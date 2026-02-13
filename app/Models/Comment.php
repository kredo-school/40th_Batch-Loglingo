<?php

namespace App\Models;

use App\Models\User;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Comment extends Model
{
    //comment belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}
