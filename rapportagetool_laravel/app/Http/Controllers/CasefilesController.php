<?php

namespace App\Http\Controllers;

use App\Casefile;
use App\CaseState;
use App\Client;
use App\Http\Controllers\Services\CasefileNumberGenerator;
use App\User;
use Illuminate\Http\Request;

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

        //Instantiate assignedInvestigatorsController
        $assignedInvestigatorsController = new AssignedInvestigatorController();

        //Get viable Investigators
        $viableInvestigators = $assignedInvestigatorsController->getAvailableInvestigators();

        $data = array(
            'casecode' => $caseCode,
            'investigators' => $viableInvestigators
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
        //
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
        $users = array();
        if(isset($input['data'])) {
            $users[] = User::where('id', $input['data'])->get();
        }

        return view('casefiles.elements.select-leadinvestigator')->with('users', $users);

    }

    public function addInvestigators(Request $request){

        $input = $request->all();
        $users = array();

        if(isset($input['data'])) {
            foreach ($input['data'] as $selected) {
                $users[] = User::where('id', $selected)->get();
            }
        }
        return view('casefiles.elements.select-investigators')->with('users', $users);

    }

    public function addClients(Request $request){

        $input = $request->all();
        $users = array();
        foreach ($input['data'] as $selected) {
            $users[] = Client::where('id', $selected)->get();
        }
        return view('casefiles.elements.select-clients')->with('users', $users);

    }

}
