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
        if (!PermissionsService::canDoWithObj($category, $obj->id, 'r', false, true)) {
            return redirect('/'.$category)->with('error', 'You don\'t have permission to view this '.$categoriesTitles[$category])->send();
        }

        if($obj->draft) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, 'r_adv', false, true)) {
                return redirect('/'.$category)->with('info', 'This '.$categoriesTitles[$category].' is still a draft.')->send();
            }
        }
        if($obj->deleted) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, 'd_adv', false, true)) {
                return redirect('/'.$category)->with('info', 'This '.$categoriesTitles[$category].' has been deleted.')->send();
            }
        }
        if(!$obj->approved) {
            if (!PermissionsService::canDoWithObj($category, $obj->id, 'u_adv', false, true)) {
                return redirect('/'.$category)->with('info', 'This '.$categoriesTitles[$category].' has not been approved yet')->send();
            }
        }

        return $obj;
    }
}