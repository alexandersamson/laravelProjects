@if(isset($cavedBtnArray))
<span class="btn-group btn-xs-table">
    @if($cavedBtnArray['a'] && $cavedBtnArray['a_show'] && !isset($a))
        <a title="Approve" href="/approval/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}/approve" class="btn btn-sm btn-xs-table btn-success oi oi-check"></a>
        <a title="Dismiss" href="/approval/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}/dismiss" class="btn btn-sm btn-xs-table btn-danger oi oi-minus"></a>
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
    @if($cavedBtnArray['p'] && !isset($p))
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