<?php

namespace App\Http\Controllers\Services;


use App\Http\Controllers\Controller;

class CasefileNumberGenerator extends Controller
{
    public function generateRandomString($length = 6) {
        $characters = '123456789CFGHJKMNPQTWX';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateCasefileCode(){
        $agencyPrefix = 'DFA'; //TODO: from dbase settings
        $seperator = '';
        $randomAmount = 6; //TODO: from dbase settings
        $yearString = date('y'); //TODO from dbase settings
        $newCode = $agencyPrefix . $seperator . $yearString . $seperator . $this->generateRandomString($randomAmount);
        return $newCode; //Expected output format AAAsYYsRRRRRR (A = Agency, s = Seperator, Y = year, R = random)
    }
}