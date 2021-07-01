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
        <div class="form-group-row mb-5">
            @include('components.input-text', [
                'name' => 'project_name', 
                'label' => 'Tên',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        @include('components.buttons', [
            'buttons' => [
                ['iconClass' => 'fas fa-save', 'value' => 'Lưu'], 
                ['iconClass' => 'fas fa-trash', 'value' => 'Xóa'], 
            ] 
        ])
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