@extends('layouts.app')

@section('content')
    <div class="container">

		@error('jobs')
			@include('components.flash-message-modal', [
				'modalId' => 'errorModal',
				'alertClass' => 'alert alert-danger',
				'message' => $errors->first('jobs')
			])
		@enderror

		


        <div class="row mb-4 ml-0">
            <form action="{{ route('jobs.search')}}" method="POST" class="w-100">
                @csrf

				



				<div class="form-group-row mb-3">
                    @include('components.select', [
						'name' => 'job_type_id',
						'label' => 'Loại công việc',
						'options' => $jobTypes ?? []
					])
					@include('components.select', [
						'name' => 'project_id',
						'label' => 'Dự án',
						'options' => $projects ?? []
					])

                </div>

				@isset($all)
					<div class="form-group-row mb-3">
						@include('components.select', [
							'name' => 'status',
							'label' => 'Trạng thái',
							'options' => []
						])
						@include('components.select', [
							'name' => 'assessment',
							'label' => 'Đánh giá',
							'options' => []
						])

					</div>
				@endisset


                <div class="form-group-row mb-3">
                    @include('components.select', [
						'name' => 'assigner_id',
						'label' => 'Người giao',
						'options' => $assigners ?? []
					])

					@include('components.input-text', [
						'name' => 'name',
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
					<button type="button" id="reset-btn" class="btn btn-light">
						<i class="fas fa-redo"></i>
					</button>

				</div>

			</form>

			<form action="{{ route('jobs.detailAction')}}" method="POST" class="w-100">
				@csrf

				<input type="hidden" name="type" value="{{ $type ?? 'all' }}">

				
				@isset($all)
			
					@yield('table')

				@else

					<div class="row ml-0 mb-5">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
							<a class="nav-link active" id="left-tab" data-toggle="tab" href="#left" role="tab" aria-controls="left" aria-selected="true">{{ $left_title }}</a>
							</li>
							<li class="nav-item" role="presentation">
							<a class="nav-link" id="right-tab" data-toggle="tab" href="#right" role="tab" aria-controls="right" aria-selected="false">{{ $right_title }}</a>
							</li>
						</ul>
						<div class="tab-content w-100" id="myTabContent">
							<div class="tab-pane fade show active w-100" id="left" role="tabpanel" aria-labelledby="left-tab">

								@yield('left-tab-table')
								
							</div>
							<div class="tab-pane" id="right" role="tabpanel" aria-labelledby="right-tab">

								@yield('right-tab-table')
								
							</div>
						</div>
					</div>

				@endisset
				

				@yield('button-group')

				@include('components.button-group', [
					'parentClass' => 'btn-group offset-1',
					'buttons' => [
						['iconClass' => 'fas fa-info-circle', 'value' => 'Xem chi tiết', 'action' => 'detail'], 
						['iconClass' => 'fas fa-check', 'value' => 'Hoàn thành', 'action' => 'finish'], 
						['iconClass' => 'fas fa-search', 'value' => 'Tìm kiếm', 'action' => 'search'], 
						['iconClass' => 'fas fa-user-plus', 'value' => 'Giao xử lý', 'action' => 'assign'], 
						['iconClass' => 'fas fa-clipboard-list', 'value' => 'Timesheet', 'action' => 'timesheet'],
						['iconClass' => 'fas fa-plus', 'value' => 'Tạo việc', 'action' => 'job_create'], 
						['iconClass' => 'fas fa-tasks', 'value' => 'Xác nhận SL', 'action' => 'amount_confirm'], 
						['iconClass' => 'fas fa-comments', 'value' => 'Trao đổi', 'action' => 'exchange'] 
					] 
				])


            </form>
        </div>
    </div>   

	<script>
		$(document).ready(function () {
			const handleReset = () => {
				$('select').prop('selectedIndex', -1);
				$('.form-group-row input').each(function() {
					$(this).val(null);
				});
			}

			const initializeSelectInput = () => {
				$('select').prop('selectedIndex', -1);
			}

			initializeSelectInput();
			
			$('th input:checkbox').prop('disabled', true);
			
			$('input:checkbox').each(function() {
				$(this).prop('checked', false);
			});

			$('#reset-btn').click(function() {
				handleReset();
			});


			$('button[value="detail"]').prop('disabled', true);


			$('#left-table thead th input:checkbox').change(function() {
				$('#left-table input:checkbox').not(this).prop('checked', this.checked).change();
			});

			$('#right-table thead th input:checkbox').change(function() {
				$('#right-table input:checkbox').not(this).prop('checked', this.checked).change();
			});

			$('#left tbody input:checkbox').change(function() {
				if (this.checked) {
					const jobId = $(this).closest('tr').attr('id');
					$(this).val(jobId);

					const processMethod = $(this).closest('tr').find('td.process_method').text();

					$('button[value="detail"]').prop('disabled', false);

					
					$('tr.data-row').each(function() {
						if ($(this).find('td.process_method').text() !== processMethod) {
							$(this).find('input:checkbox').prop('disabled', true);
						}
					});

				}
				else {
					$('#left thead input:checkbox').prop('checked', false);
					$(this).removeAttr('value');

					if ($('input:checkbox:checked').length === 0) {
						$('tr.data-row input:checkbox').prop('disabled', false);
					}

					if ($('#left tbody input:checkbox:checked').length === 0) {
						$('button[value="detail"]').prop('disabled', true);
					}
				}
			});

			$('#right tbody input:checkbox').change(function() {
				if (this.checked) {
					const jobId = $(this).closest('tr').attr('id');
					$(this).val(jobId);

					const processMethod = $(this).closest('tr').find('td.process_method').text();


					$('tr.data-row').each(function() {
						if ($(this).find('td.process_method').text() !== processMethod) {
							$(this).find('input:checkbox').prop('disabled', true);
						}
					});

					$('button[value="detail"]').prop('disabled', false);
						
				}
				else {
					$('#right thead input:checkbox').prop('checked', false);
					$(this).removeAttr('value');

					if ($('input:checkbox:checked').length === 0) {
						$('tr.data-row input:checkbox').prop('disabled', false);
					}

					if ($('#right tbody input:checkbox:checked').length === 0) {
						$('button[value="detail"]').prop('disabled', true);
					}
				}
			});


			const setCloseTimeout = (modalSelector, timeout) => {
				$(modalSelector).modal("show").on("shown.bs.modal", function () {
					window.setTimeout(function () {
						$(modalSelector).modal("hide");
					}, timeout);
				});
 		    }

        	setCloseTimeout("#errorModal", 5000);
		})
	</script>

	@yield('custom-script')

		
    </div>   



@endsection