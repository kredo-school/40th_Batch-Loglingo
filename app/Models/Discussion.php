<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Reply;
use App\Models\Question;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Bookmark;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'd_title',
        'd_content',
        'is_resolved',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Language::class, 'language_post', 'discussion_id', 'language_id',);
    }

    public function isReportedByMe()
    {
        return $this->reports()->where('user_id', auth()->id())->exists();
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function getTotalReportsCountAttribute(): int
    {
        // number of reports to discussion
        $discussionReports = $this->reports()->count();

        // total report number
        $repliesReports = $this->replies->sum(function ($reply) {
            return $reply->reports()->count();
        });

        return $discussionReports + $repliesReports;
    }


    //bookmark feature
    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function isBookmarkedBy($user): bool
    {
        if (!$user) return false;

        return $this->bookmarks()
            ->where('user_id', $user->id)
            ->exists();
    }
}
