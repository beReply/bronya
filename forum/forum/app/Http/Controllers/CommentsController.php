<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Comment;
use App\Question;
use Illuminate\Http\Request;
use Auth;

class CommentsController extends Controller
{
    public function answer($id) {
        $answer = Answer::with('comments', 'comments.user')
            ->where('id', $id)->first();
        return $answer->comments;
    }

    public function question($id) {
        $question = Question::with('comments', 'comments.user')
            ->where('id', $id)->first();
        return $question->comments;
    }

    public function store() {
        $model = $this->getModelNameFromType(request('type'));

        $comment = Comment::create([
            'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id' => Auth::guard('api')->user()->id,
            'body' => request('body')
        ]);

        return $comment;
    }

    public function getModelNameFromType($type) {
        return $type === 'question' ? 'App\question' : 'App\Answer';
    }
}
