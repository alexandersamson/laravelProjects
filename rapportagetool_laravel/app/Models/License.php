<?php

namespace App\Models;

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
        return $this->belongsTo('App\Models\User');
    }

    public function organization(){
        return $this->belongsTo('App\Models\Organization');
    }
}
