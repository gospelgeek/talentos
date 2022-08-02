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
use App\StudentGroup;
use App\Session;
use App\Course;
use App\CourseItems;
use App\StudentsGrade;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
use App\Exports\NotasExport;
use Excel;

class SeguimientosController extends Controller
{
public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }
    public function index(){
        $asignaturas = Course::All();
        return view('academico.reporteGrupal.index', compact('asignaturas'));
    }

    public function Grupos_Asignatura($id){
        $name = Course::where('id', $id)->first();
        $this->course= $name->name;
        $this->course_id= $id;
        $grupos = Group::all()->where('id_cohort', $name->id_cohort)->where('name','!=',"TEMPORAL");
        $this->eliminar = array();
        $grupos->map(function($grupo,$index){
            //dd($grupo->id,$index);
            $course_moodle = CourseMoodle::select('course_id')->where('group_id', $grupo->id)->where('fullname','LIKE',"$this->course%")->exists();
            if($course_moodle){
            //dump($course_moodle->course_id);
            $course_moodle = CourseMoodle::select('course_id')->where('group_id', $grupo->id)->where('fullname','LIKE',"$this->course%")->firstOrfail();    
            $Asistencia = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','ASISTENCIA PARTICIPATIVA')->exists();
           //dd($Asistencia);
            
            if($Asistencia){
                $Asistencia = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','ASISTENCIA PARTICIPATIVA')->first();

                //dd($Asistencia);
                $grades = StudentsGrade::select('grade')->where('item_id',$Asistencia->item_id)->get();
                $total_asistencia = 0;
                foreach($grades as $grade){
                    $total_asistencia = $total_asistencia + $grade->grade;
                }
                if($total_asistencia > 0){
                    $grupo->promedio_asistencia = number_format($total_asistencia/count($grades),2);  

                }else{
                    $grupo->promedio_asistencia = "-";
                }
                  
            }else{
                $grupo->promedio_asistencia = "-";
            }

            $seguimientos =  CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name',['SEGUIMIENTO ACADÉMICO','Actividades autogestionarias'])->exists();
            //dd($seguimientos);
            if($seguimientos){
                $seguimientos = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name',['SEGUIMIENTO ACADÉMICO','Actividades autogestionarias'])->first();

                $grades = StudentsGrade::select('grade')->where('item_id',$seguimientos->item_id)->get();
                $total_seguimientos = 0;
                foreach($grades as $grade){
                    $total_seguimientos = $total_seguimientos + $grade->grade;
                }
                if($total_seguimientos > 0){
                    $grupo->promedio_seguimientos = number_format($total_seguimientos/count($grades),2);  

                }else{
                    $grupo->promedio_seguimientos = "-";
                }
            }else{
                $grupo->promedio_seguimientos = "-";
            }

            $autoevaluacion =  CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','Autoevaluación')->exists();
            //dd($autoevaluacion);
            if($autoevaluacion){
                $autoevaluacion = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','Autoevaluación')->first();
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
                    $grupo->promedio_autoevaluacion = number_format($total_autoevaluacion/count($grades),2);
                }else{

                    $grupo->promedio_autoevaluacion = "-";
                }
                                 
            }else{
                $grupo->promedio_autoevaluacion = "-";
            }
            }else{
                array_push($this->eliminar, $index);
            }
            //dd("bien"); 
        });

        foreach($this->eliminar as $borrar){
            $grupos->pull($borrar);
        }
        //dd($this->eliminar);

        return view('academico.reporteGrupal.grupos',compact('name','grupos'));
    }

    public function detalle_seguimientos_grupo($id_curso,$id_grupo){

        $grupo = Group::where('id', $id_grupo)->first();
        $name = Course::where('id', $id_curso)->first();

        $course_moodle = CourseMoodle::select('course_id')->where('group_id', $grupo->id)->where('fullname','LIKE',"$name->name%")->firstOrfail();
        //dd($course_moodle);
        $this->course = $course_moodle->course_id;
        $this->grupo = $id_grupo;

        $estudiantes = perfilEstudiante::select('name','lastname','document_number','id_moodle')->whereHas('studentGroup',function($q)
        {
            $q->where('id_group', '=', $this->grupo);
        })->get();


        $estudiantes->map(function($estudiante){

            //dd($course_moodle);
            $estudiante->id_curso = $this->course;
            $Asistencia = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name','ASISTENCIA PARTICIPATIVA')->exists();
            //dd($Asistencia);
            if($Asistencia){
                $Asistencia = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name','ASISTENCIA PARTICIPATIVA')->first();

                $grades = StudentsGrade::select('grade','item_id')->where('item_id',$Asistencia->item_id)->where('id_moodle',$estudiante->id_moodle)->exists();

                if($grades){
                    $grades = StudentsGrade::select('grade','item_id')->where('item_id',$Asistencia->item_id)->where('id_moodle',$estudiante->id_moodle)->first();
                    //dump($grades->grade);
                    $estudiante->asistencia = $grades->grade;
                }else{
                    $estudiante->asistencia = "-";
                }
                  
            }else{
                $estudiante->asistencia = "-";
            }


            $seguimientos = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name',['SEGUIMIENTO ACADÉMICO','Actividades autogestionarias'])->exists();

            if($seguimientos){
                $seguimientos = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name',['SEGUIMIENTO ACADÉMICO','Actividades autogestionarias'])->first();

                $grades = StudentsGrade::select('grade','item_id')->where('item_id',$seguimientos->item_id)->where('id_moodle',$estudiante->id_moodle)->exists();

                if($grades){
                    $grades = StudentsGrade::select('grade','item_id')->where('item_id',$seguimientos->item_id)->where('id_moodle',$estudiante->id_moodle)->first();
                    //dump($grades->grade);
                    $estudiante->seguimientos = $grades->grade;
                }else{
                    $estudiante->seguimientos = "-";
                }
                  
            }else{
                $estudiante->seguimientos = "-";
            }


            $autoevaluacion = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name','AUTOEVALUACIÓN')->exists();

            if($autoevaluacion){
                $autoevaluacion = CourseItems::select('item_id')->where('course_id',$this->course)->where('item_type',"category")->where('item_name','AUTOEVALUACIÓN')->first();

                $grades = StudentsGrade::select('grade','item_id')->where('item_id',$autoevaluacion->item_id)->where('id_moodle',$estudiante->id_moodle)->exists();

                if($grades){
                    $grades = StudentsGrade::select('grade','item_id')->where('item_id',$autoevaluacion->item_id)->where('id_moodle',$estudiante->id_moodle)->first();
                    //dump($grades->grade);
                    $estudiante->autoevaluacion = $grades->grade;
                }else{
                    $estudiante->autoevaluacion = "-";
                }
                  
            }else{
                $estudiante->autoevaluacion = "-";
            }

            $total_curso =CourseItems::select('item_id')->where('course_id',$this->course)->where('category_name',"TOTAL CURSO")->exists();

            if($total_curso){
                $total_curso = CourseItems::select('item_id')->where('course_id',$this->course)->where('category_name',"TOTAL CURSO")->first();

                $grades = StudentsGrade::select('grade','item_id')->where('item_id',$total_curso->item_id)->where('id_moodle',$estudiante->id_moodle)->exists();

                if($grades){
                    $grades = StudentsGrade::select('grade','item_id')->where('item_id',$total_curso->item_id)->where('id_moodle',$estudiante->id_moodle)->first();
                    //dump($grades->grade);
                    $estudiante->total_curso = $grades->grade;
                }else{
                    $estudiante->total_curso = "-";
                }
                  
            }else{
                $estudiante->total_curso = "-";
            }

        });

        //dd($estudiantes);

        return view('academico.reporteGrupal.detalle_grupo', compact('grupo', 'name','estudiantes'));
    }
    public function reporte_notas($id){
        ini_set('memory_limit', '1024M');
        $notas_generales = json_decode(Storage::get('itemsbycoursereport.json'));
        $notas_estudiante    = json_decode(Storage::get('gradesreport.json'));
        $cursos_moodle=array();
        foreach($notas_generales as $notas){
            //dd($notas);
            $items_generales = array();
            foreach($notas->items as $items){
                if($items->type == "category"){
                   foreach($items->children as $children){
                        if($children->itemtype == "category"){
                            //dump($children->itemid);
                            $items_generales[] = array('id_item'=>$children->itemid,'item_name'=>$children->itemname);
                        }   
                    } 
                }else if($items->type == "fillerlast"){
                    $items_generales[] = array('id_item'=>$items->itemid,'item_name'=>$items->itemname);
                }
                
            }
            $cursos_moodle[]=array('courseid'=>$notas->courseid,'items'=>$items_generales);
        }
        //dd($cursos[0]);
        //
        $estudiantes = array();
        foreach($notas_estudiante as $estudiante){
            $student = perfilEstudiante::where('id_moodle',$estudiante->userid)->with('studentGroup')->exists();
            if($estudiante->courses != [] && $student){
                $comprobar_linea = perfilEstudiante::select('id','name','lastname','document_number')->where('id_moodle',$estudiante->userid)->with('studentGroup')->firstOrfail();
                switch ($id) {
                    case '1':
                    //dd("entro");
                        if($comprobar_linea->studentGroup->group->cohort->name == "LINEA 1"){
                            foreach($estudiante->courses as $key =>$courses){
                                //dd($courses);
                                $individual=array();
                                foreach($courses->items as $items){
                                    $nota = $this->buscar($cursos_moodle,$items->itemid,$courses->courseid);
                                    //dd($nota);
                                    if($nota != null){
                                        //dd($nota);
                                        $individual[]=array('item'=>$nota['item_name'],'nota'=>$items->grade);
                                    }  
                                }
                                $fullname = explode("-",$courses->fullname)[0];
                                $cursos[] = array('name'=>$fullname,'notas'=>$individual);
                                //dd($cursos);
                            }
                            $estudiantes[] = array('name'=>$comprobar_linea->name,
                                            'lastname'=>$comprobar_linea->lastname,
                                            'Documento'=>$comprobar_linea->document_number,
                                            'grupo'=>$comprobar_linea->studentGroup->group->name,
                                            'linea'=>$comprobar_linea->studentGroup->group->cohort->name,
                                            'asignatura'=>$cursos);
                            
                        }
                    break;              
                    case '2':
                        if($comprobar_linea->studentGroup->group->cohort->name == "LINEA 2"){
                            foreach($estudiante->courses as $key =>$courses){
                                //dd($courses);
                                $individual=array();
                                foreach($courses->items as $items){
                                    $nota = $this->buscar($cursos_moodle,$items->itemid,$courses->courseid);
                                    //dd($nota);
                                    if($nota != null){
                                        //dd($nota);
                                        $individual[]=array('item'=>$nota['item_name'],'nota'=>$items->grade);
                                    }  
                                }
                                $fullname = explode("-",$courses->fullname)[0];
                                $cursos[] = array('name'=>$fullname,'notas'=>$individual);
                                //dd($cursos);
                            }
                            $estudiantes[] = array('name'=>$comprobar_linea->name,
                                            'lastname'=>$comprobar_linea->lastname,
                                            'Documento'=>$comprobar_linea->document_number,
                                            'grupo'=>$comprobar_linea->studentGroup->group->name,
                                            'linea'=>$comprobar_linea->studentGroup->group->cohort->name,
                                            'asignatura'=>$cursos);
                            //dd($estudiantes);
                            
                        }    
                    break;    
                    case '3':
                        if($comprobar_linea->studentGroup->group->cohort->name == "LINEA 3"){
                            foreach($estudiante->courses as $key =>$courses){
                                //dd($courses);
                                $individual=array();
                                foreach($courses->items as $items){
                                    $nota = $this->buscar($cursos_moodle,$items->itemid,$courses->courseid);
                                    //dd($nota);
                                    if($nota != null){
                                        //dd($nota);
                                        $individual[]=array('item'=>$nota['item_name'],'nota'=>$items->grade);
                                    }  
                                }
                                $fullname = explode("-",$courses->fullname)[0];
                                $cursos[] = array('name'=>$fullname,'notas'=>$individual);
                                //dd($cursos);
                            }
                            $estudiantes[] = array('name'=>$comprobar_linea->name,
                                            'lastname'=>$comprobar_linea->lastname,
                                            'Documento'=>$comprobar_linea->document_number,
                                            'grupo'=>$comprobar_linea->studentGroup->group->name,
                                            'linea'=>$comprobar_linea->studentGroup->group->cohort->name,
                                            'asignatura'=>$cursos);
                            //dd($estudiantes);
                        }
                    break;
                    default:
                        return "Error Consulte Al Administrador";
                        break;
                }
            }
            
            //dd("para",$cursos);
        }
       
        $export = new NotasExport([$estudiantes]);
        $fechaexcel = Carbon::now();

        $fechaexcel = $fechaexcel->format('d-m-Y');
        
        
        return Excel::download($export, "REPORTE NOTAS"." "."LINEA"." ".$id." ".$fechaexcel.".xlsx");    
                
        
    }

    function buscar($a,$buscado,$courseid){
        //dd($a);
        if($a == []) return null;
        foreach($a as $v)
            //dd($v);
            if($v['courseid'] == $courseid)
                //dd($v['items']);
                foreach($v['items'] as $buscar)    
                    if($buscado==$buscar['id_item'])
                    return $buscar;
    }

    public function Cargar_notas(Request $request){

        $verificar_nombre = explode("_", $request->file('grades')->getClientOriginalName());
        
        //dd($verificar_nombre);

        switch ($verificar_nombre[0]) {
            case 'gradesreport':
                $nombre = "gradesreport.json";        
                if(Storage::disk('local')->exists($nombre)) {
                    Storage::delete($nombre);
                }
                Storage::putFileAs('/', $request->file('grades'), $nombre);

                $students_grades =  json_decode(Storage::get($nombre));

                $StudentsGrade = DB::table('students_grades')->truncate();

                foreach($students_grades as $student_grade){
                    foreach($student_grade->courses as $courses){
                        foreach($courses->items as $items){
                            //dd($items->grade,$student_grade->userid);
                            if($items->grade != "-" && $items->grade != "Cumplió" && $items->grade != "Present" && $items->grade != "Error" && $items->grade != "" && $items->grade != "Yes" && $items->grade != "No"){
                                $grade = explode(",",$items->grade);
                                //dd(count($grade));
                                if(count($grade) > 1){
                                    $grades = StudentsGrade::create([
                                        'item_id'       => $items->itemid,
                                        'id_moodle'     => $student_grade->userid,
                                        'grade'         => $grade[0].".".$grade[1],
                                    ]);
                                }else{
                                    $grades = StudentsGrade::create([
                                        'item_id'       => $items->itemid,
                                        'id_moodle'     => $student_grade->userid,
                                        'grade'         => $items->grade,
                                    ]);
                                }
                                
                            }
                             
                        }
                        //dd($courses);
                    }
                    //dd($student_grade);
                }

                break;

            case 'itemsbycoursereport':
                $nombre = "itemsbycoursereport.json";        
                if(Storage::disk('local')->exists($nombre)) {
                    Storage::delete($nombre);
                }
                Storage::putFileAs('/', $request->file('grades'), $nombre);

                $items_course_students =  json_decode(Storage::get($nombre));

                $Course_items = DB::table('course_items')->truncate();

                foreach($items_course_students as $items_course_student){
                    
                    foreach($items_course_student->items as $item){
                        //dump($item);
                        switch ($item->type) {
                            case 'category':
                                foreach($item->children as $children){
                                    //dump($children->itemname);

                                    $items = CourseItems::create([
                                        'category_name' => $item->categoryname,
                                        'course_id'     => $items_course_student->courseid,
                                        'item_type'     => $children->itemtype,
                                        'item_id'       => $children->itemid,
                                        'item_instance' => $children->iteminstance,
                                        'item_name'     => $children->itemname,
                                    ]);
                                }
                                break;
                            
                            case 'fillerlast':
                                $items = CourseItems::create([
                                        'category_name' => 'TOTAL CURSO',
                                        'course_id'     => $items_course_student->courseid,
                                        'item_type'     => $item->itemtype,
                                        'item_id'       => $item->itemid,
                                        'item_instance' => $item->iteminstance,
                                        'item_name'     => $item->itemname,
                                    ]);
                                break;

                            case 'filler':
                                   $items = CourseItems::create([
                                        'category_name' => 'TOTAL CURSO',
                                        'course_id'     => $items_course_student->courseid,
                                        'item_type'     => $item->itemtype,
                                        'item_id'       => $item->itemid,
                                        'item_instance' => $item->iteminstance,
                                        'item_name'     => $item->itemname,
                                    ]); 
                                   break;

                            case 'item':
                                   $items = CourseItems::create([
                                        'category_name' => 'TOTAL CURSO',
                                        'course_id'     => $items_course_student->courseid,
                                        'item_type'     => $item->itemtype,
                                        'item_id'       => $item->itemid,
                                        'item_instance' => $item->iteminstance,
                                        'item_name'     => $item->itemname,
                                    ]);
                                   break;

                            case 'courseitem':
                                    $items = CourseItems::create([
                                        'category_name' => 'TOTAL CURSO',
                                        'course_id'     => $items_course_student->courseid,
                                        'item_type'     => $item->itemtype,
                                        'item_id'       => $item->itemid,
                                        'item_instance' => $item->iteminstance,
                                        'item_name'     => $item->itemname,
                                    ]);
                                          break;          
                            default:
                                // code...
                                break;
                        }
                        
                    }
                    //dd("entro");
                }

                break;

            default:
                return back()->with('message-error', 'Por favor seleccione un archivo valido');
                break;
        }

        return back()->with('status', "el archivo" . " " . $request->file('grades')->getClientOriginalName() . " " . "fue importado correctamente");
    }
}
