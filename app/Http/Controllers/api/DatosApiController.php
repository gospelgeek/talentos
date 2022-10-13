<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\perfilEstudiante;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DatosApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user, $token)
    {   
        $prueba = User::select('id')->where('email', $user)->where('check_lave', $token)->exists();
        //dd($prueba);
        if($prueba){
            $estudiantes = perfilEstudiante::select('id', 'name', 'lastname', 'document_number', 'id_document_type', 'id_state')->get();
            $estudiantes->map(function($estudiante){
            $estudiante->tipo_documento = $estudiante->documenttype ? $estudiante->documenttype->name : null;
            $estudiante->estado = $estudiante->condition ? $estudiante->condition->name : null;  
            $estudiante->linea = $estudiante->studentGroup ?  $estudiante->studentGroup->group->cohort->name : null;
            $estudiante->grupo = $estudiante->studentGroup ?  $estudiante->studentGroup->group->name : null;

            unset($estudiante->documenttype);
            unset($estudiante->condition);
            unset($estudiante->studentGroup);
        });
        
        //return $this->succesResponse($estudiantes);
        return response()->json(array("data" => $estudiantes, "code" => 200, "msj" => ''));  
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function notas_linea_1($user, $token){
        $prueba = User::select('id')->where('email', $user)->where('check_lave', $token)->exists();
        if($prueba){
            if(Storage::disk('local')->exists('notas_linea_1.json')) {
                    $asistencias = json_decode(Storage::get('notas_linea_1.json'));
                    //dd($asistencias);
                    $estudiantes = collect($asistencias);
                    
                    $estudiantes->map(function($estudiante){

                        $accionciudadana_asistencias = 0;
                        $accionciudadana_seguimientos = 0;
                        $accionciudadana_autoevaluacion = 0;
                        $accionciudadana_totalcurso = 0;
                        $item_huerfano_accion_ciudadana = 0;
                        $courseid_accion_ciudadana = 0;
                        $docente_accion_ciudadana = '';

                        $artes_asistencias = 0;
                        $artes_seguimientos = 0;
                        $artes_autoevaluacion = 0;
                        $artes_totalcurso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $docente_artes = '';

                        $biologia_asistencias = 0;
                        $biologia_seguimientos = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_totalcurso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;
                        $docente_biologia = '';

                        $cultura_asistencias = 0;
                        $cultura_seguimientos = 0;
                        $cultura_autoevaluacion = 0;
                        $cultura_totalcurso = 0;
                        $item_huerfano_cultura = 0;
                        $courseid_cultura = 0;
                        $docente_cultura = '';

                        $deporte_asistencias = 0;
                        $deporte_seguimientos = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_totalcurso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $docente_deporte = '';

                        $dialogo_asistencias = 0;
                        $dialogo_seguimientos = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_totalcurso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $docente_dialogo = '';

                        $filosofia_asistencias = 0;
                        $filosofia_seguimientos = 0;
                        $filosofia_autoevaluacion = 0;
                        $filosofia_totalcurso = 0;
                        $item_huerfano_filosofia = 0;
                        $courseid_filosofia = 0;
                        $docente_filosofia = '';

                        $fisica_asistencias = 0;
                        $fisica_seguimientos = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_totalcurso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $docente_fisica = '';

                        $geografia_asistencias = 0;
                        $geografia_seguimientos = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_totalcurso = 0;
                        $item_huerfano_geografia = 0;
                        $courseid_geografia = 0;
                        $docente_geografia = '';

                        $historia_asistencias = 0;
                        $historia_seguimientos = 0;
                        $historia_autoevaluacion = 0;
                        $historia_totalcurso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $docente_historia = '';

                        $ingles_asistencias = 0;
                        $ingles_seguimientos = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_totalcurso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $docente_ingles = '';

                        $lectura_asistencias = 0;
                        $lectura_seguimientos = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_totalcurso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $docente_lectura = '';

                        $matematicas_asistencias = 0;
                        $matematicas_seguimientos = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_totalcurso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $docente_matematicas = '';

                        $quimica_asistencias = 0;
                        $quimica_seguimientos = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_totalcurso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $docente_quimica = '';

                        $tic_asistencias = 0;
                        $tic_seguimientos = 0;
                        $tic_autoevaluacion = 0;
                        $tic_totalcurso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        $docente_tic = '';
                        //dd($estudiante->asignaturas);
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode('-',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'JORNADAS DE ACCION CIUDADANA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $accionciudadana_asistencias = $cursos->grade;
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
                                    $docente_accion_ciudadana = $cursos->docente_name;
                                    break;

                                case 'ARTES: CONOCIMIENTO EN ACCION ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $artes_asistencias = $cursos->grade;
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
                                    $docente_artes = $cursos->docente_name;
                                    break;

                                case 'BIOLOGIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $biologia_asistencias = $cursos->grade;
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
                                    $docente_biologia = $cursos->docente_name;
                                    break;

                                case 'CULTURA DEMOCRATICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $cultura_asistencias = $cursos->grade;
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
                                    $docente_cultura = $cursos->docente_name;
                                    break;

                                case 'DEPORTE Y SALUD INTEGRAL ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $deporte_asistencias = $cursos->grade;
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
                                    $docente_deporte = $cursos->docente_name;
                                    break;

                                case 'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $dialogo_asistencias = $cursos->grade;
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
                                    $docente_dialogo = $cursos->docente_name;
                                    break;

                                case 'FILOSOFIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $filosofia_asistencias = $cursos->grade;
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
                                    $docente_filosofia = $cursos->docente_name;
                                    break;

                                case 'FISICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $fisica_asistencias = $cursos->grade;
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
                                    $docente_fisica = $cursos->docente_name;
                                    break;

                                case 'GEOGRAFIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $geografia_asistencias = $cursos->grade;
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
                                    $docente_geografia = $cursos->docente_name;
                                    break;

                                case 'HISTORIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $historia_asistencias = $cursos->grade;
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
                                    $docente_historia = $cursos->docente_name;
                                    break;

                                case 'INGLES ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $ingles_asistencias = $cursos->grade;
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
                                    $docente_ingles = $cursos->docente_name;
                                    break;                               
                                case 'LECTURA CRITICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $lectura_asistencias = $cursos->grade;
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
                                    $docente_lectura = $cursos->docente_name;
                                    break;

                                case 'MATEMATICAS ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $matematicas_asistencias = $cursos->grade;
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
                                    $docente_matematicas = $cursos->docente_name;
                                    break;                          

                                case 'QUIMICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $quimica_asistencias = $cursos->grade;
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
                                    $docente_quimica = $cursos->docente_name;
                                    break;

                                case 'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $tic_asistencias = $cursos->grade;
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
                                    $docente_tic = $cursos->docente_name;
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
                        $estudiante->docente_accion_ciudadana = $docente_accion_ciudadana;

                        $estudiante->artes_asistencias = $artes_asistencias;
                        $estudiante->artes_seguimientos = $artes_seguimientos;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_totalcurso = $artes_totalcurso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->courseid_artes = $courseid_artes;
                        $estudiante->docente_artes = $docente_artes;

                        $estudiante->biologia_asistencias = $biologia_asistencias;
                        $estudiante->biologia_seguimientos = $biologia_seguimientos;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_totalcurso = $biologia_totalcurso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->courseid_biologia = $courseid_biologia;
                        $estudiante->docente_biologia = $docente_biologia;

                        $estudiante->cultura_asistencias = $cultura_asistencias;
                        $estudiante->cultura_seguimientos = $cultura_seguimientos;
                        $estudiante->cultura_autoevaluacion = $cultura_autoevaluacion;
                        $estudiante->cultura_totalcurso = $cultura_totalcurso;
                        $estudiante->cultura_item_huerfano = $item_huerfano_cultura;
                        $estudiante->courseid_cultura = $courseid_cultura;
                        $estudiante->docente_cultura = $docente_cultura;

                        $estudiante->deporte_asistencias = $deporte_asistencias;
                        $estudiante->deporte_seguimientos = $deporte_seguimientos;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_totalcurso = $deporte_totalcurso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->courseid_deporte = $courseid_deporte;
                        $estudiante->docente_deporte = $docente_deporte;

                        $estudiante->dialogo_asistencias = $dialogo_asistencias;
                        $estudiante->dialogo_seguimientos = $dialogo_seguimientos;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_totalcurso = $dialogo_totalcurso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->courseid_dialogo = $courseid_dialogo;
                        $estudiante->docente_dialogo = $docente_dialogo;

                        $estudiante->filosofia_asistencias = $filosofia_asistencias;
                        $estudiante->filosofia_seguimientos = $filosofia_seguimientos;
                        $estudiante->filosofia_autoevaluacion = $filosofia_autoevaluacion;
                        $estudiante->filosofia_totalcurso = $filosofia_totalcurso;
                        $estudiante->filosofia_item_huerfano = $item_huerfano_filosofia;
                        $estudiante->courseid_filosofia = $courseid_filosofia;
                        $estudiante->docente_filosofia = $docente_filosofia;

                        $estudiante->fisica_asistencias = $fisica_asistencias;
                        $estudiante->fisica_seguimientos = $fisica_seguimientos;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_totalcurso = $fisica_totalcurso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->courseid_fisica = $courseid_fisica;
                        $estudiante->docente_fisica = $docente_fisica;

                        $estudiante->geografia_asistencias = $geografia_asistencias;
                        $estudiante->geografia_seguimientos = $geografia_seguimientos;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_totalcurso = $geografia_totalcurso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->courseid_geografia = $courseid_geografia;
                        $estudiante->docente_geografia = $docente_geografia;

                        $estudiante->historia_asistencias = $historia_asistencias;
                        $estudiante->historia_seguimientos = $historia_seguimientos;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_totalcurso = $historia_totalcurso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->courseid_historia = $courseid_historia;
                        $estudiante->docente_historia = $docente_historia;

                        $estudiante->ingles_asistencias = $ingles_asistencias;
                        $estudiante->ingles_seguimientos = $ingles_seguimientos;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_totalcurso = $ingles_totalcurso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->courseid_ingles = $courseid_ingles;
                        $estudiante->docente_ingles = $docente_ingles;

                        $estudiante->lectura_asistencias = $lectura_asistencias;
                        $estudiante->lectura_seguimientos = $lectura_seguimientos;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_totalcurso = $lectura_totalcurso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->courseid_lectura = $courseid_lectura;
                        $estudiante->docente_lectura = $docente_lectura;

                        $estudiante->matematicas_asistencias = $matematicas_asistencias;
                        $estudiante->matematicas_seguimientos = $matematicas_seguimientos;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_totalcurso = $matematicas_totalcurso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->courseid_matematicas = $courseid_matematicas;
                        $estudiante->docente_matematicas = $docente_matematicas;

                        $estudiante->quimica_asistencias = $quimica_asistencias;
                        $estudiante->quimica_seguimientos = $quimica_seguimientos;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_totalcurso = $quimica_totalcurso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->courseid_quimica = $courseid_quimica;
                        $estudiante->docente_quimica = $docente_quimica;

                        $estudiante->tic_asistencias = $tic_asistencias;
                        $estudiante->tic_seguimientos = $tic_seguimientos;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_totalcurso = $tic_totalcurso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->courseid_tic = $courseid_tic;
                        $estudiante->docente_tic = $docente_tic;
                        //dd($estudiante);
                    });
                //dd($estudiantes);
                return datatables()->of($estudiantes)->toJson();
        }else{
            $estudiantes_linea1 = perfilEstudiante::Estudiantes_cohort_linea1();
            $estudiantes = collect($estudiantes_linea1);
           

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
                        $docente_accion_ciudadana = '';

                        $artes_asistencias = 0;
                        $artes_seguimientos = 0;
                        $artes_autoevaluacion = 0;
                        $artes_totalcurso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $docente_artes = '';

                        $biologia_asistencias = 0;
                        $biologia_seguimientos = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_totalcurso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;
                        $docente_biologia = '';

                        $cultura_asistencias = 0;
                        $cultura_seguimientos = 0;
                        $cultura_autoevaluacion = 0;
                        $cultura_totalcurso = 0;
                        $item_huerfano_cultura = 0;
                        $courseid_cultura = 0;
                        $docente_cultura = '';

                        $deporte_asistencias = 0;
                        $deporte_seguimientos = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_totalcurso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $docente_deporte = '';

                        $dialogo_asistencias = 0;
                        $dialogo_seguimientos = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_totalcurso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $docente_dialogo = '';

                        $filosofia_asistencias = 0;
                        $filosofia_seguimientos = 0;
                        $filosofia_autoevaluacion = 0;
                        $filosofia_totalcurso = 0;
                        $item_huerfano_filosofia = 0;
                        $courseid_filosofia = 0;
                        $docente_filosofia = '';

                        $fisica_asistencias = 0;
                        $fisica_seguimientos = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_totalcurso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $docente_fisica = '';

                        $geografia_asistencias = 0;
                        $geografia_seguimientos = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_totalcurso = 0;
                        $item_huerfano_geografia = 0;
                        $courseid_geografia = 0;
                        $docente_geografia = '';

                        $historia_asistencias = 0;
                        $historia_seguimientos = 0;
                        $historia_autoevaluacion = 0;
                        $historia_totalcurso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $docente_historia = '';

                        $ingles_asistencias = 0;
                        $ingles_seguimientos = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_totalcurso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $docente_ingles = '';

                        $lectura_asistencias = 0;
                        $lectura_seguimientos = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_totalcurso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $docente_lectura = '';

                        $matematicas_asistencias = 0;
                        $matematicas_seguimientos = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_totalcurso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $docente_matematicas = '';

                        $quimica_asistencias = 0;
                        $quimica_seguimientos = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_totalcurso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $docente_quimica = '';

                        $tic_asistencias = 0;
                        $tic_seguimientos = 0;
                        $tic_autoevaluacion = 0;
                        $tic_totalcurso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        $docente_tic = '';
                        //dd($estudiante->asignaturas);
                        foreach((array)$estudiante->asignaturas as $cursos){
                            $cursos->fullname = explode('-',$cursos->fullname)[0];
                            //dd($cursos);
                            switch ($cursos->fullname) {
                                case 'JORNADAS DE ACCION CIUDADANA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $accionciudadana_asistencias = $cursos->grade;
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
                                    $docente_accion_ciudadana = $cursos->docente_name;
                                    break;

                                case 'ARTES: CONOCIMIENTO EN ACCION ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $artes_asistencias = $cursos->grade;
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
                                    $docente_artes = $cursos->docente_name;
                                    break;

                                case 'BIOLOGIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $biologia_asistencias = $cursos->grade;
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
                                    $docente_biologia = $cursos->docente_name;
                                    break;

                                case 'CULTURA DEMOCRATICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $cultura_asistencias = $cursos->grade;
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
                                    $docente_cultura = $cursos->docente_name;
                                    break;

                                case 'DEPORTE Y SALUD INTEGRAL ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $deporte_asistencias = $cursos->grade;
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
                                    $docente_deporte = $cursos->docente_name;
                                    break;

                                case 'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $dialogo_asistencias = $cursos->grade;
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
                                    $docente_dialogo = $cursos->docente_name;
                                    break;

                                case 'FILOSOFIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $filosofia_asistencias = $cursos->grade;
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
                                    $docente_filosofia = $cursos->docente_name;
                                    break;

                                case 'FISICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $fisica_asistencias = $cursos->grade;
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
                                    $docente_fisica = $cursos->docente_name;
                                    break;

                                case 'GEOGRAFIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $geografia_asistencias = $cursos->grade;
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
                                    $docente_geografia = $cursos->docente_name;
                                    break;

                                case 'HISTORIA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $historia_asistencias = $cursos->grade;
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
                                    $docente_historia = $cursos->docente_name;
                                    break;

                                case 'INGLES ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $ingles_asistencias = $cursos->grade;
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
                                    $docente_ingles = $cursos->docente_name;
                                    break;                               
                                case 'LECTURA CRITICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $lectura_asistencias = $cursos->grade;
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
                                    $docente_lectura = $cursos->docente_name;
                                    break;

                                case 'MATEMATICAS ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $matematicas_asistencias = $cursos->grade;
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
                                    $docente_matematicas = $cursos->docente_name;
                                    break;                          

                                case 'QUIMICA ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $quimica_asistencias = $cursos->grade;
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
                                    $docente_quimica = $cursos->docente_name;
                                    break;

                                case 'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES ':
                                    if ((strpos($cursos->category_name, 'Asistencia') !== false) || (strpos($cursos->category_name, 'asistencia') !== false) || (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                        
                                        $tic_asistencias = $cursos->grade;
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
                                    $docente_tic = $cursos->docente_name;
                                    break;
                                default:                                        
                                    echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADO";
                                    break;
                            }
                        }
                        unset($estudiante->asignaturas);
                        $estudiante->accionciudadana_asistencia = $accionciudadana_asistencias;
                        $estudiante->accionciudadana_seguimientos = $accionciudadana_seguimientos;
                        $estudiante->accionciudadana_autoevaluacion = $accionciudadana_autoevaluacion;
                        $estudiante->accionciudadana_totalcurso = $accionciudadana_totalcurso;
                        $estudiante->accionciudadana_item_huerfano = $item_huerfano_accion_ciudadana;
                        $estudiante->courseid_accion_ciudadana = $courseid_accion_ciudadana;
                        $estudiante->docente_accion_ciudadana = $docente_accion_ciudadana;

                        $estudiante->artes_asistencias = $artes_asistencias;
                        $estudiante->artes_seguimientos = $artes_seguimientos;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_totalcurso = $artes_totalcurso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->courseid_artes = $courseid_artes;
                        $estudiante->docente_artes = $docente_artes;

                        $estudiante->biologia_asistencias = $biologia_asistencias;
                        $estudiante->biologia_seguimientos = $biologia_seguimientos;
                        $estudiante->biologia_autoevaluacion = $biologia_autoevaluacion;
                        $estudiante->biologia_totalcurso = $biologia_totalcurso;
                        $estudiante->biologia_item_huerfano = $item_huerfano_biologia;
                        $estudiante->courseid_biologia = $courseid_biologia;
                        $estudiante->docente_biologia = $docente_biologia;

                        $estudiante->cultura_asistencias = $cultura_asistencias;
                        $estudiante->cultura_seguimientos = $cultura_seguimientos;
                        $estudiante->cultura_autoevaluacion = $cultura_autoevaluacion;
                        $estudiante->cultura_totalcurso = $cultura_totalcurso;
                        $estudiante->cultura_item_huerfano = $item_huerfano_cultura;
                        $estudiante->courseid_cultura = $courseid_cultura;
                        $estudiante->docente_cultura = $docente_cultura;

                        $estudiante->deporte_asistencias = $deporte_asistencias;
                        $estudiante->deporte_seguimientos = $deporte_seguimientos;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_totalcurso = $deporte_totalcurso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->courseid_deporte = $courseid_deporte;
                        $estudiante->docente_deporte = $docente_deporte;

                        $estudiante->dialogo_asistencias = $dialogo_asistencias;
                        $estudiante->dialogo_seguimientos = $dialogo_seguimientos;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_totalcurso = $dialogo_totalcurso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->courseid_dialogo = $courseid_dialogo;
                        $estudiante->docente_dialogo = $docente_dialogo;

                        $estudiante->filosofia_asistencias = $filosofia_asistencias;
                        $estudiante->filosofia_seguimientos = $filosofia_seguimientos;
                        $estudiante->filosofia_autoevaluacion = $filosofia_autoevaluacion;
                        $estudiante->filosofia_totalcurso = $filosofia_totalcurso;
                        $estudiante->filosofia_item_huerfano = $item_huerfano_filosofia;
                        $estudiante->courseid_filosofia = $courseid_filosofia;
                        $estudiante->docente_filosofia = $docente_filosofia;

                        $estudiante->fisica_asistencias = $fisica_asistencias;
                        $estudiante->fisica_seguimientos = $fisica_seguimientos;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_totalcurso = $fisica_totalcurso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->courseid_fisica = $courseid_fisica;
                        $estudiante->docente_fisica = $docente_fisica;

                        $estudiante->geografia_asistencias = $geografia_asistencias;
                        $estudiante->geografia_seguimientos = $geografia_seguimientos;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_totalcurso = $geografia_totalcurso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                        $estudiante->courseid_geografia = $courseid_geografia;
                        $estudiante->docente_geografia = $docente_geografia;

                        $estudiante->historia_asistencias = $historia_asistencias;
                        $estudiante->historia_seguimientos = $historia_seguimientos;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_totalcurso = $historia_totalcurso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->courseid_historia = $courseid_historia;
                        $estudiante->docente_historia = $docente_historia;

                        $estudiante->ingles_asistencias = $ingles_asistencias;
                        $estudiante->ingles_seguimientos = $ingles_seguimientos;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_totalcurso = $ingles_totalcurso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->courseid_ingles = $courseid_ingles;
                        $estudiante->docente_ingles = $docente_ingles;

                        $estudiante->lectura_asistencias = $lectura_asistencias;
                        $estudiante->lectura_seguimientos = $lectura_seguimientos;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_totalcurso = $lectura_totalcurso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->courseid_lectura = $courseid_lectura;
                        $estudiante->docente_lectura = $docente_lectura;

                        $estudiante->matematicas_asistencias = $matematicas_asistencias;
                        $estudiante->matematicas_seguimientos = $matematicas_seguimientos;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_totalcurso = $matematicas_totalcurso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->courseid_matematicas = $courseid_matematicas;
                        $estudiante->docente_matematicas = $docente_matematicas;

                        $estudiante->quimica_asistencias = $quimica_asistencias;
                        $estudiante->quimica_seguimientos = $quimica_seguimientos;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_totalcurso = $quimica_totalcurso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->courseid_quimica = $courseid_quimica;
                        $estudiante->docente_quimica = $docente_quimica;

                        $estudiante->tic_asistencias = $tic_asistencias;
                        $estudiante->tic_seguimientos = $tic_seguimientos;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_totalcurso = $tic_totalcurso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->courseid_tic = $courseid_tic;
                        $estudiante->docente_tic = $docente_tic;
                        //dd($estudiante);
                    });
                return datatables()->of($estudiantes)->toJson();
        }      
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
    
    public function notas_linea_2($user, $token){
        $prueba = User::select('id')->where('email', $user)->where('check_lave', $token)->exists();
        //dd($prueba);
        if($prueba){
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
                        $docente_biologia = '';

                        $artes_asistencia = 0;
                        $artes_seguimiento_academico = 0;
                        $artes_autoevaluacion = 0;
                        $artes_total_curso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $docente_artes = '';

                        $deporte_asistencia = 0;
                        $deporte_seguimiento_academico = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_total_curso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $docente_deporte = '';

                        $dialogo_asistencia = 0;
                        $dialogo_seguimiento_academico = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_total_curso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $docente_dialogo = '';

                        $constitucion_asistencia = 0;
                        $constitucion_seguimiento_academico = 0;
                        $constitucion_autoevaluacion = 0;
                        $constitucion_total_curso = 0;
                        $item_huerfano_constitucion = 0;
                        $courseid_constitucion = 0;
                        $docente_constitucion = '';

                        $fisica_asistencia = 0;
                        $fisica_seguimiento_academico = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_total_curso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $docente_fisica = '';

                        $geografia_asistencia = 0;
                        $geografia_seguimiento_academico = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_total_curso = 0;
                        $item_huerfano_grografia = 0;
                        $courseid_geografia = 0;
                        $docente_geografia = '';

                        $historia_asistencia = 0;
                        $historia_seguimiento_academico = 0;
                        $historia_autoevaluacion = 0;
                        $historia_total_curso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $docente_historia = '';

                        $ingles_asistencia = 0;
                        $ingles_seguimiento_academico = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_total_curso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $docente_ingles = '';

                        $lectura_asistencia = 0;
                        $lectura_seguimiento_academico = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_total_curso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $docente_lectura = '';

                        $matematicas_asistencia = 0;
                        $matematicas_seguimiento_academico = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_total_curso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $docente_matematicas = '';

                        $quimica_asistencia = 0;
                        $quimica_seguimiento_academico = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_total_curso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $docente_quimica = '';

                        $tic_asistencia = 0;
                        $tic_seguimiento_academico = 0;
                        $tic_autoevaluacion = 0;
                        $tic_total_curso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        $docente_tic = '';
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
                                    $docente_biologia = $cursos->docente_name;
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
                                    $docente_artes = $cursos->docente_name;
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
                                    $docente_deporte = $cursos->docente_name;
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
                                    $docente_dialogo = $cursos->docente_name;
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
                                    $docente_constitucion = $cursos->docente_name;
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
                                    $docente_fisica = $cursos->docente_name;
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
                                    $docente_geografia = $cursos->docente_name;
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
                                    $docente_historia = $cursos->docente_name;
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
                                    $docente_ingles = $cursos->docente_name;
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
                                    $docente_lectura = $cursos->docente_name;
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
                                    $docente_matematicas = $cursos->docente_name;
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
                                    $docente_quimica = $cursos->docente_name;
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
                                    $docente_tic = $cursos->docente_name;
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
                        $estudiante->docente_biologia = $docente_biologia;
                        $estudiante->artes_asistencia = $artes_asistencia;
                        $estudiante->artes_seguimiento_academico = $artes_seguimiento_academico;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_total_curso = $artes_total_curso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->artes_course_id = $courseid_artes;
                        $estudiante->docente_artes = $docente_artes;
                        $estudiante->deporte_asistencia = $deporte_asistencia;
                        $estudiante->deporte_seguimiento_academico = $deporte_seguimiento_academico;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_total_curso = $deporte_total_curso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->deporte_course_id = $courseid_deporte;
                        $estudiante->docente_deporte = $docente_deporte;
                        $estudiante->dialogo_asistencia = $dialogo_asistencia;
                        $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_total_curso = $dialogo_total_curso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->dialogo_course_id = $courseid_dialogo;
                        $estudiante->docente_dialogo = $docente_dialogo;
                        $estudiante->constitucion_asistencia = $constitucion_asistencia;
                        $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                        $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                        $estudiante->constitucion_total_curso = $constitucion_total_curso;
                        $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                        $estudiante->constitucion_course_id = $courseid_constitucion;
                        $estudiante->docente_constitucion = $docente_constitucion;
                        $estudiante->fisica_asistencia = $fisica_asistencia;
                        $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_total_curso = $fisica_total_curso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->fisica_course_id = $courseid_fisica;
                        $estudiante->docente_fisica = $docente_fisica;
                        $estudiante->geografia_asistencia = $geografia_asistencia;
                        $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_total_curso = $geografia_total_curso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_grografia;
                        $estudiante->geografia_course_id = $courseid_geografia;
                        $estudiante->docente_geografia = $docente_geografia;
                        $estudiante->historia_asistencia = $historia_asistencia;
                        $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_total_curso = $historia_total_curso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->historia_course_id = $courseid_historia;
                        $estudiante->docente_historia = $docente_historia;
                        $estudiante->ingles_asistencia = $ingles_asistencia;
                        $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_total_curso = $ingles_total_curso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->ingles_course_id = $courseid_ingles;
                        $estudiante->docente_ingles = $docente_ingles;
                        $estudiante->lectura_asistencia = $lectura_asistencia;
                        $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_total_curso = $lectura_total_curso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->lectura_course_id = $courseid_lectura;
                        $estudiante->docente_lectura = $docente_lectura;
                        $estudiante->matematicas_asistencia = $matematicas_asistencia;
                        $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_total_curso = $matematicas_total_curso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->matematicas_course_id = $courseid_matematicas;
                        $estudiante->docente_matematicas = $docente_matematicas;
                        $estudiante->quimica_asistencia = $quimica_asistencia;
                        $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_total_curso = $quimica_total_curso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->quimica_course_id = $courseid_quimica;
                        $estudiante->docente_quimica = $docente_quimica;
                        $estudiante->tic_asistencia = $tic_asistencia;
                        $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_total_curso = $tic_total_curso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->tic_course_id = $courseid_tic;
                        $estudiante->docente_tic = $docente_tic;
                        unset($estudiante->asignaturas);
                        //dd($estudiante);
                    });
                //dd($estudiantes);
                
                return datatables()->of($estudiantes)->toJson();
        }else{

            $estudiantes_linea2 = perfilEstudiante::Estudiantes_cohort_linea2();
            $estudiantes = collect($estudiantes_linea2);
            //dd($estudiantes);

            $estudiantes->map(function($estudiante){
                $estudiante->asignaturas = CourseMoodle::asignaturas($estudiante->grupo, $estudiante->id_moodle);
                //dd($estudiante);   
            });

            $estudiantes_notas = json_encode($estudiantes);
            Storage::disk('local')->put('notas_linea_2.json', $estudiantes_notas);
            $notas = json_decode($estudiantes_notas);

            $estudiantes_notas_linea2 = collect($notas);

            $estudiantes_notas_linea2->map(function($estudiante){
                        $biologia_asistencia = 0;
                        $biologia_seguimiento_academico = 0;
                        $biologia_autoevaluacion = 0;
                        $biologia_total_curso = 0;
                        $item_huerfano_biologia = 0;
                        $courseid_biologia = 0;
                        $docente_biologia = '';

                        $artes_asistencia = 0;
                        $artes_seguimiento_academico = 0;
                        $artes_autoevaluacion = 0;
                        $artes_total_curso = 0;
                        $item_huerfano_artes = 0;
                        $courseid_artes = 0;
                        $docente_artes = '';

                        $deporte_asistencia = 0;
                        $deporte_seguimiento_academico = 0;
                        $deporte_autoevaluacion = 0;
                        $deporte_total_curso = 0;
                        $item_huerfano_deporte = 0;
                        $courseid_deporte = 0;
                        $docente_deporte = '';

                        $dialogo_asistencia = 0;
                        $dialogo_seguimiento_academico = 0;
                        $dialogo_autoevaluacion = 0;
                        $dialogo_total_curso = 0;
                        $item_huerfano_dialogo = 0;
                        $courseid_dialogo = 0;
                        $docente_dialogo = '';

                        $constitucion_asistencia = 0;
                        $constitucion_seguimiento_academico = 0;
                        $constitucion_autoevaluacion = 0;
                        $constitucion_total_curso = 0;
                        $item_huerfano_constitucion = 0;
                        $courseid_constitucion = 0;
                        $docente_constitucion = '';

                        $fisica_asistencia = 0;
                        $fisica_seguimiento_academico = 0;
                        $fisica_autoevaluacion = 0;
                        $fisica_total_curso = 0;
                        $item_huerfano_fisica = 0;
                        $courseid_fisica = 0;
                        $docente_fisica = '';

                        $geografia_asistencia = 0;
                        $geografia_seguimiento_academico = 0;
                        $geografia_autoevaluacion = 0;
                        $geografia_total_curso = 0;
                        $item_huerfano_grografia = 0;
                        $courseid_geografia = 0;
                        $docente_geografia = '';

                        $historia_asistencia = 0;
                        $historia_seguimiento_academico = 0;
                        $historia_autoevaluacion = 0;
                        $historia_total_curso = 0;
                        $item_huerfano_historia = 0;
                        $courseid_historia = 0;
                        $docente_historia = '';

                        $ingles_asistencia = 0;
                        $ingles_seguimiento_academico = 0;
                        $ingles_autoevaluacion = 0;
                        $ingles_total_curso = 0;
                        $item_huerfano_ingles = 0;
                        $courseid_ingles = 0;
                        $docente_ingles = '';

                        $lectura_asistencia = 0;
                        $lectura_seguimiento_academico = 0;
                        $lectura_autoevaluacion = 0;
                        $lectura_total_curso = 0;
                        $item_huerfano_lectura = 0;
                        $courseid_lectura = 0;
                        $docente_lectura = '';

                        $matematicas_asistencia = 0;
                        $matematicas_seguimiento_academico = 0;
                        $matematicas_autoevaluacion = 0;
                        $matematicas_total_curso = 0;
                        $item_huerfano_matematicas = 0;
                        $courseid_matematicas = 0;
                        $docente_matematicas = '';

                        $quimica_asistencia = 0;
                        $quimica_seguimiento_academico = 0;
                        $quimica_autoevaluacion = 0;
                        $quimica_total_curso = 0;
                        $item_huerfano_quimica = 0;
                        $courseid_quimica = 0;
                        $docente_quimica = '';

                        $tic_asistencia = 0;
                        $tic_seguimiento_academico = 0;
                        $tic_autoevaluacion = 0;
                        $tic_total_curso = 0;
                        $item_huerfano_tic = 0;
                        $courseid_tic = 0;
                        $docente_tic = '';
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
                                    $docente_biologia = $cursos->docente_name;
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
                                    $docente_artes = $cursos->docente_name;
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
                                    $docente_deporte = $cursos->docente_name;
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
                                    $docente_dialogo = $cursos->docente_name;
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
                                    $docente_constitucion = $cursos->docente_name;
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
                                    $docente_fisica = $cursos->docente_name;
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
                                    $docente_geografia = $cursos->docente_name;
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
                                    $docente_historia = $cursos->docente_name;
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
                                    $docente_ingles = $cursos->docente_name;
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
                                    $docente_lectura = $cursos->docente_name;
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
                                    $docente_matematicas = $cursos->docente_name;
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
                                    $docente_quimica = $cursos->docente_name;
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
                                    $docente_tic = $cursos->docente_name;
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
                        $estudiante->docente_biologia = $docente_biologia;
                        $estudiante->artes_asistencia = $artes_asistencia;
                        $estudiante->artes_seguimiento_academico = $artes_seguimiento_academico;
                        $estudiante->artes_autoevaluacion = $artes_autoevaluacion;
                        $estudiante->artes_total_curso = $artes_total_curso;
                        $estudiante->artes_item_huerfano = $item_huerfano_artes;
                        $estudiante->artes_course_id = $courseid_artes;
                        $estudiante->docente_artes = $docente_artes;
                        $estudiante->deporte_asistencia = $deporte_asistencia;
                        $estudiante->deporte_seguimiento_academico = $deporte_seguimiento_academico;
                        $estudiante->deporte_autoevaluacion = $deporte_autoevaluacion;
                        $estudiante->deporte_total_curso = $deporte_total_curso;
                        $estudiante->deporte_item_huerfano = $item_huerfano_deporte;
                        $estudiante->deporte_course_id = $courseid_deporte;
                        $estudiante->docente_deporte = $docente_deporte;
                        $estudiante->dialogo_asistencia = $dialogo_asistencia;
                        $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                        $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                        $estudiante->dialogo_total_curso = $dialogo_total_curso;
                        $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                        $estudiante->dialogo_course_id = $courseid_dialogo;
                        $estudiante->docente_dialogo = $docente_dialogo;
                        $estudiante->constitucion_asistencia = $constitucion_asistencia;
                        $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                        $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                        $estudiante->constitucion_total_curso = $constitucion_total_curso;
                        $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                        $estudiante->constitucion_course_id = $courseid_constitucion;
                        $estudiante->docente_constitucion = $docente_constitucion;
                        $estudiante->fisica_asistencia = $fisica_asistencia;
                        $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                        $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                        $estudiante->fisica_total_curso = $fisica_total_curso;
                        $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                        $estudiante->fisica_course_id = $courseid_fisica;
                        $estudiante->docente_fisica = $docente_fisica;
                        $estudiante->geografia_asistencia = $geografia_asistencia;
                        $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                        $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                        $estudiante->geografia_total_curso = $geografia_total_curso;
                        $estudiante->geografia_item_huerfano = $item_huerfano_grografia;
                        $estudiante->geografia_course_id = $courseid_geografia;
                        $estudiante->docente_geografia = $docente_geografia;
                        $estudiante->historia_asistencia = $historia_asistencia;
                        $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                        $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                        $estudiante->historia_total_curso = $historia_total_curso;
                        $estudiante->historia_item_huerfano = $item_huerfano_historia;
                        $estudiante->historia_course_id = $courseid_historia;
                        $estudiante->docente_historia = $docente_historia;
                        $estudiante->ingles_asistencia = $ingles_asistencia;
                        $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                        $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                        $estudiante->ingles_total_curso = $ingles_total_curso;
                        $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                        $estudiante->ingles_course_id = $courseid_ingles;
                        $estudiante->docente_ingles = $docente_ingles;
                        $estudiante->lectura_asistencia = $lectura_asistencia;
                        $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                        $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                        $estudiante->lectura_total_curso = $lectura_total_curso;
                        $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                        $estudiante->lectura_course_id = $courseid_lectura;
                        $estudiante->docente_lectura = $docente_lectura;
                        $estudiante->matematicas_asistencia = $matematicas_asistencia;
                        $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                        $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                        $estudiante->matematicas_total_curso = $matematicas_total_curso;
                        $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                        $estudiante->matematicas_course_id = $courseid_matematicas;
                        $estudiante->docente_matematicas = $docente_matematicas;
                        $estudiante->quimica_asistencia = $quimica_asistencia;
                        $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                        $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                        $estudiante->quimica_total_curso = $quimica_total_curso;
                        $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                        $estudiante->quimica_course_id = $courseid_quimica;
                        $estudiante->docente_quimica = $docente_quimica;
                        $estudiante->tic_asistencia = $tic_asistencia;
                        $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                        $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                        $estudiante->tic_total_curso = $tic_total_curso;
                        $estudiante->tic_item_huerfano = $item_huerfano_tic;
                        $estudiante->tic_course_id = $courseid_tic;
                        $estudiante->docente_tic = $docente_tic;
                        unset($estudiante->asignaturas);
                        //dd($estudiante);
                    });
                //dd($estudiantes);
                
                return datatables()->of($estudiantes)->toJson();
        }  
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function notas_linea_3($user, $token){
        $prueba = User::select('id')->where('email', $user)->where('check_lave', $token)->exists();
        if($prueba){
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
                $docente_biologia = '';

                $constitucion_asistencia = 0;
                $constitucion_seguimiento_academico = 0;
                $constitucion_autoevaluacion = 0;
                $constitucion_total_curso = 0;
                $item_huerfano_constitucion = 0;
                $courseid_constitucion = 0;
                $docente_constitucion = '';

                $fisica_asistencia = 0;
                $fisica_seguimiento_academico = 0;
                $fisica_autoevaluacion = 0;
                $fisica_total_curso = 0;
                $item_huerfano_fisica = 0;
                $courseid_fisica = 0;
                $docente_fisica = '';

                $geografia_asistencia = 0;
                $geografia_seguimiento_academico = 0;
                $geografia_autoevaluacion = 0;
                $geografia_total_curso = 0;
                $item_huerfano_geografia = 0;
                $courseid_geografia = 0;
                $docente_geografia = '';
                
                $historia_asistencia = 0;
                $historia_seguimiento_academico = 0;
                $historia_autoevaluacion = 0;
                $historia_total_curso = 0;
                $item_huerfano_historia = 0;
                $courseid_historia = 0;
                $docente_historia = '';

                $ingles_asistencia = 0;
                $ingles_seguimiento_academico = 0;
                $ingles_autoevaluacion = 0;
                $ingles_total_curso = 0;
                $item_huerfano_ingles = 0;
                $courseid_ingles = 0;
                $docente_ingles = '';

                $lectura_asistencia = 0;
                $lectura_seguimiento_academico = 0;
                $lectura_autoevaluacion = 0;
                $lectura_total_curso = 0;
                $item_huerfano_lectura = 0;
                $courseid_lectura = 0;
                $docente_lectura = '';

                $matematicas_asistencia = 0;
                $matematicas_seguimiento_academico = 0;
                $matematicas_autoevaluacion = 0;
                $matematicas_total_curso = 0;
                $item_huerfano_matematicas = 0;
                $courseid_matematicas = 0;
                $docente_matematicas = '';

                $quimica_asistencia = 0;
                $quimica_seguimiento_academico = 0;
                $quimica_autoevaluacion = 0;
                $quimica_total_curso = 0;
                $item_huerfano_quimica = 0;
                $courseid_quimica = 0;
                $docente_quimica = '';

                $tic_asistencia = 0;
                $tic_seguimiento_academico = 0;
                $tic_autoevaluacion = 0;
                $tic_total_curso = 0;
                $item_huerfano_tic = 0;
                $courseid_tic = 0;
                $docente_tic = '';

                $dialogo_asistencia = 0;
                $dialogo_seguimiento_academico = 0;
                $dialogo_autoevaluacion = 0;
                $dialogo_total_curso = 0;
                $item_huerfano_dialogo = 0;
                $courseid_dialogo = 0;
                $docente_dialogo = '';

                $practica_asistencia = 0;
                $practica_seguimiento_academico = 0;
                $practica_autoevaluacion = 0;
                $practica_total_curso = 0;
                $item_huerfano_practica = 0;
                $courseid_practica = 0;
                $docente_practica = '';

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
                            $docente_biologia = $cursos->docente_name;
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
                            $docente_constitucion = $cursos->docente_name;
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
                            $docente_fisica = $cursos->docente_name;
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
                            $docente_geografia = $cursos->docente_name;
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
                            $docente_historia = $cursos->docente_name;
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
                            $docente_ingles = $cursos->docente_name;
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
                            $docente_lectura = $cursos->docente_name;
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
                            $docente_matematicas = $cursos->docente_name;
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
                            $docente_quimica = $cursos->docente_name;
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
                            $docente_tic = $cursos->docente_name;
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
                            $docente_dialogo = $cursos->docente_name;
                        break;
                        case 'PRACTICAS ARTISTICAS Y HORIZONTE SOCIO OCUPACIONAL ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $practica_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $practica_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $practica_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $practica_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_practica += 1;
                            }
                            $courseid_practica = $cursos->id;
                            $docente_practica = $cursos->docente_name;
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
                $estudiante->biologia_course_id = $courseid_biologia;
                $estudiante->docente_biologia = $docente_biologia;
                $estudiante->constitucion_asistencia = $constitucion_asistencia;
                $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                $estudiante->constitucion_total_curso = $constitucion_total_curso;
                $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                $estudiante->constitucion_course_id = $courseid_constitucion;
                $estudiante->docente_constitucion = $docente_constitucion;
                $estudiante->fisica_asistencia = $fisica_asistencia;
                $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                $estudiante->fisica_total_curso = $fisica_total_curso;
                $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                $estudiante->fisica_course_id = $courseid_fisica;
                $estudiante->docente_fisica = $docente_fisica;
                $estudiante->geografia_asistencia = $geografia_asistencia;
                $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                $estudiante->geografia_total_curso = $geografia_total_curso;
                $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                $estudiante->geografia_course_id = $courseid_geografia;
                $estudiante->docente_geografia = $docente_geografia;
                $estudiante->historia_asistencia = $historia_asistencia;
                $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                $estudiante->historia_total_curso = $historia_total_curso;
                $estudiante->historia_item_huerfano = $item_huerfano_historia;
                $estudiante->historia_course_id = $courseid_historia;
                $estudiante->docente_historia = $docente_historia;
                $estudiante->ingles_asistencia = $ingles_asistencia;
                $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                $estudiante->ingles_total_curso = $ingles_total_curso;
                $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                $estudiante->ingles_course_id = $courseid_ingles;
                $estudiante->docente_ingles = $docente_ingles;
                $estudiante->lectura_asistencia = $lectura_asistencia;
                $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                $estudiante->lectura_total_curso = $lectura_total_curso;
                $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                $estudiante->lectura_course_id = $courseid_lectura;
                $estudiante->docente_lectura = $docente_lectura;
                $estudiante->matematicas_asistencia = $matematicas_asistencia;
                $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                $estudiante->matematicas_total_curso = $matematicas_total_curso;
                $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                $estudiante->matematicas_course_id = $courseid_matematicas;
                $estudiante->docente_matematicas = $docente_matematicas;
                $estudiante->quimica_asistencia = $quimica_asistencia;
                $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                $estudiante->quimica_total_curso = $quimica_total_curso;
                $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                $estudiante->quimica_course_id = $courseid_quimica;
                $estudiante->docente_quimica = $docente_quimica;
                $estudiante->tic_asistencia = $tic_asistencia;
                $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                $estudiante->tic_total_curso = $tic_total_curso;
                $estudiante->tic_item_huerfano = $item_huerfano_tic;
                $estudiante->tic_course_id = $courseid_tic;
                $estudiante->docente_tic = $docente_tic;
                $estudiante->dialogo_asistencia = $dialogo_asistencia;
                $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                $estudiante->dialogo_total_curso = $dialogo_total_curso;
                $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                $estudiante->dialogo_course_id = $courseid_dialogo;
                $estudiante->docente_dialogo = $docente_dialogo;
                $estudiante->practica_asistencia = $practica_asistencia;
                $estudiante->practica_seguimiento_academico = $practica_seguimiento_academico;
                $estudiante->practica_autoevaluacion = $practica_autoevaluacion;
                $estudiante->practica_total_curso = $practica_total_curso;
                $estudiante->practica_item_huerfano = $item_huerfano_practica;
                $estudiante->practica_course_id = $courseid_practica;
                $estudiante->docente_practica = $docente_practica;
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
                $courseid_biologia = 0;
                $docente_biologia = '';

                $constitucion_asistencia = 0;
                $constitucion_seguimiento_academico = 0;
                $constitucion_autoevaluacion = 0;
                $constitucion_total_curso = 0;
                $item_huerfano_constitucion = 0;
                $courseid_constitucion = 0;
                $docente_constitucion = '';

                $fisica_asistencia = 0;
                $fisica_seguimiento_academico = 0;
                $fisica_autoevaluacion = 0;
                $fisica_total_curso = 0;
                $item_huerfano_fisica = 0;
                $courseid_fisica = 0;
                $docente_fisica = '';

                $geografia_asistencia = 0;
                $geografia_seguimiento_academico = 0;
                $geografia_autoevaluacion = 0;
                $geografia_total_curso = 0;
                $item_huerfano_geografia = 0;
                $courseid_geografia = 0;
                $docente_geografia = '';
                
                $historia_asistencia = 0;
                $historia_seguimiento_academico = 0;
                $historia_autoevaluacion = 0;
                $historia_total_curso = 0;
                $item_huerfano_historia = 0;
                $courseid_historia = 0;
                $docente_historia = '';

                $ingles_asistencia = 0;
                $ingles_seguimiento_academico = 0;
                $ingles_autoevaluacion = 0;
                $ingles_total_curso = 0;
                $item_huerfano_ingles = 0;
                $courseid_ingles = 0;
                $docente_ingles = '';

                $lectura_asistencia = 0;
                $lectura_seguimiento_academico = 0;
                $lectura_autoevaluacion = 0;
                $lectura_total_curso = 0;
                $item_huerfano_lectura = 0;
                $courseid_lectura = 0;
                $docente_lectura = '';

                $matematicas_asistencia = 0;
                $matematicas_seguimiento_academico = 0;
                $matematicas_autoevaluacion = 0;
                $matematicas_total_curso = 0;
                $item_huerfano_matematicas = 0;
                $courseid_matematicas = 0;
                $docente_matematicas = '';

                $quimica_asistencia = 0;
                $quimica_seguimiento_academico = 0;
                $quimica_autoevaluacion = 0;
                $quimica_total_curso = 0;
                $item_huerfano_quimica = 0;
                $courseid_quimica = 0;
                $docente_quimica = '';

                $tic_asistencia = 0;
                $tic_seguimiento_academico = 0;
                $tic_autoevaluacion = 0;
                $tic_total_curso = 0;
                $item_huerfano_tic = 0;
                $courseid_tic = 0;
                $docente_tic = '';

                $dialogo_asistencia = 0;
                $dialogo_seguimiento_academico = 0;
                $dialogo_autoevaluacion = 0;
                $dialogo_total_curso = 0;
                $item_huerfano_dialogo = 0;
                $courseid_dialogo = 0;
                $docente_dialogo = '';

                $practica_asistencia = 0;
                $practica_seguimiento_academico = 0;
                $practica_autoevaluacion = 0;
                $practica_total_curso = 0;
                $item_huerfano_practica = 0;
                $courseid_practica = 0;
                $docente_practica = '';

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
                            $docente_biologia = $cursos->docente_name;
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
                            $docente_constitucion = $cursos->docente_name;
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
                            $docente_fisica = $cursos->docente_name;
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
                            $docente_geografia = $cursos->docente_name;
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
                            $docente_historia = $cursos->docente_name;
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
                            $docente_ingles = $cursos->docente_name;
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
                            $docente_lectura = $cursos->docente_name;
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
                            $docente_matematicas = $cursos->docente_name;
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
                            $docente_quimica = $cursos->docente_name;
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
                            $docente_tic = $cursos->docente_name;
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
                            $docente_dialogo = $cursos->docente_name;
                        break;
                        case 'PRACTICAS ARTISTICAS Y HORIZONTE SOCIO OCUPACIONAL ':
                            if((strpos($cursos->category_name, 'Asistencia') !== false) || 
                                (strpos($cursos->category_name, 'asistencia') !== false) || 
                                (strpos($cursos->category_name, 'ASISTENCIA') !== false)) {
                                $practica_asistencia = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Actividades') !== false) ||
                                (strpos($cursos->category_name, 'COMPONENTE') !== false) || 
                                (strpos($cursos->category_name, 'PARCIALES') !== false) || 
                                (strpos($cursos->category_name, 'SEGUIMIENTO') !== false) || 
                                (strpos($cursos->category_name, 'seguimiento') !== false)) {
                                $practica_seguimiento_academico = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'Auto') !== false) ||
                                (strpos($cursos->category_name, 'AUTOEVALUACIÓN') !== false) 
                                || (strpos($cursos->category_name, 'AUTOEVALUCACIÓN') !== false)){
                                $practica_autoevaluacion = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'TOTAL') !== false)){
                                $practica_total_curso = $cursos->grade;
                            }
                            if((strpos($cursos->category_name, 'HUERFANO') !== false)){
                                $item_huerfano_practica += 1;
                            }
                            $courseid_practica = $cursos->id;
                            $docente_practica = $cursos->docente_name;
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
                $estudiante->biologia_course_id = $courseid_biologia;
                $estudiante->docente_biologia = $docente_biologia;
                $estudiante->constitucion_asistencia = $constitucion_asistencia;
                $estudiante->constitucion_seguimiento_academico = $constitucion_seguimiento_academico;
                $estudiante->constitucion_autoevaluacion = $constitucion_autoevaluacion;
                $estudiante->constitucion_total_curso = $constitucion_total_curso;
                $estudiante->constitucion_item_huerfano = $item_huerfano_constitucion;
                $estudiante->constitucion_course_id = $courseid_constitucion;
                $estudiante->docente_constitucion = $docente_constitucion;
                $estudiante->fisica_asistencia = $fisica_asistencia;
                $estudiante->fisica_seguimiento_academico = $fisica_seguimiento_academico;
                $estudiante->fisica_autoevaluacion = $fisica_autoevaluacion;
                $estudiante->fisica_total_curso = $fisica_total_curso;
                $estudiante->fisica_item_huerfano = $item_huerfano_fisica;
                $estudiante->fisica_course_id = $courseid_fisica;
                $estudiante->docente_fisica = $docente_fisica;
                $estudiante->geografia_asistencia = $geografia_asistencia;
                $estudiante->geografia_seguimiento_academico = $geografia_seguimiento_academico;
                $estudiante->geografia_autoevaluacion = $geografia_autoevaluacion;
                $estudiante->geografia_total_curso = $geografia_total_curso;
                $estudiante->geografia_item_huerfano = $item_huerfano_geografia;
                $estudiante->geografia_course_id = $courseid_geografia;
                $estudiante->docente_geografia = $docente_geografia;
                $estudiante->historia_asistencia = $historia_asistencia;
                $estudiante->historia_seguimiento_academico = $historia_seguimiento_academico;
                $estudiante->historia_autoevaluacion = $historia_autoevaluacion;
                $estudiante->historia_total_curso = $historia_total_curso;
                $estudiante->historia_item_huerfano = $item_huerfano_historia;
                $estudiante->historia_course_id = $courseid_historia;
                $estudiante->docente_historia = $docente_historia;
                $estudiante->ingles_asistencia = $ingles_asistencia;
                $estudiante->ingles_seguimiento_academico = $ingles_seguimiento_academico;
                $estudiante->ingles_autoevaluacion = $ingles_autoevaluacion;
                $estudiante->ingles_total_curso = $ingles_total_curso;
                $estudiante->ingles_item_huerfano = $item_huerfano_ingles;
                $estudiante->ingles_course_id = $courseid_ingles;
                $estudiante->docente_ingles = $docente_ingles;
                $estudiante->lectura_asistencia = $lectura_asistencia;
                $estudiante->lectura_seguimiento_academico = $lectura_seguimiento_academico;
                $estudiante->lectura_autoevaluacion = $lectura_autoevaluacion;
                $estudiante->lectura_total_curso = $lectura_total_curso;
                $estudiante->lectura_item_huerfano = $item_huerfano_lectura;
                $estudiante->lectura_course_id = $courseid_lectura;
                $estudiante->docente_lectura = $docente_lectura;
                $estudiante->matematicas_asistencia = $matematicas_asistencia;
                $estudiante->matematicas_seguimiento_academico = $matematicas_seguimiento_academico;
                $estudiante->matematicas_autoevaluacion = $matematicas_autoevaluacion;
                $estudiante->matematicas_total_curso = $matematicas_total_curso;
                $estudiante->matematicas_item_huerfano = $item_huerfano_matematicas;
                $estudiante->matematicas_course_id = $courseid_matematicas;
                $estudiante->docente_matematicas = $docente_matematicas;
                $estudiante->quimica_asistencia = $quimica_asistencia;
                $estudiante->quimica_seguimiento_academico = $quimica_seguimiento_academico;
                $estudiante->quimica_autoevaluacion = $quimica_autoevaluacion;
                $estudiante->quimica_total_curso = $quimica_total_curso;
                $estudiante->quimica_item_huerfano = $item_huerfano_quimica;
                $estudiante->quimica_course_id = $courseid_quimica;
                $estudiante->docente_quimica = $docente_quimica;
                $estudiante->tic_asistencia = $tic_asistencia;
                $estudiante->tic_seguimiento_academico = $tic_seguimiento_academico;
                $estudiante->tic_autoevaluacion = $tic_autoevaluacion;
                $estudiante->tic_total_curso = $tic_total_curso;
                $estudiante->tic_item_huerfano = $item_huerfano_tic;
                $estudiante->tic_course_id = $courseid_tic;
                $estudiante->docente_tic = $docente_tic;
                $estudiante->dialogo_asistencia = $dialogo_asistencia;
                $estudiante->dialogo_seguimiento_academico = $dialogo_seguimiento_academico;
                $estudiante->dialogo_autoevaluacion = $dialogo_autoevaluacion;
                $estudiante->dialogo_total_curso = $dialogo_total_curso;
                $estudiante->dialogo_item_huerfano = $item_huerfano_dialogo;
                $estudiante->dialogo_course_id = $courseid_dialogo;
                $estudiante->docente_dialogo = $docente_dialogo;
                $estudiante->practica_asistencia = $practica_asistencia;
                $estudiante->practica_seguimiento_academico = $practica_seguimiento_academico;
                $estudiante->practica_autoevaluacion = $practica_autoevaluacion;
                $estudiante->practica_total_curso = $practica_total_curso;
                $estudiante->practica_item_huerfano = $item_huerfano_practica;
                $estudiante->practica_course_id = $courseid_practica;
                $estudiante->docente_practica = $docente_practica;
                unset($estudiante->asignaturas);
                //dd($estudiante);
            });

            //dd($estudiantes);
            
            return datatables()->of($estudiantes)->toJson();
        }    
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);    
        }
    }
}
