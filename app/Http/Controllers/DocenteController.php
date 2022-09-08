<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\perfilEstudiante;
use App\CourseItems;
use App\User;
use App\StudentsGrade;
use App\Course;
use App\Group;
use App\Cohort;
use App\AsignementStudents;
use App\StudentGroup;
use App\AssignmentStudent;
use App\CourseMoodle;
use App\SessionCourse;
use App\AttendanceStudent;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
use App\Session as sesiones;
use Session;
use Redirect;
use DB;
use Response;
use Excel;
use App\Imports\CsvImport;
use Illuminate\Support\Facades\Storage;
use App\EconomicalSupport;

class DocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function grupos_asistencias_docentes($name, $materia){
        $id_curso = Course::select('id')->where('name','LIKE', $materia)->first();
        //dd($id_curso);
        $this->course_id = $id_curso->id;
        $info_grupos = CourseMoodle::select('group_id', 'docente_name')->where('docente_name', $name)->get();
        //dd($info_grupos);
        $info_grupos->map(function($grupos){
            $name_grupo = Group::select('name', 'id_cohort')->where('id', $grupos->group_id)->firstOrfail();
            $grupos->name_grupo = $name_grupo->name;
            $linea = Cohort::select('name')->where('id', $name_grupo->id_cohort)->firstOrfail();
            $grupos->linea = $linea->name;
            $course_moodle = CourseMoodle::select('attendance_id', 'course_id')->where('group_id', $grupos->group_id)->first();
            //dd($course_moodle);
            $grupos->sesiones = SessionCourse::where('lasttaken','!=',null)->where('attendance_id',$course_moodle->attendance_id)->count();
            $fecha = Carbon::now();
            //dd($fecha);
            $grupos->programadas = sesiones::where('id_group', $grupos->group_id)->where('id_course',$this->course_id)->where('date_session','<=',$fecha)->count();
            //dd($grupos);
        });

        return view('academico.docentes.asistenciasGrupos.index', compact('info_grupos', 'name', 'materia'));
    }

    public function asistencias_sesiones_docentes($group_id, $materia){
        $grupo = Group::where('id', $group_id)->first();
        $name = Course::where('name','LIKE', $materia)->first();

        $course = CourseMoodle::select('attendance_id','instance_id', 'docente_name')->where('group_id',$group_id)->where('fullname','LIKE',"$name->name%")->first();
        //dd($course->docente_name);
        $this->docente = $course->docente_name;
        $sesiones = SessionCourse::where('attendance_id',$course->attendance_id)->get();
        $this->id_grupo= $group_id;
        $this->grupo = perfilEstudiante::whereHas('studentGroup',function($q)
        {
            $q->where('id_group', '=', $this->id_grupo);
        })->count();
        $sesiones->map(function($sesion){
            //dd($sesion);
            $sesion->asistieron = AttendanceStudent::where('grade',['P','R'])->where('session_id',$sesion->session_id)->count();
            $cant_estudiantes_grupo = $this->grupo;
            //dd($cant_estudiantes_grupo);
            $sesion->no_asistieron = $cant_estudiantes_grupo-$sesion->asistieron;
            //dd($sesion);
            if($this->docente != null){
                $sesion->docente = $this->docente;
            }else{
                $sesion->docente = '-';
            }
        });
        //dd($sesiones);
        return view('academico.docentes.asistenciasGrupos.sesiones_grupales', compact('grupo', 'name','sesiones','course'));
    }

    public function lista_sesiones_docentes($course, $id, $id_session, $docente)
    {
        $grupo = Group::where('id', $id)->first();
        $name = Course::where('id', $course)->first();
        $notas = StudentGroup::all()->where('id_group', $id);
        $this->grupo = $id;
        $this->sesion = $id_session;
        $asistencias = perfilEstudiante::select('name','lastname','id_moodle')->whereHas('studentGroup',function($q)
        {
            $q->where('id_group', '=', $this->grupo);
        })->get();
        //dd($estudiantes);
        //$asistencias = AttendanceStudent::where('session_id', $id_session)->get();
        $asistencias->map(function($asistencia){
            $estudiante = AttendanceStudent::where('session_id', $this->sesion)->where('id_moodle',$asistencia->id_moodle)->where('grade',['P','R'])->exists();
            //dd($estudiante);
            if($estudiante){
                $asistencia->grade = 'Asistio';
            }else{
                $asistencia->grade = "No Asistio";
            }
            //$asistencia->name = $estudiante->name;
            //$asistencia->lastname = $estudiante->lastname;
            
        });
        //dd($asistencias);
        return view('academico.docentes.asistenciasGrupos.lista_sesiones', compact('notas', 'grupo', 'name', 'id_session','asistencias', 'docente'));
    }

    public function index_docentes(){

        return view('academico.docentes.index');
    }

    public function datosDocentes(){
        $docentes = CourseMoodle::select('docente_name')->distinct('docente_name')->where('docente_name', '!=', null)->get();
        
        $docentes->map(function($profesores){
            //dd($profesores);
            $profesores->asignatura = CourseMoodle::asignaturas_grupos($profesores->docente_name);

        });
        return datatables()->of($docentes)->toJson();
    }

    public function grupos_seguimientos_docentes($name, $materia){
        
        $info_grupos = CourseMoodle::select('group_id', 'docente_name')->where('docente_name', $name)->get();
        //dd($info_grupos);
        $this->eliminar = array();
        $info_grupos->map(function($grupos){
            $name_grupo = Group::select('name', 'id_cohort')->where('id', $grupos->group_id)->firstOrfail();
            $grupos->name_grupo = $name_grupo->name;
            $linea = Cohort::select('name')->where('id', $name_grupo->id_cohort)->firstOrfail();
            $grupos->linea = $linea->name;
            $course_moodle = CourseMoodle::select('course_id')->where('group_id', $grupos->group_id)->exists();
            //dd($course_moodle);
            if($course_moodle){
                $course_moodle = CourseMoodle::select('course_id')->where('group_id', $grupos->group_id)->firstOrfail();  
                $grupos->items_huerfanos = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('category_name',"ITEM HUERFANO")->count();
                //dd($course_moodle);    
                $Asistencia = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','like','asistencia%')->exists();
                //dd($Asistencia);
                if($Asistencia){
                    $Asistencia = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','like','asistencia%')->first();

                    //dd($Asistencia);
                    $grades = StudentsGrade::select('grade')->where('item_id',$Asistencia->item_id)->get();
                    //dd($grades);
                    $total_asistencia = 0;
                    foreach($grades as $grade){
                        $total_asistencia = $total_asistencia + $grade->grade;
                    }
                    if($total_asistencia > 0){
                        $grupos->promedio_asistencia = number_format($total_asistencia/count($grades),2);  

                    }else{
                        $grupos->promedio_asistencia = "-";
                    }
                  
                }else{
                    $grupos->promedio_asistencia = "-";
                }

                $seguimientos =  CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where(function($q){
                    $q->where('item_name', 'like', 'seguimiento%')->Orwhere('item_name','like','componente%')->Orwhere('item_name','like','actividades%')->Orwhere('item_name','like','parciales%')->Orwhere('item_name','like','seminario%');
                })->exists();
            
                if($seguimientos){
                    $seguimientos = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where(function($q){
                    $q->where('item_name', 'like', 'seguimiento%')->Orwhere('item_name','like','componente%')->Orwhere('item_name','like','actividades%')->Orwhere('item_name','like','parciales%')->Orwhere('item_name','like','seminario%');
                    })->first();
                    //dd($seguimientos->item_id);
                    $grades = StudentsGrade::select('grade')->where('item_id',$seguimientos->item_id)->get();
                //dd($grades);
                    $total_seguimientos = 0;
                    foreach($grades as $grade){
                        $total_seguimientos = $total_seguimientos + $grade->grade;
                    }
                    if($total_seguimientos > 0){
                        $grupos->promedio_seguimientos = number_format($total_seguimientos/count($grades),2);  
                    }else{
                        $grupos->promedio_seguimientos = "-";
                    }
                }else{
                    $grupos->promedio_seguimientos = "-";
                }

                $autoevaluacion =  CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','like','auto%')->exists();
                //dd($autoevaluacion);
                if($autoevaluacion){
                    $autoevaluacion = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','like','auto%')->first();
                //dd($autoevaluacion);

                $grades = StudentsGrade::select('grade')->where('item_id',$autoevaluacion->item_id)->get();
                //dd($grades);

                $total_autoevaluacion = 0;
                foreach($grades as $grade){
                    //dd($grade);
                    $total_autoevaluacion = $total_autoevaluacion + $grade->grade;
                }
                //dd("bien");
                if($total_autoevaluacion > 0){
                    //dd("bien","1");
                    $grupos->promedio_autoevaluacion = number_format($total_autoevaluacion/count($grades),2);
                }else{

                    $grupos->promedio_autoevaluacion = "-";
                }
                                 
                }else{
                    $grupos->promedio_autoevaluacion = "-";
                }
            }else{
                array_push($this->eliminar, $index);
            }
            //dd($grupos); 
        });
        //dd($materia);

        foreach($this->eliminar as $borrar){
            $grupos->pull($borrar);
        }
        
        return view('academico.docentes.seguimientosGrupos.index',compact('info_grupos', 'name', 'materia'));
    }

    public function detalle_grupal_seguimientos($group_id, $materia){
        $grupo = Group::where('id', $group_id)->first();
        //dd($grupo);
        $name = Course::where('name','LIKE', $materia)->first();
        //dd($name);
        $course_moodle = CourseMoodle::select('course_id', 'docente_name')->where('group_id', $grupo->id)->where('fullname','LIKE',"$name->name%")->firstOrfail();
        //dd($course_moodle);
        $this->course = $course_moodle->course_id;
        $this->docente = $course_moodle->docente_name;
        $this->grupo = $group_id;

        $estudiantes = perfilEstudiante::select('name','lastname','document_number','id_moodle')->whereHas('studentGroup',function($q)
        {
            $q->where('id_group', '=', $this->grupo);
        })->get();
        //dd($estudiantes);
        $items_huerfanos = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('category_name',"ITEM HUERFANO")->count();
        //dd($items_huerfanos);
        $estudiantes->map(function($estudiante){
            $Asistencia = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name','like','ASISTENCIA%')->first();

            $grades = $Asistencia ? StudentsGrade::select('grade','item_id')->where('item_id',$Asistencia->item_id)->where('id_moodle',$estudiante->id_moodle)->exists() : null;
    
            $grades = $grades ? StudentsGrade::select('grade','item_id')->where('item_id',$Asistencia->item_id)->where('id_moodle',$estudiante->id_moodle)->first() : null;
                //dd($grades);
            $estudiante->asistencia = $grades ? $grades->grade : "-";

            $seguimientos =  CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where(function($q){
                $q->where('item_name', 'like', 'seguimiento%')->Orwhere('item_name','like','componente%')->Orwhere('item_name','like','actividades%')->Orwhere('item_name','like','parciales%')->Orwhere('item_name','like','seminario%');
            })->first();

            $grades = $seguimientos ? StudentsGrade::select('grade','item_id')->where('item_id',$seguimientos->item_id)->where('id_moodle',$estudiante->id_moodle)->exists() : null;
               
            $grades = $grades ? StudentsGrade::select('grade','item_id')->where('item_id',$seguimientos->item_id)->where('id_moodle',$estudiante->id_moodle)->first() : null;
                //dump($grades->grade);
            $estudiante->seguimientos = $grades ? $grades->grade : "-";
                
            $autoevaluacion = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name','like','auto%')->first();

            $grades = $autoevaluacion ? StudentsGrade::select('grade','item_id')->where('item_id',$autoevaluacion->item_id)->where('id_moodle',$estudiante->id_moodle)->first() : null;
                //dump($grades->grade);
            $estudiante->autoevaluacion = $grades ? $grades->grade : "-";

            $total_curso = CourseItems::select('item_id')->where('course_id',$this->course)->where('category_name',"TOTAL CURSO")->first();

            $grades = $total_curso ? StudentsGrade::select('grade','item_id')->where('item_id',$total_curso->item_id)->where('id_moodle',$estudiante->id_moodle)->first() : null;
                
            $estudiante->total_curso = $grades ? $grades->grade : "-";

            if($this->docente != null){
                $estudiante->docente = $this->docente;    
            }else{
                $estudiante->docente = '-';
            }
        });
        //dd($estudiantes);
        return view('academico.docentes.seguimientosGrupos.detalle_grupal', compact('grupo', 'name','estudiantes','course_moodle','items_huerfanos', 'course_moodle'));
    }
}
