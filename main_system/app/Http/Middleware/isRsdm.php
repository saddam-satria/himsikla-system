<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isRsdm
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
        if ($request->get("action") && str_contains($request->get("action"), "certificate")) return $next($request);
        if (auth()->user()->member->occupation == "ketua" && $request->method() == "GET") return $next($request);
        if (!str_contains(auth()->user()->member->occupation, "ketua koordinator rsdm")) return abort(401);
        return $next($request);
    }
}
