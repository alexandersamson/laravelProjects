<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PermissionsService;
use App\Permission;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class imagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:matchOne,Moderator,Staff', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function showUserProfilePicture($userCategory, $user_id, $slug)
    {
        $tryExtensions = array(
            "png", "jpg", "jpeg", "PNG", "JPG", "JPEG", "Png", "Jpg", "Jpeg"
        );

        $permission = new PermissionsService;


        if($userCategory == 'users') {
            $user = User::find($user_id);
            if(auth()->user()->id != $user->id) {
                $permission->checkPermission($permission->getBitwiseValue(['Staff','Casemanager','Manager','Owner']),NULL,true,true);
            }
            $storagePath = storage_path('app/images/default_pictures/profilepicture_user_default.png');
        } elseif ($userCategory == 'posts'){
            $permission->checkPermission($permission->getBitwiseValue(['Staff','Moderator']),NULL,true,true);
            $storagePath = storage_path('app/images/default_pictures/profilepicture_post_default.png');
        } elseif ($userCategory == 'casefiles'){
            $permission->checkPermission($permission->getBitwiseValue(['Investigator','Casemanager']),NULL,true,true);
            $storagePath = storage_path('app/images/default_pictures/profilepicture_casefile_default.png');
        } elseif ($userCategory == 'clients'){
            $permission->checkPermission($permission->getBitwiseValue(['Casemanager','Relations']),NULL,true,true);
            $storagePath = storage_path('app/images/default_pictures/profilepicture_client_default.png');
        } elseif ($userCategory == 'subjects'){
            $permission->checkPermission($permission->getBitwiseValue(['Investigator','Casemanager']),NULL,true,true);
            $storagePath = storage_path('app/images/default_pictures/profilepicture_subject_default.png');
        } elseif ($userCategory == 'organizations'){
            $permission->checkPermission($permission->getBitwiseValue(['Casemanager','Relations']),NULL,true,true);
            $storagePath = storage_path('app/images/default_pictures/profilepicture_organization_default.png');
        } elseif ($userCategory == 'licenses'){
            $permission->checkPermission($permission->getBitwiseValue(['Staff','Investigator','Casemanager','Manager']),NULL,true,true);
            $storagePath = storage_path('app/images/default_pictures/profilepicture_id_default.png');
        } else {
            return false;
        }

        foreach($tryExtensions as $extension) {
            if (file_exists(storage_path('app/images/'.$userCategory.'/' . $user_id . '/'. $slug .'/' . $slug . '.' . $extension))) {
                $storagePath = storage_path('app/images/'.$userCategory.'/' . $user_id . '/'. $slug .'/' . $slug . '.' . $extension);
                break;
            }
        }
        return Image::make($storagePath)->response();
    }
}
