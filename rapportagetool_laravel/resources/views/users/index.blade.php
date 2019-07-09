@extends('layouts.obj-index', ['category' => 'users'])

@section('obj-index')
    @if(count($data['objs']) > 0)
        @foreach($data['objs'] as $user)
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
        {{$data['objs']->links()}}
    @else
        <p>No users found</p>
    @endif
@endsection