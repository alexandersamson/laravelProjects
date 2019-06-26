@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-outline-dark">Go back</a>
    <h1>{{$post->title}}</h1>
    <img alt="cover image" width="100%" src="/storage/cover_images/{{$post->cover_image}}">
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}@if($post->created_at != $post->updated_at) | Last modified on {{$post->updated_at}}@endif | By: {{$post->user_id}}</small>
    <hr>
    @guest
    @else
    <a href="/posts/{{$post->id}}/edit" class="btn btn-outline-dark">Edit</a>
    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endguest
@endsection