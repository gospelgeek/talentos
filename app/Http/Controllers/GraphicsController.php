<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index(){
        return view('graphics.index');
    }

    public function sexoPorCohorte($tipo, $cohorte){
        $datos = DB::select("SELECT COUNT(sex) as sexo FROM student_profile WHERE sex = ? AND 
        student_profile.id IN (SELECT student_groups.id_student FROM student_groups WHERE
         student_groups.id_group IN (SELECT groups.id FROM groups WHERE groups.id_cohort = ?))", [$tipo, $cohorte]);

        return $datos;
    }

}
