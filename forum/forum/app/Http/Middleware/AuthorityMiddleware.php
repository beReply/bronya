<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorityMiddleware
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
        if (Auth::guard()->user()->authority === "U") {
            flash('万分抱歉，普通用户不能进入此处', 'danger');
            return redirect()->back();
        }

        return $next($request);
    }
}
