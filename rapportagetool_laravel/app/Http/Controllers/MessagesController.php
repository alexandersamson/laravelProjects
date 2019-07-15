<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\Helper;
use App\Http\Controllers\Services\PermissionsService;
use App\LinkMessageUser;
use App\Message;
use App\Post;
use App\Traits\ControllerHelper;
use App\User;
use Composer\Package\Link;
use DB;
use Illuminate\Http\Request;

class MessagesController extends Controller
{


    use ControllerHelper;

    protected $category;

    public function __construct()
    {
        $this->category = 'messages';
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limitPerPage = 20;

                //With admin rights (d_adv)
        if (PermissionsService::canDoWithCat($this->category, 'd_adv')) {
            $messages = User::find(auth()->user()->id)->messages()->where('messages.draft', false)->withPivot('marked_as_read')->orderBy('marked_as_read', 'ASC')->orderBy('created_at', 'DESC')->paginate($limitPerPage);
        } else { //Without admin rights (normal users)
            $messages = User::find(auth()->user()->id)->messages()->where('messages.deleted', false)->where('messages.draft', false)->withPivot('marked_as_read')->orderBy('marked_as_read', 'ASC')->orderBy('created_at', 'DESC')->paginate($limitPerPage);
        }
        $data = array(
            'category' => $this->category,
            'objs' => $messages,
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



        $message = new Message();

        $result = $message::where('draft',true)->where('creator_id',auth()->user()->id)->first();
        if($result){
            $message = $result;
        }

        $message ->name = '[draft by '.auth()->user()->name.']';
        $message ->body = '';
        $message ->creator_id = auth()->user()->id;
        $message ->modifier_id= auth()->user()->id;
        $message ->draft = true;
        $message ->save();

        $data = array(
            'obj' => $message,
            'category' => $this->category
        );

        return view('messages.create')->with('data', $data);

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

        if ($request->input('quickSend')){
            $this->validate($request, [
                'title' => 'nullable|max:50',
                'body' => 'required|max:1024',
                'targetUser' => 'required',
                'cover_image' => 'image|nullable|max:1999'
            ]);
        } else {
            $this->validate($request, [
                'title' => 'nullable|max:50',
                'body' => 'required|max:1024',
                'id' => 'required',
                'users' => 'required',
                'cover_image' => 'image|nullable|max:1999'
            ]);
        }

        if(!$request->input('title')){
            $title = 'No title';
        } else {
            $title = $request->input('title');
        }

        if ($request->input('quickSend')) {
            $message = new Message();
            $message->creator_id = auth()->user()->id;
        } else {
            $message = Message::find($request->input('id'));
            $recipients = LinkMessageUser::where('message_id',$message->id)->first();
            if(!$recipients){
                return redirect('messages/create')->with('error', 'No Recipients selected');
            }
        }
        $message->name = $title; //title of post is going into name of table
        $message->body = $request->input('body');
        $message->draft = false;
        $message->modifier_id = auth()->user()->id;
        $message->save();

        if ($request->input('quickSend')) {
            $lmu = new LinkMessageUser();
            $lmu->user_id = $request->input('targetUser');
            $lmu->message_id = $message->id;
            $lmu->creator_id = auth()->user()->id;
            $lmu->modifier_id = auth()->user()->id;
            $lmu->save();
        }

        return redirect('messages')->with('success', 'Message sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Helper::checkAndGetObjToShow($this->category, $id);

        $creator = User::find($message->creator_id);
        $modifier = User::find($message->modifier_id);
        $createdAt = $message->created_at;
        $modifiedAt = $message->updated_at;


        $data = array(
            'obj' => $message,
            'creator' => $creator,
            'createdAt' => $createdAt,
            'modifiedAt' => $modifiedAt,
            'modifier' => $modifier,
        );

        return view('messages.show')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message = Message::find($id);
        if(!$message){
            return redirect('home')->with('error', 'Message does not exist');
        }
        if(!PermissionsService::canReadMessage($id, true)){
            return redirect('home')->with('error', 'No permission');
        }
        return redirect('home')->with('info', 'Sent messages cannot be edited');
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
        $message = Message::find($id);
        if(!$message){
            return redirect('home')->with('error', 'Message does not exist');
        }
        if(!PermissionsService::canReadMessage($id, true)){
            return redirect('home')->with('error', 'No permission');
        }
        return redirect('home')->with('info', 'Sent messages cannot be edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        if(!$message){
            return redirect('home')->with('error', 'Message does not exist');
        }
        if(!PermissionsService::canReadMessage($id, true)){
            return redirect('home')->with('error', 'No permission');
        }
        LinkMessageUser::where('message_id', $id)->delete();
        //ActionLog
        $actionLog = new ActionLogsController;
        $actionLog->insertAction($message, 'erase');

        $message->delete();



        $response = ['status' => 'success', 'msg' => 'Item permanently erased'];
        return response()->json($response);
    }
}
