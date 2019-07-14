
    @foreach($searchCategories as $searchCat)
        <div class="dynamicSearchBoxHolder mr-2" id="dsbh{{ucfirst($searchCat)}}">
            <div class="autocomplete">
                <label class="mb-0" for="dynamicSearchBox{{ucfirst($searchCat)}}"><small>{{$searchTitles[$loop->index]}}</small></label>
                <div data-sourcecat="{{$sourceCat}}"
                     data-sourceid="{{$sourceId}}"
                     data-targetcat="{{$searchCat}}"
                     data-targetid="sbic{{$searchCat}}"
                     class="searchBoxItemsContainer" id="sbic{{$searchCat}}">
                </div>
                @if(\App\Http\Controllers\Services\PermissionsService::canDoWithCat($searchCat, 'r') && \App\Http\Controllers\Services\PermissionsService::canDoWithObj($sourceCat, $sourceId, 'u_adv', true))
                <input  id="dynamicSearchBox{{ucfirst($searchCat)}}"
                        type="text"
                        name="dynamicSearchBox{{$searchCat}}"
                        placeholder="@if($searchCat == 'leaders') Change Lead Investigator @else Add {{ucfirst($searchCat)}} @endif"
                        data-variant="addToList"
                        data-source="{{$sourceCat}}"
                        data-sourceid="{{$sourceId}}"
                        data-permissionfilter="{{$searchPermissionFilters[$loop->index]}}"
                        data-category="{{$searchCat}}"
                        data-id="dynamicSearchBox{{ucfirst($searchCat)}}"
                        data-targetid="sbic{{$searchCat}}"
                        class="form-control dynamicSearchBox"
                        autocomplete="off">
                @endif
{{--                <button type="button" class="btn btn-primary btnDsbhAdd" id="btnDsbhAdd{{ucfirst($searchCat)}}">+</button>--}}
                <input name="{{$searchCat}}[]" id="dynamicSearchBoxTarget{{ucfirst($searchCat)}}" type="hidden" value="" required>
            </div>
        </div>

    @endforeach

