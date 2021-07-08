@extends('layouts.create')

@section('form')

    @include('components.flash-message')

    <form action="{{route('priority.store')}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'priority_code',
                'label' => 'Mã code',
                'inputClass' => 'form-control d-inline w-75',
                'value' => old('priority_code')
            ])
        </div>
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'priority_name',
                'label' => 'Tên ưu tiên',
                'inputClass' => 'form-control d-inline w-75',
                'value' => old('priority_name')
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-number', [
                'name' => 'priority_number',
                'label' => 'Thứ tự ưu tiên',
                'inputClass' => 'form-control d-inline w-75',
                'value' => old('priority_number')
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
    @include('components.table', [
        'fields' => [
            'code' => 'code',
            'name_priority' => 'name',
            'priority' => 'priority',
            'edit' => 'pattern.modified',
           ],
        'items' => $priorities,
        'edit_route' => 'priority.edit'
    ])

    {{$priorities->links()}}

@endsection,

