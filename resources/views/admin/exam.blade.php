@extends('layout.admin-course-content')

@section('course-content-page')
    <div class="tab-pane active" id="exam" role="tabpanel" aria-labelledby="exam-tab">
        <div class="row adding-exam-box">
            {!! Form::open(['url' => route('add-exam'), 'class' => 'container white-box', 'enctype' => 'multipart/form-data']) !!}

            @include('common.block.title', ['text' => __('title.exam-management')])

            @include('common.block.flash-message')

            @include('common.block.input-text', ['name' => 'exam-name'])

            @include('common.block.input-number', ['name' => 'exam-time', 'value' => 60])

            @include('common.block.input-number', ['name' => 'pass-condition', 'value' => 40])

            @include('common.block.select', [
            'name' => 'course',
            'options' => $courses,
            'valueField' => 'id',
            'displayField' => 'name'
            ])

            @include('common.block.radio-button', [
            'options' => $examTypes,
            'name' => 'exam-type'
            ])

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="form-check">
                        {{ Form::Submit(__('title.add-exam'), ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="row exam-list">
            @include('common.block.table', [
            'fields' => [
            'modify' => 'pattern.modified',
            'exam-name' => 'name',
            'status' => 'status',
            'exam-type' => 'type',
            'created-at' => 'created_at',
            'course' => 'course_name'
            ],
            'items' => $exams,
            'edit_route' => 'exam-detail',
            'delete_route' => 'delete-exam',
            'type' => [
            'multi_choice' => __('title.multi_choice'),
            'mixing' => __('title.mixing')
            ]
            ])
        </div>
    </div>
@endsection
