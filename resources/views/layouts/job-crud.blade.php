@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        
            <div class="col-md-9">
                <form action="{{route($routeName, $params ?? [])}}" method="{{$method}}">
                    @csrf
                    
                    {{-- <input type="hidden" name="assigner_id">
                    <input type="hidden" name="assignee[staff_id][]">
                    <input type="hidden" name="assignee[process_method_id][]"> --}}

                    <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                        <legend class="w-auto">Thông tin nghiệp vụ</legend>
                        <div class="form-group-row mb-3">
                            @include('components.select', [
                                'name' => 'assigner',
                                'label' => 'Người giao việc',
                                'options' => ['ABAC', 'ASCS'],	
                            ])
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'project_code',
                                'label' => 'Mã dự án'	
                            ])
                        </div>
    
                        <div class="form-group-row mb-3">
                            @include('components.select', [
                                'name' => 'job_type', 
                                'label' => 'Loại công việc', 
                                'options' => ['Dự án', 'Training']
                            ])
                            
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
                            {{-- <label for="description" class="col-sm-2 col-form-label">Mô tả CV</label>
                            <textarea name="description" id="description"></textarea> --}}
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-file', [
                                'name' => 'file',
                                'label' => 'Tệp nội dung',
                            ])
                            {{-- <label for="file" class="col-sm-2 col-form-label">Tệp nội dung</label>
                            <input type="file" name="file" id="file" class="form-control-file d-inline"> --}}
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