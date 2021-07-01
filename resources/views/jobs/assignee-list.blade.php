@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row-mb-3 ml-0">
            @include('components.table', [
                'cols' => ['Tên công việc', 'Khối lượng công việc', 'Hạn xử lý'],
                'rows' => [['test', 40, '23/6/2021'], ['test', 40, '23/6/2021'], ['test', 40, '23/6/2021']],
                'checkbox' => 'select'
            ])
        </div>
        <div class="row ml-0">
            <div class="col-md-4 p-0">
                @include('components.checkboxes')
            </div>
            <div class="col-md-8">
                <form action="#" class="w-100">
                    <div class="form-group-row mb-3">
                        @include('components.select', [
                            'name' => 'process_method', 
                            'label' => 'Hình thức xử lý', 
                            'options' => ['Chủ trì', 'Phối hợp', 'Nhận xét']
                        ])
                    </div>
                    <div class="form-group-row">
                        @include('components.table', [
                            'cols' => ['Tên công việc', 'Khối lượng công việc', 'Hạn xử lý'],
                            'checkbox' => 'select'
                        ])
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-check"></i>
                            <span>Chọn</span> 
                        </button>
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-forward"></i>
                            <span>Chuyển</span> 
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
@endsection