<div class="col-lg-12 col-md-12">
    <div class="card mb-3">
        <div class="card-body">
            <div align="center">
                @if(auth()->user()->id == $data['obj']->id)
                    Your licenses
                @else
                    Licenses of <span class="text-info">{{$data['obj']->name}}</span>
                @endif
            </div>
            <hr>
            <div class="p-1">
                <div class="container">
                    <div class="row">
                        @foreach($data['licenses'] as $license)
                            <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 p-0 m-0">
                                <div class="card ml-md-1 ml-xs-0 mr-xs-0 ml-lg-0 mr-lg-0 mr-md-1 ml-sm-1 mr-sm-1 pl-1 pr-1 mb-3
                                    @if($license->status == 'in use' && $license->active == true)
                                        border-warning bg-warning-light text-dark
                                    @else
                                        border-danger bg-danger-light text-dark
                                    @endif
                                ">
                                    <div class="p-2 align-self-center fixed-width-75">
                                        <img class="img-fluid" alt="ID Card" width="" src="{{$profilepicturesBasePath}}licenses/{{$license->id}}/profilepicture">
                                    </div>
                                    {{$license->name}}<br>
                                    Type: {{$license->type}}<br>
                                    Expires in: {{(new \App\Http\Controllers\Services\Helper)->getDaysLeft($license->valid_to)}}<br>
                                    Status: {{$license->status}}<br>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>