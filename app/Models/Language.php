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
        'color',
        'status',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'language_post', 'language_id', 'question_id');
    }

    public function getBadgeColor(): string
    {
        return match ($this->color) {
            'red'     => 'bg-red-50 text-red-600 border-red-200',
            'blue'    => 'bg-blue-50 text-blue-600 border-blue-200',
            'green'   => 'bg-green-50 text-green-600 border-green-200',
            'yellow'  => 'bg-yellow-50 text-yellow-700 border-yellow-200',
            'indigo'  => 'bg-indigo-50 text-indigo-600 border-indigo-200',
            'purple'  => 'bg-purple-50 text-purple-600 border-purple-200',
            'pink'    => 'bg-pink-50 text-pink-600 border-pink-200',
            'orange'  => 'bg-orange-50 text-orange-600 border-orange-200',
            'teal'    => 'bg-teal-50 text-teal-600 border-teal-200',
            'cyan'    => 'bg-cyan-50 text-cyan-600 border-cyan-200',
            'lime'    => 'bg-lime-50 text-lime-700 border-lime-200',
            'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
            'sky'     => 'bg-sky-50 text-sky-600 border-sky-200',
            'amber'   => 'bg-amber-50 text-amber-700 border-amber-200',
            'rose'    => 'bg-rose-50 text-rose-600 border-rose-200',
            'gray'    => 'bg-gray-50 text-gray-600 border-gray-200',
            default   => 'bg-gray-50 text-gray-600 border-gray-200',
        };
    }
}
