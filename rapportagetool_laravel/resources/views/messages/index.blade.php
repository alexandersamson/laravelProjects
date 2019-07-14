@extends('layouts.obj-index', ['category' => 'messages'])

@section('obj-index')
    @if(count($objs) > 0)
        @foreach($objs as $obj)
            <div class="card">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img alt="cover image" width="100%" src="/storage/cover_images/{{$obj->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$obj->id}}">{{$obj->name}}</a></h3>
                        <small>Written on {{$obj->created_at}} by <a href="users/{{$obj->user->id}}">{{$obj->user->name}}</a></small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$objs->links()}}
    @else
        <p>No messages found</p>
    @endif
@endsection
