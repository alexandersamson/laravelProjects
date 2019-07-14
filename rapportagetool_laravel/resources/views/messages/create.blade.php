@extends('layouts.app')

@section('content')
    <h1>Compose Message</h1>
    {!! Form::open(['action' => 'MessagesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title (optional)'])}}
        </div>
    <div class="form-group">
        {{Form::label('body', 'Message')}}
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Message (Max 1000 characters)'])}}
    </div>
    <div class="form-group">
        {{Form::label('assignees', 'Recipients')}}
        <div class="card mb-0 shadow-sm">
            <div class="row" id="recipientsContainerA">
                <div class="col-sm-12">
                    <div class="form-row m-2">
                        @include('includes.components.searchbox-add-to-list', ['sourceCat' => "messages", 'sourceId' => $data['obj']->id, 'searchCategories' => ["users"], 'searchTitles' => ["Recipients"], 'searchPermissionFilters' => [null]])
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{Form::hidden('id', $data['obj']->id)}}
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection