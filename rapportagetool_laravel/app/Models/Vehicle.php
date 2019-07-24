<?php

namespace App\Models;

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
    public function creator(){
        return $this->belongsTo('App\Models\User', 'creator_id'); //creators
    }

    public function casefiles()
    {
        return $this->belongsToMany('App\Models\Casefile', 'link_casefile_vehicles');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client', 'link_client_vehicles');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\Client', 'link_subject_vehicles');
    }
}
