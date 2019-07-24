<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Casefile
 *
 * @mixin Eloquent
 * @mixin Builder
 */

class Casefile extends Model
{
    protected $table = 'casefiles';



    public function getIntegrityAttribute()
    {
        return hash('sha256', (serialize($this)));

    }

    public function caseState(){
        return $this->belongsTo('App\Models\CaseState');
    }



    public function creator(){
        return $this->belongsTo('App\Models\User', 'creator_id', 'id');
    }

    public function modifier(){
        return $this->belongsTo('App\Models\User', 'modifier_id', 'id');
    }

    //Assignables
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'link_casefile_users');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client', 'link_casefile_clients');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject', 'link_casefile_subjects');
    }

    public function casenotes()
    {
        return $this->belongsToMany('App\Models\Casenote', 'link_casefile_casenotes');
    }

    public function assets()
    {
        return $this->belongsToMany('App\Models\Asset', 'link_casefile_assets');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'link_casefile_vehicles');
    }
}
