<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isLeader
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
        if (auth()->user()->role_id == 99) return $next($request);
        if (auth()->user()->member->occupation != "ketua" && auth()->user()->member->occupation != "wakil ketua" && !str_contains(auth()->user()->member->occupation, "ketua koordinator rsdm")) return abort(404);
        return $next($request);
    }
}
