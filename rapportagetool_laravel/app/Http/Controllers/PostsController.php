<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
    // index
    // create
    // store
    // edit
    // update
    // show
    // destroy
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:matchOne,Moderator,Staff', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')){
            //Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $filenameToStore = $filename.'_'.auth()->user()->id.'_'.time().'.'.$extension;
            // Upload it
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);

        } else {
            $filenameToStore = 'noimage.png';
        }

        $postPermissions = new PermissionsController();
        $permissionSeed = $postPermissions->getBitwiseValue(['Staff','Moderator']); //TODO: make post permissions selectable

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->modifier_id = auth()->user()->id;
        $post->cover_image = $filenameToStore;
        $post->permission = $permissionSeed;
        $post->save();

        return redirect('/posts')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $creator = User::find($post->user_id);
        $modifier = User::find($post->modifier_id);
        $createdAt = $post->created_at;
        $modifiedAt = $post->updated_at;
        $cavedButtonsController = new CavedButtonsController;
        $cavedBtnArray = $cavedButtonsController->getAvedArray('posts',$post->id);

        $data = array(
            'post' => $post,
            'creator' => $creator,
            'createdAt' => $createdAt,
            'modifiedAt' => $modifiedAt,
            'modifier' => $modifier,
            'cavedBtnArray' => $cavedBtnArray
        );
        return view('posts.show')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //Check User Id
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'No access');
        }

        //Return the post to edit
        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')) {
            //Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $filenameToStore = $filename.'_'.auth()->user()->id.'_'.time().'.'.$extension;
            // Upload it
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->modifier_id = auth()->user()->id;
        if($request->hasFile('cover_image')) {
            $post->cover_image = $filenameToStore;
        }
        $post->touch();
        $post->save();


        return redirect('/posts')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        //Check User Id
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'No access');
        }

        if($post->cover_image != 'noimage.png'){
            //Delete image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post deleted');
    }
}
