@extends('layouts.obj-index', ['category' => 'clients'])

@section('obj-index')
    @if(count($data['objs']) > 0)
        @foreach($data['objs'] as $client)
            <div class="card">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <p>
                            {{$client->name}} | {{$client->email}} | {{$client->phone_work}}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        {{$data['objs']->links()}}
    @else
        <p>No clients found</p>
    @endif
@endsection