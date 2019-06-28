@extends('layouts.app')

@section('content')
    <h1>Create Casefile</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('body', 'CaseCode: '.$data['casecode'].'')}}
    </div>
    <div class="form-group">
        {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Title (max 32 characters)'])}}
    </div>
    <div class="form-group">
        {{Form::label('body', 'Description')}}
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body message'])}}
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label" for="service_status">Leading Investigator</label>
        <div class="col-md-4">
            <select id="service_status" name="service_status" class="form-control">
                @foreach($data['investigators'] as $investigator)
                    <option value="{{$investigator->id}}" {{($investigator->id == Auth::id()) ? 'selected' : ''}}>{{$investigator->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        {{Form::file('cover_image')}}
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection