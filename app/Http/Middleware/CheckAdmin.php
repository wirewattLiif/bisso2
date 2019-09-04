<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckAdmin
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
            #//Agregar grupos que tengan permitido prefijo admin
            if(Auth::user()->grupo_id == 5 || Auth::user()->grupo_id == 6){
                return redirect(Auth::user()->grupo->home_page);
            }
        }
        return $next($request);
    }
}
