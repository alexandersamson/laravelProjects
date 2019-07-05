<?php

namespace App\Http\Controllers;

use App\AssignedClient;
use App\AssignedInvestigator;
use App\Casefile;
use App\CaseState;
use App\Client;
use App\Organization;
use App\Permission;
use App\Post;
use App\User;
use DB;
use Illuminate\Http\Request;

class CheckDeleteController extends Controller
{
    //
    public function checkDelete($category, $id)
    {
        $confirmDeleteHtmlPre = 'Do you really want to delete <strong>';
        $confirmDeleteHtmlPost = '</strong> ?';
        $errorDeleteHtml = 'This item cannot be deleted or has been deleted already.';
        $category = preg_replace('/[^a-zA-Z0-9]+/', '', $category);
        $id =  preg_replace('/[^a-zA-Z0-9]+/', '', $id);

        $sqlReturn = DB::table($category)
            ->selectRaw('*')->where( 'id', '=', $id,)->get();
        if(isset($sqlReturn[0]->id)){
            if(isset($sqlReturn[0]->title)){
                return $confirmDeleteHtmlPre.$sqlReturn[0]->title.$confirmDeleteHtmlPost;
            } elseif(isset($sqlReturn[0]->name)) {
                return $confirmDeleteHtmlPre.$sqlReturn[0]->name.$confirmDeleteHtmlPost;
            } else {
                return $confirmDeleteHtmlPre.$sqlReturn[0]->id.$confirmDeleteHtmlPost;
            }
        } else{
            return $errorDeleteHtml;
        }

    }

    public function delete($category, $id)
    {

        $errorDeleteHtml = 'This item cannot be deleted or has been deleted already.';
        $category = preg_replace('/[^a-zA-Z0-9]+/', '', $category);
        $id =  preg_replace('/[^a-zA-Z0-9]+/', '', $id);

        if($category == 'users'){
            $sqlReturn = User::where('id', $id)->delete();
        }
        if($category == 'posts'){
            $sqlReturn = Post::where('id', $id)->delete();
        }
        if($category == 'clients'){
            $sqlReturn = Client::where('id', $id)->delete();
        }
        if($category == 'casefiles'){
            $sqlReturn = Casefile::where('id', $id)->delete();
        }
        if($category == 'assigned_investigators'){
            $sqlReturn = AssignedInvestigator::where('id', $id)->delete();
        }
        if($category == 'assigned_clients'){
            $sqlReturn = AssignedClient::where('id', $id)->delete();
        }
        if($category == 'permissions'){
            $sqlReturn = Permission::where('id', $id)->delete();
        }
        if($category == 'organizations'){
            $sqlReturn = Organization::where('id', $id)->delete();
        }
        if($category == 'case_states'){
            $sqlReturn = CaseState::where('id', $id)->delete();
        }
        return;

    }
}
