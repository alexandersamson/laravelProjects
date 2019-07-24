<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Asset
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class Asset extends Model
{
    public function creator(){
        return $this->belongsTo('App\Models\User', 'creator_id'); //creators
    }

    public function casefiles()
    {
        return $this->belongsToMany('App\Models\Casefile', 'link_casefile_assets');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client', 'link_client_assets');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\Client', 'link_subject_assets');
    }
}
