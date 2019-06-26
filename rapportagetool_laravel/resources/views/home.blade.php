@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    Title
                                </th>
                                <th>
                                </th>
                                <th>
                                </th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                    <th>
                                        {{$post->title}}
                                    </th>
                                    <th>
                                        <a href="/posts/{{$post->id}}/edit" class="btn btn-outline-dark">Edit</a>
                                    </th>
                                    <th>
                                        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </th>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
