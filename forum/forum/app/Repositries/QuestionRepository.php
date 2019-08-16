<?php
/**
 * Created by PhpStorm.
 * User: FANS
 * Date: 2019/3/27
 * Time: 20:50
 */

namespace App\Repositries;

use App\Question; //引入问题表model
use App\Topic;    //引入话题表model


/**
 * Class QuestionRepository
 * @package App\Repositries
 */
class QuestionRepository
{


    /**
     * @param $id
     * @return Question|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function byIdwithTopicsAndAnswers($id){
        return Question::where('id', $id)->with('topics', 'answers')->first();
    }

    public function create(array $attributes){
        return Question::create($attributes);
    }

    public function byId($id){
        return Question::find($id);
    }

    public function getQuestionAll(){
        return Question::paginate(10);//where('id', '<', 100)->paginate(10);
    }

    public function getQuestionsFeed(){
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    public function getTopic(){
        return Topic::all();
    }

    public function getTopicById($id){
        return Topic::find($id);
    }

    /**
     * 用处;取出用户输入在select2的topic
     *如果topic没有被route/api.php转化为数字，
     * 则说明数据库中没有该topic，则将该字段作为新的topic存入数据库并获取其id
     * 最后的返回值是用户所选的所有的topic组成的数组。
     *
     *input: $topic //用户在select2中填入的一些topic值
     * output: Array $topic //数据库中与这些topic相对应的值
     */
    public function normalizeTopic(array $topics){
        return collect($topics)->map(function ($topic){
            if (is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            } else {
                $oldTopics = Topic::all();
                $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
                return $newTopic->id;
            }
        })->toArray();
    }
}