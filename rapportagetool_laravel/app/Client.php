<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'clients';

    public function casefiles(){
        return $this->hasMany('App\Casefile');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function assignedClients(){
        return $this->hasMany('App\AssignedClient');
    }
}
