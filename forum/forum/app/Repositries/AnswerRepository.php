<?php
/**
 * Created by PhpStorm.
 * User: FANS
 * Date: 2019/3/31
 * Time: 23:01
 */

namespace App\Repositries;


use App\Answer;

class AnswerRepository
{
    public function create(array $attributes){
        return Answer::create($attributes);
    }

    public function byId($id){
        return Answer::find($id);
    }

}