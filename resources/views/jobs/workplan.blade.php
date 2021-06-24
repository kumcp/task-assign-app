@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            @include('components.select', [
                'name' => 'assignee',
                'label' => 'Đối tượng xử lý',
                'options' => ['abc', 'xyz'],
            ])
            <label for="process_method">(Hình thức xử lý)</label>

        </div>
        <div class="row">
            @include('components.table', [
                'cols' => ['Từ ngày', 'Đến ngày', 'Từ giờ', 'Đến giờ', 'Nội dung công việc'],
                'rows' => [
                    ['2/5/2021', '10/5/2021', '8:00', '17:30', 'Hoàn thành task 1'],
                    ['2/5/2021', '10/5/2021', '8:00', '17:30', 'Hoàn thành task 1'],
                    ['2/5/2021', '10/5/2021', '8:00', '17:30', 'Hoàn thành task 1'],
                    ['2/5/2021', '10/5/2021', '8:00', '17:30', 'Hoàn thành task 1'],
                ],
            ])
        </div>
    </div>    
@endsection