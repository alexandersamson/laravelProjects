<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Casenote
 *
 * @mixin Eloquent
 * @mixin Builder
 */

class Casenote extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'creator_id'); //creators
    }

    public function casefiles()
    {
        return $this->belongsToMany('App\Casefile', 'link_casefile_casenotes');
    }
}
