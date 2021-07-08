@extends('layouts.create')

@section('form')

    @include('components.flash-message')

    <form action="{{route('skill.update',['id'=>$skill->id])}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'skill_code',
                'label' => 'Mã',
                'value' => $skill->code,
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-text', [
                'name' => 'skill_name',
                'label' => 'Tên',
                'value' => $skill->name,
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        @include('components.buttons', [
            'buttons' => [
                ['iconClass' => 'fas fa-save', 'value' => 'Lưu' ],
            ]
        ])

        <span class="btn btn-light" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-trash"></i> Xóa </span>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cảnh báo!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn xóa kỹ năng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <a href="{{route('skill.destroy',['id'=>$skill->id])}}" type="button" class="btn btn-primary">Xóa</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('table')
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

@endsection,

