<div class="row m-0 p-0">
    @foreach($searchCategories as $searchCat)
        <div class="col-lg-3 col-md-4 col-sm-6 m-0 p-0">
            <div class="card m-1 p-2">
                <div class="card-body m-0 p-0">
{{--                    <h5 class="card-title">Special title treatment</h5>--}}
                    <objects-selector :source-cat="'{{$sourceCat}}'" :source-id="'{{$sourceId}}'" :target-cat="'{{$searchCat}}'"></objects-selector>
                </div>
            </div>
        </div>
    @endforeach
</div>