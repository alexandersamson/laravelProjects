@extends('layouts.app')

@section('content')
    <h4>
        @if($deleted)
            <div class="badge font-weight-light badge-danger">Deleted</div>
        @endif
        @if((new \App\Http\Controllers\Services\Helper)->needsApproval($category, $id))
            <div class="badge font-weight-light badge-primary">Needs approval</div>
        @endif
    </h4>
    <h3><span class="text-muted">{{ucfirst($category)}} / </span>{{$name}}</h3>

    @include('includes.obj-show-tool-bar')
    <hr>
    <div class="mt-2">
        @yield('obj-show')
    </div>
    <hr>
    @include('includes.obj-show-tool-bar')
@endsection