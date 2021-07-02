@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @yield('form')
            </div>
            <div class="col-md-4">
                @yield('table')
            </div>
        </div>        
    </div>
    
@endsection