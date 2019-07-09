<?php

namespace App\Http\Controllers;

use App\License;
use App\User;
use Illuminate\Http\Request;

class LicensesController extends Controller
{

    protected $category;

    public function __construct()
    {
        $this->category = 'licenses';
        $this->middleware('auth'); //Anyone can Show, Edit and Update their own profile TODO: handle user profile permissions
        $this->middleware('permission:matchOne,Staff,Investigator,Manager,Casemanager,Owner', ['only' => ['index', 'show']]);
        $this->middleware('permission:matchOne,Manager,Owner', ['only' => ['create', 'edit', 'update', 'store', 'destroy']]);
    }


    public function index()
    {
        $licenses = License::orderBy('name', 'asc')->where('deleted','=',false)->paginate(10);

        $data = array(
            'objs' => $licenses
        );

        return view('licenses.index')->with('data', $data);
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
        $license = License::find($id);
        $creator = User::find($license->creator_id);
        $modifier = User::find($license->modifier_id);
        $createdAt = $license->created_at;
        $modifiedAt = $license->updated_at;


        $data = array(
            'obj' => $license,
            'creator' => $creator,
            'modifier' => $modifier,
            'modifiedAt' => $modifiedAt,
            'createdAt' => $createdAt,
        );


        return view('licenses.show')->with('data', $data);
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

    public function getAvailableLicenses(){
        // do nothing
    }
}
