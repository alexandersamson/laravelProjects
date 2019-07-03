<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class imagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:matchOne,Moderator,Staff', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function showUserProfilePicture($user_id, $slug)
    {
        $tryExtensions = array(
            "png", "jpg", "jpeg", "PNG", "JPG", "JPEG", "Png", "Jpg", "Jpeg"
        );

        $storagePath = storage_path('app/images/default_pictures/profilepicture_default.png');

        foreach($tryExtensions as $extension) {
            if (file_exists(storage_path('app/images/users/' . $user_id . '/'. $slug .'/' . $slug . '.' . $extension))) {
                $storagePath = storage_path('app/images/users/' . $user_id . '/'. $slug .'/' . $slug . '.' . $extension);
                break;
            }
        }
        return Image::make($storagePath)->response();
    }
}
