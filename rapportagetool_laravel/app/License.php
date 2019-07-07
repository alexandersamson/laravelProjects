<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }
}
