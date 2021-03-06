<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\PermissionsService;

class CheckDeleteController extends Controller
{
    //
    public function checkDelete($category, $id)
    {
        if (!PermissionsService::canDoWithObj($category, $id, 'd', true, true)) {
            return redirect()->back()->with('error', 'FAILED: No permission');
        }

        $confirmDeleteHtmlPre = 'Do you really want to delete <strong>';
        $confirmDeleteHtmlPost = '</strong> ?';
        $errorDeleteHtml = 'This item cannot be deleted or has been deleted already.';


        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($category, false, $id);

        $sqlReturn = $obj::find($id);

        if (isset($sqlReturn->id)) {
            if (isset($sqlReturn->name)) {
                return $confirmDeleteHtmlPre . $sqlReturn->name . $confirmDeleteHtmlPost;
            } else {
                return $confirmDeleteHtmlPre . $sqlReturn->id . $confirmDeleteHtmlPost;
            }
        } else {
            return $errorDeleteHtml;

        }
    }

    public function checkErase($category, $id)
    {
        if (!PermissionsService::canDoWithObj($category, $id, 'd_adv', false, true)) {
            return redirect()->back()->with('error', 'FAILED: No permission');
        }

        $confirmDeleteHtmlPre = 'Do you really want to permanently erase <strong>';
        $confirmDeleteHtmlPost = '</strong>?<br><br><h4><span class="text-danger"><b>WARNING:</b> This action cannot be undone!</span></h4><small>
        The Dutch privacy authority requires you to store case-related data for at least 1 year and at most 5 years after the last modification of this data. 
        Be aware of this and do not proceed if you are unsure.
        </small>';
        $errorDeleteHtml = 'This item cannot be erased or has been erased already.';


        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($category, false, $id);

        $sqlReturn = $obj::find($id);

        if (isset($sqlReturn->id)) {
            if (isset($sqlReturn->name)) {
                return $confirmDeleteHtmlPre . $sqlReturn->name . $confirmDeleteHtmlPost;
            } else {
                return $confirmDeleteHtmlPre . $sqlReturn->id . $confirmDeleteHtmlPost;
            }
        } else {
            return $errorDeleteHtml;

        }
    }

    public function checkRecover($category, $id)
    {
        if(!PermissionsService::canDoWithObj($category, $id, 'd_adv', false, true)){
            return redirect()->back()->with('error', 'FAILED: No permission');
        }

        $confirmDeleteHtmlPre = 'Do you really want to recover <strong>';
        $confirmDeleteHtmlPost = '</strong> ?';
        $errorDeleteHtml = 'This item cannot be recovered or has been recovered already.';

        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($category, false, $id);

        $sqlReturn = $obj::find($id);

        if(isset($sqlReturn->id)){
            if(isset($sqlReturn->name)) {
                return $confirmDeleteHtmlPre.$sqlReturn->name.$confirmDeleteHtmlPost;
            } else {
                return $confirmDeleteHtmlPre.$sqlReturn->id.$confirmDeleteHtmlPost;
            }
        } else{
            return $errorDeleteHtml;
        }

    }

    public function delete($category, $id)
    {
        if(!PermissionsService::canDoWithObj($category, $id, 'd', true, true)){
            return json_encode(['error' => 'FAILED: No permission']);
        }


        $classNameService = new ClassNameService();
        $class = $classNameService->getClassByCategory($category, false, $id);

        $class->deleted = true;
        $class->modifier_id = auth()->user()->id;
        $class->save();

        //ActionLog
        $actionLog = new ActionLogsController;
        $actionLog->insertAction($class, 'delete');
        return back()->with('success', 'Deleted: '.$class->name);


    }


    public function recover($category, $id)
    {
        if(!PermissionsService::canDoWithObj($category, $id, 'd_adv', false, true)){
            return json_encode(['error' => 'FAILED: No permission']);
        }


        $classNameService = new ClassNameService();
        $class = $classNameService->getClassByCategory($category, false, $id);

        $class->deleted = false;
        $class->modifier_id = auth()->user()->id;
        $class->save();

        //ActionLog
        $actionLog = new ActionLogsController;
        $actionLog->insertAction($class, 'recover');
        return back()->with('success', 'Recovered: '.$class->name);

    }
}
