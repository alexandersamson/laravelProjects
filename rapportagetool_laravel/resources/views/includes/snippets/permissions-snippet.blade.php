@foreach (\App\Http\Controllers\Services\PermissionsService::getPermissionsTextArray($permissions) as $role)
    @if(!$loop->first)
        |&nbsp;
    @endif
    {{$role}}
@endforeach