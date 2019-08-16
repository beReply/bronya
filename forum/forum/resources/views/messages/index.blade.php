@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信消息</div>
                    <div class="panel-body">
                        @foreach($messages as $message)
                            <li>
                                用户：
                                <a href="/users/{{ $message->fromUser->id }}">
                                    {{ $message->fromUser->name }}
                                </a>
                                发送给用户：
                                <a href="/users/{{ $message->toUser->id }}">
                                    {{ $message->toUser->name }}
                                </a>
                                的私信：{{ $message->body }}
                            </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
