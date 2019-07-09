@extends('layouts.obj-show', ['category' => 'posts','id' => $data['obj']->id,'name' => $data['obj']->name,'deleted' => $data['obj']->deleted])

@section('obj-show')
    <img alt="cover image" width="100%" src="/storage/cover_images/{{$data['obj']->cover_image}}">
    <div>
        {!!$data['obj']->body!!}
    </div>
    <hr>
    @if($data['obj']->deleted)
        <h5><span class="badge badge-danger">This post has been deleted</span></h5>
    @endif
    @include('includes.created-by-footer')
@endsection