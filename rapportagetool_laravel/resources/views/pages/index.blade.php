@extends('layouts.app')

@section('content')

    @include('modals.testmodal')
    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-4">{{$title}}</h1>
            <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
            <p>
                <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-header="HEADER TEST OK" data-body="BODY TEST OK" data-target="#testModal">
                    Test Modal
                </button>
            </p>
        </div>
    </div>
@endsection