<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Traits\ControllerHelper;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    use ControllerHelper;

    protected $category;

    public function __construct()
    {
        $this->category = 'subjects';
        $this->middleware('auth'); //Anyone can Show, Edit and Update their own profile TODO: handle user profile permissions
        $this->middleware('permission:matchOne,Investigator,Casemanager', ['only' => ['create', 'store', 'index', 'show', 'edit', 'update']]);
        $this->middleware('permission:matchAll,Casemanager',              ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::where('deleted', false)->orderBy('created_at', 'desc')->paginate(10);

        $data = array(
            'category' => $this->category,
            'objs' => $subjects,
        );

        return view('layouts.obj-index')->with('data', $data);
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
        $subject = $this->checkAndGetObjToShow($this->category, $id);

        $creator = User::find($subject->creator_id);
        $modifier = User::find($subject->modifier_id);
        $createdAt = $subject->created_at;
        $modifiedAt = $subject->updated_at;

        $data = array(
            'obj' => $subject,
            'creator' => $creator,
            'modifier' => $modifier,
            'modifiedAt' => $modifiedAt,
            'createdAt' => $createdAt
        );


        return view('subjects.show')->with('data', $data);
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
