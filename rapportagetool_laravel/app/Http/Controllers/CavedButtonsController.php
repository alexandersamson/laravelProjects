<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Controllers\Services\PermissionsService;
use App\Models\ObjectCategory;
use App\Models\User;


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
            $objs  = Client::orderBy('created_at', 'desc')->where('deleted','=',false)->take(10)->get();
            $category = 'clients';
        }
        if($category == 'test2'){
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
            $objs = (object)$user;
            $category = 'users';
        }

        $permission = new PermissionsService();

        //make category alphanumeric
        $category = preg_replace('/[^a-zA-Z0-9]+/', '', $category);

        //Check which user_id to use
        if($user_id !== null){
            $current_user_id = $user_id;
        } else {
            if(isset(auth()->user()->id)) {
                $current_user_id = auth()->user()->id;
            } else {
                abort(403, 'No permission');
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
                'c' => false, //Create new (from copy)  (Create rights needed
                'a' => false, //Approve     (Advanced update rights needed)
                'a_show' => false, //Approve show button? (Advanced Update rights needed)
                'v' => false, //View        (Reading rights needed)
                'e' => false, //Edit        (Update rights needed
                'p' => false, //Append (add something to it)    (Editing rights needed)
                'd' => false,//Delete      (Deletion rights needed)
                'd_adv' => false, //Delete Advanced (Advanced Deletion rights needed)
                'd_max' => false];//Delete Maximum (Maximum Deletion rights needed)

            $objCat = ObjectCategory::where('name', $category)->first();

            if($object->approved == false && $object->deleted == false){
                $data[$i]['a_show'] = true;
            }

            if ($object->creator_id == $current_user_id) {
                if ($objCat->c_by_creator) { //create
                    $data[$i]['c'] = true;
                }
                if ($objCat->r_by_creator) { //read
                    $data[$i]['v'] = true;
                }
                if ($objCat->e_by_creator) { //update
                    $data[$i]['p'] = true;
                    $data[$i]['e'] = true;
                }
                if ($objCat->c_adv_by_creator) { //approval
                    $data[$i]['a'] = true;
                }
                if ($objCat->d_by_creator) { // delete
                    $data[$i]['d'] = true;
                }
            }
            if ($data[$i]['c'] == false) {
                if ($permission->checkPermission($objCat->c_permission, $current_user->permission, !$objCat->c_match_all, false)['permission']) {
                    $data[$i]['c'] = true;
                }
            }
            if ($data[$i]['a'] == false) {
                if ($permission->checkPermission($objCat->u_adv_permission, $current_user->permission, !$objCat->c_adv_match_all, false)['permission']) {
                    $data[$i]['a'] = true;
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
            if ($data[$i]['p'] == false) {
                if ($permission->checkPermission($objCat->u_permission, $current_user->permission, !$objCat->u_match_all, false)['permission']) {
                    $data[$i]['p'] = true;
                }
            }
            if ($data[$i]['d'] == false) {
                if ($permission->checkPermission($objCat->d_permission, $current_user->permission, !$objCat->d_match_all, false)['permission']) {
                    $data[$i]['d'] = true;
                }
            }
            if ($data[$i]['d_adv'] == false) {
                if ($permission->checkPermission($objCat->d_adv_permission, $current_user->permission, !$objCat->d_adv_match_all, false)['permission']) {
                    $data[$i]['d_adv'] = true;
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
