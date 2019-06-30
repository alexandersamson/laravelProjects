<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedClient extends Model
{
    public function casefile(){
        return $this->belongsTo('App\Casefile');
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }
}
