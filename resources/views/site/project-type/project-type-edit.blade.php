@extends('layouts.create')

@section('form')

    @include('common.block.flash-message')

    <form action="{{route('project-type.update',['id'=>$project_type->id])}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'project_type_code',
                'label' => 'Mã',
                'value' => $project_type->code,
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'project_type_name',
                'value' => $project_type->name,
                'label' => 'Tên',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-3">
            @include('components.input-number', [
               'name' => 'project_type_deadline',
               'label' => 'Hạn xử lý',
               'value' => $project_type->deadline,
               'inputClass' => 'form-control d-inline w-75'
           ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.select', [
                'name' => 'project_type_common',
                'label' => 'Thường xuyên',
                'value' => $project_type->common,
                'options' => [
                                    ['value' => 0, 'display' => 'Không'],
                                    ['value' => 1, 'display' => 'Có'],

                                ]

            ]),
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
            'name' => 'name',
            'edit' => 'pattern.modified'
           ],
        'items' => $projects_type,
        'edit_route' => 'project-type.edit'
    ])
@endsection,

