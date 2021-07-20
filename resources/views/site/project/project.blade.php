@extends('layouts.create')

@section('form')

    @include('common.block.flash-message')

    <form action="{{route('project.store')}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'project_code', 
                'label' => 'Mã code',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-text', [
                'name' => 'project_name', 
                'label' => 'Tên dự án',
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        @include('components.button-group', [
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
            'name_project' => 'name',
            'edit' => 'pattern.modified'
           ],
        'items' => $projects,
        'edit_route' => 'project.edit'
    ])

    {{$projects->links()}}

@endsection




