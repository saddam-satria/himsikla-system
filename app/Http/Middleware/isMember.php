<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!is_null(auth()->user()->member) || auth()->user()->role_id == 99) return $next($request);
        return abort(404);
    }
}
