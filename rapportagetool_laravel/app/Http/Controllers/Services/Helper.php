<?php

namespace App\Http\Controllers\Services;

use App\AssignedInvestigator;
use App\AssignedSubject;
use App\CaseState;
use App\Http\Controllers\Controller;
use App\Organization;
use App\User;
use Illuminate\Support\Carbon;
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
            $returnStringAppend = ' days';
        } else if($diff > 0){
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
        return $obj->deleted;
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

    public static function parseBB($string = ''){
        //str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] ) : mixed
        //strpos ( string $haystack , mixed $needle [, int $offset = 0 ] ) : int

        //CC[...]
        //Change Casecodes from CC|XXXXX|  to a working CC-link

        while((substr_count($string, '[cc]') > 0) && (substr_count($string, '[/cc]') > 0)){
            $startPos = strpos($string, '[cc]');
            $endPhrasePos = strpos($string, '[/cc]', $startPos);
            $substrToReplace = substr ( $string, $startPos, ($endPhrasePos-$startPos+5));
            $substrValue = substr ( $string, $startPos+4, ($endPhrasePos-$startPos-4));
            $string = str_replace($substrToReplace, '<a href="/casefiles/cc/'.$substrValue.'">'.$substrValue.'</a>', $string);
            $startPos += 4;
        }

        while((substr_count($string, '[bold]') > 0) && (substr_count($string, '[/bold]') > 0)){

            $startPos = strpos($string, '[bold]');
            $endPhrasePos = strpos($string, '[/bold]', $startPos);
            $substrToReplace = substr ( $string, $startPos, ($endPhrasePos-$startPos+7));
            $substrValue = substr ( $string, $startPos+6, ($endPhrasePos-$startPos-6));
            $string = str_replace($substrToReplace, '<span class="font-weight-bolder">'.$substrValue.'</span>', $string);
        }

        while((substr_count($string, '[red]') > 0) && (substr_count($string, '[/red]') > 0)){
            $startPos = strpos($string, '[red]');
            $endPhrasePos = strpos($string, '[/red]', $startPos);
            $substrToReplace = substr ( $string, $startPos, ($endPhrasePos-$startPos+6));
            $substrValue = substr ( $string, $startPos+5, ($endPhrasePos-$startPos-5));
            $string = str_replace($substrToReplace, '<span class="text-danger">'.$substrValue.'</span>', $string);
            $startPos += 5;
        }

        while((substr_count($string, '[blue]') > 0) && (substr_count($string, '[/blue]') > 0)){
            $startPos = strpos($string, '[blue]');
            $endPhrasePos = strpos($string, '[/blue]', $startPos);
            $substrToReplace = substr ( $string, $startPos, ($endPhrasePos-$startPos+7));
            $substrValue = substr ( $string, $startPos+6, ($endPhrasePos-$startPos-6));
            $string = str_replace($substrToReplace, '<span class="text-primary">'.$substrValue.'</span>', $string);
        }

        while((substr_count($string, '[green]') > 0) && (substr_count($string, '[/green]') > 0)){
            $startPos = strpos($string, '[green]');
            $endPhrasePos = strpos($string, '[/green]', $startPos);
            $substrToReplace = substr ( $string, $startPos, ($endPhrasePos-$startPos+8));
            $substrValue = substr ( $string, $startPos+7, ($endPhrasePos-$startPos-7));
            $string = str_replace($substrToReplace, '<span class="text-success">'.$substrValue.'</span>', $string);
        }

        return $string;
    }

}
