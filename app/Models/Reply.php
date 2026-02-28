<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'discussion_id',
        'user_id',
        'r_content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function isReportedByMe()
    {
        return $this->reports()->where('user_id', auth()->id())->exists();
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
