@extends('layouts.app')

@section('content')

    @include('modals.testmodal')
    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-4">FastCases</h1>
            <p class="lead">Case management software for private investigators</p>
            <p>
                <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-header="TEST COMPLETED" data-body="BODY TEST OK" data-target="#testModal">
                    Test AJAX/MySQL
                </button>
            </p>
        </div>
    </div>
@endsection