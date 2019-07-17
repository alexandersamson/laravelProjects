<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * AssignedInvestigator
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class AssignedInvestigator extends Model
{
    public function casefile(){
        return $this->belongsTo('App\Casefile');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
