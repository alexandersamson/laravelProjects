<?php

namespace App\Http\Controllers;

use App\AssignedClient;
use App\AssignedInvestigator;
use App\Casefile;
use App\CaseState;
use App\Client;
use App\Http\Controllers\Services\CasefileNumberGenerator;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class CasefilesController extends Controller
{
    private $containerId = array (
        'leader' => 'leader',
        'investigator' => 'investigator',
        'client' => 'client'
    );


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
        $assignedClients = array();
        $assignedUsers = array();
        foreach ($casefiles as $casefile){
            $assignedClients[$casefile->id] = $assignedClientController->getAssignedClients($casefile->id);
            $assignedUsers[$casefile->id] = $assignedInvestigatorController->getAssignedInvestigators($casefile->id);
        }

        $data = array(
            'casefiles' => $casefiles,
            'casestates' => $casestates,
            'assignedClients' => $assignedClients,
            'assignedUsers' => $assignedUsers,
        );
        //return $data;
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

        //Get viable Investigators
        $viableInvestigators = $assignedInvestigatorController->getAvailableInvestigators();
        $viableClients = $assignedClientController->getAvailableClients();

        $data = array(
            'casecode' => $caseCode,
            'investigators' => $viableInvestigators,
            'clients' => $viableClients,
            'casestates' => $caseStates
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
        $this->validate($request, [
            'name' => 'required',
            'casecode' => 'required',
            'description' => 'required',
            $this->containerId['leader'] => 'required',
            'investigators.*.id' => 'nullable',
            'clients.*.id' => 'nullable',
            'case-state' => 'required'
        ]);

        //return $request->input($this->containerId['investigator']);
        $casefile = new Casefile();
        $casefile ->name = $request->input('name');
        $casefile ->casecode = $request->input('casecode');
        $casefile ->description = $request->input('description');
        $casefile ->user_id = auth()->user()->id;
        $casefile ->case_state_index = $request->input('case-state');
        $casefile ->lead_investigator_index = 0;
        $casefile ->client_index = 0;
        $casefile ->save();


        $thisCasefile = Casefile::where('casecode', $request->input('casecode'))->get();

        //Get assigned lead investigator
        if(isset($request->input($this->containerId['leader'])[0])) {
            $assignedInvestigator = new AssignedInvestigator();
            $assignedInvestigator->user_id = $request->input($this->containerId['leader'])[0];
            $assignedInvestigator->casefile_id = $thisCasefile[0]->id;
            $assignedInvestigator->is_lead_investigator = true;
            $assignedInvestigator->save();
        }

        if(isset($request->input($this->containerId['investigator'])[0])) {
            foreach($request->input($this->containerId['investigator']) as $investigator) {
                $assignedInvestigator = new AssignedInvestigator();
                $assignedInvestigator->user_id = $investigator;
                $assignedInvestigator->casefile_id = $thisCasefile[0]->id;
                $assignedInvestigator->is_lead_investigator = false;
                $assignedInvestigator->save();
            }
        }

        if(isset($request->input($this->containerId['client'])[0])) {
            foreach($request->input($this->containerId['client']) as $client) {
                $assignedClient = new AssignedClient();
                $assignedClient->client_id = $client;
                $assignedClient->casefile_id = $thisCasefile[0]->id;
                $assignedClient->is_first_contact = true;
                $assignedClient->save();
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

    public function addLeadInvestigator(Request $request){

        $input = $request->all();
        $idPrefix = '#';
        $containerName = $this->containerId['leader'];
        $users = array();

        if(isset($input['data'])) {
            $users[] = User::where('id', $input['data'])->get();
        }

        $data = array(
            'users' => $users,
            'idPrefix' => $idPrefix,
            'containerName' => $containerName
        );

        return view('casefiles.elements.select-assignee')->with('data',$data);

    }

    public function addInvestigators(Request $request){

        $input = $request->all();
        $idPrefix = '#';
        $containerName = $this->containerId['investigator'];
        $users = array();

        if(isset($input['data'])) {
            foreach ($input['data'] as $selected) {
                $users[] = User::where('id', $selected)->get();
            }
        }

        $data = array(
            'users' => $users,
            'idPrefix' => $idPrefix,
            'containerName' => $containerName
        );

        return view('casefiles.elements.select-assignee')->with('data',$data);

    }

    public function addClients(Request $request){

        $input = $request->all();
        $idPrefix = '#';
        $containerName = $this->containerId['client'];
        $users = array();

        if(isset($input['data'])) {
            foreach ($input['data'] as $selected) {
                $users[] = Client::where('id', $selected)->get();
            }
        }

        $data = array(
            'users' => $users,
            'idPrefix' => $idPrefix,
            'containerName' => $containerName
        );

        return view('casefiles.elements.select-assignee')->with('data',$data);

    }

}
