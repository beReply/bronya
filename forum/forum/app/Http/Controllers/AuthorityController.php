<?php

namespace App\Http\Controllers;

use App\Repositries\UserRepository;
use Illuminate\Http\Request;

/**
 * Class AuthorityController
 * @package App\Http\Controllers
 */
class AuthorityController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var
     */
    protected $nowlogin;

    /**
     * AuthorityController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * 是否为管理
     */
    public function managerStore($id){
        $auth = $this->userRepository->byId($id)->authority;
        if ($auth === "M" || $auth === "S"){
            return response()->json(['isManager' => true]);
        } else {
            return response()->json(['isManager' => false]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * 是否为编辑
     */
    public function editorStore($id){
        $auth = $this->userRepository->byId($id)->authority;
        if ($auth === "E" || $auth === "M" || $auth === "S"){
            return response()->json(['isEditor' => true]);
        } else {
            return response()->json(['isEditor' => false]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 设为/取消管理，当用户为超级用户时，该按键失效
     */
    public function setManager(Request $request) {
        $id = $request->get('user');
        $auth = $this->userRepository->byId($id)->authority;

        if ($auth === "M"){
            $this->userRepository->setUserSimpleR($id);
            return response()->json(['isManager' => false]);
        } else if ($auth === "S"){
            return response()->json(['isManager' => true]);
        } else {
            $this->userRepository->setManagerR($id);
            return response()->json(['isManager' => true]);
        }
    }

    /**
     * @param $id
     * 使用<a href>链接时候的修改用户是否为管理者
     */
    public function setManagerALink($id) {
        $auth = $this->userRepository->byId($id)->authority;

        if ($auth === "M"){
            $this->userRepository->setUserSimpleR($id);
        } else if ($auth === "S"){
            return redirect('/users/'.$id);
        } else {
            $this->userRepository->setManagerR($id);
        }
        return redirect('/users/'.$id);
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 取消/设置为编辑，当该用户是超级用户或管理员时，该按键失效
     */
    public function setEditor(Request $request) {
        $id = $request->get('user');
        $auth = $this->userRepository->byId($id)->authority;

        if ($auth === "E"){
            $this->userRepository->setUserSimpleR($id);
            return response()->json(['isEditor' => false]);
        } else if ($auth === "M" || $auth === "S") {
            return response()->json(['isEditor' => true]);
        } else {
            $this->userRepository->setEditorR($id);
            return response()->json(['isEditor' => true]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 使用<a href>链接时候的修改用户是否为编辑
     */
    public function setEditorALink($id) {
        $auth = $this->userRepository->byId($id)->authority;


        if ($auth === "E"){
            $this->userRepository->setUserSimpleR($id);
        } else if ($auth === "M" || $auth === "S") {
            return redirect('/users/'.$id);
        } else {
            $this->userRepository->setEditorR($id);
        }

        return redirect('/users/'.$id);
    }


}
