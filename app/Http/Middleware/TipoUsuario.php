<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TipoUsuario
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
        if(auth()->user()->tipo=="Admin"){
            return redirect()->route('solicitudes.index');
        } 
        if(auth()->user()->tipo=="Aliado")
        {
            return redirect()->route('panelAliado');
        }
        else
        {
            return $next($request);
        }

        return $next($request);
    }
}
