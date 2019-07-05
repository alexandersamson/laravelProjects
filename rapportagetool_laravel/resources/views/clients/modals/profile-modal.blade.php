<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div align="center">
                    <img alt="cover image" width="" src="/images/profilepicture/clients/{{$data['client']->id}}/profilepicture">
                    <h5 class="card-title">{{$data['client']->name}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['client']->email}}">{{ $data['client']->email }}</a> | <a href="tel:{{$data['client']->phone}}">{{ $data['client']->phone }}</a></h6>
                    <small class="card-subtitle mb-2 text-muted">
                        @if((new\App\Http\Controllers\PermissionsController)->getPermissionsTextArray($data['client']->permission) > 0)
                            @foreach((new\App\Http\Controllers\PermissionsController)->getPermissionsTextArray($data['client']->permission) as $permission)
                                @if (!$loop->first)
                                    |&nbsp;
                                @endif
                                <span class="text-dark">{{$permission}}</span>
                            @endforeach
                        @endif
                    </small>
                </div>
                <p class="card-text">

                </p>
                {{--                @include('includes.created-by-footer')--}}
            </div>
        </div>
    </div>
</div>