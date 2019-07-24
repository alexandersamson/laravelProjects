@extends('layouts.app')

@section('content')

    <h1>Edit Casefile | {{$data['obj']->casecode}}</h1>
    {!! Form::open(['action' => 'CasefilesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            @include('includes.snippets.copy-buttons',['obj' => $data['obj']->casecode])
            {{Form::hidden('casecode', $data['obj']->casecode)}}
            {{Form::hidden('id', $data['obj']->id)}}

        </div>
        <div class="form-group">
            {{Form::text('name', $data['obj']->name, ['id' => 'main-casefile-name',
                          'class' => 'form-control autosave-input',
                          'placeholder' => 'Title (max 32 characters)',
                          'data-cooldowngroup' => 'title',
                          'data-sourcecat' => 'casefiles',
                          'data-sourceinput' => 'name',
                          'data-inputid' => 'main-casefile-name',
                          'data-sourceid' => $data['obj']->id])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', $data['obj']->description, ['id' => 'main-casefile-description',
                                                 'class' => 'form-control autosave-input',
                                                 'placeholder' => 'Description',
                                                 'data-cooldowngroup' => 'body',
                                                 'data-sourcecat' => 'casefiles',
                                                 'data-sourceinput' => 'description',
                                                 'data-inputid' => 'main-casefile-description',
                                                 'data-sourceid' => $data['obj']->id])}}
        </div>
        <div class="form-group">
            {{Form::label('case-state', 'Status')}}
            <generic-dropdown :category="'casefiles'" :id="{{$data['obj']->id}}" :element="'case_state_index'" ></generic-dropdown>
        </div>
    <div class="form-group">
        {{Form::label('assignees', 'Assignees')}}
        @include('includes.components.searchbox-add-to-list', ['sourceCat' => 'casefiles', 'sourceId' => $data['obj']->id, 'searchCategories' => ["leaders","investigators","clients","subjects","assets","vehicles"]])
    </div>
        @if(!\App\Http\Controllers\Services\PermissionsService::canDoWithObj('casefiles', $data['obj']->id,\App\Http\Controllers\Services\PermissionsService::getPermCode('approve'), true) && $data['obj']->approved == false)
            <span class="badge font-weight-normal badge-warning">This casefile needs approval by a {{\App\Http\Controllers\Services\PermissionsService::getPermissionsTextArray(\App\Http\Controllers\Services\PermissionsService::getBitwiseValue(['Casemanager']))[0]}}</span><br>
        @endif
        {{Form::submit('Done', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
@endsection