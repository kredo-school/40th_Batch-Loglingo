<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Reply;
use App\Models\Question;
use App\Models\Language;

class Discussion extends Model
{
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
}
