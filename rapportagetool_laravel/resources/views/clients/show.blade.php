@extends('layouts.obj-show', ['category' => 'clients','id' => $data['obj']->id,'name' => $data['obj']->name])

@section('obj-show')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div align="center">
                        <img alt="cover image" width="" src="{{$profilepicturesBasePath}}clients/{{$data['obj']->id}}/profilepicture">
                        <h5 class="card-title">{{$data['obj']->name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['obj']->email}}">{{ $data['obj']->email }}</a> | <a href="tel:{{$data['obj']->phone}}">{{ $data['obj']->phone }}</a></h6>
                        <small class="card-subtitle mb-2 text-muted">
                            Small Clients info
                        </small>
                    </div>
                    <p class="card-text">

                    </p>
                    @if($data['obj']->deleted)
                        <h5><span class="badge badge-danger">This client has been deleted</span></h5>
                    @endif
                    @include('includes.created-by-footer')
                </div>
            </div>
        </div>
    </div>


@endsection