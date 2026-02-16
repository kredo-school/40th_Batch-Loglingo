<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'status',
        ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'language_post', 'language_id', 'question_id');
    }
}
