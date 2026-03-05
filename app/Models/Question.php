<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Language;
use App\Models\User;
use App\Models\Report;
use App\Models\Answer;
use App\Models\Bookmark;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'q_title',
        'q_content',
        'written_lang',
        'status',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'written_lang');
    }

    public function tags()
    {
        return $this->belongsToMany(Language::class, 'language_post', 'question_id', 'language_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // post has many answers
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function getTotalReportsCountAttribute(): int
    {
        // number of reports to question
        $questionReports = $this->reports()->count();

        // total report number
        $answersReports = $this->answers->sum(function ($answer) {
            return $answer->reports()->count();
        });

        return $questionReports + $answersReports;
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
