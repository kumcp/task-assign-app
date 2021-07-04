@extends('layouts.create')

@section('form')

<<<<<<< HEAD
    @include('components.flash-message')

    <form action="{{route('skill.store')}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'skill_code',
                'label' => 'Mã code',
=======
    @include('common.block.flash-message')

    <form action="{{route('project.store')}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'project_code',
                'label' => 'Mã',
>>>>>>> afbd025 (dat upcode 04.07.2021)
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-text', [
<<<<<<< HEAD
                'name' => 'skill_name',
                'label' => 'Kỹ năng',
=======
                'name' => 'project_name',
                'label' => 'Tên',
>>>>>>> afbd025 (dat upcode 04.07.2021)
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        @include('components.buttons', [
            'buttons' => [
                ['iconClass' => 'fas fa-save', 'value' => 'Lưu' ],
<<<<<<< HEAD
            ]
        ])
        <a href="" class="btn btn-light"> <i class="fas fa-trash"></i> Xóa </a>
=======
                ['iconClass' => 'fas fa-trash', 'value' => 'Xóa' ],
            ]
        ])
>>>>>>> afbd025 (dat upcode 04.07.2021)
    </form>
@endsection

@section('table')
<<<<<<< HEAD
    @include('components.table', [
        'fields' => [
            'code' => 'code',
            'name_skill' => 'name',
            'edit' => 'pattern.modified'
           ],
        'items' => $skills,
        'edit_route' => 'skill.edit'
    ])

    {{$skills->links()}}

=======
    @include('common.block.table', [
        'fields' => [
            'code' => 'code',
            'name_project' => 'name',
            'edit' => 'pattern.modified'
           ],
        'items' => $skill,
        'edit_route' => 'skill.edit'
    ])
>>>>>>> afbd025 (dat upcode 04.07.2021)
@endsection,

