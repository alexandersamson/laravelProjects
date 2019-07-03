<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('home')->with('posts', $user->posts);
    }


    public function ajaxRequest()
    {
        return view('ajax.ajaxRequest');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequestPost(Request $request)

    {
        $input = $request->all();
        $mysqlData = DB::table('migrations')->orderBy('batch', 'desc')->paginate(20);
        $data = array(
            'okMessage' => 'AJAX TEST OK',
            'mysqlData' => $mysqlData,
        );
        return response()->json($data);
    }
}
