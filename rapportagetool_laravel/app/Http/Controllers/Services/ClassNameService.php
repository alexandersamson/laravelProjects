<?php

namespace App\Http\Controllers\Services;

use App\Models\Asset;
use App\Models\PivotLinks\LinkCasefileClient;
use App\Models\PivotLinks\LinkCasefileUser;
use App\Models\PivotLinks\LinkCasefileSubject;
use App\Models\Casefile;
use App\Models\Client;
use App\Models\License;
use App\Models\PivotLinks\LinkCasefileAsset;
use App\Models\PivotLinks\LinkCasefileCasenote;
use App\Models\PivotLinks\LinkCasefileVehicle;
use App\Models\PivotLinks\LinkClientAsset;
use App\Models\PivotLinks\LinkClientVehicle;
use App\Models\PivotLinks\LinkMessageUser;
use App\Models\PivotLinks\LinkSubjectAsset;
use App\Models\PivotLinks\LinkSubjectVehicle;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Post;
use App\Models\Subject;
use App\Models\User;
use App\Models\Vehicle;
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
                    $class = new LinkCasefileUser();
                    $handle = 'users';
                }
                if($categories[$assigneeCategory] == 'investigators'){
                    $class = new LinkCasefileUser();
                    $handle = 'users';
                }
                if($categories[$assigneeCategory] == 'users'){
                    $class = new LinkCasefileUser();
                    $handle = 'users';
                }
                if($categories[$assigneeCategory] == 'staff'){
                    $class = new LinkCasefileUser();
                    $handle = 'users';
                }
                if($categories[$assigneeCategory] == 'clients'){
                    $class = new LinkCasefileClient();
                    $handle = 'clients';
                }
                if($categories[$assigneeCategory] == 'subjects'){
                    $class = new LinkCasefileSubject();
                    $handle = 'subjects';
                }
                if($categories[$assigneeCategory] == 'assets'){
                    $class = new LinkCasefileAsset();
                    $handle = 'assets';
                }
                if($categories[$assigneeCategory] == 'vehicles'){
                    $class = new LinkCasefileVehicle();
                    $handle = 'vehicles';
                }
                if($categories[$assigneeCategory] == 'casenotes'){
                    $class = new LinkCasefileCasenote();
                    $handle = 'casenotes';
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
                    $handle = 'users';
                }
            }
            if($categories[$parentCategory] == 'posts'){
                $parent = 'posts';
                if($categories[$assigneeCategory] == 'users'){
                    $class = new Post(); //irrelevant
                    $handle = 'users';
                }
            }
            if($categories[$parentCategory] == 'assets'){
                $parent = 'assets';
                if($categories[$assigneeCategory] == 'casefiles'){
                    $class = new LinkCasefileAsset();
                    $handle = 'casefiles';
                }
                if($categories[$assigneeCategory] == 'subjects'){
                    $class = new LinkSubjectAsset();
                    $handle = 'subjects';
                }
                if($categories[$assigneeCategory] == 'clients'){
                    $class = new LinkClientAsset();
                    $handle = 'clients';
                }
            }
            if($categories[$parentCategory] == 'vehicles'){
                $parent = 'vehicles';
                if($categories[$assigneeCategory] == 'casefiles'){
                    $class = new LinkCasefileVehicle();
                    $handle = 'casefiles';
                }
                if($categories[$assigneeCategory] == 'subjects'){
                    $class = new LinkSubjectVehicle();
                    $handle = 'subjects';
                }
                if($categories[$assigneeCategory] == 'clients'){
                    $class = new LinkClientVehicle();
                    $handle = 'clients';
                }
            }
            if($categories[$parentCategory] == 'casenotes'){
                $parent = 'casenotes';
                if($categories[$assigneeCategory] == 'users'){
                    $class = new LinkCasefileUser();
                    $handle = 'users';
                }
                if($categories[$assigneeCategory] == 'casefiles'){
                    $class = new LinkCasefileCasenote();
                    $handle = 'casefiles';
                }
            }
        }
        $data = ['class' => $class, 'handle' => $handle , 'parent' => $parent];

        return $data;
    }
}
