@if(isset($cavedBtnArray))
<span class="btn-group btn-xs-table">
    @if($cavedBtnArray['a'] && $cavedBtnArray['a_show'] && !isset($a))
        <a title="Approve" href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table text-dark border-dark btn-warning">&nbsp;A&nbsp;</a>
    @elseif(\App\Http\Controllers\Services\Helper::needsApproval($cavedBtnArray['category'],$cavedBtnArray['id']))
        <a title="Waiting for approval" href="#" data-title="Waiting for approval" class="btn btn-sm btn-xs-table btn-warning border-dark disabled">A</a>
    @endif
    @if((\App\Http\Controllers\Services\Helper::isDraft($cavedBtnArray['category'],$cavedBtnArray['id'])))
        <a title="This is a draft" href="#" data-title="This is a draft" class="btn btn-sm btn-xs-table btn-primary border-dark disabled">D</a>
    @endif
    @if($cavedBtnArray['c'] && !isset($c))
        <a title="Copy to new" href="/copynew/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-outline-info">&nbsp;&nbsp;C&nbsp;&nbsp;</a>
    @endif
    @if($cavedBtnArray['v'] && !isset($v))
        <a id="btnInfoModal{{$cavedBtnArray['category']}}{{$cavedBtnArray['id']}}"
           title="Quick View"
           href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}"
           class="btn btn-sm btn-xs-table btn-outline-primary btnModalInfoUser"
           data-toggle="modal"
           data-category="{{$cavedBtnArray['category']}}"
           data-cmd="infoObj"
           data-url="{{$cavedBtnArray['id']}}"
           data-header="{{$cavedBtnArray['name']}}"
           data-target="#genericInfoModal">
            &nbsp;V&nbsp;
        </a>
    @endif
    @if($cavedBtnArray['v'] && !isset($o))
        <a title="Open" href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-outline-primary">&nbsp;O&nbsp;</a>
    @endif
    @if($cavedBtnArray['p']
    && !isset($p)
    && !(\App\Http\Controllers\Services\Helper::needsApproval($cavedBtnArray['category'],$cavedBtnArray['id']))
    && !(\App\Http\Controllers\Services\Helper::isDraft($cavedBtnArray['category'],$cavedBtnArray['id'])))
            <a id="btnAppendModal{{$cavedBtnArray['category']}}{{$cavedBtnArray['id']}}"
               title="Append to this"
               href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}"
               class="btn btn-sm btn-xs-table btn-outline-success btnModalAppend"
               data-toggle="modal"
               data-category="{{$cavedBtnArray['category']}}"
               data-cmd="appendToObj"
               data-url="{{$cavedBtnArray['id']}}"
               data-header="{{$cavedBtnArray['name']}}"
               data-target="#genericAppendModal">
            &nbsp;A&nbsp;
        </a>
    @endif
    @if($cavedBtnArray['e'] && !isset($e))
        <a title="Edit" href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}/edit" class="btn btn-sm btn-xs-table btn-outline-secondary">&nbsp;E&nbsp;</a>
    @endif
    @if($cavedBtnArray['d'] && !isset($d))
        <a title="Delete" href="#" data-toggle="modal" data-category="{{$cavedBtnArray['category']}}" data-domid="{{$cavedBtnArray['category']}}{{$cavedBtnArray['id']}}" data-id="{{$cavedBtnArray['id']}}" data-name="{{$cavedBtnArray['name']}}" data-target="#genericDeleteModal" class="btn btn-sm btn-xs-table btn-outline-danger">&nbsp;D&nbsp;</a>
    @endif
</span>
@endif