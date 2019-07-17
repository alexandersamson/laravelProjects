<?php

namespace App;

use Eloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
/**
 * User
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'creator_id', 'modifier_id', 'profile_picture_path'
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
        'email_verified_at' => 'datetime',
        'permission' => 'integer',
        'deleted' => 'boolean',
        'approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function getPermissionAttribute($value)
    {
        return $value;
    }



    public function actionLogs(){
        return $this->hasMany('App\ActionLog');
    }

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

    public function messages(){
        return $this->belongsToMany('App\Message', 'link_message_users');
    }

    public function casenotes()
    {
        return $this->belongsToMany('App\Casenote', 'link_casefile_casenotes');
    }


    public function assignedInvestigators(){
        return $this->hasMany('App\AssignedInvestigator');
    }

    public function permissing(){
        return $this->belongsTo('App\Permission');
    }
}
