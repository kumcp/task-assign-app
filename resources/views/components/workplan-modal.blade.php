@extends('components.modal', [
    'title' => 'Kế hoạch thực hiện',
    'id' => 'workplan-modal'
])

@section('modal-body')
    <form action="{{ route('workplans.store') }}" method="POST">
        
        @isset ($jobAssignId)
            <input type="hidden" name="job_assign_id" value="{{ $jobAssignId }}">
        @endisset

        @isset ($jobId)
            <input type="hidden" name="job_id" value="{{ $jobId }}">
        @endisset

        @isset ($staffId)
            <input type="hidden" name="staff_id" value="{{ $staffId }}">
        @endisset

        <div class="form-group-row mb-3">
            @include('components.input-date', [
                'type' => 'date',
                'name' => 'from_date', 
                'label' => 'Từ ngày',
            ])

            @include('components.input-date', [
                'type' => 'date',
                'name' => 'to_date', 
                'label' => 'Đến ngày',
            ])
        </div>

        <div class="form-group-row mb-3">
            @include('components.input-date', [
                'type' => 'time',
                'name' => 'from_time', 
                'label' => 'Từ giờ',
            ])

            @include('components.input-date', [
                'type' => 'time',
                'name' => 'to_time', 
                'label' => 'Đến giờ',
            ])

        </div>

        <div class="form-group-row mb-3">
            @include('components.text-area', [
                'name' => 'content', 
                'label' => 'Nội dung'
            ])
        </div>

        @include('components.button-group', [
            'parentClass' => 'btn-group offset-5',
            'buttons' => [
                ['iconClass' => 'fas fa-save', 'value' => 'Lưu', 'action' => 'create'], 
                ['type' => 'button', 'iconClass' => 'fas fa-redo', 'value' => 'Tạo lại', 'action' => 'reset'], 
                
            ] 
        ])
        



    </form>

@endsection