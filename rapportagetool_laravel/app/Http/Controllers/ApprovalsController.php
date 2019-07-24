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

        if(PermissionsService::canDoWithObj($category, $id, PermissionsService::getPermCode('approve'))){
            if(!$obj->deleted){
                $actionLog = new ActionLogsController;
                if($action == 'approve'){
                    $obj->approved = true;
                    $returnvalue = 'Approved: '.$obj->name;
                    $actionLog->insertAction($obj, 'approve');
                } else {
                    $obj->approved = false;
                    $obj->deleted = true;
                    $returnvalue = 'Dismissed and deleted: '.$obj->name;
                    $actionLog->insertAction($obj, 'dismiss');
                }
                $returncmd = 'success';
                $obj->approved_by_id = auth()->user()->id;
                $obj->save();
            } else {
                $returncmd = 'error';
                $returnvalue = 'This item was deleted and therefore cannot be approved or dismissed';
            }
        } else {
            $returncmd = 'error';
            $returnvalue = 'You don\'t have enough permission to approve '.$category.'.';
        }
        return redirect()->back()->with($returncmd, $returnvalue);
    }
}
