<div class="col-lg-12 col-md-12">
    <div class="card mb-3">
        <div class="card-body">
            <div align="center">
                @if(auth()->user()->id == $data['user']->id)
                    Your licenses
                @else
                    Licenses of <span class="text-info">{{$data['user']->name}}</span>
                @endif
            </div>
            <hr>
            <div class="p-1">
                @foreach($data['licenses'] as $license)
                    <div class="card pl-1 pr-1 mb-2
                        @if($license->status == 'in use' && $license->active == true)
                            border-success bg-succes-light text-dark
                        @else
                            border-warning bg-warning-light text-dark
                        @endif
                    ">
                        <div class="p-2 align-self-center fixed-width-100">
                            <img class="img-fluid" alt="ID Card" width="" src="{{$profilepicturesBasePath}}licenses/{{$license->id}}/profilepicture">
                        </div>
                        {{$license->name}}<br>
                        Type: {{$license->type}}<br>
                        Expires in: {{(new \App\Http\Controllers\Services\Helper)->getDaysLeft($license->valid_to)}}<br>
                        Status: {{$license->status}}<br>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>