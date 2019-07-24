<?php

namespace App\Models;

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
