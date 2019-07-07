<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function assignedClients(){
        return $this->hasMany('App\AssignedClient');
    }

    public function permission(){
        return $this->belongsTo('App\Permission' );
    }
}
