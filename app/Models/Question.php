<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Language;
use App\Models\User;
use App\Models\Report;
use App\Models\Answer;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'q_title',
        'q_content',
        'written_lang',
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
    
}
