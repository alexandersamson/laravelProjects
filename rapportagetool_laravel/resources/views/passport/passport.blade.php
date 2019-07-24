@extends('layouts.app')

@section('content')
    <h3>Passport manager - OAuth tokens</h3>
    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>
@endsection