<?php

namespace App\Http\Controllers;

use App\AssignedInvestigator;
use App\Http\Controllers\Services\CasefileNumberGenerator;
use App\Http\Controllers\Services\PermissionsService;
use App\User;
use Illuminate\Http\Request;

class AssignedInvestigatorController extends Controller
{
    public function getAvailableInvestigators(){


        //Instantiate PermissionsProvider in order to select the users with 'Investigator' permission
        $permissionsService = new PermissionsService();


        //Get the viable Investigators
        $viableInvestigators = array();
        $users = User::where('permission', '>=', $permissionsService->getBitwiseValue('Investigator'))->get();
        foreach ($users as $user) {
            if ($permissionsService->checkPermission($permissionsService->getBitwiseValue('Investigator'), $user->permission, false)['permission']) {
                $viableInvestigators[] = $user;
            }
        }

        return $viableInvestigators; //array
    }

    public function getAssignedInvestigators($caseId){

        $assignedInvestigators = AssignedInvestigator::where(function($q) use ($caseId){
            $q->where('casefile_id', '=', $caseId);
            //$q->where('is_lead_investigator', '=', true);
            //$q->where('can_read_only', '=', false);
        })->orderBy('is_lead_investigator', 'desc')->orderBy('can_read_only', 'asc')->take(10)->get();

        return $assignedInvestigators;
    }
}
