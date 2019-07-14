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

        $assignedInvestigators = AssignedInvestigator::where('casefile_id', $caseId)->where('is_lead_investigator', false)->orderBy('can_read_only', 'asc')->get();


        return $assignedInvestigators;
    }

    public function getAssignedLeaders($caseId){

        $assignedInvestigators = AssignedInvestigator::where('casefile_id', $caseId)->where('is_lead_investigator', true)->orderBy('can_read_only', 'asc')->get();

        return $assignedInvestigators;
    }

    public function getAssignedStaff($caseId){

        $assignedInvestigators = AssignedInvestigator::where('casefile_id', $caseId)->orderBy('is_lead_investigator', 'asc')->orderBy('can_read_only', 'asc')->get();

        return $assignedInvestigators;
    }
}
