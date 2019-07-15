<?php

namespace App\Http\Controllers\Services;

use App\AssignedClient;
use App\AssignedInvestigator;
use App\AssignedSubject;
use App\Casefile;
use App\Client;
use App\License;
use App\LinkMessageUser;
use App\Message;
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
            if($categories[$category] == 'messages'){
                if ($createNew){
                    $class = new Message();
                } else {
                    $class = Message::find($id);
                }
            }
        }
        return $class;
    }


    public function getClassByAssigneeCategory($parentCategory, $assigneeCategory){
        $categories = Config::get('categoriesUnformatted'); //Providers/Globals.php
        if(isset($categories[$assigneeCategory])){
            if($categories[$parentCategory] == 'casefiles') {
                if($categories[$assigneeCategory] == 'leaders') {
                    $class = new AssignedInvestigator();
                }
                if($categories[$assigneeCategory] == 'investigators'){
                    $class = new AssignedInvestigator();
                }
                if($categories[$assigneeCategory] == 'users'){
                    $class = new AssignedInvestigator();
                }
                if($categories[$assigneeCategory] == 'staff'){
                    $class = new AssignedInvestigator();
                }
                if($categories[$assigneeCategory] == 'clients'){
                    $class = new AssignedClient();
                }
                if($categories[$assigneeCategory] == 'subjects'){
                    $class = new AssignedSubject();
                }
            }
            if($categories[$parentCategory] == 'messages'){
                if($categories[$assigneeCategory] == 'users'){
                    $class = new LinkMessageUser();
                }
            }
        }
        return $class;
    }
}
