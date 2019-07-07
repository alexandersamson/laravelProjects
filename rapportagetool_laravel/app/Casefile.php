<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casefile extends Model
{
    protected $table = 'casefiles';
    //
    public function caseState(){
        return $this->belongsTo('App\CaseState');
    }

    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function assignedInvestigators(){
        return $this->hasMany('App\AssignedInvestigator');
    }

    public function assignedClients(){
        return $this->hasMany('App\AssignedClient');
    }

    public function assignedSubjects(){
        return $this->hasMany('App\AssignedSubject');
    }
}
