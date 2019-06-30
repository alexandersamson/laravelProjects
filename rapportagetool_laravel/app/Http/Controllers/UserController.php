<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //Anyone can Show, Edit and Update their own profile TODO: handle user profile permissions
        $this->middleware('permission:matchOne,Staff,Manager,Owner', ['only' => ['index']]);
        $this->middleware('permission:matchOne,Manager,Owner', ['only' => ['create', 'store', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->paginate(10);

        $data = array(
            'users' => $users
        );

        return view('users.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $user = User::find($id);
        return view('users.profile')->with('user', $user);
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

    public function getSelectList(){

        //Instantiate assignedInvestigatorsController
        $assignedInvestigatorsController = new AssignedInvestigatorController();
        //Get viable Investigators
        $viableInvestigators = $assignedInvestigatorsController->getAvailableInvestigators();

        $data = array(
            'investigators' => $viableInvestigators
        );
        return view('modals.includes.investigator-selector')->with('data', $data);
    }

    public function getSelectListLeader(){

        //Instantiate assignedInvestigatorsController
        $assignedInvestigatorsController = new AssignedInvestigatorController();
        //Get viable Investigators
        $viableInvestigators = $assignedInvestigatorsController->getAvailableInvestigators();

        $data = array(
            'investigators' => $viableInvestigators
        );
        return view('modals.includes.leader-investigator-selector')->with('data', $data);
    }
}
