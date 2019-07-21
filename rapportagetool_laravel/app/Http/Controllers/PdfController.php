<?php

namespace App\Http\Controllers;

use App\AssignedInvestigator;
use App\CaseState;
use App\Traits\ControllerHelper;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    use ControllerHelper;

    public function toPdf($category, $id)
    {
        $categories = \Config::get('categories');
        $pdfTitle = 'Title';
        $checksumHash = '';
        $data = array('category' => $categories['casefiles'],);

        if ($category == $categories['casefiles']) {
            $obj = $this->checkAndGetObjToShow($categories[$category], $id);
            $leader = AssignedInvestigator::where('casefile_id',$id)
                ->where('is_lead_investigator',true)
                ->first()
                ->user;
            $data['leader'] = $leader;
            $creator = User::find($obj->creator_id);
            $modifier = User::find($obj->modifier_id);
            $createdAt = $obj->created_at;
            $modifiedAt = $obj->updated_at;
            $pdfTitle = $obj->casecode;
            $checksumHash = hash('sha256', (serialize($obj))); //TODO: Generalize this checksum hashing in some global helper

        }
        if (isset($obj)){
            //Data array filling
            $data['obj'] = $obj;
            $data['creator'] = $creator;
            $data['createdAt'] = $createdAt;
            $data['modifiedAt'] = $modifiedAt;
            $data['modifier'] = $modifier;
            $data['checksumHash'] = $checksumHash;
            //ActionLog
            $actionLog = new ActionLogsController;
            $actionLog->insertAction($obj, 'Make PDF');
            //Load PDF and view
            $pdf = PDF::loadView('pdf.pdf-'.$categories[$category], $data);
            return $pdf->stream($categories[$category] . '_' . $obj->id . '_' . $pdfTitle . '.pdf');
        } else {
            return abort(404);
        }
    }
}
