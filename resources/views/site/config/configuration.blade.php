@extends('layouts.app')

@section('content')
    <div class="container">
        <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
            <legend class="w-auto">Cấu hình giao việc</legend>
            @include('components.flash-message')
            <form action="{{route('config.update')}}" class="offset-4" method="POST">
            @csrf
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'period', 
                    'label' => 'Kỳ',
                    'options' => [
                        ['id' => 0, 'name' => 'Không'],
                        ['id' => 1, 'name' => 'Có'],
                    ],
                    'checked' => $config[0]->value,
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'job_code',
                    'label' => 'Mã công việc',
                    'options' => [
                        ['id' => 0, 'name' => 'Không'],
                        ['id' => 1, 'name' => 'Có'],
                    ],
                    'checked' => $config[1]->value,
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'production_volume',
                    'label' => 'Khối lượng LSX',
                    'options' => [
                        ['id' => 0, 'name' => 'Không'],
                        ['id' => 1, 'name' => 'Có'],
                    ],
                    'checked' => $config[2]->value,
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'volume_interface',
                    'label' => 'Khối lượng giao',
                    'options' => [
                        ['id' => 0, 'name' => 'Không'],
                        ['id' => 1, 'name' => 'Có'],
                    ],
                    'checked' => $config[3]->value,
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'get_job',
                    'label' => 'Nhận việc',
                    'options' => [
                        ['id' => 0, 'name' => 'Không'],
                        ['id' => 1, 'name' => 'Có'],
                    ],
                    'checked' => $config[4]->value,
                ])
            </div>
            <div class="form-group-row mb-5">
                @include('components.select', [
                    'name' => 'Implementation_plan',
                    'label' => 'Kế hoạch thực hiện',
                    'options' => [
                        ['id' => 0, 'name' => 'Không'],
                        ['id' => 1, 'name' => 'Có'],
                    ],
                    'checked' => $config[5]->value,
                ])
            </div>

            @include('components.button-group', [
                    'buttons' => [
                        ['class' => 'btn btn-primary', 'iconClass' => 'fas fa-save', 'value' => 'Lưu' ],
                    ]
            ])

        </form>
        </fieldset>
    </div>
@endsection