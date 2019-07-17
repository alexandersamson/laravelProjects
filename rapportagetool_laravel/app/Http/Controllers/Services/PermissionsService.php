<?php


namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\LinkMessageUser;
use App\ObjectCategory;
use App\Permission;
use App\User;
use Eloquent;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
/**
 * PermissionsService (Service Helper)
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class PermissionsService extends Controller
{

    public static function getPermCode($name){

        $permCodes = array
        (
            'create' => 'c',
            'create_user' => 'c',
            'create_manager' => 'c_adv',
            'create_owner' => 'c_max',
            'read' => 'r',
            'read_unapproved' => 'r_adv',
            'read_draft' => 'r_adv',
            'read_detail' => 'r_adv',
            'read_classified' => 'r_max',
            'update' => 'u',
            'update_user' => 'u',
            'update_manager' => 'u_adv',
            'update_owner' => 'u_max',
            'append' => 'u',
            'update_unapproved' => 'u_adv',
            'update_draft' => 'u_adv',
            'update_detail' => 'u_adv',
            'update_classified' => 'u_max',
            'approve' => 'c_adv',
            'dismiss' => 'c_adv',
            'delete' => 'd',
            'delete_user' => 'd_adv',
            'delete_manager' => 'd_adv',
            'delete_owner' => 'd_max',
            'recover' => 'd_adv',
            'restore' => 'd_max',
            'erase' => 'd_max',
        );
        return $permCodes[$name];
    }


    public static function checkPermission($permissionRequired, $userPermission = NULL, $checkAny = false, $gatekeeping = false){

        $permitted = false;

        //Check whether or not the userPermission parameter has been set. If it has been set manually, use that value.
        //If it's not been set, then use Auth::id()->permission value (permission of current user logged in)
        if(is_numeric ($userPermission)) {
            $userStartPermission = $userPermission;
        } else {
            $userStartPermission = \auth()->user()->permission;
        }

        //Check whether or not someone is logged in
        //If no one is logged is, check if resource is available for Guests (0 permission value)
        //Return false when more than Guest permissions is required
        //This should normally be catched by proper setting of the auth middleware.
        //This extra failsafe is intended for unintended leaks and improper settings
        if(!Auth::id()){
            if($permissionRequired == 0){
                $permitted = true;
            }
            else {
                $permitted = false;
            }
        } else {
            $bwVal = ($permissionRequired & $userStartPermission);
            if ($bwVal == 0 || ($bwVal != $permissionRequired && $checkAny == false)) {
                $permitted = false;
            } else {
                $permitted = true;
            }
        }

        if($gatekeeping == true){
            if($permitted == true) {
                return true;
            }
            throw new AuthorizationException('No permission');
        }
        return ['permission' => $permitted];
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
        if(self::checkPermission(self::getBitwiseValue(['Owner','Casemanager','Administrator','Manager']), $targetuser->permission, true)['permission']){
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
            $crud == 'd_adv' ||
            $crud == 'c_max' ||
            $crud == 'r_max' ||
            $crud == 'u_max' ||
            $crud == 'd_max'
        ){
            $selectors = array(
                'permCreator' => $crud.'_by_creator',
                'permAssigned' => $crud.'_by_assigned_user',
                'permByRole' =>  $crud.'_permission',
                'matches' =>     $crud.'_match_all');
            return $selectors;
        } else {
            return ([]);
        }
    }


    //uses permissions rights
    //from ObjectCategory model
    public static function canDoWithObj($category, $id, $crud = 'r', $checkDeletion = true, $checkCrudPowerUser = true)
    {

        $curUsrId = auth()->user()->id;
        $curUsrPerm = \auth()->user()->permission;

        //Check if object has been deleted
        if ($checkDeletion == true) {
            if (Helper::isDeleted($category, $id) == true) {
                //echo "<script>console.log('\$ps: special_access>is_deleted>true>[false]');</script>";
                return false;
            }
        }

        //Check if object is a user and this user is one's self
        //Users cannot delete themselves
        if ($category == 'users' && $crud == 'd') {
            if ($id == $curUsrId) {
                return false;
            }
            //Allow to edit own profiles however
        } else if ($id == $curUsrId && $crud == 'u') {
            //echo "<script>console.log('\$ps: special_access>own_profile>[true]');</script>";
            return true;
        }

        //Check if $crud has a valid CRUD-command and if so, pupulate the db column selectors
        $selector = self::getSelectors($crud);
        if ($selector == null) {
            //echo "<script>console.log('\$ps: error>no_valid_CRUD-command>[false]');</script>";
            return false;
        }

        $cns = new ClassNameService;
        $obj = $cns->getClassByCategory($category, false, $id);
        $objCat = ObjectCategory::where('name', $category)->first();


        //check if user is trying to crud an higher tier user profile
        //for other reasons than just a read request
        if ($category == 'users' && $crud != 'r') {
            if (!self::canCrudPowerUser($obj)) {
                //echo "<script>console.log('\$ps: special_access>higher_tier_user>true>[false]');</script>";
                return false;
            }
        }

        //Check if the user is the creator of the item and whether the user can access his or her own items
        if (isset($obj->creator_id)) {
            if ($obj->creator_id == $curUsrId) {
                if ($objCat->{$selector["permCreator"]}) {
                    //echo "<script>console.log('\$ps: special_access>by_creator>[true]');</script>";
                    return true;
                }
            }
        }

        //Check if the user is assigned to the item and whether that user can access his or her own items
        if($category == 'casefiles' || $category == 'users') {
            if ($objCat->{$selector['permAssigned']} == true) {
                $objLinkArray = $cns->getClassByAssigneeCategory($category,'users');
                if($category == 'users'){
                    if($curUsrId == $obj->id){
                        //echo "<script>console.log('\$ps: users>assigned>[true]');</script>";
                        return true;
                    }
                }
                if($category == 'casefiles'){
                    $result = $objLinkArray['class']::where('user_id', '=', $curUsrId)
                        ->where('casefile_id', '=', $obj->id)
                        ->first();
                    if($result){
                        //echo "<script>console.log('\$ps: casefiles>assigned>[true]');</script>";
                        return true;
                    }
                }
            }
        }

        //Check if user has r_adv_permission, and if not, check if the object is in draft.
        if (!self::checkPermission($objCat->r_adv_permission, $curUsrPerm, !$objCat->{$selector['matches']}, false)['permission']){
            if (Helper::isDraft($category, $id) == true) {
                //echo "<script>console.log('\$ps: special_access>obj_is_draft>r_adv_permission>false>[false]');</script>";
                return false;
            }
        }

        if (self::checkPermission($objCat->{$selector['permByRole']}, $curUsrPerm, !$objCat->{$selector['matches']}, false)['permission']) {
            //echo "<script>console.log('\$ps: general_access>by_category_permission>[true]');</script>";
                return true;
        }

        //echo "<script>console.log('\$ps: general_access>no_validitation>[false]');</script>";
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
        $usrId = auth()->user()->id;
        $result = $link::where('user_id',$usrId)->where('message_id',$messageId)->first();
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

    public static function getSettablePermissions(){
        $usrPerm = auth()->user()->permission;
        $permissions = Permission::orderBy('bitwise_value', 'asc')->get();
        $all = array();
        $available = array();
        foreach($permissions as $permission){
            if($permission->tier == 3 && self::checkPermission(self::getBitwiseValue(['owner']), $usrPerm, true)['permission']){
                $available[] = $permission;
            } elseif($permission->tier == 2 && self::checkPermission(self::getBitwiseValue(['administrator','owner']), $usrPerm, true)['permission']){
                $available[] = $permission;
            } elseif($permission->tier == 1 && self::checkPermission(self::getBitwiseValue(['manager','administrator','owner']), $usrPerm, true)['permission']) {
                $available[] = $permission;
            } else if($permission->tier > 0) {
                $available[] = null;
            }
            if($permission->tier > 0){
                $all[] = $permission;
            }
        }

        $data = array(
            'all' => $all,
            'available'   => $available
        );

        return $data;
    }
}