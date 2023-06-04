<?php

namespace App\Http\Controllers;

use App\AssignmentStudent;
use App\SocioEducationalFollowUp;
use App\HealthCondition;
use App\AnswersSocioeducationalForm;
use App\perfilEstudiante;
use App\LogsCrudActions;
use App\UpdateInformation;
use App\Exports\SocioeducativoExport;
use App\User;
use App\StudentGroup;
use App\Group;
use App\Cohort;
use Response;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $asignacion = AssignmentStudent::ultimo_asignacion();
        $ultima_asignacion = $asignacion[0]->created_at; 
        
        return view('socioeducativo.index', compact('user', 'ultima_asignacion'));
    }

    public function DataJson(){
        
        $datosDeAsignacion = DB::select("SELECT assignment_students.id, 
        (SELECT student_profile.name FROM student_profile WHERE student_profile.id = assignment_students.id_student LIMIT 1) as name, 
        (SELECT student_profile.lastname FROM student_profile WHERE student_profile.id = assignment_students.id_student LIMIT 1) as lastname,
        (SELECT student_profile.document_number FROM student_profile WHERE student_profile.id = assignment_students.id_student LIMIT 1) as tipoDocumento,
         (SELECT student_profile.student_code FROM student_profile WHERE student_profile.id = assignment_students.id_student LIMIT 1) as codigo, 
         (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort LIMIT 1) FROM groups WHERE groups.id = student_groups.id_group LIMIT 1) FROM student_groups WHERE student_groups.id_student = assignment_students.id_student LIMIT 1) as grupo, 
         (SELECT users.name FROM users WHERE users.id = assignment_students.id_user LIMIT 1) as nameUser, (SELECT users.apellidos_user FROM users WHERE users.id = assignment_students.id_user LIMIT 1) as apellidosUser FROM assignment_students WHERE assignment_students.deleted_at IS NULL");
        
        /*
        $datosDeAsignacion = DB::select("SELECT assignment_students.id, 
        (SELECT student_profile.name FROM student_profile WHERE student_profile.id = assignment_students.id_student) as name, 
        (SELECT student_profile.lastname FROM student_profile WHERE student_profile.id = assignment_students.id_student) as lastname,
        (SELECT student_profile.document_number FROM student_profile WHERE student_profile.id = assignment_students.id_student) as tipoDocumento,
         (SELECT student_profile.student_code FROM student_profile WHERE student_profile.id = assignment_students.id_student) as codigo, 
         (SELECT (SELECT (SELECT cohorts.name FROM cohorts WHERE cohorts.id = groups.id_cohort) FROM groups WHERE groups.id = student_groups.id_group) FROM student_groups WHERE student_groups.id_student = assignment_students.id_student) as grupo, 
         (SELECT users.name FROM users WHERE users.id = assignment_students.id_user) as nameUser, (SELECT users.apellidos_user FROM users WHERE users.id = assignment_students.id_user) as apellidosUser FROM assignment_students WHERE assignment_students.deleted_at IS NULL");
           */
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
    
    public function store_seguimiento(Request $request)
    {

        $mensaje = 'Seguimiento creado correctamente';
        $error = 'no puede crear';
        $id = auth()->user();

        if ($request->ajax()) {

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']), 'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindiV']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacadE']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfamiL'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkeconoM']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuniC']), 'Observaciones' => ($request['textareobservaciones']), 'urlDocumento' => ($request['url_document'])];

            $horainicio = $arreglo['HoraInicio'];
            $horafin = $arreglo['HoraFin'];

            if ($horafin > $horainicio) {
                $validacionHora = 'true';
            } else {
                $validacionHora = 'false';
            }

            if ($arreglo['Individual'] != null && $arreglo['RiesgoIndividual'] != null) {

                $vlrndvdal = 'true';
            } else {
                $vlrndvdal = 'false';
            }

            if ($arreglo['Academico'] != null && $arreglo['RiesgoAcademico'] != null) {

                $vlracdmco = 'true';
            } else {
                $vlracdmco = 'false';
            }

            if ($arreglo['Familiar'] != null && $arreglo['RiesgoFamiliar'] != null) {

                $vlrfmlar = 'true';
            } else {
                $vlrfmlar = 'false';
            }

            if ($arreglo['Economico'] != null && $arreglo['RiesgoEconomico'] != null) {

                $vlrecnmco = 'true';
            } else {
                $vlrecnmco = 'false';
            }

            if ($arreglo['VidaUniversitariaYciudad'] != null && $arreglo['RiesgoUc'] != null) {

                $vlruyc = 'true';
            } else {
                $vlruyc = 'false';
            }



            if ($arreglo['fecha'] == null && $arreglo['Lugar'] == null && $arreglo['HoraInicio'] == null && $arreglo['HoraFin'] == null && $arreglo['Objetivos'] == null && $arreglo['Individual'] == null && $arreglo['RiesgoIndividual'] == null && $arreglo['Academico'] == null && $arreglo['RiesgoAcademico'] == null && $arreglo['Familiar'] == null && $arreglo['RiesgoFamiliar'] == null && $arreglo['Economico'] == null && $arreglo['RiesgoEconomico'] == null && $arreglo['VidaUniversitariaYciudad'] == null && $arreglo['RiesgoUc'] == null && $arreglo['Observaciones'] == null) {

                echo 'No es posible crear un seguimiento vacio';
            } else {

                if ($arreglo['fecha'] != null && $arreglo['Lugar'] != null && $arreglo['HoraInicio'] != null && $arreglo['HoraFin'] != null && $arreglo['Objetivos'] != null) {

                    if ($arreglo['Individual'] != null || $arreglo['Academico'] != null || $arreglo['Familiar'] != null || $arreglo['Economico'] != null || $arreglo['VidaUniversitariaYciudad'] != null) {

                        if ($vlrndvdal == 'true' && $vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {

                            if ($validacionHora == 'true') {
                                $guardar = json_encode($arreglo);
                                $datossegui = SocioEducationalFollowUp::create([
                                    'id_student'       => $request['id_student'],
                                    'id_user'          => $id['id'],
                                    'tracking_detail'  => $guardar,
                                ]);
                                return $mensaje;
                            } else {
                                echo 'La hora final debe ser mayor a la hora inicial';
                            }
                        } else {
                            if ($vlrndvdal == 'true') {
                                $indi = $arreglo['Individual'];
                                $riesgoindi = $arreglo['RiesgoIndividual'];

                                if ($vlracdmco == 'true' || $vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {
                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlruyc == 'true') {
                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //echo 'guarde 1 2 3 y 5';
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $datossegui = SocioEducationalFollowUp::create([
                                                    'id_student'       => $request['id_student'],
                                                    'id_user'          => $id['id'],
                                                    'tracking_detail'  => $guardar,
                                                ]);
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    } else {
                                        if ($vlracdmco == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 1 2 4 y 5';
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    // echo 'guarde 1 3 4 y 5';
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                    if ($arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //   echo 'guarde 1 2 3 y 4';
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlracdmco == 'true' && $vlrecnmco == 'true') {

                                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //     echo 'guarde 1 2 y 4';
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                    'id_student'       => $request['id_student'],
                                                                    'id_user'          => $id['id'],
                                                                    'tracking_detail'  => $guardar,
                                                                ]);
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //       echo 'guarde 1 3 y 4';
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui =
                                                                        SocioEducationalFollowUp::create([
                                                                            'id_student'       => $request['id_student'],
                                                                            'id_user'          => $id['id'],
                                                                            'tracking_detail'  => $guardar,
                                                                        ]);
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //         echo 'guarde 1 3 y 5';
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $datossegui =
                                                                            SocioEducationalFollowUp::create(
                                                                                [
                                                                                    'id_student'       => $request['id_student'],
                                                                                    'id_user'          => $id['id'],
                                                                                    'tracking_detail'  => $guardar,
                                                                                ]
                                                                            );
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            } else {
                                                                if ($vlracdmco == 'true' && $vlruyc == 'true') {
                                                                    if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                    } else {
                                                                        //           echo ' guarde 1 2 y 5';
                                                                        if ($validacionHora == 'true') {
                                                                            $guardar = json_encode($arreglo);
                                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                                'id_student'       => $request['id_student'],
                                                                                'id_user'          => $id['id'],
                                                                                'tracking_detail'  => $guardar,
                                                                            ]);
                                                                            return $mensaje;
                                                                        } else {
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                } else {

                                                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true') {
                                                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                        } else {
                                                                            //guarde 1 2 y 3
                                                                            if ($validacionHora == 'true') {
                                                                                $guardar = json_encode($arreglo);
                                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                                    'id_student'       => $request['id_student'],
                                                                                    'id_user'          => $id['id'],
                                                                                    'tracking_detail'  => $guardar,
                                                                                ]);
                                                                                return $mensaje;
                                                                            } else {
                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                            } else {
                                                                                //             echo 'guarde 1 4 y 5';
                                                                                if ($validacionHora == 'true') {
                                                                                    $guardar = json_encode($arreglo);
                                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                                        'id_student'       => $request['id_student'],
                                                                                        'id_user'          => $id['id'],
                                                                                        'tracking_detail'  => $guardar,
                                                                                    ]);
                                                                                    return $mensaje;
                                                                                } else {
                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                }
                                                                            }
                                                                        } else {

                                                                            if ($vlracdmco == 'true') {

                                                                                if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                                } else {
                                                                                    //               echo 'guarde 1 y 2';
                                                                                    if ($validacionHora == 'true') {
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                                            'id_student'       => $request['id_student'],
                                                                                            'id_user'          => $id['id'],
                                                                                            'tracking_detail'  => $guardar,
                                                                                        ]);
                                                                                        return $mensaje;
                                                                                    } else {
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                if ($vlrfmlar == 'true') {
                                                                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                                    } else {
                                                                                        //                 echo 'guarde 1 y 3';
                                                                                        if ($validacionHora == 'true') {
                                                                                            $guardar = json_encode($arreglo);
                                                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                                                'id_student'       => $request['id_student'],
                                                                                                'id_user'          => $id['id'],
                                                                                                'tracking_detail'  => $guardar,
                                                                                            ]);
                                                                                            return $mensaje;
                                                                                        } else {
                                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    if ($vlrecnmco == 'true') {
                                                                                        if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {

                                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                                        } else {
                                                                                            //     echo 'guarde 1 y 4';    
                                                                                            if ($validacionHora == 'true') {
                                                                                                $guardar = json_encode($arreglo);
                                                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                                                    'id_student'       => $request['id_student'],
                                                                                                    'id_user'          => $id['id'],
                                                                                                    'tracking_detail'  => $guardar,
                                                                                                ]);
                                                                                                return $mensaje;
                                                                                            } else {
                                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        if ($vlruyc == 'true') {
                                                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                                            } else {
                                                                                                //       echo 'guarde 1 y 5';
                                                                                                if ($validacionHora == 'true') {
                                                                                                    $guardar = json_encode($arreglo);
                                                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                                                        'id_student'       => $request['id_student'],
                                                                                                        'id_user'          => $id['id'],
                                                                                                        'tracking_detail'  => $guardar,
                                                                                                    ]);
                                                                                                    return $mensaje;
                                                                                                } else {
                                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                        echo 'Las categorias deben ser diligenciadas completamente';
                                    } else {


                                        //echo "guarde con lo del primero";    
                                        if ($validacionHora == 'true') {
                                            $guardar = json_encode($arreglo);
                                            $datossegui = SocioEducationalFollowUp::create([
                                                'id_student'       => $request['id_student'],
                                                'id_user'          => $id['id'],
                                                'tracking_detail'  => $guardar,
                                            ]);
                                            return $mensaje;
                                        } else {
                                            echo 'La hora final debe ser mayor a la hora inicial';
                                        }
                                    }
                                }
                            } else {
                                if ($vlracdmco == 'true') {
                                    $acade = $arreglo['Academico'];
                                    $riesgoacade = $arreglo['RiesgoAcademico'];

                                    if ($vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {


                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 2, 3 4 y 5';    
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 2 3 y 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        echo 'Las categorias deben ser diligenciada completamente';
                                                    } else {
                                                        //guarda 2 3 y 5
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //guarda 2 4 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                    'id_student'       => $request['id_student'],
                                                                    'id_user'          => $id['id'],
                                                                    'tracking_detail'  => $guardar,
                                                                ]);
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrecnmco == 'true') {
                                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //guarda 2 y 4
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                        'id_student'       => $request['id_student'],
                                                                        'id_user'          => $id['id'],
                                                                        'tracking_detail'  => $guardar,
                                                                    ]);
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlruyc == 'true') {
                                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //guarda 2 y 5
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $datossegui =
                                                                            SocioEducationalFollowUp::create([
                                                                                'id_student'       => $request['id_student'],
                                                                                'id_user'          => $id['id'],
                                                                                'tracking_detail'  => $guardar,
                                                                            ]);
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {

                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //guarda 2 solo
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $datossegui = SocioEducationalFollowUp::create([
                                                    'id_student'       => $request['id_student'],
                                                    'id_user'          => $id['id'],
                                                    'tracking_detail'  => $guardar,
                                                ]);
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    }
                                } else {
                                    if ($vlrfmlar == 'true') {


                                        if ($vlrecnmco == 'true' || $vlruyc == 'true') {


                                            if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                //guarda 3 4 y 5
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            } else {

                                                if ($vlrecnmco == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //guarda 3 y 4
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        } else {
                                                            //guarda 3 y 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                    'id_student'       => $request['id_student'],
                                                                    'id_user'          => $id['id'],
                                                                    'tracking_detail'  => $guardar,
                                                                ]);
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null ||  $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //guarda 3
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        }
                                    } else {
                                        if ($vlrecnmco == 'true') {

                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 4 y 5                   
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['
                                                                 id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {

                                                    //guarda 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 5                                                         
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                echo 'No es posible crear un seguimiento con esa estructura';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    echo 'No es posible crear un seguimiento con esa estructura';
                }
            }
        } else {
            echo 'No es posible crear un seguimiento con esa estructura';
        }
    }


    public function edit_seguimiento($id, Request $request)
    {

        $seguimiento = SocioEducationalFollowUp::findOrFail($id);

        if ($request->ajax()) {
            return Response::json($seguimiento);
        };
    }

    public function update_seguimiento($id, Request $request)
    {
        //dd($request);
        $data = SocioEducationalFollowUp::findOrFail($id);

        $mensaje = "Seguimiento socioeducativo actualizado correctamente!!";

        if ($request->ajax()) {

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']), 'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindi']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacad']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfami'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkecono']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuni']), 'Observaciones' => ($request['textareobservaciones']), 'urlDocumento' => ($request['url_document'])];

            $horainicio = $arreglo['HoraInicio'];
            $horafin = $arreglo['HoraFin'];

            if ($horafin > $horainicio) {
                $validacionHora = 'true';
            } else {
                $validacionHora = 'false';
            }

            if ($arreglo['Individual'] != null && $arreglo['RiesgoIndividual'] != null) {

                $vlrndvdal = 'true';
            } else {
                $vlrndvdal = 'false';
            }

            if ($arreglo['Academico'] != null && $arreglo['RiesgoAcademico'] != null) {

                $vlracdmco = 'true';
            } else {
                $vlracdmco = 'false';
            }

            if ($arreglo['Familiar'] != null && $arreglo['RiesgoFamiliar'] != null) {

                $vlrfmlar = 'true';
            } else {
                $vlrfmlar = 'false';
            }

            if ($arreglo['Economico'] != null && $arreglo['RiesgoEconomico'] != null) {

                $vlrecnmco = 'true';
            } else {
                $vlrecnmco = 'false';
            }

            if ($arreglo['VidaUniversitariaYciudad'] != null && $arreglo['RiesgoUc'] != null) {

                $vlruyc = 'true';
            } else {
                $vlruyc = 'false';
            }

            if ($arreglo['fecha'] == null && $arreglo['Lugar'] == null && $arreglo['HoraInicio'] == null && $arreglo['HoraFin'] == null && $arreglo['Objetivos'] == null && $arreglo['Individual'] == null && $arreglo['RiesgoIndividual'] == null && $arreglo['Academico'] == null && $arreglo['RiesgoAcademico'] == null && $arreglo['Familiar'] == null && $arreglo['RiesgoFamiliar'] == null && $arreglo['Economico'] == null && $arreglo['RiesgoEconomico'] == null && $arreglo['VidaUniversitariaYciudad'] == null && $arreglo['RiesgoUc'] == null && $arreglo['Observaciones'] == null) {

                echo 'No es posible crear un seguimiento vacio';
            } else {

                if ($arreglo['fecha'] != null && $arreglo['Lugar'] != null && $arreglo['HoraInicio'] != null && $arreglo['HoraFin'] != null && $arreglo['Objetivos'] != null) {

                    if ($arreglo['Individual'] != null || $arreglo['Academico'] != null || $arreglo['Familiar'] != null || $arreglo['Economico'] != null || $arreglo['VidaUniversitariaYciudad'] != null) {

                        if ($vlrndvdal == 'true' && $vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {

                            if ($validacionHora == 'true') {
                                $guardar = json_encode($arreglo);
                                $data->tracking_detail = $guardar;
                                $data->save();
                                return $mensaje;
                            } else {
                                echo 'La hora final debe ser mayor a la hora inicial';
                            }
                        } else {
                            if ($vlrndvdal == 'true') {
                                $indi = $arreglo['Individual'];
                                $riesgoindi = $arreglo['RiesgoIndividual'];

                                if ($vlracdmco == 'true' || $vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {
                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlruyc == 'true') {
                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //echo 'guarde 1 2 3 y 5';
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $data->tracking_detail = $guardar;
                                                $data->save();
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    } else {
                                        if ($vlracdmco == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 1 2 4 y 5';
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    // echo 'guarde 1 3 4 y 5';
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                    if ($arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //   echo 'guarde 1 2 3 y 4';
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlracdmco == 'true' && $vlrecnmco == 'true') {

                                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //     echo 'guarde 1 2 y 4';
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //       echo 'guarde 1 3 y 4';
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //         echo 'guarde 1 3 y 5';
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $data->tracking_detail = $guardar;
                                                                        $data->save();
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            } else {
                                                                if ($vlracdmco == 'true' && $vlruyc == 'true') {
                                                                    if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                    } else {
                                                                        //           echo ' guarde 1 2 y 5';
                                                                        if ($validacionHora == 'true') {
                                                                            $guardar = json_encode($arreglo);
                                                                            $data->tracking_detail = $guardar;
                                                                            $data->save();
                                                                            return $mensaje;
                                                                        } else {
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                } else {

                                                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true') {
                                                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                        } else {
                                                                            //guarde 1 2 y 3
                                                                            if ($validacionHora == 'true') {
                                                                                $guardar = json_encode($arreglo);
                                                                                $data->tracking_detail = $guardar;
                                                                                $data->save();
                                                                                return $mensaje;
                                                                            } else {
                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                            } else {
                                                                                //             echo 'guarde 1 4 y 5';
                                                                                if ($validacionHora == 'true') {
                                                                                    $guardar = json_encode($arreglo);
                                                                                    $data->tracking_detail = $guardar;
                                                                                    $data->save();
                                                                                    return $mensaje;
                                                                                } else {
                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                }
                                                                            }
                                                                        } else {

                                                                            if ($vlracdmco == 'true') {

                                                                                if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                                } else {
                                                                                    //               echo 'guarde 1 y 2';
                                                                                    if ($validacionHora == 'true') {
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $data->tracking_detail = $guardar;
                                                                                        $data->save();
                                                                                        return $mensaje;
                                                                                    } else {
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                if ($vlrfmlar == 'true') {
                                                                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                                    } else {
                                                                                        //                 echo 'guarde 1 y 3';
                                                                                        if ($validacionHora == 'true') {
                                                                                            $guardar = json_encode($arreglo);
                                                                                            $data->tracking_detail = $guardar;
                                                                                            $data->save();
                                                                                            return $mensaje;
                                                                                        } else {
                                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    if ($vlrecnmco == 'true') {
                                                                                        if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {

                                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                                        } else {
                                                                                            //     echo 'guarde 1 y 4';    
                                                                                            if ($validacionHora == 'true') {
                                                                                                $guardar = json_encode($arreglo);
                                                                                                $data->tracking_detail = $guardar;
                                                                                                $data->save();
                                                                                                return $mensaje;
                                                                                            } else {
                                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        if ($vlruyc == 'true') {
                                                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                                            } else {
                                                                                                //       echo 'guarde 1 y 5';
                                                                                                if ($validacionHora == 'true') {
                                                                                                    $guardar = json_encode($arreglo);
                                                                                                    $data->tracking_detail = $guardar;
                                                                                                    $data->save();
                                                                                                    return $mensaje;
                                                                                                } else {
                                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                        echo 'Las categorias deben ser diligenciadas completamente';
                                    } else {


                                        //echo "guarde con lo del primero";    
                                        if ($validacionHora == 'true') {
                                            $guardar = json_encode($arreglo);
                                            $data->tracking_detail = $guardar;
                                            $data->save();
                                            return $mensaje;
                                        } else {
                                            echo 'La hora final debe ser mayor a la hora inicial';
                                        }
                                    }
                                }
                            } else {
                                if ($vlracdmco == 'true') {
                                    $acade = $arreglo['Academico'];
                                    $riesgoacade = $arreglo['RiesgoAcademico'];

                                    if ($vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {


                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 2, 3 4 y 5';    
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 2 3 y 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        echo 'Las categorias deben ser diligenciada completamente';
                                                    } else {
                                                        //guarda 2 3 y 5
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //guarda 2 4 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrecnmco == 'true') {
                                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //guarda 2 y 4
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlruyc == 'true') {
                                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //guarda 2 y 5
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $data->tracking_detail = $guardar;
                                                                        $data->save();
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {

                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //guarda 2 solo
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $data->tracking_detail = $guardar;
                                                $data->save();
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    }
                                } else {
                                    if ($vlrfmlar == 'true') {


                                        if ($vlrecnmco == 'true' || $vlruyc == 'true') {


                                            if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                //guarda 3 4 y 5
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            } else {

                                                if ($vlrecnmco == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //guarda 3 y 4
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        } else {
                                                            //guarda 3 y 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null ||  $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //guarda 3
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        }
                                    } else {
                                        if ($vlrecnmco == 'true') {

                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 4 y 5                   
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {

                                                    //guarda 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 5                                                         
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                echo 'No es posible crear un seguimiento con esa estructura';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    echo 'No es posible crear un seguimiento con esa estructura';
                }
            }
        } else {
            echo 'No es posible crear un seguimiento con esa estructura';
        };
    }

    public function delete_seguimiento($id, Request $request)
    {
        //dd('entro a eliminar');
        if ($request->ajax()) {
            $data = SocioEducationalFollowUp::findOrFail($id);
            $data->delete();
            return;
        }
    }

    public function crear_condicion(Request $request){

        $trabajador;
        if($request['trabajador'] == 'true'){
            $trabajador = true; 
        }else if($request['trabajador'] !== 'true'){
            $trabajador = false;
        }

        $sld_fisica;
        if($request['salud_fisica'] == 'true'){
            $sld_fisica = true; 
        }else if($request['salud_fisica'] !== 'true'){
            $sld_fisica = false;
        }

        $sld_mntal;
        if($request['salud_mental'] == 'true'){
            $sld_mntal = true; 
        }else if($request['salud_mental'] !== 'true'){
            $sld_mntal = false;
        }

        $rsgo_pscosocial;
        if($request['riesgo_psicosocial'] == 'true'){
            $rsgo_pscosocial = true; 
        }else if($request['riesgo_psicosocial'] !== 'true'){
            $rsgo_pscosocial = false;
        }
        //dd($trabajador, $sld_mntal);

        $validar = HealthCondition::where('id_student', $request['id'])->exists();
        //dd($validar);
        if($validar == true){
            $condicion_id = HealthCondition::select('id')->where('id_student', $request['id'])->first();
            $data_condicion = HealthCondition::findOrfail($condicion_id->id);
            $data_condicion_old = HealthCondition::findOrfail($condicion_id->id);
            
            $data_condicion->employee = $trabajador;
            $data_condicion->physical_health = $sld_fisica;
            $data_condicion->mental_health = $sld_mntal;
            $data_condicion->psychosocial_risk = $rsgo_pscosocial;
                   
            $data_condicion->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $data_condicion['id'],
                'actividad_realizada'      => 'CONDICION DE SALUD ACTUALIZADA',
            ]);

            $old = array();
            $new = array();

            if($data_condicion_old->employee != $data_condicion->employee){
                $old[] = array('trabajador' => $data_condicion_old->employee);
                $new[] = array('trabajador' => $data_condicion->employee);
            }
            if($data_condicion_old->physical_health != $data_condicion->physical_health){
                $old[] = array('salud_fisica' => $data_condicion_old->physical_health);
                $new[] = array('salud_fisica' => $data_condicion->physical_health);
            }
            if($data_condicion_old->mental_health != $data_condicion->mental_health){
                $old[] = array('salud_mental' => $data_condicion_old->mental_health);
                $new[] = array('salud_mental' => $data_condicion->mental_health);
            }
            if($data_condicion_old->psychosocial_risk != $data_condicion->psychosocial_risk){
                $old[] = array('riesgo_psicosocial' => $data_condicion_old->psychosocial_risk);
                $new[] = array('riesgo_psicosocial' => $data_condicion->psychosocial_risk);
            }

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            if($guardarOld != null && $guardarNew != null){
                $update = UpdateInformation::create([
                    'id_log'              => $datos['id'],
                    'changed_information' => $guardarOld,
                    'new_information'     => $guardarNew,
                ]);
            }

            return $data_condicion; 

        }else if($validar == false){
                    
            $condicion_salud = HealthCondition::create([
                'id_student'        => $request['id'],
                'employee'          => $trabajador,
                'physical_health'   => $sld_fisica,
                'mental_health'     => $sld_mntal,
                'psychosocial_risk' => $rsgo_pscosocial,
            ]);

            $ip = User::getRealIP();
            $id = auth()->user();
            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $condicion_salud['id'],
                'actividad_realizada'      => 'NUEVA CONDICION DE SALUD',
            ]);
            
            return $condicion_salud;
        }

    }
    
     public function datos_index(){
        
        $datos = SocioEducationalFollowUp::socioeducativo_reporte();

        $arreglo_datos = array();
   
        foreach($datos as $dato){

            $json_detalle = json_decode($dato->detalle);            

            $arreglo_datos[] = array(
                'id' => $dato->id,
                'name' => $dato->name, 
                'lastname' => $dato->lastname,
                'document_number' => $dato->document_number,
                'grupo_id' => $dato->grupoid,
                'grupo' => $dato->grupo,
                'estado' => $dato->estado,
                'cohorte' => $dato->cohorte,
                'id_profesional' => $dato->id_profesional,
                'nombre_profesional' => $dato->nombre_profesional,
                'apellido_profesional' => $dato->apellido_profersional,
                'cantidad_seguimientos' => $dato->cantidad_seguimientos, 
                'aceptacion1' => $dato->aceptacion1,
                'aceptacion2' => $dato->aceptacion2,
                'riesgo_indivdual' => $json_detalle->RiesgoIndividual,
                'riesgo_academico' => $json_detalle->RiesgoAcademico,
                'riesgo_familiar' => $json_detalle->RiesgoFamiliar,
                'riesgo_economico' => $json_detalle->RiesgoEconomico,
                'riesgo_Uc' => $json_detalle->RiesgoUc,
                'trabajador' => $dato->trabajador,
                'salud_fisica' => $dato->salud_fisica,
                'salud_mental' => $dato->salud_mental,
                'riesgo_psicosocial' => $dato->riesgo_psicosocial, 
                'id_state' => $dato->id_state
            ); 
        }

        $colection_seguimiento = collect($arreglo_datos);
        
        return datatables()->of($colection_seguimiento)->toJson();
                
    }


    public function index_reporte(){
       
        return view('socioeducativo.index_reporte');
    }

    public function exportar_reporte_socioeducativo(){

        $estudiantes = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, socio_educational_follow_ups.tracking_detail as detalle, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, (SELECT health_conditions.employee FROM health_conditions WHERE health_conditions.id_student = student_profile.id) as trabajador, (SELECT health_conditions.physical_health FROM health_conditions WHERE health_conditions.id_student = student_profile.id) as salud_fisica, (SELECT health_conditions.mental_health FROM health_conditions WHERE health_conditions.id_student = student_profile.id) as salud_mental,
            (SELECT health_conditions.psychosocial_risk FROM health_conditions WHERE 
            health_conditions.id_student = student_profile.id) as riesgo_psicosocial
            FROM student_profile 
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            INNER JOIN socio_educational_follow_ups on socio_educational_follow_ups.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            AND socio_educational_follow_ups.deleted_at IS NULL");

        $estudiantes_colection = collect($estudiantes);
        $excel = array();
        $trabajador;
        $salud_fisica;
        $salud_mental;
        $riesgo_psicosocial;
        foreach($estudiantes_colection as $estudiante_colection){

            if($estudiante_colection->trabajador !== null){
                if($estudiante_colection->trabajador == 1){
                    $trabajador = 'SI';
                }else if($estudiante_colection->trabajador == 0){
                    $trabajador = 'NO';
                }
            }else{
                $trabajador = null;
            }

            if($estudiante_colection->salud_fisica !== null){
                if($estudiante_colection->salud_fisica == 1){
                    $salud_fisica = 'SI';
                }else if($estudiante_colection->salud_fisica == 0){
                    $salud_fisica = 'NO';
                }
            }else{
                $salud_fisica = null;
            }

            if($estudiante_colection->salud_mental !== null){
                if($estudiante_colection->salud_mental == 1){
                    $salud_mental = 'SI';
                }else if($estudiante_colection->salud_mental == 0){
                    $salud_mental = 'NO';
                }
            }else{
                $salud_mental = null;
            }

            if($estudiante_colection->riesgo_psicosocial !== null){
                if($estudiante_colection->riesgo_psicosocial == 1){
                    $riesgo_psicosocial = 'SI';
                }else if($estudiante_colection->riesgo_psicosocial == 0){
                    $riesgo_psicosocial = 'NO';
                }
            }else{
                $riesgo_psicosocial = null;
            }

            $detalle_seguimiento = json_decode($estudiante_colection->detalle);    
            
            $excel[] = array('id' => $estudiante_colection->id,
                            'nombres' => $estudiante_colection->name,
                            'apellidos' => $estudiante_colection->lastname,
                            'tipo_documento' => $estudiante_colection->tipodocumento,
                            'numero documento' => $estudiante_colection->document_number,
                            'codigo' => $estudiante_colection->student_code,
                            'correo' => $estudiante_colection->email, 
                            'telefono' => $estudiante_colection->cellphone,
                            'cohorte' => $estudiante_colection->cohorte,
                            'grupo' => $estudiante_colection->grupo, 
                            'estado' => $estudiante_colection->estado, 
                            'aceptacion1' => $estudiante_colection->aceptacion1,
                            'aceptacion2' => $estudiante_colection->aceptacion2,
                            'trabajador' => $trabajador,
                            'salud_fisica' => $salud_fisica,
                            'salud_mental' => $salud_mental,
                            'riesgo_psicosocial' => $riesgo_psicosocial, 
                            'fecha_seguimiento' => $detalle_seguimiento->fecha, 
                            'lugar_seguimiento' => $detalle_seguimiento->Lugar,
                            'hora_inicio' => $detalle_seguimiento->HoraInicio,
                            'hora_fin' => $detalle_seguimiento->HoraFin, 
                            'objetivos' => $detalle_seguimiento->Objetivos, 
                            'descripcion_individual' => $detalle_seguimiento->Individual, 
                            'riesgo_indivdual' => $detalle_seguimiento->RiesgoIndividual,
                            'descripcion_academica' => $detalle_seguimiento->Academico,
                            'riesgo_academico' => $detalle_seguimiento->RiesgoAcademico,
                            'descripcion_familiar' => $detalle_seguimiento->Familiar,
                            'riesgo_familiar' => $detalle_seguimiento->RiesgoFamiliar,
                            'descripcion_economica' => $detalle_seguimiento->Economico,
                            'riesgo_eonomico' => $detalle_seguimiento->RiesgoEconomico, 
                            'escripcion_vdaunvrstriaycdad' => $detalle_seguimiento->VidaUniversitariaYciudad,
                            'riesgo_vdaunvrstriaycdad' => $detalle_seguimiento->RiesgoUc,
                            'observaciones' => $detalle_seguimiento->Observaciones);
        }      

        $exportar = new SocioeducativoExport([$excel]);


        return Excel::download($exportar, 'socioeducativo_reporte.xlsx');


    }

    public function store_seguimiento(Request $request)
    {

        $mensaje = 'Seguimiento creado correctamente';
        $error = 'no puede crear';
        $id = auth()->user();

        if ($request->ajax()) {

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']), 'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindiV']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacadE']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfamiL'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkeconoM']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuniC']), 'Observaciones' => ($request['textareobservaciones']), 'urlDocumento' => ($request['url_document'])];

            $horainicio = $arreglo['HoraInicio'];
            $horafin = $arreglo['HoraFin'];

            if ($horafin > $horainicio) {
                $validacionHora = 'true';
            } else {
                $validacionHora = 'false';
            }

            if ($arreglo['Individual'] != null && $arreglo['RiesgoIndividual'] != null) {

                $vlrndvdal = 'true';
            } else {
                $vlrndvdal = 'false';
            }

            if ($arreglo['Academico'] != null && $arreglo['RiesgoAcademico'] != null) {

                $vlracdmco = 'true';
            } else {
                $vlracdmco = 'false';
            }

            if ($arreglo['Familiar'] != null && $arreglo['RiesgoFamiliar'] != null) {

                $vlrfmlar = 'true';
            } else {
                $vlrfmlar = 'false';
            }

            if ($arreglo['Economico'] != null && $arreglo['RiesgoEconomico'] != null) {

                $vlrecnmco = 'true';
            } else {
                $vlrecnmco = 'false';
            }

            if ($arreglo['VidaUniversitariaYciudad'] != null && $arreglo['RiesgoUc'] != null) {

                $vlruyc = 'true';
            } else {
                $vlruyc = 'false';
            }



            if ($arreglo['fecha'] == null && $arreglo['Lugar'] == null && $arreglo['HoraInicio'] == null && $arreglo['HoraFin'] == null && $arreglo['Objetivos'] == null && $arreglo['Individual'] == null && $arreglo['RiesgoIndividual'] == null && $arreglo['Academico'] == null && $arreglo['RiesgoAcademico'] == null && $arreglo['Familiar'] == null && $arreglo['RiesgoFamiliar'] == null && $arreglo['Economico'] == null && $arreglo['RiesgoEconomico'] == null && $arreglo['VidaUniversitariaYciudad'] == null && $arreglo['RiesgoUc'] == null && $arreglo['Observaciones'] == null) {

                echo 'No es posible crear un seguimiento vacio';
            } else {

                if ($arreglo['fecha'] != null && $arreglo['Lugar'] != null && $arreglo['HoraInicio'] != null && $arreglo['HoraFin'] != null && $arreglo['Objetivos'] != null) {

                    if ($arreglo['Individual'] != null || $arreglo['Academico'] != null || $arreglo['Familiar'] != null || $arreglo['Economico'] != null || $arreglo['VidaUniversitariaYciudad'] != null) {

                        if ($vlrndvdal == 'true' && $vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {

                            if ($validacionHora == 'true') {
                                $guardar = json_encode($arreglo);
                                $datossegui = SocioEducationalFollowUp::create([
                                    'id_student'       => $request['id_student'],
                                    'id_user'          => $id['id'],
                                    'tracking_detail'  => $guardar,
                                ]);
                                return $mensaje;
                            } else {
                                echo 'La hora final debe ser mayor a la hora inicial';
                            }
                        } else {
                            if ($vlrndvdal == 'true') {
                                $indi = $arreglo['Individual'];
                                $riesgoindi = $arreglo['RiesgoIndividual'];

                                if ($vlracdmco == 'true' || $vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {
                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlruyc == 'true') {
                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //echo 'guarde 1 2 3 y 5';
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $datossegui = SocioEducationalFollowUp::create([
                                                    'id_student'       => $request['id_student'],
                                                    'id_user'          => $id['id'],
                                                    'tracking_detail'  => $guardar,
                                                ]);
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    } else {
                                        if ($vlracdmco == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 1 2 4 y 5';
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    // echo 'guarde 1 3 4 y 5';
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                    if ($arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //   echo 'guarde 1 2 3 y 4';
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlracdmco == 'true' && $vlrecnmco == 'true') {

                                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //     echo 'guarde 1 2 y 4';
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                    'id_student'       => $request['id_student'],
                                                                    'id_user'          => $id['id'],
                                                                    'tracking_detail'  => $guardar,
                                                                ]);
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //       echo 'guarde 1 3 y 4';
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui =
                                                                        SocioEducationalFollowUp::create([
                                                                            'id_student'       => $request['id_student'],
                                                                            'id_user'          => $id['id'],
                                                                            'tracking_detail'  => $guardar,
                                                                        ]);
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //         echo 'guarde 1 3 y 5';
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $datossegui =
                                                                            SocioEducationalFollowUp::create(
                                                                                [
                                                                                    'id_student'       => $request['id_student'],
                                                                                    'id_user'          => $id['id'],
                                                                                    'tracking_detail'  => $guardar,
                                                                                ]
                                                                            );
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            } else {
                                                                if ($vlracdmco == 'true' && $vlruyc == 'true') {
                                                                    if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                    } else {
                                                                        //           echo ' guarde 1 2 y 5';
                                                                        if ($validacionHora == 'true') {
                                                                            $guardar = json_encode($arreglo);
                                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                                'id_student'       => $request['id_student'],
                                                                                'id_user'          => $id['id'],
                                                                                'tracking_detail'  => $guardar,
                                                                            ]);
                                                                            return $mensaje;
                                                                        } else {
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                } else {

                                                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true') {
                                                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                        } else {
                                                                            //guarde 1 2 y 3
                                                                            if ($validacionHora == 'true') {
                                                                                $guardar = json_encode($arreglo);
                                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                                    'id_student'       => $request['id_student'],
                                                                                    'id_user'          => $id['id'],
                                                                                    'tracking_detail'  => $guardar,
                                                                                ]);
                                                                                return $mensaje;
                                                                            } else {
                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                            } else {
                                                                                //             echo 'guarde 1 4 y 5';
                                                                                if ($validacionHora == 'true') {
                                                                                    $guardar = json_encode($arreglo);
                                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                                        'id_student'       => $request['id_student'],
                                                                                        'id_user'          => $id['id'],
                                                                                        'tracking_detail'  => $guardar,
                                                                                    ]);
                                                                                    return $mensaje;
                                                                                } else {
                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                }
                                                                            }
                                                                        } else {

                                                                            if ($vlracdmco == 'true') {

                                                                                if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                                } else {
                                                                                    //               echo 'guarde 1 y 2';
                                                                                    if ($validacionHora == 'true') {
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                                            'id_student'       => $request['id_student'],
                                                                                            'id_user'          => $id['id'],
                                                                                            'tracking_detail'  => $guardar,
                                                                                        ]);
                                                                                        return $mensaje;
                                                                                    } else {
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                if ($vlrfmlar == 'true') {
                                                                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                                    } else {
                                                                                        //                 echo 'guarde 1 y 3';
                                                                                        if ($validacionHora == 'true') {
                                                                                            $guardar = json_encode($arreglo);
                                                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                                                'id_student'       => $request['id_student'],
                                                                                                'id_user'          => $id['id'],
                                                                                                'tracking_detail'  => $guardar,
                                                                                            ]);
                                                                                            return $mensaje;
                                                                                        } else {
                                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    if ($vlrecnmco == 'true') {
                                                                                        if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {

                                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                                        } else {
                                                                                            //     echo 'guarde 1 y 4';    
                                                                                            if ($validacionHora == 'true') {
                                                                                                $guardar = json_encode($arreglo);
                                                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                                                    'id_student'       => $request['id_student'],
                                                                                                    'id_user'          => $id['id'],
                                                                                                    'tracking_detail'  => $guardar,
                                                                                                ]);
                                                                                                return $mensaje;
                                                                                            } else {
                                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        if ($vlruyc == 'true') {
                                                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                                            } else {
                                                                                                //       echo 'guarde 1 y 5';
                                                                                                if ($validacionHora == 'true') {
                                                                                                    $guardar = json_encode($arreglo);
                                                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                                                        'id_student'       => $request['id_student'],
                                                                                                        'id_user'          => $id['id'],
                                                                                                        'tracking_detail'  => $guardar,
                                                                                                    ]);
                                                                                                    return $mensaje;
                                                                                                } else {
                                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                        echo 'Las categorias deben ser diligenciadas completamente';
                                    } else {


                                        //echo "guarde con lo del primero";    
                                        if ($validacionHora == 'true') {
                                            $guardar = json_encode($arreglo);
                                            $datossegui = SocioEducationalFollowUp::create([
                                                'id_student'       => $request['id_student'],
                                                'id_user'          => $id['id'],
                                                'tracking_detail'  => $guardar,
                                            ]);
                                            return $mensaje;
                                        } else {
                                            echo 'La hora final debe ser mayor a la hora inicial';
                                        }
                                    }
                                }
                            } else {
                                if ($vlracdmco == 'true') {
                                    $acade = $arreglo['Academico'];
                                    $riesgoacade = $arreglo['RiesgoAcademico'];

                                    if ($vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {


                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 2, 3 4 y 5';    
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 2 3 y 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        echo 'Las categorias deben ser diligenciada completamente';
                                                    } else {
                                                        //guarda 2 3 y 5
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //guarda 2 4 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                    'id_student'       => $request['id_student'],
                                                                    'id_user'          => $id['id'],
                                                                    'tracking_detail'  => $guardar,
                                                                ]);
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrecnmco == 'true') {
                                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //guarda 2 y 4
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                        'id_student'       => $request['id_student'],
                                                                        'id_user'          => $id['id'],
                                                                        'tracking_detail'  => $guardar,
                                                                    ]);
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlruyc == 'true') {
                                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //guarda 2 y 5
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $datossegui =
                                                                            SocioEducationalFollowUp::create([
                                                                                'id_student'       => $request['id_student'],
                                                                                'id_user'          => $id['id'],
                                                                                'tracking_detail'  => $guardar,
                                                                            ]);
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {

                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //guarda 2 solo
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $datossegui = SocioEducationalFollowUp::create([
                                                    'id_student'       => $request['id_student'],
                                                    'id_user'          => $id['id'],
                                                    'tracking_detail'  => $guardar,
                                                ]);
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    }
                                } else {
                                    if ($vlrfmlar == 'true') {


                                        if ($vlrecnmco == 'true' || $vlruyc == 'true') {


                                            if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                //guarda 3 4 y 5
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            } else {

                                                if ($vlrecnmco == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //guarda 3 y 4
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        } else {
                                                            //guarda 3 y 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                    'id_student'       => $request['id_student'],
                                                                    'id_user'          => $id['id'],
                                                                    'tracking_detail'  => $guardar,
                                                                ]);
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null ||  $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //guarda 3
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        }
                                    } else {
                                        if ($vlrecnmco == 'true') {

                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 4 y 5                   
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['
                                                                 id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {

                                                    //guarda 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 5                                                         
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                echo 'No es posible crear un seguimiento con esa estructura';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    echo 'No es posible crear un seguimiento con esa estructura';
                }
            }
        } else {
            echo 'No es posible crear un seguimiento con esa estructura';
        }
    }


    public function edit_seguimiento($id, Request $request)
    {

        $seguimiento = SocioEducationalFollowUp::findOrFail($id);

        if ($request->ajax()) {
            return Response::json($seguimiento);
        };
    }

    public function update_seguimiento($id, Request $request)
    {
        //dd($request);
        $data = SocioEducationalFollowUp::findOrFail($id);

        $mensaje = "Seguimiento socioeducativo actualizado correctamente!!";

        if ($request->ajax()) {

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']), 'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindi']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacad']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfami'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkecono']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuni']), 'Observaciones' => ($request['textareobservaciones']), 'urlDocumento' => ($request['url_document'])];

            $horainicio = $arreglo['HoraInicio'];
            $horafin = $arreglo['HoraFin'];

            if ($horafin > $horainicio) {
                $validacionHora = 'true';
            } else {
                $validacionHora = 'false';
            }

            if ($arreglo['Individual'] != null && $arreglo['RiesgoIndividual'] != null) {

                $vlrndvdal = 'true';
            } else {
                $vlrndvdal = 'false';
            }

            if ($arreglo['Academico'] != null && $arreglo['RiesgoAcademico'] != null) {

                $vlracdmco = 'true';
            } else {
                $vlracdmco = 'false';
            }

            if ($arreglo['Familiar'] != null && $arreglo['RiesgoFamiliar'] != null) {

                $vlrfmlar = 'true';
            } else {
                $vlrfmlar = 'false';
            }

            if ($arreglo['Economico'] != null && $arreglo['RiesgoEconomico'] != null) {

                $vlrecnmco = 'true';
            } else {
                $vlrecnmco = 'false';
            }

            if ($arreglo['VidaUniversitariaYciudad'] != null && $arreglo['RiesgoUc'] != null) {

                $vlruyc = 'true';
            } else {
                $vlruyc = 'false';
            }

            if ($arreglo['fecha'] == null && $arreglo['Lugar'] == null && $arreglo['HoraInicio'] == null && $arreglo['HoraFin'] == null && $arreglo['Objetivos'] == null && $arreglo['Individual'] == null && $arreglo['RiesgoIndividual'] == null && $arreglo['Academico'] == null && $arreglo['RiesgoAcademico'] == null && $arreglo['Familiar'] == null && $arreglo['RiesgoFamiliar'] == null && $arreglo['Economico'] == null && $arreglo['RiesgoEconomico'] == null && $arreglo['VidaUniversitariaYciudad'] == null && $arreglo['RiesgoUc'] == null && $arreglo['Observaciones'] == null) {

                echo 'No es posible crear un seguimiento vacio';
            } else {

                if ($arreglo['fecha'] != null && $arreglo['Lugar'] != null && $arreglo['HoraInicio'] != null && $arreglo['HoraFin'] != null && $arreglo['Objetivos'] != null) {

                    if ($arreglo['Individual'] != null || $arreglo['Academico'] != null || $arreglo['Familiar'] != null || $arreglo['Economico'] != null || $arreglo['VidaUniversitariaYciudad'] != null) {

                        if ($vlrndvdal == 'true' && $vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {

                            if ($validacionHora == 'true') {
                                $guardar = json_encode($arreglo);
                                $data->tracking_detail = $guardar;
                                $data->save();
                                return $mensaje;
                            } else {
                                echo 'La hora final debe ser mayor a la hora inicial';
                            }
                        } else {
                            if ($vlrndvdal == 'true') {
                                $indi = $arreglo['Individual'];
                                $riesgoindi = $arreglo['RiesgoIndividual'];

                                if ($vlracdmco == 'true' || $vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {
                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlruyc == 'true') {
                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //echo 'guarde 1 2 3 y 5';
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $data->tracking_detail = $guardar;
                                                $data->save();
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    } else {
                                        if ($vlracdmco == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 1 2 4 y 5';
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    // echo 'guarde 1 3 4 y 5';
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                    if ($arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //   echo 'guarde 1 2 3 y 4';
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlracdmco == 'true' && $vlrecnmco == 'true') {

                                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //     echo 'guarde 1 2 y 4';
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //       echo 'guarde 1 3 y 4';
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                                if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //         echo 'guarde 1 3 y 5';
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $data->tracking_detail = $guardar;
                                                                        $data->save();
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            } else {
                                                                if ($vlracdmco == 'true' && $vlruyc == 'true') {
                                                                    if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                    } else {
                                                                        //           echo ' guarde 1 2 y 5';
                                                                        if ($validacionHora == 'true') {
                                                                            $guardar = json_encode($arreglo);
                                                                            $data->tracking_detail = $guardar;
                                                                            $data->save();
                                                                            return $mensaje;
                                                                        } else {
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                } else {

                                                                    if ($vlracdmco == 'true' && $vlrfmlar == 'true') {
                                                                        if ($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                        } else {
                                                                            //guarde 1 2 y 3
                                                                            if ($validacionHora == 'true') {
                                                                                $guardar = json_encode($arreglo);
                                                                                $data->tracking_detail = $guardar;
                                                                                $data->save();
                                                                                return $mensaje;
                                                                            } else {
                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                                            if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                            } else {
                                                                                //             echo 'guarde 1 4 y 5';
                                                                                if ($validacionHora == 'true') {
                                                                                    $guardar = json_encode($arreglo);
                                                                                    $data->tracking_detail = $guardar;
                                                                                    $data->save();
                                                                                    return $mensaje;
                                                                                } else {
                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                }
                                                                            }
                                                                        } else {

                                                                            if ($vlracdmco == 'true') {

                                                                                if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                                } else {
                                                                                    //               echo 'guarde 1 y 2';
                                                                                    if ($validacionHora == 'true') {
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $data->tracking_detail = $guardar;
                                                                                        $data->save();
                                                                                        return $mensaje;
                                                                                    } else {
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                if ($vlrfmlar == 'true') {
                                                                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                                    } else {
                                                                                        //                 echo 'guarde 1 y 3';
                                                                                        if ($validacionHora == 'true') {
                                                                                            $guardar = json_encode($arreglo);
                                                                                            $data->tracking_detail = $guardar;
                                                                                            $data->save();
                                                                                            return $mensaje;
                                                                                        } else {
                                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    if ($vlrecnmco == 'true') {
                                                                                        if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {

                                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                                        } else {
                                                                                            //     echo 'guarde 1 y 4';    
                                                                                            if ($validacionHora == 'true') {
                                                                                                $guardar = json_encode($arreglo);
                                                                                                $data->tracking_detail = $guardar;
                                                                                                $data->save();
                                                                                                return $mensaje;
                                                                                            } else {
                                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        if ($vlruyc == 'true') {
                                                                                            if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                                            } else {
                                                                                                //       echo 'guarde 1 y 5';
                                                                                                if ($validacionHora == 'true') {
                                                                                                    $guardar = json_encode($arreglo);
                                                                                                    $data->tracking_detail = $guardar;
                                                                                                    $data->save();
                                                                                                    return $mensaje;
                                                                                                } else {
                                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                        echo 'Las categorias deben ser diligenciadas completamente';
                                    } else {


                                        //echo "guarde con lo del primero";    
                                        if ($validacionHora == 'true') {
                                            $guardar = json_encode($arreglo);
                                            $data->tracking_detail = $guardar;
                                            $data->save();
                                            return $mensaje;
                                        } else {
                                            echo 'La hora final debe ser mayor a la hora inicial';
                                        }
                                    }
                                }
                            } else {
                                if ($vlracdmco == 'true') {
                                    $acade = $arreglo['Academico'];
                                    $riesgoacade = $arreglo['RiesgoAcademico'];

                                    if ($vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {


                                        if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //echo 'guarde 2, 3 4 y 5';    
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        } else {
                                            if ($vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 2 3 y 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {

                                                if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        echo 'Las categorias deben ser diligenciada completamente';
                                                    } else {
                                                        //guarda 2 3 y 5
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        } else {
                                                            //guarda 2 4 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    } else {
                                                        if ($vlrecnmco == 'true') {
                                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            } else {
                                                                //guarda 2 y 4
                                                                if ($validacionHora == 'true') {
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                                } else {
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        } else {
                                                            if ($vlruyc == 'true') {
                                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                } else {
                                                                    //guarda 2 y 5
                                                                    if ($validacionHora == 'true') {
                                                                        $guardar = json_encode($arreglo);
                                                                        $data->tracking_detail = $guardar;
                                                                        $data->save();
                                                                        return $mensaje;
                                                                    } else {
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {

                                        if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        } else {
                                            //guarda 2 solo
                                            if ($validacionHora == 'true') {
                                                $guardar = json_encode($arreglo);
                                                $data->tracking_detail = $guardar;
                                                $data->save();
                                                return $mensaje;
                                            } else {
                                                echo 'La hora final debe ser mayor a la hora inicial';
                                            }
                                        }
                                    }
                                } else {
                                    if ($vlrfmlar == 'true') {


                                        if ($vlrecnmco == 'true' || $vlruyc == 'true') {


                                            if ($vlrecnmco == 'true' && $vlruyc == 'true') {
                                                //guarda 3 4 y 5
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            } else {

                                                if ($vlrecnmco == 'true') {
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    } else {
                                                        //guarda 3 y 4
                                                        if ($validacionHora == 'true') {
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        } else {
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                } else {
                                                    if ($vlruyc == 'true') {
                                                        if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                        } else {
                                                            //guarda 3 y 5
                                                            if ($validacionHora == 'true') {
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                            } else {
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null ||  $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                echo 'Las categorias deben ser diligenciadas completamente';
                                            } else {
                                                //guarda 3
                                                if ($validacionHora == 'true') {
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                } else {
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        }
                                    } else {
                                        if ($vlrecnmco == 'true') {

                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 4 y 5                   
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {

                                                    //guarda 4
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($vlruyc == 'true') {
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {

                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                } else {
                                                    //guarda 5                                                         
                                                    if ($validacionHora == 'true') {
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    } else {
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            } else {
                                                echo 'No es posible crear un seguimiento con esa estructura';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    echo 'No es posible crear un seguimiento con esa estructura';
                }
            }
        } else {
            echo 'No es posible crear un seguimiento con esa estructura';
        };
    }

    public function delete_seguimiento($id, Request $request)
    {
        //dd('entro a eliminar');
        if ($request->ajax()) {
            $data = SocioEducationalFollowUp::findOrFail($id);
            $data->delete();
            return;
        }
    }

    public function crear_condicion(Request $request){

        $trabajador;
        if($request['trabajador'] == 'true'){
            $trabajador = true; 
        }else if($request['trabajador'] !== 'true'){
            $trabajador = false;
        }

        $sld_fisica;
        if($request['salud_fisica'] == 'true'){
            $sld_fisica = true; 
        }else if($request['salud_fisica'] !== 'true'){
            $sld_fisica = false;
        }

        $sld_mntal;
        if($request['salud_mental'] == 'true'){
            $sld_mntal = true; 
        }else if($request['salud_mental'] !== 'true'){
            $sld_mntal = false;
        }

        $rsgo_pscosocial;
        if($request['riesgo_psicosocial'] == 'true'){
            $rsgo_pscosocial = true; 
        }else if($request['riesgo_psicosocial'] !== 'true'){
            $rsgo_pscosocial = false;
        }
        //dd($trabajador, $sld_mntal);

        $validar = HealthCondition::where('id_student', $request['id'])->exists();
        //dd($validar);
        if($validar == true){
            $condicion_id = HealthCondition::select('id')->where('id_student', $request['id'])->first();
            $data_condicion = HealthCondition::findOrfail($condicion_id->id);
            $data_condicion_old = HealthCondition::findOrfail($condicion_id->id);
            
            $data_condicion->employee = $trabajador;
            $data_condicion->physical_health = $sld_fisica;
            $data_condicion->mental_health = $sld_mntal;
            $data_condicion->psychosocial_risk = $rsgo_pscosocial;
                   
            $data_condicion->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $data_condicion['id'],
                'actividad_realizada'      => 'CONDICION DE SALUD ACTUALIZADA',
            ]);

            $old = array();
            $new = array();

            if($data_condicion_old->employee != $data_condicion->employee){
                $old[] = array('trabajador' => $data_condicion_old->employee);
                $new[] = array('trabajador' => $data_condicion->employee);
            }
            if($data_condicion_old->physical_health != $data_condicion->physical_health){
                $old[] = array('salud_fisica' => $data_condicion_old->physical_health);
                $new[] = array('salud_fisica' => $data_condicion->physical_health);
            }
            if($data_condicion_old->mental_health != $data_condicion->mental_health){
                $old[] = array('salud_mental' => $data_condicion_old->mental_health);
                $new[] = array('salud_mental' => $data_condicion->mental_health);
            }
            if($data_condicion_old->psychosocial_risk != $data_condicion->psychosocial_risk){
                $old[] = array('riesgo_psicosocial' => $data_condicion_old->psychosocial_risk);
                $new[] = array('riesgo_psicosocial' => $data_condicion->psychosocial_risk);
            }

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            if($guardarOld != null && $guardarNew != null){
                $update = UpdateInformation::create([
                    'id_log'              => $datos['id'],
                    'changed_information' => $guardarOld,
                    'new_information'     => $guardarNew,
                ]);
            }

            return $data_condicion; 

        }else if($validar == false){
                    
            $condicion_salud = HealthCondition::create([
                'id_student'        => $request['id'],
                'employee'          => $trabajador,
                'physical_health'   => $sld_fisica,
                'mental_health'     => $sld_mntal,
                'psychosocial_risk' => $rsgo_pscosocial,
            ]);

            $ip = User::getRealIP();
            $id = auth()->user();
            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $condicion_salud['id'],
                'actividad_realizada'      => 'NUEVA CONDICION DE SALUD',
            ]);
            
            return $condicion_salud;
        }

    }
    
    public function datos_index(){
        
        $datos = SocioEducationalFollowUp::socioeducativo_reporte();

        $arreglo_datos = array();
   
        foreach($datos as $dato){

            $json_detalle = json_decode($dato->detalle);            

            $arreglo_datos[] = array(
                'id' => $dato->id,
                'name' => $dato->name, 
                'lastname' => $dato->lastname,
                'document_number' => $dato->document_number,
                'grupo_id' => $dato->grupoid,
                'grupo' => $dato->grupo,
                'estado' => $dato->estado,
                'cohorte' => $dato->cohorte,
                'id_profesional' => $dato->id_profesional,
                'nombre_profesional' => $dato->nombre_profesional,
                'apellido_profesional' => $dato->apellido_profersional,
                'cantidad_seguimientos' => $dato->cantidad_seguimientos, 
                'aceptacion1' => $dato->aceptacion1,
                'aceptacion2' => $dato->aceptacion2,
                'riesgo_indivdual' => $json_detalle->RiesgoIndividual,
                'riesgo_academico' => $json_detalle->RiesgoAcademico,
                'riesgo_familiar' => $json_detalle->RiesgoFamiliar,
                'riesgo_economico' => $json_detalle->RiesgoEconomico,
                'riesgo_Uc' => $json_detalle->RiesgoUc,
                'trabajador' => $dato->trabajador,
                'salud_fisica' => $dato->salud_fisica,
                'salud_mental' => $dato->salud_mental,
                'riesgo_psicosocial' => $dato->riesgo_psicosocial, 
                'id_state' => $dato->id_state
            ); 
        }

        $colection_seguimiento = collect($arreglo_datos);
        
        return datatables()->of($colection_seguimiento)->toJson();
                
    }


    public function index_reporte(){
        $seguimiento = SocioEducationalFollowUp::ultimo_seguimiento();
        $ultimo_seguimiento = $seguimiento[0]->created_at; 
       
        return view('socioeducativo.index_reporte', compact('ultimo_seguimiento'));
    }

    public function exportar_reporte_socioeducativo(){

        $estudiantes = DB::select("select student_profile.id, student_profile.name, student_profile.lastname,
            (SELECT document_type.name FROM document_type WHERE document_type.id = 
            student_profile.id_document_type LIMIT 1) as tipodocumento, 
            student_profile.document_number, student_profile.student_code, 
            student_profile.email, student_profile.cellphone, student_groups.id_group as 
            grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, 
            socio_educational_follow_ups.tracking_detail as detalle, 
            formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as 
            aceptacion2, 
            (SELECT health_conditions.employee FROM health_conditions WHERE 
            health_conditions.id_student = student_profile.id LIMIT 1) as trabajador,
            (SELECT health_conditions.physical_health FROM health_conditions WHERE 
            health_conditions.id_student = student_profile.id LIMIT 1) as salud_fisica,
            (SELECT health_conditions.mental_health FROM health_conditions WHERE 
            health_conditions.id_student = student_profile.id LIMIT 1) as salud_mental,
            (SELECT health_conditions.psychosocial_risk FROM health_conditions WHERE 
            health_conditions.id_student = student_profile.id LIMIT 1) as riesgo_psicosocial
            FROM student_profile 
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            INNER JOIN socio_educational_follow_ups on socio_educational_follow_ups.id_student = 
            student_profile.id
            WHERE student_groups.deleted_at IS null
            AND socio_educational_follow_ups.deleted_at IS NULL");

        $estudiantes_colection = collect($estudiantes);
        $excel = array();
        $trabajador;
        $salud_fisica;
        $salud_mental;
        $riesgo_psicosocial;
        foreach($estudiantes_colection as $estudiante_colection){

            if($estudiante_colection->trabajador !== null){
                if($estudiante_colection->trabajador == 1){
                    $trabajador = 'SI';
                }else if($estudiante_colection->trabajador == 0){
                    $trabajador = 'NO';
                }
            }else{
                $trabajador = null;
            }

            if($estudiante_colection->salud_fisica !== null){
                if($estudiante_colection->salud_fisica == 1){
                    $salud_fisica = 'SI';
                }else if($estudiante_colection->salud_fisica == 0){
                    $salud_fisica = 'NO';
                }
            }else{
                $salud_fisica = null;
            }

            if($estudiante_colection->salud_mental !== null){
                if($estudiante_colection->salud_mental == 1){
                    $salud_mental = 'SI';
                }else if($estudiante_colection->salud_mental == 0){
                    $salud_mental = 'NO';
                }
            }else{
                $salud_mental = null;
            }

            if($estudiante_colection->riesgo_psicosocial !== null){
                if($estudiante_colection->riesgo_psicosocial == 1){
                    $riesgo_psicosocial = 'SI';
                }else if($estudiante_colection->riesgo_psicosocial == 0){
                    $riesgo_psicosocial = 'NO';
                }
            }else{
                $riesgo_psicosocial = null;
            }

            $detalle_seguimiento = json_decode($estudiante_colection->detalle);    
            
            $excel[] = array('id' => $estudiante_colection->id,
                            'nombres' => $estudiante_colection->name,
                            'apellidos' => $estudiante_colection->lastname,
                            'tipo_documento' => $estudiante_colection->tipodocumento,
                            'numero documento' => $estudiante_colection->document_number,
                            'codigo' => $estudiante_colection->student_code,
                            'correo' => $estudiante_colection->email, 
                            'telefono' => $estudiante_colection->cellphone,
                            'cohorte' => $estudiante_colection->cohorte,
                            'grupo' => $estudiante_colection->grupo, 
                            'estado' => $estudiante_colection->estado, 
                            'aceptacion1' => $estudiante_colection->aceptacion1,
                            'aceptacion2' => $estudiante_colection->aceptacion2,
                            'trabajador' => $trabajador,
                            'salud_fisica' => $salud_fisica,
                            'salud_mental' => $salud_mental,
                            'riesgo_psicosocial' => $riesgo_psicosocial, 
                            'fecha_seguimiento' => $detalle_seguimiento->fecha, 
                            'lugar_seguimiento' => $detalle_seguimiento->Lugar,
                            'hora_inicio' => $detalle_seguimiento->HoraInicio,
                            'hora_fin' => $detalle_seguimiento->HoraFin, 
                            'objetivos' => $detalle_seguimiento->Objetivos, 
                            'descripcion_individual' => $detalle_seguimiento->Individual, 
                            'riesgo_indivdual' => $detalle_seguimiento->RiesgoIndividual,
                            'descripcion_academica' => $detalle_seguimiento->Academico,
                            'riesgo_academico' => $detalle_seguimiento->RiesgoAcademico,
                            'descripcion_familiar' => $detalle_seguimiento->Familiar,
                            'riesgo_familiar' => $detalle_seguimiento->RiesgoFamiliar,
                            'descripcion_economica' => $detalle_seguimiento->Economico,
                            'riesgo_eonomico' => $detalle_seguimiento->RiesgoEconomico, 
                            'escripcion_vdaunvrstriaycdad' => $detalle_seguimiento->VidaUniversitariaYciudad,
                            'riesgo_vdaunvrstriaycdad' => $detalle_seguimiento->RiesgoUc,
                            'observaciones' => $detalle_seguimiento->Observaciones);
        }      

        $exportar = new SocioeducativoExport([$excel]);

        return Excel::download($exportar, 'socioeducativo_reporte.xlsx');
    }
    
    public function caracterizacion_index(){
        return view('socioeducativo.index_caracterizacion');
    }

    public function datos_caracterizacion(){

        if(Storage::disk('local')->exists('caracterizacion_marzo.json')){
            $caracterizacion = json_decode(Storage::get('caracterizacion_marzo.json'));
            
            $datos = collect($caracterizacion);
            //dd($datos);
            
            return datatables()->of($datos)->toJson();   
        }else{

            $datos = AnswersSocioeducationalForm::select('id_student', 'date_diligence', 'try')->distinct()->where('try', 1)->get();
            $datos->map(function($ids){
            
                $datos = perfilEstudiante::withTrashed()->select('id','name', 'lastname', 'id_document_type','document_number', 'id_state')->where('id', $ids->id_student)->first();
                $ids->nombres = $datos->name;
                $ids->apellidos = $datos->lastname;
                $ids->tipo_documento = $datos->documenttype ? $datos->documenttype->name : null;
                $ids->documento = $datos->document_number;
                $ids->grupo = $datos->studentGroup ? $datos->studentGroup->group->name : null;
                $ids->cohorte = $datos->studentGroup ? $datos->studentGroup->group->cohort->name : null;
                $ids->estado = $datos->condition ? $datos->condition->name : null;
                $name_prof = $datos->assignmentstudent ? $datos->assignmentstudent->UserInfo->name : null;
                $lastname_prof = $datos->assignmentstudent ? $datos->assignmentstudent->UserInfo->apellidos_user : null; 
                $ids->profesional = $name_prof .' '.$lastname_prof;
                $respuesta = AnswersSocioeducationalForm::select('id_question','answers', 'score')->where('id_student', $ids->id_student)->where('try', 1)->whereNotBetween('id_question', [50, 53])->get();
 
                foreach($respuesta as $respuestas){
                    switch($respuestas->id_question){
                        case '1':
                            $ids->pre_1 = $respuestas->answers;
                            $ids->score_1 = $respuestas->score;
                        break;
                        case '2':
                            $ids->pre_2 = $respuestas->answers;
                            $ids->score_2 = $respuestas->score;
                        break;
                        case '3':
                            $ids->pre_3 = $respuestas->answers;
                            $ids->score_3 = $respuestas->score;
                        break;
                        case '4':
                            $ids->pre_4 = $respuestas->answers;
                            $ids->score_4 = $respuestas->score;
                        break;
                        case '5':
                            $ids->pre_5 = $respuestas->answers;
                            $ids->score_5 = $respuestas->score;
                        break;
                        case '6':
                            $ids->pre_6 = $respuestas->answers;
                            $ids->score_6 = $respuestas->score;
                        break;
                        case '7':
                            $ids->pre_7 = $respuestas->answers;
                            $ids->score_7 = $respuestas->score;
                        break;
                        case '8':
                            $ids->pre_8 = $respuestas->answers;
                            $ids->score_8 = $respuestas->score;
                        break;
                        case '9':
                            $ids->pre_9 = $respuestas->answers;
                            $ids->score_9 = $respuestas->score;
                        break;
                        case '10':
                            $ids->pre_10 = $respuestas->answers;
                            $ids->score_10 = $respuestas->score;
                        break;
                        case '11':
                            $ids->pre_11 = $respuestas->answers;
                            $ids->score_11 = $respuestas->score;
                        break;
                        case '12':
                            $ids->pre_12 = $respuestas->answers;
                            $ids->score_12 = $respuestas->score;
                        break;
                        case '13':
                            $ids->pre_13 = $respuestas->answers;
                            $ids->score_13 = $respuestas->score;
                        break;
                        case '14':
                            $ids->pre_14 = $respuestas->answers;
                            $ids->score_14 = $respuestas->score;
                        break;
                        case '15':
                            $ids->pre_15 = $respuestas->answers;
                            $ids->score_15 = $respuestas->score;
                        break;
                        case '16':
                            $ids->pre_16 = $respuestas->answers;
                            $ids->score_16 = $respuestas->score;
                        break;
                        case '17':
                            $ids->pre_17 = $respuestas->answers;
                            $ids->score_17 = $respuestas->score;
                        break;
                        case '18':
                            $ids->pre_18 = $respuestas->answers;
                            $ids->score_18 = $respuestas->score;
                        break;
                        case '19':
                            $ids->pre_19 = $respuestas->answers;
                            $ids->score_19 = $respuestas->score;
                        break;
                        case '20':
                            $ids->pre_20 = $respuestas->answers;
                            $ids->score_20 = $respuestas->score;
                        break;
                        case '21':
                            $ids->pre_21 = $respuestas->answers;
                            $ids->score_21 = $respuestas->score;
                        break;
                        case '22':
                            $ids->pre_22 = $respuestas->answers;
                            $ids->score_22 = $respuestas->score;
                        break;
                        case '22':
                            $ids->pre_22 = $respuestas->answers;
                            $ids->score_22 = $respuestas->score;
                        break;
                        case '23':
                            $ids->pre_23 = $respuestas->answers;
                            $ids->score_23 = $respuestas->score;
                        break;
                       case '24':
                            $ids->pre_24 = $respuestas->answers;
                            $ids->score_24 = $respuestas->score;
                        break;
                        case '25':
                            $ids->pre_25 = $respuestas->answers;
                            $ids->score_25 = $respuestas->score;
                        break;
                        case '26':
                            $ids->pre_26 = $respuestas->answers;
                            $ids->score_26 = $respuestas->score;
                        break;
                        case '27':
                            $ids->pre_27 = $respuestas->answers;
                            $ids->score_27 = $respuestas->score;
                        break;
                        case '28':
                            $ids->pre_28 = $respuestas->answers;
                            $ids->score_28 = $respuestas->score;
                        break;
                        case '29':
                            $ids->pre_29 = $respuestas->answers;
                            $ids->score_29 = $respuestas->score;
                        break;
                        case '30':
                            $ids->pre_30 = $respuestas->answers;
                            $ids->score_30 = $respuestas->score;
                        break;
                        case '31':
                            $ids->pre_31 = $respuestas->answers;
                            $ids->score_31 = $respuestas->score;
                        break;
                        case '32':
                            $ids->pre_32 = $respuestas->answers;
                            $ids->score_32 = $respuestas->score;
                        break;
                        case '33':
                            $ids->pre_33 = $respuestas->answers;
                            $ids->score_33 = $respuestas->score;
                        break;
                        case '34':
                            $ids->pre_34 = $respuestas->answers;
                            $ids->score_34 = $respuestas->score;
                        break;
                        case '35':
                            $ids->pre_35 = $respuestas->answers;
                            $ids->score_35 = $respuestas->score;
                        break;
                        case '36':
                            $ids->pre_36 = $respuestas->answers;
                            $ids->score_36 = $respuestas->score;
                        break;
                        case '37':
                            $ids->pre_37 = $respuestas->answers;
                            $ids->score_37 = $respuestas->score;
                        break;
                        case '38':
                            $ids->pre_38 = $respuestas->answers;
                            $ids->score_38 = $respuestas->score;
                        break;
                        case '39':
                            $ids->pre_39 = $respuestas->answers;
                            $ids->score_39 = $respuestas->score;
                        break;
                        case '40':
                            $ids->pre_40 = $respuestas->answers;
                            $ids->score_40 = $respuestas->score;
                        break;
                        case '41':
                            $ids->pre_41 = $respuestas->answers;
                            $ids->score_41 = $respuestas->score;
                        break;
                        case '42':
                            $ids->pre_42 = $respuestas->answers;
                            $ids->score_42 = $respuestas->score;
                        break;
                        case '43':
                            $ids->pre_43 = $respuestas->answers;
                            $ids->score_43 = $respuestas->score;
                        break;
                        case '44':
                            $ids->pre_44 = $respuestas->answers;
                            $ids->score_44 = $respuestas->score;
                        break;
                        case '45':
                            $ids->pre_45 = $respuestas->answers;
                            $ids->score_45 = $respuestas->score;
                        break;
                        case '46':
                            $ids->pre_46 = $respuestas->answers;
                            $ids->score_46 = $respuestas->score;
                        break;
                        case '47':
                            $ids->pre_47 = $respuestas->answers;
                            $ids->score_47 = $respuestas->score;
                        break;
                        case '48':
                            $ids->pre_48 = $respuestas->answers;
                            $ids->score_48 = $respuestas->score;
                        break;
                        case '49':
                            $ids->pre_49 = $respuestas->answers;
                            $ids->score_49 = $respuestas->score;
                        break;
                        case '54':
                            $ids->pre_54 = $respuestas->answers;
                            $ids->score_54 = $respuestas->score;
                        break;
                        case '55':
                            $ids->pre_55 = $respuestas->answers;
                            $ids->score_55 = $respuestas->score;
                        break;
                        case '56':
                            $ids->pre_56 = $respuestas->answers;
                            $ids->score_56 = $respuestas->score;
                        break;
                        case '57':
                            $ids->pre_57 = $respuestas->answers;
                            $ids->score_57 = $respuestas->score;
                        break;
                        case '58':
                            $ids->pre_58 = $respuestas->answers;
                            $ids->score_58 = $respuestas->score;
                        break;
                        default:                                        
                            echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADO";
                        break;
                    }
                }

            });
        
            $json_datos = json_encode($datos);
            Storage::disk('local')->put('caracterizacion_marzo.json', $json_datos);
            $caracterizacion = json_decode(Storage::get('caracterizacion_marzo.json'));
            $datos = collect($caracterizacion);
            return datatables()->of($datos)->toJson();
        }
    }

    public function datos_caracterizacion_mayo(){
        
        if(Storage::disk('local')->exists('caracterizacion_mayo.json')){
            $caracterizacion = json_decode(Storage::get('caracterizacion_mayo.json'));
            
            $datos = collect($caracterizacion);
            //dd($datos);
            
            return datatables()->of($datos)->toJson();   
        }else{

            $datos = AnswersSocioeducationalForm::select('id_student', 'date_diligence', 'try')->distinct()->where('try', 2)->get();
            $datos->map(function($ids){
            
                $datos = perfilEstudiante::withTrashed()->select('id','name', 'lastname', 'id_document_type', 'document_number', 'id_state')->where('id', $ids->id_student)->first();
                $ids->nombres = $datos->name;
                $ids->apellidos = $datos->lastname;
                $ids->tipo_documento = $datos->documenttype ? $datos->documenttype->name : null;
                $ids->documento = $datos->document_number;
                $ids->grupo = $datos->studentGroup ? $datos->studentGroup->group->name : null;
                $ids->cohorte = $datos->studentGroup ? $datos->studentGroup->group->cohort->name : null;
                $ids->estado = $datos->condition ? $datos->condition->name : null;
                $name_prof = $datos->assignmentstudent ? $datos->assignmentstudent->UserInfo->name : null;
                $lastname_prof = $datos->assignmentstudent ? $datos->assignmentstudent->UserInfo->apellidos_user : null; 
                $ids->profesional = $name_prof .' '.$lastname_prof;
                $respuesta = AnswersSocioeducationalForm::select('id_question','answers', 'score')->where('id_student', $ids->id_student)->where('try', 2)->get();
                //dd($respuesta);
                foreach($respuesta as $respuestas){
                    switch($respuestas->id_question){
                        case '1':
                            $ids->pre_1 = $respuestas->answers;
                            $ids->score_1 = $respuestas->score;
                        break;
                        case '2':
                            $ids->pre_2 = $respuestas->answers;
                            $ids->score_2 = $respuestas->score;
                        break;
                        case '3':
                            $ids->pre_3 = $respuestas->answers;
                            $ids->score_3 = $respuestas->score;
                        break;
                        case '4':
                            $ids->pre_4 = $respuestas->answers;
                            $ids->score_4 = $respuestas->score;
                        break;
                        case '5':
                            $ids->pre_5 = $respuestas->answers;
                            $ids->score_5 = $respuestas->score;
                        break;
                        case '6':
                            $ids->pre_6 = $respuestas->answers;
                            $ids->score_6 = $respuestas->score;
                        break;
                        case '7':
                            $ids->pre_7 = $respuestas->answers;
                            $ids->score_7 = $respuestas->score;
                        break;
                        case '8':
                            $ids->pre_8 = $respuestas->answers;
                            $ids->score_8 = $respuestas->score;
                        break;
                        case '9':
                            $ids->pre_9 = $respuestas->answers;
                            $ids->score_9 = $respuestas->score;
                        break;
                        case '10':
                            $ids->pre_10 = $respuestas->answers;
                            $ids->score_10 = $respuestas->score;
                        break;
                        case '11':
                            $ids->pre_11 = $respuestas->answers;
                            $ids->score_11 = $respuestas->score;
                        break;
                        case '12':
                            $ids->pre_12 = $respuestas->answers;
                            $ids->score_12 = $respuestas->score;
                        break;
                        case '13':
                            $ids->pre_13 = $respuestas->answers;
                            $ids->score_13 = $respuestas->score;
                        break;
                        case '14':
                            $ids->pre_14 = $respuestas->answers;
                            $ids->score_14 = $respuestas->score;
                        break;
                        case '15':
                            $ids->pre_15 = $respuestas->answers;
                            $ids->score_15 = $respuestas->score;
                        break;
                        case '16':
                            $ids->pre_16 = $respuestas->answers;
                            $ids->score_16 = $respuestas->score;
                        break;
                        case '17':
                            $ids->pre_17 = $respuestas->answers;
                            $ids->score_17 = $respuestas->score;
                        break;
                        case '18':
                            $ids->pre_18 = $respuestas->answers;
                            $ids->score_18 = $respuestas->score;
                        break;
                        case '19':
                            $ids->pre_19 = $respuestas->answers;
                            $ids->score_19 = $respuestas->score;
                        break;
                        case '20':
                            $ids->pre_20 = $respuestas->answers;
                            $ids->score_20 = $respuestas->score;
                        break;
                        case '21':
                            $ids->pre_21 = $respuestas->answers;
                            $ids->score_21 = $respuestas->score;
                        break;
                        case '22':
                            $ids->pre_22 = $respuestas->answers;
                            $ids->score_22 = $respuestas->score;
                        break;
                        case '22':
                            $ids->pre_22 = $respuestas->answers;
                            $ids->score_22 = $respuestas->score;
                        break;
                        case '23':
                            $ids->pre_23 = $respuestas->answers;
                            $ids->score_23 = $respuestas->score;
                        break;
                       case '24':
                            $ids->pre_24 = $respuestas->answers;
                            $ids->score_24 = $respuestas->score;
                        break;
                        case '25':
                            $ids->pre_25 = $respuestas->answers;
                            $ids->score_25 = $respuestas->score;
                        break;
                        case '26':
                            $ids->pre_26 = $respuestas->answers;
                            $ids->score_26 = $respuestas->score;
                        break;
                        case '27':
                            $ids->pre_27 = $respuestas->answers;
                            $ids->score_27 = $respuestas->score;
                        break;
                        case '28':
                            $ids->pre_28 = $respuestas->answers;
                            $ids->score_28 = $respuestas->score;
                        break;
                        case '29':
                            $ids->pre_29 = $respuestas->answers;
                            $ids->score_29 = $respuestas->score;
                        break;
                        case '30':
                            $ids->pre_30 = $respuestas->answers;
                            $ids->score_30 = $respuestas->score;
                        break;
                        case '31':
                            $ids->pre_31 = $respuestas->answers;
                            $ids->score_31 = $respuestas->score;
                        break;
                        case '32':
                            $ids->pre_32 = $respuestas->answers;
                            $ids->score_32 = $respuestas->score;
                        break;
                        case '33':
                            $ids->pre_33 = $respuestas->answers;
                            $ids->score_33 = $respuestas->score;
                        break;
                        case '34':
                            $ids->pre_34 = $respuestas->answers;
                            $ids->score_34 = $respuestas->score;
                        break;
                        case '35':
                            $ids->pre_35 = $respuestas->answers;
                            $ids->score_35 = $respuestas->score;
                        break;
                        case '36':
                            $ids->pre_36 = $respuestas->answers;
                            $ids->score_36 = $respuestas->score;
                        break;
                        case '37':
                            $ids->pre_37 = $respuestas->answers;
                            $ids->score_37 = $respuestas->score;
                        break;
                        case '38':
                            $ids->pre_38 = $respuestas->answers;
                            $ids->score_38 = $respuestas->score;
                        break;
                        case '39':
                            $ids->pre_39 = $respuestas->answers;
                            $ids->score_39 = $respuestas->score;
                        break;
                        case '40':
                            $ids->pre_40 = $respuestas->answers;
                            $ids->score_40 = $respuestas->score;
                        break;
                        case '41':
                            $ids->pre_41 = $respuestas->answers;
                            $ids->score_41 = $respuestas->score;
                        break;
                        case '42':
                            $ids->pre_42 = $respuestas->answers;
                            $ids->score_42 = $respuestas->score;
                        break;
                        case '43':
                            $ids->pre_43 = $respuestas->answers;
                            $ids->score_43 = $respuestas->score;
                        break;
                        case '44':
                            $ids->pre_44 = $respuestas->answers;
                            $ids->score_44 = $respuestas->score;
                        break;
                        case '45':
                            $ids->pre_45 = $respuestas->answers;
                            $ids->score_45 = $respuestas->score;
                        break;
                        case '46':
                            $ids->pre_46 = $respuestas->answers;
                            $ids->score_46 = $respuestas->score;
                        break;
                        case '47':
                            $ids->pre_47 = $respuestas->answers;
                            $ids->score_47 = $respuestas->score;
                        break;
                        case '48':
                            $ids->pre_48 = $respuestas->answers;
                            $ids->score_48 = $respuestas->score;
                        break;
                        case '49':
                            $ids->pre_49 = $respuestas->answers;
                            $ids->score_49 = $respuestas->score;
                        break;
                        case '50':
                            $ids->pre_50 = $respuestas->answers;
                            $ids->score_50 = $respuestas->score;
                        break;
                        case '51':
                            $ids->pre_51 = $respuestas->answers;
                            $ids->score_51 = $respuestas->score;
                        break;
                        case '52':
                            $ids->pre_52 = $respuestas->answers;
                            $ids->score_52 = $respuestas->score;
                        break;
                        case '53':
                            $ids->pre_53 = $respuestas->answers;
                            $ids->score_53 = $respuestas->score;
                        break;
                        case '54':
                            $ids->pre_54 = $respuestas->answers;
                            $ids->score_54 = $respuestas->score;
                        break;
                        case '55':
                            $ids->pre_55 = $respuestas->answers;
                            $ids->score_55 = $respuestas->score;
                        break;
                        case '56':
                            $ids->pre_56 = $respuestas->answers;
                            $ids->score_56 = $respuestas->score;
                        break;
                        case '57':
                            $ids->pre_57 = $respuestas->answers;
                            $ids->score_57 = $respuestas->score;
                        break;
                        case '58':
                            $ids->pre_58 = $respuestas->answers;
                            $ids->score_58 = $respuestas->score;
                        break;
                        default:                                        
                            echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADO";
                        break;
                    }
                }

            });
        
            $json_datos = json_encode($datos);
            Storage::disk('local')->put('caracterizacion_mayo.json', $json_datos);
            $caracterizacion = json_decode(Storage::get('caracterizacion_mayo.json'));
            $datos = collect($caracterizacion);
            
            return datatables()->of($datos)->toJson();
        }
    }
    
    public function index_individual($id){

        $datos = perfilEstudiante::withTrashed()->select('name', 'lastname')->where('id', $id)->firstOrfail();
        $group = StudentGroup::select('id_group')->where('id_student', $id)->firstOrfail();
        $grupo = Group::select('name', 'id_cohort')->where('id', $group->id_group)->firstOrfail();
        $linea = Cohort::select('name')->where('id', $grupo->id_cohort)->firstOrfail();
        $asignacion = AssignmentStudent::select('id_user')->where('id_student', $id)->firstOrfail();
        $usuario = User::select('name', 'apellidos_user')->where('id', $asignacion->id_user)->firstOrfail();
        
        return view('socioeducativo.individual.index', compact('datos', 'grupo', 'linea', 'usuario'));
    }

    public function datos_caracterizacion_individual(Request $request){
        //dd($request['parametro']);
        $informacion = AnswersSocioeducationalForm::all()->where('id_student', $request['parametro']);
        //dd($informacion);
        $informacion->map(function($datos){
            $datos->name_question = $datos->socioeducationalform ? $datos->socioeducationalform->question : null;
            //dd($datos->try);
            $primer_diligenciamiento = '';
            $segundo_diligenciamiento = '';
            switch($datos->try){
                case '1':
                    $primer_diligenciamiento = $datos->answers;
                break;
                case '2':
                    $segundo_diligenciamiento = $datos->answers;
                break;
                default:                                        
                    echo "ERROR POR FAVOR CONTACTE AL ADMINISTRADOR";
                break;
            }
            $datos->primer_diligenciamiento = $primer_diligenciamiento;
            $datos->segundo_diligenciamiento = $segundo_diligenciamiento; 
        });
        return datatables()->of($informacion)->toJson();
    }
    
    public function tabla_modal_socioeducativo(Request $request){

        $seguimientos = SocioEducationalFollowUp::where('id_student',$request->id_student)->get();


        $arreglo_datos = array();
   
        foreach($seguimientos as $dato){

            $json_detalle = json_decode($dato->tracking_detail);
            //dd($json_detalle);            
            $arreglo_datos[] = array(
                'fecha'            => $json_detalle->fecha,
                'lugar'            => $json_detalle->Lugar,  
                'riesgo_indivdual' => $json_detalle->RiesgoIndividual,
                'riesgo_academico' => $json_detalle->RiesgoAcademico,
                'riesgo_familiar' => $json_detalle->RiesgoFamiliar,
                'riesgo_economico' => $json_detalle->RiesgoEconomico,
                'riesgo_Uc' => $json_detalle->RiesgoUc
            );
        }

        //dd($arreglo_datos);    
        $colection_seguimiento = collect($arreglo_datos);
        
        return datatables()->of($colection_seguimiento)->toJson();
    }
}
