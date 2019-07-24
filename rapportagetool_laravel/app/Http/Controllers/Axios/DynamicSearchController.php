<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\AssignedHelper;
use App\Http\Controllers\Services\PermissionsService;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Config;
/**
 * DynamicSearchController (Controller)
 *
 * @mixin Eloquent
 * @mixin Builder
 */

class DynamicSearchController extends Controller
{

    public function getSearchValues(Request $request){

        //NEEDS:
        //categories
        //element
        //searchString

        $input = $request->all();
        $ps = new PermissionsService();
        $categoriesFormatted = Config::get('categories');
        $categoriesUnformatted = Config::get('categoriesUnformatted');
        $title = 'Search results';
        $errors = array();
        $searchCols = array();
        $returnCols = array();
        $categories = array();
        $permissionFilter = array();

        if(!isset($input['element'])) {
            $errors[] = ['error' => 'No Element'];
        }
        if(!isset($input['searchString'])) {
            $errors[] = ['error' => 'No Search String'];
        }
        if(!isset($input['categories'])) {
            $errors[] = ['error' => 'No Categories'];
        }
        if(count($errors) > 0){
            return json_encode($errors);
        }

        foreach ($input['categories'] as $key => $category) {
            $categories[] = $categoriesUnformatted[$input['categories'][$key]];
            if($category == $categoriesUnformatted['investigators']
                || $category == $categoriesUnformatted['leaders']){
                $permissionFilter[$key] = 'Investigator';
            }
            if ($category == $categoriesUnformatted['investigators']
                || $category == $categoriesUnformatted['leaders']
                || $category == $categoriesUnformatted['staff']
                || $category == $categoriesUnformatted['users']
                || $category == $categoriesUnformatted['clients']
                || $category == $categoriesUnformatted['subjects']) {
                $searchCols = ['id','name','email','phone','city'];
                $returnCols[$key] = ['id','name','email','phone','city','permission'];
            }
            if ($category == $categoriesUnformatted['assets']) {
                $searchCols = ['id','name','city','address','type'];
                $returnCols[$key] = ['id','name','type','address','city','permission'];
            }
        }

        $class = new ClassNameService();
        $values = array();
        foreach($categories as $key => $category) {
            if (!PermissionsService::canDoWithCat($category, 'r')) {
                continue;
            }
            $objs = $class->getClassByCategory($category);
            foreach($searchCols as $searchCol) {
                if($input['searchString'] == '#recent'){
                    $title = 'Recently updated '.$category;
                    $items = $objs::orderBy('updated_at', 'DESC')
                        ->select($returnCols[$key])
                        ->take(50)
                        ->get();
                } else {
                    $items = $objs::where($searchCol, 'LIKE', '%' . $input['searchString'] . '%')
                        ->select($returnCols[$key])
                        ->take(50)
                        ->get();
                }
                foreach ($items as $item) {
                    if (!isset($permissionFilter[$key]) || $ps->checkPermission($ps->getBitwiseValue([$permissionFilter[$key]]), $item->permission, false)['permission'] == true) {
                        $item['url'] = '/'.$categoriesFormatted[$category].'/'.$item['id'];
                        if (!in_array($item, $values)){
                            $values[] = $item;
                        }
                    }
                }
            }
        }
        $data = array(
            'objs' => $values,
            'title' => $title,
        );
        return json_encode($data);
    }


    public function addToList(Request $request){

        $input = $request->all();
        $objs = array();
        $title = $input['targetCat'];
        $ps = new PermissionsService();
        $cns = new ClassNameService();

        $assigneeData = $cns->getClassByAssigneeCategory($input['sourceCat'], $input['targetCat']);
        $sourceObj = $cns->getClassByCategory($input['sourceCat'], false, $input['sourceId']);
        $targetObj = $cns->getClassByCategory($input['targetCat'], false, $input['id']);
        $targetObjClass = $cns->getClassByCategory($input['targetCat']);

        $objectColumnLinks = Config::get('objectColumnLinks');

        if ($sourceObj->draft == false) {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        } else {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        }
        if ($input['targetCat'] == 'leaders' || $input['targetCat'] == 'investigators') {
            if (!$ps::checkPermission($ps::getBitwiseValue(['Investigator']), $targetObj->permission, true)['permission'] == true) {
                return json_encode(["ERROR" => 'Selected user or asset has no permission to be assigned']);
            }
        }

        if ($input['targetCat'] == 'leaders') {
            $assignee = $assigneeData['class']::where('is_lead_investigator', true)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->first();
        } else {
            $assignee = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->where($objectColumnLinks[$input['targetCat']], $input['id'])
                ->first();
        }
        if ($assignee) {
            if($input['targetCat'] == 'leaders') {
                $assignee->{$objectColumnLinks[$input['targetCat']]} = $input['id'];
                $assignee->save();
                $duplicate = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                    ->where($objectColumnLinks[$input['targetCat']], $input['id'])
                    ->where('is_lead_investigator', false)
                    ->first();
                if($duplicate) {
                    $duplicate->delete();
                }
            }
        } else {
            $assignee = new $assigneeData['class']();
            $assignee->{$objectColumnLinks[$input['sourceCat']]} = $input['sourceId'];
            $assignee->{$objectColumnLinks[$input['targetCat']]} = $input['id'];
            if($input['targetCat'] == 'leaders') {
                $assignee->is_lead_investigator = true;
            } else if($input['targetCat'] == 'investigators'){
                $assignee->is_lead_investigator = false;
            }
            $assignee->creator_id = auth()->user()->id;
            $assignee->modifier_id = auth()->user()->id;
            $assignee->save();
        }
        if ($input['targetCat'] == 'leaders') {
            $assignees = $assigneeData['class']::where('is_lead_investigator', true)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        } else if ($input['targetCat'] == 'investigators'){
            $assignees = $assigneeData['class']::where('is_lead_investigator', false)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        } else {
            $assignees = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        }
        foreach ($assignees as $item) {
            $objs[] = $targetObjClass::find($item->{$objectColumnLinks[$input['targetCat']]})->toArray();
        }

        $data = array(
            'objs' => $objs,
            'title' => $title,
            'category' => $input['targetCat'],
        );

        return json_encode($data);

    }


    public function removeFromList(Request $request){
        //In de request should be these 4 pieces of data:
        //$input['sourceCat'] = category of parent object
        //$input['sourceId'] = id of parent object
        //$input['targetCat'] = category of child/targeted object
        //$input['id'] = id of child/targeted object

        $input = $request->all();
        $idPrefix = '#';
        $objs = array();
        $ps = new PermissionsService;

        $objectColumnLinks = \Config::get('objectColumnLinks');

        $cns = new ClassNameService();
        $assigneeData = $cns->getClassByAssigneeCategory($input['sourceCat'], $input['targetCat']);
        $obj = $cns->getClassByCategory($input['targetCat'], false, $input['id']);

        if ($obj->draft == false) {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        } else {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        }

        if ($input['targetCat'] == 'leaders') {
            //Noone can delete lead investigators. They can only be replaced with someone else via the addToList method
            return view('pages.ajax-returns.no-permission');
        }
        else if ($input['targetCat'] == 'investigators') {
            $assignee = $assigneeData['class']::where('is_lead_investigator', false)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->where($objectColumnLinks[$input['targetCat']], $input['id'])
                ->first();
            if ($assignee) {
                $assignee->delete();
            }
        } else {
            $assignee = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->where($objectColumnLinks[$input['targetCat']], $input['id'])
                ->first();
            if ($assignee) {
                $assignee->delete();
            }
        }

        return $this->receiveList($request);
    }


    public function receiveList(Request $request){

        $input = $request->all();
        $cns = new ClassNameService();
        $linkClass = $cns->getClassByAssigneeCategory($input['sourceCat'],$input['targetCat']);
        $obj = $cns->getClassByCategory($input['sourceCat'], false, $input['sourceId']);
        $categories = Config::get('categories');

        if($input['targetCat'] == 'users' || $input['targetCat'] == 'investigators' || $input['targetCat'] == 'leaders') {
            $objs = $obj
                ->{$linkClass['handle']}()
                ->wherePivot('deleted', false)
                ->leader($input['targetCat'])
                ->get();
        } else {
            $objs = $obj
                ->{$linkClass['handle']}()
                ->wherePivot('deleted', false)
                ->get();
        }

        //check whether or not allowing deletion links
        foreach ($objs as $key => $obj){
            if(PermissionsService::canDoWithObj($categories[$input['sourceCat']], $obj->id, PermissionsService::getPermCode('update_casefile'), true, true)){
                if($input['targetCat'] != 'leaders') {
                    $objs[$key]['show_link'] = true;
                } else {
                    $objs[$key]['show_link'] = false;
                }
            } else {
                $objs[$key]['show_link'] = false;
            }
        }

        $data = array(
            'objs' => $objs,
            'title' => $input['targetCat'],
            'category' => $input['targetCat'],
            'sourceCat' => $input['sourceCat'],
            'sourceId' => $input['sourceId']
        );

        return json_encode($data);

    }
}
