@extends('layouts.app')

@section('content')
    @include('modals.generic-info-modal')
    @include('modals.generic-form-modal')

    <h1>Create Casefile</h1>
    {!! Form::open(['action' => 'CasefilesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::button('CaseCode: '.$data['casecode'].' <span id="caseCodeCopyBadge" class="text-light badge badge-primary font-weight-light">Click to copy</span>', ['data-clipboard-return-id-target'=> 'caseCodeCopyBadge', 'data-clipboard-text'=> $data['casecode'], 'type' => 'button', 'class' => 'btn btn-light btn-sm  btnClipboard'] ) }}
            {{Form::hidden('casecode', $data['casecode'])}}

        </div>
        <div class="form-group">
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Title (max 32 characters)'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body message'])}}
        </div>
        <div class="form-group">
            {{Form::label('case-state', 'Status')}}
            @include('casefiles.elements.select-case-state-dropdown')
        </div>
        <div class="form-group">
            {{Form::label('assignees', 'Assignees')}}
            <div class="card mb-0 shadow-sm">
                <div class="row" id="assigneesContainerA">
                    <div class="col-sm-3">
                        <div class="p-1">
                            <button type="button" class="btn btn-primary btn-block btn-md genericFormModalBtn" data-toggle="modal" data-save="addLeadInvestigator" data-cmd="getAjax" data-url="ajaxGetLeadInvestigatorSelectList" data-header="Add Lead Investigator" data-target="#genericFormModal">
                                Select Lead Investigator
                            </button>
                            <div class="mt-1" id="ajax-output-addLeadInvestigator">
                                {{--AJAX Output--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="p-1">
                            <button type="button" class="btn btn-primary btn-block btn-md genericFormModalBtn" data-toggle="modal" data-save="addInvestigators" data-cmd="getAjax" data-url="ajaxGetInvestigatorSelectList" data-header="Add Investigator" data-target="#genericFormModal">
                                Select Investigators
                            </button>
                            <div class="mt-1" id="ajax-output-addInvestigators">
                                {{--AJAX Output--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="p-1">
                            <button type="button" class="btn btn-primary btn-block btn-md genericFormModalBtn" data-toggle="modal" data-save="addClients" data-cmd="getAjax" data-url="ajaxGetClientSelectList" data-header="Add Client"  data-target="#genericFormModal">
                                 Select Clients
                            </button>
                            <div class="mt-1" id="ajax-output-addClients">
                                {{--AJAX Output--}}
                            </div>
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