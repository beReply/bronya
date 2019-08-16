<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositries\QuestionRepository;
use App\Repositries\TopicRepository;
use App\Topic;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class QuestionController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        //当用户未登录时禁止发布问题
        $this->middleware('auth')->except([
            'index', 'show', 'topic', 'activeCheck', 'searchDegree', 'search'
        ]);

        //对于QuestionRepository注入
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionAll();
        $topics = $this->questionRepository->getTopic();
        return view('questions.index', compact('questions', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->activeCheck();
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $this->activeCheck();//检测用户是否被激活
        $body = $request->get('body');
        if (strpos($body, '{{') || strpos($body, '{!!') || strpos($body,'?php')){
            flash('描述中出现非法字符，具体情况请看上传规则', 'danger');
            return redirect('/questions/create');
        }
        $title = $request->get('title');
        if (strpos($title, '{{') || strpos($title, '{!!') || strpos($title,'?php')){
            flash('标题中出现非法字符，具体情况请看上传规则', 'danger');
            return redirect('/questions/create');
        }
        $topics = $request->get('topics');
        if ($topics == null){
            flash('话题为空', 'danger');
            return redirect('/questions/create');
        }
        if (Auth::guard()->user()->authority === "U") {
            flash('普通用户无法创建问题，联系1号用户为你开通权限', 'danger');
            return redirect()->back();
        }


        $topicDatas = Topic::all();
        foreach ($topicDatas as $topicData){
            if (in_array($topicData->name,$topics)){
                flash('重复的话题被创建', 'danger');
                return redirect('/questions/create');
            }
        }

        $topic = $this->questionRepository->normalizeTopic($topics);
        $data = [
            'title' => $request->get('title'),
            'body' => $body,
            'user_id' => Auth::id()
        ];
        $question = $this->questionRepository->create($data);

        $question->topics()->attach($topic);

        return redirect("/questions/".$question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdwithTopicsAndAnswers($id);

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->activeCheck();
        $question = $this->questionRepository->byId($id);
        if (Auth::user()->owns($question)){
            return view('questions.edit', compact('question'));
        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $this->activeCheck();
        $question = $this->questionRepository->byId($id);
        $topic = $this->questionRepository->normalizeTopic($request->get('topics'));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body')
        ]);
        $question->topics()->sync($topic);

        return redirect("/questions/".$question->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->activeCheck();
        $question = $this->questionRepository->byId($id);

        if (Auth::user()->owns($question)) {
            $question->delete();

            return redirect('/');
        }

        abort(403, "Forbidden");
    }

    public function topic($id){
        $topic = $this->questionRepository->getTopicById($id);
        $questions = $topic->questions;
        $topics = $this->questionRepository->getTopic();
        return view('questions.topic', compact('questions', 'topics'));

    }

    public function activeCheck(){
        $active = Auth::guard()->user()->is_active;
        if ($active == 0){
            return redirect('register/login/out');
        }
    }

    public function search(Request $request){
        $search = $request->get('search');
        if ($search == null) {
            return redirect()->back();
        }
        $questions_find = $this->questionRepository->getQuestionAll();
        $questions = array();
        foreach ($questions_find as $question) {
           // dd($question->title);
            if (count(explode($search,$question->title)) > 1) {
                array_push($questions, $question);
            }
        }
        $topics = $this->questionRepository->getTopic();
        return view('questions.topic', compact('questions', 'topics'));
    }

    public function searchDegree(Request $request) {
        $search = $request->get('search');
        if ($search == null) {
            return redirect()->back();
        }
        $questions_find = $this->questionRepository->getQuestionAll();
        $questions = array();
        foreach ($questions_find as $question) {
            // dd($question->title);
            if (count(explode($search,$question->body)) > 1) {
                array_push($questions, $question);
            }
        }
        $topics = $this->questionRepository->getTopic();
        return view('questions.topic', compact('questions', 'topics'));
    }
}
