<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'clients';

    public function casefiles(){
        return $this->hasMany('App\Casefile');
    }
}
