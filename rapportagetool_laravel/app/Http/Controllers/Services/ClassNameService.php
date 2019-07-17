<?php

namespace App\Http\Controllers\Services;

use App\Asset;
use App\AssignedClient;
use App\AssignedInvestigator;
use App\AssignedSubject;
use App\Casefile;
use App\Client;
use App\License;
use App\LinkCasefileAsset;
use App\LinkCasefileCasenote;
use App\LinkCasefileVehicle;
use App\LinkClientVehicle;
use App\LinkMessageUser;
use App\LinkSubjectAsset;
use App\LinkSubjectVehicle;
use App\Message;
use App\Organization;
use App\Post;
use App\Subject;
use App\User;
use App\Vehicle;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
/**
 * ClassNameService (Service Helper)
 *
 * @mixin Eloquent
 * @mixin Builder
 */
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
            if($categories[$category] == 'assets'){
                if ($createNew){
                    $class = new Asset();
                } else {
                    $class = Asset::find($id);
                }
            }
            if($categories[$category] == 'vehicles'){
                if ($createNew){
                    $class = new Vehicle();
                } else {
                    $class = Vehicle::find($id);
                }
            }
        }
        return $class;
    }


    public function getClassByAssigneeCategory($parentCategory, $assigneeCategory){
        //The returned $class is the 'Pivot' table, as used in any 'Parent<->Pivot<->Child' relationships
        //The returned $handle is used to target proper 'Child' relationship table with the linkage/assignee class
        //The returned $parent is used to target the 'Parent' in any 'Parent<->Pivot<->Child' or 'Parent<->Child' relationships
        //Be aware of setting the right model relationships within the models Classes' files. ~Alexander Samson - 2019
        $categories = Config::get('categoriesUnformatted'); //Providers/Globals.php
        if(isset($categories[$assigneeCategory])){
            if($categories[$parentCategory] == 'casefiles') {
                $parent = 'casefiles';
                if($categories[$assigneeCategory] == 'leaders') {
                    $class = new AssignedInvestigator();
                    $handle = 'user';
                }
                if($categories[$assigneeCategory] == 'investigators'){
                    $class = new AssignedInvestigator();
                    $handle = 'user';
                }
                if($categories[$assigneeCategory] == 'users'){
                    $class = new AssignedInvestigator();
                    $handle = 'user';
                }
                if($categories[$assigneeCategory] == 'staff'){
                    $class = new AssignedInvestigator();
                    $handle = 'user';
                }
                if($categories[$assigneeCategory] == 'clients'){
                    $class = new AssignedClient();
                    $handle = 'client';
                }
                if($categories[$assigneeCategory] == 'subjects'){
                    $class = new AssignedSubject();
                    $handle = 'subject';
                }
                if($categories[$assigneeCategory] == 'assets'){
                    $class = new LinkCasefileAsset();
                    $handle = 'asset';
                }
                if($categories[$assigneeCategory] == 'vehicles'){
                    $class = new LinkCasefileVehicle();
                    $handle = 'vehicle';
                }
                if($categories[$assigneeCategory] == 'casenotes'){
                    $class = new LinkCasefileCasenote();
                    $handle = 'casenote';
                }
            }
            if($categories[$parentCategory] == 'messages'){
                $parent = 'messages';
                if($categories[$assigneeCategory] == 'users'){
                    $class = new LinkMessageUser();
                    $handle = 'user';
                }
            }
            if($categories[$parentCategory] == 'users'){
                $parent = 'users';
                if($categories[$assigneeCategory] == 'users'){
                    $class = new User();
                    $handle = 'user';
                }
            }
            if($categories[$parentCategory] == 'posts'){
                $parent = 'posts';
                if($categories[$assigneeCategory] == 'users'){
                    $class = new Post(); //irrelevant
                    $handle = 'user';
                }
            }
            if($categories[$parentCategory] == 'assets'){
                $parent = 'assets';
                if($categories[$assigneeCategory] == 'casefiles'){
                    $class = new LinkCasefileAsset();
                    $handle = 'casefile';
                }
                if($categories[$assigneeCategory] == 'subjects'){
                    $class = new LinkSubjectAsset();
                    $handle = 'subject';
                }
                if($categories[$assigneeCategory] == 'clients'){
                    $class = new LinkClientVehicle();
                    $handle = 'client';
                }
            }
            if($categories[$parentCategory] == 'vehicles'){
                $parent = 'vehicles';
                if($categories[$assigneeCategory] == 'casefiles'){
                    $class = new LinkCasefileAsset();
                    $handle = 'casefile';
                }
                if($categories[$assigneeCategory] == 'subjects'){
                    $class = new LinkSubjectVehicle();
                    $handle = 'subject';
                }
                if($categories[$assigneeCategory] == 'clients'){
                    $class = new LinkClientVehicle();
                    $handle = 'client';
                }
            }
            if($categories[$parentCategory] == 'casenotes'){
                $parent = 'casenotes';
                if($categories[$assigneeCategory] == 'users'){
                    $class = new AssignedInvestigator();
                    $handle = 'user';
                }
                if($categories[$assigneeCategory] == 'casefiles'){
                    $class = new Casefile();
                    $handle = 'casefile';
                }
            }
        }
        $data = ['class' => $class, 'handle' => $handle , 'parent' => $parent];

        return $data;
    }
}
