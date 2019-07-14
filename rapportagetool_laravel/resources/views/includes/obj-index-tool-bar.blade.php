<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group-sm mr-3" role="group" aria-label="Navigation">
        <a title="Back to Dashboard" href="/home" class="btn btn-sm btn-outline-primary oi oi-arrow-thick-left"></a>
    </div>
    @if((new \App\Http\Controllers\Services\PermissionsService())->canDoWithCat($category, 'c'))
        <div class="btn-group-sm mr-3" role="group" aria-label="Tools">
            <a title="New" href="/{{$category}}/create" class="btn btn-sm btn-outline-success oi oi-plus"></a>
        </div>
    @endif
    <div class="btn-group-sm mr-3" role="group" aria-label="Tools">
        <a title="Copy" href="/{{$category}}" class="btn btn-sm btn-outline-secondary oi oi-clipboard"></a>
        <a title="Sort Ascending" href="/{{$category}}" class="btn btn-sm btn-outline-secondary oi oi-sort-ascending"></a>
        <a title="Sort Descending" href="/{{$category}}" class="btn btn-sm btn-outline-secondary oi oi-sort-descending"></a>
    </div>
    <form class="form-inline">
        <div class="dynamicSearchBoxHolder" id="dsbh{{$category}}">
            <div class="autocomplete">
                <input id="dynamicSearchBox{{$category}}"
                       type="search"
                       name="dynamicSearchBox{{$category}}"
                       placeholder="Search"
                       data-position="0"
                       data-category="{{$category}}"
                       data-id="dynamicSearchBox{{$category}}"
                       data-targetid="dynamicSearchBoxTarget{{$category}}"
                       class="form-control-sm mr-sm-1 dynamicSearchBox"
                       aria-label="Search">
                <input name="{{$category}}[]" id="dynamicSearchBoxTarget{{$category}}" type="hidden" value="" required>
            </div>
        </div>
    </form>
</div>


{{--Usable variables:--}}
{{--$category--}}
{{--$id--}}
{{--$name--}}