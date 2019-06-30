<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\User;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{
    public function checkPermission($permissionRequired, $userPermission = NULL, $checkAny = false){

        //First check whether or not someone is logged in
        //If no one is logged is, check if resource is available for Guests (0 permission value)
        //Return false when more than Guest permissions is required
        //This should normally be catched by proper setting of the auth middleware.
        //This extra failsafe is intended for unintended leaks and improper settings
        if(!Auth::id()){
            if($permissionRequired == 0){
                return ['permission' => true];
            }
            else {
                return ['permission' => false];
            }
        }

        //Check whether or not the userPermission parameter has been set. If it has been set manually, use that value.
        //If it's not been set, then use Auth::id()->permission value (permission of current user logged in)
        if(is_numeric ($userPermission)) {
            $userStartPermission = $userPermission;
        } else {
            $userStartPermission = User::find(Auth::id())->permission;
        }


        //The actual checkPermission method:
        $up = $userStartPermission;
        //Get highest permission value
        $startValueBitwise = Permission::orderBy('bitwise_value', 'desc')->get()[0]->bitwise_value * 2;
        $sv = $startValueBitwise;
        //Bitwise operations
        $pCounter = 0;
        while($sv >= 1){
            if($permissionRequired >= $sv){
                $permissionRequired -= $sv;
                $pCounter += 1;
                if($up >= $sv){
                    //if checkAny == true this method wil return true on the first match
                    if($checkAny == true){
                        return ['permission' => true];
                    }
                    $up -= $sv;
                    $pCounter -= 1;
                }
            } else {
                if ($up >= $sv) {
                    $up -= $sv;
                }
            }
            $sv /= 2;
        }

        //return true if all permissions matches
        if($pCounter == 0) {
            return ['permission' => true];
        }
        else{
            return ['permission' => false];
        }
    }



    //This method returns the bitwise value of a single or multiple permission name(s) passed to it
    public function getBitwiseValue($permissions){
        $pValue = 0;
        if (is_array($permissions) || is_object($permissions)) {
            foreach ($permissions as $permission) {
                $pValue += Permission::where('name', $permission)->take(1)->get()[0]->bitwise_value;
            }
        } else {
            $pValue = Permission::where('name', $permissions)->take(1)->get()[0]->bitwise_value;
        }
            return $pValue;
    }


    //Some test to test getBitwiseValue
    public function testBitwiseValue(){
        return $this->getBitwiseValue(['Guest', 'Investigator', 'Registered']); // should return 5
    }
}
