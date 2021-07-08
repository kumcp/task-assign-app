@extends('jobs.index', [
    'left_title' => 'Công việc trực tiếp xử lý',
    'right_title' => 'Công việc liên quan'
])


@section('left-tab-table')
    @include('components.dynamic-table', [
        'id' => 'left-table',
        'cols' => [                               
            'Mã dự án' => 'project_code',         
            'Tên công việc' => 'name',                 
            'Người giao' => 'assigner',   
            'Hình thức xử lý' => 'process_method',
            'Hạn xử lý' => 'deadline',
            'KL giao' => 'assign_amount',
            'KL timesheet' => 'timesheet_amount',
            '% hoàn thành' => 'finished_percent',
            'Số ngày còn lại' => 'remaining',
            'checkbox' => 'job_ids[]'
        ],
        'rows' => $directJobs,                      
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
            'Hình thức xử lý' => 'process_method',
            'Người chuyển tiếp' => 'forward',
            'Hạn xử lý' => 'deadline',
            'KL giao' => 'assign_amount',
            'KL timesheet' => 'timesheet_amount',
            '% hoàn thành' => 'finished_percent',
            'Số ngày còn lại' => 'remaining',
            'checkbox' => 'job_ids[]'
        ],
        'rows' => $relatedJobs,                       
        'min_row' => 4,                          
    ])
@endsection

{{-- @section('button-group')
    @include('components.button-group', [
        'parentClass' => 'btn-group offset-1',
        'buttons' => [
            ['iconClass' => 'fas fa-info-circle', 'value' => 'Xem chi tiết', 'action' => 'detail'], 
            ['iconClass' => 'fas fa-check', 'value' => 'Hoàn thành', 'action' => 'finish'], 
            ['iconClass' => 'fas fa-search', 'value' => 'Tìm kiếm', 'action' => 'search'], 
            ['iconClass' => 'fas fa-user-plus', 'value' => 'Giao xử lý', 'action' => 'assign'], 
            ['iconClass' => 'fas fa-clipboard-list', 'value' => 'Timesheet', 'action' => 'timesheet'], 
            ['iconClass' => 'fas fa-tasks', 'value' => 'Xác nhận SL', 'action' => 'amount_confirm'], 
            ['iconClass' => 'fas fa-comments', 'value' => 'Trao đổi', 'action' => 'exchange'] 
        ] 
    ])
@endsection --}}

