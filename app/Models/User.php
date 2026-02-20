<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User;
use App\Models\Language;
use App\Models\Post;
use App\Models\Question;
use App\Models\Follow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'f_lang',
        's_lang',
        'avatar',
        'introduction',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // user's language tags
    public function firstLanguage()
    {
        return $this->belongsTo(Language::class, 'f_lang');
    }

    public function studyLanguage()
    {
        return $this->belongsTo(Language::class, 's_lang');
    }

    // for profile tabs
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function followings()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'following_id'
        );
    }

    public function isFollowing(User $user): bool
    {
    return $this->followings()
        ->where('following_id', $user->id)
        ->exists();
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_id',
            'follower_id'
        );
    }

    // check if log in user is following this user
    public function isFollowed(): bool
    {
        return $this->followers()
            ->where('follower_id', Auth::id())
            ->exists();
    }

    // 任意ユーザーがこのユーザーをフォローしているか
    public function isFollowedBy(User $user): bool
    {
        return $this->followers()
            ->where('follower_id', $user->id)
            ->exists();
    }

}




    // public function followsYou(){
    //     return $this->follow()->where('following_id', Auth::user()->id)->exists();
    // }

