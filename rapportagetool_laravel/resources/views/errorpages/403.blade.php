@extends('layouts.app')


@section('content')
    <div class="error-page">
        <h2 class="headline text-info"> 403</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! No access.</h3>
            <p>
                You do not have access to this page.
                Meanwhile, you can <a href="/home">return to dashboard</a>.
            </p>
        </div>
    </div>
@endsection