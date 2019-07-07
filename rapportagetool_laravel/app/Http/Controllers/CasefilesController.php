<?php

namespace App\Http\Controllers;

use App\AssignedClient;
use App\AssignedInvestigator;
use App\AssignedSubject;
use App\Casefile;
use App\CaseState;
use App\Client;
use App\Http\Controllers\Services\CasefileNumberGenerator;
use App\Http\Controllers\Services\ClassNameService;
use App\Organization;
use App\Post;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CasefilesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:matchOne,Investigator,Casemanager', ['only' => ['index', 'show', 'edit', 'update']]);
        $this->middleware('permission:matchAll,Casemanager',              ['only' => ['create', 'store', 'destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $casefiles = Casefile::orderBy('created_at', 'desc')->paginate(10);
        $casestates = CaseState::all();

        $assignedClientController = new AssignedClientController();
        $assignedInvestigatorController = new AssignedInvestigatorController();
        $assignedSubjectsController = new AssignedSubjectController();
        $assignedClients = array();
        $assignedUsers = array();
        $assignedSubjects = array();
        foreach ($casefiles as $casefile){
            $assignedClients[$casefile->id] = $assignedClientController->getAssignedClients($casefile->id);
            $assignedUsers[$casefile->id] = $assignedInvestigatorController->getAssignedInvestigators($casefile->id);
            $assignedSubjects[$casefile->id] = $assignedSubjectsController->getAssignedSubjects($casefile->id);
        }

        $data = array(
            'casefiles' => $casefiles,
            'casestates' => $casestates,
            'assignedClients' => $assignedClients,
            'assignedUsers' => $assignedUsers,
            'assignedSubjects' => $assignedSubjects,
        );
        //return $data;
        //return $casefiles;
        return view('casefiles.dashboard')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Generate casecode
        $caseCodeGenerator = new CasefileNumberGenerator();
        $caseCode = $caseCodeGenerator->generateCasefileCode();

        //get possible casestates
        $caseStates = CaseState::all();

        //Instantiate helpers
        $assignedInvestigatorController = new AssignedInvestigatorController();
        $assignedClientController = new AssignedClientController();
        $assignedSubjectsController = new AssignedSubjectController();

        //Get viable Investigators/clients/subjects
        $viableInvestigators = $assignedInvestigatorController->getAvailableInvestigators();
        $viableClients = $assignedClientController->getAvailableClients();
        $viableSubjects = $assignedSubjectsController->getAvailableSubjects();

        $data = array(
            'casecode' => $caseCode,
            'investigators' => $viableInvestigators,
            'clients' => $viableClients,
            'subjects' => $viableSubjects,
            'casestates' => $caseStates,
        );
        return view('casefiles.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = Config::get('categoriesUnformatted');


        $this->validate($request, [
            'name' => 'required',
            'casecode' => 'required',
            'description' => 'required',
            $categories['leaders'] => 'required',
            'investigators.*.id' => 'nullable',
            'clients.*.id' => 'nullable',
            'case-state' => 'required'
        ]);

        //return $request->input($this->containerId['investigator']);
        $casefile = new Casefile();
        $casefile ->name = $request->input('name');
        $casefile ->casecode = $request->input('casecode');
        $casefile ->description = $request->input('description');
        $casefile ->creator_id = auth()->user()->id;
        $casefile ->modifier_id= auth()->user()->id;
        $casefile ->case_state_index = $request->input('case-state');
        $casefile ->lead_investigator_index = 0;
        $casefile ->client_index = 0;
        $casefile ->save();


        $thisCasefile = Casefile::where('casecode', $request->input('casecode'))->get();

        //TODO: Dit opfrissen (Teveel herhalingen)
        //Get assigned lead investigator
        if(isset($request->input($categories['leaders'])[0])) {
            $assignedInvestigator = new AssignedInvestigator();
            $assignedInvestigator->user_id = $request->input($categories['leaders'])[0];
            $assignedInvestigator->creator_id = auth()->user()->id;
            $assignedInvestigator->casefile_id = $thisCasefile[0]->id;
            $assignedInvestigator->is_lead_investigator = true;
            $assignedInvestigator->save();
        }

        if(isset($request->input($categories['investigators'])[0])) {
            foreach($request->input($categories['investigators']) as $investigator) {
                $assignedInvestigator = new AssignedInvestigator();
                $assignedInvestigator->user_id = $investigator;
                $assignedInvestigator->creator_id = auth()->user()->id;
                $assignedInvestigator->casefile_id = $thisCasefile[0]->id;
                $assignedInvestigator->is_lead_investigator = false;
                $assignedInvestigator->save();
            }
        }

        if(isset($request->input($categories['clients'])[0])) {
            foreach($request->input($categories['clients']) as $client) {
                $assignedClient = new AssignedClient();
                $assignedClient->client_id = $client;
                $assignedClient->creator_id = auth()->user()->id;
                $assignedClient->casefile_id = $thisCasefile[0]->id;
                $assignedClient->is_first_contact = true;
                $assignedClient->save();
            }
        }
        if(isset($request->input($categories['subjects'])[0])) {
            foreach($request->input($categories['subjects']) as $subject) {
                $assignedSubject = new AssignedSubject();
                $assignedSubject->subject_id = $subject;
                $assignedSubject->creator_id = auth()->user()->id;
                $assignedSubject->casefile_id = $thisCasefile[0]->id;
                $assignedSubject->save();
            }
        }

        return redirect('/casefiles')->with('success', 'Casefile '.$request->input('casecode').' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $casefile = Casefile::find($id);
        return view('casefiles.show')->with('casefile', $casefile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function ajaxAddPersons(Request $request){


        $input = $request->all();
        $idPrefix = '#';
        $persons = array();

        $classNameService = new ClassNameService();
        $person = $classNameService->getClassByCategory($input['category']);



        if(isset($input['data'])) {
            foreach ($input['data'] as $selected) {
                $persons[] = $person::where('id', $selected)->get();
            }
        }

        $data = array(
            'persons' => $persons,
            'idPrefix' => $idPrefix,
            'category' => $input['category']
        );

        //return print_r($data);
        return view('casefiles.elements.select-assignee')->with('data',$data);

    }

}
