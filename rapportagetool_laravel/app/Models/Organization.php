<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Organization
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class Organization extends Model
{
    public function creator(){
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function assignedClients(){
        return $this->hasMany('App\Models\PivotLinks\LinkCasefileClient');
    }

    public function clients(){
        return $this->hasMany('App\Models\Client');
    }

    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }

    public function licenses(){
        return $this->hasMany('App\Models\Licenses');
    }
}
