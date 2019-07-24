<?php

namespace App\Http\Controllers;

use App\Models\Casefile;
use App\Models\Casenote;
use App\Http\Resources\Casesnote as CasenoteResource;
use App\Http\Resources\Casesnotes as CasenoteCollection;
use Illuminate\Http\Request;

class CasenotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $casenotes = Casenote::paginate(10);

        return CasenoteResource::collection($casenotes);
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
        $casenote = Casenote::findOrFail($id);
        return new CasenoteResource($casenote);
    }

    public function showApi($id)
    {
        $casenote = Casenote::findOrFail($id);
        return new CasenoteResource($casenote);
    }

    public function showCasefileNotesApi($casefileId){

        $notes = Casefile::find($casefileId)
            ->casenotes()
            ->where('casenotes.deleted', false)
            ->orderBy('casenotes.created_at', 'desc')
            ->with(['modifier:id,name','creator:id,name'])
            ->paginate(20);
        foreach ($notes as $key=>$note){
            if($note->created_at != $note->updated_at){
                $notes[$key]->body = $notes[$key]->body."<br><small class='text-black-50'>[edited at ".$note->updated_at." by ".$note->modifier->name."]</small>";
            } else {
                $notes[$key]->body = $notes[$key]->body."<br><small class='text-black-50'>[original]</small>";
            }
        }
        return new CasenoteCollection($notes, $casefileId);
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
