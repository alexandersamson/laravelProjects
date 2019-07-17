<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * UserSetting
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class UserSetting extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
}
