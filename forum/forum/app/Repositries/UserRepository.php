<?php
/**
 * Created by PhpStorm.
 * User: FANS
 * Date: 2019/4/6
 * Time: 15:10
 */

namespace App\Repositries;


use App\Question;
use App\User;
use Auth;

/**
 * Class UserRepository
 * @package App\Repositries
 */
class UserRepository
{
    /**
     * @param $id
     * @return User|User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function byId($id) {
        return User::find($id);
    }

    public function nowLogin() {
        return Auth::guard()->user();
    }


    public function getFollowedQuestion($user) {
        return User::find($user)->with('follows')->first();
    }

    public function userAll() {
        return User::all();
    }


    public function getFollowers($user) {
        return User::find($user)->with('followersUsers')->first();
    }

    /**
     * @param $id
     * @return bool
     */
    public function setManagerR($id){
        return User::where('id', $id)->update(['authority' => "M"]);
    }
    public function setUserSimpleR($id) {
        return User::where('id', $id)->update(['authority' => "U"]);
    }
    public function setEditorR($id){
        return User::where('id', $id)->update(['authority' => "E"]);
    }
}