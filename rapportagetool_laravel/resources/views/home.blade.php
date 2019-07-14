@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    
    @include('dashboard.index-include')
{{--    TODO: Add some more html to bottom of cards dashboard containers--}}
@endsection
