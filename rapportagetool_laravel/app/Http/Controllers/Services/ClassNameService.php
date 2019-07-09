<?php

namespace App\Http\Controllers\Services;

use App\Casefile;
use App\Client;
use App\License;
use App\Organization;
use App\Post;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ClassNameService extends Controller
{
    public function getClassByCategory($category, $createNew = true, $id = 0){
        $categories = Config::get('categories'); //Providers/Globals.php
        if(isset($categories[$category])){
            if($categories[$category] == 'casefiles') {
                if ($createNew){
                    $class = new Casefile();
                } else {
                    $class = Casefile::find($id);
                }
            }
            if($categories[$category] == 'posts'){
                if ($createNew){
                    $class = new Post();
                } else {
                    $class = Post::find($id);
                }
            }
            if($categories[$category] == 'users'){
                if ($createNew){
                    $class = new User();
                } else {
                    $class = User::find($id);
                }
            }
            if($categories[$category] == 'clients'){
                if ($createNew){
                    $class = new Client();
                } else {
                    $class = Client::find($id);
                }
            }
            if($categories[$category] == 'organizations'){
                if ($createNew){
                    $class = new Organization();
                } else {
                    $class = Organization::find($id);
                }
            }
            if($categories[$category] == 'subjects'){
                if ($createNew){
                    $class = new Subject();
                } else {
                    $class = Subject::find($id);
                }
            }
            if($categories[$category] == 'licenses'){
                if ($createNew){
                    $class = new License();
                } else {
                    $class = License::find($id);
                }
            }
        } else {
            abort(403);
        }
        return $class;
    }
}
