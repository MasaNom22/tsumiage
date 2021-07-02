<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'self_introduction', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //フォロワーがフォローしているユーザー
    public function followings()
    {
        /* 第一引数は使用するモデル 第二引数は使用する中間テーブル
        第３引数はリレーションを定義しているモデルの外部キー名、第４引数には結合するモデルの外部キー名 */
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }

    //ユーザーにフォローされているフォロワー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }

    //すでにフォロー中であるかどうか
    public function is_following(User $user)
    {    
        return $this->followings()->where('followee_id', $user->id)->exists();
    }

    public function follow($user)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($user->id);
        // 対象が自分自身かどうかの確認
        $myself = $this->id == $user->id;

        if ($exist || $myself) {
            // すでにフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($user->id);
        }
    }

    public function unfollow(User$user)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($user->id);
        // 対象が自分自身かどうかの確認
        $myself = $this->id == $user->id;

        if ($exist && !$myself) {
            // すでにフォローしていればフォローを外す
            $this->followings()->detach($user->id);
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
}
