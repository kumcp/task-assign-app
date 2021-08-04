@extends('jobs.index', [
    'all' => true
])


@section('table')
    @include('components.dynamic-table', [
        'id' => 'left-table',
        'cols' => [                               
            'Mã dự án' => 'project_code',         
            'Tên công việc' => 'name',                 
            'Người giao' => 'assigner',
            'Chủ trì' => 'main_handler',
            'Khác' => 'others'   
            'Hạn xử lý' => 'deadline',
            'KL giao' => 'assign_amount',
            'Ngày còn lại' => 'remaining',
            'Trạng thái' => 'status',
            'checkbox' => 'job_ids[]'
        ],
        'rows' => $jobs ?? [],                                  
    ])
@endsection




