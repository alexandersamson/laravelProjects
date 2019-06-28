@extends('layouts.app')

@section('content')
    <h1>Casefiles</h1>
    @if(count($data['casefiles']) > 0)
        @foreach($data['casefiles'] as $casefile)
            <div class="card">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <h3>
                            <a href="/casefiles/{{$casefile->id}}">{{$casefile->casecode}}</a>
                        </h3>
{{--                        <img alt="cover image" width="100%" src="/storage/cover_images/{{$post->cover_image}}">--}}
                    </div>
                    <div class="col-md-3 col-sm-3">
                        {{\Illuminate\Support\Str::limit($casefile->name,32)}}<br>
                        <small>
                            {{$data['casestates'][$casefile->case_state_index]->name}}
                        </small>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <small>
                            Created {{$casefile->created_at}} by <a href="users/{{$casefile->user_id}}">{{$casefile->user->name}}</a><br>
                            Assigned to <a href="users/{{$casefile->lead_investigator_index}}">{{$data['assignees'][$casefile->id]}}</a>
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$data['casefiles']->links()}}
    @else
        <p>No casefiles found</p>
    @endif
@endsection