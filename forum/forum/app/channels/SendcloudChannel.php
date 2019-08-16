<?php
/**
 * Created by PhpStorm.
 * User: FANS
 * Date: 2019/4/6
 * Time: 23:16
 */

namespace App\channels;


use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable, Notification $notification) {
        $message = $notification->toSendcloud($notifiable);
    }

}