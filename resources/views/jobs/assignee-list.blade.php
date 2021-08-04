@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/assign-list.css') }}">
    <div class="container">
        <div class="row-mb-3 ml-0">
            <div class="job-list">
                @include('components.dynamic-table', [
                'cols' => [
                'Tên công việc' => 'name',
                'Khối lượng công việc' => 'workAmount',
                'Hạn xử lý' => 'deadline',
                'Tệp nội dung' => 'file',
                'checkbox' => ''
                ],
                'rows' => $jobs,
                'min_row' => 5,
                'checkbox' => 'select'
                ])
            </div>
        </div>
        <div class="col-md-12">
            @include('components.icon-button-group',
            ['buttonList' => [ 'cut' , 'list-ul' ]
            ])
        </div>
        <div class="assignee-list">
            <div class="row ml-0">
                <div class="col-md-4 p-0">
                    @include('components.checkboxes')
                </div>
                <div class="col-md-8">
                    <form action="#" class="w-100">
                        <div class="form-group-row mb-3">
                            @include('components.select', [
                            'name' => 'process_method',
                            'label' => 'Hình thức xử lý',
                            'options' => ['Chủ trì', 'Phối hợp', 'Nhận xét']
                            ])
                        </div>
                        <div class="form-group-row">
                            @include('components.dynamic-table', [
                            'cols' => [
                            'Đối tượng xử lý' => 'name',
                            'Hình thức xử lý' => 'processMethod',
                            'Báo cáo trực tiếp' => '',
                            'Hạn xử lý' => 'deadline',
                            'SMS' => 'sms'
                            ],
                            'rows' => $assignees ?? [],
                            'min_row' => 5,
                            'checkbox' => 'select'
                            ])
                        </div>
                        <div class="button-group">
                            <button type="submit" class="btn btn-light">
                                <i class="fas fa-check"></i>
                                <span>Chọn</span>
                            </button>
                            <button type="submit" class="btn btn-light">
                                <i class="fas fa-forward"></i>
                                <span>Chuyển</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
