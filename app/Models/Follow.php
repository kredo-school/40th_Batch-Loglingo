<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public $timestamps = false;

    //follow belngs to user (paired with follows())
    public function following(){
        return $this->belongsTo(User::class, 'following_id')->withTrashed();
    }

    // follow belongs to user(paired with follows())
    public function follower(){
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }
}
