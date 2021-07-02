@extends('layouts.create')

@section('form')

    @include('common.block.flash-message')

    <form action="{{ route('project.store') }}" method="POST">
        @csrf
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
        @include('components.button-group', [
        'buttons' => [
        ['iconClass' => 'fas fa-save', 'value' => 'Lưu', 'action' => 'save'],
        ['iconClass' => 'fas fa-trash', 'value' => 'Xóa', 'action' => 'delete'],
        ]
        ])
    </form>
@endsection

@section('table')
    @include('components.table', [
    'cols' => ['Mã', 'Tên'],
    'rows' => []

    ])
@endsection
