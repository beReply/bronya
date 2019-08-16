<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name', 'questions_count', 'bio'];

    public function questions()
    {
        //withTimestamps用于填写question_topic中的时间字段
        return $this->belongsToMany(Question::class)->withTimestamps();

    }
}
