@extends('layouts.app')

@section('content')
    <a href="/casefiles" class="btn btn-outline-dark">Go back</a>
    <h1>{{$casefile->title}}</h1>
{{--    <img alt="cover image" width="100%" src="/storage/cover_images/{{$post->cover_image}}">--}}
    <div>
        {!!$casefile->description!!}
    </div>
    <hr>
    <small>Written on {{$casefile->created_at}}@if($casefile->created_at != $casefile->updated_at) | Last modified on {{$casefile->updated_at}}@endif | By: {{$casefile->user_id}}</small>
    <hr>
@endsection