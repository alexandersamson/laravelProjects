<?php

namespace App;

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
        return $this->belongsTo('App\User' , 'creator_id');
    }
}
