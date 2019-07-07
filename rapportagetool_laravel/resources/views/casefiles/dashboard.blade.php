@extends('layouts.app')

@section('content')
    <h1>Casefiles</h1>
    @include('includes.casefile-card-title')
    @if(count($data['casefiles']) > 0)
        @foreach($data['casefiles'] as $casefile)
            <div class="card mb-0 shadow-sm small">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="btn-group btn-group-sm btn-xs-div">
                            <div class="dropdown dropdown-btn">
                                <button type="button" class="btn btn-outline-success text-dark btn-sm btn-xs-div fixed-width-125 pl-1 pr-1 pt-0 pb-0 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="">{{$casefile->casecode}}</span>
                                </button>
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header text-center">{{$casefile->casecode}}</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/casefiles/{{$casefile->id}}">View Casefile</a>
                                    <a class="dropdown-item text-primary" href="#">Add note</a>
                                    <a class="dropdown-item text-primary" href="#">Add media</a>
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
                            <div class="dropdown dropdown-btn">
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle btn-xs-div fixed-width-100 pl-1 pr-1 pt-0 pb-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        </div>
                        {{--                        <h5><span class="font-weight-normal badge badge-success">{{$data['casestates'][$casefile->case_state_index]->name}}</span></h5>--}}
                    </div>
                    <div class="col-sm-3">
                        <span class="text-sm-left">{{\Illuminate\Support\Str::limit($casefile->name,30)}}</span>
                    </div>
                    <div class="col-sm-2">
                        <h6>
                            @foreach($data['assignedUsers'][$casefile->id] as $assignee)
                                @if($loop->iteration > 1)
                                    <small>+{{count($data['assignedUsers'][$casefile->id])-1}}</small>
                                    @break
                                @endif
                                <a class="font-weight-normal @if($assignee->is_lead_investigator)badge badge-primary btn-sm @elseif($assignee->can_read_only) badge badge-light text-muted btn-sm @else badge badge-secondary btn-sm @endif" href="users/{{$assignee->user->id}}">{{$assignee->user->name}}</a>
                            @endforeach
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6>
                            @foreach($data['assignedClients'][$casefile->id] as $assignee)
                                @if($loop->iteration > 1)
                                    <small>+{{count($data['assignedClients'][$casefile->id])-1}}</small>
                                    @break
                                @endif
                                <a class="font-weight-normal @if($assignee->is_first_contact)badge badge-dark btn-sm @elseif($assignee->can_read_only) badge badge-light text-muted btn-sm @else badge badge-secondary btn-sm @endif" href="clients/{{$assignee->client->id}}">{{$assignee->client->name}}</a>
                            @endforeach
                        </h6>
                    </div>
                    <div class="col-sm-2">
                        <h6>
                            @foreach($data['assignedSubjects'][$casefile->id] as $assignee)
                                @if($loop->iteration > 1)
                                    <small>+{{count($data['assignedSubjects'][$casefile->id])-1}}</small>
                                    @break
                                @endif
                                <a class="font-weight-normal badge badge-primary btn-sm badge badge-secondary btn-sm" href="subjects/{{$assignee->subject->id}}">{{$assignee->subject->name}}</a>
                            @endforeach
                        </h6>
                    </div>
                </div>
            </div>
        @endforeach
        {{$data['casefiles']->links()}}
    @else
        <p>No casefiles found</p>
    @endif
@endsection