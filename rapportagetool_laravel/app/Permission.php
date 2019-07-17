<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Permission
 *
 * @mixin Eloquent
 * @mixin Builder
 */
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
