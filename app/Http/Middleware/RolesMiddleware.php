<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;

class RolesMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->rol_id == '1'){
                return redirect('usuario/');
            }

            if(Auth::user()->rol_id == '2'){
                return redirect('estudiante/');
            }

            if(Auth::user()->rol_id == '3'){
                return redirect('estudiante/');
            }

            if(Auth::user()->rol_id == '4'){
                return redirect('estudiante/');
            }

            if(Auth::user()->rol_id == '5'){
                return redirect('estudiante/');
            }

        }

        return $next($request);  
    }
}
