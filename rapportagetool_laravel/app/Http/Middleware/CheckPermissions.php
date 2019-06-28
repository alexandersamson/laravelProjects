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
    public function handle($request, Closure $next, ...$permissions)
    {
        $permissionCheck = new PermissionsController;
        $result = $permissionCheck->checkPermission($permissionCheck->getBitwiseValue($permissions));
        if($result[0]['permission'] == false){
            throw new AuthorizationException('No permission');
        }
        return $next($request);
    }
}
