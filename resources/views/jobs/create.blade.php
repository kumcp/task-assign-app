@extends('layouts.job-crud', [
	'routeName' => 'jobs.action',
	'method' => 'POST', 
	'staff' => $staff,
	'jobs' => $jobs,
	'projects' => $projects,
	'jobTypes' => $jobTypes,
	'priorities' => $priorities,
	'processMethods' => $processMethods,
	'editable' => true

])


@section('modal')
	@include('components.assignee-modal', ['staff' => $staff])
@endsection


@section('message')
	@if (session('success'))
		@include('components.flash-message-modal', [
			'modalId' => 'successModal',
			'alertClass' => 'alert alert-sucess',
			'message' => session('success')
		])
	@endif

	@if (session('error')) 
		@include('components.flash-message-modal', [
			'modalId' => 'errorModal',
			'alertClass' => 'alert alert-danger',
			'message' => session('error')
		])
	@endif
@endsection


@section('job-info')
	<div class="form-group-row mb-3">



		<input type="hidden" name="authenticated_name" id="authenticated_name" value="{{ Auth::user()->staff->name }}">
		<input type="hidden" name="authenticated_id" id="authenticated_id" value="{{ Auth::user()->staff_id }}">



		@include('components.input-text', [
			'name' => 'assigner_name',
			'label' => 'Người giao việc',
			'value' => Auth::user()->staff->name,
			'readonly' => true
		])
		
		<input type="hidden" name="assigner_id" id="assigner_id" value="{{ Auth::user()->staff_id }}">

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
		
	</div>

	<div class="form-group-row mb-3">
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

		<button type="button" class="btn btn-light" id="file-count">
			<i class="fas fa-file"></i>
			<sup><span class="badge badge-success"></span></sup>
		</button>
	</div>
	<label class="mt-3"> (Kích thước tệp không vượt quá 10mb) </label>

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
					else if ($(this).attr('name') !== 'authenticated_name' && $(this).attr('name') !== 'authenticated_id') {
						$(this).val('');
					}
		
				})

				$('#assigner_name').val($('#authenticated_name').val());
				$('#assigner_id').val($('#authenticated_id').val());

				$('#period_unit').prop('selectedIndex', -1);
				$('textarea').val('');
				$('#history-workplan').hide();
				$('#note-wrapper').hide();

				resetTable('files');
				$('#file-count span').html(null);
				$('#file-count').hide();

				resetHiddenInputs();
				resetFullAssigneeTable('full-assignee-table');
				resetAssigneeDisplayValues();
			});

			$('button[value="edit"]').click(function () {
				const jobId = $('#job_id').val();
				if (jobId !== '') {
					$('#note').val('');
					$('#note-wrapper').show();
				}
			});




			$('input:file').change(function(e) {

				const files = e.target.files;
				
				if (files.length > 0) {
					let cnt = 0;
					

					resetTable('files');

					for (let i = 0; i < files.length; i++) {
						const file = files[i];
						const fileSize = ((file.size / 1024) / 1024).toFixed(4); // MB
						
						if (fileSize <= 10) {
							const newLink = $('<a/>', {
								href: URL.createObjectURL(file),
								text: file.name,
								target: '_blank'
            				});
							addRowToTable('files', i, newLink);
							cnt++;
						}

					}

					if (cnt > 0) {

						$('#file-count span').html(cnt);
						$('#file-count').show();
					}

					
				}
				else {
					$('#file-count').hide();
				}
			});

			$('#file-count').hide();

			$('#file-count').click(function() {

				$('#file-modal').modal('show');
				
			});
			
			

			$('#chu-tri-btn').click(function() {
				$('#process_method').val('chu-tri');

				$('#assignee-modal .modal-title').html('Chủ trì');
			});

			$('#phoi-hop-btn').click(function() {
				$('#process_method').val('phoi-hop');

				$('#assignee-modal .modal-title').html('Phối hợp');
			});

			$('#nhan-xet-btn').click(function() {
				$('#process_method').val('nhan-xet');

				$('#assignee-modal .modal-title').html('Theo dõi/Nhận xét');
			});


			$('#assignee-modal').on('show.bs.modal', function() {
				const processMethod = $('#process_method').val();
				tickAssigneeTable(processMethod);
			});


			$('#assignee-modal').on('shown.bs.modal', function() {


				$('#search-reset-btn').click(function() {
					$('#id').val(null).keyup();
					$('#name').val(null).keyup();
				});

				$('#id').keyup(function() {
					const assigneeId = $('#id').val();
					const assigneeName = $('#name').val();
					search('assignee-list', assigneeId, assigneeName);
				});

				$('#name').keyup(function() {
					const assigneeId = $('#id').val();
					const assigneeName = $('#name').val();
					search('assignee-list', assigneeId, assigneeName);
				});
			});



			$('#assignee-modal').on('hidden.bs.modal', function() {
				untickAssigneeTable();
				displayAssigneeList('assignee-list');
			});


			$('#assignee-list tr.data-row').click(function() {
	
	
				const id = $(this).attr('id');
				const processMethod = $('#process_method').val();

				const assignee = $(this).find('td[class="name"]').html();
				

				toggleTickElement(id, processMethod, assignee);


				
			});


			$('#full-assignee-table').on('change', 'input.direct-report', function() {

				const idElement = $(this).closest('tr').find('.id');
				const id = idElement.text();

				const processMethod = idElement.siblings('.process_method').text();
				

				let hiddenInput = null;
				let value = null;


				switch (processMethod) {

					case 'Chủ trì':
						hiddenInput = $(`input[name="chu-tri[]"][id="${id}"]`);

						value = JSON.parse(hiddenInput.val());

						hiddenInput.val(JSON.stringify({
							...value,
							direct_report: this.checked
						}));
						
						
						break;

					case 'Phối hợp':

						hiddenInput = $(`input[name="phoi-hop[]"][id="${id}"]`);
						
						value = JSON.parse(hiddenInput.val());

						hiddenInput.val(JSON.stringify({
							...value,
							direct_report: this.checked
						}));

						break;

					case 'Theo dõi/Nhận xét':
						hiddenInput = $(`input[name="nhan-xet[]"][id="${id}"]`);
						
						value = JSON.parse(hiddenInput.val());

						hiddenInput.val(JSON.stringify({
							...value,
							direct_report: this.checked
						}));
						break;
				}
				
				
			});

			$('#full-assignee-table').on('change', 'input.sms', function() {

				const idElement = $(this).closest('tr').find('.id');
				const id = idElement.text();

				const processMethod = idElement.siblings('.process_method').text();


				let hiddenInput = null;
				switch (processMethod) {

					case 'Chủ trì':
						hiddenInput = $(`input[name="chu-tri[]"][id="${id}"]`);
						
						value = JSON.parse(hiddenInput.val());

						hiddenInput.val(JSON.stringify({
							...value,
							sms: this.checked
						}));

						break;

					case 'Phối hợp':
					
						hiddenInput = $(`input[name="phoi-hop[]"][id="${id}"]`);
						
						value = JSON.parse(hiddenInput.val());

						hiddenInput.val(JSON.stringify({
							...value,
							sms: this.checked
						}));
						break;

					case 'Theo dõi/Nhận xét':
						hiddenInput = $(`input[name="nhan-xet[]"][id="${id}"]`);
						
						value = JSON.parse(hiddenInput.val());

						hiddenInput.val(JSON.stringify({
							...value,
							sms: this.checked
						}));
						break;
				}
			});











		});

	</script>
@endsection
