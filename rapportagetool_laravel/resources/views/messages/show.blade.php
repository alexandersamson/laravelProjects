@extends('layouts.obj-show', ['category' => 'messages','id' => $data['obj']->id,'name' => $data['obj']->name,'deleted' => $data['obj']->deleted])

@section('obj-show')
    <div>
        {!!\App\Http\Controllers\Services\Helper::parseBB($data['obj']->body)!!}
    </div>
    <hr>
    @if($data['obj']->deleted)
        <h5><span class="badge badge-danger">This message has been deleted</span></h5>
    @endif
    @include('includes.created-by-footer')
@endsection