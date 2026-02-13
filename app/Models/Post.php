<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Language;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Post extends Model
{

    protected $fillable = [
        'user_id',
        'p_title',
        'p_content',
        'event_date',
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

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}



