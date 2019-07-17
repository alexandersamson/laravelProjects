<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * AssignedSubject
 *
 * @mixin Eloquent
 * @mixin Builder
 */
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
