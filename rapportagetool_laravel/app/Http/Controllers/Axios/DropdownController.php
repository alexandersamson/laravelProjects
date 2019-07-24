<?php

namespace App\Http\Controllers\Axios;

use App\Models\Casefile;
use App\Models\CaseState;
use App\Http\Controllers\ActionLogsController;
use App\Http\Controllers\Services\ClassNameService;
use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DropdownController extends Controller
{
    public function getValues(Request $request){

        //RECEIVING:
        //  category
        //  id
        //  element

        $categories = Config::get('categories');
        $category = $categories[$request->input('category')];
        $id = $request->input('id');
        $element = $request->input('element');

        $values = CaseState::orderBy('position', 'asc')->get();
        $active = Casefile::find($id)->case_state_index;
        return json_encode(
        [   'title' => 'Select',
            'values' => $values,
            'active' => $active
        ]
        );
    }

    public function updateValue(Request $request){

        //RECEIVING:
        //  category
        //  id
        //  element
        //  value

        //validate category
        $categories = Config::get('categories');
        $category = $categories[$request->input('category')];

        //get id
        $id = $request->input('id');

        //get element and its new value
        $element = $request->input('element');
        $value = $request->input('value');

        //get object
        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($category, false, $id);

        if($element == 'case_state_index'){
            $obj->{$element} = $value;
            $obj->save();

            //ActionLog
            if($obj->draft == false) {
                $actionLog = new ActionLogsController;
                $actionLog->insertAction($obj, 'Change status');
            }
        }

        return json_encode(
            [
                'succes' => 'saved',
            ]
        );
    }
}
