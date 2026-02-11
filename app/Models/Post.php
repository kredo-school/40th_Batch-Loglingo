<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'user_id',
        'p_title',
        'p_content',
    
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // post has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Language::class, 'language_post', 'post_id', 'language_id');
    }


}
