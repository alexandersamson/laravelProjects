<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div align="center">
                    <img alt="cover image" width="" src="{{$profilepicturesBasePath}}{{$data['category']}}/{{$data['person']->id}}/profilepicture">
                    <h5 class="card-title">{{$data['person']->name}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['person']->email}}">{{ $data['person']->email }}</a> | <a href="tel:{{$data['person']->phone}}">{{ $data['person']->phone }}</a></h6>
                    <small class="card-subtitle mb-2 text-muted">
                        @if($data['category'] == 'users' || $data['category'] == 'investigators' || $data['category'] == 'leaders')
                            @getuserroles($data['person']->permission)
                        @endif
                        @if($data['category'] == 'clients')
                            Organization: {{$data['person']->organization_id}} | City: {{$data['person']->city}}
                        @endif
                        @if($data['category'] == 'subjects')
                            Leeftijd/GD: {{$data['person']->birthday}} | Lengte: {{$data['person']->height}} cm | Huidskleur: {{$data['person']->skin}} | Ogen: {{$data['person']->eyes}}
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