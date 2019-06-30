<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\PermissionsController;
use Illuminate\Auth\Access\AuthorizationException;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $checkAny = 'matchAll', ...$permissions)
    {
        if($checkAny == 'matchOne'){
            $checkAnyCmd = true;
        } else {
            $checkAnyCmd = false;
        }
        $permissionCheck = new PermissionsController;
        $result = $permissionCheck->checkPermission($permissionCheck->getBitwiseValue($permissions), NULL, $checkAnyCmd);
        if($result['permission'] == false){
            throw new AuthorizationException('No permission');
        }
        return $next($request);
    }
}
