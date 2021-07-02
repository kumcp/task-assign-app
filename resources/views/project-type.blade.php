
@extends('layouts.create')

@section('form')
    <form action="#">
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'project_code', 
                'label' => 'Mã',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'project_name', 
                'label' => 'Tên',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-date', [
                'name' => 'deadline', 
                'type' => 'date',
                'label' => 'Hạn xử lý',
            ])
            @include('components.select', [
                'name' => 'common', 
                'label' => 'Thường xuyên',
                'options' => ['Không', 'Có'],
            ])
        </div>

        @include('components.buttons', ['buttons' => ['Lưu', 'Xóa']])
    </form>
@endsection

@section('table')
    @include('components.table', [
        'cols' => ['Mã', 'Tên'],
        'rows' => [
            ['ABC', 'CodeStar'],
            ['ABC', 'CodeStar'],
            ['ABC', 'CodeStar'],
            ['ABC', 'CodeStar'],
        ]
    ])
    
@endsection