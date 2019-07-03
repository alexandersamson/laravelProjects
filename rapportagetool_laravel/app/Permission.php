<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    // Table Name
    public $table = 'permissions';

    public function users(){
        return $this->hasMany('App\User');
    }

    public function clients(){
        return $this->hasMany('App\Client');
    }
}
