<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckCliente
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
            if(Auth::user()->grupo_id == 5){
                if(!Auth::user()->cliente->registro_completo){
                    return redirect()->route('aprobacion_credito');
                }
            }
        }
        return $next($request);
    }
}
