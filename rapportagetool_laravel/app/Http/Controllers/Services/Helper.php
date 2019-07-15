<?php

namespace App\Http\Controllers\Services;

use App\AssignedInvestigator;
use App\AssignedSubject;
use App\Casefile;
use App\CaseState;
use App\Http\Controllers\Controller;
use App\Organization;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Helper extends Controller
{
    //
    public static function getMockEmail(){
        return 'alexander@gm7.nl';
    }

    public static function getMockPassword(){
        return 'kippensoep';
    }



    public static function exists($cat, $id){
        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($cat, false, $id);
        if($obj){
            return true;
        }
        return false;
    }

    public static function needsApproval($category, $id){
        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($category, false, $id);
        if(!$obj->deleted) {
            return !$obj->approved;
        } else {
            return false;
        }
    }

    public static function isDeleted($category, $id){
        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($category, false, $id);
        if(!$obj){
            return false;
        }
        return $obj->deleted;
    }

    public static function isDraft($category, $id){
        $classNameService = new ClassNameService();
        $obj = $classNameService->getClassByCategory($category, false, $id);
        if(!$obj){
            return false;
        }
        return $obj->draft;
    }


    public static function getObjRowTitles($category){
        $rowTitles = array(
            'casefiles' => ['Casecode','Name','State','Lead Investigator','Clients','Subjects'],
            'users' => ['Name','Email','Phone','Roles'],
            'clients' => ['Name','City','Organization','E-mail','Casefiles'],
            'subjects' => ['Name','City','Occupation','Assigned Casefiles'],
            'posts' => ['Name','Written by','Created','Summary'],
            'licenses' => ['Name','Type','Issued to','Expires in'],
            'messages' => ['Name','From','Sent date'],
        );
        return $rowTitles[$category];
    }

    public static function getObjRowData($category, $obj){

        $rowData = array();
        if($category == 'casefiles'){
            $rowData[] = [
                $obj->casecode,
                $obj->name,CaseState::find($obj->case_state_index)->name,
                Helper::makeObjHyperlink(User::find(AssignedInvestigator::where('casefile_id', $obj->id)->where('is_lead_investigator', true)->first()->user_id)->name, 'users', User::find(AssignedInvestigator::where('casefile_id', $obj->id)->where('is_lead_investigator', true)->first()->user_id)->id),
                self::formatArrayText(self::extractObjs($obj->assignedClients, 'name', 'client' , 'clients', 2),','),
                self::formatArrayText(self::extractObjs($obj->assignedSubjects, 'name', 'subject' , 'subjects', 1),',')];
        }
        if($category == 'users'){
            $rowData[] = [$obj->name,$obj->email,$obj->phone,self::formatArrayText(PermissionsService::getPermissionsTextArray($obj->permission), ',')];
        }
        if($category == 'clients'){
            $rowData[] = [
                $obj->name,
                $obj->city,
                Organization::find($obj->organization_id)->name,
                $obj->email,
                self::formatArrayText(self::extractObjs($obj->assignedClients, 'casecode', 'casefile' , 'casefiles', 3),',')];
        }
        if($category == 'subjects'){
            $rowData[] = [$obj->name,$obj->city,$obj->occupation,self::formatArrayText(self::extractObjs($obj->assignedSubjects, 'casecode', 'casefile' , 'casefiles', 3),',')];
        }
        if($category == 'posts'){
            $rowData[] = [$obj->name,$obj->user->name,$obj->created_at,Str::limit(strip_tags(self::parseBB($obj->body)),84)];
        }
        if($category == 'messages'){
            $rowData[] = [$obj->name,$obj->user->name,$obj->created_at];
        }

        return $rowData;
    }

    public static function getDaysLeft($startDate, $formatted=true)
    {
        $returnStringAppend = '';
        $s = 's';
        $warningLimit = 92; //little over 3 months
        $expiredPre = '<span class="text-danger font-weight-bold">';
        $warningPre = '<span class="text-danger">';
        $warningPost = '</span>';
        $date = Carbon::parse($startDate);
        $now = Carbon::now();
        $diff = $now->diffInDays($date, false);
        $returnValue = '';
        if($diff > 1824){
            $returnValue = floor($diff / 365);
            $returnStringAppend = ' year';
            if($diff > 1){
                $returnStringAppend .= $s;
            }
        } elseif($diff > (364/30.4166)){
            $returnValue = floor($diff / 30.4166);
            $returnStringAppend = ' month';
            if($diff > 1){
                $returnStringAppend .= $s;
            }
        } elseif($diff > 1) {
            $returnValue = $diff;
            $returnStringAppend = ' days';
        } else if($diff > 0){
            $returnValue = $diff;
            $returnStringAppend = ' day';
        } else if($diff == 0){
            $returnValue = '';
            $returnStringAppend = 'today';
        } else {
            $returnValue = '';
            $returnStringAppend = 'expired';
        }
        if($diff < 1 && $formatted == true){
            return $expiredPre.$returnValue.$returnStringAppend.$warningPost;
        } else if($diff < $warningLimit && $formatted == true){
            return $warningPre.$returnValue.$returnStringAppend.$warningPost;
        } else {
            return $returnValue . $returnStringAppend;
        }
    }


    //extractObjs() Inserts:
    //Array of objects (obj)
    //Value to extract (string)
    //Via which model (optional, string)
    //category for hyperlink (optional, string)
    //limit the output (optional, integer)
    //append a text to last item if limit has been reached (optional, string)
    //check for Deleted and/or Approved objects (boolean)
    //reverse the output (optional boolean)
    public static function extractObjs($objArray, $extractValue, $extractVia = null, $categoryHyperlink = '', $limit = 4, $limitText = '...', $checkDelApprove = true, $reverseReturn = true){
        $returnArray = array();
        //dd($objArray[0]->casefile->casecode);
        $i=0;
        if(isset($objArray)) {
            foreach ($objArray as $obj) {
                if ($extractVia == null) {
                    if (isset($obj->$extractValue)) {
                        if (($obj->deleted == false || $obj->approved == true) || ($checkDelApprove == false)) {
                            if (++$i == $limit + 1) break;
                            if ($categoryHyperlink != '') {
                                $returnArray[] = self::makeObjHyperlink($obj->$extractValue, $categoryHyperlink, $obj->id, $obj->$extractVia->name);
                            } else {
                                $returnArray[] = $obj->$extractValue;
                            }
                        }
                    }
                } else {
                    if (isset($obj->$extractVia->$extractValue)) {
                        if (($obj->$extractVia->deleted == false || $obj->$extractVia->approved == true) || ($checkDelApprove == false)) {
                            if (++$i == $limit + 1) break;
                            if ($categoryHyperlink != '') {
                                $returnArray[] = self::makeObjHyperlink($obj->$extractVia->$extractValue, $categoryHyperlink, $obj->$extractVia->id, $obj->$extractVia->name);
                            } else {
                                $returnArray[] = $obj->$extractVia->$extractValue;
                            }
                        }
                    }
                }
            }
        } else {
            return [];
        }
        if($reverseReturn == true) {
            $returnArray = array_reverse($returnArray);
        }
        if($i > $limit && $limitText != ''){
            $returnArray[$limit] = $limitText;
        }
        return $returnArray;

    }


    public static function formatArrayText($inputArray = [], $delimiter = ' |'){
        $returnString = '';
        $counter = 0;
        foreach($inputArray as $item) {
            if ($counter > 0) {
                $returnString .= $delimiter.' ';
            }
            $returnString .= $item;
            $counter++;
        }
        return $returnString;
    }

    public static function makeObjHyperlink($string,$cat,$obj, $title = ''){
        if($title == ''){
            $title = $string;
        }
        return "<a title=\"$title\" href=\"$cat/$obj\">$string</a>";
    }





    //  custom BB parser [parseBB] - 2019 - Alexander Samson
    //  Add items to the $bbCodes array as you wish.
    //  [#*S*#] points to the string between the 'openTag' and 'closeTag'
    //  [#*R*#] points to the name of an object searched for by the value of  [#*S*#] in the model's table and is
    //  defined by 'Rcat'. Rcat is not necessary when this database functionality is not needed.
    public static function parseBB($string = '')
    {

        $bbCodes = array(
            [
                'openTag' => '[cc]',
                'closeTag' => '[/cc]',
                'replace' => '<a href="/casefiles/cc/[#*S*#]">[#*S*#]</a>',
                'Rcat' => '',
            ],
            [
                'openTag' => '[user]',
                'closeTag' => '[/user]',
                'replace' => '<a href="/users/[#*S*#]">[#*R*#]</a>',
                'Rcat' => 'users'
            ],
            [
                'openTag' => '[b]',
                'closeTag' => '[/b]',
                'replacement' => '<span class="font-weight-bolder">[#*S*#]</span>',
                'Rcat' => ''
            ],
            [
                'openTag' => '[i]',
                'closeTag' => '[/i]',
                'replacement' => '<span class="font-italic">[#*S*#]</span>',
                'Rcat' => ''
            ],
            [
                'openTag' => '[red]',
                'closeTag' => '[/red]',
                'replace' => '<span class="text-danger">[#*S*#]</span>',
                'Rcat' => ''
            ],
            [
                'openTag' => '[green]',
                'closeTag' => '[/green]',
                'replace' => '<span class="text-success">[#*S*#]</span>',
                'Rcat' => ''
            ],
            [
                'openTag' => '[blue]',
                'closeTag' => '[/blue]',
                'replace' => '<span class="text-primary">[#*S*#]</span>',
                'Rcat' => ''
            ],
        );

        foreach ($bbCodes as $bbCode){
            while ((substr_count($string, $bbCode['openTag']) > 0) && (substr_count($string, $bbCode['closeTag']) > 0)) {
                $startPos = strpos($string, $bbCode['openTag']);
                $endPhrasePos = strpos($string, $bbCode['closeTag'], $startPos);
                $substrToReplace = substr($string, $startPos, ($endPhrasePos - $startPos + strlen($bbCode['closeTag'])));
                $substrValueS = substr($string, $startPos + strlen($bbCode['openTag']), ($endPhrasePos - $startPos - strlen($bbCode['openTag'])));
                if($bbCode['Rcat'] !== ''){
                    $categories = \Config::get('categories');
                    $cns = new ClassNameService;
                    $class = $cns->getClassByCategory($categories[$bbCode['Rcat']]);
                    $substrValueR = ' ... ';
                    $obj = $class::find($substrValueS);
                    if($obj){
                        $objName = $obj->name;
                        $substrValueR = $objName;
                    } else {
                        $obj = $class::where('name', 'LIKE', '%'.$substrValueS.'%')->first();
                        if($obj) {
                            $objName = $obj->name;
                            $substrValueR = $objName;
                        }
                    }
                    $replaceString = str_replace('[#*R*#]', $substrValueR, $bbCode['replace']);
                    $string = str_replace($substrToReplace, str_replace('[#*S*#]', $substrValueS, $replaceString), $string);
                } else {
                    $string = str_replace($substrToReplace, str_replace('[#*S*#]', $substrValueS, $bbCode['replace']), $string);
                }
            }
        }
        return $string;

    }

}
