<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use App\Models\User;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
