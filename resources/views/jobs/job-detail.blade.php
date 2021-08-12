@extends('layouts.job-crud', [
	'routeName' => 'job-assigns.updateStatus',
	'method' => 'POST', 
	'jobId' => $jobId ?? null,
	'editable' => false 
])


@section('message')
	@isset($success)
		
		@include('components.flash-message-modal', [
			'modalId' => 'successModal',
			'alertClass' => 'alert alert-sucess',
			'message' => $success
		])
	
	@endisset
		
@endsection


@section('job-info')
	<div class="form-group-row mb-3">

		@include('components.input-text', [
			'name' => 'assigner_name',
			'label' => 'Người giao việc', 
			'readonly' => true
		])
		
	
	</div>

	<div class="form-group-row mb-3">

		@include('components.input-text', [
				'name' => 'project_code',
				'label' => 'Mã dự án', 
				'readonly' => true
		])

		@include('components.input-text', [
			'name' => 'project_name',
			'label' => '(Tên dự án)',
			'readonly' => true,
		])
		
	</div>

	


	<div class="form-group-row mb-3">


		@include('components.input-text', [
			'name' => 'job_type',
			'label' => 'Loại công việc', 
			'readonly' => true
		])
	
		
	</div>
	<div class="form-group-row mb-3">

		@include('components.input-text', [
			'name' => 'period',
			'label' => 'Kỳ',
            'readonly' => true
		])
		@include('components.input-text', [
			'name' => 'period_unit', 
			'label' => 'Đơn vị',
			'readonly' => true
		])

	
	</div>
	<div class="form-group-row mb-3">

		@include('components.input-text', [
			'name' => 'parent_job',
			'label' => 'Việc cha', 
			'readonly' => true
		])
		
	
	</div>
	<div class="form-group-row mb-3">
	
		@include('components.input-text', [
			'name' => 'code',
			'label' => 'Mã CV',
            'readonly' => true
		])
		@include('components.input-text', [
			'name' => 'priority_name',
			'label' => 'Độ ưu tiên', 
			'readonly' => true 
		])
		
	</div>
	<div class="form-group-row mb-3">

		@include('components.input-text', [
			'name' => 'name', 
			'label' => 'Tên công việc',
            'readonly' => true
		])
	
	
	</div>

	<div class="form-group-row mb-3">

		@include('components.input-text', [
			'name' => 'lsx_amount', 
			'label' => 'Khối lượng LSX',
            'readonly' => true
		])
		<label>(Man day)</label>


	</div>
	<div class="form-group-row mb-3">


		@include('components.input-text', [
			'name' => 'assign_amount', 
			'label' => 'Khối lượng giao',
            'readonly' => true
		])
		<label>(Man day)</label>
	</div>
	<div class="form-group-row mb-3">
		@include('components.input-text', [
			'name' => 'deadline', 
			'label' => 'Hạn xử lý',
			'readonly' => true
		])
	
	</div>

	<div class="form-group-row mb-3">
		@include('components.text-area', [
			'name' => 'description',
			'label' => 'Mô tả CV',
            'readonly' => true
		])
	
	</div>
	<div class="form-group-row mb-3">

		<label for="file-count" class="col-sm-2 col-form-label p-0">Tệp nội dung</label>
		<div class="col-sm-4 d-inline">
			<button type="button" class="btn btn-light" id="file-count">
				<i class="fas fa-file"></i>
				<sup><span class="badge badge-success"></span></sup>
			</button>
		</div>
		
	</div>
@endsection




@section('assign-button-group')

	<div class="text-center">
		@include('components.button-group', [
			'parentClass' => 'btn-group',
			'buttons' => [
				['type' => 'button', 'iconClass' => 'fas fa-info-circle', 'value' => 'Xem chi tiết', 'action' => 'assignee-detail'], 
			] 
		])
	</div>
	
@endsection



@section('deny-reason-modal')
	
	<div class="modal fade" id="deny-reason-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Lý do từ chối</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group-row mb-3">
					@include('components.text-area', [
						'name' => 'deny_reason',
						'label' => 'Lý do từ chối',
					])
				</div>

				<button class="btn btn-primary offset-5" type="submit" name="action" value="reject">Ghi lại</button>
			</div>

		</div>
		</div>
	</div>

@endsection


@section('button-group')

	@include('components.button-group', [
		'parentClass' => 'btn-group offset-2',
		'buttons' => [
			['iconClass' => 'fas fa-check', 'value' => 'Nhận việc', 'action' => 'accept'], 
			['type' => 'button', 'id' => 'reject-btn', 'iconClass' => 'fas fa-times', 'value' => 'Từ chối'], 
			['iconClass' => 'fas fa-comment', 'value' => 'Trao đổi', 'action' => 'exchange'], 
		] 
	])


	
@endsection


@section('custom-script')
	<script>
		$(document).ready(function() {

            $('#reject-btn').click(function() {
				$('#deny-reason-modal').modal('show');
			});

			$('#history-workplan').show();


			$('#file-count').click(function() {

				$('#file-modal').modal('show');

			});

		});



	</script>
@endsection
