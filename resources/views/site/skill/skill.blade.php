@extends('layouts.create')

@section('form')

    @include('common.block.flash-message')

    <form action="{{route('skill.store')}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'skill_code',
                'label' => 'Mã code',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-text', [
                'name' => 'skill_name',
                'label' => 'Tên kỹ năng',
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
            'name_skill' => 'name',
            'edit' => 'pattern.modified'
           ],
        'items' => $skills,
        'edit_route' => 'skill.edit'
    ])
@endsection,

