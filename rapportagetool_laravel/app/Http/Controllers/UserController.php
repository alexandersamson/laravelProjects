<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\PermissionsService;
use App\Models\License;
use App\Models\RegistrationKey;
use App\Traits\ControllerHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendRegkey;
use Illuminate\Support\Str;

class UserController extends Controller
{

    use ControllerHelper;

    protected $category;

    public function __construct()
    {
        $this->category = 'users';
        $this->middleware('auth'); //Anyone can Show, Edit and Update their own profile TODO: handle user profile permissions

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

        $permissions = PermissionsService::getSettablePermissions();

        $data = array(
            'permissions' => $permissions,
        );


        return view('users.create')->with('data', $data);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateRegkey(Request $request)
    {

        //VALIDATION
        $this->validate($request,
        [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:registration_keys,user_email'],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissionValues' => ['nullable', 'array'],
        ]);

        //VARS
        $regkey = Str::random(32);
        $hashedKey = Hash::make($regkey);
        $input =  $request->all();
        $name = $input['name'];
        $email = $input['email'];
        if(isset($input['description'])){
            $description = $input['description'];
        } else {
            $description = '';
        }
        $permissionVal = 0;
        if(isset($input['permissionValues'])){
            foreach($input['permissionValues'] as $val) {
                $permissionVal += $val;
            }
        }

        //DBASE
        $regkeyObj = new RegistrationKey();
        $regkeyObj->name = $name;
        $regkeyObj->description = $description;
        $regkeyObj->user_email = $email;
        $regkeyObj->user_permission = $permissionVal;
        $regkeyObj->regkey = $hashedKey;
        $regkeyObj->creator_id = auth()->user()->id;
        $regkeyObj->modifier_id = auth()->user()->id;
        $regkeyObj->save();

        //EMAIL
        $data = array(
            'name' => $name,
            'email' => $email,
            'regkey' => $regkey,
        );
        Mail::to($email)->send(new SendRegkey($data));

        //RETURN
        return back()->with('success', 'Registration Key generated and emailed to '.$email);
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
