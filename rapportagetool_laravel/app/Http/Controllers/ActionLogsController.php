<?php

namespace App\Http\Controllers;

use App\ActionLog;
use Illuminate\Http\Request;
use Eloquent;

class ActionLogsController extends Controller
{
    public function insertAction($object, $action){
        $tableName = $object->getTable();

        $actionLog = new ActionLog;
        $actionLog->user_id = auth()->user()->id;
        $actionLog->creator_id = auth()->user()->id;
        $actionLog->modifier_id = auth()->user()->id;
        $actionLog->object = $tableName;
        $actionLog->object_id = $object->id;
        $actionLog->action = $action;
        $actionLog->save();
    }
}
