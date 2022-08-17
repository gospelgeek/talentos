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
use App\Cohort;
use App\CourseItems;
use App\StudentsGrade;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
use App\Exports\NotasExport;
use Excel;
use App\Imports\CsvImport;
use App\Exports\ReporteExport;
use App\Exports\NotasLinea1Export;
use App\Exports\NotasLinea2Export;
use App\Exports\NotasLinea3Export;
use Response;

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
            //dd($grupo->name,$index);
            $course_moodle = CourseMoodle::select('course_id')->where('group_id', $grupo->id)->where('fullname','LIKE',"$this->course%")->exists();
            //dd($course_moodle);
            if($course_moodle){
            
            $course_moodle = CourseMoodle::select('course_id')->where('group_id', $grupo->id)->where('fullname','LIKE',"$this->course%")->firstOrfail();

            $grupo->items_huerfanos = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('category_name',"ITEM HUERFANO")->count();
            //dd($course_moodle);    
            $Asistencia = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','like','asistencia%')->exists();
           //dd($Asistencia);
            
            if($Asistencia){
                $Asistencia = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('item_type',"category")->where('item_name','like','asistencia%')->first();

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
                    $grupo->promedio_seguimientos = number_format($total_seguimientos/count($grades),2);  

                }else{
                    $grupo->promedio_seguimientos = "-";
                }
            }else{
                $grupo->promedio_seguimientos = "-";
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
        //dd($estudiantes);
        $items_huerfanos = CourseItems::select('item_id')->where('course_id',$course_moodle->course_id)->where('category_name',"ITEM HUERFANO")->count();

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

        });

        //dd($estudiantes);

        return view('academico.reporteGrupal.detalle_grupo', compact('grupo', 'name','estudiantes','course_moodle','items_huerfanos'));
    }

    public function items_huerfanos_y_items_categorias(Request $request){
        //dd($request->tipo);


        switch ($request->tipo) {

            case '1':
                $items_estudiante = CourseItems::select('item_id','item_name')->where('course_id',$request->id_curso)->where('item_type','!=',"category")->where('category_name','like','ASISTENCIA%')->get();
                break;

            case '2':
                $items_estudiante = CourseItems::select('item_id','item_name')->where('course_id',$request->id_curso)->where('item_type','!=',"category")->where(function($q){
                    $q->where('category_name', 'like', 'seguimiento%')->Orwhere('category_name','like','componente%')->Orwhere('category_name','like','actividades%')->Orwhere('category_name','like','parciales%')->Orwhere('category_name','like','seminario%');
                })->get();
                break;

            case '3':
                $items_estudiante  = CourseItems::select('item_id','item_name')->where('course_id',$request->id_curso)->where('item_type','!=',"category")->where('category_name','like','auto%')->get();
                break;

            case '4':
                $items_estudiante  = CourseItems::select('item_id','item_name')->where('category_name','ITEM HUERFANO')->where('course_id',$request->id_curso)->get();
                break;

            default:
                echo "ERROR CONSULTAR CON EL ADMINISTRADOR";
                break;
        }
        $this->id_moodle = $request->id_moodle;
        $items_estudiante->map(function($item){
            $grade = StudentsGrade::select('grade')->where('item_id',$item->item_id)->where('id_moodle',$this->id_moodle)->first();
                    //dd($grade);
            $item->grade = $grade ? $grade->grade : "-";
        });
        return datatables()->of($items_estudiante)->toJson();
        
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
                            if($items->grade != "-" && $items->grade != "Cumplió" && $items->grade != "Present" && $items->grade != "Error" && $items->grade != "" && $items->grade != "Yes" && $items->grade != "No" && $items->grade != "No cumplió"){
                                $grade = explode(",",$items->grade);
                                $grade2 = explode(" ",$items->grade);

                                //dd(count($grade2));
                                if(count($grade) > 1){
                                    if(count($grade2) == 1){
                                       $grades = StudentsGrade::create([
                                            'item_id'       => $items->itemid,
                                            'id_moodle'     => $student_grade->userid,
                                            'grade'         => $grade[0].".".$grade[1],
                                        ]); 
                                    }
                                    else if(count($grade2) > 1){
                                        $grade = explode(" ",$items->grade)[0];
                                        $grade1 = explode(",",$grade);
                                        //$grade2 = $grade2[0] + explode(",",$items->grade);
                                        //dd($grade,$grade1);
                                        $grades = StudentsGrade::create([
                                            'item_id'       => $items->itemid,
                                            'id_moodle'     => $student_grade->userid,
                                            'grade'         => $grade1[0].".".$grade1[1],
                                        ]); 
                                    }
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
                                        'item_type'     => 'total curso',
                                        'item_id'       => $item->itemid,
                                        'item_instance' => $item->iteminstance,
                                        'item_name'     => $item->itemname,
                                    ]);
                                break;

                            case 'filler':
                                   $items = CourseItems::create([
                                        'category_name' => 'ITEM HUERFANO',
                                        'course_id'     => $items_course_student->courseid,
                                        'item_type'     => $item->itemtype,
                                        'item_id'       => $item->itemid,
                                        'item_instance' => $item->iteminstance,
                                        'item_name'     => $item->itemname,
                                    ]); 
                                   break;

                            case 'fillerfirst':
                                   $items = CourseItems::create([
                                        'category_name' => 'ITEM HUERFANO',
                                        'course_id'     => $items_course_student->courseid,
                                        'item_type'     => $item->itemtype,
                                        'item_id'       => $item->itemid,
                                        'item_instance' => $item->iteminstance,
                                        'item_name'     => $item->itemname,
                                    ]); 
                                   break;  
                                        
                            case 'item':
                                   $items = CourseItems::create([
                                        'category_name' => 'ITEM HUERFANO',
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
                                        'item_type'     => 'total curso',
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
    
   public function notasIndividuales(){

        $cohorte = Cohort::pluck('name', 'id');
         
        return view('academico.reporteGeneral.reporte_individuales', compact('cohorte'));
    }

    public function notas_linea1(){
        if(Storage::disk('local')->exists('notas_linea_1.json')) {
                    $asistencias    = json_decode(Storage::get('notas_linea_1.json'));
                    //dd($asistencias);
                    $estudiantes = collect($asistencias);
                    
                    $estudiantes->map(function($estudiante){

                        $accionciudadana_asistencias = 0;
                        $accionciudadana_seguimientos = 0;
                        $accionciudadana_autoevaluacion = 0;
                        $accionciudadana_totalcurso = 0;
                        $item_huerfano_accion_ciudadana = 0;
                        $courseid_accion_ciudadana = 0;

                        $artes_asistencias = 0;
                        $artes_seguimientos = 0;
                        $artes_autoevaluacion = 0;
                        $artes_totalcurso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;

                        $biologia_asistencias = 0;
                        $biologia_seguimientos = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_totalcurso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;

                        $cultura_asistencias = 0;
                        $cultura_seguimientos = 0;
                        $cultura_autoevaluacion = 0;
                        $cultura_totalcurso = 0;
                        $item_huerfano_cultura = 0;
                        $courseid_cultura = 0;

                        $deporte_asistencias = 0;
                        $deporte_seguimientos = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_totalcurso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;

                        $dialogo_asistencias = 0;
                        $dialogo_seguimientos = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_totalcurso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;

                        $filosofia_asistencias = 0;
                        $filosofia_seguimientos = 0;
                        $filosofia_autoevaluacion = 0;
                        $filosofia_totalcurso = 0;
                        $item_huerfano_filosofia = 0;
                        $courseid_filosofia = 0;

                        $fisica_asistencias = 0;
                        $fisica_seguimientos = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_totalcurso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;

                        $geografia_asistencias = 0;
                        $geografia_seguimientos = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_totalcurso = 0;
                        $item_huerfano_geografia = 0;
                        $courseid_geografia = 0;

                        $historia_asistencias = 0;
                        $historia_seguimientos = 0;
                        $historia_autoevaluacion = 0;
                        $historia_totalcurso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;

                        $ingles_asistencias = 0;
                        $ingles_seguimientos = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_totalcurso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;

                        $lectura_asistencias = 0;
                        $lectura_seguimientos = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_totalcurso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;

                        $matematicas_asistencias = 0;
                        $matematicas_seguimientos = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_totalcurso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;

                        $quimica_asistencias = 0;
                        $quimica_seguimientos = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_totalcurso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;

                        $tic_asistencias = 0;
                        $tic_seguimientos = 0;
                        $tic_autoevaluacion = 0;
                        $tic_totalcurso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;

                        //dd($estudiante->asignaturas);
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode(' ',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'JORNADAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $accionciudadana_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $accionciudadana_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $accionciudadana_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $accionciudadana_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_accion_ciudadana += 1;
                                    }                                           
                                    
                                    $courseid_accion_ciudadana = $cursos->id;
                                    break;

                                case 'ARTES:':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $artes_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $artes_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $artes_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $artes_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_artes +=1;
                                    }                                           
                                    
                                    $courseid_artes = $cursos->id;
                                    break;

                                case 'BIOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $biologia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $biologia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $biologia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_biologia += 1;
                                    }                                           
                                    
                                    $courseid_biologia = $cursos->id;
                                    break;

                                case 'CULTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $cultura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $cultura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $cultura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $cultura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_cultura += 1;
                                    }                                           
                                    
                                    $courseid_cultura = $cursos->id;
                                    break;

                                case 'DEPORTE':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $deporte_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $deporte_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $deporte_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_deporte += 1;
                                    }                                           
                                    
                                    $courseid_deporte = $cursos->id;
                                    break;

                                case 'DIALOGO':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $dialogo_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $dialogo_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $dialogo_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_dialogo += 1;
                                    }                                           
                                    
                                    $courseid_dialogo = $cursos->id;
                                    break;

                                case 'FILOSOFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $filosofia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $filosofia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $filosofia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $filosofia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_filosofia += 1;
                                    }                                           
                                    
                                    $courseid_filosofia = $cursos->id;
                                    break;

                                case 'FISICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $fisica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $fisica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $fisica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_fisica += 1;
                                    }                                           
                                    
                                    $courseid_fisica = $cursos->id;
                                    break;

                                case 'GEOGRAFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $geografia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $geografia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $geografia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_geografia += 1;
                                    }                                           
                                    
                                    $courseid_geografia = $cursos->id;
                                    break;

                                case 'HISTORIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $historia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $historia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $historia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $historia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_historia += 1;
                                    }                                           
                                    
                                    $courseid_historia = $cursos->id;
                                    break;

                                case 'INGLES':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $ingles_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $ingles_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $ingles_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_ingles += 1;
                                    }                                           
                                    $courseid_ingles = $cursos->id;
                                    break;                               
                                case 'LECTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $lectura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $lectura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $lectura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_lectura +=1 ;
                                    }                                           
                                    
                                    $courseid_lectura = $cursos->id;
                                    break;

                                case 'MATEMATICAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $matematicas_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $matematicas_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $matematicas_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_matematicas += 1;
                                    }                                           
                                    $courseid_matematicas = $cursos->id;
                                    break;                          

                                case 'QUIMICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $quimica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $quimica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $quimica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_quimica += 1;
                                    }                                           
                                    
                                    $courseid_quimica = $cursos->id;
                                    break;

                                case 'TECNOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $tic_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $tic_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $tic_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $tic_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_tic += 1;
                                    }                                           
                                                                            
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:                                        
                                    echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADO";
                                    break;
                            }
                        }
                        unset($estudiante->asignaturas);
                        $estudiante->accionciudadana_asistencias = $accionciudadana_asistencias;
                        $estudiante->accionciudadana_seguimientos = $accionciudadana_seguimientos;
                        $estudiante->accionciudadana_autoevaluacion = $accionciudadana_autoevaluacion;
                        $estudiante->accionciudadana_totalcurso = $accionciudadana_totalcurso;
                        $estudiante->accionciudadana_item_huerfano = $item_huerfano_accion_ciudadana;
                        $estudiante->courseid_accion_ciudadana = $courseid_accion_ciudadana;

                        $estudiante->artes_asistencias = $artes_asistencias;
                        $estudiante->artes_seguimientos = $artes_seguimientos;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_totalcurso = $artes_totalcurso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->courseid_artes = $courseid_artes;

                        $estudiante->biologia_asistencias = $biologia_asistencias;
                        $estudiante->biologia_seguimientos = $biologia_seguimientos;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_totalcurso = $biologia_totalcurso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->courseid_biologia = $courseid_biologia;

                        $estudiante->cultura_asistencias = $cultura_asistencias;
                        $estudiante->cultura_seguimientos = $cultura_seguimientos;
                        $estudiante->cultura_autoevaluacion = $cultura_autoevaluacion;
                        $estudiante->cultura_totalcurso = $cultura_totalcurso;
                        $estudiante->cultura_item_huerfano = $item_huerfano_cultura;
                        $estudiante->courseid_cultura = $courseid_cultura;

                        $estudiante->deporte_asistencias = $deporte_asistencias;
                        $estudiante->deporte_seguimientos = $deporte_seguimientos;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_totalcurso = $deporte_totalcurso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->courseid_deporte = $courseid_deporte;

                        $estudiante->dialogo_asistencias = $dialogo_asistencias;
                        $estudiante->dialogo_seguimientos = $dialogo_seguimientos;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_totalcurso = $dialogo_totalcurso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->courseid_dialogo = $courseid_dialogo;

                        $estudiante->filosofia_asistencias = $filosofia_asistencias;
                        $estudiante->filosofia_seguimientos = $filosofia_seguimientos;
                        $estudiante->filosofia_autoevaluacion = $filosofia_autoevaluacion;
                        $estudiante->filosofia_totalcurso = $filosofia_totalcurso;
                        $estudiante->filosofia_item_huerfano = $item_huerfano_filosofia;
                        $estudiante->courseid_filosofia = $courseid_filosofia;

                        $estudiante->fisica_asistencias = $fisica_asistencias;
                        $estudiante->fisica_seguimientos = $fisica_seguimientos;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_totalcurso = $fisica_totalcurso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->courseid_fisica = $courseid_fisica;

                        $estudiante->geografia_asistencias = $geografia_asistencias;
                        $estudiante->geografia_seguimientos = $geografia_seguimientos;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_totalcurso = $geografia_totalcurso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->courseid_geografia = $courseid_geografia;

                        $estudiante->historia_asistencias = $historia_asistencias;
                        $estudiante->historia_seguimientos = $historia_seguimientos;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_totalcurso = $historia_totalcurso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->courseid_historia = $courseid_historia;

                        $estudiante->ingles_asistencias = $ingles_asistencias;
                        $estudiante->ingles_seguimientos = $ingles_seguimientos;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_totalcurso = $ingles_totalcurso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->courseid_ingles = $courseid_ingles;

                        $estudiante->lectura_asistencias = $lectura_asistencias;
                        $estudiante->lectura_seguimientos = $lectura_seguimientos;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_totalcurso = $lectura_totalcurso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->courseid_lectura = $courseid_lectura;

                        $estudiante->matematicas_asistencias = $matematicas_asistencias;
                        $estudiante->matematicas_seguimientos = $matematicas_seguimientos;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_totalcurso = $matematicas_totalcurso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->courseid_matematicas = $courseid_matematicas;

                        $estudiante->quimica_asistencias = $quimica_asistencias;
                        $estudiante->quimica_seguimientos = $quimica_seguimientos;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_totalcurso = $quimica_totalcurso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->courseid_quimica = $courseid_quimica;

                        $estudiante->tic_asistencias = $tic_asistencias;
                        $estudiante->tic_seguimientos = $tic_seguimientos;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_totalcurso = $tic_totalcurso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->courseid_tic = $courseid_tic;
                        //dd($estudiante);
                    });
                return datatables()->of($estudiantes)->toJson();
        }else{

            $estudiantes_linea1 = perfilEstudiante::Estudiantes_cohort_linea1();
            $estudiantes = collect($estudiantes_linea1);
            //dd($estudiantes);
            /*$cursos = explode(',', $estudiantes[0]->asignatura);
            $estudiantes[0]->asignatura = $cursos;*/
            //dd($estudiantes[0]);

            $estudiantes->map(function($estudiante){
                $estudiante->asignaturas = CourseMoodle::asignaturas($estudiante->grupo, $estudiante->id_moodle);
                //dd($estudiante);   
            });

            $estudiantes_notas = json_encode($estudiantes);
            Storage::disk('local')->put('notas_linea_1.json', $estudiantes_notas);
            $notas = json_decode($estudiantes_notas);

            $estudiantes_notas = collect($notas);
                           
            $estudiantes->map(function($estudiante){

                        $accionciudadana_asistencias = 0;
                        $accionciudadana_seguimientos = 0;
                        $accionciudadana_autoevaluacion = 0;
                        $accionciudadana_totalcurso = 0;
                        $item_huerfano_accion_ciudadana = 0;
                        $courseid_accion_ciudadana = 0;

                        $artes_asistencias = 0;
                        $artes_seguimientos = 0;
                        $artes_autoevaluacion = 0;
                        $artes_totalcurso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;

                        $biologia_asistencias = 0;
                        $biologia_seguimientos = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_totalcurso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;

                        $cultura_asistencias = 0;
                        $cultura_seguimientos = 0;
                        $cultura_autoevaluacion = 0;
                        $cultura_totalcurso = 0;
                        $item_huerfano_cultura = 0;
                        $courseid_cultura = 0;

                        $deporte_asistencias = 0;
                        $deporte_seguimientos = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_totalcurso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;

                        $dialogo_asistencias = 0;
                        $dialogo_seguimientos = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_totalcurso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;

                        $filosofia_asistencias = 0;
                        $filosofia_seguimientos = 0;
                        $filosofia_autoevaluacion = 0;
                        $filosofia_totalcurso = 0;
                        $item_huerfano_filosofia = 0;
                        $courseid_filosofia = 0;

                        $fisica_asistencias = 0;
                        $fisica_seguimientos = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_totalcurso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;

                        $geografia_asistencias = 0;
                        $geografia_seguimientos = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_totalcurso = 0;
                        $item_huerfano_geografia = 0;
                        $courseid_geografia = 0;

                        $historia_asistencias = 0;
                        $historia_seguimientos = 0;
                        $historia_autoevaluacion = 0;
                        $historia_totalcurso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;

                        $ingles_asistencias = 0;
                        $ingles_seguimientos = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_totalcurso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;

                        $lectura_asistencias = 0;
                        $lectura_seguimientos = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_totalcurso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;

                        $matematicas_asistencias = 0;
                        $matematicas_seguimientos = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_totalcurso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;

                        $quimica_asistencias = 0;
                        $quimica_seguimientos = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_totalcurso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;

                        $tic_asistencias = 0;
                        $tic_seguimientos = 0;
                        $tic_autoevaluacion = 0;
                        $tic_totalcurso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;

                        //dd($estudiante->asignaturas);
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode(' ',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'JORNADAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $accionciudadana_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $accionciudadana_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $accionciudadana_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $accionciudadana_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_accion_ciudadana += 1;
                                    }                                           
                                    
                                    $courseid_accion_ciudadana = $cursos->id;
                                    break;

                                case 'ARTES:':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $artes_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $artes_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $artes_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $artes_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_artes += 1;
                                    }                                           
                                    
                                    $courseid_artes = $cursos->id;
                                    break;

                                case 'BIOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $biologia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $biologia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $biologia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_biologia += 1;
                                    }                                           
                                    
                                    $courseid_biologia = $cursos->id;
                                    break;

                                case 'CULTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $cultura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $cultura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $cultura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $cultura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_cultura += 1;
                                    }                                           
                                    
                                    $courseid_cultura = $cursos->id;
                                    break;

                                case 'DEPORTE':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $deporte_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $deporte_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $deporte_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_deporte += 1;
                                    }                                           
                                    
                                    $courseid_deporte = $cursos->id;
                                    break;

                                case 'DIALOGO':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $dialogo_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $dialogo_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $dialogo_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_dialogo += 1;
                                    }                                           
                                    
                                    $courseid_dialogo = $cursos->id;
                                    break;

                                case 'FILOSOFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $filosofia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $filosofia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $filosofia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $filosofia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_filosofia += 1;
                                    }                                           
                                    
                                    $courseid_filosofia = $cursos->id;
                                    break;

                                case 'FISICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $fisica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $fisica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $fisica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_fisica += 1;
                                    }                                           
                                    
                                    $courseid_fisica = $cursos->id;
                                    break;

                                case 'GEOGRAFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $geografia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $geografia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $geografia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_geografia += 1;
                                    }                                           
                                    
                                    $courseid_geografia = $cursos->id;
                                    break;

                                case 'HISTORIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $historia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $historia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $historia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $historia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_historia += 1;
                                    }                                           
                                    
                                    $courseid_historia = $cursos->id;
                                    break;

                                case 'INGLES':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $ingles_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $ingles_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $ingles_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_ingles += 1;
                                    }                                           
                                    $courseid_ingles = $cursos->id;
                                    break;                              

                                case 'LECTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $lectura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $lectura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $lectura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_lectura += 1;
                                    }                                           
                                    
                                    $courseid_lectura = $cursos->id;
                                    break;

                                case 'MATEMATICAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $matematicas_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $matematicas_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $matematicas_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_matematicas += 1;
                                    }                                           
                                    $courseid_matematicas = $cursos->id;
                                    break;                         

                                case 'QUIMICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $quimica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $quimica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $quimica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_quimica += 1;
                                    }                                           
                                    
                                    $courseid_quimica = $cursos->id;
                                    break;

                                case 'TECNOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $tic_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $tic_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $tic_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $tic_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_tic += 1;
                                    }                                           
                                                                            
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:                                        
                                    echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADO";
                                    break;
                            }
                        }
                        unset($estudiante->asignaturas);
                        $estudiante->accionciudadana_asistencias = $accionciudadana_asistencias;
                        $estudiante->accionciudadana_seguimientos = $accionciudadana_seguimientos;
                        $estudiante->accionciudadana_autoevaluacion = $accionciudadana_autoevaluacion;
                        $estudiante->accionciudadana_totalcurso = $accionciudadana_totalcurso;
                        $estudiante->accionciudadana_item_huerfano = $item_huerfano_accion_ciudadana;
                        $estudiante->courseid_accion_ciudadana = $courseid_accion_ciudadana;

                        $estudiante->artes_asistencias = $artes_asistencias;
                        $estudiante->artes_seguimientos = $artes_seguimientos;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_totalcurso = $artes_totalcurso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->courseid_artes = $courseid_artes;

                        $estudiante->biologia_asistencias = $biologia_asistencias;
                        $estudiante->biologia_seguimientos = $biologia_seguimientos;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_totalcurso = $biologia_totalcurso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->courseid_biologia = $courseid_biologia;

                        $estudiante->cultura_asistencias = $cultura_asistencias;
                        $estudiante->cultura_seguimientos = $cultura_seguimientos;
                        $estudiante->cultura_autoevaluacion = $cultura_autoevaluacion;
                        $estudiante->cultura_totalcurso = $cultura_totalcurso;
                        $estudiante->cultura_item_huerfano = $item_huerfano_cultura;
                        $estudiante->courseid_cultura = $courseid_cultura;

                        $estudiante->deporte_asistencias = $deporte_asistencias;
                        $estudiante->deporte_seguimientos = $deporte_seguimientos;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_totalcurso = $deporte_totalcurso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->courseid_deporte = $courseid_deporte;

                        $estudiante->dialogo_asistencias = $dialogo_asistencias;
                        $estudiante->dialogo_seguimientos = $dialogo_seguimientos;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_totalcurso = $dialogo_totalcurso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->courseid_dialogo = $courseid_dialogo;

                        $estudiante->filosofia_asistencias = $filosofia_asistencias;
                        $estudiante->filosofia_seguimientos = $filosofia_seguimientos;
                        $estudiante->filosofia_autoevaluacion = $filosofia_autoevaluacion;
                        $estudiante->filosofia_totalcurso = $filosofia_totalcurso;
                        $estudiante->filosofia_item_huerfano = $item_huerfano_filosofia;
                        $estudiante->courseid_filosofia = $courseid_filosofia;

                        $estudiante->fisica_asistencias = $fisica_asistencias;
                        $estudiante->fisica_seguimientos = $fisica_seguimientos;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_totalcurso = $fisica_totalcurso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->courseid_fisica = $courseid_fisica;

                        $estudiante->geografia_asistencias = $geografia_asistencias;
                        $estudiante->geografia_seguimientos = $geografia_seguimientos;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_totalcurso = $geografia_totalcurso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->courseid_geografia = $courseid_geografia;

                        $estudiante->historia_asistencias = $historia_asistencias;
                        $estudiante->historia_seguimientos = $historia_seguimientos;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_totalcurso = $historia_totalcurso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->courseid_historia = $courseid_historia;

                        $estudiante->ingles_asistencias = $ingles_asistencias;
                        $estudiante->ingles_seguimientos = $ingles_seguimientos;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_totalcurso = $ingles_totalcurso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->courseid_ingles = $courseid_ingles;

                        $estudiante->lectura_asistencias = $lectura_asistencias;
                        $estudiante->lectura_seguimientos = $lectura_seguimientos;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_totalcurso = $lectura_totalcurso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->courseid_lectura = $courseid_lectura;

                        $estudiante->matematicas_asistencias = $matematicas_asistencias;
                        $estudiante->matematicas_seguimientos = $matematicas_seguimientos;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_totalcurso = $matematicas_totalcurso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->courseid_matematicas = $courseid_matematicas;

                        $estudiante->quimica_asistencias = $quimica_asistencias;
                        $estudiante->quimica_seguimientos = $quimica_seguimientos;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_totalcurso = $quimica_totalcurso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->courseid_quimica = $courseid_quimica;

                        $estudiante->tic_asistencias = $tic_asistencias;
                        $estudiante->tic_seguimientos = $tic_seguimientos;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_totalcurso = $tic_totalcurso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->courseid_tic = $courseid_tic;
                        //dd($estudiante);
                    });
                return datatables()->of($estudiantes)->toJson();
        }           
    }

    public function notas_linea2(){
        if(Storage::disk('local')->exists('notas_linea_2.json')) {
                    $notas = json_decode(Storage::get('notas_linea_2.json'));
                    $estudiantes = collect($notas);
                    //dd($estudiantes);
                    $estudiantes->map(function($estudiante){
                        $biologia_asistencia = 0;
                        $biologia_seguimiento_academico = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_total_curso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;
                        $artes_asistencia = 0;
                        $artes_seguimiento_academico = 0;
                        $artes_autoevaluacion = 0;
                        $artes_total_curso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $deporte_asistencia = 0;
                        $deporte_seguimiento_academico = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_total_curso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $dialogo_asistencia = 0;
                        $dialogo_seguimiento_academico = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_total_curso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $constitucion_asistencia = 0;
                        $constitucion_seguimiento_academico = 0;
                        $constitucion_autoevaluacion = 0;
                        $constitucion_total_curso = 0;
                        $item_huerfano_constitucion = 0;
                        $courseid_constitucion = 0;
                        $fisica_asistencia = 0;
                        $fisica_seguimiento_academico = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_total_curso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $geografia_asistencia = 0;
                        $geografia_seguimiento_academico = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_total_curso = 0;
                        $item_huerfano_grografia = 0;
                        $courseid_geografia = 0;
                        $historia_asistencia = 0;
                        $historia_seguimiento_academico = 0;
                        $historia_autoevaluacion = 0;
                        $historia_total_curso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $ingles_asistencia = 0;
                        $ingles_seguimiento_academico = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_total_curso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $lectura_asistencia = 0;
                        $lectura_seguimiento_academico = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_total_curso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $matematicas_asistencia = 0;
                        $matematicas_seguimiento_academico = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_total_curso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $quimica_asistencia = 0;
                        $quimica_seguimiento_academico = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_total_curso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $tic_asistencia = 0;
                        $tic_seguimiento_academico = 0;
                        $tic_autoevaluacion = 0;
                        $tic_total_curso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode('-',$cursos->fullname)[0];
                            //dd($cursos->fullname);
                            switch ($cursos->fullname) {
                                case 'BIOLOGIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $biologia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $biologia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $biologia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_biologia += 1;
                                    }
                                    $courseid_biologia = $cursos->id;                                               
                                    break;
                                
                                case 'ARTES: CONOCIMIENTO EN ACCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $artes_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $artes_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $artes_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $artes_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_artes += 1;
                                    }
                                    $courseid_artes = $cursos->id;
                                    break;
                                case 'DEPORTE Y SALUD INTEGRAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $deporte_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $deporte_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $deporte_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_deporte += 1;
                                    }
                                    $courseid_deporte = $cursos->id;
                                    break;
                                case 'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $dialogo_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $dialogo_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $dialogo_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_dialogo += 1;
                                    }
                                    $courseid_dialogo = $cursos->id;
                                    break;
                                case 'CONSTITUCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $constitucion_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $constitucion_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $constitucion_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $constitucion_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_constitucion += 1;
                                    }
                                    $courseid_constitucion = $cursos->id;
                                    break;    
                                case 'FISICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $fisica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $fisica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $fisica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_fisica += 1;
                                    }
                                    $courseid_fisica = $cursos->id;
                                    break;
                                case 'GEOGRAFIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $geografia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $geografia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $geografia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_grografia += 1;
                                    }
                                    $courseid_geografia = $cursos->id;
                                    break;
                                case 'HISTORIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $historia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $historia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $historia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $historia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_historia += 1;
                                    }
                                    $courseid_historia = $cursos->id;
                                    break;
                                case 'INGLES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $ingles_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $ingles_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $ingles_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_ingles += 1;
                                    }
                                    $courseid_ingles = $cursos->id;
                                    break;
                                case 'LECTURA CRITICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $lectura_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $lectura_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $lectura_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_lectura += 1;
                                    }
                                    $courseid_lectura = $cursos->id;
                                    break;
                                case 'MATEMATICAS ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $matematicas_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $matematicas_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $matematicas_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_matematicas += 1;
                                    }
                                    $courseid_matematicas = $cursos->id;
                                    break;
                                case 'QUIMICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $quimica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $quimica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $quimica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_quimica += 1;
                                    }
                                    $courseid_quimica = $cursos->id;
                                    break;
                                case 'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $tic_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $tic_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $tic_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $tic_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_tic += 1;
                                    }
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:
                                    break;
                            }
                        }  
                        //dd($estudiante->asignaturas);
                        $estudiante->biologia_asistencia = $biologia_asistencia;
                        $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_total_curso = $biologia_total_curso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->biologia_course_id = $courseid_biologia;
                        $estudiante->artes_asistencia = $artes_asistencia;
                        $estudiante->artes_seguimiento_academico = $artes_seguimiento_academico;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_total_curso = $artes_total_curso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->artes_course_id = $courseid_artes;
                        $estudiante->deporte_asistencia = $deporte_asistencia;
                        $estudiante->deporte_seguimiento_academico = $deporte_seguimiento_academico;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_total_curso = $deporte_total_curso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->deporte_course_id = $courseid_deporte;
                        $estudiante->dialogo_asistencia = $dialogo_asistencia;
                        $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_total_curso = $dialogo_total_curso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->dialogo_course_id = $courseid_dialogo;
                        $estudiante->constitucion_asistencia = $constitucion_asistencia;
                        $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                        $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                        $estudiante->constitucion_total_curso = $constitucion_total_curso;
                        $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                        $estudiante->constitucion_course_id = $courseid_constitucion;
                        $estudiante->fisica_asistencia = $fisica_asistencia;
                        $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_total_curso = $fisica_total_curso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->fisica_course_id = $courseid_fisica;
                        $estudiante->geografia_asistencia = $geografia_asistencia;
                        $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_total_curso = $geografia_total_curso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_grografia;
                        $estudiante->geografia_course_id = $courseid_geografia;
                        $estudiante->historia_asistencia = $historia_asistencia;
                        $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_total_curso = $historia_total_curso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->historia_course_id = $courseid_historia;
                        $estudiante->ingles_asistencia = $ingles_asistencia;
                        $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_total_curso = $ingles_total_curso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->ingles_course_id = $courseid_ingles;
                        $estudiante->lectura_asistencia = $lectura_asistencia;
                        $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_total_curso = $lectura_total_curso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->lectura_course_id = $courseid_lectura;
                        $estudiante->matematicas_asistencia = $matematicas_asistencia;
                        $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_total_curso = $matematicas_total_curso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->matematicas_course_id = $courseid_matematicas;
                        $estudiante->quimica_asistencia = $quimica_asistencia;
                        $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_total_curso = $quimica_total_curso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->quimica_course_id = $courseid_quimica;
                        $estudiante->tic_asistencia = $tic_asistencia;
                        $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_total_curso = $tic_total_curso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->tic_course_id = $courseid_tic;
                        unset($estudiante->asignaturas);
                        //dd($estudiante);
                    });
                //dd($estudiantes);
                
                return datatables()->of($estudiantes)->toJson();
        }else{

            $estudiantes_linea1 = perfilEstudiante::Estudiantes_cohort_linea2();
            $estudiantes = collect($estudiantes_linea1);
            //dd($estudiantes);

            $estudiantes->map(function($estudiante){
                $estudiante->asignaturas = CourseMoodle::asignaturas($estudiante->grupo, $estudiante->id_moodle);
                //dd($estudiante);   
            });

            $estudiantes_notas = json_encode($estudiantes);
            Storage::disk('local')->put('notas_linea_2.json', $estudiantes_notas);
            $notas = json_decode($estudiantes_notas);

            $estudiantes_notas = collect($notas);

            $estudiantes_notas->map(function($estudiante){
                        $biologia_asistencia = 0;
                        $biologia_seguimiento_academico = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_total_curso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;
                        $artes_asistencia = 0;
                        $artes_seguimiento_academico = 0;
                        $artes_autoevaluacion = 0;
                        $artes_total_curso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $deporte_asistencia = 0;
                        $deporte_seguimiento_academico = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_total_curso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $dialogo_asistencia = 0;
                        $dialogo_seguimiento_academico = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_total_curso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $constitucion_asistencia = 0;
                        $constitucion_seguimiento_academico = 0;
                        $constitucion_autoevaluacion = 0;
                        $constitucion_total_curso = 0;
                        $item_huerfano_constitucion = 0;
                        $courseid_constitucion = 0;
                        $fisica_asistencia = 0;
                        $fisica_seguimiento_academico = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_total_curso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $geografia_asistencia = 0;
                        $geografia_seguimiento_academico = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_total_curso = 0;
                        $item_huerfano_grografia = 0;
                        $courseid_geografia = 0;
                        $historia_asistencia = 0;
                        $historia_seguimiento_academico = 0;
                        $historia_autoevaluacion = 0;
                        $historia_total_curso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $ingles_asistencia = 0;
                        $ingles_seguimiento_academico = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_total_curso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $lectura_asistencia = 0;
                        $lectura_seguimiento_academico = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_total_curso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $matematicas_asistencia = 0;
                        $matematicas_seguimiento_academico = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_total_curso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $quimica_asistencia = 0;
                        $quimica_seguimiento_academico = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_total_curso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $tic_asistencia = 0;
                        $tic_seguimiento_academico = 0;
                        $tic_autoevaluacion = 0;
                        $tic_total_curso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode('-',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'BIOLOGIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $biologia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $biologia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $biologia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_biologia += 1;
                                    }
                                    $courseid_biologia = $cursos->id;                                               
                                    break;
                                
                                case 'ARTES: CONOCIMIENTO EN ACCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $artes_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $artes_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $artes_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $artes_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_artes += 1;
                                    }
                                    $courseid_artes = $cursos->id;
                                    break;
                                case 'DEPORTE Y SALUD INTEGRAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $deporte_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $deporte_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $deporte_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_deporte += 1;
                                    }
                                    $courseid_deporte = $cursos->id;
                                    break;
                                case 'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $dialogo_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $dialogo_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $dialogo_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_dialogo += 1;
                                    }
                                    $courseid_dialogo = $cursos->id;
                                    break;
                                case 'CONSTITUCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $constitucion_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $constitucion_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $constitucion_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $constitucion_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_constitucion += 1;
                                    }
                                    $courseid_constitucion = $cursos->id;
                                    break;    
                                case 'FISICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $fisica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $fisica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $fisica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_fisica += 1;
                                    }
                                    $courseid_fisica = $cursos->id;
                                    break;
                                case 'GEOGRAFIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $geografia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $geografia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $geografia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_grografia += 1;
                                    }
                                    $courseid_grografia = $cursos->id;
                                    break;
                                case 'HISTORIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $historia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $historia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $historia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $historia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_historia += 1;
                                    }
                                    $courseid_historia = $cursos->id;
                                    break;
                                case 'INGLES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $ingles_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $ingles_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $ingles_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_ingles += 1;
                                    }
                                    $courseid_ingles = $cursos->id;
                                    break;
                                case 'LECTURA CRITICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $lectura_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $lectura_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $lectura_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_lectura += 1;
                                    }
                                    $courseid_lectura = $cursos->id;
                                    break;
                                case 'MATEMATICAS ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $matematicas_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $matematicas_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $matematicas_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_matematicas += 1;
                                    }
                                    $courseid_matematicas = $cursos->id;
                                    break;
                                case 'QUIMICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $quimica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $quimica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $quimica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_quimica += 1;
                                    }
                                    $courseid_quimica = $cursos->id;
                                    break;
                                case 'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $tic_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $tic_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $tic_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $tic_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_tic += 1;
                                    }
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:
                                    break;
                            }
                        }  
                        //dd($estudiante->asignaturas);
                        $estudiante->biologia_asistencia = $biologia_asistencia;
                        $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_total_curso = $biologia_total_curso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->biologia_course_id = $courseid_biologia;
                        $estudiante->artes_asistencia = $artes_asistencia;
                        $estudiante->artes_seguimiento_academico = $artes_seguimiento_academico;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_total_curso = $artes_total_curso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->artes_course_id = $courseid_artes;
                        $estudiante->deporte_asistencia = $deporte_asistencia;
                        $estudiante->deporte_seguimiento_academico = $deporte_seguimiento_academico;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_total_curso = $deporte_total_curso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->deporte_course_id = $courseid_deporte;
                        $estudiante->dialogo_asistencia = $dialogo_asistencia;
                        $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_total_curso = $dialogo_total_curso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->dialogo_course_id = $courseid_dialogo;
                        $estudiante->constitucion_asistencia = $constitucion_asistencia;
                        $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                        $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                        $estudiante->constitucion_total_curso = $constitucion_total_curso;
                        $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                        $estudiante->constitucion_course_id = $courseid_constitucion;
                        $estudiante->fisica_asistencia = $fisica_asistencia;
                        $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_total_curso = $fisica_total_curso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->fisica_course_id = $courseid_fisica;
                        $estudiante->geografia_asistencia = $geografia_asistencia;
                        $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_total_curso = $geografia_total_curso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->geografia_course_id = $courseid_geografia;
                        $estudiante->historia_asistencia = $historia_asistencia;
                        $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_total_curso = $historia_total_curso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->historia_course_id = $courseid_historia;
                        $estudiante->ingles_asistencia = $ingles_asistencia;
                        $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_total_curso = $ingles_total_curso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->ingles_course_id = $courseid_ingles;
                        $estudiante->lectura_asistencia = $lectura_asistencia;
                        $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_total_curso = $lectura_total_curso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->lectura_course_id = $courseid_lectura;
                        $estudiante->matematicas_asistencia = $matematicas_asistencia;
                        $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_total_curso = $matematicas_total_curso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->matematicas_course_id = $courseid_matematicas;
                        $estudiante->quimica_asistencia = $quimica_asistencia;
                        $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_total_curso = $quimica_total_curso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->quimica_course_id = $courseid_quimica;
                        $estudiante->tic_asistencia = $tic_asistencia;
                        $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_total_curso = $tic_total_curso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->tic_course_id = $courseid_tic;
                        unset($estudiante->asignaturas);
                        //dd($estudiante);
                    });
                return datatables()->of($estudiantes_notas)->toJson();
        }           
    }

    public function notas_linea3(){
        if(Storage::disk('local')->exists('notas_linea_3.json')) {
            $notas = json_decode(Storage::get('notas_linea_3.json'));
            $estudiantes = collect($notas);
            //dd($estudiantes);      
            $estudiantes->map(function($estudiante){
                $biologia_asistencia = 0;
                $biologia_seguimiento_academico = 0;
                $biologia_autoevaluacion = 0;
                $biologia_total_curso = 0;
                $item_huerfano_biologia = 0;
                $courseid_biologia = 0;

                $constitucion_asistencia = 0;
                $constitucion_seguimiento_academico = 0;
                $constitucion_autoevaluacion = 0;
                $constitucion_total_curso = 0;
                $item_huerfano_constitucion = 0;
                $courseid_constitucion = 0;

                $fisica_asistencia = 0;
                $fisica_seguimiento_academico = 0;
                $fisica_autoevaluacion = 0;
                $fisica_total_curso = 0;
                $item_huerfano_fisica = 0;
                $courseid_fisica = 0;

                $geografia_asistencia = 0;
                $geografia_seguimiento_academico = 0;
                $geografia_autoevaluacion = 0;
                $geografia_total_curso = 0;
                $item_huerfano_geografia = 0;
                $courseid_geografia = 0;
                
                $historia_asistencia = 0;
                $historia_seguimiento_academico = 0;
                $historia_autoevaluacion = 0;
                $historia_total_curso = 0;
                $item_huerfano_historia = 0;
                $courseid_historia = 0;

                $ingles_asistencia = 0;
                $ingles_seguimiento_academico = 0;
                $ingles_autoevaluacion = 0;
                $ingles_total_curso = 0;
                $item_huerfano_ingles = 0;
                $courseid_ingles = 0;

                $lectura_asistencia = 0;
                $lectura_seguimiento_academico = 0;
                $lectura_autoevaluacion = 0;
                $lectura_total_curso = 0;
                $item_huerfano_lectura = 0;
                $courseid_lectura = 0;

                $matematicas_asistencia = 0;
                $matematicas_seguimiento_academico = 0;
                $matematicas_autoevaluacion = 0;
                $matematicas_total_curso = 0;
                $item_huerfano_matematicas = 0;
                $courseid_matematicas = 0;

                $quimica_asistencia = 0;
                $quimica_seguimiento_academico = 0;
                $quimica_autoevaluacion = 0;
                $quimica_total_curso = 0;
                $item_huerfano_quimica = 0;
                $courseid_quimica = 0;

                foreach((array)$estudiante->asignaturas as $cursos){
                    $cursos->fullname = explode('-',$cursos->fullname)[0];
                    //dd($cursos);
                    switch ($cursos->fullname) {
                        case 'BIOLOGIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $biologia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $biologia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $biologia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_biologia += 1;
                            }
                            $courseid_biologia = $cursos->id;                                           
                        break;
                        case 'CONSTITUCION ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $constitucion_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $constitucion_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $constitucion_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $constitucion_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_constitucion += 1;
                            }
                            $courseid_constitucion = $cursos->id;
                        break;    
                        case 'FISICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $fisica_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $fisica_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $fisica_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $fisica_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_fisica += 1;
                            }
                            $courseid_fisica = $cursos->id;
                        break;
                        case 'GEOGRAFIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $geografia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $geografia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $geografia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $geografia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_geografia += 1;
                            }
                            $courseid_geografia = $cursos->id;
                        break;
                        case 'HISTORIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $historia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $historia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $historia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $historia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_historia += 1;
                            }
                            $courseid_historia = $cursos->id;
                        break;
                        case 'INGLES ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $ingles_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $ingles_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $ingles_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $ingles_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_ingles += 1;
                            }
                            $courseid_ingles = $cursos->id;
                        break;
                        case 'LECTURA CRITICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $lectura_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $lectura_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $lectura_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $lectura_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_lectura += 1;
                            }
                            $courseid_lectura = $cursos->id;
                            break;
                            case 'MATEMATICAS ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $matematicas_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $matematicas_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $matematicas_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $matematicas_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_matematicas += 1;
                                }
                                $courseid_matematicas = $cursos->id;
                            break;
                            case 'QUIMICA ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $quimica_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $quimica_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $quimica_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $quimica_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_quimica += 1;
                                }
                                $courseid_quimica = $cursos->id;
                                break;    
                        default:
                            break;
                    }
                }
                //dd($courseid);
                
                $estudiante->biologia_asistencia = $biologia_asistencia;
                $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                $estudiante->biologia_total_curso = $biologia_total_curso;
                $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                $estudiante->biologia_course_id = $courseid_biologia;
                $estudiante->constitucion_asistencia = $constitucion_asistencia;
                $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                $estudiante->constitucion_total_curso = $constitucion_total_curso;
                $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                $estudiante->constitucion_course_id = $courseid_constitucion;
                $estudiante->fisica_asistencia = $fisica_asistencia;
                $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                $estudiante->fisica_total_curso = $fisica_total_curso;
                $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                $estudiante->fisica_course_id = $courseid_fisica;
                $estudiante->geografia_asistencia = $geografia_asistencia;
                $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                $estudiante->geografia_total_curso = $geografia_total_curso;
                $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                $estudiante->geografia_course_id = $courseid_geografia;
                $estudiante->historia_asistencia = $historia_asistencia;
                $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                $estudiante->historia_total_curso = $historia_total_curso;
                $estudiante->historia_item_huerfano = $item_huerfano_historia;
                $estudiante->historia_course_id = $courseid_historia;
                $estudiante->ingles_asistencia = $ingles_asistencia;
                $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                $estudiante->ingles_total_curso = $ingles_total_curso;
                $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                $estudiante->ingles_course_id = $courseid_ingles;
                $estudiante->lectura_asistencia = $lectura_asistencia;
                $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                $estudiante->lectura_total_curso = $lectura_total_curso;
                $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                $estudiante->lectura_course_id = $courseid_lectura;
                $estudiante->matematicas_asistencia = $matematicas_asistencia;
                $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                $estudiante->matematicas_total_curso = $matematicas_total_curso;
                $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                $estudiante->matematicas_course_id = $courseid_matematicas;
                $estudiante->quimica_asistencia = $quimica_asistencia;
                $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                $estudiante->quimica_total_curso = $quimica_total_curso;
                $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                $estudiante->quimica_course_id = $courseid_quimica;
                unset($estudiante->asignaturas);
                //dd($estudiante);
            });

            //dd($estudiantes);
            
            return datatables()->of($estudiantes)->toJson();
        }else{
            $estudiantes_linea3 = perfilEstudiante::Estudiantes_cohort_linea3();
            $estudiantes = collect($estudiantes_linea3);
            //dd($estudiantes);

            $estudiantes->map(function($estudiante){
                $estudiante->asignaturas = CourseMoodle::asignaturas($estudiante->grupo, $estudiante->id_moodle);
                //dd($estudiante);   
            });

            $estudiantes_notas = json_encode($estudiantes);
            Storage::disk('local')->put('notas_linea_3.json', $estudiantes_notas);
            $notas = json_decode($estudiantes_notas);

            $estudiantes_notas_linea3 = collect($notas);

            $estudiantes_notas_linea3->map(function($estudiante){
                $biologia_asistencia = 0;
                $biologia_seguimiento_academico = 0;
                $biologia_autoevaluacion = 0;
                $biologia_total_curso = 0;
                $item_huerfano_biologia = 0;

                $constitucion_asistencia = 0;
                $constitucion_seguimiento_academico = 0;
                $constitucion_autoevaluacion = 0;
                $constitucion_total_curso = 0;
                $item_huerfano_constitucion = 0;

                $fisica_asistencia = 0;
                $fisica_seguimiento_academico = 0;
                $fisica_autoevaluacion = 0;
                $fisica_total_curso = 0;
                $item_huerfano_fisica = 0;

                $geografia_asistencia = 0;
                $geografia_seguimiento_academico = 0;
                $geografia_autoevaluacion = 0;
                $geografia_total_curso = 0;
                $item_huerfano_geografia = 0;
                
                $historia_asistencia = 0;
                $historia_seguimiento_academico = 0;
                $historia_autoevaluacion = 0;
                $historia_total_curso = 0;
                $item_huerfano_historia = 0;

                $ingles_asistencia = 0;
                $ingles_seguimiento_academico = 0;
                $ingles_autoevaluacion = 0;
                $ingles_total_curso = 0;
                $item_huerfano_ingles = 0;

                $lectura_asistencia = 0;
                $lectura_seguimiento_academico = 0;
                $lectura_autoevaluacion = 0;
                $lectura_total_curso = 0;
                $item_huerfano_lectura = 0;

                $matematicas_asistencia = 0;
                $matematicas_seguimiento_academico = 0;
                $matematicas_autoevaluacion = 0;
                $matematicas_total_curso = 0;
                $item_huerfano_matematicas = 0;

                $quimica_asistencia = 0;
                $quimica_seguimiento_academico = 0;
                $quimica_autoevaluacion = 0;
                $quimica_total_curso = 0;
                $item_huerfano_quimica = 0;

                foreach((array)$estudiante->asignaturas as $cursos){
                    $cursos->fullname = explode('-',$cursos->fullname)[0];
                    dd($cursos);
                    switch ($cursos->fullname) {
                        case 'BIOLOGIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $biologia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $biologia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $biologia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_biologia += 1;
                            }                                               
                        break;
                        case 'CONSTITUCION ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $constitucion_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $constitucion_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $constitucion_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $constitucion_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_constitucion += 1;
                            }
                        break;    
                        case 'FISICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $fisica_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $fisica_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $fisica_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $fisica_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_fisica += 1;
                            }
                        break;
                        case 'GEOGRAFIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $geografia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $geografia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $geografia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $geografia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_geografia += 1;
                            }
                        break;
                        case 'HISTORIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $historia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $historia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $historia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $historia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_historia += 1;
                            }
                        break;
                        case 'INGLES ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $ingles_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $ingles_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $ingles_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $ingles_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_ingles += 1;
                            }
                        break;
                        case 'LECTURA CRITICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $lectura_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $lectura_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $lectura_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $lectura_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_lectura += 1;
                            }
                            break;
                            case 'MATEMATICAS ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $matematicas_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $matematicas_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $matematicas_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $matematicas_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_matematicas += 1;
                                }
                            break;
                            case 'QUIMICA ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $quimica_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $quimica_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $quimica_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $quimica_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_quimica += 1;
                                }
                                break;    
                        default:
                            break;
                    }
                }
                $estudiante->biologia_asistencia = $biologia_asistencia;
                $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                $estudiante->biologia_total_curso = $biologia_total_curso;
                $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                $estudiante->biologia_course_id = $estudiante->cursos->course_id;
                $estudiante->constitucion_asistencia = $constitucion_asistencia;
                $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                $estudiante->constitucion_total_curso = $constitucion_total_curso;
                $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                $estudiante->constitucion_course_id = $estudiante->cursos->course_id;
                $estudiante->fisica_asistencia = $fisica_asistencia;
                $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                $estudiante->fisica_total_curso = $fisica_total_curso;
                $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                $estudiante->fisica_course_id = $estudiante->cursos->course_id;
                $estudiante->geografia_asistencia = $geografia_asistencia;
                $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                $estudiante->geografia_total_curso = $geografia_total_curso;
                $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                $estudiante->geografia_course_id = $estudiante->cursos->course_id;
                $estudiante->historia_asistencia = $historia_asistencia;
                $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                $estudiante->historia_total_curso = $historia_total_curso;
                $estudiante->historia_item_huerfano = $item_huerfano_historia;
                $estudiante->historia_course_id = $estudiante->cursos->course_id;
                $estudiante->ingles_asistencia = $ingles_asistencia;
                $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                $estudiante->ingles_total_curso = $ingles_total_curso;
                $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                $estudiante->ingles_course_id = $estudiante->cursos->course_id;
                $estudiante->lectura_asistencia = $lectura_asistencia;
                $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                $estudiante->lectura_total_curso = $lectura_total_curso;
                $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                $estudiante->lectura_course_id = $estudiante->cursos->course_id;
                $estudiante->matematicas_asistencia = $matematicas_asistencia;
                $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                $estudiante->matematicas_total_curso = $matematicas_total_curso;
                $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                $estudiante->matematicas_course_id = $estudiante->cursos->course_id;
                $estudiante->quimica_asistencia = $quimica_asistencia;
                $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                $estudiante->quimica_total_curso = $quimica_total_curso;
                $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                $estudiante->quimica_course_id = $estudiante->cursos->course_id;
                unset($estudiante->asignaturas);
                //dd($estudiante);
            });
            //dd($estudiantes);
            
            return datatables()->of($$estudiantes_notas_linea3)->toJson();
        }
    }

    public function datos_items_huerfanos_linea3(Request $request){
        if($request['course_id'] != 0){
            $course_id = CourseMoodle::select('course_id')->where('id', $request['course_id'])->first();
            $item_huerfano_estudiante = CourseItems::select('item_id', 'item_name')->where('category_name','ITEM HUERFANO')->where('course_id', $course_id->course_id)->get();
            //dd($item_huerfano_estudiante);
            $this->id_moodle = $request->id_moodle;
            $item_huerfano_estudiante->map(function($item){
                $grade = StudentsGrade::select('grade')->where('item_id', $item->item_id)->where('id_moodle', $this->id_moodle)->first();
                 $item->grade = $grade ? $grade->grade : null;
            });
            //dd($item_huerfano_estudiante);
            return datatables()->of($item_huerfano_estudiante)->toJson();
        } 
    }

    public function items_categorias(Request $request){
        //dd($request->course_id);
        $course_id = CourseMoodle::select('course_id')->where('id', $request['course_id'])->first();
        //dd($course_id);
        switch($request->tipo){
            case '1':
                $items_estudiante = CourseItems::select('item_id','item_name')->where('course_id',$course_id->course_id)->where('item_type','!=',"category")->where('category_name','like','ASISTENCIA%')->get();
            break;
            case '2':
                $items_estudiante = CourseItems::select('item_id','item_name')->where('course_id',$course_id->course_id)->where('item_type','!=',"category")->where(function($q){
                    $q->where('category_name', 'like', 'seguimiento%')->Orwhere('category_name','like','componente%')->Orwhere('category_name','like','actividades%')->Orwhere('category_name','like','parciales%')->Orwhere('category_name','like','seminario%');
                })->get();
            break;
            case '3':
                $items_estudiante  = CourseItems::select('item_id','item_name')->where('course_id',$course_id->course_id)->where('item_type','!=',"category")->where('category_name','like','auto%')->get();
            break;
            default:
                echo "ERROR, CONSULTAR CON EL ADMINISTRADOR";
            break;
        }
        $this->id_moodle = $request->id_moodle;
        $items_estudiante->map(function($item){
            $grade = StudentsGrade::select('grade')->where('item_id',$item->item_id)->where('id_moodle',$this->id_moodle)->first();
                    //dd($grade);
            $item->grade = $grade ? $grade->grade : "-";
        });
        //dd($items_estudiante);
        return datatables()->of($items_estudiante)->toJson();
    }

    public function exportar_excel_notas_linea1(){

        if(Storage::disk('local')->exists('notas_linea_1.json')) {
                    $asistencias    = json_decode(Storage::get('notas_linea_1.json'));
                    //dd($asistencias);
                    $estudiantes = collect($asistencias);
                    
                    $estudiantes->map(function($estudiante){

                        $accionciudadana_asistencias = 0;
                        $accionciudadana_seguimientos = 0;
                        $accionciudadana_autoevaluacion = 0;
                        $accionciudadana_totalcurso = 0;
                        $item_huerfano_accion_ciudadana = 0;
                        $courseid_accion_ciudadana = 0;

                        $artes_asistencias = 0;
                        $artes_seguimientos = 0;
                        $artes_autoevaluacion = 0;
                        $artes_totalcurso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;

                        $biologia_asistencias = 0;
                        $biologia_seguimientos = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_totalcurso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;

                        $cultura_asistencias = 0;
                        $cultura_seguimientos = 0;
                        $cultura_autoevaluacion = 0;
                        $cultura_totalcurso = 0;
                        $item_huerfano_cultura = 0;
                        $courseid_cultura = 0;

                        $deporte_asistencias = 0;
                        $deporte_seguimientos = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_totalcurso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;

                        $dialogo_asistencias = 0;
                        $dialogo_seguimientos = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_totalcurso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;

                        $filosofia_asistencias = 0;
                        $filosofia_seguimientos = 0;
                        $filosofia_autoevaluacion = 0;
                        $filosofia_totalcurso = 0;
                        $item_huerfano_filosofia = 0;
                        $courseid_filosofia = 0;

                        $fisica_asistencias = 0;
                        $fisica_seguimientos = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_totalcurso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;

                        $geografia_asistencias = 0;
                        $geografia_seguimientos = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_totalcurso = 0;
                        $item_huerfano_geografia = 0;
                        $courseid_geografia = 0;

                        $historia_asistencias = 0;
                        $historia_seguimientos = 0;
                        $historia_autoevaluacion = 0;
                        $historia_totalcurso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;

                        $ingles_asistencias = 0;
                        $ingles_seguimientos = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_totalcurso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;

                        $lectura_asistencias = 0;
                        $lectura_seguimientos = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_totalcurso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;

                        $matematicas_asistencias = 0;
                        $matematicas_seguimientos = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_totalcurso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;

                        $quimica_asistencias = 0;
                        $quimica_seguimientos = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_totalcurso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;

                        $tic_asistencias = 0;
                        $tic_seguimientos = 0;
                        $tic_autoevaluacion = 0;
                        $tic_totalcurso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;

                        //dd($estudiante->asignaturas);
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode(' ',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'JORNADAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $accionciudadana_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $accionciudadana_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $accionciudadana_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $accionciudadana_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_accion_ciudadana += 1;
                                    }                                           
                                    
                                    $courseid_accion_ciudadana = $cursos->id;
                                    break;

                                case 'ARTES:':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $artes_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $artes_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $artes_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $artes_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_artes +=1;
                                    }                                           
                                    
                                    $courseid_artes = $cursos->id;
                                    break;

                                case 'BIOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $biologia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $biologia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $biologia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_biologia += 1;
                                    }                                           
                                    
                                    $courseid_biologia = $cursos->id;
                                    break;

                                case 'CULTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $cultura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $cultura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $cultura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $cultura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_cultura += 1;
                                    }                                           
                                    
                                    $courseid_cultura = $cursos->id;
                                    break;

                                case 'DEPORTE':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $deporte_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $deporte_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $deporte_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_deporte += 1;
                                    }                                           
                                    
                                    $courseid_deporte = $cursos->id;
                                    break;

                                case 'DIALOGO':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $dialogo_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $dialogo_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $dialogo_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_dialogo += 1;
                                    }                                           
                                    
                                    $courseid_dialogo = $cursos->id;
                                    break;

                                case 'FILOSOFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $filosofia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $filosofia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $filosofia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $filosofia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_filosofia += 1;
                                    }                                           
                                    
                                    $courseid_filosofia = $cursos->id;
                                    break;

                                case 'FISICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $fisica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $fisica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $fisica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_fisica += 1;
                                    }                                           
                                    
                                    $courseid_fisica = $cursos->id;
                                    break;

                                case 'GEOGRAFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $geografia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $geografia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $geografia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_geografia += 1;
                                    }                                           
                                    
                                    $courseid_geografia = $cursos->id;
                                    break;

                                case 'HISTORIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $historia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $historia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $historia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $historia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_historia += 1;
                                    }                                           
                                    
                                    $courseid_historia = $cursos->id;
                                    break;

                                case 'INGLES':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $ingles_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $ingles_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $ingles_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_ingles += 1;
                                    }                                           
                                    $courseid_ingles = $cursos->id;
                                    break;                               
                                case 'LECTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $lectura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $lectura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $lectura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_lectura +=1 ;
                                    }                                           
                                    
                                    $courseid_lectura = $cursos->id;
                                    break;

                                case 'MATEMATICAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $matematicas_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $matematicas_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $matematicas_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_matematicas += 1;
                                    }                                           
                                    $courseid_matematicas = $cursos->id;
                                    break;                          

                                case 'QUIMICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $quimica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $quimica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $quimica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_quimica += 1;
                                    }                                           
                                    
                                    $courseid_quimica = $cursos->id;
                                    break;

                                case 'TECNOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $tic_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $tic_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $tic_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $tic_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_tic += 1;
                                    }                                           
                                                                            
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:                                        
                                    echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADO";
                                    break;
                            }
                        }
                        unset($estudiante->asignaturas);
                        $estudiante->accionciudadana_asistencias = $accionciudadana_asistencias;
                        $estudiante->accionciudadana_seguimientos = $accionciudadana_seguimientos;
                        $estudiante->accionciudadana_autoevaluacion = $accionciudadana_autoevaluacion;
                        $estudiante->accionciudadana_totalcurso = $accionciudadana_totalcurso;
                        $estudiante->accionciudadana_item_huerfano = $item_huerfano_accion_ciudadana;
                        $estudiante->courseid_accion_ciudadana = $courseid_accion_ciudadana;

                        $estudiante->artes_asistencias = $artes_asistencias;
                        $estudiante->artes_seguimientos = $artes_seguimientos;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_totalcurso = $artes_totalcurso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->courseid_artes = $courseid_artes;

                        $estudiante->biologia_asistencias = $biologia_asistencias;
                        $estudiante->biologia_seguimientos = $biologia_seguimientos;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_totalcurso = $biologia_totalcurso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->courseid_biologia = $courseid_biologia;

                        $estudiante->cultura_asistencias = $cultura_asistencias;
                        $estudiante->cultura_seguimientos = $cultura_seguimientos;
                        $estudiante->cultura_autoevaluacion = $cultura_autoevaluacion;
                        $estudiante->cultura_totalcurso = $cultura_totalcurso;
                        $estudiante->cultura_item_huerfano = $item_huerfano_cultura;
                        $estudiante->courseid_cultura = $courseid_cultura;

                        $estudiante->deporte_asistencias = $deporte_asistencias;
                        $estudiante->deporte_seguimientos = $deporte_seguimientos;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_totalcurso = $deporte_totalcurso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->courseid_deporte = $courseid_deporte;

                        $estudiante->dialogo_asistencias = $dialogo_asistencias;
                        $estudiante->dialogo_seguimientos = $dialogo_seguimientos;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_totalcurso = $dialogo_totalcurso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->courseid_dialogo = $courseid_dialogo;

                        $estudiante->filosofia_asistencias = $filosofia_asistencias;
                        $estudiante->filosofia_seguimientos = $filosofia_seguimientos;
                        $estudiante->filosofia_autoevaluacion = $filosofia_autoevaluacion;
                        $estudiante->filosofia_totalcurso = $filosofia_totalcurso;
                        $estudiante->filosofia_item_huerfano = $item_huerfano_filosofia;
                        $estudiante->courseid_filosofia = $courseid_filosofia;

                        $estudiante->fisica_asistencias = $fisica_asistencias;
                        $estudiante->fisica_seguimientos = $fisica_seguimientos;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_totalcurso = $fisica_totalcurso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->courseid_fisica = $courseid_fisica;

                        $estudiante->geografia_asistencias = $geografia_asistencias;
                        $estudiante->geografia_seguimientos = $geografia_seguimientos;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_totalcurso = $geografia_totalcurso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->courseid_geografia = $courseid_geografia;

                        $estudiante->historia_asistencias = $historia_asistencias;
                        $estudiante->historia_seguimientos = $historia_seguimientos;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_totalcurso = $historia_totalcurso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->courseid_historia = $courseid_historia;

                        $estudiante->ingles_asistencias = $ingles_asistencias;
                        $estudiante->ingles_seguimientos = $ingles_seguimientos;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_totalcurso = $ingles_totalcurso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->courseid_ingles = $courseid_ingles;

                        $estudiante->lectura_asistencias = $lectura_asistencias;
                        $estudiante->lectura_seguimientos = $lectura_seguimientos;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_totalcurso = $lectura_totalcurso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->courseid_lectura = $courseid_lectura;

                        $estudiante->matematicas_asistencias = $matematicas_asistencias;
                        $estudiante->matematicas_seguimientos = $matematicas_seguimientos;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_totalcurso = $matematicas_totalcurso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->courseid_matematicas = $courseid_matematicas;

                        $estudiante->quimica_asistencias = $quimica_asistencias;
                        $estudiante->quimica_seguimientos = $quimica_seguimientos;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_totalcurso = $quimica_totalcurso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->courseid_quimica = $courseid_quimica;

                        $estudiante->tic_asistencias = $tic_asistencias;
                        $estudiante->tic_seguimientos = $tic_seguimientos;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_totalcurso = $tic_totalcurso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->courseid_tic = $courseid_tic;
                        //dd($estudiante);
                    });
                $excel = array();
                foreach($estudiantes as $estudiante){
                    $excel[] = array(
                                'id' => $estudiante->id,
                                'name' => $estudiante->name,
                                'lastname' => $estudiante->lastname,
                                'tipo_documento' => $estudiante->tipo_documento,
                                'document_number' => $estudiante->document_number,
                                'grupo' => $estudiante->grupo_name,
                                'estado' => $estudiante->estado,
                                'profersional' => $estudiante->encargado,

                                'accionciudadana_asistencias' => $estudiante->accionciudadana_asistencias,
                                'accionciudadana_seguimientos' => $estudiante->accionciudadana_seguimientos,
                                'accionciudadana_autoevaluacion' => $estudiante->accionciudadana_autoevaluacion,
                                'accionciudadana_totalcurso' => $estudiante->accionciudadana_totalcurso,

                                'artes_asistencias' => $estudiante->artes_asistencias,
                                'artes_seguimientos' => $estudiante->artes_seguimientos,
                                'artes_autoevaluacion' => $estudiante->artes_autoevaluacion,
                                'artes_totalcurso' => $estudiante->artes_totalcurso,

                                'biologia_asistencias' => $estudiante->biologia_asistencias,
                                'biologia_seguimientos' => $estudiante->biologia_seguimientos,
                                'biologia_autoevaluacion' => $estudiante->biologia_autoevaluacion,
                                'biologia_totalcurso' => $estudiante->biologia_totalcurso,

                                'cultura_asistencias' => $estudiante->cultura_asistencias,
                                'cultura_seguimientos' => $estudiante->cultura_seguimientos,
                                'cultura_autoevaluacion' => $estudiante->cultura_autoevaluacion,
                                'cultura_totalcurso' => $estudiante->cultura_totalcurso,
                                
                                'deporte_asistencias' => $estudiante->deporte_asistencias,
                                'deporte_seguimientos' => $estudiante->deporte_seguimientos,
                                'deporte_autoevaluacion' => $estudiante->deporte_autoevaluacion,
                                'deporte_totalcurso' => $estudiante->deporte_totalcurso,

                                'dialogo_asistencias' => $estudiante->dialogo_asistencias,
                                'dialogo_seguimientos' => $estudiante->dialogo_seguimientos,
                                'dialogo_autoevaluacion' => $estudiante->dialogo_autoevaluacion,
                                'dialogo_totalcurso' => $estudiante->dialogo_totalcurso,

                                'filosofia_asistencias' => $estudiante->filosofia_asistencias,
                                'filosofia_seguimientos' => $estudiante->filosofia_seguimientos,
                                'filosofia_autoevaluacion' => $estudiante->filosofia_autoevaluacion,
                                'filosofia_totalcurso' => $estudiante->filosofia_totalcurso,

                                'fisica_asistencias' => $estudiante->fisica_asistencias,
                                'fisica_seguimientos' => $estudiante->fisica_seguimientos,
                                'fisica_autoevaluacion' => $estudiante->fisica_autoevaluacion,
                                'fisica_totalcurso' => $estudiante->fisica_totalcurso,

                                'geografia_asistencias' => $estudiante->geografia_asistencias,
                                'geografia_seguimientos' => $estudiante->geografia_seguimientos,
                                'geografia_autoevaluacion' => $estudiante->geografia_autoevaluacion,
                                'geografia_totalcurso' => $estudiante->geografia_totalcurso,

                                'historia_asistencias' => $estudiante->historia_asistencias,
                                'historia_seguimientos' => $estudiante->historia_seguimientos,
                                'historia_autoevaluacion' => $estudiante->historia_autoevaluacion,
                                'historia_totalcurso' => $estudiante->historia_totalcurso,

                                'ingles_asistencias' => $estudiante->ingles_asistencias,
                                'ingles_seguimientos' => $estudiante->ingles_seguimientos,
                                'ingles_autoevaluacion' => $estudiante->ingles_autoevaluacion,
                                'ingles_totalcurso' => $estudiante->ingles_totalcurso,

                                'lectura_asistencias' => $estudiante->lectura_asistencias,
                                'lectura_seguimientos' => $estudiante->lectura_seguimientos,
                                'lectura_autoevaluacion' => $estudiante->lectura_autoevaluacion,
                                'lectura_totalcurso' => $estudiante->lectura_totalcurso,

                                'matematicas_asistencias' => $estudiante->matematicas_asistencias,
                                'matematicas_seguimientos' => $estudiante->matematicas_seguimientos,
                                'matematicas_autoevaluacion' => $estudiante->matematicas_autoevaluacion,
                                'matematicas_totalcurso' => $estudiante->matematicas_totalcurso,

                                'quimica_asistencias' => $estudiante->quimica_asistencias,
                                'quimica_seguimientos' => $estudiante->quimica_seguimientos,
                                'quimica_autoevaluacion' => $estudiante->quimica_autoevaluacion,
                                'quimica_totalcurso' => $estudiante->quimica_totalcurso,

                                'tic_asistencias' => $estudiante->tic_asistencias,
                                'tic_seguimientos' => $estudiante->tic_seguimientos,
                                'tic_autoevaluacion' => $estudiante->tic_autoevaluacion,
                                'tic_totalcurso' => $estudiante->tic_totalcurso,
                            );
                }
                //dd($excel);
                $exportar = new NotasLinea1Export([$excel]);

                return Excel::download($exportar, "reporte_notas_linea_1.xlsx");
                //return datatables()->of($estudiantes)->toJson();
        }else{

            $estudiantes_linea1 = perfilEstudiante::Estudiantes_cohort_linea1();
            $estudiantes = collect($estudiantes_linea1);
            //dd($estudiantes);
            /*$cursos = explode(',', $estudiantes[0]->asignatura);
            $estudiantes[0]->asignatura = $cursos;*/
            //dd($estudiantes[0]);

            $estudiantes->map(function($estudiante){
                $estudiante->asignaturas = CourseMoodle::asignaturas($estudiante->grupo, $estudiante->id_moodle);
                //dd($estudiante);   
            });

            $estudiantes_notas = json_encode($estudiantes);
            Storage::disk('local')->put('notas_linea_1.json', $estudiantes_notas);
            $notas = json_decode($estudiantes_notas);

            $estudiantes_notas = collect($notas);
                           
            $estudiantes->map(function($estudiante){

                        $accionciudadana_asistencias = 0;
                        $accionciudadana_seguimientos = 0;
                        $accionciudadana_autoevaluacion = 0;
                        $accionciudadana_totalcurso = 0;
                        $item_huerfano_accion_ciudadana = 0;
                        $courseid_accion_ciudadana = 0;

                        $artes_asistencias = 0;
                        $artes_seguimientos = 0;
                        $artes_autoevaluacion = 0;
                        $artes_totalcurso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;

                        $biologia_asistencias = 0;
                        $biologia_seguimientos = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_totalcurso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;

                        $cultura_asistencias = 0;
                        $cultura_seguimientos = 0;
                        $cultura_autoevaluacion = 0;
                        $cultura_totalcurso = 0;
                        $item_huerfano_cultura = 0;
                        $courseid_cultura = 0;

                        $deporte_asistencias = 0;
                        $deporte_seguimientos = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_totalcurso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;

                        $dialogo_asistencias = 0;
                        $dialogo_seguimientos = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_totalcurso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;

                        $filosofia_asistencias = 0;
                        $filosofia_seguimientos = 0;
                        $filosofia_autoevaluacion = 0;
                        $filosofia_totalcurso = 0;
                        $item_huerfano_filosofia = 0;
                        $courseid_filosofia = 0;

                        $fisica_asistencias = 0;
                        $fisica_seguimientos = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_totalcurso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;

                        $geografia_asistencias = 0;
                        $geografia_seguimientos = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_totalcurso = 0;
                        $item_huerfano_geografia = 0;
                        $courseid_geografia = 0;

                        $historia_asistencias = 0;
                        $historia_seguimientos = 0;
                        $historia_autoevaluacion = 0;
                        $historia_totalcurso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;

                        $ingles_asistencias = 0;
                        $ingles_seguimientos = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_totalcurso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;

                        $lectura_asistencias = 0;
                        $lectura_seguimientos = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_totalcurso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;

                        $matematicas_asistencias = 0;
                        $matematicas_seguimientos = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_totalcurso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;

                        $quimica_asistencias = 0;
                        $quimica_seguimientos = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_totalcurso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;

                        $tic_asistencias = 0;
                        $tic_seguimientos = 0;
                        $tic_autoevaluacion = 0;
                        $tic_totalcurso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;

                        //dd($estudiante->asignaturas);
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode(' ',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'JORNADAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $accionciudadana_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $accionciudadana_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $accionciudadana_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $accionciudadana_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_accion_ciudadana += 1;
                                    }                                           
                                    
                                    $courseid_accion_ciudadana = $cursos->id;
                                    break;

                                case 'ARTES:':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $artes_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $artes_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $artes_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $artes_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_artes += 1;
                                    }                                           
                                    
                                    $courseid_artes = $cursos->id;
                                    break;

                                case 'BIOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $biologia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $biologia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $biologia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_biologia += 1;
                                    }                                           
                                    
                                    $courseid_biologia = $cursos->id;
                                    break;

                                case 'CULTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $cultura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $cultura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $cultura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $cultura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_cultura += 1;
                                    }                                           
                                    
                                    $courseid_cultura = $cursos->id;
                                    break;

                                case 'DEPORTE':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $deporte_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $deporte_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $deporte_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_deporte += 1;
                                    }                                           
                                    
                                    $courseid_deporte = $cursos->id;
                                    break;

                                case 'DIALOGO':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $dialogo_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $dialogo_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $dialogo_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_dialogo += 1;
                                    }                                           
                                    
                                    $courseid_dialogo = $cursos->id;
                                    break;

                                case 'FILOSOFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $filosofia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $filosofia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $filosofia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $filosofia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_filosofia += 1;
                                    }                                           
                                    
                                    $courseid_filosofia = $cursos->id;
                                    break;

                                case 'FISICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $fisica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $fisica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $fisica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_fisica += 1;
                                    }                                           
                                    
                                    $courseid_fisica = $cursos->id;
                                    break;

                                case 'GEOGRAFIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $geografia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $geografia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $geografia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_geografia += 1;
                                    }                                           
                                    
                                    $courseid_geografia = $cursos->id;
                                    break;

                                case 'HISTORIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $historia_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $historia_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $historia_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $historia_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_historia += 1;
                                    }                                           
                                    
                                    $courseid_historia = $cursos->id;
                                    break;

                                case 'INGLES':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $ingles_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $ingles_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $ingles_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_ingles += 1;
                                    }                                           
                                    $courseid_ingles = $cursos->id;
                                    break;                              

                                case 'LECTURA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $lectura_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $lectura_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $lectura_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_lectura += 1;
                                    }                                           
                                    
                                    $courseid_lectura = $cursos->id;
                                    break;

                                case 'MATEMATICAS':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $matematicas_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $matematicas_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $matematicas_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_matematicas += 1;
                                    }                                           
                                    $courseid_matematicas = $cursos->id;
                                    break;                         

                                case 'QUIMICA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $quimica_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $quimica_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $quimica_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_quimica += 1;
                                    }                                           
                                    
                                    $courseid_quimica = $cursos->id;
                                    break;

                                case 'TECNOLOGIA':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $tic_asistencia = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Actividades') !== false) || (strpos($cursos->category_name,'ACTIVIDADES') !== false) || (strpos($cursos->category_name, 'COMPONENTE') !== false) || (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || (strpos($cursos->category_name, 'Seguimiento') !== false)) {
                                        
                                        $tic_seguimientos = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'Auto') !== false) || (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)) {
                                        
                                        $tic_autoevaluacion = $cursos->grade;
                                    }

                                    if ((strpos($cursos->category_name, 'TOTAL') !== false)) {
                                        
                                        $tic_totalcurso = $cursos->grade;
                                    }
                                    if(strpos($cursos->category_name, 'HUERFANO') !== false){
                                        $item_huerfano_tic += 1;
                                    }                                           
                                                                            
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:                                        
                                    echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADO";
                                    break;
                            }
                        }
                        unset($estudiante->asignaturas);
                        $estudiante->accionciudadana_asistencias = $accionciudadana_asistencias;
                        $estudiante->accionciudadana_seguimientos = $accionciudadana_seguimientos;
                        $estudiante->accionciudadana_autoevaluacion = $accionciudadana_autoevaluacion;
                        $estudiante->accionciudadana_totalcurso = $accionciudadana_totalcurso;
                        $estudiante->accionciudadana_item_huerfano = $item_huerfano_accion_ciudadana;
                        $estudiante->courseid_accion_ciudadana = $courseid_accion_ciudadana;

                        $estudiante->artes_asistencias = $artes_asistencias;
                        $estudiante->artes_seguimientos = $artes_seguimientos;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_totalcurso = $artes_totalcurso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->courseid_artes = $courseid_artes;

                        $estudiante->biologia_asistencias = $biologia_asistencias;
                        $estudiante->biologia_seguimientos = $biologia_seguimientos;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_totalcurso = $biologia_totalcurso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->courseid_biologia = $courseid_biologia;

                        $estudiante->cultura_asistencias = $cultura_asistencias;
                        $estudiante->cultura_seguimientos = $cultura_seguimientos;
                        $estudiante->cultura_autoevaluacion = $cultura_autoevaluacion;
                        $estudiante->cultura_totalcurso = $cultura_totalcurso;
                        $estudiante->cultura_item_huerfano = $item_huerfano_cultura;
                        $estudiante->courseid_cultura = $courseid_cultura;

                        $estudiante->deporte_asistencias = $deporte_asistencias;
                        $estudiante->deporte_seguimientos = $deporte_seguimientos;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_totalcurso = $deporte_totalcurso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->courseid_deporte = $courseid_deporte;

                        $estudiante->dialogo_asistencias = $dialogo_asistencias;
                        $estudiante->dialogo_seguimientos = $dialogo_seguimientos;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_totalcurso = $dialogo_totalcurso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->courseid_dialogo = $courseid_dialogo;

                        $estudiante->filosofia_asistencias = $filosofia_asistencias;
                        $estudiante->filosofia_seguimientos = $filosofia_seguimientos;
                        $estudiante->filosofia_autoevaluacion = $filosofia_autoevaluacion;
                        $estudiante->filosofia_totalcurso = $filosofia_totalcurso;
                        $estudiante->filosofia_item_huerfano = $item_huerfano_filosofia;
                        $estudiante->courseid_filosofia = $courseid_filosofia;

                        $estudiante->fisica_asistencias = $fisica_asistencias;
                        $estudiante->fisica_seguimientos = $fisica_seguimientos;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_totalcurso = $fisica_totalcurso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->courseid_fisica = $courseid_fisica;

                        $estudiante->geografia_asistencias = $geografia_asistencias;
                        $estudiante->geografia_seguimientos = $geografia_seguimientos;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_totalcurso = $geografia_totalcurso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->courseid_geografia = $courseid_geografia;

                        $estudiante->historia_asistencias = $historia_asistencias;
                        $estudiante->historia_seguimientos = $historia_seguimientos;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_totalcurso = $historia_totalcurso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->courseid_historia = $courseid_historia;

                        $estudiante->ingles_asistencias = $ingles_asistencias;
                        $estudiante->ingles_seguimientos = $ingles_seguimientos;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_totalcurso = $ingles_totalcurso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->courseid_ingles = $courseid_ingles;

                        $estudiante->lectura_asistencias = $lectura_asistencias;
                        $estudiante->lectura_seguimientos = $lectura_seguimientos;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_totalcurso = $lectura_totalcurso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->courseid_lectura = $courseid_lectura;

                        $estudiante->matematicas_asistencias = $matematicas_asistencias;
                        $estudiante->matematicas_seguimientos = $matematicas_seguimientos;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_totalcurso = $matematicas_totalcurso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->courseid_matematicas = $courseid_matematicas;

                        $estudiante->quimica_asistencias = $quimica_asistencias;
                        $estudiante->quimica_seguimientos = $quimica_seguimientos;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_totalcurso = $quimica_totalcurso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->courseid_quimica = $courseid_quimica;

                        $estudiante->tic_asistencias = $tic_asistencias;
                        $estudiante->tic_seguimientos = $tic_seguimientos;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_totalcurso = $tic_totalcurso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->courseid_tic = $courseid_tic;
                        //dd($estudiante);
                    });
                $excel = array();
                foreach($estudiantes as $estudiante){
                    $excel[] = array(
                                'id' => $estudiante->id,
                                'name' => $estudiante->name,
                                'lastname' => $estudiante->lastname,
                                'tipo_documento' => $estudiante->tipo_documento,
                                'document_number' => $estudiante->document_number,
                                'grupo' => $estudiante->grupo_name,
                                'estado' => $estudiante->estado,
                                'profersional' => $estudiante->encargado,

                                'accionciudadana_asistencias' => $estudiante->accionciudadana_asistencias,
                                'accionciudadana_seguimientos' => $estudiante->accionciudadana_seguimientos,
                                'accionciudadana_autoevaluacion' => $estudiante->accionciudadana_autoevaluacion,
                                'accionciudadana_totalcurso' => $estudiante->accionciudadana_totalcurso,

                                'artes_asistencias' => $estudiante->artes_asistencias,
                                'artes_seguimientos' => $estudiante->artes_seguimientos,
                                'artes_autoevaluacion' => $estudiante->artes_autoevaluacion,
                                'artes_totalcurso' => $estudiante->artes_totalcurso,

                                'biologia_asistencias' => $estudiante->biologia_asistencias,
                                'biologia_seguimientos' => $estudiante->biologia_seguimientos,
                                'biologia_autoevaluacion' => $estudiante->biologia_autoevaluacion,
                                'biologia_totalcurso' => $estudiante->biologia_totalcurso,

                                'cultura_asistencias' => $estudiante->cultura_asistencias,
                                'cultura_seguimientos' => $estudiante->cultura_seguimientos,
                                'cultura_autoevaluacion' => $estudiante->cultura_autoevaluacion,
                                'cultura_totalcurso' => $estudiante->cultura_totalcurso,
                                
                                'deporte_asistencias' => $estudiante->deporte_asistencias,
                                'deporte_seguimientos' => $estudiante->deporte_seguimientos,
                                'deporte_autoevaluacion' => $estudiante->deporte_autoevaluacion,
                                'deporte_totalcurso' => $estudiante->deporte_totalcurso,

                                'dialogo_asistencias' => $estudiante->dialogo_asistencias,
                                'dialogo_seguimientos' => $estudiante->dialogo_seguimientos,
                                'dialogo_autoevaluacion' => $estudiante->dialogo_autoevaluacion,
                                'dialogo_totalcurso' => $estudiante->dialogo_totalcurso,

                                'filosofia_asistencias' => $estudiante->filosofia_asistencias,
                                'filosofia_seguimientos' => $estudiante->filosofia_seguimientos,
                                'filosofia_autoevaluacion' => $estudiante->filosofia_autoevaluacion,
                                'filosofia_totalcurso' => $estudiante->filosofia_totalcurso,

                                'fisica_asistencias' => $estudiante->fisica_asistencias,
                                'fisica_seguimientos' => $estudiante->fisica_seguimientos,
                                'fisica_autoevaluacion' => $estudiante->fisica_autoevaluacion,
                                'fisica_totalcurso' => $estudiante->fisica_totalcurso,

                                'geografia_asistencias' => $estudiante->geografia_asistencias,
                                'geografia_seguimientos' => $estudiante->geografia_seguimientos,
                                'geografia_autoevaluacion' => $estudiante->geografia_autoevaluacion,
                                'geografia_totalcurso' => $estudiante->geografia_totalcurso,

                                'historia_asistencias' => $estudiante->historia_asistencias,
                                'historia_seguimientos' => $estudiante->historia_seguimientos,
                                'historia_autoevaluacion' => $estudiante->historia_autoevaluacion,
                                'historia_totalcurso' => $estudiante->historia_totalcurso,

                                'ingles_asistencias' => $estudiante->ingles_asistencias,
                                'ingles_seguimientos' => $estudiante->ingles_seguimientos,
                                'ingles_autoevaluacion' => $estudiante->ingles_autoevaluacion,
                                'ingles_totalcurso' => $estudiante->ingles_totalcurso,

                                'lectura_asistencias' => $estudiante->lectura_asistencias,
                                'lectura_seguimientos' => $estudiante->lectura_seguimientos,
                                'lectura_autoevaluacion' => $estudiante->lectura_autoevaluacion,
                                'lectura_totalcurso' => $estudiante->lectura_totalcurso,

                                'matematicas_asistencias' => $estudiante->matematicas_asistencias,
                                'matematicas_seguimientos' => $estudiante->matematicas_seguimientos,
                                'matematicas_autoevaluacion' => $estudiante->matematicas_autoevaluacion,
                                'matematicas_totalcurso' => $estudiante->matematicas_totalcurso,

                                'quimica_asistencias' => $estudiante->quimica_asistencias,
                                'quimica_seguimientos' => $estudiante->quimica_seguimientos,
                                'quimica_autoevaluacion' => $estudiante->quimica_autoevaluacion,
                                'quimica_totalcurso' => $estudiante->quimica_totalcurso,

                                'tic_asistencias' => $estudiante->tic_asistencias,
                                'tic_seguimientos' => $estudiante->tic_seguimientos,
                                'tic_autoevaluacion' => $estudiante->tic_autoevaluacion,
                                'tic_totalcurso' => $estudiante->tic_totalcurso,
                            );
                }
                //dd($excel);
                $exportar = new NotasLinea1Export([$excel]);

                return Excel::download($exportar, "reporte_notas_linea_1.xlsx");
            }           
        
    }

    public function exportar_excel_notas_linea2(){
        if(Storage::disk('local')->exists('notas_linea_2.json')) {
                    $notas = json_decode(Storage::get('notas_linea_2.json'));
                    $estudiantes = collect($notas);
                    //dd($estudiantes);
                    $estudiantes->map(function($estudiante){
                        $biologia_asistencia = 0;
                        $biologia_seguimiento_academico = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_total_curso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;
                        $artes_asistencia = 0;
                        $artes_seguimiento_academico = 0;
                        $artes_autoevaluacion = 0;
                        $artes_total_curso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $deporte_asistencia = 0;
                        $deporte_seguimiento_academico = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_total_curso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $dialogo_asistencia = 0;
                        $dialogo_seguimiento_academico = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_total_curso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $constitucion_asistencia = 0;
                        $constitucion_seguimiento_academico = 0;
                        $constitucion_autoevaluacion = 0;
                        $constitucion_total_curso = 0;
                        $item_huerfano_constitucion = 0;
                        $courseid_constitucion = 0;
                        $fisica_asistencia = 0;
                        $fisica_seguimiento_academico = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_total_curso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $geografia_asistencia = 0;
                        $geografia_seguimiento_academico = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_total_curso = 0;
                        $item_huerfano_grografia = 0;
                        $courseid_geografia = 0;
                        $historia_asistencia = 0;
                        $historia_seguimiento_academico = 0;
                        $historia_autoevaluacion = 0;
                        $historia_total_curso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $ingles_asistencia = 0;
                        $ingles_seguimiento_academico = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_total_curso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $lectura_asistencia = 0;
                        $lectura_seguimiento_academico = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_total_curso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $matematicas_asistencia = 0;
                        $matematicas_seguimiento_academico = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_total_curso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $quimica_asistencia = 0;
                        $quimica_seguimiento_academico = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_total_curso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $tic_asistencia = 0;
                        $tic_seguimiento_academico = 0;
                        $tic_autoevaluacion = 0;
                        $tic_total_curso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode('-',$cursos->fullname)[0];
                            //dd($cursos->fullname);
                            switch ($cursos->fullname) {
                                case 'BIOLOGIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $biologia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $biologia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $biologia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_biologia += 1;
                                    }
                                    $courseid_biologia = $cursos->id;                                               
                                    break;
                                
                                case 'ARTES: CONOCIMIENTO EN ACCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $artes_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $artes_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $artes_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $artes_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_artes += 1;
                                    }
                                    $courseid_artes = $cursos->id;
                                    break;
                                case 'DEPORTE Y SALUD INTEGRAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $deporte_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $deporte_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $deporte_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_deporte += 1;
                                    }
                                    $courseid_deporte = $cursos->id;
                                    break;
                                case 'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $dialogo_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $dialogo_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $dialogo_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_dialogo += 1;
                                    }
                                    $courseid_dialogo = $cursos->id;
                                    break;
                                case 'CONSTITUCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $constitucion_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $constitucion_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $constitucion_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $constitucion_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_constitucion += 1;
                                    }
                                    $courseid_constitucion = $cursos->id;
                                    break;    
                                case 'FISICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $fisica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $fisica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $fisica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_fisica += 1;
                                    }
                                    $courseid_fisica = $cursos->id;
                                    break;
                                case 'GEOGRAFIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $geografia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $geografia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $geografia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_grografia += 1;
                                    }
                                    $courseid_geografia = $cursos->id;
                                    break;
                                case 'HISTORIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $historia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $historia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $historia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $historia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_historia += 1;
                                    }
                                    $courseid_historia = $cursos->id;
                                    break;
                                case 'INGLES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $ingles_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $ingles_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $ingles_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_ingles += 1;
                                    }
                                    $courseid_ingles = $cursos->id;
                                    break;
                                case 'LECTURA CRITICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $lectura_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $lectura_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $lectura_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_lectura += 1;
                                    }
                                    $courseid_lectura = $cursos->id;
                                    break;
                                case 'MATEMATICAS ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $matematicas_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $matematicas_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $matematicas_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_matematicas += 1;
                                    }
                                    $courseid_matematicas = $cursos->id;
                                    break;
                                case 'QUIMICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $quimica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $quimica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $quimica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_quimica += 1;
                                    }
                                    $courseid_quimica = $cursos->id;
                                    break;
                                case 'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $tic_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $tic_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $tic_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $tic_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_tic += 1;
                                    }
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:
                                    break;
                            }
                        }  
                        //dd($estudiante->asignaturas);
                        $estudiante->biologia_asistencia = $biologia_asistencia;
                        $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_total_curso = $biologia_total_curso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->biologia_course_id = $courseid_biologia;
                        $estudiante->artes_asistencia = $artes_asistencia;
                        $estudiante->artes_seguimiento_academico = $artes_seguimiento_academico;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_total_curso = $artes_total_curso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->artes_course_id = $courseid_artes;
                        $estudiante->deporte_asistencia = $deporte_asistencia;
                        $estudiante->deporte_seguimiento_academico = $deporte_seguimiento_academico;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_total_curso = $deporte_total_curso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->deporte_course_id = $courseid_deporte;
                        $estudiante->dialogo_asistencia = $dialogo_asistencia;
                        $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_total_curso = $dialogo_total_curso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->dialogo_course_id = $courseid_dialogo;
                        $estudiante->constitucion_asistencia = $constitucion_asistencia;
                        $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                        $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                        $estudiante->constitucion_total_curso = $constitucion_total_curso;
                        $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                        $estudiante->constitucion_course_id = $courseid_constitucion;
                        $estudiante->fisica_asistencia = $fisica_asistencia;
                        $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_total_curso = $fisica_total_curso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->fisica_course_id = $courseid_fisica;
                        $estudiante->geografia_asistencia = $geografia_asistencia;
                        $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_total_curso = $geografia_total_curso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_grografia;
                        $estudiante->geografia_course_id = $courseid_geografia;
                        $estudiante->historia_asistencia = $historia_asistencia;
                        $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_total_curso = $historia_total_curso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->historia_course_id = $courseid_historia;
                        $estudiante->ingles_asistencia = $ingles_asistencia;
                        $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_total_curso = $ingles_total_curso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->ingles_course_id = $courseid_ingles;
                        $estudiante->lectura_asistencia = $lectura_asistencia;
                        $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_total_curso = $lectura_total_curso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->lectura_course_id = $courseid_lectura;
                        $estudiante->matematicas_asistencia = $matematicas_asistencia;
                        $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_total_curso = $matematicas_total_curso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->matematicas_course_id = $courseid_matematicas;
                        $estudiante->quimica_asistencia = $quimica_asistencia;
                        $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_total_curso = $quimica_total_curso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->quimica_course_id = $courseid_quimica;
                        $estudiante->tic_asistencia = $tic_asistencia;
                        $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_total_curso = $tic_total_curso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->tic_course_id = $courseid_tic;
                        unset($estudiante->asignaturas);
                        //dd($estudiante);
                    });
                //dd($estudiantes);
                $excel = array();
                foreach($estudiantes as $estudiante){
                    $excel[] = array(
                                'id' => $estudiante->id,
                                'name' => $estudiante->name,
                                'lastname' => $estudiante->lastname,
                                'tipo_documento' => $estudiante->tipo_documento,
                                'document_number' => $estudiante->document_number,
                                'grupo' => $estudiante->grupo_name,
                                'estado' => $estudiante->estado,
                                'profersional' => $estudiante->encargado,
                                'biologia_asistencia' => $estudiante->biologia_asistencia,
                                'biologia_seguimiento_academico' => $estudiante->biologia_seguimiento_academico,
                                'biologia_autoevaluacion' => $estudiante->biologia_autoevaluacion,
                                'biologia_total_curso' => $estudiante->biologia_total_curso,

                                'artes_asistencia' => $estudiante->artes_asistencia,
                                'artes_seguimiento_academico' => $estudiante->artes_seguimiento_academico,
                                'artes_autoevaluacion' => $estudiante->artes_autoevaluacion,
                                'artes_total_curso' => $estudiante->artes_total_curso,

                                'deporte_asistencia' => $estudiante->deporte_asistencia,
                                'deporte_seguimiento_academico' => $estudiante->deporte_seguimiento_academico,
                                'deporte_autoevaluacion' => $estudiante->deporte_autoevaluacion,
                                'deporte_total_curso' => $estudiante->deporte_total_curso,

                                'dialogo_asistencia' => $estudiante->dialogo_asistencia,
                                'dialogo_seguimiento_academico' => $estudiante->dialogo_seguimiento_academico,
                                'dialogo_autoevaluacion' => $estudiante->dialogo_autoevaluacion,
                                'dialogo_total_curso' => $estudiante->dialogo_total_curso,

                                'constitucion_asistencia' => $estudiante->constitucion_asistencia,
                                'constitucion_seguimiento_academico' => $estudiante->constitucion_seguimiento_academico,
                                'constitucion_autoevaluacion' => $estudiante->constitucion_autoevaluacion,
                                'constitucion_total_curso' => $estudiante->constitucion_total_curso,

                                'fisica_asistencia' => $estudiante->fisica_asistencia,
                                'fisica_seguimiento_academico' => $estudiante->fisica_seguimiento_academico,
                                'fisica_autoevaluacion' => $estudiante->fisica_autoevaluacion,
                                'fisica_total_curso' => $estudiante->fisica_total_curso,

                                'geografia_asistencia' => $estudiante->geografia_asistencia,
                                'geografia_seguimiento_academico' => $estudiante->geografia_seguimiento_academico,
                                'geografia_autoevaluacion' => $estudiante->geografia_autoevaluacion,
                                'geografia_total_curso' => $estudiante->geografia_total_curso,

                                'historia_asistencia' => $estudiante->historia_asistencia,
                                'historia_seguimiento_academico' => $estudiante->historia_seguimiento_academico,
                                'historia_autoevaluacion' => $estudiante->historia_autoevaluacion,
                                'historia_total_curso' => $estudiante->historia_total_curso,

                                'ingles_asistencia' => $estudiante->ingles_asistencia,
                                'ingles_seguimiento_academico' => $estudiante->ingles_seguimiento_academico,
                                'ingles_autoevaluacion' => $estudiante->ingles_autoevaluacion,
                                'ingles_total_curso' => $estudiante->ingles_total_curso,

                                'lectura_asistencia' => $estudiante->lectura_asistencia,
                                'lectura_seguimiento_academico' => $estudiante->lectura_seguimiento_academico,
                                'lectura_autoevaluacion' => $estudiante->lectura_autoevaluacion,
                                'lectura_total_curso' => $estudiante->lectura_total_curso,

                                'matematicas_asistencia' => $estudiante->matematicas_asistencia,
                                'matematicas_seguimiento_academico' => $estudiante->matematicas_seguimiento_academico,
                                'matematicas_autoevaluacion' => $estudiante->matematicas_autoevaluacion,
                                'matematicas_total_curso' => $estudiante->matematicas_total_curso,

                                'quimica_asistencia' => $estudiante->quimica_asistencia,
                                'quimica_seguimiento_academico' => $estudiante->quimica_seguimiento_academico,
                                'quimica_autoevaluacion' => $estudiante->quimica_autoevaluacion,
                                'quimica_total_curso' => $estudiante->quimica_total_curso,

                                'tic_asistencia' => $estudiante->tic_asistencia,
                                'tic_seguimiento_academico' => $estudiante->tic_seguimiento_academico,
                                'tic_autoevaluacion' => $estudiante->tic_autoevaluacion,
                                'tic_total_curso' => $estudiante->tic_total_curso,
                            );
                }
                //dd($excel);
                $exportar = new NotasLinea2Export([$excel]);

                return Excel::download($exportar, "reporte_notas_linea_2.xlsx");
        }else{

            $estudiantes_linea1 = perfilEstudiante::Estudiantes_cohort_linea2();
            $estudiantes = collect($estudiantes_linea1);
            //dd($estudiantes);

            $estudiantes->map(function($estudiante){
                $estudiante->asignaturas = CourseMoodle::asignaturas($estudiante->grupo, $estudiante->id_moodle);
                //dd($estudiante);   
            });

            $estudiantes_notas = json_encode($estudiantes);
            Storage::disk('local')->put('notas_linea_2.json', $estudiantes_notas);
            $notas = json_decode($estudiantes_notas);

            $estudiantes_notas = collect($notas);

            $estudiantes_notas->map(function($estudiante){
                        $biologia_asistencia = 0;
                        $biologia_seguimiento_academico = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_total_curso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;
                        $artes_asistencia = 0;
                        $artes_seguimiento_academico = 0;
                        $artes_autoevaluacion = 0;
                        $artes_total_curso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $deporte_asistencia = 0;
                        $deporte_seguimiento_academico = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_total_curso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $dialogo_asistencia = 0;
                        $dialogo_seguimiento_academico = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_total_curso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $constitucion_asistencia = 0;
                        $constitucion_seguimiento_academico = 0;
                        $constitucion_autoevaluacion = 0;
                        $constitucion_total_curso = 0;
                        $item_huerfano_constitucion = 0;
                        $courseid_constitucion = 0;
                        $fisica_asistencia = 0;
                        $fisica_seguimiento_academico = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_total_curso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $geografia_asistencia = 0;
                        $geografia_seguimiento_academico = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_total_curso = 0;
                        $item_huerfano_grografia = 0;
                        $courseid_geografia = 0;
                        $historia_asistencia = 0;
                        $historia_seguimiento_academico = 0;
                        $historia_autoevaluacion = 0;
                        $historia_total_curso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $ingles_asistencia = 0;
                        $ingles_seguimiento_academico = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_total_curso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $lectura_asistencia = 0;
                        $lectura_seguimiento_academico = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_total_curso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $matematicas_asistencia = 0;
                        $matematicas_seguimiento_academico = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_total_curso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $quimica_asistencia = 0;
                        $quimica_seguimiento_academico = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_total_curso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $tic_asistencia = 0;
                        $tic_seguimiento_academico = 0;
                        $tic_autoevaluacion = 0;
                        $tic_total_curso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode('-',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'BIOLOGIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $biologia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $biologia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $biologia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_biologia += 1;
                                    }
                                    $courseid_biologia = $cursos->id;                                               
                                    break;
                                
                                case 'ARTES: CONOCIMIENTO EN ACCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $artes_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $artes_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $artes_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $artes_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_artes += 1;
                                    }
                                    $courseid_artes = $cursos->id;
                                    break;
                                case 'DEPORTE Y SALUD INTEGRAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $deporte_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $deporte_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $deporte_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $deporte_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_deporte += 1;
                                    }
                                    $courseid_deporte = $cursos->id;
                                    break;
                                case 'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $dialogo_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $dialogo_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $dialogo_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $dialogo_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_dialogo += 1;
                                    }
                                    $courseid_dialogo = $cursos->id;
                                    break;
                                case 'CONSTITUCION ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $constitucion_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $constitucion_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $constitucion_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $constitucion_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_constitucion += 1;
                                    }
                                    $courseid_constitucion = $cursos->id;
                                    break;    
                                case 'FISICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $fisica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $fisica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $fisica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $fisica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_fisica += 1;
                                    }
                                    $courseid_fisica = $cursos->id;
                                    break;
                                case 'GEOGRAFIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $geografia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $geografia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $geografia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $geografia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_grografia += 1;
                                    }
                                    $courseid_grografia = $cursos->id;
                                    break;
                                case 'HISTORIA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $historia_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $historia_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $historia_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $historia_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_historia += 1;
                                    }
                                    $courseid_historia = $cursos->id;
                                    break;
                                case 'INGLES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $ingles_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $ingles_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $ingles_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $ingles_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_ingles += 1;
                                    }
                                    $courseid_ingles = $cursos->id;
                                    break;
                                case 'LECTURA CRITICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $lectura_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $lectura_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $lectura_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $lectura_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_lectura += 1;
                                    }
                                    $courseid_lectura = $cursos->id;
                                    break;
                                case 'MATEMATICAS ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $matematicas_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $matematicas_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $matematicas_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $matematicas_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_matematicas += 1;
                                    }
                                    $courseid_matematicas = $cursos->id;
                                    break;
                                case 'QUIMICA ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $quimica_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $quimica_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $quimica_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $quimica_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_quimica += 1;
                                    }
                                    $courseid_quimica = $cursos->id;
                                    break;
                                case 'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES ':
                                    if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'asistencia') !== false) || 
                                        (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        $tic_asistencia = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                        (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                        (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                        (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                        (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                        $tic_seguimiento_academico = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'Auto') !== false) ||
                                        (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                        || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $tic_autoevaluacion = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                        $tic_total_curso = $cursos->grade;
                                    }
                                    if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                        $item_huerfano_tic += 1;
                                    }
                                    $courseid_tic = $cursos->id;
                                    break;
                                default:
                                    break;
                            }
                        }  
                        //dd($estudiante->asignaturas);
                        $estudiante->biologia_asistencia = $biologia_asistencia;
                        $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_total_curso = $biologia_total_curso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->biologia_course_id = $courseid_biologia;
                        $estudiante->artes_asistencia = $artes_asistencia;
                        $estudiante->artes_seguimiento_academico = $artes_seguimiento_academico;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_total_curso = $artes_total_curso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->artes_course_id = $courseid_artes;
                        $estudiante->deporte_asistencia = $deporte_asistencia;
                        $estudiante->deporte_seguimiento_academico = $deporte_seguimiento_academico;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_total_curso = $deporte_total_curso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->deporte_course_id = $courseid_deporte;
                        $estudiante->dialogo_asistencia = $dialogo_asistencia;
                        $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_total_curso = $dialogo_total_curso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->dialogo_course_id = $courseid_dialogo;
                        $estudiante->constitucion_asistencia = $constitucion_asistencia;
                        $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                        $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                        $estudiante->constitucion_total_curso = $constitucion_total_curso;
                        $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                        $estudiante->constitucion_course_id = $courseid_constitucion;
                        $estudiante->fisica_asistencia = $fisica_asistencia;
                        $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_total_curso = $fisica_total_curso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->fisica_course_id = $courseid_fisica;
                        $estudiante->geografia_asistencia = $geografia_asistencia;
                        $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_total_curso = $geografia_total_curso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->geografia_course_id = $courseid_geografia;
                        $estudiante->historia_asistencia = $historia_asistencia;
                        $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_total_curso = $historia_total_curso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->historia_course_id = $courseid_historia;
                        $estudiante->ingles_asistencia = $ingles_asistencia;
                        $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_total_curso = $ingles_total_curso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->ingles_course_id = $courseid_ingles;
                        $estudiante->lectura_asistencia = $lectura_asistencia;
                        $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_total_curso = $lectura_total_curso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->lectura_course_id = $courseid_lectura;
                        $estudiante->matematicas_asistencia = $matematicas_asistencia;
                        $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_total_curso = $matematicas_total_curso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->matematicas_course_id = $courseid_matematicas;
                        $estudiante->quimica_asistencia = $quimica_asistencia;
                        $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_total_curso = $quimica_total_curso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->quimica_course_id = $courseid_quimica;
                        $estudiante->tic_asistencia = $tic_asistencia;
                        $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_total_curso = $tic_total_curso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->tic_course_id = $courseid_tic;
                        unset($estudiante->asignaturas);
                        //dd($estudiante);
                    });
                
                $excel = array();
                foreach($estudiantes as $estudiante){
                    $excel[] = array(
                                'id' => $estudiante->id,
                                'name' => $estudiante->name,
                                'lastname' => $estudiante->lastname,
                                'tipo_documento' => $estudiante->tipo_documento,
                                'document_number' => $estudiante->document_number,
                                'grupo' => $estudiante->grupo_name,
                                'estado' => $estudiante->estado,
                                'profersional' => $estudiante->encargado,
                                'biologia_asistencia' => $estudiante->biologia_asistencia,
                                'biologia_seguimiento_academico' => $estudiante->biologia_seguimiento_academico,
                                'biologia_autoevaluacion' => $estudiante->biologia_autoevaluacion,
                                'biologia_total_curso' => $estudiante->biologia_total_curso,
                                'artes_asistencia' => $estudiante->artes_asistencia,
                                'artes_seguimiento_academico' => $estudiante->artes_seguimiento_academico,
                                'artes_autoevaluacion' => $estudiante->artes_autoevaluacion,
                                'artes_total_curso' => $estudiante->artes_total_curso,
                                'deporte_asistencia' => $estudiante->deporte_asistencia,
                                'deporte_seguimiento_academico' => $estudiante->deporte_seguimiento_academico,
                                'deporte_autoevaluacion' => $estudiante->deporte_autoevaluacion,
                                'deporte_total_curso' => $estudiante->deporte_total_curso,
                                'dialogo_asistencia' => $estudiante->dialogo_asistencia,
                                'dialogo_seguimiento_academico' => $estudiante->dialogo_seguimiento_academico,
                                'dialogo_autoevaluacion' => $estudiante->dialogo_autoevaluacion,
                                'dialogo_total_curso' => $estudiante->dialogo_total_curso,
                                'constitucion_asistencia' => $estudiante->constitucion_asistencia,
                                'constitucion_seguimiento_academico' => $estudiante->constitucion_seguimiento_academico,
                                'constitucion_autoevaluacion' => $estudiante->constitucion_autoevaluacion,
                                'constitucion_total_curso' => $estudiante->constitucion_total_curso,
                                'fisica_asistencia' => $estudiante->fisica_asistencia,
                                'fisica_seguimiento_academico' => $estudiante->fisica_seguimiento_academico,
                                'fisica_autoevaluacion' => $estudiante->fisica_autoevaluacion,
                                'fisica_total_curso' => $estudiante->fisica_total_curso,
                                'geografia_asistencia' => $estudiante->geografia_asistencia,
                                'geografia_seguimiento_academico' => $estudiante->geografia_seguimiento_academico,
                                'geografia_autoevaluacion' => $estudiante->geografia_autoevaluacion,
                                'geografia_total_curso' => $estudiante->geografia_total_curso,
                                'historia_asistencia' => $estudiante->historia_asistencia,
                                'historia_seguimiento_academico' => $estudiante->historia_seguimiento_academico,
                                'historia_autoevaluacion' => $estudiante->historia_autoevaluacion,
                                'historia_total_curso' => $estudiante->historia_total_curso,
                                'ingles_asistencia' => $estudiante->ingles_asistencia,
                                'ingles_seguimiento_academico' => $estudiante->ingles_seguimiento_academico,
                                'ingles_autoevaluacion' => $estudiante->ingles_autoevaluacion,
                                'ingles_total_curso' => $estudiante->ingles_total_curso,
                                'lectura_asistencia' => $estudiante->lectura_asistencia,
                                'lectura_seguimiento_academico' => $estudiante->lectura_seguimiento_academico,
                                'lectura_autoevaluacion' => $estudiante->lectura_autoevaluacion,
                                'lectura_total_curso' => $estudiante->lectura_total_curso,
                                'matematicas_asistencia' => $estudiante->matematicas_asistencia,
                                'matematicas_seguimiento_academico' => $estudiante->matematicas_seguimiento_academico,
                                'matematicas_autoevaluacion' => $estudiante->matematicas_autoevaluacion,
                                'matematicas_total_curso' => $estudiante->matematicas_total_curso,
                                'quimica_asistencia' => $estudiante->quimica_asistencia,
                                'quimica_seguimiento_academico' => $estudiante->quimica_seguimiento_academico,
                                'quimica_autoevaluacion' => $estudiante->quimica_autoevaluacion,
                                'quimica_total_curso' => $estudiante->quimica_total_curso,
                                'tic_asistencia' => $estudiante->tic_asistencia,
                                'tic_seguimiento_academico' => $estudiante->tic_seguimiento_academico,
                                'tic_autoevaluacion' => $estudiante->tic_autoevaluacion,
                                'tic_total_curso' => $estudiante->tic_total_curso,
                            );
                }
                //dd($excel);
                $exportar = new NotasLinea2Export([$excel]);

                return Excel::download($exportar, "reporte_notas_linea_2.xlsx");
            }           
        
    }

    public function exportar_excel_notas_linea3(){
        if(Storage::disk('local')->exists('notas_linea_3.json')) {
            $notas = json_decode(Storage::get('notas_linea_3.json'));
            $estudiantes = collect($notas);
            //dd($estudiantes);      
            $estudiantes->map(function($estudiante){
                $biologia_asistencia = 0;
                $biologia_seguimiento_academico = 0;
                $biologia_autoevaluacion = 0;
                $biologia_total_curso = 0;
                $item_huerfano_biologia = 0;
                $courseid_biologia = 0;

                $constitucion_asistencia = 0;
                $constitucion_seguimiento_academico = 0;
                $constitucion_autoevaluacion = 0;
                $constitucion_total_curso = 0;
                $item_huerfano_constitucion = 0;
                $courseid_constitucion = 0;

                $fisica_asistencia = 0;
                $fisica_seguimiento_academico = 0;
                $fisica_autoevaluacion = 0;
                $fisica_total_curso = 0;
                $item_huerfano_fisica = 0;
                $courseid_fisica = 0;

                $geografia_asistencia = 0;
                $geografia_seguimiento_academico = 0;
                $geografia_autoevaluacion = 0;
                $geografia_total_curso = 0;
                $item_huerfano_geografia = 0;
                $courseid_geografia = 0;
                
                $historia_asistencia = 0;
                $historia_seguimiento_academico = 0;
                $historia_autoevaluacion = 0;
                $historia_total_curso = 0;
                $item_huerfano_historia = 0;
                $courseid_historia = 0;

                $ingles_asistencia = 0;
                $ingles_seguimiento_academico = 0;
                $ingles_autoevaluacion = 0;
                $ingles_total_curso = 0;
                $item_huerfano_ingles = 0;
                $courseid_ingles = 0;

                $lectura_asistencia = 0;
                $lectura_seguimiento_academico = 0;
                $lectura_autoevaluacion = 0;
                $lectura_total_curso = 0;
                $item_huerfano_lectura = 0;
                $courseid_lectura = 0;

                $matematicas_asistencia = 0;
                $matematicas_seguimiento_academico = 0;
                $matematicas_autoevaluacion = 0;
                $matematicas_total_curso = 0;
                $item_huerfano_matematicas = 0;
                $courseid_matematicas = 0;

                $quimica_asistencia = 0;
                $quimica_seguimiento_academico = 0;
                $quimica_autoevaluacion = 0;
                $quimica_total_curso = 0;
                $item_huerfano_quimica = 0;
                $courseid_quimica = 0;

                foreach((array)$estudiante->asignaturas as $cursos){
                    $cursos->fullname = explode('-',$cursos->fullname)[0];
                    //dd($cursos);
                    switch ($cursos->fullname) {
                        case 'BIOLOGIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $biologia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $biologia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $biologia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_biologia += 1;
                            }
                            $courseid_biologia = $cursos->id;                                           
                        break;
                        case 'CONSTITUCION ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $constitucion_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $constitucion_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $constitucion_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $constitucion_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_constitucion += 1;
                            }
                            $courseid_constitucion = $cursos->id;
                        break;    
                        case 'FISICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $fisica_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $fisica_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $fisica_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $fisica_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_fisica += 1;
                            }
                            $courseid_fisica = $cursos->id;
                        break;
                        case 'GEOGRAFIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $geografia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $geografia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $geografia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $geografia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_geografia += 1;
                            }
                            $courseid_geografia = $cursos->id;
                        break;
                        case 'HISTORIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $historia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $historia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $historia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $historia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_historia += 1;
                            }
                            $courseid_historia = $cursos->id;
                        break;
                        case 'INGLES ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $ingles_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $ingles_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $ingles_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $ingles_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_ingles += 1;
                            }
                            $courseid_ingles = $cursos->id;
                        break;
                        case 'LECTURA CRITICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $lectura_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $lectura_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $lectura_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $lectura_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_lectura += 1;
                            }
                            $courseid_lectura = $cursos->id;
                            break;
                            case 'MATEMATICAS ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $matematicas_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $matematicas_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $matematicas_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $matematicas_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_matematicas += 1;
                                }
                                $courseid_matematicas = $cursos->id;
                            break;
                            case 'QUIMICA ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $quimica_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $quimica_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $quimica_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $quimica_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_quimica += 1;
                                }
                                $courseid_quimica = $cursos->id;
                                break;    
                        default:
                            break;
                    }
                }
                //dd($courseid);
                
                $estudiante->biologia_asistencia = $biologia_asistencia;
                $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                $estudiante->biologia_total_curso = $biologia_total_curso;
                $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                $estudiante->biologia_course_id = $courseid_biologia;
                $estudiante->constitucion_asistencia = $constitucion_asistencia;
                $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                $estudiante->constitucion_total_curso = $constitucion_total_curso;
                $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                $estudiante->constitucion_course_id = $courseid_constitucion;
                $estudiante->fisica_asistencia = $fisica_asistencia;
                $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                $estudiante->fisica_total_curso = $fisica_total_curso;
                $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                $estudiante->fisica_course_id = $courseid_fisica;
                $estudiante->geografia_asistencia = $geografia_asistencia;
                $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                $estudiante->geografia_total_curso = $geografia_total_curso;
                $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                $estudiante->geografia_course_id = $courseid_geografia;
                $estudiante->historia_asistencia = $historia_asistencia;
                $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                $estudiante->historia_total_curso = $historia_total_curso;
                $estudiante->historia_item_huerfano = $item_huerfano_historia;
                $estudiante->historia_course_id = $courseid_historia;
                $estudiante->ingles_asistencia = $ingles_asistencia;
                $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                $estudiante->ingles_total_curso = $ingles_total_curso;
                $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                $estudiante->ingles_course_id = $courseid_ingles;
                $estudiante->lectura_asistencia = $lectura_asistencia;
                $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                $estudiante->lectura_total_curso = $lectura_total_curso;
                $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                $estudiante->lectura_course_id = $courseid_lectura;
                $estudiante->matematicas_asistencia = $matematicas_asistencia;
                $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                $estudiante->matematicas_total_curso = $matematicas_total_curso;
                $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                $estudiante->matematicas_course_id = $courseid_matematicas;
                $estudiante->quimica_asistencia = $quimica_asistencia;
                $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                $estudiante->quimica_total_curso = $quimica_total_curso;
                $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                $estudiante->quimica_course_id = $courseid_quimica;
                unset($estudiante->asignaturas);
                //dd($estudiante);
            });

            //dd($estudiantes);
            $excel = array();
                foreach($estudiantes as $estudiante){
                    $excel[] = array(
                                'id' => $estudiante->id,
                                'name' => $estudiante->name,
                                'lastname' => $estudiante->lastname,
                                'tipo_documento' => $estudiante->tipo_documento,
                                'document_number' => $estudiante->document_number,
                                'grupo' => $estudiante->grupo_name,
                                'estado' => $estudiante->estado,
                                'profersional' => $estudiante->encargado,
                                
                                'biologia_asistencia' => $estudiante->biologia_asistencia,
                                'biologia_seguimiento_academico' => $estudiante->biologia_seguimiento_academico,
                                'biologia_autoevaluacion' => $estudiante->biologia_autoevaluacion,
                                'biologia_total_curso' => $estudiante->biologia_total_curso,

                                'constitucion_asistencia' => $estudiante->constitucion_asistencia,
                                'constitucion_seguimiento_academico' => $estudiante->constitucion_seguimiento_academico,
                                'constitucion_autoevaluacion' => $estudiante->constitucion_autoevaluacion,
                                'constitucion_total_curso' => $estudiante->constitucion_total_curso,

                                'fisica_asistencia' => $estudiante->fisica_asistencia,
                                'fisica_seguimiento_academico' => $estudiante->fisica_seguimiento_academico,
                                'fisica_autoevaluacion' => $estudiante->fisica_autoevaluacion,
                                'fisica_total_curso' => $estudiante->fisica_total_curso,

                                'geografia_asistencia' => $estudiante->geografia_asistencia,
                                'geografia_seguimiento_academico' => $estudiante->geografia_seguimiento_academico,
                                'geografia_autoevaluacion' => $estudiante->geografia_autoevaluacion,
                                'geografia_total_curso' => $estudiante->geografia_total_curso,

                                'historia_asistencia' => $estudiante->historia_asistencia,
                                'historia_seguimiento_academico' => $estudiante->historia_seguimiento_academico,
                                'historia_autoevaluacion' => $estudiante->historia_autoevaluacion,
                                'historia_total_curso' => $estudiante->historia_total_curso,

                                'ingles_asistencia' => $estudiante->ingles_asistencia,
                                'ingles_seguimiento_academico' => $estudiante->ingles_seguimiento_academico,
                                'ingles_autoevaluacion' => $estudiante->ingles_autoevaluacion,
                                'ingles_total_curso' => $estudiante->ingles_total_curso,

                                'lectura_asistencia' => $estudiante->lectura_asistencia,
                                'lectura_seguimiento_academico' => $estudiante->lectura_seguimiento_academico,
                                'lectura_autoevaluacion' => $estudiante->lectura_autoevaluacion,
                                'lectura_total_curso' => $estudiante->lectura_total_curso,

                                'matematicas_asistencia' => $estudiante->matematicas_asistencia,
                                'matematicas_seguimiento_academico' => $estudiante->matematicas_seguimiento_academico,
                                'matematicas_autoevaluacion' => $estudiante->matematicas_autoevaluacion,
                                'matematicas_total_curso' => $estudiante->matematicas_total_curso,

                                'quimica_asistencia' => $estudiante->quimica_asistencia,
                                'quimica_seguimiento_academico' => $estudiante->quimica_seguimiento_academico,
                                'quimica_autoevaluacion' => $estudiante->quimica_autoevaluacion,
                                'quimica_total_curso' => $estudiante->quimica_total_curso,
                            );
                }
                //dd($excel);
                $exportar = new NotasLinea3Export([$excel]);

                return Excel::download($exportar, "reporte_notas_linea_3.xlsx");
        }else{
            $estudiantes_linea3 = perfilEstudiante::Estudiantes_cohort_linea3();
            $estudiantes = collect($estudiantes_linea3);
            //dd($estudiantes);

            $estudiantes->map(function($estudiante){
                $estudiante->asignaturas = CourseMoodle::asignaturas($estudiante->grupo, $estudiante->id_moodle);
                //dd($estudiante);   
            });

            $estudiantes_notas = json_encode($estudiantes);
            Storage::disk('local')->put('notas_linea_3.json', $estudiantes_notas);
            $notas = json_decode($estudiantes_notas);

            $estudiantes_notas = collect($notas);

            $estudiantes->map(function($estudiante){
                $biologia_asistencia = 0;
                $biologia_seguimiento_academico = 0;
                $biologia_autoevaluacion = 0;
                $biologia_total_curso = 0;
                $item_huerfano_biologia = 0;

                $constitucion_asistencia = 0;
                $constitucion_seguimiento_academico = 0;
                $constitucion_autoevaluacion = 0;
                $constitucion_total_curso = 0;
                $item_huerfano_constitucion = 0;

                $fisica_asistencia = 0;
                $fisica_seguimiento_academico = 0;
                $fisica_autoevaluacion = 0;
                $fisica_total_curso = 0;
                $item_huerfano_fisica = 0;

                $geografia_asistencia = 0;
                $geografia_seguimiento_academico = 0;
                $geografia_autoevaluacion = 0;
                $geografia_total_curso = 0;
                $item_huerfano_geografia = 0;
                
                $historia_asistencia = 0;
                $historia_seguimiento_academico = 0;
                $historia_autoevaluacion = 0;
                $historia_total_curso = 0;
                $item_huerfano_historia = 0;

                $ingles_asistencia = 0;
                $ingles_seguimiento_academico = 0;
                $ingles_autoevaluacion = 0;
                $ingles_total_curso = 0;
                $item_huerfano_ingles = 0;

                $lectura_asistencia = 0;
                $lectura_seguimiento_academico = 0;
                $lectura_autoevaluacion = 0;
                $lectura_total_curso = 0;
                $item_huerfano_lectura = 0;

                $matematicas_asistencia = 0;
                $matematicas_seguimiento_academico = 0;
                $matematicas_autoevaluacion = 0;
                $matematicas_total_curso = 0;
                $item_huerfano_matematicas = 0;

                $quimica_asistencia = 0;
                $quimica_seguimiento_academico = 0;
                $quimica_autoevaluacion = 0;
                $quimica_total_curso = 0;
                $item_huerfano_quimica = 0;

                foreach((array)$estudiante->asignaturas as $cursos){
                    $cursos->fullname = explode('-',$cursos->fullname)[0];
                    dd($cursos);
                    switch ($cursos->fullname) {
                        case 'BIOLOGIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $biologia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $biologia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                        $biologia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $biologia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_biologia += 1;
                            }                                               
                        break;
                        case 'CONSTITUCION ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $constitucion_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $constitucion_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $constitucion_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $constitucion_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_constitucion += 1;
                            }
                        break;    
                        case 'FISICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $fisica_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $fisica_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $fisica_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $fisica_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_fisica += 1;
                            }
                        break;
                        case 'GEOGRAFIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $geografia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $geografia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $geografia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $geografia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_geografia += 1;
                            }
                        break;
                        case 'HISTORIA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $historia_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $historia_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $historia_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $historia_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_historia += 1;
                            }
                        break;
                        case 'INGLES ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $ingles_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $ingles_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $ingles_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $ingles_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_ingles += 1;
                            }
                        break;
                        case 'LECTURA CRITICA ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                            (strpos($cursos->category_name, 'asistencia') !== false) || 
                            (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $lectura_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                            (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                            (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                            (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                            (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $lectura_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                            (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                            || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $lectura_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $lectura_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_lectura += 1;
                            }
                            break;
                            case 'MATEMATICAS ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $matematicas_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $matematicas_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $matematicas_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $matematicas_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_matematicas += 1;
                                }
                            break;
                            case 'QUIMICA ':
                                if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                    $quimica_asistencia = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                    $quimica_seguimiento_academico = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                    $quimica_autoevaluacion = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                    $quimica_total_curso = $cursos->grade;
                                }
                                if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                    $item_huerfano_quimica += 1;
                                }
                                break;    
                        default:
                            break;
                    }
                }
                $estudiante->biologia_asistencia = $biologia_asistencia;
                $estudiante->biologia_seguimiento_academico = $biologia_seguimiento_academico;
                $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                $estudiante->biologia_total_curso = $biologia_total_curso;
                $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                $estudiante->biologia_course_id = $estudiante->cursos->course_id;
                $estudiante->constitucion_asistencia = $constitucion_asistencia;
                $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                $estudiante->constitucion_total_curso = $constitucion_total_curso;
                $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                $estudiante->constitucion_course_id = $estudiante->cursos->course_id;
                $estudiante->fisica_asistencia = $fisica_asistencia;
                $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                $estudiante->fisica_total_curso = $fisica_total_curso;
                $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                $estudiante->fisica_course_id = $estudiante->cursos->course_id;
                $estudiante->geografia_asistencia = $geografia_asistencia;
                $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                $estudiante->geografia_total_curso = $geografia_total_curso;
                $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                $estudiante->geografia_course_id = $estudiante->cursos->course_id;
                $estudiante->historia_asistencia = $historia_asistencia;
                $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                $estudiante->historia_total_curso = $historia_total_curso;
                $estudiante->historia_item_huerfano = $item_huerfano_historia;
                $estudiante->historia_course_id = $estudiante->cursos->course_id;
                $estudiante->ingles_asistencia = $ingles_asistencia;
                $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                $estudiante->ingles_total_curso = $ingles_total_curso;
                $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                $estudiante->ingles_course_id = $estudiante->cursos->course_id;
                $estudiante->lectura_asistencia = $lectura_asistencia;
                $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                $estudiante->lectura_total_curso = $lectura_total_curso;
                $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                $estudiante->lectura_course_id = $estudiante->cursos->course_id;
                $estudiante->matematicas_asistencia = $matematicas_asistencia;
                $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                $estudiante->matematicas_total_curso = $matematicas_total_curso;
                $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                $estudiante->matematicas_course_id = $estudiante->cursos->course_id;
                $estudiante->quimica_asistencia = $quimica_asistencia;
                $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                $estudiante->quimica_total_curso = $quimica_total_curso;
                $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                $estudiante->quimica_course_id = $estudiante->cursos->course_id;
                unset($estudiante->asignaturas);
                //dd($estudiante);
            });
            //dd($estudiantes);
            $excel = array();
                foreach($estudiantes_notas as $estudiante){
                    $excel[] = array(
                                'id' => $estudiante->id,
                                'name' => $estudiante->name,
                                'lastname' => $estudiante->lastname,
                                'tipo_documento' => $estudiante->tipo_documento,
                                'document_number' => $estudiante->document_number,
                                'grupo' => $estudiante->grupo_name,
                                'estado' => $estudiante->estado,
                                'profersional' => $estudiante->encargado,
                                'biologia_asistencia' => $estudiante->biologia_asistencia,
                                'biologia_seguimiento_academico' => $estudiante->biologia_seguimiento_academico,
                                'biologia_autoevaluacion' => $estudiante->biologia_autoevaluacion,
                                'biologia_total_curso' => $estudiante->biologia_total_curso,
                                'constitucion_asistencia' => $estudiante->constitucion_asistencia,
                                'constitucion_seguimiento_academico' => $estudiante->constitucion_seguimiento_academico,
                                'constitucion_autoevaluacion' => $estudiante->constitucion_autoevaluacion,
                                'constitucion_total_curso' => $estudiante->constitucion_total_curso,
                                'fisica_asistencia' => $estudiante->fisica_asistencia,
                                'fisica_seguimiento_academico' => $estudiante->fisica_seguimiento_academico,
                                'fisica_autoevaluacion' => $estudiante->fisica_autoevaluacion,
                                'fisica_total_curso' => $estudiante->fisica_total_curso,
                                'geografia_asistencia' => $estudiante->geografia_asistencia,
                                'geografia_seguimiento_academico' => $estudiante->geografia_seguimiento_academico,
                                'geografia_autoevaluacion' => $estudiante->geografia_autoevaluacion,
                                'geografia_total_curso' => $estudiante->geografia_total_curso,
                                'historia_asistencia' => $estudiante->historia_asistencia,
                                'historia_seguimiento_academico' => $estudiante->historia_seguimiento_academico,
                                'historia_autoevaluacion' => $estudiante->historia_autoevaluacion,
                                'historia_total_curso' => $estudiante->historia_total_curso,
                                'ingles_asistencia' => $estudiante->ingles_asistencia,
                                'ingles_seguimiento_academico' => $estudiante->ingles_seguimiento_academico,
                                'ingles_autoevaluacion' => $estudiante->ingles_autoevaluacion,
                                'ingles_total_curso' => $estudiante->ingles_total_curso,
                                'lectura_asistencia' => $estudiante->lectura_asistencia,
                                'lectura_seguimiento_academico' => $estudiante->lectura_seguimiento_academico,
                                'lectura_autoevaluacion' => $estudiante->lectura_autoevaluacion,
                                'lectura_total_curso' => $estudiante->lectura_total_curso,
                                'matematicas_asistencia' => $estudiante->matematicas_asistencia,
                                'matematicas_seguimiento_academico' => $estudiante->matematicas_seguimiento_academico,
                                'matematicas_autoevaluacion' => $estudiante->matematicas_autoevaluacion,
                                'matematicas_total_curso' => $estudiante->matematicas_total_curso,
                                'quimica_asistencia' => $estudiante->quimica_asistencia,
                                'quimica_seguimiento_academico' => $estudiante->quimica_seguimiento_academico,
                                'quimica_autoevaluacion' => $estudiante->quimica_autoevaluacion,
                                'quimica_total_curso' => $estudiante->quimica_total_curso,
                            );
                }
                //dd($excel);
                $exportar = new NotasLinea3Export([$excel]);

                return Excel::download($exportar, "reporte_notas_linea_3.xlsx");
        }
    
    } 
}
