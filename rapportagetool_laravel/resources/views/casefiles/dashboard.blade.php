@extends('layouts.app')

@section('content')
    <h1>Casefiles</h1>
    @include('includes.casefile-card-title')
    @if(count($data['casefiles']) > 0)
        @foreach($data['casefiles'] as $casefile)
            <div class="card mb-0 shadow-sm">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-sm btn-success" href="/casefiles/{{$casefile->id}}">{{$casefile->casecode}}</a>
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Options</span>
                            </button>
                            <div class="dropdown-menu">
                                <h6 class="dropdown-header text-center">{{$casefile->casecode}}</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/casefiles/{{$casefile->id}}">View Casefile</a>
                                <a class="dropdown-item text-primary" href="#">Add note</a>
                                <a class="dropdown-item text-primary" href="#">Add file</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Copy CaseCode</a>
                                <a class="dropdown-item" href="#">Copy CaseCode Staff link</a>
                                <a class="dropdown-item" href="#">Copy CaseCode Client link</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Hide Casefile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">Delete Casefile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="">{{$data['casestates'][$casefile->case_state_index-1]->name}}</span>
                            </button>
                            <div class="dropdown-menu">
                                <h6 class="dropdown-header text-center">Set {{$casefile->casecode}} status to</h6>
                                <div class="dropdown-divider"></div>
                                @foreach($data['casestates'] as $caseState)
                                    <a id="case-state-{{$caseState['id']}}" class="dropdown-item @if($casefile->case_state_index == $caseState['id']) active @endif " href="#">{{$caseState['name']}}</a>
                                @endforeach
                            </div>
                        </div>
                        {{--                        <h5><span class="font-weight-normal badge badge-success">{{$data['casestates'][$casefile->case_state_index]->name}}</span></h5>--}}
                    </div>
                    <div class="col-sm-2">
                        <small><span class="text-sm-left align-content-center">{{\Illuminate\Support\Str::limit($casefile->name,22)}}</span></small>
                    </div>
                    <div class="col-md-2">
                        <h6>
                            @foreach($data['assignedClients'][$casefile->id] as $assignee)
                                <a class="font-weight-normal @if($assignee->is_first_contact)badge badge-dark btn-sm @elseif($assignee->can_read_only) badge badge-light text-muted btn-sm @else badge badge-secondary btn-sm @endif" href="clients/{{$assignee->client->id}}">{{$assignee->client->name}}</a>
                            @endforeach
                        </h6>
                    </div>
                    <div class="col-sm-4">
                        <h6>
                            @foreach($data['assignedUsers'][$casefile->id] as $assignee)
                                <a class="font-weight-normal @if($assignee->is_lead_investigator)badge badge-primary btn-sm @elseif($assignee->can_read_only) badge badge-light text-muted btn-sm @else badge badge-secondary btn-sm @endif" href="users/{{$assignee->user->id}}">{{$assignee->user->name}}</a>
                            @endforeach
                        </h6>
{{--                        <small>Created {{$casefile->created_at}} by <a class="text-secondary" href="users/{{$casefile->user_id}}">{{$casefile->user->name}}</a></small><br>--}}
                    </div>
                </div>
            </div>
        @endforeach
        {{$data['casefiles']->links()}}
    @else
        <p>No casefiles found</p>
    @endif
@endsection