<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * ActionLog
 *
 * @mixin Eloquent
 * @mixin Builder
 */


class ActionLog extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\User' , 'creator_id');
    }
}
