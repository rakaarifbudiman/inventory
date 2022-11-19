<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\Str;

class AksesAdmin
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
        $contains = Str::containsAll(Auth::user()->role, ['ATK']);     

        if(Auth::user()->akses == 'admin' && $contains==true){
            return $next($request);
        }

        return abort(404);
    }
}
