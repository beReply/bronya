<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * @package App
 */
class Question extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function topics(){
        //withTimestamps用于填写question_topic中的时间字段
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers() {
        return $this->belongsToMany(User::class, 'user_question')->withTimestamps();
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query){
        return $query->where('is_hidden', 'F');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * 和comment的关系，是一个多态关联的关系
     */
    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
