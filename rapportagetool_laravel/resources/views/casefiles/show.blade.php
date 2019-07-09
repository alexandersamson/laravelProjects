@extends('layouts.obj-show', ['category' => 'casefiles','id' => $data['obj']->id,'name' => $data['obj']->name,'deleted' => $data['obj']->deleted])

@section('obj-show')
    <div>
        {{$data['obj']->description}}
    </div>
    <hr>
    @if($data['obj']->deleted)
        <h5><span class="badge badge-danger">This casefile has been deleted</span></h5>
    @endif
    @include('includes.created-by-footer')
    <hr>
@endsection