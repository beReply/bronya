<?php
/**
 * Created by PhpStorm.
 * User: FANS
 * Date: 2019/4/7
 * Time: 3:10
 */

namespace App\Repositries;


use App\Message;
use App\User;

class MessageRepository
{
    public function create(array $attributes) {
        return Message::create($attributes);
    }

    public function ReadFromOther($user_id) {
        return Message::all()->where('to_user_id', $user_id);
    }

    public function ReadToOther($user_id) {
        return Message::all()->where('from_user_id',$user_id);
    }
}