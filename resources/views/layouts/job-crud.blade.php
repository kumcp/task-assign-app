@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        
            <div class="col-md-9">
               
                <form action="{{route($routeName, $params ?? [])}}" method="{{$method}}">
                    @csrf
                    
                

                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Thông tin nghiệp vụ</legend>
                        <div class="form-group-row mb-3">
        
                            @include('components.searchable-input-text', [
                                'name' => 'assigner',
                                'label' => 'Người giao việc', 
                                'listId' => 'assigner_list',
                                'list' => ['Quan', 'Thanh', 'Dat']
                            ])
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'project_code',
                                'label' => 'Mã dự án'	
                            ])
                            <input type="hidden" name="project_id" id="project_id">
                        </div>

                          
        
                        <div class="form-group-row mb-3">
                            @include('components.select', [
                                'name' => 'job_type', 
                                'label' => 'Loại công việc', 
                                'options' => ['Dự án', 'Training']
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
                                'options' => ['Ngày', 'Tuần', 'Tháng']
                            ])
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.select', [
                                'name' => 'parent_job', 
                                'label' => 'Việc cha', 
                                'options' => ['ABC', 'XYZ']
                            ])
                            <input type="hidden" name="parent_id" id="parent_id">
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'job_code',
                                'label' => 'Mã CV'
                            ])
                            @include('components.select', [
                                'name' => 'priorities', 
                                'label' => 'Độ ưu tiên', 
                                'options' => ['ABC', 'XYZ', 'DEF'] 
                            ])
                            <input type="hidden" name="priority_id" id="priority_id">
    
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'job_name', 
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
                                'name' => 'file',
                                'label' => 'Tệp nội dung',
                            ])
                        </div>
                    </fieldset>
					
                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Đối tượng xử lý</legend>
                        <div class="form-group-row mb-3 offset-10">
                            <button class="btn btn-info">Rút gọn</button>
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'chu-tri', 
                                'label' => 'Chủ trì'
                            ])
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'phoi-hop', 
                                'label' => 'Phối hợp'
                            ])
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'nhan-xet', 
                                'label' => 'Theo dõi, nhận xét'
                            ])
                        </div>
                        @yield('assign-button-group')
                    </fieldset>
                    
                    
					<div class="form-group-row mb-3 p-3">
						@include('components.input-text', [
							'name' => 'status', 
							'label' => 'Trạng thái'
						])
					</div>
                    
                    @yield('button-group')
                </form>
            </div>
            <div class="col">
                @include('components.table', [
                    'cols' => ['Tên công việc'], 
                    'rows' => [],
                ])
            </div>

        </div>
        
                
    </div>
    
@endsection


