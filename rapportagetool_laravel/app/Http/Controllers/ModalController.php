<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\ClassNameService;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ModalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showPersonInfo($category, $user_id)
    {
        $classNameService = new ClassNameService();
        $personClass = $classNameService->getClassByCategory($category, false, $user_id);



        $obj = $personClass->find($user_id);
        $creator = User::find($obj->creator_id);
        $modifier = User::find($obj->modifier_id);
        $createdAt = $obj->created_at;
        $modifiedAt = $obj->updated_at;

        $data = array(
            'obj' => $obj,
            'category' => $category,
            'creator' => $creator,
            'modifier' => $modifier,
            'modifiedAt' => $modifiedAt,
            'createdAt' => $createdAt
        );


        return view('modals.includes.show-person-info')->with('data', $data);
    }


    public function ajaxGetPersonSelectList(Request $request){

        $input = $request->all();
        $idPrefix = '#';
        $categories = Config::get('categories');
        $persons = array();

        if(isset($input['category'])) {
            if(!isset($categories[$input['category']])){
                abort(403);
            }
        } else {
            abort(403);
        }

            $isLeadInvestigator = false;
        if($input['category'] == 'leaders'){
            $cat = 'users';
            $isLeadInvestigator = true;
        } else if($input['category'] == 'investigators'){
            $cat = 'users';
        } else {
            $cat = $input['category'];
        }

        if($cat == $categories['users']){
            $assignedClass = new AssignedInvestigatorController();
            $viablePersons = $assignedClass->getAvailableInvestigators();
        }
        if($cat == $categories['clients']){
            $assignedClass = new AssignedClientController();
            $viablePersons = $assignedClass->getAvailableClients();
        }
        if($cat == $categories['organizations']){
            $assignedClass = new AssignedOrganizationController();
            $viablePersons = $assignedClass->getAvailableOrganizations();
        }
        if($cat == $categories['subjects']){
            $assignedClass = new AssignedSubjectController();
            $viablePersons = $assignedClass->getAvailableSubjects();
        }
        if($cat == $categories['licenses']){
            $assignedClass = new LicensesController();
            $viablePersons = $assignedClass->getAvailableLicenses();
        }


        $data = array(
            'category' => $input['category'],
            'viablePersons' => $viablePersons,
            'isLeadInvestigator' => $isLeadInvestigator
        );
        return view('modals.includes.select-person')->with('data', $data);

    }
}
