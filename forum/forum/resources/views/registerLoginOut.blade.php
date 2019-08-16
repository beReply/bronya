@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">你已注册成功，请激活邮箱后重新登录</div>

                    <div class="panel-body">
                        <form id="logout-form" name="formOut" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            <input type="submit" value="Submit"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        setTimeout("document.formOut.submit()",2000)
    </script>

@endsection
