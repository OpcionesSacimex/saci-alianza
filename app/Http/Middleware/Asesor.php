<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Asesor
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

        if(auth()->user()->tipo=="Admin"||auth()->user()->tipo=="Aesor"){
            return $next($request);
        } else if((($request->is('clientes/create'))||($request->is('clientes'))))
        {
            return $next($request);
            //return $request->path();
            //return redirect()->route('home');
        }else{
            return redirect()->route('login');
        }
        return redirect()->route('login');
        
    }
    
}
