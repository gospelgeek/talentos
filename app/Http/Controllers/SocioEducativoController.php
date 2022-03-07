<?php

namespace App\Http\Controllers;

use App\AssignmentStudent;
use App\User;
use Illuminate\Http\Request;

class SocioEducativoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index()
    {
        $asignaciones = AssignmentStudent::all();
        $user = User::where('rol_id', '=', 6)->get();       
        //dd($user);
        return view('socioeducativo.index', compact('asignaciones', 'user'));
    }

    public function updateAssigment($id, Request $request){

        $data = AssignmentStudent::findOrfail($id);
        //dd($data);
        if($request->ajax()){
            $data->id_user = $request['id_user'];
            
        }
        $datosUser = User::findOrfail($request['id_user']);
        return $datosUser;
    }
}
