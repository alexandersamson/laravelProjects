<?php

namespace App\Models;

use Eloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\HasApiTokens;

/**
 * User
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    public function scopeLeader($query, $role)
    {
        if ($role) {
            if($role == 'leaders') {
                return $query->where('is_lead_investigator', true);
            } else {
                return $query->where('is_lead_investigator', false);
            }
        }
        return $query;
    }

    public function getPermissionAttribute($value)
    {
        return $value;
    }

    public function creator(){
        return $this->belongsTo('App\Models\User', 'creator_id'); //creators
    }

    public function modifier(){
        return $this->belongsTo('App\Models\User', 'modifier_id', ); // Modifiers
    }

    public function permissing(){
        return $this->belongsTo('App\Models\Permission');
    }

    public function actionLogs(){
        return $this->hasMany('App\Models\ActionLog');
    }

    public function posts(){
        return $this->hasMany('App\Models\Post');
    }

    public function userSettings(){
        return $this->hasMany('App\Models\UserSetting');
    }

    public function casefiles() // assignee as investigator
    {
        return $this->belongsToMany('App\Models\Casefile', 'link_casefile_users');
    }

    public function licenses(){
        return $this->hasMany('App\Models\Licenses');
    }

    public function messages(){
        return $this->belongsToMany('App\Models\Message', 'link_message_users');
    }

    public function casenotes()
    {
        return $this->belongsToMany('App\Models\Casenote', 'link_casefile_casenotes');
    }

}
