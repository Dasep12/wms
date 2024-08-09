<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class GlobalVariableMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        View::share('user_id', session()->get("user_id"));
        View::share('MenuUrl', request()->path());
        return $next($request);
    }
}
