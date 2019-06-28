@extends('layouts.app')

@section('content')
    <h1>Users</h1>
    @if(count($data['users']) > 0)
        @foreach($data['users'] as $user)
            <div class="card">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4>
                            <a href="/users/{{$user->id}}">{{$user->name}}</a>
                        </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4>
                            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                        </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <small>
                            Permissions: {{$user->permission}}<br>
                            Created {{$user->created_at}}
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$data['users']->links()}}
    @else
        <p>No users found</p>
    @endif
@endsection