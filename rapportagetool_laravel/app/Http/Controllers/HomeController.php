<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\Casefile;
use App\Client;
use App\License;
use App\Post;
use App\Subject;
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
        $limitPerPage = 10;
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $recentPosts = Post::where('deleted', '=', false)->orderBy('created_at', 'desc')->take($limitPerPage)->get();
        $recentClients = Client::where('deleted', '=', false)->orderBy('created_at', 'desc')->take($limitPerPage)->get();
        $recentSubjects = Subject::where('deleted', '=', false)->orderBy('created_at', 'desc')->take($limitPerPage)->get();
        $recentCasefiles = Casefile::where('deleted', '=', false)->orderBy('created_at', 'desc')->take($limitPerPage)->get();
        $recentUpdatedCasefiles = Casefile::where('deleted', '=', false)->orderBy('updated_at', 'desc')->take($limitPerPage)->get();
        $recentDueLicenses = License::where('deleted', '=', false)->orderBy('valid_to', 'asc')->take($limitPerPage)->get();
        $actionLogs = ActionLog::where('hidden', '=', false)->where('deleted','=',false)->orderBy('id', 'desc')->take($limitPerPage)->get();
        //$userCasefiles = Casefile::where('user_id','=', $user_id)->orderBy('created_at', 'desc')->take(10)->get();
        $userCasefiles = DB::table('casefiles')
            ->join('assigned_investigators', 'casefiles.id', '=', 'assigned_investigators.casefile_id')
            ->where('assigned_investigators.deleted','=',false)
            ->where('casefiles.deleted','=',false)
            ->where('assigned_investigators.user_id','=',$user_id)
            ->select('casefiles.*')
            ->orderBy('assigned_investigators.is_lead_investigator', 'DESC')
            ->orderBy('assigned_investigators.created_at', 'DESC')->take($limitPerPage)->get();
        $cavedButtonsController = new CavedButtonsController;
        $cavedBtn = array();
        $cavedBtn['posts'] = $cavedButtonsController->getCavedBtnArray('posts',$recentPosts);
        $cavedBtn['casefiles_recent'] = $cavedButtonsController->getCavedBtnArray('casefiles',$recentCasefiles);
        $cavedBtn['casefiles_updated'] = $cavedButtonsController->getCavedBtnArray('casefiles',$recentUpdatedCasefiles);
        $cavedBtn['casefiles_user'] = $cavedButtonsController->getCavedBtnArray('casefiles',$userCasefiles);
        $cavedBtn['clients_recent'] = $cavedButtonsController->getCavedBtnArray('clients',$recentClients);
        $cavedBtn['subjects_recent'] = $cavedButtonsController->getCavedBtnArray('subjects',$recentSubjects);
        $cavedBtn['licenses_due'] = $cavedButtonsController->getCavedBtnArray('licenses',$recentDueLicenses);
        //return $recentPosts;
        $data = array(
            'posts' => $recentPosts,
            'casefiles_recent' => $recentCasefiles,
            'casefiles_updated' => $recentUpdatedCasefiles,
            'casefiles_user' => $userCasefiles,
            'clients_recent' => $recentClients,
            'subjects_recent' => $recentSubjects,
            'licenses_due' => $recentDueLicenses,
            'action_logs' => $actionLogs,
            'permission' => $user->permission,
            'cavedBtn' => $cavedBtn
        );
        return view('home')->with('data', $data);
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
