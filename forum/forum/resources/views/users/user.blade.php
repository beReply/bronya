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
                                    {{--<a href="#" class="topic pull-left">我的关注</a>--}}
                                    {{--<a href="/user/followed" class="topic pull-left">关注我的</a>--}}
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
                                    <a href="/authority/editors/{{ $user->id }}"
                                       class="btn btn-default {{ $user->authority == "E" ? 'btn-success': '' }}">
                                        {{ $user->authority == "E" ? '取消编辑': '设为编辑' }}
                                    </a>
                                    <a href="/authority/manager/{{ $user->id }}"
                                       class="pull-right btn btn-default {{ $user->authority == "M" ? 'btn-success': '' }}">
                                        {{ $user->authority == "M" ? '取消管理': '设为管理' }}
                                    </a>
                                    {{--<editor user="{{ $user->id }}"></editor> --}}
                                    {{--<manager user="{{ $user->id }}" class="pull-right"></manager>--}}
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
                                    我的创作
                                @else
                                    该用户的创作
                                @endif
                            @else
                                该用户的创作
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        @foreach($user->questions as $question)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img width="48" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/questions/{{ $question->id }}">
                                            {{ $question->title }}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="media">
                            @if (Auth::check())
                                @if($user->id === Auth::guard()->user()->id)
                                    我的关注
                                @else
                                    该用户的关注
                                @endif
                            @else
                                该用户的关注
                            @endif

                        </div>
                    </div>
                    <div class="panel-body">
                        @foreach($questions as $question)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img width="48" src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/questions/{{ $question->id }}">
                                            {{ $question->title }}
                                        </a>
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
