<?php
/**
 * Created by PhpStorm.
 * User: FANS
 * Date: 2019/4/6
 * Time: 23:49
 */

namespace App\Mailer;

use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    protected function sendTo($template, $email, array $data) {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email){
            $message->from('chenyifan@dreamabout.com', 'dreamAbout');
            $message->to($email);
        });
    }
}