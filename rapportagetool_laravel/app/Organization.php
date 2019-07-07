<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
