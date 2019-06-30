<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function assignedClients(){
        return $this->hasMany('App\AssignedClients');
    }

    public function clients(){
        return $this->hasMany('App\Clients');
    }
}
