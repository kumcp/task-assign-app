@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4 ml-0">
            @include('components.select', [
                'name' => 'assignee',
                'label' => 'Đối tượng xử lý',
                'options' => ['abc', 'xyz'],
            ])
            <label for="process_method">(Hình thức xử lý)</label>

        </div>
        <div class="row ml-0">
            @include('components.dynamic-table', [
                'id' => 'right-table',
                'cols' => [                              
                    'Từ ngày' => 'from_date',        
                    'Đến ngày' => 'to_date',               
                    'Từ giờ' => 'from_time',   
                    'Đến giờ' => 'to_time',
                    'Nội dung công việc' => 'content',
                    'checkbox' => 'workplan_ids[]'
                ],
                'rows' => $workPlans ?? [],                       
                'min_row' => 4,                          
            ])
        </div>
    </div>
    
    <script>
        
    </script>
@endsection