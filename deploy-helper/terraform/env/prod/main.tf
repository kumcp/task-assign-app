terraform {
  required_version = ">= 0.12.6"

  required_providers {
    aws = ">= 2.0"
  }
}

locals {
  name        = "test_ecs"
  environment = "stag"
  common_tags = {
    Project = "demo"
    Env     = local.environment
  }
}

module "ecs_cluster" {
  source = "../../module/ecs_cluster"

  name               = local.name
  capacity_providers = ["FARGATE", "FARGATE_SPOT"]

  default_capacity_provider_strategy = [{
    capacity_provider = "FARGATE"
    weight            = 1
    base              = 0
  }]

  tags = {
    Environment = local.environment
  }
}


resource "aws_ecs_task_definition" "task_def" {
  family                = "service"
  container_definitions = file("../../../task_def/nginx-php-revision2.json")

  cpu                      = 256
  memory                   = 512
  requires_compatibilities = ["FARGATE"]
  network_mode             = "awsvpc"

  execution_role_arn = module.ecs_cluster.taskExecRoleArn
  # task_role_arn      = module.ecs_cluster.taskExecRoleArn
}

module "common_sg" {
  source = "../../module/common_sg"

  vpc_id = module.vpc.vpc_id
}


module "vpc" {
  source = "terraform-aws-modules/vpc/aws"

  name = "my-vpc"
  cidr = "10.0.0.0/16"

  azs             = ["ap-southeast-1a", "ap-southeast-1b"]
  private_subnets = ["10.0.1.0/24", "10.0.2.0/24"]
  public_subnets  = ["10.0.3.0/24", "10.0.4.0/24"]

  #   enable_nat_gateway = true
  #   enable_vpn_gateway = true

  tags = local.common_tags

}

data "aws_security_group" "default_sg" {
  vpc_id = module.vpc.vpc_id

  filter {
    name   = "group-name"
    values = ["default"]
  }
}

resource "aws_ecs_service" "service" {
  name            = "main_service"
  cluster         = module.ecs_cluster.id
  task_definition = aws_ecs_task_definition.task_def.arn
  desired_count   = 1

  network_configuration {
    subnets          = module.vpc.public_subnets
    security_groups  = [module.common_sg.allow_http.id, data.aws_security_group.default_sg.id]
    assign_public_ip = true
  }

  load_balancer {
    target_group_arn = module.alb.target_group_arns[0]
    container_name   = "nginx"
    container_port   = 80
  }
}


module "alb" {
  source  = "terraform-aws-modules/alb/aws"
  version = "~> 6.0"

  name = "alb"

  load_balancer_type = "application"

  vpc_id          = module.vpc.vpc_id
  subnets         = module.vpc.public_subnets
  security_groups = [module.common_sg.allow_http.id, data.aws_security_group.default_sg.id]

  target_groups = [
    {
      name             = "do2806-tg1"
      backend_protocol = "HTTP"
      backend_port     = 80
      target_type      = "ip"

      health_check = {
        matcher = "301"
      }
    }
  ]

  http_tcp_listeners = [
    {
      port               = 80
      protocol           = "HTTP"
      target_group_index = 0
    }
  ]

  tags = {
    Environment = "test"
  }
}
