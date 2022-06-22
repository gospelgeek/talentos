<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IcfesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index(){
        return view('icfes.index');
    }

    public function DatosIcfes()
    {
        $datosIcfes = DB::select("SELECT id, (SELECT student_profile.name FROM student_profile 
        WHERE student_profile.id = icfes_students.id_student LIMIT 1 ) as nombre, 
        (SELECT student_profile.lastname FROM student_profile 
        WHERE student_profile.id = icfes_students.id_student LIMIT 1 ) as apellidos, 
        (SELECT student_profile.document_number FROM student_profile WHERE 
        student_profile.id = icfes_students.id_student LIMIT 1) as documento, 
        (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort LIMIT 1) 
        FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) FROM student_groups WHERE 
        student_groups.id_student = icfes_students.id_student LIMIT 1) as linea,
        (SELECT (SELECT groups.name FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) 
        FROM student_groups WHERE student_groups.id_student = icfes_students.id_student LIMIT 1) as grupo , 
        icfes_students.total_score FROM icfes_students");

        return datatables()->of($datosIcfes)->toJson();
    }
}
