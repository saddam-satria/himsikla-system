<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isChamberlain
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
        if (is_null(auth()->user()->member)) return abort(401);
        if (auth()->user()->member->occupation == "ketua" && $request->method() == "GET") return $next($request);
        if (auth()->user()->member->occupation != "bendahara") return abort(401);
        return $next($request);
    }
}
