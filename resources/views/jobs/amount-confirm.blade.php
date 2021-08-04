@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <form action="#" class="w-100">
                    <div class="form-group-row mb-3">
                        @include('components.input-date', [
                            'type' => 'month',
                            'name' => 'month', 
                            'label' => 'Tháng',
                        ])
                    </div>
    
                    <div class="form-group-row mb-3">
                        @include('components.select', [
                            'name' => 'assignee',
                            'label' => 'Người xử lý',
                            'options' => ['Hoàng Quân', 'Quân', 'ABC', 'XYZ']
                        ])
                    </div>
    
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'assign_amount', 
                            'label' => 'KL giao',
                        ])
                    </div>
    
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'old_confirm_amount', 
                            'label' => 'KL cũ đã xác nhận',
                        ])
                        @include('components.input-number', [
                            'name' => 'old_confirm_percentage', 
                            'label' => '% đã xác nhận',
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'request_amount', 
                            'label' => 'KL đề nghị',
                        ])
                        @include('components.input-number', [
                            'name' => 'request_percentage', 
                            'label' => '% đề nghị',
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'confirm_amount', 
                            'label' => 'KL CV',
                        ])
                        @include('components.input-number', [
                            'name' => 'confirm_percentage', 
                            'label' => '% hoàn thành',
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.select', [
                            'name' => 'quality',
                            'label' => 'Chất lượng',
                            'options' => ['Tốt', 'Trung bình', 'Kém'],
                        ])
  
                    </div>
  
                    <div class="form-group-row mb-5">
                        @include('components.text-area', [
                            'name' => 'note',
                            'label' => 'Nhận xét',
                        ])

                    </div>

                    @include('components.button-group', [
                        'buttons' => [
                            ['iconClass' => 'fas fa-save', 'value' => 'Lưu', 'action' => 'save'], 
                            ['iconClass' => 'fas fa-trash', 'value' => 'Xóa', 'action' => 'delete'], 
                            ['iconClass' => 'fas fa-clipboard-list', 'value' => 'Timesheet', 'action' => 'timesheet'], 
                        ] 
                    ])
                </form>
                
            </div>

            <div class="col-md-3">
                {{-- TODO: table filling --}}
            </div>
        </div>
    </div>
    
@endsection