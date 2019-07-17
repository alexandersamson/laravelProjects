<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Vehicle
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class Vehicle extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'creator_id'); //creators
    }

    public function casefiles()
    {
        return $this->belongsToMany('App\Casefile', 'link_casefile_vehicles');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Client', 'link_client_vehicles');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Client', 'link_subject_vehicles');
    }
}
