@extends('layouts.app')

@section('content')
    <h1>Subjects</h1>
    @if(count($data['subjects']) > 0)
        @foreach($data['subjects'] as $subject)
            <div class="card">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <p>
                            {{$subject->name}} | {{$subject->email}} | {{$subject->phone_work}}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        {{$data['subjects']->links()}}
    @else
        <p>No subjects found</p>
    @endif
@endsection

