<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\PermissionsService;
use Illuminate\Http\Request;

class ApprovalsController extends Controller
{
    public function approval($category, $id, $action){

        $classNameService = new ClassNameService;
        $obj = $classNameService->getClassByCategory($category, false, $id);
        $returncmd = '';
        $returnvalue = '';

        if(PermissionsService::canDoWithObj($category, $id, 'u_adv')){
            if(!$obj->deleted){
                $actionLog = new ActionLogsController;
                if($action == 'approve'){
                    $obj->approved = true;
                    $obj->approved_by_id = auth()->user()->id;
                    $obj->save();
                    $returncmd = 'success';
                    $returnvalue = 'Approved: '.$obj->name;
                    $actionLog->insertAction($obj, 'approve');
                } else {
                    $obj->approved = false;
                    $obj->approved_by_id = auth()->user()->id;
                    $obj->deleted = true;
                    $obj->save();
                    $returncmd = 'success';
                    $returnvalue = 'Dismissed and deleted: '.$obj->name;
                    $actionLog->insertAction($obj, 'dismiss');
                }
            } else {
                $returncmd = 'error';
                $returnvalue = 'This item was already deleted';
            }
        } else {
            $returncmd = 'error';
            $returnvalue = 'You don\'t have enough permission to approve '.$category.'.';
        }
        return redirect()->back()->with($returncmd, $returnvalue);
    }
}
