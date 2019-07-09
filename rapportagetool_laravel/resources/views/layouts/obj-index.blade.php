@extends('layouts.app')

@section('content')
    <h3>{{ucfirst($category)}}</h3>
    @include('includes.obj-index-tool-bar')
    <div class="mt-2">
        @yield('obj-index')
    </div>
@endsection