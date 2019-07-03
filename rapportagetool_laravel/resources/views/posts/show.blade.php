@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-outline-dark">Go back</a>
    <h1>{{$data['post']->title}}</h1>
    <img alt="cover image" width="100%" src="/storage/cover_images/{{$data['post']->cover_image}}">
    <div>
        {!!$data['post']->body!!}
    </div>
    <hr>
    @include('includes.created-by-footer')
    <hr>
    @guest
    @else
    <a href="/posts/{{$data['post']->id}}/edit" class="btn btn-outline-dark">Edit</a>
    {!!Form::open(['action' => ['PostsController@destroy', $data['post']->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endguest
@endsection