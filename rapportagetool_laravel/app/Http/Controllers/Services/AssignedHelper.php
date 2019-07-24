<?php

namespace App\Http\Controllers\Services;

use App\Models\User;


class AssignedHelper
{
    public static function getAvailable($assigneeCategory)
    {

        $unformattedCats = \Config::get('categoriesUnformatted');
        $cns = new ClassNameService();
        $assigneeData = $cns->getClassByCategory($assigneeCategory);

        if(!$assigneeData['class']){
            return redirect()->back()->with('error','Illegal operation')->send();
        }

        if ($assigneeCategory == $unformattedCats['investigators']){
            $permissionsService = new PermissionsService();
            $viableInvestigators = User::where('permission', '&', $permissionsService->getBitwiseValue('Investigator'))->get()->toArray();
            return $viableInvestigators; //array
        } else {
            $objs = $assigneeData['class']::where('deleted', false)->get();
            return $objs; //array
        }

    }

    public static function getAssigneesArray($parentCategory, $parentId, $assigneeCategory){

        $cats = \Config::get('categories');
        $unformattedCats = \Config::get('categoriesUnformatted');
        $objectColumnLinks = \Config::get('objectColumnLinks');
        $cns = new ClassNameService();
        $assigneeData = $cns->getClassByAssigneeCategory($parentCategory, $assigneeCategory);
        $objArray = array();


        if(!$assigneeData['class']){
            return redirect()->back()->with('error','Illegal operation')->send();
        }

        if($parentCategory == $cats['casefiles']) {
            if ($unformattedCats[$assigneeCategory] == 'leaders') {
                $assignedObjs = $assigneeData['class']::with($assigneeData['handle'])->where($objectColumnLinks[$parentCategory], $parentId)->where('is_lead_investigator', true)->orderBy('can_read_only', 'asc')->get();
            } else if ($unformattedCats[$assigneeCategory] == 'investigators') {
                $assignedObjs = $assigneeData['class']::with($assigneeData['handle'])->where($objectColumnLinks[$parentCategory], $parentId)->where('is_lead_investigator', false)->orderBy('can_read_only', 'asc')->get();
            } else if ($unformattedCats[$assigneeCategory] == 'users') {
                $assignedObjs = $assigneeData['class']::with($assigneeData['handle'])->where($objectColumnLinks[$parentCategory], $parentId)->orderBy('is_lead_investigator', 'asc')->orderBy('can_read_only', 'asc')->get();
            } else {
                $assignedObjs = $assigneeData['class']::with($assigneeData['handle'])->where($objectColumnLinks[$parentCategory], '=', $parentId)->get();
            }
        } else {
            $assignedObjs = $assigneeData['class']::with($assigneeData['handle'])->where($objectColumnLinks[$parentCategory], '=', $parentId)->get();
        }

        foreach ($assignedObjs as $obj){
            $objArray[] = $obj->{$assigneeData['handle']};
        }
        return $objArray;


    }
}
