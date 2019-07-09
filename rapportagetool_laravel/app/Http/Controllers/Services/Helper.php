<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class Helper extends Controller
{
    //

    public static function getDaysLeft($startDate)
    {
        $returnStringAppend = '';
        $s = 's';
        $date = Carbon::parse($startDate);
        $now = Carbon::now();
        $diff = $now->diffInDays($date, false);
        if($diff > 364){
            $diff = floor($diff / 365);
            $returnStringAppend = ' year';
            if($diff > 1){
                $returnStringAppend .= $s;
            }
        } elseif($diff > 1) {
            $returnStringAppend = ' days';
        } else if($diff > 0){
            $returnStringAppend = ' day';
        } else if($diff == 0){
            $diff = '';
            $returnStringAppend = 'today';
        } else {
            $diff = '';
            $returnStringAppend = 'expired';
        }
        return $diff.$returnStringAppend;
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

}
