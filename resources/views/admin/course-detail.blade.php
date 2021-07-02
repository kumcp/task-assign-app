@extends('layout.admin-dashboard')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('page')

    

    <h3 class="title">{{ __('title.course-content-management') }}</h3>

    <div class="container white-box">
        <div class="row mb-3">
            <div class="col-sm-12">

                <div class="tab-content">
                    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="course-tab">
                        <div class="row adding-course-box">
                            {!! Form::open(['url' => route('update-course', ['id' => $course->id]), 'class' => 'container white-box', 'enctype' => 'multipart/form-data']) !!}

                            @include('common.block.title', ['text' => __('title.course-detail')])

                            @include('common.block.flash-message')

                            @include('common.block.input-text', ['name' => 'course-name', 'value' => $course->name])

                            <div class="mb-3 row">
                                <label for="course-name"
                                    class="col-sm-2 col-form-label">{{ __('title.course-description') }}</label>
                                <div class="col-sm-6">
                                    <textarea type="text" class="form-control" id="course-description"
                                        name="course-description">{{ $course->description }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="course-image"
                                    class="col-sm-2 col-form-label">{{ __('title.course-image') }}</label>
                                <div class="col-sm-5">
                                    <div class="mb-3">
                                        <input class="form-control form-control-sm" name="course-image" type="file">
                                        @if ($course->image)
                                        <img src="{{ $course->image }}" alt="" srcset="" width="200" height="200">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @include('common.block.radio-button',
                                [
                                'options' => $courseTypes,
                                'name' => 'course-type',
                                'select' => $course->type
                                ])


                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <div class="form-check">
                                        {{ Form::Submit(__('title.save'), ['class' => 'btn btn-primary']) }}
                                        {{ Form::Submit(__('title.delete'), ['class' => 'btn btn-danger', 'name' => 'delete']) }}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class=" tab-pane" id="profile" role="tabpanel" aria-labelledby="exam-tab">
                        {{ __('title.exam') }}
                    </div>
                    <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="question-set-tab">
                        {{ __('title.question-set') }}</div>
                    <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="exam-result-tab">
                        {{ __('title.exam-result') }}</div>
                </div>
            </div>
        </div>

    </div>

@endsection
