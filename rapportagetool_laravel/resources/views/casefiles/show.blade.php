@extends('layouts.obj-show', ['category' => 'casefiles','id' => $data['obj']->id,'name' => $data['obj']->name])

@section('obj-show')
    <div class="">
        <h3>{{$data['obj']->casecode}}</h3>
    </div>
    @include('includes.snippets.copy-buttons',['obj' => $data['obj']->casecode])
    @include('includes.snippets.qrCode',['casecode'=>$data['obj']->casecode])
    <div>
        {{$data['obj']->description}}
    </div>
    <hr>
    <div>
        <casenotes parent-id="{{ json_encode($data['obj']->id) }}"></casenotes>
    </div>
    @if($data['obj']->deleted)
        <h5><span class="badge badge-danger">This casefile has been deleted</span></h5>
    @endif
    @include('includes.created-by-footer')
    <hr>
@endsection