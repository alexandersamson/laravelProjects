<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Client
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class Client extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


    protected $table = 'clients';

    public function user(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function assignedClients(){
        return $this->hasMany('App\AssignedClient');
    }


    public function permission(){
        return $this->belongsTo('App\Permission' );
    }

    public function assets()
    {
        return $this->belongsToMany('App\Asset', 'link_client_assets');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle', 'link_client_vehicles');
    }
}
