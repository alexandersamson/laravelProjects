@if(count($data['users']) > 0)
    @foreach($data['users'] as $user)
        <div id="{{$data['containerName']}}{{$user[0]->id}}">
            {{Form::hidden($data['containerName']."[]", $user[0]->id)}}
            <span  class="mb-1 btn-group btn-group-sm">
                <button type="button" id="btnInfoModal{{$data['containerName']}}{{$user[0]->id}}" class="btn btn-outline-info btnModalInfoUser" data-toggle="modal"
                        data-usertype="{{$data['containerName']}}" data-cmd="infoUser" data-url="{{$user[0]->id}}"
                        data-header="{{$user[0]->user}} | Contact details"  data-target="#genericInfoModal">@</button>
                <button type="button" class="btn btn-secondary">{{$user[0]->name}}</button>
                <button type="button" data-url="{{$data['idPrefix']}}{{$data['containerName']}}{{$user[0]->id}}" data-container="#assigneesContainerA" class="btn btn-outline-danger btnDeleteItem">&times;</button>
            </span>
            <br>
        </div>
    @endforeach
@else
    <span class="badge badge-light">Nothing selected</span>
@endif
