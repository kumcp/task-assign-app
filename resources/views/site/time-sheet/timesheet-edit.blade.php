@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
                    <legend class="w-auto">Time sheet</legend>

                    @include('components.flash-message')

                    <form action="{{route('timesheet.update',['id'=>$timeSheet->id])}}" method="POST">
                        @csrf
                        <div class="form-group-row mb-3">
                            @include('components.select', [
                                'name' => 'job_name',
                                'label' => 'Tên công việc',
                                'check' => $timeSheet->id,
                                'options' => $nameJob
                            ])

                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.select', [
                                'name' => 'process_method',
                                'label' => 'Đối tượng xử lý',
                                'check' => 0,
                                'options' => $staff
                            ])

                            <label for="process_method" class="ml-5">(Hình thức xử lý)</label>
                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-date', [
                                'type' => 'date',
                                'name' => 'from_date',
                                'label' => 'Từ ngày',
                                'value' => $timeSheet->from_date,
                            ])

                            @include('components.input-date', [
                                'type' => 'date',
                                'name' => 'to_date',
                                'label' => 'Đến ngày',
                                'value' => $timeSheet->to_date,
                            ])

                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-date', [
                                'type' => 'time',
                                'name' => 'from_time',
                                'label' => 'Từ giờ',
                                'value' => $timeSheet->form_time
                            ])
                            @include('components.input-date', [
                                'type' => 'time',
                                'name' => 'to_time',
                                'label' => 'Đến giờ',
                                'value' => $timeSheet->to_time
                            ])

                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.input-text', [
                                'name' => 'percentage_completed',
                                'label' => '% hoàn thành',
                                'value' => '20'
                            ])

                        </div>
                        <div class="form-group-row mb-3">
                            @include('components.text-area', [
                                'name' => 'content',
                                'label' => 'Nội dung',
                                'value' => $timeSheet->content
                            ])

                        </div>
                        @include('components.button-group', [
                            'buttons' => [
                                ['iconClass' => 'fas fa-save', 'value' => 'Lưu' ],
                            ]
                        ])

                        @include('components.span-modal', [
                           'value' => 'Xóa'
                       ])
                    </form>

                    @include('components.modal', [
                        'href' => route('timesheet.destroy',['id'=>$timeSheet->id]),
                        'messages' => 'Bạn có chắc chắn xóa time sheets?'
                    ])

                </fieldset>
            </div>
            <div class="col-md-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Ngày nhập time sheet</th><th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timeSheets as $timesheet)
                        <tr>
                            <td>{{$timesheet->created_at}}</td>
                            <td><a href="{{route('timesheet.edit',['id'=>$timesheet['id']])}}" class="btn btn-primary">Xem</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$timeSheets->links()}}
            </div>
        </div>
    </div>

@endsection