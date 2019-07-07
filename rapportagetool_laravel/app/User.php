<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];


    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function userSettings(){
        return $this->hasMany('App\UserSetting');
    }

    public function casefiles(){
        return $this->hasMany('App\Casefile');
    }

    public function licenses(){
        return $this->hasMany('App\Licenses');
    }

    public function assignedInvestigators(){
        return $this->hasMany('App\AssignedInvestigator');
    }

    public function permissing(){
        return $this->belongsTo('App\Permission');
    }
}
