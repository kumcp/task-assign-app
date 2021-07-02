@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4 ml-0">
            <form action="#" class="w-100">
                <div class="form-group-row mb-3">
                    @include('components.select', [
						'name' => 'job_type',
						'label' => 'Loại công việc',
						'options' => ['Tất cả', 'Dự án', 'Training']
					])
					@include('components.select', [
						'name' => 'project',
						'label' => 'Dự án',
						'options' => ['Tất cả', 'ABC', 'CodeStar']
					])

                </div>
                <div class="form-group-row mb-3">
                    @include('components.select', [
						'name' => 'assigner',
						'label' => 'Người giao',
						'options' => ['Tất cả', 'Hoang Huy Quan']
					])

					@include('components.input-text', [
						'name' => 'job_name',
						'label' => 'Tên công việc'
					])
					
                    
                </div>
                <div class="form-group-row mb-3">
					@include('components.input-date', [
						'name' => 'from_date',
						'label' => 'Từ ngày',
						'type' => 'date',
					])
					@include('components.input-date', [
						'name' => 'to_date',
						'label' => 'Đến ngày',
						'type' => 'date',
					])
				</div>
				<div class="btn-group offset-5" role="group">
					<button type="submit" class="btn btn-light">
						<i class="fas fa-search"></i>
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-redo"></i>
					</button>

				</div>
				<div class="row ml-0 mb-5">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
						  <a class="nav-link active" id="direct-tab" data-toggle="tab" href="#direct" role="tab" aria-controls="direct" aria-selected="true">Công việc trực tiếp xử lý</a>
						</li>
						<li class="nav-item" role="presentation">
						  <a class="nav-link" id="related-tab" data-toggle="tab" href="#related" role="tab" aria-controls="related" aria-selected="false">Công việc liên quan</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="direct" role="tabpanel" aria-labelledby="direct-tab">
							<table class="table">
								<thead>
								  <tr>
									<th scope="col">Mã dự án</th>
									<th scope="col">Tên công việc</th>
									<th scope="col">Người giao</th>
									<th scope="col">Hình thức xử lý</th>
									<th scope="col">Hạn xử lý</th>
									<th scope="col">KL giao</th>
									<th scope="col">KL timesheet</th>
									<th scope="col">% hoàn thành</th>
									<th scope="col">Số ngày còn lại</th>
									<th scope="col"><input type="checkbox" name="option" id="option"></th>
								  </tr>
								</thead>
								<tbody>
								  <tr>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>@mdo</td>
								  </tr>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="related" role="tabpanel" aria-labelledby="related-tab">
							<table class="table">
								<thead>
								  <tr>
									<th scope="col">Mã dự án</th>
									<th scope="col">Tên công việc</th>
									<th scope="col">Người giao</th>
									<th scope="col">Hình thức xử lý</th>
									<th scope="col">Hạn xử lý</th>
									<th scope="col">KL giao</th>
									<th scope="col">KL timesheet</th>
									<th scope="col">% hoàn thành</th>
									<th scope="col">Số ngày còn lại</th>
									<th scope="col"><input type="checkbox" name="option" id="option"></th>
								  </tr>
								</thead>
								<tbody>
								  <tr>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>@mdo</td>
								  </tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="btn-group offset-1" role="group">
					<button type="submit" class="btn btn-light">
						<i class="fas fa-info-circle"></i>
						<span>Xem chi tiết</span> 
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-check"></i>
						<span>Hoàn thành</span>
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-search"></i>
						<span>Tìm kiếm</span>
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-tasks"></i>
						<span>Giao xử lý</span> 
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-clipboard-list"></i>
						<span>Timesheet</span> 	
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-plus"></i>
						<span>Tạo việc</span> 
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-tasks"></i>
						<span>Xác nhận SL</span>
					</button>
					<button type="submit" class="btn btn-light">
						<i class="fas fa-comments"></i>
						<span>Trao đổi</span> 
					</button>
				</div>
				
            </form>
        </div>
		

		
    </div>   
@endsection