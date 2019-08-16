@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="pull-left col-md-3">
                <div class="col-md-3  col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading question-follow">
                            <h5>用户个人</h5>
                        </div>
                        <div class="panel-body">
                            <div class="media-left">
                                <a href="#">
                                    <img width="36" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="">
                                        {{ $user->name }}
                                    </a></h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{ $user->question_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{ $user->answers_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{ $user->followers_count }}</div>
                                </div>
                            </div>
                            @if(Auth::check())
                                <user-follow-button user="{{ $user->id }}"></user-follow-button>
                                <send_message user="{{ $user->id }}"></send_message>
                            @endif
                        </div>
                    </div>
                </div>


                @if (Auth::check())
                    @if($user->id === Auth::guard()->user()->id)
                        <div class="col-md-3 col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="/questions/create" target="_blank" class="topic pull-left">创建问题</a>
                                    <a href="/notifications" class="topic pull-left">系统信息</a>
                                    <a href="/messages/{{ $user->id }}" class="topic pull-left">所收私信</a>
                                    <a href="/messagesTo/{{ $user->id }}" class="topic pull-left">所发私信</a>
                                    <a href="#" class="topic pull-left">我的关注</a>
                                    <a href="#" class="topic pull-left">关注我的</a>
                                    <a href="#" class="topic pull-left">关注的问题</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if (Auth::check())
                    @if(Auth::guard()->user()->authority == "S" && $user->authority != "S")
                        <div class="col-md-3 col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <editor user="{{ $user->id }}"></editor>
                                    <manager user="{{ $user->id }}" class="pull-right"></manager>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>



            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="media">
                            @if (Auth::check())
                                @if($user->id === Auth::guard()->user()->id)
                                    关注我的用户
                                @else
                                    关注该用户的用户
                                @endif
                            @else
                                关注该用户的用户
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        @foreach($followers as $follower)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img width="48" src="{{ $follower->avatar }}" alt="{{ $follower->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        关注了你。
                                    </h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>




        </div>
    </div>

@endsection
