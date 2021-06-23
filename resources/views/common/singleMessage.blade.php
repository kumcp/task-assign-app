@extends('layout.main')

@section('page')
<div class="alert alert-info" role="alert">
    {{ $message ?? '' }}
</div>
@endsection