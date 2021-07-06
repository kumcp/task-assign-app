@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
    <div class="container">
        <div class="row">
            <input type="hidden" name="job_id" id="job_id">
            <div class="col-md-9">
               
                <form action="{{route($routeName, $params ?? [])}}" method="{{$method}}">
                    @csrf

                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Thông tin nghiệp vụ</legend>
                        <div class="form-group-row mb-3">
                            @include('components.searchable-input-text', [
                                'name' => 'assigner_name',
                                'label' => 'Người giao việc', 
                                'listId' => 'assigner_list',
                                'list' => $staff
                            ])
                            <input type="hidden" name="assigner_id" id="assigner_id">
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.searchable-input-text', [
                                'name' => 'project_code',
                                'label' => 'Mã dự án', 
                                'listId' => 'project_code_list',
                                'list' => $projects, 
                                'displayField' => 'code',
                            ])

                            @include('components.input-text', [
                                'name' => 'project_name',
                                'label' => '(Tên dự án)',
                                'readonly' => true	
                            ])
                            <input type="hidden" name="project_id" id="project_id">
                        </div>

                         

        
                        <div class="form-group-row mb-3">
                            @include('components.searchable-input-text', [
                                'name' => 'job_type',
                                'label' => 'Loại công việc', 
                                'listId' => 'job_type_list',
                                'list' => $jobTypes, 
                            ])
                            <input type="hidden" name="job_type_id" id="job_type_id">
                            
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'period',
                                'label' => 'Kỳ'
                            ])
                            @include('components.select', [
                                'name' => 'period_unit', 
                                'label' => 'Đơn vị',
                                'options' => [
                                    ['value' => 'day', 'display' => 'Ngày'],
                                    ['value' => 'week', 'display' => 'Ngày'],
                                    ['value' => 'term', 'display' => 'Kỳ'],    
                                ]
                            ])
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.searchable-input-text', [
                                'name' => 'parent_job',
                                'label' => 'Việc cha', 
                                'listId' => 'parent_job_list',
                                'list' => $jobs, 
                            ])
                            <input type="hidden" name="parent_id" id="parent_id">
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'code',
                                'label' => 'Mã CV'
                            ])
                            @include('components.searchable-input-text', [
                                'name' => 'priority_name',
                                'label' => 'Độ ưu tiên', 
                                'listId' => 'priorities',
                                'list' => $priorities, 
                            ])
                            <input type="hidden" name="priority_id" id="priority_id">
    
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'name', 
                                'label' => 'Tên công việc'
                            ])
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'lsx_amount', 
                                'label' => 'Khối lượng LSX'
                            ])
                            <label>(Man day)</label>
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
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
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.text-area', [
                                'name' => 'description',
                                'label' => 'Mô tả CV',
                            ])
                           
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-file', [
                                'name' => 'files[]',
                                'label' => 'Tệp nội dung',
                            ])
                        </div>
                    </fieldset>
					
                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Đối tượng xử lý</legend>


                        <div class="form-group-row mb-3 offset-10">
                            <button class="btn btn-info">Rút gọn</button>
                        </div>

                        <div id="short-list">
                            <div class="form-group-row mb-3">
                                @include('components.searchable-input-text', [
                                    'name' => 'chu-tri',
                                    'label' => 'Chủ trì', 
                                    'listId' => 'chu-tri-list',
                                    'list' => $staff, 
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
                                    'listId' => 'nhan-xet-list',
                                    'list' => $staff, 
                                ])
                                <input type="hidden" name="nhan-xet-id" id="nhan-xet-id">
                            </div>
                        </div>

                        <div id="detail" class="d-none">
                            
                        </div>
                        
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
                    
                    @yield('button-group')
                </form>
            </div>
            <div class="col">
                @include('components.dynamic-table', [
                    'cols' => [
                        'Tên công việc' => 'name',
                    ],
                    'rows' => $jobs,
                    'min_row' => 5,
                    
                ])
            </div>

        </div>
        
                
    </div>

    <script type="text/javascript">
        const handleOptionChange = (name, hiddenInputId) => {
            document.querySelector('#' + name).addEventListener('input', function (e) {
                let input = e.target;
                let list = input.getAttribute('list');
                let options = document.querySelectorAll('#' + list + ' option');
                let hiddenInput = document.getElementById(hiddenInputId);
                let inputValue = input.value;
                let matched = false;
                for(let i = 0; i < options.length; i++) {
                    let option = options[i];
                    if (option.innerHTML === inputValue) {
                        hiddenInput.value = option.getAttribute('data-value');
                        matched = true;
                        break;
                    }
                }
                
                if (!matched) {
                    hiddenInput.value = null;
                }
            });
        }

        const getJob = (id, options) => {
            return fetch(`/api/jobs/${id}`, {
                method: "GET",
                ...options
            }).then(response => response.json());
        } 

        const setValue = (selector, value) => {
            document.querySelector(selector).value = value;
        }

        datalistInputs = [
            {name: 'assigner_name', hiddenInputId: 'assigner_id'},
            {name: 'project_code', hiddenInputId: 'project_id'},
            {name: 'job_type', hiddenInputId: 'job_type_id'},
            {name: 'parent_job', hiddenInputId: 'parent_id'},
            {name: 'priority_name', hiddenInputId: 'priority_id'},
        ];

        datalistInputs.forEach(element => {
            handleOptionChange(element.name, element.hiddenInputId);
        });

        document.querySelectorAll('tr').forEach(function (element) {
            
            if (element.id !== '') {
                const id = element.id;                
                element.addEventListener('click', function (e) {
                    
                    document.getElementById('job_id').value = id;
                    getJob(id).then(job => {
                        console.log(job);
                        Object.keys(job).forEach(key => {
                            let input = document.querySelector(`#${key}`);
                            if (input !== null) {
                                input.value = job[key];
                            }
                            
                        })

                        setValue('#assigner_name', job.assigner.name);

                        setValue('#project_code', job.project ? job.project.code : '');
                        setValue('#project_name', job.project ? job.project.name : '');

                        setValue('#job_type', job.type ? job.type.name : '');
                        
                        setValue('#parent_job', job.parent ? job.parent.name : '');
                        
                        setValue('#priority_name', job.priority ? job.priority.name : '');

                                          
                    })
                })
            }
            
        });

        
    </script>

    
@endsection


