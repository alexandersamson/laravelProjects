@extends('layouts.app')

@section('content')

    <h1>Create Casefile</h1>
    {!! Form::open(['action' => 'CasefilesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            <span class="">{{$data['casecode']}}</span>
            @include('includes.snippets.copy-buttons',['obj' => $data['casecode']])
            {{Form::hidden('casecode', $data['casecode'])}}
            {{Form::hidden('id', $data['id'])}}

        </div>
        <div class="form-group">
            {{Form::text('name', '', ['id' => 'main-casefile-name',
                                      'class' => 'form-control autosave-input',
                                      'placeholder' => 'Title (max 32 characters)',
                                      'data-cooldowngroup' => 'title',
                                      'data-sourcecat' => 'casefiles',
                                      'data-sourceinput' => 'name',
                                      'data-inputid' => 'main-casefile-name',
                                      'data-sourceid' => $data['id']])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', '', ['id' => 'main-casefile-description',
                                                 'class' => 'form-control autosave-input',
                                                 'placeholder' => 'Description',
                                                 'data-cooldowngroup' => 'body',
                                                 'data-sourcecat' => 'casefiles',
                                                 'data-sourceinput' => 'description',
                                                 'data-inputid' => 'main-casefile-description',
                                                 'data-sourceid' => $data['id']])}}
        </div>
        <div class="form-group">
            {{Form::label('case-state', 'Status')}}
            @include('casefiles.elements.select-case-state-dropdown')
        </div>
        <div class="form-group">
            {{Form::label('assignees', 'Assignees')}}
            <div class="card mb-0 shadow-sm">
                <div class="row" id="assigneesContainerA">
                    <div class="col-sm-12">
                        <div class="form-row m-2">
                            @include('includes.components.searchbox-add-to-list', ['sourceCat' => "casefiles", 'sourceId' => $data["id"], 'searchCategories' => ["leaders","investigators","clients","subjects"], 'searchTitles' => ["Lead Investigator","Investigators","Clients","Subjects"], 'searchPermissionFilters' => ["Investigator","Investigator",null,null]])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
@endsection