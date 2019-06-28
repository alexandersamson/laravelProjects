<?php

namespace App\Http\Controllers;

use App\Casefile;
use App\CaseState;
use App\Http\Controllers\Services\CasefileNumberGenerator;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class CasefilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Registered', ['only' => ['index', 'show']]);
        $this->middleware('permission:Registered,Investigator', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
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
        $assignees = array();
        foreach ($casefiles as $casefile){
            $assignees[$casefile->id] = User::where('id', $casefile->lead_investigator_index)->get()[0]->name;
        }
        $data = array(
            'casefiles' => $casefiles,
            'casestates' => $casestates,
            'assignees' => $assignees,
        );

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

        //Instantiate Permissions controller
        $permissionsController = new PermissionsController();


        //Get viable Investigators
        $viableUsers = array();
        $users = User::where('permission', '>=', $permissionsController->getBitwiseValue('Investigator'))->get();
        foreach ($users as $user) {
            if ($permissionsController->checkPermission($permissionsController->getBitwiseValue('Investigator'), $user->permission)[0]['permission']) {
                $viableUsers[] = $user;
            }
        }

        $data = array(
            'casecode' => $caseCode,
            'investigators' => $viableUsers
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
}
