<?php

namespace App\Http\Controllers\Axios;

use App\Models\Casefile;
use App\Models\CaseState;
use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinklistController extends Controller
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
                'objs' => $values,
                'active' => $active
            ]
        );
    }
}
