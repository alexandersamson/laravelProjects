@extends('layouts.app')

@section('content')
    <a href="/subjects" class="btn btn-outline-dark">&lt; Back to subjects</a>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div align="center">
                        <img alt="cover image" width="" src="{{$profilepicturesBasePath}}subjects/{{$data['subject']->id}}/profilepicture">
                        <h5 class="card-title">{{$data['subject']->name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['subject']->email}}">{{ $data['subject']->email }}</a> | <a href="tel:{{$data['subject']->phone}}">{{ $data['subject']->phone }}</a></h6>
                        <small class="card-subtitle mb-2 text-muted">
                            Small Subjects info
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