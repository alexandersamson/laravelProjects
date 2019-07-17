<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Subject
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class Subject extends Model
{
    protected $table = 'subjects';

    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function casefiles(){
        return $this->hasMany('App\Casefile');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function assignedSubjects(){
        return $this->hasMany('App\AssignedSubject');
    }

    public function assets()
    {
        return $this->belongsToMany('App\Asset', 'link_subject_assets');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle', 'link_subject_vehicles');
    }

}
