<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositries\UserRepository;
use Auth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository){
        $this->middleware('auth')->except('store');
        $this->userRepository = $userRepository;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 根据所传入的id显示相应用户的主页
     */
    public function store($id){
        $user = $this->userRepository->byId($id);
        if ($user == null) {
            flash('未找到该用户', 'success');
            return redirect()->back();
        }
        $questions = $this->userRepository->getFollowedQuestion($id)->follows;
       // dd($questions);
        return view('/users/user', compact('user', 'questions'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示当前所登录用户的用户主页
     */
    public function nowLogin() {
        $user = $this->userRepository->nowLogin();
        $questions = $this->userRepository->getFollowedQuestion($user->id)->follows;
        //dd($questions);
        return view('/users/user', compact('user', 'questions'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示所有用户
     */
    public function userList() {
        $users = $this->userRepository->userAll();
        return view('users/list', compact('users'));
    }

    /**
     *关注该用户的人
     */
    public function followedList() {
        $user = $this->userRepository->nowLogin();
        $id = $user->id;
        $followers = $this->userRepository->getFollowers($id)->followersUsers;
       // dd($followers);
        return view('users/followers', compact('user', 'followers'));
    }

    /**
     * 该用户关注的人
     */
    public function followersList() {
        //
    }
}
