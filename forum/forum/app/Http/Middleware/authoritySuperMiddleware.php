<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class authoritySuperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()){
            if (Auth::guard()->user()->authority != "S" ) {
                flash('万分抱歉，你不是系统管理员', 'danger');
                return redirect("/");
            }
        } else {
            flash('你还没有登录', 'success');
            return redirect('/questions');
        }

        return $next($request);
    }
}
