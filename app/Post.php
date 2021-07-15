<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'study_hour', 'study_time', 'study_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id')->withTimestamps();
    }
    //$userがnullでも可
    public function isFavoritedBy(?User $user): bool
    {
        return $user
            //$userがnullでない時 型キャスト
            ? (bool)$this->favorites->where('id', $user->id)->count()
            //$userがnullの時
            : false;
    }
}
