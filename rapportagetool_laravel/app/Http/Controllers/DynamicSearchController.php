<?php

namespace App\Http\Controllers;

use App\AssignedClient;
use App\AssignedInvestigator;
use App\AssignedSubject;
use App\Client;
use App\Http\Controllers\Services\ClassNameService;
use App\Http\Controllers\Services\Helper;
use App\Http\Controllers\Services\PermissionsService;
use App\LinkMessageUser;
use App\Subject;
use App\User;
use Illuminate\Http\Request;

class DynamicSearchController extends Controller
{
    public function getSearchItems(Request $request){
        $input = $request->all();
        //needs
        //categories
        //returnCols
        //searchCols
        //searchString

        $permissionsService = new PermissionsService();

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
                    $items = $objs::where($searchCol, 'LIKE', '%'.$input['searchString'].'%')->where('permission', '>=', $permissionsService->getBitwiseValue($input['permissionfilter']))->select($returnCols[$i])->take(20)->get();
                    foreach ($items as $item) {
                        if(isset($item->permission)){
                            if ($permissionsService->checkPermission($permissionsService->getBitwiseValue([$input['permissionfilter']]), $item->permission, false)['permission'] == true) {
                                if (!in_array($item, $values)){
                                    $values[] = $item;
                                }
                            }
                        }
                    }
                } else {
                    $items = $objs::where($searchCol, 'LIKE', '%'.$input['searchString'].'%')->select($returnCols[$i])->take(20)->get()->toArray();
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
        //dd($input);
        $idPrefix = '#';
        $objs = array();

        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($input['category'], false, $input['id']);

        if($input['sourceCat'] == 'casefiles') {
            if ($input['category'] == 'leaders') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                } else {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $assignee = AssignedInvestigator::where('is_lead_investigator', true)->where('casefile_id', $input['sourceId'])->first();
                if (PermissionsService::checkPermission(PermissionsService::getBitwiseValue(['Investigator']), $obj->permission, true)['permission'] == true) {
                    if ($assignee) {
                        $assignee->user_id = $input['id'];
                        $assignee->save();
                    } else {
                        $assignee = new AssignedInvestigator();
                        $assignee->casefile_id = $input['sourceId'];
                        $assignee->user_id = $input['id'];
                        $assignee->is_lead_investigator = true;
                        $assignee->creator_id = auth()->user()->id;
                        $assignee->modifier_id = auth()->user()->id;
                        $assignee->save();
                    }
                    $assignees = AssignedInvestigator::where('is_lead_investigator', true)->where('casefile_id', $input['sourceId'])->get();
                    foreach ($assignees as $item) {
                        $objs[] = User::find($item->user_id);
                    }
                } else {
                    return json_encode(["ERROR" => 'Selected Lead Investigator has no permission to be assigned']);
                }
            }

            if ($input['category'] == 'investigators') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                } else {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $assignee = AssignedInvestigator::where('is_lead_investigator', false)->where('casefile_id', $input['sourceId'])->where('user_id', $input['id'])->first();
                if (PermissionsService::checkPermission(PermissionsService::getBitwiseValue(['Investigator']), $obj->permission)['permission'] == true) {
                    if ($assignee) {
                        //Do nothing; already there
                    } else {
                        $assignee = new AssignedInvestigator();
                        $assignee->casefile_id = $input['sourceId'];
                        $assignee->user_id = $input['id'];
                        $assignee->is_lead_investigator = false;
                        $assignee->creator_id = auth()->user()->id;
                        $assignee->modifier_id = auth()->user()->id;
                        $assignee->save();
                    }
                    $assignees = AssignedInvestigator::where('is_lead_investigator', false)->where('casefile_id', $input['sourceId'])->get();
                    foreach ($assignees as $item) {
                        $objs[] = User::find($item->user_id);
                    }
                } else {
                    return json_encode(["ERROR" => 'Selected Investigator has no permission to be assigned']);
                }
                //dd($objs);
            }

            if ($input['category'] == 'clients') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                } else {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $assignee = AssignedClient::where('casefile_id', $input['sourceId'])->where('client_id', $input['id'])->first();
                if ($assignee) {
                    //Do nothing; already there
                } else {
                    $assignee = new AssignedClient();
                    $assignee->casefile_id = $input['sourceId'];
                    $assignee->client_id = $input['id'];
                    $assignee->is_first_contact = true;
                    $assignee->creator_id = auth()->user()->id;
                    $assignee->modifier_id = auth()->user()->id;
                    $assignee->save();
                }
                $assignees = AssignedClient::where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $client) {
                    $objs[] = Client::find($client->client_id);
                }
                //dd($objs);
            }

            if ($input['category'] == 'subjects') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                } else {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');

                    }
                }
                $assignee = AssignedSubject::where('casefile_id', $input['sourceId'])->where('subject_id', $input['id'])->first();
                if ($assignee) {
                    //Do nothing; already there
                } else {
                    $assignee = new AssignedSubject();
                    $assignee->casefile_id = $input['sourceId'];
                    $assignee->subject_id = $input['id'];
                    $assignee->is_prime_subject = true;
                    $assignee->creator_id = auth()->user()->id;
                    $assignee->modifier_id = auth()->user()->id;
                    $assignee->save();
                }
                $assignees = AssignedSubject::where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $subject) {
                    $objs[] = Subject::find($subject->subject_id);
                }
                //dd($objs);
            }
        }
        if($input['sourceCat'] == 'messages') {
            if ($input['category'] == 'users') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $lmu = LinkMessageUser::where('message_id', $input['sourceId'])->where('user_id', $input['id'])->first();
                if ($lmu) {
                    //Do nothing; already there
                } else {
                    $lmu = new LinkMessageUser();
                    $lmu->message_id = $input['sourceId'];
                    $lmu->user_id = $input['id'];
                    $lmu->marked_as_read = false;
                    $lmu->creator_id = auth()->user()->id;
                    $lmu->modifier_id = auth()->user()->id;
                    $lmu->save();
                }
                $recipients = LinkMessageUser::where('message_id', $input['sourceId'])->get();
                foreach ($recipients as $rec) {
                    $objs[] = User::find($rec->user_id);
                }
                //dd($objs);
            }
        }



        $data = array(
            'objs' => $objs,
            'idPrefix' => $idPrefix,
            'category' => $input['category'],
            'sourceCat' => $input['sourceCat'],
            'sourceId' => $input['sourceId']
        );


        //return print_r($data);
        return view('casefiles.elements.select-assignee')->with('data',$data);

    }


    public function removeFromList(Request $request){


        $input = $request->all();
        //dd($input);
        $idPrefix = '#';
        $objs = array();

        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($input['category'], false, $input['id']);


        if($input['sourceCat'] == 'casefiles') {
            if ($input['category'] == 'leaders') {
                //Noone can delete lead investigators. They can only be replaced with someone else via the addToList method
                return view('pages.ajax-returns.no-permission');
            }

            if ($input['category'] == 'investigators') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                } else {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $assignee = AssignedInvestigator::where('is_lead_investigator', false)->where('casefile_id', $input['sourceId'])->where('user_id', $input['id'])->first();
                if ($assignee) {
                    $assignee->delete();
                }
                $assignees = AssignedInvestigator::where('is_lead_investigator', false)->where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $item) {
                    $objs[] = User::find($item->user_id);
                }
            }

            if ($input['category'] == 'clients') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u_adv', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                } else {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $assignee = AssignedClient::where('casefile_id', $input['sourceId'])->where('client_id', $input['id'])->first();
                if ($assignee) {
                    $assignee->delete();
                }
                $assignees = AssignedClient::where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $client) {
                    $objs[] = Client::find($client->client_id);
                }
            }

            if ($input['category'] == 'subjects') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'u', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                } else {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $assignee = AssignedSubject::where('casefile_id', $input['sourceId'])->where('subject_id', $input['id'])->first();
                if ($assignee) {
                    $assignee->delete();
                }
                $assignees = AssignedSubject::where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $subject) {
                    $objs[] = Subject::find($subject->subject_id);
                }
            }
        }
        if($input['sourceCat'] == 'messages') {
            if ($input['category'] == 'users') {
                if ($obj->draft == false) {
                    if (!PermissionsService::canDoWithObj($input['sourceCat'], $input['sourceId'], 'c', false, true)) {
                        return view('pages.ajax-returns.no-permission');
                    }
                }
                $recipient = LinkMessageUser::where('message_id', $input['sourceId'])->where('user_id', $input['id'])->first();
                if ($recipient) {
                    $recipient->delete();
                }
                $recipients = LinkMessageUser::where('message_id', $input['sourceId'])->get();
                foreach ($recipients as $rec) {
                    $objs[] = User::find($rec->user_id);
                }
            }
        }



        $data = array(
            'objs' => $objs,
            'idPrefix' => $idPrefix,
            'category' => $input['category'],
            'sourceCat' => $input['sourceCat'],
            'sourceId' => $input['sourceId']
        );


        //return print_r($data);
        return view('casefiles.elements.select-assignee')->with('data',$data);

    }


    public function receiveList(Request $request){


        $input = $request->all();
        //dd($input);
        $idPrefix = '#';
        $objs = array();

        if($input['sourceCat'] == 'casefiles') {
            if ($input['targetCat'] == 'leaders') {
                $assignees = AssignedInvestigator::where('is_lead_investigator', true)->where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $item) {
                    $objs[] = User::find($item->user_id);
                }
            }

            if ($input['targetCat'] == 'investigators') {
                $assignees = AssignedInvestigator::where('is_lead_investigator', false)->where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $item) {
                    $objs[] = User::find($item->user_id);
                }
            }

            if ($input['targetCat'] == 'clients') {
                $assignees = AssignedClient::where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $client) {
                    $objs[] = Client::find($client->client_id);
                }
            }

            if ($input['targetCat'] == 'subjects') {
                $assignees = AssignedSubject::where('casefile_id', $input['sourceId'])->get();
                foreach ($assignees as $subject) {
                    $objs[] = Subject::find($subject->subject_id);
                }
            }
        }

        if($input['sourceCat'] == 'messages') {
            if ($input['targetCat'] == 'users') {
                $users = LinkMessageUser::where('message_id', $input['sourceId'])->get();
                foreach ($users as $user) {
                    $objs[] = User::find($user->user_id);
                }
            }
        }



        $data = array(
            'objs' => $objs,
            'idPrefix' => $idPrefix,
            'category' => $input['targetCat'],
            'sourceCat' => $input['sourceCat'],
            'sourceId' => $input['sourceId']
        );


        //return print_r($data);
        return view('casefiles.elements.select-assignee')->with('data',$data);

    }
}
