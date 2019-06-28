<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseState extends Model
{
    //
    public function casefiles(){
        return $this->hasMany('App\Casefile');
    }
}
