<?php

namespace App\Http\Controllers;

use App\Repositries\AnswerRepository;
use Illuminate\Http\Request;
use Auth;

class VotesController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function users($id) {
        $user = Auth::guard('api')->user();

        if ($user->hasVoteFor($id)) {
            return response()->json(['voted' => true]);
        } else {
            return response()->json(['voted' => false]);
        }

    }

    public function vote() {
        $answer = $this->answer->byId(request('answer'));
        $voted = Auth::guard('api')->user()->voteFor(request('answer'));

        if (count($voted['detached']) > 0) {
            $answer->decrement('votes_count');
            return response()->json(['voted' => false]);
        } else {
            $answer->increment('votes_count');
            return response()->json(['voted' => true]);
        }
    }
}
