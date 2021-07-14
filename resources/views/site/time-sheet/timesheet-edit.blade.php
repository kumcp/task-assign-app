@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form action="#">
                    <div class="form-group-row mb-3">
                        @include('components.input-text', [
                            'name' => 'job_name',
                            'label' => 'Tên công việc',
                            'value' => $jobs[$jobAssign[$timeSheet->id]->job_id]->name,
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-text', [
                            'name' => 'assignee',
                            'label' => 'Đối tượng xử lý',
                            'value' => $jobAssign[$timeSheet->id]->staff_id,
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
                        ])
                        @include('components.input-date', [
                            'type' => 'time',
                            'name' => 'to_time',
                            'label' => 'Đến giờ',
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-text', [
                            'name' => 'percentage_completed',
                            'label' => '% hoàn thành',
                            'value' => 'text'
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.text-area', [
                            'name' => 'content',
                            'label' => 'Nội dung',
                        ])

                    </div>

                    <div class="btn-group offset-3" role="group">
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-save"></i>
                            <span>Ghi lại</span>
                        </button>
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-copy"></i>
                            <span>Ghi-sao</span>
                        </button>
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-trash"></i>
                            <span>Xóa</span>
                        </button>

                    </div>

                </form>
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
                            <td >{{$timesheet->created_at->format('d-m-y')}}</td>
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