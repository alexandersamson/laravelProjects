@if(count($data['persons']) > 0)
    @foreach($data['persons'] as $person)
        <div id="{{$data['category']}}{{$person[0]->id}}">
            {{Form::hidden($data['category']."[]", $person[0]->id)}}
            <span  class="mb-1 btn-group btn-group-sm">
                <button type="button" id="btnInfoModal{{$data['category']}}{{$person[0]->id}}" class="btn btn-outline-info btnModalInfoUser" data-toggle="modal"
                        data-category="{{$data['category']}}" data-cmd="infoUser" data-url="{{$person[0]->id}}"
                        data-header="{{$person[0]->name}} | Contact details"  data-target="#genericInfoModal">@</button>
                <button type="button" class="btn btn-secondary">{{$person[0]->name}}</button>
                <button type="button" data-url="{{$data['idPrefix']}}{{$data['category']}}{{$person[0]->id}}" data-container="#assigneesContainerA" class="btn btn-outline-danger btnDeleteItem">&times;</button>
            </span>
            <br>
        </div>
    @endforeach
@else
    <span class="badge badge-light">Nothing selected</span>
@endif
