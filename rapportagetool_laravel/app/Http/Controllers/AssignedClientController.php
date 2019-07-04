<?php

namespace App\Http\Controllers;

use App\AssignedClient;
use App\Client;
use Illuminate\Http\Request;

class AssignedClientController extends Controller
{
    public function getAvailableClients(){


        //Get the viable Investigators
        $viableClients = array();
        $clients = Client::where('deleted', false)->get();
        return $clients; //array

    }

    public function getAssignedClients($caseId){

        $assignedClients = AssignedClient::where(function($q) use ($caseId){
            $q->where('casefile_id', '=', $caseId);
            //$q->where('is_lead_investigator', '=', true);
            //$q->where('can_read_only', '=', false);
        })->orderBy('is_first_contact', 'desc')->take(10)->get();

        return $assignedClients;
    }
}
