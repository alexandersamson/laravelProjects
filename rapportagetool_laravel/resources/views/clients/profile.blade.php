@extends('layouts.app')

@section('content')
    <a href="/clients" class="btn btn-outline-dark">&lt; Back to users</a>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div align="center">
                        <img alt="cover image" width="" src="{{$profilepicturesBasePath}}clients/{{$data['client']->id}}/profilepicture">
                        <h5 class="card-title">{{$data['client']->name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['client']->email}}">{{ $data['client']->email }}</a> | <a href="tel:{{$data['client']->phone}}">{{ $data['client']->phone }}</a></h6>
                        <small class="card-subtitle mb-2 text-muted">
                            Small Clients info
                        </small>
                    </div>
                    <p class="card-text">

                    </p>
                    @include('includes.created-by-footer')
                </div>
            </div>
        </div>
    </div>


@endsection