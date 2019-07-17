<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Client
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class License extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }
}
