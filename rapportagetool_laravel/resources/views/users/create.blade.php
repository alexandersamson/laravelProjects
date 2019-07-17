@extends('layouts.app')

@section('content')
    <h1>Create User Registration Key</h1>
    <form method="POST" action="{{ route('generateregkey') }}">
    @csrf
        <div class="form-group">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}
            {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Message or description')}}
            {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'Message/description'])}}
        </div>
        <div class="form-group">
            {{Form::label('permissionValues', 'User permissions')}}
            @foreach($data['permissions']['all'] as $permission)
                <div class="form-check">
                    <input class="form-check-input" name="permissionValues[]" type="checkbox" value="{{$permission->bitwise_value}}" id="defaultCheck1" @if($data['permissions']['available'][$loop->index] == null) disabled @endif >
                    <label class="form-check-label" for="defaultCheck1">
                        {{$permission->name}}
                    </label>
                </div>
            @endforeach
        </div>
        {{Form::submit('Send Registration Key', ['class' => 'btn btn-primary'])}}
    </form>
@endsection