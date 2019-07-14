<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\PermissionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class AutosavesController extends Controller
{
    protected $category;

    public function __construct()
    {
        $this->category = 'autosaves';
        $this->middleware('auth');
    }



    public function saveFromAjax(Request $request, $category, $id)
    {
        if(!PermissionsService::canDoWithObj($category, $id, 'u', true, true)){
            return json_encode(['error' => 'permission errors']);
        }

        $validator = Validator::make($request->all(), [
            'data' => 'required|max:5000',
            'input' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(['error' => 'validation errors']);
        }

        $categories = Config::get('categories');
        $category = $categories[$category];

        $class = new ClassNameService();
        $obj = $class->getClassByCategory($category, false, $id);
        if(!$obj){
            return json_encode(['error' => 'object not found error']);
        }

        if($category == 'casefiles') {
            if ($request->input('input') == 'name') {
                $obj->name = $request->input('data');
                $obj->save();
            }
            if ($request->input('input') == 'description') {
                $obj->description = $request->input('data');
                $obj->save();
            }
        } else {
            return json_encode(['error' => 'not a valid autosave category']);
        }


        return json_encode(['succes' => 'autosave succeeded']);

    }
}
