@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @foreach($users as $user)
                            <div class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img width="48" src="{{ $quser->avatar }}" alt="{{ $user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        预留
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
