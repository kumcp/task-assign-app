@extends('layout.admin-dashboard')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('page')

    <h3 class="title">{{ __('title.system-config-management') }}</h3>
    @if ($message ?? '')
        <div class="alert alert-{{ $messageType ?? 'info' }}" role="alert">
            {{ $message ?? '' }}
        </div>
    @endif

    <div>
        {!! Form::open(['url' => route('update-system-config'), 'class' => 'container white-box']) !!}
        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" {{ $configRRA == true ? 'checked' : '' }}
                        id="flexCheckDefault" name="require-rra">
                    <label class="form-check-label white" for="flexCheckDefault">
                        {{ __('title.requireRRA') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">{{ __('title.save') }}</button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>

@endsection
