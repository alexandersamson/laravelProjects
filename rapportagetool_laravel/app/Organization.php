<?php

namespace App;

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
    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function assignedClients(){
        return $this->hasMany('App\AssignedClient');
    }

    public function clients(){
        return $this->hasMany('App\Client');
    }

    public function subjects(){
        return $this->hasMany('App\Subject');
    }

    public function licenses(){
        return $this->hasMany('App\Licenses');
    }
}
