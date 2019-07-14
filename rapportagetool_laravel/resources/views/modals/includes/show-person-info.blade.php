<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div align="center">
                    @if($data['category'] == 'casefiles')
                        @include('includes.snippets.qrCode',['casecode'=>$data['obj']->casecode])
                    @else
                        <img alt="cover image" width="" src="{{$profilepicturesBasePath}}{{$data['category']}}/{{$data['obj']->id}}/profilepicture">
                    @endif
                    <h5 class="card-title">{{$data['obj']->name}}</h5>
                    @if($data['category'] == 'users' || $data['category'] == 'investigators' || $data['category'] == 'leaders')
                        <h6 class="card-subtitle mb-2 text-muted"><a href="mailto:{{$data['obj']->email}}">{{ $data['obj']->email }}</a> | <a href="tel:{{$data['obj']->phone}}">{{ $data['obj']->phone }}</a></h6>
                    @endif
                    <small class="card-subtitle mb-2 text-muted">
                        @if($data['category'] == 'users' || $data['category'] == 'investigators' || $data['category'] == 'leaders')
                            @include('includes.snippets.permissions-snippet',['permissions' => $data['obj']->permission])
                        @endif
                        @if($data['category'] == 'clients')
                            Organisatie: {{$data['obj']->organization_id}} | Stad: {{$data['obj']->city}}
                        @endif
                        @if($data['category'] == 'subjects')
                            Leeftijd/GD: {{$data['obj']->birthday}} | Lengte: {{$data['obj']->height}} cm | Huidskleur: {{$data['obj']->skin}} | Ogen: {{$data['obj']->eyes}}
                        @endif
                        @if($data['category'] == 'casefiles')
                            {{$data['obj']->description}}<br>
                        @endif
                         @if($data['category'] == 'posts')
                                {!!\App\Http\Controllers\Services\Helper::parseBB($data['obj']->body)!!}<br>
                         @endif
                    </small>
                </div>
                <p class="card-text">

                </p>
                @include('includes.created-by-footer')
            </div>
        </div>
    </div>
</div>