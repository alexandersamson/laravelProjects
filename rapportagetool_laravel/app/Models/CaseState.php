<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * CaseState
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class CaseState extends Model
{
    //
    public function casefiles(){
        return $this->hasMany('App\Models\Casefile');
    }
}
