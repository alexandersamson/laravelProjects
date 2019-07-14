@if(count($data['objs']) > 0)
    @foreach($data['objs'] as $person)
        <div id="{{$data['category']}}{{$person->id}}">
            {{Form::hidden($data['category']."[]", $person->id)}}
            <span  class="mb-1 btn-group btn-group-sm btn-xs-div pt-0">
                <button type="button" id="btnInfoModal{{$data['category']}}{{$person->id}}"
                        class="btn btn-outline-info btn-sm btn-xs-div pt-0 btnModalInfoUser"
                        title="Quick view {{$person->name}}"
                        data-toggle="modal"
                        data-category="{{$data['category']}}"
                        data-cmd="infoUser"
                        data-url="{{$person->id}}"
                        data-header="{{$person->name}} | Contact details"
                        data-target="#genericInfoModal"
                >
                    @
                </button>
                <button type="button" class="btn btn-secondary btn-sm btn-xs-div pt-0">
                    <small>{{\Illuminate\Support\Str::limit($person->name, 20)}}</small>
                </button>
                @if((\App\Http\Controllers\Services\PermissionsService::canDoWithObj($data['sourceCat'], $data['sourceId'], 'u') && $data['category'] != "leaders"))
                <button type="button"
                        data-objid="{{$person->id}}"
                        data-category="{{$data['category']}}"
                        data-container="{{$data['category']}}"
                        data-sourceid="{{$data['sourceId']}}"
                        data-sourcecat="{{$data['sourceCat']}}"
                        title="Remove {{$person->name}}"
                        class="btn btn-outline-danger btn-sm btn-xs-div pt-0 pl-1 pr-1 btnDeleteItem"
                >
                    &times;
                </button>
                @endif
            </span>
            <br>
        </div>
    @endforeach
@else
{{--    <span class="badge badge-light font-weight-light text-muted">Nothing selected</span>--}}
@endif
