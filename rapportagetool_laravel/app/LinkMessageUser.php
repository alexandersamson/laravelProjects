<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkMessageUser extends Model
{
    public function message(){
        return $this->belongsTo('App\Message'); // the message
    }

    public function user(){
        return $this->belongsTo('App\User'); //the recipient
    }

}
