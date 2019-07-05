<?php

namespace App\Http\Controllers;

use App\Client;
use App\ObjectCategory;
use App\Post;
use App\User;
use DB;
use Illuminate\Http\Request;
use Psy\Util\Str;

class CavedButtonsController extends Controller
{

    private $permission;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCavedBtnArray($category, $objs, $user_id = null){
//              ['name' => 'casefiles',     'permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),            'match_all_permissions' => false],
//              ['name' => 'users',         'permission' => $postPermissions->getBitwiseValue(['Staff','Casemanager','Manager','Owner']), 'match_all_permissions' => false],
//              ['name' => 'clients',       'permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),               'match_all_permissions' => false],
//              ['name' => 'organizations', 'permission' => $postPermissions->getBitwiseValue(['Casemanager','Relations']),               'match_all_permissions' => false],
//              ['name' => 'posts',         'permission' => $postPermissions->getBitwiseValue(['Staff','Moderator']),                     'match_all_permissions' => false]

        if($category == 'test'){
            $objs  = Client::orderBy('created_at', 'desc')->take(10)->get();
            $category = 'clients';
        }
        if($category == 'test2'){
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
            $objs = (object)$user;
            $category = 'users';
        }

        $permission = new PermissionsController();

        //make category alphanumeric
        $category = preg_replace('/[^a-zA-Z0-9]+/', '', $category);

        //Check which user_id to use
        if($user_id !== null){
            $current_user_id = $user_id;
        } else {
            if(isset(auth()->user()->id)) {
                $current_user_id = auth()->user()->id;
            } else {
                abort(403, 'Unauthorized Action');
            }
        }
        $current_user = User::find($current_user_id);

        $data = array();


        foreach($objs as $object) {
            $i = $object->id;

            if(isset($object->name)){
                $name = $object->name;
            } elseif(isset($object->title)){
                $name = $object->title;
            } else {
                $name = 'No Name';
            }

           $data[$i]=[
                'id' => $i,
                'category' => $category,
                'name' => $name,
                'c' => false,
                'a' => false,
                'v' => false,
                'e' => false,
                'd' => false];

            $objCat = ObjectCategory::where('name', $category)->first();

            if ($object->user_id == $current_user_id) {
                if ($objCat->c_by_creator) {
                    $data[$i]['c'] = true;
                }
                if ($objCat->r_by_creator) {
                    $data[$i]['v'] = true;
                }
                if ($objCat->u_by_creator) {
                    $data[$i]['e'] = true;
                }
                if ($objCat->d_by_creator) {
                    $data[$i]['d'] = true;
                }
            }
            if ($data[$i]['c'] == false) {
                if ($permission->checkPermission($objCat->c_permission, $current_user->permission, !$objCat->c_match_all, false)['permission']) {
                    $data[$i]['c'] = true;
                }
            }
            if ($data[$i]['v'] == false) {
                if ($permission->checkPermission($objCat->r_permission, $current_user->permission, !$objCat->r_match_all, false)['permission']) {
                    $data[$i]['v'] = true;
                }
            }
            if ($data[$i]['e'] == false) {
                if ($permission->checkPermission($objCat->u_permission, $current_user->permission, !$objCat->u_match_all, false)['permission']) {
                    $data[$i]['e'] = true;
                }
            }
            if ($data[$i]['d'] == false) {
                if ($permission->checkPermission($objCat->d_permission, $current_user->permission, !$objCat->d_match_all, false)['permission']) {
                    $data[$i]['d'] = true;
                }
            }
        }
        //TODO: add more functionality

        //echo var_dump($data);
        return $data;

    }
}

//    'name' => 'casefiles',
//    'c_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
//    'r_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
//    'u_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
//    'u_adv_permission' => $postPermissions->getBitwiseValue(['Investigator','Casemanager']),
//    'd_permission' => $postPermissions->getBitwiseValue(['Casemanager']),
//    'c_match_all' => false,
//    'r_match_all' => false,
//    'u_match_all' => false,
//    'u_adv_match_all' => false,
//    'd_match_all' => false,
//    'r_by_creator' => false,
//    'u_by_creator' => false,
//    'u_adv_by_creator' => false,
//    'd_by_creator' => false,
//    'r_by_assigned_leader' => true,
//    'u_by_assigned_leader' => true,
//    'u_adv_by_assigned_leader' => true,
//    'd_by_assigned_leader' => false,
//    'r_by_assigned_user' => true,
//    'u_by_assigned_user' => true,
//    'u_adv_by_assigned_user' => false,
//    'd_by_assigned_user' => false,
//    'r_by_assigned_client' => true,
//    'u_by_assigned_client' => false,
//    'u_adv_by_assigned_client' => false,
//    'd_by_assigned_client' => false
