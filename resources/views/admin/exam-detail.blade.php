@extends('layout.admin-course-content')

@section('course-content-page')
    <div class="tab-pane active" id="exam" role="tabpanel" aria-labelledby="exam-tab">
        <div class="row adding-exam-box">
            {!! Form::open(['url' => route('update-exam', ['id' => $exam->id]), 'class' => 'container white-box', 'enctype' => 'multipart/form-data']) !!}

            @include('common.block.title', ['text' => __('title.exam-detail')])

            @include('common.block.flash-message')

            @include('common.block.input-text', ['name' => 'exam-name', 'value' => $exam->name])

            @include('common.block.input-number', ['name' => 'exam-time', 'value' => $exam->time_minute])

            @include('common.block.input-number', ['name' => 'pass-condition', 'value' => $exam->amount_to_pass])

            @include('common.block.select', [
            'name' => 'course',
            'options' => $courses,
            'valueField' => 'id',
            'displayField' => 'name',
            'select' => $exam->course_id
            ])

            @include('common.block.radio-button', [
            'options' => $examTypes,
            'name' => 'exam-type',
            'select' => $exam->type,
            ])

            @include('common.block.input-file', [
            'name' => 'exam-data'
            ])

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="form-check">
                        <button type="submit" class="btn btn-primary" name='action'
                            value='update'>{{ __('title.save') }}</button>
                        <button type="submit" class="btn btn-danger" name='action'
                            value='delete'>{{ __('title.delete') }}</button>
                        <button type="submit" class="btn btn-danger" name='action'
                            value='truncate-question'>{{ __('title.truncate-question') }}</button>

                    </div>
                </div>
            </div>
            {!! Form::close() !!}

            <div class="accordion" id="accordionExample">
                {{ !($index = 1) }}
                @foreach ($exam->questions ?? [] as $question)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ $question->id }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $question->id }}" aria-expanded="true"
                                aria-controls="collapse-{{ $question->id }}">
                                {{ $index++ }}. {{ $question->text }}
                            </button>
                        </h2>

                        <div id="collapse-{{ $question->id }}" class="accordion-collapse collapse show"
                            aria-labelledby="heading-{{ $question->id }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="float-end">
                                    <button class='btn btn-primary'><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg></button>
                                </div>
                            </div>
                            @foreach ($question->answers ?? [] as $answer)
                                <div class="accordion-body">
                                    @if ($answer->correct_answer === 'yes')
                                        <b>{{ $answer->text }}</b>
                                    @else
                                        {{ $answer->text }}
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
