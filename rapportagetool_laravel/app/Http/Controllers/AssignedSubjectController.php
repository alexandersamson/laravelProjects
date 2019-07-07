<?php

namespace App\Http\Controllers;

use App\AssignedSubject;
use App\Subject;
use Illuminate\Http\Request;

class AssignedSubjectController extends Controller
{
    public function getAvailableSubjects(){


        //Get the viable Investigators
        $viableClients = array();
        $subjects = Subject::where('deleted', false)->get();
        return $subjects; //array

    }

    public function getAssignedSubjects($caseId){

        $assignedSubjects = AssignedSubject::where(function($q) use ($caseId){
            $q->where('casefile_id', '=', $caseId);
            //$q->where('is_lead_investigator', '=', true);
            //$q->where('can_read_only', '=', false);
        })->take(10)->get();

        return $assignedSubjects;
    }
}
