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
                        
                        {{-- <div class="form-group-row mb-3">

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
                        </div> --}}
                    </fieldset>
					
                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Đối tượng xử lý</legend>

                        @yield('assignee-info')


                        {{-- <div class="form-group-row mb-3 offset-10">
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
                        </div> --}}

                        
                        
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
                    'rows' => $jobs,
                    'min_row' => 5,
                    'pagination' => true
                ])
                <div id="history-workplan" style="display: none">
                    <a href="" class="btn btn-link p-0 mb-1 text-decoration-none" data-toggle="modal" data-target="#update-job-histories">Lịch sử công việc</a>
                    <a href="" class="btn btn-link p-0 text-decoration-none" data-toggle="modal" data-target="#workplan">Kế hoạch thực hiện</a>
                    

                    
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


                    <!-- Workplan modal -->
                    <div class="modal fade" id="workplan" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Kế hoạch thực hiện</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- TODO: workplan table --}}
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


