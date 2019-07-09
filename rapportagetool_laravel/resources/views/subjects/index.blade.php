@extends('layouts.obj-index', ['category' => 'subjects'])

@section('obj-index')
    @if(count($data['objs']) > 0)
        @foreach($data['objs'] as $subject)
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
        {{$data['objs']->links()}}
    @else
        <p>No subjects found</p>
    @endif
@endsection

