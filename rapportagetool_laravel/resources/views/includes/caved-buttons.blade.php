@if(isset($cavedBtnArray))
<span class="btn-group btn-xs-table">
    @if($cavedBtnArray['a'] && $cavedBtnArray['a_show'] && !isset($a))
        <a title="Approve" href="/approve/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-success">&nbsp;A&nbsp;</a>
        <a title="Deny" href="/deny/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-danger">&nbsp;X&nbsp;</a>
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
           data-cmd="infoUser"
           data-url="{{$cavedBtnArray['id']}}"
           data-header="{{$cavedBtnArray['name']}}"
           data-target="#genericInfoModal">
            &nbsp;V&nbsp;
        </a>
    @endif
    @if($cavedBtnArray['v'] && !isset($o))
        <a title="Open" href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-outline-primary">&nbsp;O&nbsp;</a>
    @endif
    @if($cavedBtnArray['p'] && !isset($a))
        <a title="Append" href="/append/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-outline-success">&nbsp;+&nbsp;</a>
    @endif
    @if($cavedBtnArray['e'] && !isset($e))
        <a title="Edit" href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}/edit" class="btn btn-sm btn-xs-table btn-outline-secondary">&nbsp;E&nbsp;</a>
    @endif
    @if($cavedBtnArray['d'] && !isset($d))
        <a title="Delete" href="#" data-toggle="modal" data-category="{{$cavedBtnArray['category']}}" data-domid="{{$cavedBtnArray['category']}}{{$cavedBtnArray['id']}}" data-id="{{$cavedBtnArray['id']}}" data-name="{{$cavedBtnArray['name']}}" data-target="#genericDeleteModal" class="btn btn-sm btn-xs-table btn-outline-danger">&nbsp;D&nbsp;</a>
    @endif
</span>
@endif