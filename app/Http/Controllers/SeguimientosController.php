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

    public function reporte_notas($id){

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
        //ini_set('memory_limit', '8600M');
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
}
