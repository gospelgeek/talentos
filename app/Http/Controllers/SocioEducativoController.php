<?php

namespace App\Http\Controllers;

use App\AssignmentStudent;
use App\SocioEducationalFollowUp;
use App\HealthCondition;
use App\LogsCrudActions;
use App\UpdateInformation;
use App\Exports\SocioeducativoExport;
use App\User;
use Response;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
