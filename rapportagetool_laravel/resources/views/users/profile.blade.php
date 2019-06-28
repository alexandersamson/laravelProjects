@extends('layouts.app')

@section('content')
    <a href="/users" class="btn btn-outline-dark">Go back</a>
    <h1>{{$user->name}}</h1>
    <div>
        {!!$user->name!!}
    </div>
    <hr>
    <small>Created on {{$user->created_at}} by: {{$user->id}}</small>
    <hr>
    {{ print_r($user) }}
@endsection