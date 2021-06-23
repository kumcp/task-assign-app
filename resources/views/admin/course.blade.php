@extends('layout.admin-course-content')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('course-content-page')
    <div class="tab-pane active" id="course" role="tabpanel" aria-labelledby="course-tab">
        <div class="row adding-course-box">
            {!! Form::open(['url' => route('add-course'), 'class' => 'container white-box', 'enctype' => 'multipart/form-data']) !!}

            @include('common.block.title', ['text' => __('title.course-management')])

            @include('common.block.flash-message')

            @include('common.block.input-text', ['name' => 'course-name'])

            <div class="mb-3 row">
                <label for="course-name" class="col-sm-2 col-form-label">{{ __('title.course-description') }}</label>
                <div class="col-sm-6">
                    <textarea type="text" class="form-control" id="course-description" name="course-description"></textarea>
                </div>
            </div>

            @include('common.block.input-file', ['name' => 'course-image'])

            @include('common.block.radio-button',
            [
            'options' => $courseTypes,
            'name' => 'course-type'
            ])


            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="form-check">
                        {{ Form::Submit(__('title.add-course'), ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="row course-list">
            @include('common.block.table', [
            'fields' => [
            'modify' => 'pattern.modified',
            'course-name' => 'name',
            'avatar' => 'pattern.image',
            'status' => 'status',
            'course-type' => 'type',
            'created-at' => 'created_at'
            ],
            'items' => $courses,
            'edit_route' => 'course-detail',

            'type' => [
            'multiple_choice' => __('title.multi_choice'),
            'mixing' => __('title.mixing')
            ]
            ])
        </div>

    </div>

@endsection
