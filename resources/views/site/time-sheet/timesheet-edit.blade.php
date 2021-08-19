@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                    <legend class="w-auto">Time sheet</legend>

                    @include('components.flash-message')

                    <form action="{{route('timesheet.update',['id'=> $timeSheet->id])}}" method="POST">
                        @csrf
                        <div class="form-group-row mb-3">
                            @if ($readonly)
                                @include('components.input-text', [
                                    'name' => 'job_name',
                                    'label' => 'Tên công việc',
                                    'value' => $job->name,
                                    'readonly' => true
                                ])
                                <input type="hidden" id="job_id" value="{{ $job->id }}">
                            @else
                                @include('components.select', [
                                    'name' => 'job_name',
                                    'label' => 'Tên công việc',
                                    'checked' => $job->id,
                                    'options' => $directJobs
                                ])
                            @endif


                        </div>
                        <div class="form-group-row mb-3">
                            @if ($readonly)
                                @include('components.select', [
                                    'name' => 'assignee_id',
                                    'label' => 'Đối tượng xử lý',
                                    'options' => $assignees,
                                    'checked' => $timeSheet->jobAssign->staff_id
                                ])
                            @else
                                @include('components.input-text', [
                                    'name' => 'assignee',
                                    'label' => 'Đối tượng xử lý',
                                    'value' => Auth::user()->staff->name,
                                    'readonly' => true
                                ])
                            @endif

                            <label for="process_method" class="ml-5">(Hình thức xử lý)</label>
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-date', [
                                'type' => 'date',
                                'name' => 'from_date',
                                'label' => 'Từ ngày',
                                'value' => $timeSheet->from_date,
                                'readonly' => $readonly
                            ])

                            @include('components.input-date', [
                                'type' => 'date',
                                'name' => 'to_date',
                                'label' => 'Đến ngày',
                                'value' => $timeSheet->to_date,
                                'readonly' => $readonly
                            ])

                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-date', [
                                'type' => 'time',
                                'name' => 'from_time',
                                'label' => 'Từ giờ',
                                'value' => $timeSheet->from_time,
                                'readonly' => $readonly
                            ])
                            @include('components.input-date', [
                                'type' => 'time',
                                'name' => 'to_time',
                                'label' => 'Đến giờ',
                                'value' => $timeSheet->to_time,
                                'readonly' => $readonly
                            ])

                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'percentage_completed',
                                'label' => '% hoàn thành',
                                'value' => $timeSheet->percentage_completed,
                                'readonly' => true
                            ])

                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.text-area', [
                                'name' => 'content',
                                'label' => 'Nội dung',
                                'value' => $timeSheet->content,
                                'readonly' => $readonly

                            ])

                        </div>
                        @if (!$readonly)
                            @include('components.button-group', [
                                'buttons' => [
                                    ['iconClass' => 'fas fa-save', 'action' => 'save', 'value' => 'Lưu' ],
                                    ['iconClass' => 'fas fa-redo', 'action' => 'reset', 'value' => 'Tạo mới' ],
                                ]
                            ])

                            @include('components.span-modal', [
                                'value' => 'Xóa'
                            ])
                        @endif

                    </form>

                    @include('components.warning-modal', [
                        'href' => route('timesheet.destroy',['id'=>$timeSheet->id]),
                        'messages' => 'Bạn có chắc chắn xóa time sheets?'
                    ])

                </fieldset>
            </div>
            <div class="col-md-4">
                <table class="table border table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Ngày nhập time sheet</th><th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timeSheets as $timesheet)
                        <tr>
                            <td>{{date_format($timesheet->created_at, 'd-m-Y')}}</td>
                            <td><a href="{{route('timesheet.edit',['id'=>$timesheet['id']])}}" class="btn btn-primary">Xem</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{-- {{$timeSheets->links()}} --}}
            </div>
        </div>
    </div>

    <script>
            $(document).ready(function() {
                $('#assignee_id').change(function() {
                    const assigneeId = $(this).val();
                    const jobId = $('#job_id').val();
                    window.location.href = `http://127.0.0.1:8000/timesheets?job_id=${jobId}&staff_id=${assigneeId}`;
                });
            });

    </script>

@endsection