<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casefile extends Model
{
    //
    public function caseState(){
        return $this->belongsTo('App\CaseState');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }
}
