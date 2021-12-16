<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class AcademicoMiddleware
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
            if($this->auth->user()->rol_id == '3')
            {
                return $next($request);              
            }
            if($this->auth->user()->rol_id == '2'){
                return Redirect::to('/estudiante');
                Session::flash('message-error','Sin privilegios para Ingresar');                
            }
            if($this->auth->user()->rol_id == '1'){
                return Redirect::to('/usuario');
                Session::flash('message-error','Sin privilegios para Ingresar');                
            }
            if($this->auth->user()->rol_id == '4'){
                return Redirect::to('/estudiante');
                Session::flash('message-error','Sin privilegios para Ingresar');                
            }
            if($this->auth->user()->rol_id == '5'){
                return Redirect::to('/estudiante');
                Session::flash('message-error','Sin privilegios para Ingresar');                
            }

        }else{
            return redirect()->to('logout');
            Session::flash('message-error','Inicio sesion para acceder al sistema');
        }
    }
}
