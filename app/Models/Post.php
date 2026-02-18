<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\User;
use App\Models\Comment;
use App\Models\Language;
use App\Models\Report;


class Post extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'p_title',
        'p_content',
        'event_date',
        'status',
    ];

     protected $casts = [
        'event_date' => 'date', 
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

    public function getTotalReportsCountAttribute(): int
    {
        // number of reports to post
        $postReports = $this->reports()->count();

        // total report number
        $commentsReports = $this->comments->sum(function ($comment) {
            return $comment->reports()->count();
        });

        return $postReports + $commentsReports;
    }
}



