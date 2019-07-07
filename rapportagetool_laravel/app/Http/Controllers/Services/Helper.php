<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Carbon;

class Helper
{
    //

    public function getDaysLeft($startDate)
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

}
