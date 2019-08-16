<?php
/**
 * Created by PhpStorm.
 * User: FANS
 * Date: 2019/4/6
 * Time: 23:58
 */

namespace App\Mailer;

use App\User;
use Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email) {
        $data = [
            'url' => url('/'),
            'name' => Auth::guard('api')->user()->name
        ];

        $this->sendTo('user_followed', $email, $data);
    }

    public function passWordReset($email,$token, $name) {
        $data = [
            'url' => url('password/reset', $token),
            'name' => $name
            ];

        $this->sendTo('pass_reset', $email, $data);
    }

    public function welcome(User $user) {
        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name,
        ];

        $this->sendTo('test_template_active', $user->email, $data);

        $user_master = User::find(2);
        $this->sendTo('test_template_active', $user_master->email, $data);
    }
}