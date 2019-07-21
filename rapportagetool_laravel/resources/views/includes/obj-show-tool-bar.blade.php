<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group-sm mr-3" role="group" aria-label="Navigation">
        <a title="Back to {{$category}}" href="/{{$category}}" class="btn btn-sm btn-outline-primary oi oi-arrow-thick-left"></a>
    </div>
    @if((new \App\Http\Controllers\Services\Helper)->needsApproval($category, $id))
        @if((new \App\Http\Controllers\Services\PermissionsService())->canDoWithObj($category, $id, 'u_adv'))
            <div class="btn-group-sm mr-3" role="group" aria-label="Approval">
                <a title="Approve" href="/approval/{{$category}}/{{$id}}/approve" class="btn btn-sm btn-success oi oi-check"></a>
                <a title="Dismiss" href="/approval/{{$category}}/{{$id}}/dismiss" class="btn btn-sm btn-danger oi oi-x"></a>
            </div>
        @endif
    @endif
    @if(!\App\Http\Controllers\Services\Helper::isDeleted($category, $id))
    <div class="btn-group-sm mr-3" role="group" aria-label="Tools">
        <a title="Generate printable PDF-file" href="/to-pdf/{{$category}}/{{$id}}" class="btn btn-sm btn-outline-secondary oi oi-print"></a>
        <a title="Copy '{{$name}}'"
           id = "btnCopyId"
           href="#"
           class="btn btn-sm btn-outline-secondary oi oi-layers btnClipboard"
           data-clipboard-return-id-target="btnCopyId"
           data-clipboard-text = "{{$name}}"></a>
        @if($category == 'users')
            <a title="Send a message to {{$name}}" href="#" class="btn btn-sm btn-outline-secondary oi oi-chat"></a>
        @endif
        @if(\App\Http\Controllers\Services\PermissionsService::canDoWithObj($category, $id, 'u', true))
            <a title="Edit {{$name}}" href="/{{$category}}/{{$id}}/edit" class="btn btn-sm btn-outline-secondary oi oi-cog"></a>
        @endif
    </div>
    @endif
    <div class="btn-group-sm" role="group" aria-label="Advanced Tools">
        @if(!\App\Http\Controllers\Services\Helper::isDeleted($category, $id))
            @if(\App\Http\Controllers\Services\PermissionsService::canDoWithObj($category, $id, 'd', false))
                <a title="Delete {{$name}}" href="#"
                   data-toggle="modal"
                   data-category="{{$category}}"
                   data-domid="{{$category.$id}}"
                   data-id="{{$id}}"
                   data-name="{{$name}}"
                   data-target="#genericDeleteModal"
                   class="btn btn-sm btn-outline-danger oi px-2 oi-circle-x">
                </a>
            @endif
        @else
            @if(\App\Http\Controllers\Services\PermissionsService::canDoWithObj($category, $id, \App\Http\Controllers\Services\PermissionsService::getPermCode('recover'), false))
                <a title="Recover {{$name}}" href="#"
                   data-toggle="modal"
                   data-category="{{$category}}"
                   data-domid="{{$category.$id}}"
                   data-id="{{$id}}"
                   data-name="{{$name}}"
                   data-target="#genericRecoverModal"
                   class="btn btn-sm btn-success oi oi-arrow-circle-bottom">
                </a>
                @if(\App\Http\Controllers\Services\PermissionsService::canEraseObj($category, $id, \App\Http\Controllers\Services\PermissionsService::getPermCode('erase')))
                       <a title="Permanently erase {{$name}}" href="#"
                       data-toggle="modal"
                       data-category="{{$category}}"
                       data-domid="{{$category.$id}}"
                       data-id="{{$id}}"
                       data-name="{{$name}}"
                       data-target="#genericEraseModal"
                       class="btn btn-sm btn-danger oi oi-delete">
                       </a>
                @endif
            @endif
        @endif
    </div>
</div>

{{--Usable variables:--}}
{{--$category--}}
{{--$id--}}
{{--$name--}}