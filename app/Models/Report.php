<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    // 一括書き込みを許可する属性
    protected $fillable = [
        'user_id',
        'reportable_id',
        'reportable_type',
    ];

    /**
     * 通報対象（Post, Comment, Question, Answer）へのリレーション
     */
    public function reportable(): MorphTo
    {
        // reportable_id と reportable_type を使って自動判別します
        return $this->morphTo();
    }

    /**
     * 通報したユーザーへのリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}