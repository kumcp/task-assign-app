@extends('layout.admin-dashboard')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('page')
    @if ($message ?? '')
        <div class="alert alert-{{ $messageType ?? 'info' }}" role="alert">
            {{ $message ?? '' }}
        </div>
    @endif

    <h3 class="title">{{ __('title.course-content-management') }}</h3>

    <div class="container white-box">
        <div class="row mb-3">
            <div class="col-sm-12">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'course' ? 'btn btn-primary' : '' }}"
                            aria-current="page" href="{{ route('course') }}">{{ __('title.course') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'exam' ? 'btn btn-primary' : '' }}"
                            href="{{ route('exam') }}">{{ __('title.exam') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'question-set' ? 'btn btn-primary' : '' }}"
                            href="{{ route('question-set') }}">{{ __('title.question-set') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'exam-result' ? 'btn btn-primary' : '' }}"
                            href="{{ route('exam-result') }}">{{ __('title.exam-result') }}</a>
                    </li>
                </ul>


                <div class="tab-content">
                @section('course-content-page')
                @show
            </div>
        </div>
    </div>

</div>

@endsection
