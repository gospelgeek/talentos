<?php

namespace App\Http\Controllers;

use App\AssignmentStudent;
use App\Imports\CsvImport;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SocioEducativoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function index()
    {
        $user = User::where('rol_id', '=', 6)->get();       
        return view('socioeducativo.index', compact('user'));
    }

    public function DataJson(){

        $datosDeAsignacion = DB::select("SELECT assignment_students.id, 
        (SELECT student_profile.name FROM student_profile WHERE student_profile.id = assignment_students.id_student) as name, 
        (SELECT student_profile.lastname FROM student_profile WHERE student_profile.id = assignment_students.id_student) as lastname,
        (SELECT student_profile.document_number FROM student_profile WHERE student_profile.id = assignment_students.id_student) as tipoDocumento,
         (SELECT student_profile.student_code FROM student_profile WHERE student_profile.id = assignment_students.id_student) as codigo, 
         (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort) FROM groups WHERE groups.id = student_groups.id_group) FROM student_groups WHERE student_groups.deleted_at IS NULL AND student_groups.id_student = assignment_students.id_student) as grupo, 
         (SELECT users.name FROM users WHERE users.id = assignment_students.id_user) as nameUser, (SELECT users.apellidos_user FROM users WHERE users.id = assignment_students.id_user) as apellidosUser FROM assignment_students WHERE assignment_students.deleted_at IS NULL");

         return datatables()->of($datosDeAsignacion)->toJson();
    }

    public function updateAssigment($id, Request $request){

        $data = AssignmentStudent::findOrfail($id);
        if($request->ajax()){
            AssignmentStudent::create([
                'id_user' => $request['id_user'],
                'id_student' => $data->id_student,
                'id_periods' => $data->id_periods
            ]);
            $data->delete();
        }
        
        $datosUser = User::findOrfail($request['id_user']);
        return $datosUser;
    }

    public function verificarInfo(Request $request){
        $coleccion = Excel::toArray(new CsvImport, $request->file('file'));
        foreach($coleccion[0] as $data){
            
            var_dump($data['id_student']);
        }

        return var_dump($coleccion);
    }

}
