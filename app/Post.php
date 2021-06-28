<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'study_hour', 'study_time', 'study_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
