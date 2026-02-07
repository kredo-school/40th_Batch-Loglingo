<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'q_title',
        'q_content',
        'written_lang',
        'user_id'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'written_lang');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
