@extends('layouts.app')

@section('content')
    <h1>Clients</h1>
    @if(count($data['clients']) > 0)
        @foreach($data['clients'] as $client)
            <div class="card">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <p>
                            {{$client->name}} | {{$client->email}} | {{$client->phone_work}}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        {{$data['clients']->links()}}
    @else
        <p>No clients found</p>
    @endif
@endsection