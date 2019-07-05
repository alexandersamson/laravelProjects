@if(isset($cavedBtnArray))
<span class="btn-group btn-xs-table">
    @if($cavedBtnArray['c'] && !isset($c))
        <a title="Copy to new" href="/copynew/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-outline-info">&nbsp;C&nbsp;</a>
    @endif
    @if($cavedBtnArray['a'] && !isset($a))
        <a title="Approve" href="/approve/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-success">&nbsp;A&nbsp;</a>
    @endif
    @if($cavedBtnArray['v'] && !isset($v))
        <a title="View" href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}" class="btn btn-sm btn-xs-table btn-outline-primary">&nbsp;&nbsp;&nbsp;V&nbsp;&nbsp;&nbsp;</a>
    @endif
    @if($cavedBtnArray['e'] && !isset($e))
        <a title="Edit" href="/{{$cavedBtnArray['category']}}/{{$cavedBtnArray['id']}}/edit" class="btn btn-sm btn-xs-table btn-outline-secondary">&nbsp;E&nbsp;</a>
    @endif
    @if($cavedBtnArray['d'] && !isset($d))
        <a title="Delete" href="#" data-toggle="modal" data-category="{{$cavedBtnArray['category']}}" data-domid="{{$cavedBtnArray['category']}}{{$cavedBtnArray['id']}}" data-id="{{$cavedBtnArray['id']}}" data-name="{{$cavedBtnArray['name']}}" data-target="#genericDeleteModal" class="btn btn-sm btn-xs-table btn-outline-danger">&nbsp;D&nbsp;</a>
    @endif
</span>
@endif