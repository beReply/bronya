@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="media">
                            <form class="search" action="/search/degree" method="post">
                            {{ csrf_field() }}
                            <input type="text" placeholder="内容搜索" name="search"/>
                            </form>
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
                                        <a class="face" href="/questions/{{ $question->id }}">
                                            {{ $question->title }}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        @endforeach

                        {!! PaginateRoute::renderPageList($questions, false, 'pagination') !!}

                    </div>
                </div>
            </div>

            <div class="col-md-3 pull-right">
                <div class="panel panel-default">
                    <div class="panel-heading question-follow">
                        <h5>话题列表</h5>
                    </div>
                    <div class="panel-body">
                        <form  action="/search/topic" method="post">
                            {{ csrf_field() }}
                            <input type="text" placeholder="话题搜索" name="search"/>
                        </form>
                    </div>

                    <div class="panel-body">
                        @foreach($topics as $topic)
                            <div class="panel-heading question-follow">
                                <h4 class="media-body">
                                    <a class="face" href="/topic/{{ $topic->id }}">
                                        {{ $topic->name }}
                                    </a>
                                </h4>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
