@extends('layouts.obj-index', ['category' => 'posts'])

@section('obj-index')
    @if(count($objs) > 0)
        @foreach($objs as $post)
            <div class="card">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img alt="cover image" width="100%" src="/storage/cover_images/{{$post->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post->name}}</a></h3>
                        <small>Written on {{$post->created_at}} by <a href="users/{{$post->user->id}}">{{$post->user->name}}</a></small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$objs->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection
