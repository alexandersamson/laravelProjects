<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Table Name
    public $table = 'messages';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User', 'creator_id'); //creators
    }

    public function linkMessageUsers(){
        return $this->hasMany('App\LinkMessageUser'); //recipients
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'link_message_users');
    }

}
