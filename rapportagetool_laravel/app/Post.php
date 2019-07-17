<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Post
 *
 * @mixin Eloquent
 * @mixin Builder
 */
class Post extends Model
{
    // Table Name
    public $table = 'posts';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User' , 'creator_id');
    }
}
