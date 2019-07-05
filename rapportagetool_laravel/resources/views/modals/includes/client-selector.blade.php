<h5>Assignable clients</h5>
@if(count($data['clients']) > 0)
    @foreach($data['clients'] as $client)
        <div class="d-flex flex-row align-items-center border">
            <div class="mr-auto pl-1">
                <a class="btn text-sm-left align-self-sm-start btn-sm btn-primary font-weight-light" href="/users/{{$client->id}}">{{$client->name}}</a>
            </div>
            <div class="p-2">
                <small>
                    Permission: {{$client->permission}}<br>
                </small>
            </div>
            <div class="pr-1">
                <a class="btn text-sm-left align-self-sm-start btn-sm btn-primary font-weight-light selectBtnMulti" data-url="addClients" data-value="{{$client->id}}" id="btnRadio{{$client->id}}" href="#">Select this user</a>
            </div>
        </div>
    @endforeach
    {{--    {{$client['users']->links()}}--}}
@else
    <p>No users found</p>
@endif

{{--<label class="col-md-5 control-label" for="service_status">Leading client</label>--}}
{{--<div class="row">--}}
{{--    <div class="col-sm-4">--}}
{{--        <select id="select_client" name="select_client" class="form-control">--}}
{{--            @foreach($data['clients'] as $client)--}}
{{--                <option value="{{$client->id}}" {{($client->id == Auth::id()) ? 'selected' : ''}}>{{$client->name}}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--    </div>--}}
{{--    <div class="col-sm-4">--}}
{{--        <button type="button" name="add" id="add" class="btn btn-success">Add more</button>--}}
{{--    </div>--}}
{{--</div>--}}