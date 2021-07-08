@extends('layouts.job-crud', [
	'routeName' => 'jobs.store',
	'method' => 'POST', 
	'staff' => $staff,
	'jobs' => $jobs,
	'projects' => $projects,
	'jobTypes' => $jobTypes,
	'priorities' => $priorities,
	'processMethods' => $processMethods,

])


@section('message')
	@if (session('success'))
		@include('components.flash-message-modal', [
			'modalId' => 'successModal',
			'alertClass' => 'alert alert-sucess',
			'message' => session('success')
		])
	@elseif ($errors->has('job_id')) 
		@include('components.flash-message-modal', [
			'modalId' => 'errorModal',
			'alertClass' => 'alert alert-danger',
			'message' => $errors->first('job_id')
		])
	@endif
@endsection


@section('job-info')
	<div class="form-group-row mb-3">

		@include('components.searchable-input-text', [
			'name' => 'assigner_name',
			'label' => 'Người giao việc', 
			'options' => $staff
		])
		<i class="fas fa-asterisk" style="width: .5em; color:red"></i>
		<input type="hidden" name="assigner_id" id="assigner_id" value="{{ old('assigner_id') }}">


		@error('assigner_id')
			<span class="alert alert-danger ml-3 p-1 errors">{{$errors->first('assigner_id')}}</span>
		@enderror
		

	
	</div>

	<div class="form-group-row mb-3">

		@include('components.searchable-input-text', [
				'name' => 'project_code',
				'label' => 'Mã dự án', 
				'options' => $projects, 
				'displayField' => 'code',
				'hiddenField' => 'name'
			])

			@include('components.input-text', [
				'name' => 'project_name',
				'label' => '(Tên dự án)',
				'readonly' => true,
			])
		<input type="hidden" name="project_id" id="project_id" value="{{ old('project_id') }}">
		

		
	</div>

	


	<div class="form-group-row mb-3">


		@include('components.searchable-input-text', [
			'name' => 'job_type',
			'label' => 'Loại công việc', 
			'options' => $jobTypes, 
		])
		<input type="hidden" name="job_type_id" id="job_type_id" value="{{ old('job_type_id') }}">

	
		
	</div>
	<div class="form-group-row mb-3">

		@include('components.input-number', [
			'name' => 'period',
			'label' => 'Kỳ',
		])
		@include('components.select', [
			'name' => 'period_unit', 
			'label' => 'Đơn vị',
			'options' => [
				['value' => 'day', 'display' => 'Ngày'],
				['value' => 'week', 'display' => 'Tuần'],
				['value' => 'term', 'display' => 'Kỳ'],    
			]
		])

	
	</div>
	<div class="form-group-row mb-3">

		@include('components.searchable-input-text', [
			'name' => 'parent_job',
			'label' => 'Việc cha', 
			'options' => $jobs, 
		])
		<input type="hidden" name="parent_id" id="parent_id" value="{{ old('parent_id') }}">

	
	</div>
	<div class="form-group-row mb-3">
	
		@include('components.input-text', [
			'name' => 'code',
			'label' => 'Mã CV'
		])
		@include('components.searchable-input-text', [
			'name' => 'priority_name',
			'label' => 'Độ ưu tiên', 
			'options' => $priorities, 
		])
		<input type="hidden" name="priority_id" id="priority_id" value="{{ old('priority_id') }}">

	</div>
	<div class="form-group-row mb-3">

		@include('components.input-text', [
			'name' => 'name', 
			'label' => 'Tên công việc',
		])
		<i class="fas fa-asterisk" style="width: .5em; color:red"></i>
		
		@error('name')
		<span class="alert alert-danger ml-3 p-1 errors">{{$errors->first('name')}}</span>
		@enderror
	
	</div>

	<div class="form-group-row mb-3">

		@include('components.input-number', [
			'name' => 'lsx_amount', 
			'label' => 'Khối lượng LSX',
		])
		<label>(Man day)</label>


	</div>
	<div class="form-group-row mb-3">


		@include('components.input-number', [
			'name' => 'assign_amount', 
			'label' => 'Khối lượng giao'
		])
		<label>(Man day)</label>
	</div>
	<div class="form-group-row mb-3">
		@include('components.input-date', [
			'type' => 'date',
			'name' => 'deadline', 
			'label' => 'Hạn xử lý',
		])
		<i class="fas fa-asterisk" style="width: .5em; color:red"></i>
		@error('deadline')
			<span class="alert alert-danger ml-3 p-1 errors">{{$errors->first('deadline')}}</span>
		@enderror
	</div>

	<div class="form-group-row mb-3">
		@include('components.text-area', [
			'name' => 'description',
			'label' => 'Mô tả CV',
		])
	
	</div>
	<div class="form-group-row mb-3">
		@include('components.input-file', [
			'name' => 'job_files[]',
			'label' => 'Tệp nội dung',
		])
	</div>
@endsection


@section('assignee-info')
	<div class="form-group-row mb-3 offset-10">
		<button class="btn btn-info">Rút gọn</button>
	</div>

	<div id="short-list">
		<div class="form-group-row mb-3">
			@include('components.searchable-input-text', [
				'name' => 'chu-tri',
				'label' => 'Chủ trì', 
				'options' => $staff, 
			])
			<input type="hidden" name="chu-tri-id" id="chu-tri-id">
		</div>
		<div class="form-group-row mb-3">
			@include('components.multiple-search-input', [
				'name' => 'phoi-hop[]', 
				'label' => 'Phối hợp', 
				'options' => $staff
			])
		</div>
		<div class="form-group-row mb-3">
			@include('components.searchable-input-text', [
				'name' => 'nhan-xet',
				'label' => 'Theo dõi, nhận xét', 
				'options' => $staff, 
			])
			<input type="hidden" name="nhan-xet-id" id="nhan-xet-id">
		</div>
	</div>
@endsection

@section('assign-button-group')
	{{-- TODO: Thêm 2 link xem chi tiết + bô sung --}}
	
@endsection



@section('button-group')

	@include('components.button-group', [
		'parentClass' => 'btn-group offset-2',
		'buttons' => [
			['iconClass' => 'fas fa-save', 'value' => 'Lưu', 'action' => 'save'], 
			['iconClass' => 'fas fa-copy', 'value' => 'Lưu-sao', 'action' => 'save_copy'], 
			['iconClass' => 'fas fa-edit', 'type' => 'button', 'value' => 'Sửa', 'action' => 'edit'], 
			['iconClass' => 'fas fa-trash', 'value' => 'Xóa', 'action' => 'delete'], 
			['iconClass' => 'fas fa-search', 'value' => 'Tìm kiếm', 'action' => 'search'],
			['iconClass' => 'fas fa-redo', 'type' => 'button', 'value' => 'Tạo mới', 'action' => 'reset'], 
		] 
	])


	
@endsection


@section('custom-script')
	<script>
		$(document).ready(function() {

			$('button[value="reset"]').click(function () {
				$('.selectpicker').each(function () {
					$(this).val('');
					$(this).selectpicker('refresh')
				})
				$('input').each(function () {
					if ($(this).attr('name') === 'status') {
						$(this).val('Chưa nhận');
					}
					else {
						$(this).val('');
					}
				})
				$('#period_unit').prop('selectedIndex', -1);
				$('textarea').val('');
				$('#history-workplan').hide();
				$('#note-wrapper').hide();
			});

			$('button[value="edit"]').click(function () {
				const jobId = $('#job_id').val();
				if (jobId !== '') {
					$('#note').val('');
					$('#note-wrapper').show();
				}
			})
		});

	</script>
@endsection
