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
class Client extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


    public function creator(){
        return $this->belongsTo('App\Models\User', 'creator_id'); //creators
    }

    public function modifier(){
        return $this->belongsTo('App\Models\User', 'modifier_id', ); // Modifiers
    }

    public function casefiles()
    {
        return $this->belongsToMany('App\Models\Casefile', 'link_casefile_casenotes');
    }
}
