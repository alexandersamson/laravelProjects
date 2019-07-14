
    @foreach($searchCategories as $searchCat)
        <div class="dynamicSearchBoxHolder" id="dsbh{{ucfirst($searchCat)}}">
            <div class="autocomplete">
                <label class="mb-0" for="dynamicSearchBox{{ucfirst($searchCat)}}"><small>{{$searchTitles[$loop->index]}}</small></label>
                <input  id="dynamicSearchBox{{ucfirst($searchCat)}}"
                        type="text"
                        name="dynamicSearchBox{{$searchCat}}"
                        placeholder=""
                        data-position="0"
                        data-category="{{$searchCat}}"
                        data-id="dynamicSearchBox{{ucfirst($searchCat)}}"
                        data-targetid="dynamicSearchBoxTarget{{ucfirst($searchCat)}}"
                        class="form-control dynamicSearchBox">
{{--                <button type="button" class="btn btn-primary btnDsbhAdd" id="btnDsbhAdd{{ucfirst($searchCat)}}">+</button>--}}
                <input name="{{$searchCat}}[]" id="dynamicSearchBoxTarget{{ucfirst($searchCat)}}" type="hidden" value="" required>
            </div>
        </div>
    @endforeach

