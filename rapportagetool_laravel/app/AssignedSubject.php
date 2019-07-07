<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedSubject extends Model
{
    public $table = 'assigned_subjects';

    public function casefile(){
        return $this->belongsTo('App\Casefile');
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }

}
