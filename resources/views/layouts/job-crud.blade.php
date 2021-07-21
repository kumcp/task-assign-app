@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
    <div class="container">

        @yield('message')

        <div class="row">

            
            <div class="col-md-9">

                @yield('form')

                <form action="{{route($routeName, $params ?? [])}}" method="{{$method}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="job_id" id="job_id" value="{{ $job_id ?? old('job_id') }}">
                    
                	{{-- TODO: authenticated staff id --}}
                	<input type="hidden" name="staff_id" value="10">

                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Thông tin nghiệp vụ</legend>
                        
                        @yield('job-info')
                        
                        
                    </fieldset>
					
                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Đối tượng xử lý</legend>

                        @yield('assignee-info')

                        @yield('assign-button-group')

                    </fieldset>
                    
                    
					<div class="form-group-row mb-3 p-3">
						@include('components.input-text', [
							'name' => 'status', 
							'label' => 'Trạng thái',
                            'readonly' => true,
                            'value' => 'Chưa nhận'
						])
					</div>

                    <div class="form-group-row mb-3 p-3" id="note-wrapper" style="display:  none">
                        @include('components.text-area', [
                            'name' => 'note',
                            'label' => 'Ghi chú sửa đổi',
                        ])
					</div>

                    @yield('deny-reason-modal')
                    
                    @yield('button-group')
                </form>
            </div>
            <div class="col-md-3">
                @include('components.dynamic-table', [
                    'cols' => [
                        'Tên công việc' => 'name',
                    ],
                    'rows' => $jobs ?? [],
                    'min_row' => 5,
                    'pagination' => true
                ])
                <div id="history-workplan" style="display: none">
                    <a href=""  class="btn btn-link p-0 mb-1 text-decoration-none" data-toggle="modal" data-target="#update-job-histories">Lịch sử công việc</a>
                    
                    <a href="{{ route('workplans.create', ['job_id' => $job_id ?? '0']) }}" id="workplan" class="btn btn-link p-0 text-decoration-none">Kế hoạch thực hiện</a>
                    

                    
                    <!-- Update job histories modal -->
                    <div class="modal fade" id="update-job-histories" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Lịch sử sửa đổi công việc</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @include('components.dynamic-table', [
                                    'id' => 'update-histories-table',
                                    'cols' => [
                                        'Ngày sửa đổi' => 'created_at',
                                        'Tên trường' => 'field', 
                                        'Giá trị cũ' => 'old_value', 
                                        'Giá trị thay đổi' => 'new_value',
                                        'Ghi chú sửa đổi' => 'note',
                                    ],
                                    'rows' => [],
                              
                                ])
                            </div>

                        </div>
                        </div>
                    </div>





                </div>
            </div>

        </div>
        
                
    </div>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/job-crud/jobAPI.js') }}"></script>
    <script src="{{ asset('js/job-crud/jobFormInput.js') }}"></script>
    <script src="{{ asset('js/job-crud/jobTable.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($('#job_id').val() !== '') {
                const jobId = $('#job_id').val();
                
                let url = $('#workplan').attr('href');
                $('#workplan').prop('href', `${url.slice(0, -1)}${jobId}`);

                initializeJobValues(jobId);
            }

            selectInputs = [
                {name: 'assigner_name', hiddenInputId: 'assigner_id'},
                {name: 'project_code', hiddenInputId: 'project_id'},
                {name: 'job_type', hiddenInputId: 'job_type_id'},
                {name: 'parent_job', hiddenInputId: 'parent_id'},
                {name: 'priority_name', hiddenInputId: 'priority_id'},
                {name: 'chu-tri', hiddenInputId: 'chu-tri-id'},
                {name: 'nhan-xet', hiddenInputId: 'nhan-xet-id'},
            ];

            selectInputs.forEach(element => {
                handleOptionChange(element.name, element.hiddenInputId);
            });

            $("#period_unit").prop("selectedIndex", -1);

            $('#project_code').change(function () {
                const projectName = $(this).find(':selected').attr('data-hidden');
                $('#project_name').val(projectName);
            });
            

            $('#update-job-histories').on('show.bs.modal', function () {
                generateUpdateHistoriesTable();
            });

            $('#update-job-histories').on('hidden.bs.modal', function () {
               resetUpdateHistoriesTable();
            });

            

            document.querySelectorAll('tr').forEach(function (element) {
                if (element.id !== '') {
                    const id = element.id;                
                    element.addEventListener('click', function () {
                        handleRowClick(id);
                    });
                }
            });

        });



        const setCloseTimeout = (modalSelector, timeout) => {
            $(modalSelector).modal("show").on("shown.bs.modal", function () {
                window.setTimeout(function () {
                    $(modalSelector).modal("hide");
                }, timeout);
            });
        }

        setCloseTimeout("#successModal", 5000);
        setCloseTimeout("#errorModal", 5000);

        
    </script>

    @yield('custom-script')

    
@endsection


