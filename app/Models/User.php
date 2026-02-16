<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Question;
use App\Models\User;
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

    // for profile tabs
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // user follows many users
    // public function follow()
    // {
    //     return $this->hasMany(Follow::class, 'follower_id');
    // }

    // user has many followers    
    // public function followers()
    // {
    //     return $this->hasMany(Follow::class, 'following_id');
    // }

    public function followings()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'following_id'
        );
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

