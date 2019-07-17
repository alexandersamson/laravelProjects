<?php

namespace App;

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
    //
    public function caseState(){
        return $this->belongsTo('App\CaseState');
    }

    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function assignedInvestigators(){
        return $this->hasMany('App\AssignedInvestigator');
    }

    public function assignedClients(){
        return $this->hasMany('App\AssignedClient');
    }

    public function assignedSubjects(){
        return $this->hasMany('App\AssignedSubject');
    }

    public function casenotes()
    {
        return $this->belongsToMany('App\Casenote', 'link_casefile_casenotes');
    }

    public function assets()
    {
        return $this->belongsToMany('App\Asset', 'link_casefile_assets');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle', 'link_casefile_vehicles');
    }
}
