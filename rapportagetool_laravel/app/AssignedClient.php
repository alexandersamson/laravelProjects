<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * AssignedClient
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class AssignedClient extends Model
{
    public function casefile(){
        return $this->belongsTo('App\Casefile');
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }

}
