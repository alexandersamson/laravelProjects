<tr class="bg-light" id="licensesTitle">
    @foreach(\App\Http\Controllers\Services\Helper::getObjRowTitles($category) as $col)
        <td class="@if($loop->index > 2)d-none d-lg-table-cell @elseif($loop->index == 2)d-none d-sm-table-cell @endif">
            {{$col}}
        </td>
    @endforeach
</tr>