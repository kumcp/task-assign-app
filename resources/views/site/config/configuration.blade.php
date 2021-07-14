@extends('layouts.app')

@section('content')
    <div class="container">
        <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
            <legend class="w-auto">Cấu hình</legend>
            <form action="#" class="flex-center" method="POST">
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'period', 
                    'label' => 'Kỳ',
                    'options' => [
                        ['value' => 0, 'display' => 'Không'],
                        ['value' => 1, 'display' => 'Bắt buộc'],
                    ],
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'project_code', 
                    'label' => 'Mã công việc',
                    'options' => [
                        ['value' => 0, 'display' => 'Không'],
                        ['value' => 1, 'display' => 'Bắt buộc'],
                    ],
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'lsx_amount', 
                    'label' => 'Khối lượng LSX',
                    'options' => [
                        ['value' => 0, 'display' => 'Không'],
                        ['value' => 1, 'display' => 'Bắt buộc'],
                    ],
                ])
            </div>

            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'assign_amount', 
                    'label' => 'Khối lượng giao',
                    'options' => [
                        ['value' => 0, 'display' => 'Không'],
                        ['value' => 1, 'display' => 'Bắt buộc'],
                    ],
                ])
            </div>

            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'job_accept', 
                    'label' => 'Nhận việc',
                    'options' => [
                        ['value' => 0, 'display' => 'Không'],
                        ['value' => 1, 'display' => 'Bắt buộc'],
                    ],
                ])
            </div>

            <div class="form-group-row mb-5">
                @include('components.select', [
                    'name' => 'work_plan', 
                    'label' => 'Kế hoạch thực hiện',
                    'options' => [
                        ['value' => 0, 'display' => 'Không'],
                        ['value' => 1, 'display' => 'Bắt buộc'],
                    ],
                ])
            </div>
            <div class="row offset-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Lưu</span> 
                </button>
            </div>
            
        </form>
        </fieldset>
    </div>
@endsection