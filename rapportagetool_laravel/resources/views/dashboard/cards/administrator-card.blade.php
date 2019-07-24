
<small>
    <table class="table table-sm">
        <tr class="bg-light" id="licensesTitle">
            <td class="overflow-hidden">
                Settings
            </td>
        </tr>
        <tr>
            <td class="line-clamp">
                @if(\App\Http\Controllers\Services\PermissionsService::canDoWithCat('system_settings', \App\Http\Controllers\Services\PermissionsService::getPermCode('api_token_management')))
                    <a href="/passport-manager"> Manage OAuth Tokens </a>
                @endif
            </td>
        </tr>
    </table>
</small>