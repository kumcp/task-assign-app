@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="#" class="offset-4">
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'period', 
                    'label' => 'Kỳ',
                    'options' => ['Không', 'Bắt buộc'],
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'project_code', 
                    'label' => 'Mã công việc',
                    'options' => ['Không', 'Bắt buộc'],
                ])
            </div>
            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'lsx_amount', 
                    'label' => 'Khối lượng LSX',
                    'options' => ['Không', 'Bắt buộc'],
                ])
            </div>

            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'assign_amount', 
                    'label' => 'Khối lượng giao',
                    'options' => ['Không', 'Bắt buộc'],
                ])
            </div>

            <div class="form-group-row mb-3">
                @include('components.select', [
                    'name' => 'job_accept', 
                    'label' => 'Nhận việc',
                    'options' => ['Không', 'Bắt buộc'],
                ])
            </div>

            <div class="form-group-row mb-5">
                @include('components.select', [
                    'name' => 'work_plan', 
                    'label' => 'Kế hoạch thực hiện',
                    'options' => ['Không', 'Bắt buộc'],
                ])
            </div>
            <div class="row offset-2">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i>
                    <span>Lưu</span> 
                </button>
            </div>
            
        </form>
            
    </div>
@endsection