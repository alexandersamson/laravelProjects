@if(count($users) > 0)
        @foreach($users as $user)
            <span class="mb-1 btn-group btn-group-sm">
                <button type="button" id="LeadInv{{$user[0]->id}}" class="btn btn-outline-info" data-toggle="modal"
                        data-save="null" data-cmd="infoClient" data-url="{{$user[0]->id}}"
                        data-header="{{$user[0]->user}} | Contact details"  data-target="#genericInfoModal">@</button>
                <button type="button" class="btn btn-secondary">{{$user[0]->name}}</button>
                <button type="button" class="btn btn-outline-danger">&times;</button>
            </span><br>
        @endforeach
@endif
