<?php

namespace App\Http\Controllers;

use App\AssignedClient;
use App\AssignedInvestigator;
use App\AssignedSubject;
use App\Client;
use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\AssignedHelper;
use App\Http\Controllers\Services\PermissionsService;
use App\LinkMessageUser;
use App\Subject;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
/**
 * DynamicSearchController (Controller)
 *
 * @mixin Eloquent
 * @mixin Builder
 */

class DynamicSearchController extends Controller
{
    public function getSearchItems(Request $request){
        $input = $request->all();
        //needs
        //categories
        //returnCols
        //searchCols
        //searchString

        $ps = new PermissionsService();

        if(!is_array($input['categories'])){
            $categories[] = $input['categories'];
        } else {
            $categories = $input['categories'];
        }
        if(!is_array($input['returnCols'])){
            for($i = 0; $i < count($categories); $i++) {
                $returnCols[$i][] = $input['returnCols'];
            }
        } else {
            for($i = 0; $i < count($categories); $i++) {
                for($j = 0; $j < count ($input['returnCols'][$i]); $j++) {
                    $returnCols[$i][$j] = $input['returnCols'][$i][$j];
                }
            }
        }
        if(!is_array($input['searchCols'])){
            $searchCols[] = $input['searchCols'];
        } else {
            $searchCols = $input['searchCols'];
        }

        $class = new ClassNameService();
        $values = array();
        $i = 0;
        foreach($categories as $category) {
            if (!PermissionsService::canDoWithCat($category, 'r')) {
                continue;
            }
            $objs = $class->getClassByCategory($category);
            foreach($searchCols as $searchCol) {
                if(isset($input['permissionfilter'])){
                    $items = $objs::where($searchCol, 'LIKE', '%'.$input['searchString'].'%')
                        ->where('permission', '>=', $ps->getBitwiseValue($input['permissionfilter']))
                        ->select($returnCols[$i])
                        ->take(20)
                        ->get();
                    foreach ($items as $item) {
                        if(isset($item->permission)){
                            if ($ps->checkPermission($ps->getBitwiseValue([$input['permissionfilter']]), $item->permission, false)['permission'] == true) {
                                if (!in_array($item, $values)){
                                    $values[] = $item;
                                }
                            }
                        }
                    }
                } else {
                    $items = $objs::where($searchCol, 'LIKE', '%'.$input['searchString'].'%')
                        ->select($returnCols[$i])
                        ->take(20)
                        ->get()
                        ->toArray();
                    foreach ($items as $item) {
                        if (!in_array($item, $values)) {
                            $values[] = $item;
                        }
                    }
                }
            }
            $i++;
        }
        return json_encode($values);
    }


    public function addToList(Request $request){

        $input = $request->all();
        $idPrefix = '#';
        $objs = array();

        $ps = new PermissionsService();
        $cns = new ClassNameService();

        $assigneeData = $cns->getClassByAssigneeCategory($input['sourceCat'], $input['category']);
        $sourceObj = $cns->getClassByCategory($input['sourceCat'], false, $input['sourceId']);
        $targetObj = $cns->getClassByCategory($input['category'], false, $input['id']);
        $targetObjClass = $cns->getClassByCategory($input['category']);

        $objectColumnLinks = \Config::get('objectColumnLinks');

        if ($sourceObj->draft == false) {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        } else {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        }
        if ($input['category'] == 'leaders' || $input['category'] == 'investigators') {
            if (!$ps::checkPermission($ps::getBitwiseValue(['Investigator']), $targetObj->permission, true)['permission'] == true) {
                return json_encode(["ERROR" => 'Selected user or asset has no permission to be assigned']);
            }
        }

        if ($input['category'] == 'leaders') {
            $assignee = $assigneeData['class']::where('is_lead_investigator', true)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->first();
        } else {
            $assignee = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->where($objectColumnLinks[$input['category']], $input['id'])
                ->first();
        }
        if ($assignee) {
            if($input['category'] == 'leaders') {
                $assignee->{$objectColumnLinks[$input['category']]} = $input['id'];
                $assignee->save();
                $duplicate = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                    ->where($objectColumnLinks[$input['category']], $input['id'])
                    ->where('is_lead_investigator', false)
                    ->first();
                if($duplicate) {
                    $duplicate->delete();
                    echo "<script>location.reload();</script>"; //TODO: fire an AJAX call to just refresh the element container of the deleted item instead of this nasty pagerefresh
                }
            }
        } else {
            $assignee = new $assigneeData['class']();
            $assignee->{$objectColumnLinks[$input['sourceCat']]} = $input['sourceId'];
            $assignee->{$objectColumnLinks[$input['category']]} = $input['id'];
            if($input['category'] == 'leaders') {
                $assignee->is_lead_investigator = true;
            } else if($input['category'] == 'investigators'){
                $assignee->is_lead_investigator = false;
            }
            $assignee->creator_id = auth()->user()->id;
            $assignee->modifier_id = auth()->user()->id;
            $assignee->save();
        }
        if ($input['category'] == 'leaders') {
            $assignees = $assigneeData['class']::where('is_lead_investigator', true)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        } else if ($input['category'] == 'investigators'){
            $assignees = $assigneeData['class']::where('is_lead_investigator', false)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        } else {
            $assignees = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        }
        foreach ($assignees as $item) {
            $objs[] = $targetObjClass::find($item->{$objectColumnLinks[$input['category']]});
        }

        $data = array(
            'objs' => $objs,
            'idPrefix' => $idPrefix,
            'category' => $input['category'],
            'sourceCat' => $input['sourceCat'],
            'sourceId' => $input['sourceId']
        );

        return view('casefiles.elements.select-assignee')
            ->with('data',$data);

    }


    public function removeFromList(Request $request){
        //In de request should be these 4 pieces of data:
        //$input['sourceCat'] = category of parent object
        //$input['sourceId'] = id of parent object
        //$input['category'] = category of child/targeted object
        //$input['id'] = id of child/targeted object

        $input = $request->all();
        $idPrefix = '#';
        $objs = array();
        $ps = new PermissionsService;

        $objectColumnLinks = \Config::get('objectColumnLinks');

        $cns = new ClassNameService();
        $assigneeData = $cns->getClassByAssigneeCategory($input['sourceCat'], $input['category']);
        $obj = $cns->getClassByCategory($input['category'], false, $input['id']);

        if ($obj->draft == false) {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        } else {
            if (!$ps::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                return view('pages.ajax-returns.no-permission');
            }
        }

        if ($input['category'] == 'leaders') {
            //Noone can delete lead investigators. They can only be replaced with someone else via the addToList method
            return view('pages.ajax-returns.no-permission');
        }
        else if ($input['category'] == 'investigators') {
            $assignee = $assigneeData['class']::where('is_lead_investigator', false)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->where($objectColumnLinks[$input['category']], $input['id'])
                ->first();
            if ($assignee) {
                $assignee->delete();
            }
            $assignees = $assigneeData['class']::where('is_lead_investigator', false)
                ->where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        } else {
            $assignee = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->where($objectColumnLinks[$input['category']], $input['id'])
                ->first();
            if ($assignee) {
                $assignee->delete();
            }
            $assignees = $assigneeData['class']::where($objectColumnLinks[$input['sourceCat']], $input['sourceId'])
                ->get();
        }

        foreach ($assignees as $assignee) {
            $objs[] = User::find($assignee->{$objectColumnLinks[$input['category']]});
        }

        $data = array(
            'objs' => $objs,
            'idPrefix' => $idPrefix,
            'category' => $input['category'],
            'sourceCat' => $input['sourceCat'],
            'sourceId' => $input['sourceId']
        );

        return view('casefiles.elements.select-assignee')
            ->with('data',$data);

    }


    public function receiveList(Request $request){

        $input = $request->all();
        $idPrefix = '#';

        $objs = AssignedHelper::getAssigneesArray($input['sourceCat'], $input['sourceId'], $input['targetCat']);

        $data = array(
            'objs' => $objs,
            'idPrefix' => $idPrefix,
            'category' => $input['targetCat'],
            'sourceCat' => $input['sourceCat'],
            'sourceId' => $input['sourceId']
        );

        return view('casefiles.elements.select-assignee')
            ->with('data',$data);

    }
}
