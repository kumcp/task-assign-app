@extends('layouts.create')

@section('form')

    @include('common.block.flash-message')

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
                'options' => [
                     ['value' => 0, 'display' => 'Không'],
                     ['value' => 1, 'display' => 'Có'],
                 ]
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
            'name_process' => 'name',
            'edit' => 'pattern.modified'
           ],
        'items' => $process_methods,
        'edit_route' => 'process-method.edit'
    ])
@endsection,

