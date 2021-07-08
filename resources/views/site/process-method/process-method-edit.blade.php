@extends('layouts.create')

@section('form')

    @include('components.flash-message')

    <form action="{{route('process-method.update',['id'=>$process_method->id])}}" method="POST">
        @csrf
        <div class="form-group-row mb-3">
            @include('components.input-text', [
                'name' => 'process_code',
                'label' => 'Mã code',
                'value' => $process_method->code,
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.input-text', [
                'name' => 'process_name',
                'label' => 'Hình thức xử lý',
                'value' => $process_method->name,
                'inputClass' => 'form-control d-inline w-75'
            ])
        </div>
        <div class="form-group-row mb-5">
            @include('components.select', [
                'name' => 'process_assigner',
                'label' => 'Chủ trì',
                'value' => $process_method->assigner,
                'options' => $jobs,
                 'checked' => 0,
            ])
        </div>
        @include('components.buttons', [
            'buttons' => [
                ['iconClass' => 'fas fa-save', 'value' => 'Lưu' ],
            ]
        ])
        @include('components.span-modal', [
           'value' => 'Xóa'
       ])
        </form>

        @include('components.modal', [
            'href' => route('process-method.destroy',['id'=>$process_method->id])
        ])
@endsection

@section('table')
    @include('components.table', [
        'fields' => [
            'code' => 'code',
            'name_process' => 'name',
            'edit' => 'pattern.modified'
           ],
        'items' => $process_methods,
        'edit_route' => 'process-method.edit'
    ])

    {{$process_methods->links()}}

@endsection,

