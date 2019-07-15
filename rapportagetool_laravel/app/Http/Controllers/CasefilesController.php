<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\AssignedClient;
use App\AssignedInvestigator;
use App\AssignedSubject;
use App\Casefile;
use App\CaseState;
use App\Client;
use App\Http\Controllers\Services\CasefileNumberGenerator;
use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\Helper;
use App\Http\Controllers\Services\PermissionsService;
use App\Organization;
use App\Post;
use App\Subject;
use App\Traits\ControllerHelper;
use App\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CasefilesController extends Controller
{

    use ControllerHelper;

    protected $category;

    public function __construct()
    {
        $this->category = 'casefiles';
        $this->middleware('auth');
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
        $casefiles = Casefile::orderBy('created_at', 'desc')->where('deleted','=',false)->paginate(25);

        $data = array(
            'category' => $this->category,
            'objs' => $casefiles,
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
        if (!PermissionsService::canDoWithCat($this->category, 'c')) {

            return redirect('home')->with('error', 'No permission');
        }

        //Generate casecode
        $caseCodeGenerator = new CasefileNumberGenerator();
        $caseCode = $caseCodeGenerator->generateCasefileCode();
        while (Casefile::where('casecode', '=', $caseCode)->first()){
            $caseCode = $caseCodeGenerator->generateCasefileCode();
        }

        //get possible casestates
        $caseStates = CaseState::all();

        $casefile = new Casefile();
        $casefile ->name = '[draft by '.auth()->user()->name.']';
        $casefile ->casecode = $caseCode;
        $casefile ->description = '';
        $casefile ->creator_id = auth()->user()->id;
        $casefile ->modifier_id= auth()->user()->id;
        $casefile ->case_state_index = 1;
        $casefile ->lead_investigator_index = 0;
        $casefile ->client_index = 0;
        $casefile ->draft = true;
        $casefile ->save();

        $assignedleader = new AssignedInvestigator();
        $assignedleader ->user_id = auth()->user()->id;
        $assignedleader ->is_lead_investigator = true;
        $assignedleader ->casefile_id = $casefile->id;
        $assignedleader ->creator_id = auth()->user()->id;
        $assignedleader ->modifier_id= auth()->user()->id;
        $assignedleader ->save();

        //ActionLog
        $actionLog = new ActionLogsController;
        $actionLog->insertAction($casefile, 'new draft');


        $data = array(
            'casecode' => $caseCode,
            'id' => $casefile->id,
            'casestatus' => $caseStates,
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
        if (!PermissionsService::canDoWithCat($this->category, 'c')) {
            return redirect('home')->with('error', 'No permission');
        }

        $categories = Config::get('categoriesUnformatted');


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'required',
            'casecode' => 'required',
            'case-state' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('casefiles/'.$request->input('id').'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        //return $request->input($this->containerId['investigator']);
        $casefile = Casefile::where('casecode',$request->input('casecode'))->where('id',$request->input('id'))->first();
        if(!$casefile) {
            return redirect('/home')->with('error', 'CaseCode/ID combination not found');
        }

        $casefile->name = $request->input('name');
        $casefile->casecode = $request->input('casecode');
        $casefile->description = $request->input('description');
        $casefile->modifier_id = auth()->user()->id;
        $casefile->case_state_index = $request->input('case-state');
        $casefile->lead_investigator_index = 0;
        $casefile->client_index = 0;
        $casefile->draft = false;
        $casefile->save();

        //ActionLog
        $actionLog = new ActionLogsController;
        $actionLog->insertAction($casefile, 'create');


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
        $casefile = $this->checkAndGetObjToShow($this->category, $id);

        $creator = User::find($casefile->creator_id);
        $modifier = User::find($casefile->modifier_id);
        $createdAt = $casefile->created_at;
        $modifiedAt = $casefile->updated_at;

        //get possible casestates
        $casestatus = CaseState::all();


        $data = array(
            'obj' => $casefile,
            'creator' => $creator,
            'createdAt' => $createdAt,
            'modifiedAt' => $modifiedAt,
            'modifier' => $modifier,
            'casestatus' => $casestatus
        );
        return view('casefiles.show')->with('data', $data);
    }

    public function showByCasecode($casecode)
    {
        $casefile = Casefile::where('casecode', $casecode)->first();
        if ($casefile){
            if (!PermissionsService::canDoWithObj('casefiles', $casefile->id, 'r', false, true)) {
                return redirect('home')->with('error', 'No permission');
            }
            return redirect()->route('casefiles.show',[$casefile->id]);
        } else {
            return redirect('home')->with('error', 'Not found');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $casefile = Casefile::find($id);

        if (!PermissionsService::canDoWithObj($this->category, $id, 'u', false, true)) {
            return redirect('home')->with('error', 'No permission');
        }

        $creator = User::find($casefile->creator_id);
        $modifier = User::find($casefile->modifier_id);
        $createdAt = $casefile->created_at;
        $modifiedAt = $casefile->updated_at;

        //get possible casestates
        $casestatus = CaseState::all();


        $data = array(
            'obj' => $casefile,
            'creator' => $creator,
            'createdAt' => $createdAt,
            'modifiedAt' => $modifiedAt,
            'modifier' => $modifier,
            'casestatus' => $casestatus,
        );
        return view('casefiles.edit')->with('data', $data);
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
        $casefile = new Casefile;


        //ActionLog
        $actionLog = new ActionLogsController;
        $actionLog->insertAction($casefile, 'update');
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


    public function addAssignee($own_id, $category, $item_id){


        if($category == 'leaders'){
            $result = AssignedInvestigator::where('is_lead_investigator', true)->where('case_id',$own_id)->where('user_id',$item_id)->take(1)->get();
            dd($result);
        }

        //return print_r($data);
        return view('casefiles.elements.select-assignee')->with('data',$data);

    }

}
