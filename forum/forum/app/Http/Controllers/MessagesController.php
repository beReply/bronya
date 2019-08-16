<?php

namespace App\Http\Controllers;


use App\Repositries\MessageRepository;
use Illuminate\Http\Request;
use Auth;

class MessagesController extends Controller
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
       // $this->middleware('auth');
        $this->message = $message;
    }

    public function store() {
        $message = $this->message->create([
            'to_user_id' => request('user'),
            'from_user_id' => Auth::guard('api')->user()->id,
            'body' => request('body')
        ]);

        if ($message) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function readMessage($id) {
        if ($id != Auth::guard()->user()->id){
            dd("别想了，这是其他用户的私人领地");
        }
        $messages = $this->message->ReadFromOther($id);
        return view('messages/index', compact('messages'));
    }

    public function readMessageTo($id) {
        if ($id != Auth::guard()->user()->id){
            dd("别想了，这是其他用户的私人领地");
        }
        $messages = $this->message->ReadToOther($id);
        return view('messages/index', compact('messages'));
    }
}
