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
    public function getClassByCategory($category){
        $categories = Config::get('categories'); //Providers/Globals.php
        if(isset($categories[$category])){
            if($categories[$category] == 'casefiles'){
                $class = new Casefile();
            }
            if($categories[$category] == 'posts'){
                $class = new Post();
            }
            if($categories[$category] == 'users'){
                $class = new User();
            }
            if($categories[$category] == 'clients'){
                $class = new Client();
            }
            if($categories[$category] == 'organizations'){
                $class = new Organization();
            }
            if($categories[$category] == 'subjects'){
                $class = new Subject();
            }
            if($categories[$category] == 'licenses'){
                $class = new License();
            }
        } else {
            abort(403);
        }
        return $class;
    }
}
