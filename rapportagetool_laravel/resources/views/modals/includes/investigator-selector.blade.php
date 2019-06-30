<h5>Assignable investigators</h5>
@if(count($data['investigators']) > 0)
    @foreach($data['investigators'] as $investigator)
            <div class="d-flex flex-row align-items-center border">
                <div class="mr-auto pl-1">
                        <a class="btn text-sm-left align-self-sm-start btn-sm btn-primary font-weight-light" href="/users/{{$investigator->id}}">{{$investigator->name}}</a>
                </div>
                <div class="p-2">
                    <small>
                        Permission: {{$investigator->permission}}<br>
                    </small>
                </div>
                <div class="pr-1">
                    <a class="btn text-sm-left align-self-sm-start btn-sm btn-primary font-weight-light selectBtnMulti" data-url="addInvestigators" data-value="{{$investigator->id}}" id="btnRadio{{$investigator->id}}" href="#}">Select this user</a>
                </div>
            </div>
    @endforeach
{{--    {{$investigator['users']->links()}}--}}
@else
    <p>No users found</p>
@endif

{{--<label class="col-md-5 control-label" for="service_status">Leading Investigator</label>--}}
{{--<div class="row">--}}
{{--    <div class="col-sm-4">--}}
{{--        <select id="select_investigator" name="select_investigator" class="form-control">--}}
{{--            @foreach($data['investigators'] as $investigator)--}}
{{--                <option value="{{$investigator->id}}" {{($investigator->id == Auth::id()) ? 'selected' : ''}}>{{$investigator->name}}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--    </div>--}}
{{--    <div class="col-sm-4">--}}
{{--        <button type="button" name="add" id="add" class="btn btn-success">Add more</button>--}}
{{--    </div>--}}
{{--</div>--}}