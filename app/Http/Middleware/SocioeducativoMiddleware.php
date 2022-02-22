<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SocioeducativoMiddleware
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
         if(\Auth::check())
        {  
            if($this->auth->user()->rol_id == '2' || $this->auth->user()->rol_id == '3' || $this->auth->user()->rol_id == '4' || $this->auth->user()->rol_id == '5' || $this->auth->user()->rol_id == '1' || $this->auth->user()->rol_id== '6')

            {
                //dd('fdff');
                return $next($request);              
            }
        }else{
            return redirect()->to('logout');
            Session::flash('message-error','Inicio sesion para acceder al sistema');
        }
    }
}
