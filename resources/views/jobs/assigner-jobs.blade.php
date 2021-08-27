@extends('jobs.index', [
    'left_title' => $leftTableJobs['title'],
    'right_title' => $rightTableJobs['title'],
    'type' => $type
])


@section('left-tab-table')
    @include('components.dynamic-table', [
        'id' => 'left-table',
        'cols' => [                               
            'Mã dự án' => 'project_code',        
            'Tên công việc' => 'name',               
            'Người giao' => 'assigner',   
            'Khác' => 'others',
            'Hạn xử lý' => 'deadline',
            'KL giao' => 'assign_amount',
            'Số ngày còn lại' => 'remaining',
            'Trạng thái' => 'status',
            'Đánh giá' => 'evaluation',
            'checkbox' => 'job_ids[]'
        ],
        'rows' => $leftTableJobs['jobs'],                      
        'min_row' => 4,                             
    ])
@endsection


@section('right-tab-table')
    @include('components.dynamic-table', [
        'id' => 'right-table',
        'cols' => [                              
            'Mã dự án' => 'project_code',        
            'Tên công việc' => 'name',               
            'Người giao' => 'assigner',   
            'Khác' => 'others',
            'Hạn xử lý' => 'deadline',
            'KL giao' => 'assign_amount',
            'Số ngày còn lại' => 'remaining',
            'Trạng thái' => 'status',
            'Đánh giá' => 'evaluation',
            'checkbox' => 'job_ids[]'
        ],
        'rows' => $rightTableJobs['jobs'],                       
        'min_row' => 4,                          
    ])
@endsection



