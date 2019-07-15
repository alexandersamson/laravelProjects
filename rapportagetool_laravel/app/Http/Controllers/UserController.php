<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\Helper;
use App\Http\Controllers\Services\PermissionsService;
use App\License;
use App\Post;
use App\Providers\PermissionsProvider;
use App\Traits\ControllerHelper;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    use ControllerHelper;

    protected $category;

    public function __construct()
    {
        $this->category = 'users';
        $this->middleware('auth'); //Anyone can Show, Edit and Update their own profile TODO: handle user profile permissions
        $this->middleware('permission:matchOne,Staff', ['only' => ['edit', 'update']]);
        $this->middleware('permission:matchOne,Manager,Owner', ['only' => ['create', 'store', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('deleted', false)->orderBy('name', 'asc')->paginate(10);

        $data = array(
            'category' => $this->category,
            'objs' => $users,
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

        $user = $this->checkAndGetObjToShow($this->category, $id);

        $creator = User::find($user->creator_id);
        $modifier = User::find($user->modifier_id);
        $createdAt = $user->created_at;
        $modifiedAt = $user->updated_at;
        $licenses = License::where('user_id','=',$id)->get();


        $data = array(
            'obj' => $user,
            'creator' => $creator,
            'modifier' => $modifier,
            'modifiedAt' => $modifiedAt,
            'createdAt' => $createdAt,
            'licenses' => $licenses
        );


        return view('users.show')->with('data', $data);
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
