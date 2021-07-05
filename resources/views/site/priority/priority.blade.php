@extends('layouts.create')

@section('form')

    @include('common.block.flash-message')

    <form action="{{route('project.store')}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'priority_code',
                'label' => 'Mã code',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'priority_name',
                'label' => 'Tên ưu tiên',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-number', [
                'name' => 'priority_number',
                'label' => 'Thứ tự ưu tiên',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        @include('components.buttons', [
            'buttons' => [
                ['iconClass' => 'fas fa-save', 'value' => 'Lưu' ],
                ['iconClass' => 'fas fa-trash', 'value' => 'Xóa' ],
            ]
        ])
    </form>
@endsection

@section('table')
    @include('common.block.table', [
        'fields' => [
            'code' => 'code',
            'name_priority' => 'name',
            'edit' => 'pattern.modified',
           ],
        'items' => $prioritys,
        'edit_route' => 'priority.edit'
    ])
@endsection,

