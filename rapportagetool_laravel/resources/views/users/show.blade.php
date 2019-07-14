@extends('layouts.obj-show', ['category' => 'users','id' => $data['obj']->id,'name' => $data['obj']->name,'deleted' => $data['obj']->deleted])

@section('obj-show')
    <div class="row">
        <div class="col-lg-8 col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div align="center">
                        <img alt="cover image" width="" src="{{$profilepicturesBasePath}}users/{{$data['obj']->id}}/profilepicture">
                        <h5 class="card-title">{{$data['obj']->name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['obj']->email}}">{{ $data['obj']->email }}</a> | <a href="tel:{{$data['obj']->phone}}">{{ $data['obj']->phone }}</a></h6>
                        <small class="card-subtitle mb-2 text-muted">
                            @include('includes.snippets.permissions-snippet',['permissions' => $data['obj']->permission])
                        </small>
                    </div>
                    <p class="card-text">

                    </p>
                    @include('includes.created-by-footer')
                    @if($data['obj']->deleted)
                        <h5><span class="badge badge-danger">This user has been deleted</span></h5>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="row">
                @hasanyrole('Investigator')
                    @if(count($data['licenses']) > 0)
                        @include('users.includes.licenses')
                    @endif
                @endhasanyrole
                @if(!\App\Http\Controllers\Services\Helper::isDeleted('users', $data['obj']->id))
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div align="center">
                                    @if(auth()->user()->id == $data['obj']->id)
                                        Send a memo to <span class="text-info">yourself</span>
                                    @else
                                        Send <span class="text-info">{{$data['obj']->name}}</span> a message
                                    @endif
                                </div>
                                <hr>
                                <div class="p-1">
                                    {!! Form::open(['action' => 'MessagesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <div class="form-group">
                                        {{Form::text('title', '', ['class' => 'form-control mb-2', 'placeholder' => 'Title (optional)'])}}
                                        {{Form::textarea('body', '', ['rows' => 6, 'maxlength' => 1001, 'id' => 'message-box', 'class' => 'form-control', 'placeholder' => 'Your message (max 1000 characters)'])}}
                                    </div>
                                    {{Form::hidden('targetUser', $data['obj']->id)}}
                                    {{Form::hidden('quickSend', true)}}
                                    {{Form::submit('Send', ['class' => 'btn btn-primary'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection