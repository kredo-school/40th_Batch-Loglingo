<?php

namespace App\Models;

use App\Models\User;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;
    
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
