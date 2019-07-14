<?php


namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\LinkMessageUser;
use App\Message;
use App\ObjectCategory;
use App\Permission;
use App\Providers\Globals;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PermissionsService extends Controller
{

    public static function checkPermission($permissionRequired, $userPermission = NULL, $checkAny = false, $gatekeeping = false){

        //First check whether or not someone is logged in
        //If no one is logged is, check if resource is available for Guests (0 permission value)
        //Return false when more than Guest permissions is required
        //This should normally be catched by proper setting of the auth middleware.
        //This extra failsafe is intended for unintended leaks and improper settings
        if(!Auth::id()){
            if($permissionRequired == 0){
                if($gatekeeping == true){
                    return true;
                }
                return ['permission' => true];
            }
            else {
                if($gatekeeping == true){
                    throw new AuthorizationException('No permission');
                } else {
                    return ['permission' => false];
                }
            }
        }

        //Check whether or not the userPermission parameter has been set. If it has been set manually, use that value.
        //If it's not been set, then use Auth::id()->permission value (permission of current user logged in)
        if(is_numeric ($userPermission)) {
            $userStartPermission = $userPermission;
        } else {
            $userStartPermission = \auth()->user()->permission;
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
                        if($gatekeeping == true){
                            return true;
                        }
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
            if($gatekeeping == true){
                return true;
            }  else {
                return ['permission' => true];
            }
        }
        else{
            if($gatekeeping == true){
                throw new AuthorizationException('No permission');
            } else {
                return ['permission' => false];
            }
        }
    }



    //This method returns the bitwise value of a single or multiple permission name(s) passed to it
    public static function getBitwiseValue($permissions){
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


    public static function getPermissionsTextArray($userPermission){
        $permissions = array();
        //Check whether or not the userPermission parameter has been set. If it has been set manually, use that value.
        //If it's not been set, then use Auth::id()->permission value (permission of current user logged in)
        if($userPermission != null) {
            $up = (integer)$userPermission;
        } else {
            $up = \auth()->user()->permission;
        }

        $permissions = array();
        //Get highest permission value
        $sv = Permission::orderBy('bitwise_value', 'desc')->get()[0]->bitwise_value * 2;
        //Bitwise operations
        $pCounter = 0;
        while($sv >= 1){
            if ($up >= $sv) {
                $up -= $sv;
                $permissions[] = Permission::where('bitwise_value', $sv)->get()[0]['name'];
            }
            $sv /= 2;
        }
        return $permissions;
    }


    //Some test to test getBitwiseValue
    public function testBitwiseValue(){
        return $this->getBitwiseValue(['Guest', 'Investigator', 'Registered']); // should return 5
    }


    protected static function canCrudPowerUser($targetuser){
        if(self::checkPermission(self::getBitwiseValue(['Owner','Administrator','Manager']), $targetuser->permission, true)['permission']){
            if(self::checkPermission(self::getBitwiseValue(['Owner']), \auth()->user()->permission, true)['permission']){
                return true;
            } else {
                return false;
            }
        }
        return true;
    }


    private static function getSelectors($crud){
        //Check the permissions
        if( $crud == 'c' ||
            $crud == 'r' ||
            $crud == 'u' ||
            $crud == 'd' ||
            $crud == 'c_adv' ||
            $crud == 'r_adv' ||
            $crud == 'u_adv' ||
            $crud == 'd_adv'
        ){
            $selectors = array(
                'permCreator' => $crud.'_by_creator',
                'permByRole' =>  $crud.'_permission',
                'matches' =>     $crud.'_match_all');
            return $selectors;
        } else {
            return ([]);
        }
    }


    //uses permissions rights
    //from ObjectCategory model
    public static function canDoWithObj($category, $id, $crud = 'r', $checkDeletion = true, $checkCrudPowerUser = true){

        //Check if object has been deleted
        if($checkDeletion == true){
            if(Helper::isDeleted($category, $id) == true){
                return false;
            }
        }

        //Check if object is a user and this user is one's self
        //Users cannot delete themselves
        if($category == 'users' && $crud == 'd'){
            if($id == auth()->user()->id){
                return false;
            }
            //Allow to edit own profiles however
        } else if($id == auth()->user()->id && $crud == 'u'){
            return true;
        }

        //Check if $crud has a valid CRUD-command and if so, pupulate the db column selectors
        $selector = self::getSelectors($crud);
        if($selector ==  null){
            return false;
        }

        $classNameService = new ClassNameService;
        $obj = $classNameService->getClassByCategory($category, false, $id);
        $objCat = ObjectCategory::where('name', $category)->first();
        $curUsrPerm = \auth()->user()->permission;

        //check if user is trying to crud an higher tier user profile
        //for other reasons than just a read request
        if($category == 'users' && $crud != 'r')
        {
            if(!self::canCrudPowerUser($obj)){
                return false;
            }
        }

        if(isset($obj->creator_id)) {
            if ($obj->creator_id == auth()->user()->id && $crud != 'c') {
                if ($objCat->{$selector["permCreator"]}) {
                    return true;
                }
            }
        }

        if (self::checkPermission($objCat->{$selector['permByRole']}, $curUsrPerm, !$objCat->{$selector['matches']}, false)['permission']) {
                return true;
        }
        return false;
    }


    public static function canDoWithCat($category, $crud){

        //Check if $crud has a valid CRUD-command and if so, pupulate the db column selectors
        $selector = self::getSelectors($crud);
        if($selector ==  null){
            return false;
        }

        $categories = Config::get('categories');
        $category = $categories[$category];

        $objCat = ObjectCategory::where('name', $category)->first();
        $curUsrPerm = \auth()->user()->permission;

        if (self::checkPermission($objCat->{$selector['permByRole']}, $curUsrPerm, !$objCat->{$selector['matches']}, false)['permission']) {
            return true;
        }
        return false;

    }

    public static function canReadMessage($messageId, $markAsRead = false){
        $link = new LinkMessageUser();
        $user = User::find(auth()->user()->id);
        $result = $link::where('user_id',$user->id)->where('message_id',$messageId)->first();
        if($result){
            if($markAsRead == true){
                $result->marked_as_read = true;
                $result->save();
            }
            return true;
        }
        if(self::canDoWithObj('messages', $messageId, 'r_adv', true, true)){
            return true;
        }
        return false;
    }

    public static function canEraseObj($cat, $id, $crud){
        if(self::canDoWithObj($cat, $id, $crud, false, true)){
            if(Helper::isDeleted($cat, $id) == true){
                if($cat == "messages"){
                    return true;
                }
            }
        }
        return false;
    }
}