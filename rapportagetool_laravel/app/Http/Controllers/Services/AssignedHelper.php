<?php

namespace App\Http\Controllers\Services;

use App\User;


class AssignedHelper
{
    public static function getAvailable($assigneeCategory)
    {

        $unformattedCats = \Config::get('categoriesUnformatted');
        $cns = new ClassNameService();
        $class = $cns->getClassByCategory($assigneeCategory);

        if(!$class){
            return redirect()->back()->with('error','Illegal operation')->send();
        }

        if ($assigneeCategory == $unformattedCats['investigators']){
            $permissionsService = new PermissionsService();
            $viableInvestigators = User::where('permission', '&', $permissionsService->getBitwiseValue('Investigator'))->get()->toArray();
            return $viableInvestigators; //array
        } else {
            $objs = $class::where('deleted', false)->get();
            return $objs; //array
        }

    }

    public static function getAssigneesArray($parentCategory, $parentId, $assigneeCategory){

        $cats = \Config::get('categories');
        $unformattedCats = \Config::get('categoriesUnformatted');
        $cns = new ClassNameService();
        $assigneeClass = $cns->getClassByAssigneeCategory($parentCategory, $assigneeCategory);
        $objArray = array();
        $objHandle = 'user';

        if(!$assigneeClass){
            return redirect()->back()->with('error','Illegal operation')->send();
        }

        if($parentCategory == $cats['casefiles']) {
            if ($unformattedCats[$assigneeCategory] == 'leaders') {
                $objHandle = 'user';
                $assignedObjs = $assigneeClass::with($objHandle)->where('casefile_id', $parentId)->where('is_lead_investigator', true)->orderBy('can_read_only', 'asc')->get();
            } else if ($unformattedCats[$assigneeCategory] == 'investigators') {
                $objHandle = 'user';
                $assignedObjs = $assigneeClass::with($objHandle)->where('casefile_id', $parentId)->where('is_lead_investigator', false)->orderBy('can_read_only', 'asc')->get();
            } else if ($unformattedCats[$assigneeCategory] == 'users') {
                $objHandle = 'user';
                $assignedObjs = $assigneeClass::with($objHandle)->where('casefile_id', $parentId)->orderBy('is_lead_investigator', 'asc')->orderBy('can_read_only', 'asc')->get();
            } else if ($unformattedCats[$assigneeCategory] == 'clients') {
                $objHandle = 'client';
                $assignedObjs = $assigneeClass::with($objHandle)->where('casefile_id', '=', $parentId)->get();
            } else if ($unformattedCats[$assigneeCategory] == 'subjects') {
                $objHandle = 'subject';
                $assignedObjs = $assigneeClass::with($objHandle)->where('casefile_id', '=', $parentId)->get();
            }
        }
        if($parentCategory == $cats['messages']) {
            if ($unformattedCats[$assigneeCategory] == 'users') {
                $objHandle = 'user';
                $assignedObjs = $assigneeClass::with($objHandle)->where('message_id', $parentId)->get();
            }
        }
        foreach ($assignedObjs as $obj){
            $objArray[] = $obj->{$objHandle};
        }
        return $objArray;


    }
}
