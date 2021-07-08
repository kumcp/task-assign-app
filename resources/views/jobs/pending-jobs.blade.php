@extends('jobs.index', [
    'left_title' => 'Công việc đang chờ nhận',
    'right_title' => 'Công việc chưa có người nhận'
])


@section('left-tab-table')
    @include('components.dynamic-table', [
        'id' => 'left-table',
        'cols' => [                               
            'Mã dự án' => 'project_code',         
            'Tên công việc' => 'name',                 
            'Người giao' => 'assigner',   
            'Hạn xử lý' => 'deadline',
            'KL giao' => 'assign_amount',
            'checkbox' => 'job_ids[]'
        ],
        'rows' => $newAssignedJobs,                      
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
            'Hạn xử lý' => 'deadline',
            'KL giao' => 'assign_amount',
            'checkbox' => 'job_ids[]'
        ],
        'rows' => $unassignedJobs,                       
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

