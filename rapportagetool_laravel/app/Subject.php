<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function casefiles(){
        return $this->hasMany('App\Casefile');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function assignedSubjects(){
        return $this->hasMany('App\AssignedSubject');
    }

}
