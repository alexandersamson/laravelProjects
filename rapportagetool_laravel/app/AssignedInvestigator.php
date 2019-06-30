<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedInvestigator extends Model
{
    public function casefile(){
        return $this->belongsTo('App\Casefile');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
