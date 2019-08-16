<?php

namespace App;

use App\Mailer\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use Naux\Mail\SendCloudTemplate;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;
  //  protected $table = 'users';
  //  protected $primaryKey = 'user_id';
   // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token',
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
     * @param string $token
     */
    public function sendPasswordResetNotification($token){
        (new userMailer())->passWordReset($this->email, $token, $this->name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    /**
     * @param Model $model
     * @return bool
     * 判断该问题是否由该用户创建
     */
    public function owns(Model $model){
        return $this->id == $model->user_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 对关联表的操作
     */
    public function follows(){
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    /**
     * @param $question
     * @return array
     * 关注状态改变
     */
    public function followThis($question) {
        return $this->follows()->toggle($question); //toggle拥有反向的意思，if(存在)删除，else创建。
    }

    /**
     * @param $question
     * @return bool
     * 是否关注
     */
    public function followed($question) {
        return !! $this->follows()->where('question_id', $question)->count();
    }



    /**
     * 按照关注发起者进行查找
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers() {
        return $this->belongsToMany(self::class,
            'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * 按照被关注的人进行查找
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followersUsers() {
        return $this->belongsToMany(self::class,
            'followers', 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     * @param $user
     * @return array
     * 关注该用户
     */
    public function followThisUser($user) {
        return $this->followers()->toggle($user);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 点赞数据库对象获取
     */
    public function votes() {
        return $this->belongsToMany(Answer::class, 'votes')->withTimestamps();
    }


    /**
     * @param $answer
     * @return array
     * 点赞数据库添加/删除
     */
    public function voteFor($answer) {
        return $this->votes()->toggle($answer);
    }

    /**
     * @param $answer
     * @return bool
     * 是否已经点赞
     */
    public function hasVoteFor($answer) {
        return !! $this->votes()->where('answer_id', $answer)->count();
    }


    public function messages() {
        return $this->hasMany(Message::class, 'to_user_id');
    }


}
