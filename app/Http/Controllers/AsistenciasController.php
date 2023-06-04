<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\perfilEstudiante;
use App\CourseMoodle;
use App\SessionCourse;
use App\AttendanceStudent;
use App\Group;
use App\Session;
use App\Course;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
use App\Exports\ReporteAsistencias;
use Excel;

class AsistenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function ver_asistencias($id_moodle,$id_group){
        $cursos = CourseMoodle::all();
        /*$cursos->map(function($estudiante){
            $estudiante->sesiones;
            dd($estudiante);

        });*/
        
        $asistencias = AttendanceStudent::all()->where('id_moodle',225178);
        $sesiones = SessionCourse::select('attendance_id')->where('session_id', 40522)->first();
        $sesiones = SessionCourse::all()->where('attendance_id', $sesiones->attendance_id);
        dd($asistencias);
    }
    public function reporte_asistencias_programadas(){
        $grupos = Group::all()->where('name','!=',"TEMPORAL");
        //dd($grupos);
        $collection;
        $contador=0;
        foreach($grupos as $grupo){
            //dd($grupo->id);
            $course_moodle = CourseMoodle::select('attendance_id','fullname')->where('group_id', $grupo->id)->get();
            //dd($course_moodle);
            foreach($course_moodle as $course){
                $calificadas = SessionCourse::where('lasttaken','!=',null)->where('attendance_id',$course->attendance_id)->count();
                //dd($grupo);
                $fecha = Carbon::now();
                //dd($fecha);
                $fullname = explode("-",$course->fullname);
                //dd($fullname[3]);
                switch ($fullname[3]) {
                    case ' A0':
                        $fullname[3]=1;
                        $linea="linea 1";
                        break;
                    case ' TE':
                        $fullname[3]=2;
                        $linea="linea 2";
                        break;
                    case ' TS':
                        $fullname[3]=3;
                        $linea="linea 3";
                        break;    
                    default:
                        ECHO "ERROR";
                        break;
                }
                //dump($fullname);
                $course_BD = Course::select('id')->where('name',$fullname[0])->where('id_cohort',$fullname[3])->exists();
                //dump($course_BD->id);
                if($course_BD){
                $course_BD = Course::select('id')->where('name',$fullname[0])->where('id_cohort',$fullname[3])->firstOrfail();

                    $programadas = Session::where('id_group',$grupo->id)->where('id_course',$course_BD->id)->where('date_session','<=',$fecha)->count();
                //dump($programadas,$fullname[0]);
                $collection[$contador] = array('asignatura'=>$fullname[0],
                                          'grupo'=>$grupo->name,
                                          'linea'=>$linea,
                                          'programadas'=>$programadas,
                                          'calificadas'=>$calificadas,   
                                            );
                $contador++;
                }
                
            }
            
            

            //dd($collection);
        };
        //dd("é");
        //dd($collection);
        $export = new ReporteAsistencias([$collection]);
        $fechaexcel = Carbon::now();

        $fechaexcel = $fechaexcel->format('d-m-Y');
        
        
        return Excel::download($export, "REPORTE SESIONES PROGRAMADAS"." ".$fechaexcel.".xlsx");
    }
    public function asistencias_ficha(Request $request){

        //dd($request->id_student);
        $estudiante = perfilEstudiante::withTrashed()->select('id','id_moodle')->where('id', $request->id_student)->firstOrfail();
        $this->id_moodle = $estudiante->id_moodle;
        $cursos = CourseMoodle::select('id','fullname','attendance_id')->where('group_id',$estudiante->studentGroup->group->id)->with('sesiones')->get();
        //dd($cursos);
        $cursos->map(function($curso)
        {
            $contador=0;

            foreach($curso->sesiones as $sesion){
                $sesion = AttendanceStudent::where('session_id',$sesion->session_id)->where('grade',['P','R'])->where('id_moodle',$this->id_moodle)->exists();
                if($sesion){
                    $contador++;
                }
            }
            $curso->asistencia = $contador;

            $curso->cant_sesiones = count($curso->sesiones);
            $curso->id_moodle = $this->id_moodle;
            unset($curso->sesiones);

        });

        return datatables()->of($cursos)->toJson();
    }
    public function detalle_sesiones_ficha($attendance_id,$id_moodle){
        //dd($attendance_id,$id_moodle);
        $this->id_moodle = $id_moodle;
        $sesiones = SessionCourse::select('sessdate','session_id','lasttaken')->where('attendance_id',$attendance_id)->get();
        $this->curso = CourseMoodle::select('fullname')->where('attendance_id',$attendance_id)->firstOrfail();
        //dd($this->curso);
        $sesiones->map(function($sesion){
                $sesion->asistio = AttendanceStudent::where('id_moodle',$this->id_moodle)->where('session_id',$sesion->session_id)->where('grade',['P','R'])->exists();
                $sesion->curso = $this->curso->fullname;
        });

        return $sesiones;
    }
    public function detalles(Request $request){
        $id_student = $request->estudiante;
        $id_course = $request->curso;
        switch ($request->mes) {
            case '1':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($nombre);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_actual = Carbon::now();
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','<=',$fecha_actual)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;
            case '2':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of february 2022');
                $fecha_fin = new Carbon('last day of february 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '3':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of March 2022');
                $fecha_fin = new Carbon('last day of March 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '4':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of april 2022');
                $fecha_fin = new Carbon('last day of april 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '5':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of may 2022');
                $fecha_fin = new Carbon('last day of may 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '6':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of june 2022');
                $fecha_fin = new Carbon('last day of june 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '7':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of july 2022');
                $fecha_fin = new Carbon('last day of july 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '8':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of August 2022');
                $fecha_fin = new Carbon('last day of August 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '9':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of September 2022');
                $fecha_fin = new Carbon('last day of September 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '10':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of October 2022');
                $fecha_fin = new Carbon('last day of October 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '11':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of november 2022');
                $fecha_fin = new Carbon('last day of november 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '12':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($nombre);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_actual = Carbon::now();
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','<=',$fecha_actual)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;
            default:
                ECHO "ERROR MES...";
                break;
        }     
    }
    public function detalles_adicionales(Request $request){
        $id_student = $request->estudiante;
        if(is_array($request->curso)){
            $id_course = $request->curso[0];
        }else{
            $id_course = $request->curso;
        }
        
        switch ($request->mes) {
            case '1':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($nombre);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_actual = Carbon::now();
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','<=',$fecha_actual)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;
            case '2':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of february 2022');
                $fecha_fin = new Carbon('last day of february 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '3':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of March 2022');
                $fecha_fin = new Carbon('last day of March 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '4':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of april 2022');
                $fecha_fin = new Carbon('last day of april 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '5':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of may 2022');
                $fecha_fin = new Carbon('last day of may 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '6':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of june 2022');
                $fecha_fin = new Carbon('last day of june 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '7':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of july 2022');
                $fecha_fin = new Carbon('last day of july 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '8':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of August 2022');
                $fecha_fin = new Carbon('last day of August 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '9':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of September 2022');
                $fecha_fin = new Carbon('last day of September 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '10':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of October 2022');
                $fecha_fin = new Carbon('last day of October 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '11':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($course_moodle->fullname);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_inicio = new Carbon('first day of november 2022');
                $fecha_fin = new Carbon('last day of november 2022');
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','>=',$fecha_inicio)->where('date_session','<=',$fecha_fin)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;                   
            case '12':
                $estudiante =perfilEstudiante::withTrashed()->findOrFail($id_student);
                $course_moodle = CourseMoodle::select('fullname','group_id','attendance_id')->where('id',$id_course)->firstOrfail();
                $nombre = explode("-",$course_moodle->fullname)[0];
                //dd($nombre);
                $cohort = $estudiante->studentGroup->group->cohort->id;
                //dd($cohort);
                $curso = Course::select('id','name')->where('name',$nombre)->where('id_cohort',$cohort)->firstOrfail();
                $this->course = explode("-",$course_moodle->fullname)[1];
                $fecha_actual = Carbon::now();
                //dd($fecha_actual->format('y-m-d'));
                $sesiones = Session::select('date_session')->where('date_session','<=',$fecha_actual)->where('id_group',$course_moodle->group_id)->where('id_course',$curso->id)->get();
                $this->attendance_id = $course_moodle->attendance_id;
                $this->id_moodle = $estudiante->id_moodle;
                $sesiones->map(function($sesion){
                    $sesiones_moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->exists();
                    $sesion->grupo = $this->course;
                    if($sesiones_moodle){
                        $moodle = SessionCourse::where('attendance_id',$this->attendance_id)->where('sessdate',$sesion->date_session)->firstOrfail();
                        //dd($moodle->session_id, $this->id_moodle);
                        $asistencia = AttendanceStudent::where('session_id',intval($moodle->session_id))->where('id_moodle',intval($this->id_moodle))->where(function($q){
                            $q->where('grade','P')->Orwhere('grade','R');
                        })->exists();
                        //dump($asistencia);
                        if($moodle->lasttaken != null){
                            $sesion->calificada = "SI";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }    
                        }else {
                            //dump($asistencia,$moodle->lasttaken);
                            $sesion->calificada = "NO";
                            if($asistencia == true){
                                $sesion->asistio = "SI";
                            }else{
                                $sesion->asistio = "NO";
                            }
                        }  
                    }else{
                        $sesion->asistio = "NO";
                        $sesion->calificada = "NO";
                    }
                });
                return datatables()->of($sesiones)->toJson();
                break;
            default:
                ECHO "ERROR MES...";
                break;
        }     
    }
    
    public function cargar_asistencias(Request $request){
        //dd($request,$request->file('sesiones'));
        $verificar_nombre = explode("_", $request->file('sesiones')->getClientOriginalName());
        if($verificar_nombre[0] == "sessionsbycoursereport"){
            $nombre = "sessionsbycoursereport.json";        
            if(Storage::disk('local')->exists($nombre)) {
                Storage::delete($nombre);
            }
            Storage::putFileAs('/', $request->file('sesiones'), $nombre);
            $sesiones =  json_decode(Storage::get($nombre));
            //dd($sesiones);
            $course_moodle = DB::table('course_moodles')->truncate();
            $session_course = DB::table('session_courses')->truncate();

            foreach($sesiones as $sesion){
                //dd($sesion);
                $shortname = explode("-",$sesion->shortname);
                //dd($shortname);
                $shortname[2];
                //dd($grupo);
                if($shortname[2] < 10)
                {
                    $shortname[2] = explode("0",$shortname[2]);
                    $grupo = "Grupo"." ".$shortname[2][1];
                }else{
                    $grupo = "Grupo"." ".$shortname[2];
                }
                switch($shortname[4]){
                    case "A0":
                        $shortname[4] = 1;
                        break;
                    case "TE":
                        $shortname[4] = 2;
                        break;
                    case "TS":
                        $shortname[4] = 3;
                        break;
                    default:
                    echo "NO SE ENCUENTRA LA COHORTE";            
                }
                //dd($shortname); 
                $grupos = Group::select('id')->where('name',$grupo)->where('id_cohort',$shortname[4])->first();
                //dd($grupos->id);
                $course_moodle = CourseMoodle::create([
                    'fullname'    =>   $sesion->fullname,
                    'course_id'   =>   $sesion->courseid,
                    'instance_id' =>   $sesion->instanceid,
                    'attendance_id' => $sesion->attendanceid,
                    'group_id'    =>   $grupos->id,
                ]);

                foreach($sesion->sessions as $course){
                    
                    //dd($date = date('d-m-Y H:i:s', $course->sesstimestamp));
                    $date = Carbon::today();
                    $sessdate = new Carbon();
                    $sessdate->setTimestamp($course->sesstimestamp);
                    //dd($date,$sessdate);
                    //dd($date->setTimestamp($course->sesstimestamp));
                    if($date > $sessdate){
                        $sesion_course = SessionCourse::create([
                        'attendance_id' => $sesion->attendanceid,
                        'session_id'    => $course->id,
                        'sessdate'      => $sessdate,
                        'lasttaken'     => $course->lasttaken,
                        'description'   => " ",
                        'type'          => " ",
                        ]);
                    }
                    
                    //dd($sesion->fullname);
                }           
            }
            return back()->with('status', "el archivo" . " " . $request->file('sesiones')->getClientOriginalName() . " " . "fue importado correctamente");
        }

        if($verificar_nombre[0] == "attendancereport"){
            $nombre = "attendancereport.json";        
            if(Storage::disk('local')->exists($nombre)) {
                Storage::delete($nombre);
                Storage::delete("asistencias_linea_1.json");
                Storage::delete("asistencias_linea_2.json");
                Storage::delete("asistencias_linea_3.json");
            }
            Storage::putFileAs('/', $request->file('sesiones'), $nombre);
            $attendances =  json_decode(Storage::get($nombre));   
            $attendance_student = DB::table('attendance_students')->truncate();
            
            foreach($attendances as $attendance){
            
                foreach($attendance->courses as $course){
                    //dd($course);
                    foreach($course->attendance->fullsessionslog as $sesion){
                        //dump($course, $attendance,$sesion);
                        $attendance_student = AttendanceStudent::create([
                            'id_moodle'     => $attendance->userid,
                            'session_id'    => $sesion->sessionid,
                            'grade'         => $sesion->statusacronym,
                            'notes'         => " ",
                        ]);  
                    }
                    /*$course_session = SessionCourse::where('attendance_id',$course->attendance->attendanceid)->get();
                    foreach($course_session as $sesionid){
                        //dd($sesionid);
                        $attendance_student = AttendanceStudent::where('session_id',$sesionid->session_id)->where('id_moodle',$attendance->userid)->exists();
                        //dd($attendance_student);
                        switch ($attendance_student) {
                            case true:
                                break;
                            case false:
                                $attendance_student = AttendanceStudent::create([
                                                        'id_moodle'     => $attendance->userid,
                                                        'session_id'    => $sesionid->session_id,
                                                        'grade'         => "I",
                                                        'notes'         => " ",
                                                    ]);
                                break;
                            default:
                            echo "i no es igual a 0, 1 ni 2";
                        }
                    }*/
                    //dd($course_session);
                }
                //dd("hecho");
            }
            return back()->with('status', "el archivo" . " " . $request->file('sesiones')->getClientOriginalName() . " " . "fue importado correctamente");
        }else{
            return back()->with('message-error', 'Por favor seleccione un archivo valido');
        }       
    }

}
