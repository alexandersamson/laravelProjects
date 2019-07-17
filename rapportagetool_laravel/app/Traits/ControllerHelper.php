<?php


namespace App\Traits;


use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\PermissionsService;

trait ControllerHelper
{
    //This method should be called in every Show (GET) request
    public function checkAndGetObjToShow($category, $id){

        //Preparing some vars
        $categories = \Config::get('categories');
        $category = $categories[$category];
        $categoriesTitles = \Config::get('categoriesSingular');
        $cns = new ClassNameService;
        $Class = $cns->getClassByCategory($category);

        //Basic routing and finding of the object
        $obj = $Class::find($id);
        if(!$obj){
            if($category == 'casefiles'){
                $obj = $Class::where('casecode', '=', $id)->first();
            } else {
                $obj = $Class::where('name', 'LIKE', '%'.$id.'%')->first();
            }
            if($obj) {
                return redirect()->route($category.'.show',[$obj->id])->send();
            } else {
                return redirect('/'.$category)->with('error', $categoriesTitles[$category].' does not exist')->send();
            }
        }

        //Some basic view/read permissions
        if($obj->deleted) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, 'd_adv', false, true)) {
                return redirect('/'.$category)->with('info', 'This '.$categoriesTitles[$category].' has been deleted.')->send();
            }
        } elseif($obj->draft) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, PermissionsService::getPermCode('read_unapproved'), false, true)) {
                return redirect('/'.$category)->with('info', 'This '.$categoriesTitles[$category].' is still a draft.')->send();
            }
        } elseif(!$obj->approved) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, 'r_adv', false, true)) {
                return redirect('/' . $category)->with('info', 'This ' . $categoriesTitles[$category] . ' has not been approved yet')->send();
            }
        } elseif ($category == 'messages'){
            if (!PermissionsService::canReadMessage($obj->id, true)) {
                return redirect('/' . $category)->with('error', 'You don\'t have permission to read this '.$categoriesTitles[$category])->send();
            }
        } elseif (!PermissionsService::canDoWithObj($category, $obj->id, 'r', false, true)) {
            return redirect('/'.$category)->with('error', 'You don\'t have permission to view this '.$categoriesTitles[$category])->send();
        }

        return $obj;
    }


    public function checkAndGetObjToEdit($category, $id){

        //Preparing some vars
        $categories = \Config::get('categories');
        $category = $categories[$category];
        $categoriesTitles = \Config::get('categoriesSingular');
        $cns = new ClassNameService;
        $Class = $cns->getClassByCategory($category);

        //Basic routing and finding of the object
        $obj = $Class::find($id);
        if(!$obj){
            if($category == 'casefiles'){
                $obj = $Class::where('casecode', '=', $id)->first();
            } else {
                $obj = $Class::where('name', 'LIKE', '%'.$id.'%')->first();
            }
            if($obj) {
                return redirect()->route($category.'.edit',[$obj->id])->send();
            } else {
                return redirect('/'.$category)->with('error', $categoriesTitles[$category].' does not exist')->send();
            }
        }

        //Some basic edit/update permissions
        if($obj->deleted) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, PermissionsService::getPermCode('recover'), false, true)) {
                return redirect('/'.$category)->with('info', 'This '.$categoriesTitles[$category].' has been deleted.')->send();
            }
        } elseif($obj->draft) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, PermissionsService::getPermCode('update_draft'), false, true)) {
                return redirect('/'.$category)->with('info', 'This '.$categoriesTitles[$category].' is still a draft.')->send();
            }
        } elseif(!$obj->approved) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, PermissionsService::getPermCode('update_unapproved'), false, true)) {
                return redirect('/' . $category)->with('info', 'This ' . $categoriesTitles[$category] . ' has not been approved yet')->send();
            }
        } elseif ($category == 'messages'){
            return redirect('/' . $category)->with('error', 'You can\'t edit this '.$categoriesTitles[$category])->send();
        } elseif (!PermissionsService::canDoWithObj($category, $obj->id, PermissionsService::getPermCode('update'), false, true)) {
            return redirect('/'.$category)->with('error', 'You don\'t have permission to edit this '.$categoriesTitles[$category])->send();
        }

        return $obj;
    }
}