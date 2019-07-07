@extends('layouts.app')

@section('content')
    <a href="/users" class="btn btn-outline-dark">&lt; Back to users</a>
    <div class="row">
        <div class="col-lg-8 col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div align="center">
                        <img alt="cover image" width="" src="{{$profilepicturesBasePath}}users/{{$data['user']->id}}/profilepicture">
                        <h5 class="card-title">{{$data['user']->name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['user']->email}}">{{ $data['user']->email }}</a> | <a href="tel:{{$data['user']->phone}}">{{ $data['user']->phone }}</a></h6>
                        <small class="card-subtitle mb-2 text-muted">
                            @getuserroles($data['person']->permission)
                        </small>
                    </div>
                    <p class="card-text">

                    </p>
                    @include('includes.created-by-footer')
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="row">
                @hasanyrole('Investigator')
                    @if(count($data['licenses']) > 0)
                        @include('users.includes.licenses')
                    @endif
                @endhasanyrole
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="center">
                                @if(auth()->user()->id == $data['user']->id)
                                    Send a memo to <span class="text-info">yourself</span>
                                @else
                                    Send <span class="text-info">{{$data['user']->name}}</span> a message
                                @endif
                            </div>
                            <hr>
                            <div class="p-1">
                                {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <div class="form-group">
                                    {{Form::textarea('body', '', ['rows' => 6, 'maxlength' => 500, 'id' => 'message-box', 'class' => 'form-control', 'placeholder' => 'Your message (max 500 characters)'])}}
                                </div>
                                {{Form::submit('Send', ['class' => 'btn btn-primary'])}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection