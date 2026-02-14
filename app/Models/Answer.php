<?php

namespace App\Models;

use App\Models\User;
use App\Models\Answer;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'a_content',
        'user_id',
        'question_id',
    ];

    //answer belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}