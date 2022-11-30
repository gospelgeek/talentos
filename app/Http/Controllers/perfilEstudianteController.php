<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Exports\SabanaExport;
use App\Exports\SabanaExportCompleta;
use App\Exports\RetirosExport;
use App\Exports\ReporteExport;
use App\Exports\SocioeducativoExport;
use App\perfilEstudiante;
use App\AdmissionScores;
use App\SocioeconomicData;
use App\PreviousAcademicData;
use App\LogsCrudActions;
use App\User;
use App\Gender;
use App\DocumentType;
use App\BirthDepartament;
use App\Tutor;
use App\Withdrawals;
use App\UpdateInformation;
use App\BirthCity;
use App\Condition;
use App\Reasons;
use App\Occupation;
use App\CivilStatus;
use App\RecidenceTime;
use App\HousingType;
use App\HealthRegime;
use App\Benefits;
use App\SocialConditions;
use App\Disability;
use App\Ethnicity;
use App\Neighborhood;
use App\Formalization;
use App\InstitutionType;
use App\Course;
use App\Comune;
use App\Group;
use App\Cohort;
use App\AsignementStudents;
use App\StudentGroup;
use App\AssignmentStudent;
use App\SocioEducationalFollowUp;
use App\CourseMoodle;
use App\SessionCourse;
use App\AttendanceStudent;
use App\Http\Requests\perfilEstudianteRequest;
use App\Http\Requests\DatosSocioeconomicosRequest;
use App\Http\Requests\DatosAcademicosRequest;
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
use App\Programs;
use App\ProgramOptions;
use App\IcfesStudent;
use App\Rating;

class perfilEstudianteController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function mostrar(Request $request)
    {
         
        $user = auth()->user();
        
        if ($user['rol_id'] == 6) {

            if($request['todos'] === "true"){

                $estudiantes = perfilEstudiante::estudiantes_asignacion();

                return datatables()->of($estudiantes)->toJson();    
            }
            if($request['admitidos'] === "true"){
                //dd('entro a admitidos');
                $estudiantes = perfilEstudiante::estudiantes_admitidos();
                if($estudiantes != null){
                    return datatables()->of($estudiantes)->toJson();    
                }else{                
                    $validar = collect($estudiantes);
                    return datatables()->of($validar)->toJson();
                }
            }
            if($request['activos'] === "true"){
            
                $estudiantes = perfilEstudiante::estudiantes_activos_asignacion();
            
                return datatables()->of($estudiantes)->toJson();

            }
            if($request['inactivos'] === "true"){
            
                $estudiantes = perfilEstudiante::estudiantes_inactivos_asignacion();

                return datatables()->of($estudiantes)->toJson();    
            }
        }
        
        if($request['todos'] === "true")
        {
            //dd('entro a todos');
            $estudiantes = perfilEstudiante::estudiantes();
           
            return datatables()->of($estudiantes)->toJson();

        }
        if($request['admitidos'] === "true"){
            //dd('entro a admitidos');
            $estudiantes = perfilEstudiante::estudiantes_admitidos();
            if($estudiantes != null){
                return datatables()->of($estudiantes)->toJson();    
            }else{                
                $validar = collect($estudiantes);
                return datatables()->of($validar)->toJson();
            }
        }
        if($request['activos'] === "true"){
            //dd('entro a activos');
            $estudiantes = perfilEstudiante::estudiantes_activos();
            
            return datatables()->of($estudiantes)->toJson();

        }
        if($request['inactivos'] === "true"){
            //dd('entro a inactivos');
            $estudiantes = perfilEstudiante::estudiantes_inactivos();

            return datatables()->of($estudiantes)->toJson();    
        }
    }

    public function indexPerfilEstudiante()
    {
        
        $genero = Gender::pluck('name', 'id');
        $sexo = array(
            'F' => 'Fenemino',
            'M' => 'Masculino'
        );
        $tipo_documento = array(
            '1' => 'Cedula de Ciudadania',
            '2' => 'Tarjeta de Identidad',
            '3' => 'Cedula Extranjera'
        );

        $depNacimiento = BirthDepartament::pluck('name', 'id');
        $muni_nacimiento = BirthCity::pluck('name', 'id');
        $barrios = Neighborhood::pluck('name', 'id');
        $comunas = Comune::pluck('name', 'id');
        $tutor = Tutor::pluck('name', 'id');
        $cohorte = Cohort::pluck('name', 'id');
        $grupo = Group::pluck('name', 'id');
        $profersinal = User::where('rol_id', 6)->pluck('name', 'id');
        $ultimo_registro = Withdrawals::ultimo_registro();
        $valor_ultimo = $ultimo_registro[0]->created_at;
         
        return view('perfilEstudiante.index', compact('tipo_documento', 'depNacimiento', 'muni_nacimiento', 'sexo','genero', 'comunas', 'barrios', 'tutor','cohorte', 'grupo', 'profersinal', 'valor_ultimo'));
    }

    public function mostrarMenores()
    {

        $mayoriaedad = perfilEstudiante::mayoriaEdad();

        return datatables()->of($mayoriaedad)->toJson();
    }

    public function indexMenores()
    {
        $cumpleaños = perfilEstudiante::ultimo_cumpleaños();
        
        $cumpleaños_ultimos = $cumpleaños[0]->birth_date;
        
        return view('perfilEstudiante.indexMenores', compact('cumpleaños_ultimos'));
    }

    public function storePerfilEstudiante(perfilEstudianteRequest $request)
    {
        $mensaje = 'ESTUDIANTE CREADO EXITOSAMENTE!';

        $estudiante = perfilEstudiante::create([
            'name'                      =>  $request['name'],
            'lastname'                  =>  $request['lastname'],
            'id_document_type'          =>  $request['id_document_type'],
            'document_number'           =>  $request['document_number'],
            'birth_date'                =>  $request['birth_date'],
            'id_birth_department'       =>  $request['id_birth_department'],
            'id_birth_city'             =>  $request['id_birth_city'],
            'email'                     =>  $request['email'],
            'sex'                       =>  $request['sex'],
            'id_gender'                 =>  $request['id_gender'],
            'id_commune'                =>  $request['id_commune'],
            'id_neighborhood'           =>  $request['id_neighborhood'],
            'direction'                 =>  $request['direction'],
            'id_tutor'                  =>  $request['id_tutor'],
            'student_code'              =>  $request['student_code'],
            'id_moodle'                 =>  $request['id_moodle'],
            'cellphone'                 =>  $request['cellphone'],
            'phone'                     =>  $request['phone'],
            'first_name'                =>  $request['first_name'],
            'id_state'                  => 1,
        ]);

        $group_student = StudentGroup::create([
            'id_student'  => $estudiante['id'],
            'id_group'    => $request['id_group'], 
        ]);

        $admission_scores = AdmissionScores::create([
            'id_student' => $estudiante['id'],
        ]);

        $formalization = Formalization::create([
            'id_student' => $estudiante['id'],
        ]);

        $previous_academic = PreviousAcademicData::create([
            'id_student' => $estudiante['id'],
        ]);

        $socioeconomicdata = SocioeconomicData::create([
            'id_student' => $estudiante['id'],
        ]);

        

        $ip = User::getRealIP();
        $id = auth()->user();
        $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y h:i:s A');
        //dd($fecha);
        $datos = LogsCrudActions::create([
            'id_user'                  => $id['id'],
            'rol'                      => $id['rol_id'],
            'ip'                       => $ip,
            'id_usuario_accion'        => $estudiante['id'],
            'actividad_realizada'      => 'SE CREO UN REGISTRO',
        ]);

        return $mensaje;
    }

    public function verPerfilEstudiante($id)
    {
        $iden = $id;
        $verDatosPerfil = perfilEstudiante::withTrashed()->findOrFail($id);
        //return $id;
        /* $user = auth()->user();
        /*if($user['rol_id'] == 6){
            $idUser = $user['id'];
            $dt = AssignmentStudent::where('id_student', $id)->where('id_user', $idUser)->exists();
            if( $dt == true){
                $verDatosPerfil = perfilEstudiante::findOrFail($id);
            }else{ 
                return Redirect::to('/estudiante');
            }           
        }*/

        $totalS1 = DB::select("SELECT icfes_students.total_score as total1 
        FROM icfes_students WHERE icfes_students.id_student = ? 
        AND icfes_students.id_icfes_test = 1", [$id]);

        $totalS2 = DB::select("SELECT icfes_students.total_score as total2 
        FROM icfes_students WHERE icfes_students.id_student = ? 
        AND icfes_students.id_icfes_test = 2", [$id]);
        
        $totalS3 = DB::select("SELECT icfes_students.total_score as total3 
        FROM icfes_students WHERE icfes_students.id_student = ? 
        AND icfes_students.id_icfes_test = 3", [$id]);

        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        
        if($totalS1 == []){
            $t1 = 0;
        }else {
            $t1 = $totalS1[0]->total1;
        }

        if($totalS2 == []){
            $t2 = 0;
        }else {
            $t2 = $totalS2[0]->total2;
        }
        
        if($totalS3 == []){
            //dd($t2);
            $t3 = 0;
        }else {
            $t3 = $totalS3[0]->total3;
        }
        
        $totalSimulacros = $t1 + $t2;
        
        $url_entrada = DB::select("SELECT icfes_students.url_support as url FROM 
        icfes_students WHERE id_icfes_test = 4 AND id_student = ?", [$id]);

        $url_salida = DB::select("SELECT icfes_students.url_support as url FROM 
        icfes_students WHERE id_icfes_test = 5 AND id_student = ?", [$id]);

        $pruebaS1 = DB::select("SELECT id_icfes_test as prueba FROM icfes_students WHERE id_icfes_test = 1 AND id_student = ?", [$id]);
        $pruebaS2 = DB::select("SELECT id_icfes_test as prueba FROM icfes_students WHERE id_icfes_test = 2 AND id_student = ?", [$id]);
        $pruebaS3 = DB::select("SELECT id_icfes_test as prueba FROM icfes_students WHERE id_icfes_test = 3 AND id_student = ?", [$id]);
        $pruebaS4 = DB::select("SELECT id_icfes_test as prueba FROM icfes_students WHERE id_icfes_test = 4 AND id_student = ?", [$id]);
        $pruebaS5 = DB::select("SELECT id_icfes_test as prueba FROM icfes_students WHERE id_icfes_test = 5 AND id_student = ?", [$id]);
        
        //$verDatosPerfil = perfilEstudiante::withTrashed()->findOrFail($id);
        //$verDatosPerfil = perfilEstudiante::findOrFail($id);
        $asignacion = AssignmentStudent::where('id_student', $id)->first();
        $cohort = $verDatosPerfil->studentGroup->group->cohort->id;
        
        $variacion = 0;

        if($cohort == 1 || $cohort == 2){
            $dataIcfesEn = DB::select("SELECT icfes_students.total_score as puntajeEntrada FROM 
                icfes_students WHERE id_icfes_test = 4 AND id_student = ?", [$id]);
            if($dataIcfesEn == []){ $variacion = 0;}else{$variacion = $dataIcfesEn[0]->puntajeEntrada;};
            
        }
        
        $variacionL3 = 0;
        $l3 = 0;
        if($cohort == 3){
            $l3 = 1;
            $dataIcfesS1 = DB::select("SELECT icfes_students.total_score as puntajeS1 FROM 
                icfes_students WHERE id_icfes_test = 1 AND id_student = ?", [$id]);
            if($dataIcfesS1 == []){$variacionL3 = 0;}else{$variacionL3 = $dataIcfesS1[0]->puntajeS1;}
        }
        
        $grupos = Group::where('id_cohort', $cohort)->pluck('name', 'id');
        //return $grupos;

        $seguimientos = SocioEducationalFollowUp::all()->where('id_student', $verDatosPerfil['id']);
        $apoyo_economico = EconomicalSupport::all()->where('id_student', $id);

        $genero = Gender::pluck('name', 'id');
        $sexo = array(
            'F' => 'Femenino',
            'M' => 'Masculino'
        );

        $tipo_documento = array(
            '1' => 'Cedula de Ciudadania',
            '2' => 'Tarjeta de Identidad',
            '3' => 'Cedula Extranjera'
        );
        $documento = DocumentType::pluck('name', 'id');

        $estado = Condition::pluck('name', 'id');

        $motivos = Reasons::pluck('name', 'id');

        $ciudad_nacimiento = BirthCity::pluck('name', 'id');

        $barrio = Neighborhood::pluck('name', 'id');

        $tutor = Tutor::pluck('name', 'id');

        $ocupacion = Occupation::pluck('name', 'id');

        $estado_civil = CivilStatus::pluck('name', 'id');

        $residencia = RecidenceTime::pluck('name', 'id');

        $vivienda = HousingType::pluck('name', 'id');

        $regimen = HealthRegime::pluck('name', 'id');

        $condicion = SocialConditions::pluck('name', 'id');

        $discapacidad = Disability::pluck('name', 'id');

        $etnia = Ethnicity::pluck('name', 'id');

        $edad = Carbon::parse($verDatosPerfil->birth_date)->age;

        $estado = Condition::pluck('name', 'id');

        $beneficios = Benefits::pluck('name', 'id');

        $cohorte = Cohort::pluck('name', 'id');

        $estado = Condition::pluck('name', 'id');
        $motivos = Reasons::pluck('name', 'id');



        $ip = User::getRealIP();
        $id = auth()->user();
        $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y');

        
        //dd($fecha);
        $datos = LogsCrudActions::create([
            'id_user'                  => $id['id'],
            'rol'                      => $id['rol_id'],
            'ip'                       => $ip,
            'id_usuario_accion'        => $verDatosPerfil['id'],
            'actividad_realizada'      => 'ANALISIS DE REGISTRO',
        ]);



        if ($verDatosPerfil->photo == "") {
            $foto = null;
        } else {
            $foto = explode("/", $verDatosPerfil->photo);
            $foto = $foto[5];
        }
        $this->id_moodle = $verDatosPerfil->id_moodle;
        
        $cursos = DB::select("select course_moodles.attendance_id,course_moodles.fullname,COUNT(*) as asistencia
                            FROM `course_moodles`,session_courses,attendance_students 
                            WHERE session_courses.attendance_id = course_moodles.attendance_id 
                            and attendance_students.session_id = session_courses.session_id
                            and attendance_students.grade = 'P' 
                            and attendance_students.id_moodle = '".$verDatosPerfil->id_moodle."'
                            GROUP BY course_moodles.fullname");
        $cursos= collect($cursos);

        $cursos->map(function($curso)
        {
            $curso->sesiones = SessionCourse::where('attendance_id',$curso->attendance_id)->count();
            //dd($curso);
        });
        

        return view('perfilEstudiante.verDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'seguimientos', 'cohorte', 'grupos', 'asignacion', 'iden', 'apoyo_economico','cursos', 't1', 't2','t3' ,'totalSimulacros', 'url_entrada', 'url_salida', 'pruebaS1', 'pruebaS2', 'pruebaS3', 'pruebaS4', 'pruebaS5', 'variacion', 'variacionL3', 'l3'));
    }




    public function verDatosSocieconomicos($id)
    {
        //dd($id_student);
        //$datos = SocioeconomicData::all()->where('id_student', $id_student); 
        $datos = perfilEstudiante::findOrFail($id);
        //dd($datos);

        return view('perfilEstudiante.datosSocioeconomicos', compact('datos'));
    }



    public function updateDatosSocioeconomicos($id, Request $request)
    {
        $socio = SocioeconomicData::findOrFail($id);
        $socioOld = SocioeconomicData::findOrFail($id);
       
        $mensaje = "Datos Socieconomicos actualizados correctamente!!";

        if ($request->ajax()) {

            $socio->id_ocupation            = $request['id_ocupation'];
            $socio->id_civil_status         = $request['id_civil_status'];
            $socio->children_number         = $request['children_number'];
            $socio->id_residence_time       = $request['id_residence_time'];
            $socio->id_housing_type         = $request['id_housing_type'];
            $socio->id_health_regime        = $request['id_health_regime'];
            $socio->sisben_category         = $request['sisben_category'];
            $socio->id_benefits             = $request['id_benefits'];
            $socio->household_people        = $request['household_people'];
            $socio->economic_possition      = $request['economic_possition'];
            $socio->dependent_people        = $request['dependent_people'];
            $socio->internet_zon            = $request['internet_zon'];
            $socio->internet_home           = $request['internet_home'];
            $socio->sex_document_identidad  = $request['sex_document_identidad'];
            $socio->id_social_conditions    = $request['id_social_conditions'];
            $socio->id_disability           = $request['id_disability'];
            $socio->id_ethnicity            = $request['id_ethnicity'];
            $socio->eps_name                = $request['eps_name'];
            $socio->url_health_regime       = $request['url_health_regime'];
            $socio->url_sisben_category     = $request['url_sisben_category'];
            $socio->url_social_conditions   = $request['url_social_conditions'];
            $socio->url_ethnicity           = $request['url_ethnicity'];

            $socio->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            $fecha = Carbon::now();
            $fecha = $fecha->format('d-m-Y');

            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $socio['id_student'],
                'actividad_realizada'      => 'ACTUALIZACION DATOS SOCIOECONOMICOS',
            ]);

            $old = array();
            $new = array();

            if($socioOld->id_ocupation != $socio->id_ocupation){
                $old[] = array('ocupacion' => $socioOld->id_ocupation);
                $new[] = array('ocupacion' => $socio->id_ocupation);
            }
            if($socioOld->id_civil_status != $socio->id_civil_status){
                $old[] = array('estado civil' => $socioOld->id_civil_status);
                $new[] = array('estado civil' => $socio->id_civil_status);
            }
            if($socioOld->children_number != $socio->children_number){
                $old[] = array('numero hijos' => $socioOld->children_number);
                $new[] = array('numero hijos' => $socio->children_number);
            }
            if($socioOld->id_residence_time != $socio->id_residence_time){
                $old[] = array('tiempo residencia' => $socioOld->id_residence_time);
                $new[] = array('tiempo residencia' => $socio->id_residence_time);
            }
            if($socioOld->id_housing_type != $socio->id_housing_type){
                $old[] = array('tipo vivienda' => $socioOld->id_housing_type);
                $new[] = array('tipo vivienda' => $socio->id_housing_type);
            }
            if($socioOld->id_health_regime != $socio->id_health_regime){
                $old[] = array('regimen salud' => $socioOld->id_health_regime);
                $new[] = array('regimen salud' => $socio->id_health_regime);
            }
            if($socioOld->sisben_category != $socio->sisben_category){
                $old[] = array('categoria sisben' => $socioOld->sisben_category);
                $new[] = array('categoria sisben' => $socio->sisben_category);
            }
            if($socioOld->id_benefits != $socio->id_benefits){
                $old[] = array('beneficios' => $socioOld->id_benefits);
                $new[] = array('beneficios' => $socio->id_benefits);
            }
            if($socioOld->household_people != $socio->household_people){
                $old[] = array('personas en la familia' => $socioOld->household_people);
                $new[] = array('personas en la familia' => $socio->household_people);
            }
            if($socioOld->economic_possition != $socio->economic_possition){
                $old[] = array('posicion economica' => $socioOld->economic_possition);
                $new[] = array('ocupacion' => $socio->economic_possition);
            }
            if($socioOld->dependent_people != $socio->dependent_people){
                $old[] = array('personas a cargo' => $socioOld->dependent_people);
                $new[] = array('personas a cargo' => $socio->dependent_people);
            }
            if($socioOld->internet_zon != $socio->internet_zon){
                $old[] = array('internet zona' => $socioOld->internet_zon);
                $new[] = array('internet zona' => $socio->internet_zon);
            }
            if($socioOld->internet_home != $socio->internet_home){
                $old[] = array('internet casa' => $socioOld->internet_home);
                $new[] = array('internet casa' => $socio->internet_home);
            }
            if($socioOld->sex_document_identidad != $socio->sex_document_identidad){
                $old[] = array('sexo documento' => $socioOld->sex_document_identidad);
                $new[] = array('sexo documento' => $socio->sex_document_identidad);
            }
            if($socioOld->id_social_conditions != $socio->id_social_conditions){
                $old[] = array('condicion social' => $socioOld->id_social_conditions);
                $new[] = array('condicion social' => $socio->id_social_conditions);
            }
            if($socioOld->id_disability != $socio->id_disability){
                $old[] = array('discapacidad' => $socioOld->id_disability);
                $new[] = array('discapacidad' => $socio->id_disability);
            }
            if($socioOld->id_ethnicity != $socio->id_ethnicity){
                $old[] = array('etnia' => $socioOld->id_ethnicity);
                $new[] = array('etnia' => $socio->id_ethnicity);
            }
            if($socioOld->eps_name != $socio->eps_name){
                $old[] = array('eps' => $socioOld->eps_name);
                $new[] = array('eps' => $socio->eps_name);
            }
            if($socioOld->url_health_regime != $socio->url_health_regime){
                $old[] = array('soporte_regimen_salud' => $socioOld->url_health_regime);
                $new[] = array('soporte_regimen_salud' => $socio->url_health_regime);
            }
            if($socioOld->url_sisben_category != $socio->url_sisben_category){
                $old[] = array('soporte_categoria_sisben' => $socioOld->url_sisben_category);
                $new[] = array('soporte_categoria_sisben' => $socio->url_sisben_category);
            }
            if($socioOld->url_social_conditions != $socio->url_social_conditions){
                $old[] = array('soporte_condicion_social' => $socioOld->url_social_conditions);
                $new[] = array('soporte_condicion_social' => $socio->url_social_conditions);
            }
            if($socioOld->url_ethnicity != $socio->url_ethnicity){
                $old[] = array('soporte_etnia' => $socioOld->url_ethnicity);
                $new[] = array('soporte_etnia' => $socio->url_ethnicity);
            }

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            $update = UpdateInformation::create([
                'id_log'              => $datos['id'],
                'changed_information' => $guardarOld,
                'new_information'     => $guardarNew,
            ]);

        };

        return $mensaje;
    }

    public function verDatosAcademicos($id)
    {
        $datos = perfilEstudiante::findOrFail($id);

        return view('perfilEstudiante.verdatosAcademicos', compact('datos'));
    }


    public function updateDatosAcademicos($id, Request $request)
    {
        $acade = PreviousAcademicData::findOrFail($id);
        $acadeOld = PreviousAcademicData::findOrFail($id);

        $mensaje = "Datos academicos previos actualizados correctamente!!";

        if ($request->ajax()) {

            $acade->institution_name    = $request['institution_name'];
            $acade->year_graduation     = $request['year_graduation'];
            $acade->bachelor_title      = $request['bachelor_title'];
            $acade->icfes_date          = $request['icfes_date'];
            $acade->snp_register        = $request['snp_register'];
            $acade->icfes_score         = $request['icfes_score'];
            $acade->url_academic_support = $request['url_academic_support'];

            $acade->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            $fecha = Carbon::now();
            $fecha = $fecha->format('d-m-Y');
          
            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $acade['id_student'],
                'actividad_realizada'      => 'ACTUALIZACION DATOS ACADEMICOS',
            ]);


            $old = array();
            $new = array();

             if($acadeOld->institution_name != $acade->institution_name){
                $old[] = array('nombre institucion' => $acadeOld->institution_name);
                $new[] = array('nombre institucion' => $acade->institution_name);
            }
            if($acadeOld->year_graduation != $acade->year_graduation){
                $old[] = array('año graduacion' => $acadeOld->year_graduation);
                $new[] = array('año graduacion' => $acade->year_graduation);
            }
            if($acadeOld->bachelor_title != $acade->bachelor_title){
                $old[] = array('titulo bachiller' => $acadeOld->bachelor_title);
                $new[] = array('titulo bachiller' => $acade->bachelor_title);
            }
            if($acadeOld->icfes_date != $acade->icfes_date){
                $old[] = array('fecha icfes' => $acadeOld->icfes_date);
                $new[] = array('fecha icfes' => $acade->icfes_date);
            }
            if($acadeOld->snp_register != $acade->snp_register){
                $old[] = array('registro SNP' => $acadeOld->snp_register);
                $new[] = array('registro SNP' => $acade->snp_register);
            }
            if($acadeOld->icfes_score != $acade->icfes_score){
                $old[] = array('puntaje icfes' => $acadeOld->icfes_score);
                $new[] = array('puntaje icfes' => $acade->icfes_score);
            }
            if($acadeOld->url_academic_support != $acade->url_academic_support){
                $old[] = array('Soporte_academico' => $acadeOld->url_academic_support);
                $new[] = array('Soporte_academico' => $acade->url_academic_support);
            }

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            $update = UpdateInformation::create([
                'id_log'              => $datos['id'],
                'changed_information' => $guardarOld,
                'new_information'     => $guardarNew,
            ]);

        };

        return $mensaje;
    }

    public function editarPerfilEstudiante($id)
    {

        $iden = $id;
        $verDatosPerfil = perfilEstudiante::withTrashed()->findOrFail($id);
        $asignacion = AssignmentStudent::where('id_student', $id)->first();
        $cohort = $verDatosPerfil->studentGroup->group->cohort->id;
        $grupos = Group::where('id_cohort', $cohort)->pluck('name', 'id');
        //return $grupos;


        $seguimientos = SocioEducationalFollowUp::all()->where('id_student', $verDatosPerfil['id']);
        $apoyo_economico = EconomicalSupport::all()->where('id_student', $id);
        
        $genero = Gender::pluck('name', 'id');
        $sexo = array(
            'F' => 'Femenino',
            'M' => 'Masculino'
        );


        $tipo_documento = array(
            '1' => 'Cedula de Ciudadania',
            '2' => 'Tarjeta de Identidad',
            '3' => 'Cedula Extranjera'
        );
        $documento = DocumentType::pluck('name', 'id');

        $estado = Condition::pluck('name', 'id');

        $motivos = Reasons::pluck('name', 'id');

        $ciudad_nacimiento = BirthCity::pluck('name', 'id');

        $barrio = Neighborhood::pluck('name', 'id');

        $tutor = Tutor::pluck('name', 'id');

        $ocupacion = Occupation::pluck('name', 'id');

        $estado_civil = CivilStatus::pluck('name', 'id');

        $residencia = RecidenceTime::pluck('name', 'id');

        $vivienda = HousingType::pluck('name', 'id');

        $regimen = HealthRegime::pluck('name', 'id');

        $condicion = SocialConditions::pluck('name', 'id');

        $discapacidad = Disability::pluck('name', 'id');

        $etnia = Ethnicity::pluck('name', 'id');

        $edad = Carbon::parse($verDatosPerfil->birth_date)->age;

        $estado = Condition::pluck('name', 'id');

        $beneficios = Benefits::pluck('name', 'id');


        $cohorte = Cohort::pluck('name', 'id');


        if ($verDatosPerfil->photo == "") {
            $foto = null;
        } else {
            $foto = explode("/", $verDatosPerfil->photo);
            $foto = $foto[5];
        }

        $depNacimiento = BirthDepartament::pluck('name', 'id');

        $muni_nacimiento = BirthCity::pluck('name', 'id');

        $ciudad = BirthCity::pluck('name', 'id');
        
        $this->id_moodle = $verDatosPerfil->id_moodle;
        
        $cursos = DB::select("select course_moodles.attendance_id,course_moodles.fullname,COUNT(*) as asistencia
                            FROM `course_moodles`,session_courses,attendance_students 
                            WHERE session_courses.attendance_id = course_moodles.attendance_id 
                            and attendance_students.session_id = session_courses.session_id
                            and attendance_students.grade = 'P' 
                            and attendance_students.id_moodle = '".$verDatosPerfil->id_moodle."'
                            GROUP BY course_moodles.fullname");
        $cursos= collect($cursos);

        $cursos->map(function($curso)
        {
            $curso->sesiones = SessionCourse::where('attendance_id',$curso->attendance_id)->count();
            //dd($curso);
        });

        return view('perfilEstudiante.verEditarDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'depNacimiento', 'muni_nacimiento', 'ciudad', 'seguimientos', 'cohorte', 'grupos', 'asignacion', 'iden', 'apoyo_economico','cursos'));
    }



   public function updatePerfilEstudiante($id, Request $request)
    {

        $data = perfilEstudiante::withTrashed()->findOrFail($id);
        $dataOld = perfilEstudiante::withTrashed()->findOrFail($id);

        $mensaje = "Datos generales actualizados correctamente!!";

        $depNacimiento = BirthDepartament::pluck('name', 'id');
        $muni_nacimiento = BirthCity::pluck('name', 'id');


        if ($request->ajax()) {

            $data->name                     = $request['name'];
            $data->lastname                 = $request['lastname'];
            $data->id_document_type         = $request['id_document_type'];
            $data->document_number          = $request['document_number'];
            $data->document_expedition_date = $request['document_expedition_date'];
            $data->email                    = $request['email'];
            $data->birth_date               = $request['birth_date'];
            $data->id_birth_city            = $request['id_birth_city'];
            $data->sex                      = $request['sex'];
            $data->id_gender                = $request['id_gender'];
            $data->cellphone                = $request['cellphone'];
            $data->phone                    = $request['phone'];
            $data->id_neighborhood          = $request['id_neighborhood'];
            $data->direction                = $request['direction'];
            $data->student_code             = $request['student_code'];
            $data->first_name               = $request['first_name'];
            $data->emergency_contact_name   = $request['emergency_contact_name'];
            $data->relationship             = $request['relationship'];
            $data->emergency_contact        = $request['emergency_contact'];
            $data->url_document_type        = $request['url_document_type'];

            $data->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            $fecha = Carbon::now();
            $fecha = $fecha->format('d-m-Y');

            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $data['id'],
                'actividad_realizada'      => 'ACTUALIZACION DATOS GENERALES',
            ]);

            $old = array();
            $new = array();

            if($dataOld->name != $data->name){
                $old[] = array('nombres' => $dataOld->name);
                $new[] = array('nombres' => $data->name);
            }
            if($dataOld->lastname != $data->lastname){
                $old[] = array('apellidos' => $dataOld->lastname);
                $new[] = array('apellidos' => $data->lastname);
            }
            if($dataOld->id_document_type != $data->id_document_type){
                $old[] = array('tipo documento' => $dataOld->id_document_type);
                $new[] = array('tipo documento' => $data->id_document_type);
            }
            if($dataOld->document_number != $data->document_number){
                $old[] = array('numero documento' => $dataOld->document_number);
                $new[] = array('numero documento' => $data->document_number);
            }
            if($dataOld->document_expedition_date != $data->document_expedition_date){
                $old[] = array('fecha expedicion' => $dataOld->document_expedition_date);
                $new[] = array('fecha expedicion' => $data->document_expedition_date);
            }
            if($dataOld->email != $data->email){
                $old[] = array('email' => $dataOld->email);
                $new[] = array('email' => $data->email);
            }
            if($dataOld->birth_date != $data->birth_date){
                $old[] = array('fecha nacimiento' => $dataOld->birth_date);
                $new[] = array('fecha nacimiento' => $data->birth_date);
            }
            if($dataOld->id_birth_city != $data->id_birth_city){
                $old[] = array('ciudad nacimiento' => $dataOld->id_birth_city);
                $new[] = array('ciudad nacimiento' => $data->id_birth_city);
            }
            if($dataOld->sex != $data->sex){
                $old[] = array('sexo' => $dataOld->sex);
                $new[] = array('sexo' => $data->sex);
            }
            if($dataOld->id_gender != $data->id_gender){
                $old[] = array('genero' => $dataOld->id_gender);
                $new[] = array('genero' => $data->id_gender);
            }
            if($dataOld->cellphone != $data->cellphone){
                $old[] = array('celular 1' => $dataOld->cellphone);
                $new[] = array('celular 1' => $data->cellphone);
            }
            if($dataOld->phone != $data->phone){
                $old[] = array('celular 2' => $dataOld->phone);
                $new[] = array('celular 2' => $data->phone);
            }
            if($dataOld->id_neighborhood != $data->id_neighborhood){
                $old[] = array('barrio' => $dataOld->id_neighborhood);
                $new[] = array('barrio' => $data->id_neighborhood);
            }
            if($dataOld->direction != $data->direction){
                $old[] = array('direccion' => $dataOld->direction);
                $new[] = array('direccion' => $data->direction);
            }
            if($dataOld->student_code != $data->student_code){
                $old[] = array('codigo estudiante' => $dataOld->student_code);
                $new[] = array('codigo estudiante' => $data->student_code);
            }
            if($dataOld->first_name != $data->first_name){
                $old[] = array('Nombre Pila' => $dataOld->first_name);
                $new[] = array('Nombre Pila' => $data->first_name);
            }
            if($dataOld->emergency_contact_name != $data->emergency_contact_name){
                $old[] = array('Nombre contacto emergencia' => $dataOld->emergency_contact_name);
                $new[] = array('Nombre contacto emergencia' => $data->emergency_contact_name);
            }
            if($dataOld->relationship != $data->relationship){
                $old[] = array('Parentezco' => $dataOld->relationship);
                $new[] = array('Parentezco' => $data->relationship);
            }
            if($dataOld->emergency_contact != $data->emergency_contact){
                $old[] = array('Contacto emergencia' => $dataOld->emergency_contact);
                $new[] = array('Contacto emergencia' => $data->emergency_contact);
            }
            if($dataOld->url_document_type != $data->url_document_type){
                $old[] = array('soporte_documento' => $dataOld->url_document_type);
                $new[] = array('soporte_documento' => $data->url_document_type);
            }

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            $update = UpdateInformation::create([
                'id_log'              => $datos['id'],
                'changed_information' => $guardarOld,
                'new_information'     => $guardarNew,
            ]);
        };

        return $mensaje;
    }

    public function barrios(Request $request, $id) {

        $barrios = Neighborhood::where('id_commune', $id)->get();
        //dd($municipios);
        if ($request->ajax()) {

            return response()->json($barrios);
        }   
    }

    public function gruposCreate(Request $request, $id) {

        $grupos = Group::where('id_cohort', $id)->get();
        //dd($municipios);
        if ($request->ajax()) {

            return response()->json($grupos);
        } 
    }

    public function municipios(Request $request, $id)
    {
        $municipios = BirthCity::where('id_departament', $id)->get();
        //dd($municipios);
        if ($request->ajax()) {

            return response()->json($municipios);
        }
    }

    public function indexAsignaturas()
    {
        $asignaturas = Course::All();

        //dd($asignaturas);

        return view('perfilEstudiante.asignaturas.index', compact('asignaturas'));
    }

    public function verGrupos($id)
    {
        $name = Course::where('id', $id)->first();
        $grupos = Group::all()->where('id_cohort', $name->id_cohort);

        //dd($name);

        return view('perfilEstudiante.asignaturas.grupos', compact('grupos', 'name'));
    }

    public function vernotas($id)
    {
        $grupo = Group::where('id', $id)->first();

        $notas = StudentGroup::all()->where('id_group', $id);

        //dd($grupo);

        return view('perfilEstudiante.asignaturas.notas', compact('notas', 'id', 'grupo'));
    }


    public function updateEstado($id, Request $request){
       $status = "Estado actualizado correctamente!!";
       //dd($request);
        if($request->ajax())
        {   
            $borrar = Withdrawals::where('id_student', $id)->exists();
            //dd($borrar);

            if($request['id_state'] != 1){
                if($borrar != false){
                   $estado2 = perfilEstudiante::withTrashed()->where('id', $id)->update(['id_state' => $request['id_state']]);

                }else{
                    $estado = perfilEstudiante::withTrashed()->findOrFail($id);       
                    $estado->id_state = $request['id_state'];
                    $estado->save();  
                    $estado->delete();
                }
            }
            
            if($request['id_state'] == 1){
                if($borrar != false){
                    $borrar = Withdrawals::where('id_student', $id)->delete();
                    $estado = perfilEstudiante::withTrashed()->where('id', $id)->update(['deleted_at' => null]);
                    $estado2 = perfilEstudiante::withTrashed()->where('id', $id)->update(['id_state' => $request['id_state']]);

                    return 'true';
                }
                else{
                    return 'true';
                }    
            }
            if($request['id_state'] == 4){
                if($borrar == false){
                    $datos = Withdrawals::create([
                'id_student'   =>  $id,
                'observation'  =>  $request['observation'],
                'fecha'        =>  $request['fecha'], 
                 ]);
                return 'true';
            }else{
                $borrar = Withdrawals::where('id_student', $id)->delete();
                $datos = Withdrawals::create([
                'id_student'   =>  $id,
                'observation'  =>  $request['observation'],
                'fecha'        =>  $request['fecha'],
                 ]);
                return 'true';
            }
                 
            }
            if(($request['id_state'] == 2) || ($request['id_state'] == 3) || ($request['id_state'] == 5) || ($request['id_state'] == 6)){
                    if($borrar == false){
                        $datos = Withdrawals::create([
                        'id_student'   =>  $id,
                        'id_reasons'   =>  $request['id_reasons'],
                        'observation'  =>  $request['observation'],
                        'url'          =>  $request['url'],
                        'fecha'        =>  $request['fecha'],
                        ]);
                        return 'true'; 
                    }else{
                        $borrar = Withdrawals::where('id_student', $id)->delete();
                        $datos = Withdrawals::create([
                        'id_student'   =>  $id,
                        'id_reasons'   =>  $request['id_reasons'],
                        'observation'  =>  $request['observation'],
                        'url'          =>  $request['url'],
                        'fecha'        =>  $request['fecha'],
                        ]);
                        return 'true'; 
                    }                        
            }                                 
        };
    }


    public function indexAsistencias()
    {

        $asignaturas = Course::All();
        $cohorte = Cohort::pluck('name','id');
        $ultima_carga = CourseMoodle::fecha_carga();
        $valor_carga = $ultima_carga[0]->created_at;
      
        return view('perfilEstudiante.Asistencias.index', compact('asignaturas','cohorte', 'valor_carga'));
    }

    public function Grupos_Asignaturas($id)
    {
        $name = Course::where('id', $id)->first();
        //dd($name);
        $this->course= $name->name;
        $this->course_id= $id;
        //dd($name);
        $grupos = Group::all()->where('id_cohort', $name->id_cohort)->where('name','!=',"TEMPORAL");
        //dd($grupos);
        $grupos->map(function($grupo){
            //dd($grupo->id);
            $course_moodle = CourseMoodle::select('attendance_id', 'course_id')->where('group_id', $grupo->id)->where('fullname','LIKE',"$this->course%")->first();
            //dd($course_moodle);
            $docente_name = CourseMoodle::select('docente_name')->where('group_id', $grupo->id)->where('fullname','LIKE',"$this->course%")->where('course_id', $course_moodle->course_id)->exists();
            if($docente_name){
                $docente = CourseMoodle::select('docente_name')->where('group_id', $grupo->id)->where('fullname','LIKE',"$this->course%")->where('course_id', $course_moodle->course_id)->firstOrfail();
                $grupo->docente = $docente->docente_name; 
            }else{
                $grupo->docente = '-';
            }
            $grupo->sesiones = SessionCourse::where('lasttaken','!=',null)->where('attendance_id',$course_moodle->attendance_id)->count();
            //dd($grupo);
            $fecha = Carbon::now();
            //dd($fecha);
            $grupo->programadas = sesiones::where('id_group',$grupo->id)->where('id_course',$this->course_id)->where('date_session','<=',$fecha)->count();
            //dd($grupo->programadas);
        });
        
        //dd($grupos);
        

        return view('perfilEstudiante.Asistencias.grupos', compact('grupos', 'name'));
    }

    public function Asistencias_grupo($course, $id, $id_session)
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
        return view('perfilEstudiante.Asistencias.notas', compact('notas', 'grupo', 'name', 'id_session','asistencias'));
    }

    public function sesiones($course, $id)
    {
        $grupo = Group::where('id', $id)->first();
        $name = Course::where('id', $course)->first();
        $course = CourseMoodle::select('attendance_id','instance_id', 'docente_name')->where('group_id',$id)->where('fullname','LIKE',"$name->name%")->first();
        $this->docente = $course->docente_name;
        $sesiones = SessionCourse::where('attendance_id',$course->attendance_id)->get();
        $this->id_grupo= $id;
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
            if($this->docente != null){
                $sesion->docente = $this->docente;
            }else{
                $sesion->docente = '-';
            }
            //dd($sesion);
        });

        return view('perfilEstudiante.Asistencias.sesiones', compact('grupo', 'name','sesiones','course'));
    }
   
    
    public function exportar_reporte_socioeducativo(){

        $estudiantes = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.id_document_type, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, socio_educational_follow_ups.tracking_detail as detalle, document_type.name as documento_tipo, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2
            FROM student_profile 
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN document_type ON document_type.id = student_profile.id_document_type
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            INNER JOIN socio_educational_follow_ups on socio_educational_follow_ups.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null");

        $estudiantes_colection = collect($estudiantes);
        $excel = array();

        foreach($estudiantes_colection as $estudiante_colection){
            
            $detalle_seguimiento = json_decode($estudiante_colection->detalle);    
            

            $excel[] = array('id' => $estudiante_colection->id, 'nombres' => $estudiante_colection->name, 'apellidos' => $estudiante_colection->lastname, 'tipo_documento' => $estudiante_colection->documento_tipo, 'numero documento' => $estudiante_colection->document_number, 'codigo' => $estudiante_colection->student_code, 'correo' => $estudiante_colection->email, 'telefono' => $estudiante_colection->cellphone, 'cohorte' => $estudiante_colection->cohorte, 'grupo' => $estudiante_colection->grupo, 'estado' => $estudiante_colection->estado, 'aceptacion1' => $estudiante_colection->aceptacion1, 'aceptacion2' => $estudiante_colection->aceptacion2, 'fecha_seguimiento' => $detalle_seguimiento->fecha, 'lugar_seguimiento' => $detalle_seguimiento->Lugar, 'hora_inicio' => $detalle_seguimiento->HoraInicio, 'hora_fin' => $detalle_seguimiento->HoraFin, 'objetivos' => $detalle_seguimiento->Objetivos, 'descripcion_individual' => $detalle_seguimiento->Individual, 'riesgo_indivdual' => $detalle_seguimiento->RiesgoIndividual, 'descripcion_academica' => $detalle_seguimiento->Academico, 'riesgo_academico' => $detalle_seguimiento->RiesgoAcademico, 'descripcion_familiar' => $detalle_seguimiento->Familiar, 'riesgo_familiar' => $detalle_seguimiento->RiesgoFamiliar, 'descripcion_economica' => $detalle_seguimiento->Economico, 'riesgo_eonomico' => $detalle_seguimiento->RiesgoEconomico, 'descripcion_vdaunvrstriaycdad' => $detalle_seguimiento->VidaUniversitariaYciudad, 'riesgo_vdaunvrstriaycdad' => $detalle_seguimiento->RiesgoUc, 'observaciones' => $detalle_seguimiento->Observaciones  );
        }  

        $exportar = new SocioeducativoExport([$excel]);


        return Excel::download($exportar, 'socioeducativo_reporte.xlsx');


    }
    
     public function exportar_reporte_estados(){

       $estudiantes_retiros = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.id_document_type, student_profile.document_number, student_profile.student_code, student_profile.email, student_profile.cellphone, student_groups.id_group as grupoid, groups.name AS grupo, cohorts.name AS cohorte, conditions.name as estado, document_type.name as documento_tipo, formalizations.acceptance_v1 as aceptacion1, formalizations.acceptance_v2 as aceptacion2, withdrawals.id_reasons as motivo, withdrawals.observation as obser, withdrawals.url as url, withdrawals.created_at as creado
            FROM student_profile
            INNER JOIN withdrawals ON withdrawals.id_student = student_profile.id
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN document_type ON document_type.id = student_profile.id_document_type
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN conditions on conditions.id = student_profile.id_state
            WHERE student_groups.deleted_at IS null
            AND withdrawals.id_reasons IS null");

        //dd($estudiantes_retiros);

        $estudiantes_colection = collect($estudiantes_retiros);
        $excel = array();

        foreach($estudiantes_colection as $estudiante_colection){

            $excel[] = array('id' => $estudiante_colection->id, 'nombres' => $estudiante_colection->name, 'apellidos' => $estudiante_colection->lastname, 'tipo_documento' => $estudiante_colection->documento_tipo, 'numero documento' => $estudiante_colection->document_number, 'codigo' => $estudiante_colection->student_code, 'correo' => $estudiante_colection->email, 'telefono' => $estudiante_colection->cellphone, 'cohorte' => $estudiante_colection->cohorte, 'grupo' => $estudiante_colection->grupo, 'estado' => $estudiante_colection->estado, 'aceptacion1' => $estudiante_colection->aceptacion1, 'aceptacion2' => $estudiante_colection->aceptacion2, 'fecha cambio estado' => $estudiante_colection->creado, 'motivo' => $estudiante_colection->motivo, 'observation' => $estudiante_colection->obser, 'url' => $estudiante_colection->url);
        }

        $exportar = new RetirosExport([$excel]);


        return Excel::download($exportar, 'retiros_reporte.xlsx');
        
        

    }

    public function grupos(Request $request, $id)
    {
        $grpos = Group::where('id_cohort', $id)->get();
        //return $grupos;
        if ($request->ajax()) {

            return response()->json($grpos);
        }
    }

    public function datosNuevos(Request $request, $id)
    {


        $grupo = Group::where('id', $id)->select('name')->first();

        $grpo = $grupo->name;

        $cohort = Group::where('id', $id)->select('id_cohort')->first();
        $vercohort = $cohort->id_cohort;

        $cohorte = Cohort::where('id', $vercohort)->select('name')->first();
        $chrte = $cohorte->name;

        $array = ['grupo' => $grpo, 'cohorte' => $chrte];

        //return $array;
        if ($request->ajax()) {
            return response()->json($array);
        }
    }

   public function updateCohorteGrupo($id, Request $request)
    {
        $group = StudentGroup::findOrFail($id);
        
        
        $mensaje = "Datos actualizados correctamente!!";
        $error = 'El grupo seleccionado debe pertenecer a la cohorte correspondiente';

        $cohort = Group::where('id', $request['grupo'])->select('id_cohort')->first();
        $vlrchrte = $cohort->id_cohort;
        
        if ($request->ajax()) {

            if ($vlrchrte == $request['cohorte']) {
                if($request['group_change_date'] !== null && $request['grupo'] !== null){                   
                    
                    $group->delete();

                    $ip = User::getRealIP();
                    $id = auth()->user();
            
                    $datos = LogsCrudActions::create([
                        'id_user'                  => $id['id'],
                        'rol'                      => $id['rol_id'],
                        'ip'                       => $ip,
                        'id_usuario_accion'        => $group['id'],
                        'actividad_realizada'      => 'SE ELIMINÓ REGISTRO STUDENTGROUP',
                    ]);


                    $newregister = StudentGroup::create([
                        'id_student'        => $group->id_student, 
                        'id_group'          => $request['grupo'],
                        'group_change_date' => $request['group_change_date'],
                    ]);   

                    $datos = LogsCrudActions::create([
                        'id_user'                  => $id['id'],
                        'rol'                      => $id['rol_id'],
                        'ip'                       => $ip,
                        'id_usuario_accion'        => $newregister['id'],
                        'actividad_realizada'      => 'NUEVO REGISTRO STUDENTGROUP',
                    ]);
                }else{
                    return 2;
                }

            }else {
                return $error;
            }
        };

        return $mensaje;
    }


    public function export(){

        
        $estudiantes = perfilEstudiante::select('id', 'college', 'registration_date', 'email', 'name', 'lastname', 'id_document_type', 'document_number', 'document_expedition_date', 'landline', 'cellphone', 'phone', 'id_birth_city', 'direction', 'id_neighborhood', 'id_gender', 'id_tutor', 'birth_date')->withTrashed()->get();

        $excel = array();
        $motivo;
        $dispositivos;
        
        $comuna;
        $tpodcmntotutor;
        $si;

        foreach($estudiantes as $estudiante){ 
        $nameDispositivo = ' ';    
            
            if($estudiante->withdrawals != null){
                if ($estudiante->withdrawals->id_reasons != null) {
                    $motivo = $estudiante->withdrawals->reasons->name;
                } 
            }else{
                    $motivo = null;
            }

            if($estudiante->neighborhood != null){
                if ($estudiante->neighborhood->comune != null) {
                    $comuna = $estudiante->neighborhood->comune->name;
                } 
            }else{
                    $comuna = null;
            }            

            if($estudiante->studentdevices != null){
                foreach($estudiante->studentdevices as $dispositivos){
                    $nameDispositivo .= $dispositivos->devices->name.', ';    
                }    
            }else{
                $nameDispositivo = null;
            }    
            
            if ($estudiante->tutor != null) {
                if ($estudiante->tutor->documenttype != null) {
                    $tpodcmntotutor = $estudiante->tutor->documenttype->name;                    
                }else{
                    $tpodcmntotutor = null;
                }
            }
          
            
        
            
            $excel[] = array('id' => $estudiante->id,'cohorte' => $estudiante->studentGroup ? $estudiante->studentGroup->group->cohort->name : null, 'universiad' => $estudiante->college, 'fecha registro' => $estudiante->registration_date, 'usuario' => $estudiante->email, 'nombres' => $estudiante->name, 'apellidos' => $estudiante->lastname, 'tipo documento' => $estudiante->documenttype ? $estudiante->documenttype->name : null, 'numero documento' => $estudiante->document_number, 'fecha expedicion' => $estudiante->document_expedition_date, 'edad' => Carbon::parse($estudiante->birth_date)->age, 'fijo' => $estudiante->landline, 'celular ' => $estudiante->cellphone,'celular 2' => $estudiante->phone, 'lugar nacimiento' => $estudiante->birthcity ? $estudiante->birthcity->name : null, 'direccion' => $estudiante->direction, 'comuna' => $comuna, 'barrio' => $estudiante->neighborhood ? $estudiante->neighborhood->name : null, 'zona rural' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->rural_zone : null, 'estrato' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->stratum : null, 'ocupacion' => $estudiante->socioeconomicdata->occupation ? $estudiante->socioeconomicdata->occupation->name : null, 'estado civil' => $estudiante->socioeconomicdata->civilstatus ? $estudiante->socioeconomicdata->civilstatus->name : null, 'numero hijos' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->children_number : null, 'tiempo residencia' => $estudiante->socioeconomicdata->recidencetime ? $estudiante->socioeconomicdata->recidencetime->name : null, 'tipo vivienda' => $estudiante->socioeconomicdata->housingtype ? $estudiante->socioeconomicdata->housingtype->name : null, 'regimen salud' => $estudiante->socioeconomicdata->healthregime ? $estudiante->socioeconomicdata->healthregime->name : null, 'categoria sisben' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->sisben_category : null, 'beneficios' => $estudiante->socioeconomicdata->benefits ? $estudiante->socioeconomicdata->benefits->name : null, 'personas hogar' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->household_people : null, 'posicion economica' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->economic_possition : null, 'personas dependientes' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->dependent_people : null, 'internet zona' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->internet_zon : null, 'internet hogar' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->internet_home : null, 'dispositivos' => $nameDispositivo, 'sexo documento' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->sex_document_identidad : null, 'lgbtiq+' => $estudiante->gender ? $estudiante->gender->name : null, 'condicion social' => $estudiante->socioeconomicdata->socialconditions ? $estudiante->socioeconomicdata->socialconditions->name : null, 'discapacidad' => $estudiante->socioeconomicdata->disability ? $estudiante->socioeconomicdata->disability->name : null, 'etnia' => $estudiante->socioeconomicdata->ethnicity ? $estudiante->socioeconomicdata->ethnicity->name : null, 'tipo institucion' => $estudiante->previousacademicdata->institutiontype ? $estudiante->previousacademicdata->institutiontype->name : null, 'nombre institucion' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->institution_name : null, 'año graduacion' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->year_graduation : null, 'titulo bachiller' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->bachelor_title : null, 'fecha icfes' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->icfes_date : null, 'registro snp' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->snp_register : null, 'puntaje icfes' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->icfes_score : null, 'nombre tutor' => $estudiante->tutor ? $estudiante->tutor->name : null, 'apellidos tutor' => $estudiante->tutor ? $estudiante->tutor->lastname : null, 'correo tutor' => $estudiante->tutor ? $estudiante->tutor->email : null, 'tipo documento tutor' => $tpodcmntotutor, 'numero documento tutor' => $estudiante->tutor ? $estudiante->tutor->document_number : null, 'fecha nacimiento tutor' => $estudiante->tutor ? $estudiante->tutor->birth_date : null, 'celular tutor' => $estudiante->tutor ? $estudiante->tutor->cellphone : null, 'ocupacion tutor' => $estudiante->tutor ? $estudiante->tutor->occupation : null, 'p1(icfes)' => $estudiante->admissionScores ? $estudiante->admissionScores->icfes_score_p1 : null, 'p2 vulnerabilidad' => $estudiante->admissionScores ? $estudiante->admissionScores->vulnerability : null, 'formula' => $estudiante->admissionScores ? $estudiante->admissionScores->formula : null, 'zonaRural' => $estudiante->admissionScores ? $estudiante->admissionScores->rural_zone : null, 'mujer' => $estudiante->admissionScores ? $estudiante->admissionScores->woman : null, 'Lqtbiq+' => $estudiante->admissionScores ? $estudiante->admissionScores->lgtbiq : null, 'Discapacidad' => $estudiante->admissionScores ? $estudiante->admissionScores->disability : null, 'victima' => $estudiante->admissionScores ? $estudiante->admissionScores->victim_conflict : null, 'estrato 1 y 2' => $estudiante->admissionScores ? $estudiante->admissionScores->strata_1_2 : null, 'sisben a b c' => $estudiante->admissionScores ? $estudiante->admissionScores->sisben_a_b_c : null, 'afrodescendiente' => $estudiante->admissionScores ? $estudiante->admissionScores->afro : null, 'indigena' => $estudiante->admissionScores ? $estudiante->admissionScores->indigenous : null, 'motivo-retiro' => $motivo
            );
        }
        $exportar = new SabanaExport([$excel]);

        return Excel::download($exportar, "sábana_secretaía.xlsx");   
    }

    public function exportar_completa(){
        set_time_limit(0);
        $estudiantes = perfilEstudiante::select('id', 'photo','college', 'registration_date', 'email', 'name', 'lastname', 'id_document_type', 'document_number', 'url_document_type', 'document_expedition_date', 'landline', 'cellphone', 'phone', 'id_birth_city', 'direction', 'id_neighborhood', 'id_gender', 'id_tutor', 'birth_date', 'sex')->withTrashed()->get();

        $excel = array();

        $motivo;
        $dispositivos;
        
        $comuna;
        $tpodcmntotutor;
        $nameasignacion;
        $lastnameasignacion;
        

        foreach($estudiantes as $estudiante){ 
        $nameDispositivo = ' ';    
            
            if($estudiante->withdrawals != null){
                if ($estudiante->withdrawals->id_reasons != null) {
                    $motivo = $estudiante->withdrawals->reasons->name;
                } 
            }else{
                    $motivo = null;
            }

            if($estudiante->neighborhood != null){
                if ($estudiante->neighborhood->comune != null) {
                    $comuna = $estudiante->neighborhood->comune->name;
                } 
            }else{
                    $comuna = null;
            }            

            if($estudiante->studentdevices != null){
                foreach($estudiante->studentdevices as $dispositivos){
                    $nameDispositivo .= $dispositivos->devices->name.', ';    
                }    
            }else{
                $nameDispositivo = null;
            }    
            
            if ($estudiante->tutor != null) {
                if ($estudiante->tutor->documenttype != null) {
                    $tpodcmntotutor = $estudiante->tutor->documenttype->name;                    
                }else{
                    $tpodcmntotutor = null;
                }
            }

            if ($estudiante->assignmentstudent != null) {
                if ($estudiante->assignmentstudent->UserInfo != null) {
                    $nameasignacion = $estudiante->assignmentstudent->UserInfo->name;                    
                }else{
                    $nameasignacion = null;
                }
            }

            if ($estudiante->assignmentstudent != null) {
                if ($estudiante->assignmentstudent->UserInfo != null) {
                    $lastnameasignacion = $estudiante->assignmentstudent->UserInfo->apellidos_user;                    
                }else{
                    $lastnameasignacion = null;
                }
            }

            $excel[] = array('id' => $estudiante->id,'cohorte' => $estudiante->studentGroup ? $estudiante->studentGroup->group->cohort->name : null, 'grupo' =>$estudiante->studentGroup ? $estudiante->studentGroup->group->name : null, 'universiad' => $estudiante->college, 'fecha registro' => $estudiante->registration_date, 'usuario' => $estudiante->email, 'nombres' => $estudiante->name, 'apellidos' => $estudiante->lastname, 'photo' => $estudiante->photo, 'tipo documento' => $estudiante->documenttype ? $estudiante->documenttype->name : null, 'numero documento' => $estudiante->document_number, 'urldocumento' => $estudiante->url_document_type, 'fecha expedicion' => $estudiante->document_expedition_date, 'fecha nacimineto' => $estudiante->birth_date, 'edad' => Carbon::parse($estudiante->birth_date)->age, 'sexo' => $estudiante->sex, 'genero' => $estudiante->gender ? $estudiante->gender->name : null, 'codigo estudiante' => $estudiante->student_code, 'asignacion nombres' => $nameasignacion, 'asignacion apellidos' => $lastnameasignacion, 'fijo' => $estudiante->landline, 'celular ' => $estudiante->cellphone,'celular 2' => $estudiante->phone, 'departamento nacimiento' => $estudiante->birthcity ? $estudiante->birthcity->birthdepartament->name : null, 'ciudad nacimiento' => $estudiante->birthcity ? $estudiante->birthcity->name : null, 'direccion' => $estudiante->direction, 'comuna' => $comuna, 'barrio' => $estudiante->neighborhood ? $estudiante->neighborhood->name : null, 'zona rural' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->rural_zone : null, 'estrato' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->stratum : null, 'ocupacion' => $estudiante->socioeconomicdata->occupation ? $estudiante->socioeconomicdata->occupation->name : null, 'estado civil' => $estudiante->socioeconomicdata->civilstatus ? $estudiante->socioeconomicdata->civilstatus->name : null, 'numero hijos' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->children_number : null, 'tiempo residencia' => $estudiante->socioeconomicdata->recidencetime ? $estudiante->socioeconomicdata->recidencetime->name : null, 'tipo vivienda' => $estudiante->socioeconomicdata->housingtype ? $estudiante->socioeconomicdata->housingtype->name : null, 'regimen salud' => $estudiante->socioeconomicdata->healthregime ? $estudiante->socioeconomicdata->healthregime->name : null, 'url regimen salud' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->url_health_regime  : null, 'categoria sisben' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->sisben_category : null, 'url categoria sisben' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->url_sisben_category : null, 'eps' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->eps_name  : null, 'beneficios' => $estudiante->socioeconomicdata->benefits ? $estudiante->socioeconomicdata->benefits->name : null, 'personas hogar' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->household_people : null, 'posicion economica' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->economic_possition : null, 'personas dependientes' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->dependent_people : null, 'internet zona' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->internet_zon : null, 'internet hogar' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->internet_home : null, 'dispositivos' => $nameDispositivo, 'sexo documento' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->sex_document_identidad : null, 'lgbtiq+' => $estudiante->gender ? $estudiante->gender->name : null, 'condicion social' => $estudiante->socioeconomicdata->socialconditions ? $estudiante->socioeconomicdata->socialconditions->name : null, 'url condicion social' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->url_social_conditions : null, 'discapacidad' => $estudiante->socioeconomicdata->disability ? $estudiante->socioeconomicdata->disability->name : null, 'etnia' => $estudiante->socioeconomicdata->ethnicity ? $estudiante->socioeconomicdata->ethnicity->name : null, 'url etnia' => $estudiante->socioeconomicdata ? $estudiante->socioeconomicdata->url_ethnicity : null, 'tipo institucion' => $estudiante->previousacademicdata->institutiontype ? $estudiante->previousacademicdata->institutiontype->name : null, 'nombre institucion' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->institution_name : null, 'año graduacion' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->year_graduation : null, 'titulo bachiller' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->bachelor_title : null, 'url soporte academico' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->url_academic_support : null, 'fecha icfes' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->icfes_date : null, 'registro snp' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->snp_register : null, 'puntaje icfes' => $estudiante->previousacademicdata ? $estudiante->previousacademicdata->icfes_score : null, 'nombre tutor' => $estudiante->tutor ? $estudiante->tutor->name : null, 'apellidos tutor' => $estudiante->tutor ? $estudiante->tutor->lastname : null, 'correo tutor' => $estudiante->tutor ? $estudiante->tutor->email : null, 'tipo documento tutor' => $tpodcmntotutor, 'numero documento tutor' => $estudiante->tutor ? $estudiante->tutor->document_number : null, 'fecha nacimiento tutor' => $estudiante->tutor ? $estudiante->tutor->birth_date : null, 'celular tutor' => $estudiante->tutor ? $estudiante->tutor->cellphone : null, 'ocupacion tutor' => $estudiante->tutor ? $estudiante->tutor->occupation : null, 'p1(icfes)' => $estudiante->admissionScores ? $estudiante->admissionScores->icfes_score_p1 : null, 'p2 vulnerabilidad' => $estudiante->admissionScores ? $estudiante->admissionScores->vulnerability : null, 'formula' => $estudiante->admissionScores ? $estudiante->admissionScores->formula : null, 'zonaRural' => $estudiante->admissionScores ? $estudiante->admissionScores->rural_zone : null, 'mujer' => $estudiante->admissionScores ? $estudiante->admissionScores->woman : null, 'Lqtbiq+' => $estudiante->admissionScores ? $estudiante->admissionScores->lgtbiq : null, 'Discapacidad' => $estudiante->admissionScores ? $estudiante->admissionScores->disability : null, 'victima' => $estudiante->admissionScores ? $estudiante->admissionScores->victim_conflict : null, 'reintegracion' => $estudiante->admissionScores ? $estudiante->admissionScores->social_reintegration : null, 'estrato 1 y 2' => $estudiante->admissionScores ? $estudiante->admissionScores->strata_1_2 : null, 'sisben a b c' => $estudiante->admissionScores ? $estudiante->admissionScores->sisben_a_b_c : null, 'afrodescendiente' => $estudiante->admissionScores ? $estudiante->admissionScores->afro : null, 'indigena' => $estudiante->admissionScores ? $estudiante->admissionScores->indigenous : null, 'motivo-retiro' => $motivo
            );
        }
         
        $exportar = new SabanaExportCompleta([$excel]);

        return Excel::download($exportar, "sábana_completa.xlsx");  
    }   

    public function excel(Request $request)
    {
        $repechaje = Rating::count();

        if($repechaje > 0){
            $estado = 2;
        }else{
            $estado = 1;
        }

        $collection2 = Excel::toArray(new CsvImport, request()->file('file'));
        //dd(count($collection2));
        //$course_moodle = DB::table('program_options')->truncate();
        //foreach ($collection2 as $var) {
            //dd($var);
            foreach ($collection2[0] as $key => $value) {
                //$result = array_diff($value,[null]);
                //dd($value);
                
                $this->nombres = $value['nombre'];
                $this->apellidos = $value['apellidos'];
                $this->documento = $value['documento'];
                $this->email = $value['correo_electronico'];

                $estudiantes = perfilEstudiante::select('student_profile.id')->join('student_groups','student_groups.id_student','=','student_profile.id')->join('groups','groups.id','=','student_groups.id_group')->where(function($q){
                    $q->where(['student_profile.name' => $this->nombres, 'student_profile.lastname' => $this->apellidos])->Orwhere('student_profile.document_number',$this->documento)->Orwhere('student_profile.email', $this->email);
                })->where('groups.id_cohort',1)->where('student_groups.deleted_at',null)->where('student_profile.id_state',1)->exists();

                //dd($estudiante);

                /*if(!$estudiantes){
                    $estudiante = perfilEstudiante::select('student_profile.id')->join('student_groups','student_groups.id_student','=','student_profile.id')->join('groups','groups.id','=','student_groups.id_group')->where(function($q){
                    $q->where(['student_profile.name' => $this->nombres, 'student_profile.lastname' => $this->apellidos])->Orwhere('student_profile.document_number',$this->documento)->Orwhere('student_profile.email', $this->email);
                })->where('groups.id_cohort',1)->where('student_groups.deleted_at',null)->where('student_profile.id_state',1)->first();

                    dd($value,$estudiante);
                }*/

                $estudiante = perfilEstudiante::select('student_profile.id')->join('student_groups','student_groups.id_student','=','student_profile.id')->join('groups','groups.id','=','student_groups.id_group')->where(function($q){
                    $q->where(['student_profile.name' => $this->nombres, 'student_profile.lastname' => $this->apellidos])->Orwhere('student_profile.document_number',$this->documento)->Orwhere('student_profile.email', $this->email);
                })->where('groups.id_cohort',1)->where('student_groups.deleted_at',null)->where('student_profile.id_state',1)->first();

                //dd($estudiante);
                $semestre_ingreso = explode("-",$value['respuesta_1'])[1];
                if($semestre_ingreso == 1){
                    $semestre_ingreso = "I-2023";
                }else{
                    $semestre_ingreso = "II-2023";
                }


                $primera_opcion = explode(" ",$value['opcion1'])[0];
                $segunda_opcion = explode(" ",$value['opcion2'])[0];
                $tercera_opcion = explode(" ",$value['opcion3'])[0];
                $cuarta_opcion = explode(" ",$value['opcion4'])[0];
                $quinta_opcion = explode(" ",$value['opcion5'])[0];

                $primera_opcion_jornada = explode("(",$value['opcion1']);
                $segunda_opcion_jornada = explode("(",$value['opcion2']);
                $tercera_opcion_jornada = explode("(",$value['opcion3']);
                $cuarta_opcion_jornada = explode("(",$value['opcion4']);
                $quinta_opcion_jornada = explode("(",$value['opcion5']);

                if(($primera_opcion == 3845 || $primera_opcion == 3841) && count($primera_opcion_jornada) > 0){
                    $id_primera_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$primera_opcion)->where('working_day',"N")->first();  
                }else{
                    $id_primera_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$primera_opcion)->first();  
                }

                if(($segunda_opcion == 3845 || $segunda_opcion == 3841) && count($segunda_opcion_jornada) > 1){
                    $id_segunda_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$segunda_opcion)->where('working_day',"N")->first();
                }else{
                    $id_segunda_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$segunda_opcion)->first();
                }

                if(($tercera_opcion == 3845 || $tercera_opcion == 3841) && count($tercera_opcion_jornada) > 1){
                    $id_tercera_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$tercera_opcion)->first();
                }else{
                    $id_tercera_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$tercera_opcion)->first();
                } 

                if(($cuarta_opcion == 3845 || $cuarta_opcion == 3841) && count($cuarta_opcion_jornada) > 1){
                    $id_cuarta_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$cuarta_opcion)->where('working_day',"N")->first();
                }else{
                    $id_cuarta_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$cuarta_opcion)->first();
                }    

                if(($quinta_opcion == 3845 || $quinta_opcion == 3841) && count($quinta_opcion_jornada) > 1){
                    $id_quinta_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$quinta_opcion)->where('working_day',"N")->first();
                }else{
                    $id_quinta_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$quinta_opcion)->first();
                }
                                                        

                //dd($nota_ponderada1);

                $icfes_validar = IcfesStudent::select('total_score')->where('id_student',$estudiante ? $estudiante->id : 0)->where('id_icfes_test', 5)->exists();

                if($estudiantes && $icfes_validar){

                    $icfes = IcfesStudent::select('total_score')->where('id_student',$estudiante->id)->where('id_icfes_test', 5)->first();

                    //dd($icfes);
                    if($value['nota_prueba1'] != null && $value['nota_prueba1'] != "#N/A"){
                        $nota_prueba_1 = $value['nota_prueba1'];
                    }else{
                        $nota_prueba_1 = 0;
                    }

                    if($value['nota_prueba2'] != null && $value['nota_prueba2'] != "#N/A"){
                        $nota_prueba_2 = $value['nota_prueba2'];
                    }else{
                        $nota_prueba_2 = 0;
                    }

                    if($value['nota_prueba3'] != null && $value['nota_prueba3'] != "#N/A"){
                        $nota_prueba_3 = $value['nota_prueba3'];
                    }else{
                        $nota_prueba_3 = 0;
                    }

                    if($value['nota_prueba4'] != null && $value['nota_prueba4'] != "#N/A"){
                        $nota_prueba_4 = $value['nota_prueba4'];
                    }else{
                        $nota_prueba_4 = 0;
                    }

                    if($value['nota_prueba5'] != null && $value['nota_prueba5'] != "#N/A"){
                        $nota_prueba_5 = $value['nota_prueba5'];
                    }else{
                        $nota_prueba_5 = 0;
                    }

                    //dd(0);
                    
                    $nota_ponderada1 = (((100-($id_primera_opcion ? $id_primera_opcion->weighting_test_specific : 0))*$icfes->total_score) + (($id_primera_opcion ? $id_primera_opcion->weighting_test_specific : 0) * $nota_prueba_1))/100;

                    $nota_ponderada2 = (((100-($id_segunda_opcion ? $id_segunda_opcion->weighting_test_specific : 0))*$icfes->total_score) + (($id_segunda_opcion ? $id_segunda_opcion->weighting_test_specific : 0) * $nota_prueba_2))/100;

                    $nota_ponderada3 = (((100-($id_tercera_opcion ? $id_tercera_opcion->weighting_test_specific : 0))*$icfes->total_score) + (($id_tercera_opcion ? $id_tercera_opcion->weighting_test_specific : 0) * $nota_prueba_3))/100;

                    $nota_ponderada4 = (((100-($id_cuarta_opcion ? $id_cuarta_opcion->weighting_test_specific : 0))*$icfes->total_score) + (($id_cuarta_opcion ? $id_cuarta_opcion->weighting_test_specific : 0) * $nota_prueba_4))/100;

                    $nota_ponderada5 = (((100-($id_quinta_opcion ? $id_quinta_opcion->weighting_test_specific : 0))*$icfes->total_score) + (($id_quinta_opcion ? $id_quinta_opcion->weighting_test_specific : 0 ) * $nota_prueba_5))/100;

                    $program_options = ProgramOptions::Create([
                        'id_estudiante'     =>   $estudiante->id,
                        'id_programa1'      =>   $id_primera_opcion ? $id_primera_opcion->id : 0,
                        'nota_ponderada1'   =>   $nota_ponderada1,
                        'nota_prueba_1'     =>   $nota_prueba_1,
                        'id_programa2'      =>   $id_segunda_opcion ? $id_segunda_opcion->id : 0,
                        'nota_ponderada2'   =>   $nota_ponderada2,
                        'nota_prueba_2'     =>   $nota_prueba_2,
                        'id_programa3'      =>   $id_tercera_opcion ? $id_tercera_opcion->id : 0,
                        'nota_ponderada3'   =>   $nota_ponderada3,
                        'nota_prueba_3'     =>   $nota_prueba_3,
                        'id_programa4'      =>   $id_cuarta_opcion ? $id_cuarta_opcion->id : 0,
                        'nota_ponderada4'   =>   $nota_ponderada4,
                        'nota_prueba_4'     =>   $nota_prueba_4,
                        'id_programa5'      =>   $id_quinta_opcion ? $id_quinta_opcion->id : 0,
                        'nota_ponderada5'   =>   $nota_ponderada5,
                        'nota_prueba_5'     =>   $nota_prueba_5,
                        'semestre_ingreso'  =>   $semestre_ingreso,
                        'estado'            =>   $estado,        
                    ]);
                }
                
                
                //echo $value['codigo'],' : ',$value['id_moodle'],'<br>';
                /*$insertar = perfilEstudiante::where('document_number',$value['documento'])->where('id','>=',3100)->update(['id_moodle' => $value['id_moodle']]);*/
            }
        //}
        
      
        echo "completo";
    }

    public function CargarJSon(Request $request)
    {
        //dd($request->file('sesiones')->getClientOriginalName());

        $verificar_nombre = explode("_", $request->file('sesiones')->getClientOriginalName());
        //dd($verificar_nombre);
        //Storage::disk('local')->put('', $request->file('sesiones')->originalName());


        if ($verificar_nombre[0] == "sessionsbycoursereport") {
            $nombre = "students.json";
            Storage::delete($nombre);
            if(Storage::disk('local')->exists('inasistencias.json')) {
                Storage::delete('inasistencias.json');
            }

            Storage::putFileAs('/', $request->file('sesiones'), $nombre);
            return back()->with('status', "el archivo" . " " . $request->file('sesiones')->getClientOriginalName() . " " . "fue importado correctamente");
        }
        if ($verificar_nombre[0] == "attendancereport") {
            $nombre = "asistencias.json";
            Storage::delete($nombre);
            if(Storage::disk('local')->exists('inasistencias.json')) {
                Storage::delete('inasistencias.json');
            }
            Storage::putFileAs('/', $request->file('sesiones'), $nombre);
            return back()->with('status', "el archivo" . " " . $request->file('sesiones')->getClientOriginalName() . " " . "fue importado correctamente");
        } else {
            return back()->with('message-error', 'Por favor seleccione un archivo valido');

        }   
    }
    public function asistencias_linea_1(Request $request){
        switch ($request->mes) {
            case '1':
                if(Storage::disk('local')->exists('asistencias_linea_1.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,null,null);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,null,null);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,null,null);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,null,null);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '2':
                if(Storage::disk('local')->exists('asistencias_linea_1_febrero.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_febrero.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1643711398);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1643711398);
                    $this->month_end = date('Y/m/d', $month_end);

                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_febrero.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '3':
                if(Storage::disk('local')->exists('asistencias_linea_1_marzo.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_marzo.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1646130598);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1646130598);
                    $this->month_end = date('Y/m/d', $month_end);
                
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_marzo.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '4':
                if(Storage::disk('local')->exists('asistencias_linea_1_abril.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_abril.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1648808998);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1648808998);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_abril.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '5':
                if(Storage::disk('local')->exists('asistencias_linea_1_mayo.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_mayo.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1651400998);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1651400998);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_mayo.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '6':
                if(Storage::disk('local')->exists('asistencias_linea_1_junio.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_junio.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1654079398);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1654079398);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_junio.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '7':
                if(Storage::disk('local')->exists('asistencias_linea_1_julio.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_julio.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1656671381);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1656671381);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_julio.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '8':
                if(Storage::disk('local')->exists('asistencias_linea_1_agosto.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_agosto.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1659402911);
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of this month', 1659402911);
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_agosto.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '9':
                if(Storage::disk('local')->exists('asistencias_linea_1_septiembre.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_septiembre.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of September 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of September 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_septiembre.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '10':
                if(Storage::disk('local')->exists('asistencias_linea_1_octubre.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_octubre.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of October 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of October 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_octubre.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '11':
                if(Storage::disk('local')->exists('asistencias_linea_1_november.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_november.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of november 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of november 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_november.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '12':
                if(Storage::disk('local')->exists('asistencias_linea_1_aceptacion.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_1_aceptacion.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    //$month_start = strtotime('first day of October 2022');
                    //$this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = Carbon::now();
                    $this->month_end = $month_end->format('Y/m/d');
                    //dd($this->month_end,$this->month_start);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                        
                        $fecha_aceptacion = Formalization::where('id_student',$estudiante->id)->select('acceptance_date')->firstOrfail();
                        //dd($fecha_aceptacion->acceptance_date,$estudiante->id,$this->month_end);
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->fecha_aceptacion = $fecha_aceptacion->acceptance_date;
                        //dd($estudiante);
                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_1_aceptacion.json', $estudiantes);

                    $asistencias  = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            default:
                echo "ERROR DE MES..";
                break;
        }             
    }
    public function asistencias_linea_2(Request $request){
        switch ($request->mes) {
            case '1':
                if(Storage::disk('local')->exists('asistencias_linea_2.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,null,null);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,null,null);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,null,null);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,null,null);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '2':
                if(Storage::disk('local')->exists('asistencias_linea_2_febrero.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_febrero.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1643711398);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1643711398);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_febrero.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '3':
                if(Storage::disk('local')->exists('asistencias_linea_2_marzo.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_marzo.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1646130598);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1646130598);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_marzo.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '4':
                if(Storage::disk('local')->exists('asistencias_linea_2_abril.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_abril.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1648808998);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1648808998);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_abril.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '5':
                if(Storage::disk('local')->exists('asistencias_linea_2_mayo.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_mayo.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1651400998);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1651400998);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_mayo.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '6':
                if(Storage::disk('local')->exists('asistencias_linea_2_junio.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_junio.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1654079398);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1654079398);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_junio.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '7':
                if(Storage::disk('local')->exists('asistencias_linea_2_julio.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_julio.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1656671381);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1656671381);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_julio.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '8':
                if(Storage::disk('local')->exists('asistencias_linea_2_agosto.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_agosto.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1659402911);
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of this month', 1659402911);
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_agosto.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '9':
                if(Storage::disk('local')->exists('asistencias_linea_2_septiembre.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_septiembre.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of September 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of September 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_septiembre.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '10':
                if(Storage::disk('local')->exists('asistencias_linea_2_octubre.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_octubre.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of October 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of October 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_octubre.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '11':
                if(Storage::disk('local')->exists('asistencias_linea_2_november.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_november.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of november 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of november 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_november.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '12':
                if(Storage::disk('local')->exists('asistencias_linea_2_aceptacion.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_2_aceptacion.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    //$month_start = strtotime('first day of October 2022');
                    //$this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = Carbon::now();
                    $this->month_end = $month_end->format('Y/m/d');
                    //dd($this->month_end,$this->month_start);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                        
                        $fecha_aceptacion = Formalization::where('id_student',$estudiante->id)->select('acceptance_date')->firstOrfail();
                        //dd($fecha_aceptacion->acceptance_date,$estudiante->id,$this->month_end);
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->fecha_aceptacion = $fecha_aceptacion->acceptance_date;
                        //dd($estudiante);
                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_2_aceptacion.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            default:
                echo "ERROR DE MES..";
                break;
        }      
    }
    public function asistencias_linea_3(Request $request){
        switch ($request->mes) {
            case '1':
                if(Storage::disk('local')->exists('asistencias_linea_3.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,null,null);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,null,null);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,null,null);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,null,null);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '2':
                if(Storage::disk('local')->exists('asistencias_linea_3_febrero.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_febrero.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1643711398);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1643711398);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_febrero.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '3':
                if(Storage::disk('local')->exists('asistencias_linea_3_marzo.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_marzo.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1646130598);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1646130598);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_marzo.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '4':
                if(Storage::disk('local')->exists('asistencias_linea_3_abril.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_abril.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1648808998);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1648808998);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_abril.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '5':
                if(Storage::disk('local')->exists('asistencias_linea_3_mayo.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_mayo.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1651400998);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1651400998);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_mayo.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '6':
                if(Storage::disk('local')->exists('asistencias_linea_3_junio.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_junio.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1654079398);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1654079398);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_junio.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '7':
                if(Storage::disk('local')->exists('asistencias_linea_3_julio.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_julio.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1656671381);
                    $this->month_start = date('Y/m/d', $month_start);
                    $month_end = strtotime('last day of this month', 1656671381);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_julio.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;
            case '8':
                if(Storage::disk('local')->exists('asistencias_linea_3_agosto.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_agosto.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of this month', 1659402911);
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of this month', 1659402911);
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_agosto.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '9':
                if(Storage::disk('local')->exists('asistencias_linea_3_septiembre.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_septiembre.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of September 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of September 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_septiembre.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '10':
                if(Storage::disk('local')->exists('asistencias_linea_3_octubre.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_octubre.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of October 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of October 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_octubre.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '11':
                if(Storage::disk('local')->exists('asistencias_linea_3_november.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_november.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    $month_start = strtotime('first day of november 2022');
                    $this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = strtotime('last day of november 2022');
                    //dd($month_end);
                    $this->month_end = date('Y/m/d', $month_end);
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->month_start,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$this->month_start,$this->month_end);

                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_november.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            case '12':
                if(Storage::disk('local')->exists('asistencias_linea_3_aceptacion.json')) {
                    $asistencias    = json_decode(Storage::get('asistencias_linea_3_aceptacion.json'));
                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();
                }else{
                    //$month_start = strtotime('first day of October 2022');
                    //$this->month_start = date('Y/m/d', $month_start);
                    //dd($this->month_start);
                    $month_end = Carbon::now();
                    $this->month_end = $month_end->format('Y/m/d');
                    //dd($this->month_end);
                    $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
                    $estudiantes = collect($estudiantes);
                    $estudiantes->map(function($estudiante){
                        
                        $fecha_aceptacion = Formalization::where('id_student',$estudiante->id)->select('acceptance_date')->firstOrfail();
                        //dd($fecha_aceptacion->acceptance_date,$estudiante->id,$this->month_end);
                        $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->calificadas_virtuales = CourseMoodle::asistencias_virtuales_calificadas($estudiante->grupo,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->calificadas_presenciales = CourseMoodle::asistencias_presenciales_calificadas($estudiante->grupo,$fecha_aceptacion->acceptance_date,$this->month_end);

                        $estudiante->fecha_aceptacion = $fecha_aceptacion->acceptance_date;
                        //dd($estudiante);
                        unset($estudiante->grupo);
                        unset($estudiante->id_moodle);
                    });

                    $estudiantes = json_encode($estudiantes);
                    Storage::disk('local')->put('asistencias_linea_3_aceptacion.json', $estudiantes);

                    $asistencias    = json_decode($estudiantes);

                    $estudiantes = collect($asistencias);
               
                    return datatables()->of($estudiantes)->toJson();       
                }
                break;    
            default:
                echo "ERROR DE MES..";
                break;
        }      
    }
        
    public function indexEstudiantes(){
        $cohorte = Cohort::pluck('name','id');
        $fecha_carga = SessionCourse::fecha_carga();
        $carga = $fecha_carga[0]->created_at;
        
        return view('perfilEstudiante.Asistencias.Individuales.index',compact('cohorte', 'carga'));   
    }

    public function sesiones_asistencias($id_curso){
        $sesiones    = json_decode(Storage::get('students.json'));
        //dd($id_curso);
        $contador = 0;
        foreach($sesiones as $sesion){
            if($sesion->courseid == $id_curso){
                //dd($sesion,$id_curso);
                $date = new Carbon();
                
                foreach($sesion->sessions as $session){
                    //dump($session);
                    $horas = $session->duration/60;
                    //$date = Carbon::now()->subMinutes($horas);
                    $date2 = new Carbon($session->sessdate);
                    //dd($date);
                    if($date >= $date2){
                        //dump($session);
                        $contador++;
                    }             
                }     
            }
            //dd($contador);
            //return $contador;
        }

        return $contador;   
    }

    public function estudiantes_asistencias($id_moodle){

        $asistencias = json_decode(Storage::get('asistencias.json'));
        $contador_asistencias = 0;
        $contador_sesiones = 0;
        $inasistencias;
        foreach($asistencias as $info){
            //dd($info->userid);
            if($info->userid == $id_moodle){
                //dd($info,intval($id_moodle));
                foreach($info->courses as $course){
                    //dump($course);
                    $contador_asistencias += $course->attendance->takensessionssumary->numtakensessions;
                    $contador_sesiones += $this->sesiones_asistencias($course->courseid);

                }
                $inasistencias = $contador_sesiones - $contador_asistencias;
                   
            }   
        }
        //dd($inasistencias);
        return $inasistencias;
    }

    public function ver_Asistencias($id)
    {
        //$verDatosPerfil = perfilEstudiante::
        if($verDatosPerfil->photo == ""){
            $foto = null;
        }else{
            $foto = explode("/",$verDatosPerfil->photo);
            $foto = $foto[5];
        }
        return view('perfilEstudiante.Asistencias.Individuales.reporte',compact('id'));
    }

    public function index_Estados()
    {
        $estado = Condition::pluck('name', 'id');
        $motivos = Reasons::pluck('name', 'id');
        $motivs = Reasons::select('name')->get();
        $ultimo_registro = Withdrawals::ultimo_registro();
        $valor_ultimo = $ultimo_registro[0]->created_at;
        
        return view('perfilEstudiante.estado.index', compact('estado','motivos','motivs', 'valor_ultimo'));
    }

    public function edit_Estado($id, Request $request){
        $verDatosPerfil  = perfilEstudiante::withTrashed()->select('id','id_state','name','lastname','document_number')->where('id',$id)->get();
        $data = $verDatosPerfil[0]->condition;
        $data2 = $verDatosPerfil[0]->withdrawals;
        if($request->ajax()){
            return Response::json($verDatosPerfil);
        };
    }
    
   public function get_Estados(Request $request){
        
        if($request['febrero'] === "false" && $request['marzo'] === "false" && $request['abril'] === "false" && $request['mayo'] === "false" && $request['junio'] === "false" && $request['julio'] === "false" && $request['agosto'] === "false" && $request['septiembre'] === "false" && $request['octubre'] === "false" && $request['noviembre'] === "false"){

            $verDatosPerfil  = perfilEstudiante::withTrashed()->get(['id','name','lastname','id_document_type','document_number','id_state']);
            $verDatosPerfil->map(function($estudiante){
                $estudiante->cohorte = $estudiante->studentGroup->group->cohort ? $estudiante->studentGroup->group->cohort->name : null;
                $estudiante->grupo = $estudiante->studentGroup->group ? $estudiante->studentGroup->group->name : null;
                $estudiante->tipodocumento = $estudiante->documenttype ? $estudiante->documenttype->name : null;
                $estudiante->condicion = $estudiante->condition ? $estudiante->condition->name : null;
                $profesionales = AssignmentStudent::where('id_student', $estudiante->id)->exists();
                $profesionales = AssignmentStudent::where('id_student', $estudiante->id)->exists();
                if($profesionales == true){
                    $profesional_name = $estudiante->assignmentstudent->UserInfo ? $estudiante->assignmentstudent->UserInfo->name : null;
                    $profesional_lastname = $estudiante->assignmentstudent->UserInfo ? $estudiante->assignmentstudent->UserInfo->apellidos_user : null;
                    $estudiante->encargado = $profesional_name .' '.$profesional_lastname;      
                }else{
                    $estudiante->encargado = null;
                }

                $withdrawals = Withdrawals::where('id_student', $estudiante->id)->exists();
                if($withdrawals == true){
                    $estudiante->motivo = $estudiante->withdrawals->reasons ? $estudiante->withdrawals->reasons->name : null;
                    $estudiante->fecha = $estudiante->withdrawals ? $estudiante->withdrawals->fecha : null;
                    $estudiante->observacion = $estudiante->withdrawals ? $estudiante->withdrawals->observation : null;
                    $estudiante->url = $estudiante->withdrawals ? $estudiante->withdrawals->url : null;
                }else{
                    $estudiante->motivo = null;
                    $estudiante->fecha = null;
                    $estudiante->observacion = null;
                    $estudiante->url = null;
                }
                unset($estudiante->withdrawals);
                unset($estudiante->studentGroup);
                unset($estudiante->condition);
                unset($estudiante->documenttype);
                unset($estudiante->assignmentstudent);
            });
            return datatables()->of($verDatosPerfil)->toJson();
        }else{
            //dd($request);
            if($request['febrero'] === "true"){
                $cambios_febrero = Withdrawals::febrero();
                //dd($cambios_febrero);
                if($cambios_febrero != null){
                    return datatables()->of($cambios_febrero)->toJson();    
                }else{
                    $cambios_febrero = null;
                    $validar = collect($cambios_febrero);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['marzo'] === "true"){
                $cambios_marzo = Withdrawals::marzo();
                //dd($cambios_marzo);
                if($cambios_marzo != null){
                    return datatables()->of($cambios_marzo)->toJson();    
                }else{
                    $cambios_marzo = null;
                    $validar = collect($cambios_marzo);
                    return datatables()->of($validar)->toJson();
                }   
            }
            if($request['abril'] === "true"){
                $cambios_abril = Withdrawals::abril();
                //dd($cambios_abril);
                if($cambios_abril != null){
                    return datatables()->of($cambios_abril)->toJson();    
                }else{
                    $cambios_abril = null;
                    $validar = collect($cambios_abril);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['mayo'] === "true"){
                $cambios_mayo = Withdrawals::mayo();
                //dd($cambios_mayo);
                if($cambios_mayo != null){
                    return datatables()->of($cambios_mayo)->toJson();    
                }else{
                    $cambios_mayo = null;
                    $validar = collect($cambios_mayo);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['junio'] === "true"){
                $cambios_junio = Withdrawals::junio();
                //dd($cambios_junio);
                if($cambios_junio != null){
                    return datatables()->of($cambios_junio)->toJson();    
                }else{
                    $cambios_junio = null;
                    $validar = collect($cambios_junio);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['julio'] === "true"){
                $cambios_julio = Withdrawals::julio();
                //dd($cambios_julio);
                if($cambios_julio != null){
                    return datatables()->of($cambios_julio)->toJson();    
                }else{
                    $cambios_julio = null;
                    $validar = collect($cambios_julio);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['agosto'] === "true"){
                $cambios_agosto = Withdrawals::agosto();
                //dd($cambios_agosto);
                if($cambios_agosto != null){
                    return datatables()->of($cambios_agosto)->toJson();    
                }else{
                    $cambios_agosto = null;
                    $validar = collect($cambios_agosto);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['septiembre'] === "true"){
                $cambios_septiembre = Withdrawals::septiembre();
                //dd($cambios_septiembre);
                if($cambios_septiembre != null){
                    return datatables()->of($cambios_septiembre)->toJson();    
                }else{
                    $cambios_septiembre = null;
                    $validar = collect($cambios_septiembre);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['octubre'] === "true"){
                $cambios_octubre = Withdrawals::octubre();
                //dd($cambios_octubre);
                if($cambios_octubre != null){
                    return datatables()->of($cambios_octubre)->toJson();    
                }else{
                    $cambios_octubre = null;
                    $validar = collect($cambios_octubre);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['noviembre'] === "true"){
                $cambios_noviembre = Withdrawals::noviembre();
                //dd($cambios_noviembre);
                if($cambios_noviembre != null){
                    return datatables()->of($cambios_noviembre)->toJson();    
                }else{
                    $cambios_noviembre = null;
                    $validar = collect($cambios_noviembre);
                    return datatables()->of($validar)->toJson();
                }     
            }
            if($request['todos'] === "true"){
                $verDatosPerfil  = perfilEstudiante::withTrashed()->get(['id','name','lastname','
                id_document_type','document_number','id_state']);
                $verDatosPerfil->map(function($estudiante){
                    //$estudiante->cohorte = $estudiante->studentGroup->group->cohort ? $estudiante->studentGroup->group->cohort->name : null;
                    //$estudiante->grupo = $estudiante->studentGroup->group ? $estudiante->studentGroup->group->name : null;
                    $estudiante->tipodocumento = $estudiante->documenttype ? $estudiante->documenttype->name : null;
                    $estudiante->condicion = $estudiante->condition ? $estudiante->condition->name : null;
                    $profesionales = AssignmentStudent::where('id_student', $estudiante->id)->exists();
                    $profesionales = AssignmentStudent::where('id_student', $estudiante->id)->exists();
                    if($profesionales == true){
                        $profesional_name = $estudiante->assignmentstudent->UserInfo ? $estudiante->assignmentstudent->UserInfo->name : null;
                        $profesional_lastname = $estudiante->assignmentstudent->UserInfo ? $estudiante->assignmentstudent->UserInfo->apellidos_user : null;
                        $estudiante->encargado = $profesional_name .' '.$profesional_lastname;      
                    }else{
                        $estudiante->encargado = null;
                    }

                    $withdrawals = Withdrawals::where('id_student', $estudiante->id)->exists();
                    if($withdrawals == true){
                        $estudiante->motivo = $estudiante->withdrawals->reasons ? $estudiante->withdrawals->reasons->name : null;
                        $estudiante->fecha = $estudiante->withdrawals ? $estudiante->withdrawals->fecha : null;
                        $estudiante->observacion = $estudiante->withdrawals ? $estudiante->withdrawals->observation : null;
                        $estudiante->url = $estudiante->withdrawals ? $estudiante->withdrawals->url : null;
                    }else{
                        $estudiante->motivo = null;
                        $estudiante->fecha = null;
                        $estudiante->observacion = null;
                        $estudiante->url = null;
                    }
                    unset($estudiante->withdrawals);
                    unset($estudiante->studentGroup);
                    unset($estudiante->condition);
                    unset($estudiante->documenttype);
                    unset($estudiante->assignmentstudent);
                });
                return datatables()->of($verDatosPerfil)->toJson();    
            }
            /*if($request['septiembre'] === "true"){
                $cambios_septiembre = Withdrawals::septiembre();
                dd($cambios_septiembre);
                if($cambios_septiembre != null){
                    return datatables()->of($cambios_septiembre)->toJson();    
                }else{
                    $cambios_septiembre = null;
                    $validar = collect($cambios_septiembre);
                    return datatables()->of($validar)->toJson();
                }     
            }*/
        }
    }

    public function excel_asistencias(Request $request){
        //dd($request->from_date);
        $asistencias = json_decode(Storage::get('asistencias.json'));
        $sesiones    = json_decode(Storage::get('students.json'));
        //dd($sesiones);

        $asistio = array();
        foreach($asistencias as $key => $info){
            //dd($info);
            foreach($info->courses as $course){
                foreach($course->attendance->fullsessionslog as $asistieron){
                    //dd($asistieron);
                    $sessdate = new Carbon();
                    $sessdate->setTimestamp($asistieron->timestamp);
                    $from_date = new Carbon($request->from_date);
                    $to_date = new Carbon($request->to_date);
                    $to_date = $to_date->addDay();
                    //dd($from_date,$to_date);
                    if($sessdate >= $from_date && $sessdate < $to_date && ($asistieron->statusacronym == "P" ||$asistieron->statusacronym == "R")){
                        $asistio[] = array('id_sesion'=>$asistieron->sessionid);
                    }                                   
                }
            }
        }
        //dd($asistio);
        $collection;
        foreach($sesiones as $key => $sesion){
            $date = new Carbon();
            $contador = 0;
            $contador2 = 0;
            $total2 =0;
            $total=0;
            $prom_virtual=0;
            $prom_presencial=0;
            $prom_total=0;
            //dd($sesion);
            foreach($sesion->sessions as $session){
                //dd($session);
                //$horas = $session->duration/60;
                //$date = Carbon::now();
                $date2 = new Carbon($session->sessdate);
                $from_date = new Carbon($request->from_date);
                $to_date = new Carbon($request->to_date);
                $to_date = $to_date->addDay();
                //dd($date2);
                if($date2 >= $from_date && $date2 < $to_date && $date2->isoFormat('dddd') == "Saturday"){
                    //dd($session->sessdate);
                    $total2 = $total2 + $this->contar_valores($asistio,$session->id);
                    $contador2++;
                }
                if($date2 >= $from_date && $date2 < $to_date && $date2->isoFormat('dddd') != "Saturday"){
                    //dd($session->sessdate);
                    $total = $total + $this->contar_valores($asistio,$session->id);
                    $contador++;
                }   
            }

            if($contador != 0 || $contador2 != 0){
                 $prom_total = ($total+$total2)/($contador+$contador2);
            }
            if($contador != 0){
                $prom_virtual = $total/$contador;
            }
            if($contador2 != 0){
                $prom_presencial = $total2/$contador2;
            }
            $curso = explode("-",$sesion->shortname);
            if($curso[4] == "A0"){
                $curso[4] = "LINEA 1";
            }else if($curso[4] == "TE"){
                $curso[4] = "LINEA 2";
            }else if($curso[4] == "TS"){
                $curso[4] = "LINEA 3";
            }
            $url="https://campusvirtual.univalle.edu.co/moodle/mod/attendance/manage.php?id=".$sesion->instanceid."&view=5";
            //dd($url);
            $collection[$key] = array('asignatura'=>$curso[1],
                                      'grupo'=>$curso[2],
                                      'linea'=>$curso[4],
                                      'url'  =>$url,
                                      'sesiones_virtuales'=>$contador,
                                      'prom_virtuales'=>intval($prom_virtual),
                                      'sesiones_presenciales' =>$contador2,
                                      'prom_presenciales'=>intval($prom_presencial),
                                      'total_sesiones'   =>$contador2+$contador,
                                      'Promedio-asistencias'=>intval($prom_total));
        }

        $export = new ReporteExport([$collection]);
        $fechaexcel = Carbon::now();

        $fechaexcel = $fechaexcel->format('d-m-Y');
        
        
        return Excel::download($export, "REPORTE GENERAL ASISTENCIAS"." ".$fechaexcel.".xlsx");      
    }

    function contar_valores($a,$buscado){
   
        if(!is_array($a)) return NULL;
        $i=0;
        foreach($a as $v)
        if($buscado==$v['id_sesion'])
        $i++;
        return $i;
    }
    
    public function tabla_estados_resumen(){
        
        $activos_linea1 = perfilEstudiante::activos_linea1();
        $desertores_linea1 = perfilEstudiante::desertados_linea1();
        $desestimientos_linea1 = perfilEstudiante::desestimientos_linea1();
        $retiros_linea1 = perfilEstudiante::retiros_linea1();

        $activos_linea2 = perfilEstudiante::activos_linea2();
        $desertores_linea2 = perfilEstudiante::desertados_linea2();
        $desestimientos_linea2 = perfilEstudiante::desestimientos_linea2();
        $retiros_linea2 = perfilEstudiante::retiros_linea2();

        $activos_linea3 = perfilEstudiante::activos_linea3();
        $desertores_linea3 = perfilEstudiante::desertados_linea3();
        $desestimientos_linea3 = perfilEstudiante::desestimientos_linea3();
        $retiros_linea3 = perfilEstudiante::retiros_linea3();
        
        $linea1_activos;
        $linea1_desertores;
        $linea1_desestimientos;
        $linea1_retiros;

        $linea2_activos;
        $linea2_desertores;
        $linea2_desestimientos;
        $linea2_retiros;

        $linea3_activos;
        $linea3_desertores;
        $linea3_desestimientos;
        $linea3_retiros;

        foreach($activos_linea1 as $activos){
            $linea1_activos = $activos->activos;
        }
        foreach($desertores_linea1 as $desertores){
            $linea1_desertores = $desertores->desertados;
        }
        foreach($desestimientos_linea1 as $desestimientos){
            $linea1_desestimientos = $desestimientos->desestimientos;
        }
        foreach($retiros_linea1 as $retiros){
            $linea1_retiros = $retiros->retiros;
        }

        foreach($activos_linea2 as $activos){
            $linea2_activos = $activos->activos;
        }
        foreach($desertores_linea2 as $desertores){
            $linea2_desertores = $desertores->desertados;
        }
        foreach($desestimientos_linea2 as $desestimientos){
            $linea2_desestimientos = $desestimientos->desestimientos;
        }
        foreach($retiros_linea2 as $retiros){
            $linea2_retiros = $retiros->retiros;
        }

        foreach($activos_linea3 as $activos){
            $linea3_activos = $activos->activos;
        }
        foreach($desertores_linea3 as $desertores){
            $linea3_desertores = $desertores->desertados;
        }
        foreach($desestimientos_linea3 as $desestimientos){
            $linea3_desestimientos = $desestimientos->desestimientos;
        }
        foreach($retiros_linea3 as $retiros){
            $linea3_retiros = $retiros->retiros;
        }

        $linea_1 = array();
        $linea_1 = array('linea' => 'LINEA1',
                        'activos' => $linea1_activos,
                        'desertores' => $linea1_desertores,
                        'desestimientos' => $linea1_desestimientos,
                        'retiros' => $linea1_retiros,
                        'total' => $linea1_activos + $linea1_desertores + $linea1_desestimientos + $linea1_retiros);

        $linea_2 = array();
        $linea_2 = array('linea' => 'LINEA2',
                        'activos' => $linea2_activos,
                        'desertores' => $linea2_desertores,
                        'desestimientos' => $linea2_desestimientos,
                        'retiros' => $linea2_retiros,
                        'total' => $linea2_activos + $linea2_desertores + $linea2_desestimientos + $linea2_retiros);

        $linea_3 = array();
        $linea_3 = array('linea' => 'LINEA3',
                        'activos' => $linea3_activos,
                        'desertores' => $linea3_desertores,
                        'desestimientos' => $linea3_desestimientos,
                        'retiros' => $linea3_retiros,
                        'total' => $linea3_activos + $linea3_desertores + $linea3_desestimientos + $linea3_retiros);

        $total_activos = $linea1_activos + $linea2_activos + $linea3_activos;
        $total_desertados = $linea1_desertores + $linea2_desertores + $linea3_desertores;
        $total_desestimientos = $linea1_desestimientos + $linea2_desestimientos + $linea3_desestimientos;
        $total_retiros = $linea1_retiros + $linea2_retiros + $linea3_retiros;
        
        $totales = array();
        $totales = array('linea' => 'TOTAL',
                        'activos' => $total_activos,
                        'desertores' => $total_desertados,
                        'desestimientos' => $total_desestimientos,
                        'retiros' => $total_retiros, 
                        'total' => $total_activos + $total_desertados + $total_desestimientos + $total_retiros);

        $general = array($linea_1, $linea_2, $linea_3, $totales);
        
        return datatables()->of($general)->toJson();
        
    }

    public function tabla_clasificacion_resumen(){

        $admitidos_linea1 = perfilEstudiante::admitidos_linea1();
        $activos_linea1 = perfilEstudiante::activos_linea_1();
        $inactivos_linea1 = perfilEstudiante::inactivos_linea1();

        $admitidos_linea2 = perfilEstudiante::admitidos_linea2();
        $activos_linea2 = perfilEstudiante::activos_linea_2();
        $inactivos_linea2 = perfilEstudiante::inactivos_linea2();

        $admitidos_linea3 = perfilEstudiante::admitidos_linea3();
        $activos_linea3 = perfilEstudiante::activos_linea_3();
        $inactivos_linea3 = perfilEstudiante::inactivos_linea3();
        
        $linea1_admitidos;
        $linea1_activos;
        $linea1_inactivos;

        $linea2_admitidos;
        $linea2_activos;
        $linea2_inactivos;

        $linea3_admitidos;
        $linea3_activos;
        $linea3_inactivos;

        foreach($admitidos_linea1 as $admitidos){
            $linea1_admitidos = $admitidos->admitidos;
        }
        foreach($activos_linea1 as $activos){
            $linea1_activos = $activos->activos;
        }
        foreach($inactivos_linea1 as $inactivos){
            $linea1_inactivos = $inactivos->inactivos;
        }

        foreach($admitidos_linea2 as $admitidos){
            $linea2_admitidos = $admitidos->admitidos;
        }
        foreach($activos_linea2 as $activos){
            $linea2_activos = $activos->activos;
        }
        foreach($inactivos_linea2 as $inactivos){
            $linea2_inactivos = $inactivos->inactivos;
        }

        foreach($admitidos_linea3 as $admitidos){
            $linea3_admitidos = $admitidos->admitidos;
        }
        foreach($activos_linea3 as $activos){
            $linea3_activos = $activos->activos;
        }
        foreach($inactivos_linea3 as $inactivos){
            $linea3_inactivos = $inactivos->inactivos;
        }

        $linea_1 = array();
        $linea_1 = array('linea' => 'LINEA1',
                        'admitidos' => $linea1_admitidos,
                        'activos' => $linea1_activos,
                        'inactivos' => $linea1_inactivos,
                        'total' => $linea1_admitidos + $linea1_activos + $linea1_inactivos);

        $linea_2 = array();
        $linea_2 = array('linea' => 'LINEA2',
                        'admitidos' => $linea2_admitidos,
                        'activos' => $linea2_activos,
                        'inactivos' => $linea2_inactivos,
                        'total' => $linea2_admitidos + $linea2_activos + $linea2_inactivos);

        $linea_3 = array();
        $linea_3 = array('linea' => 'LINEA3',
                        'admitidos' => $linea3_admitidos,
                        'activos' => $linea3_activos,
                        'inactivos' => $linea3_inactivos,
                        'total' => $linea3_admitidos + $linea3_activos + $linea3_inactivos);

        $total_admitidos = $linea1_admitidos + $linea2_admitidos + $linea3_admitidos;
        $total_activos = $linea1_activos + $linea2_activos + $linea3_activos;
        $total_inactivos = $linea1_inactivos + $linea2_inactivos + $linea3_inactivos;
        $totales = array();
        $totales = array('linea' => 'TOTAL',
                        'admitidos' => $total_admitidos,
                        'activos' => $total_activos,
                        'inactivos' => $total_inactivos,
                        'total' => $total_admitidos + $total_activos + $total_inactivos);

        
        $general = array($linea_1, $linea_2, $linea_3, $totales);

        return datatables()->of($general)->toJson();
    }
    public function datosPendientes(){
        return view('perfilEstudiante.datosPendientes.index');
    }

    public function datos_generales(){
        $generales = perfilEstudiante::generales();
        
        return datatables()->of($generales)->toJson();
    }

    public function datos_socioeconomicos(){
        $socioeconomicos = SocioeconomicData::socioeconomicos();
        
        return datatables()->of($socioeconomicos)->toJson();
    }

    public function datos_academicos(){
        $academicos = PreviousAcademicData::academicos();
        
        return datatables()->of($academicos)->toJson();   
    }

    public function datos_formalizacion(){
        $formalizacion = Formalization::formalizacion_pendientes();
        
        return datatables()->of($formalizacion)->toJson();   
    }
    
    public function resumen_grupos_tabla(){

        $grupos = Group::select('name')->distinct()->where('name', '!=', 'TEMPORAL')->get();
        
        $grupos->map(function($grupo){
            $linea_1 = Group::where('name', $grupo->name)->whereBetween('id', [1, 40])->select('id')->firstOrfail();
            //dd($linea_1);
            $cant_linea_1 = collect(DB::select("
                    select COUNT(student_groups.id) as cantidad 
                    FROM student_groups, student_profile
                    WHERE student_groups.id_group = '".$linea_1->id."'
                    AND student_groups.id_student = student_profile.id
                    AND student_profile.id_state = 1
                    AND student_groups.deleted_at IS null"));
            foreach($cant_linea_1 as $cant){
                $grupo->cant_linea_1 = $cant->cantidad; 
            }
             
            $linea_2 = Group::where('name', $grupo->name)->whereBetween('id', [1004, 1043])->select('id')->firstOrfail();
            //dd($linea_1);
            $cant_linea_2 = collect(DB::select("
                    select COUNT(student_groups.id) as cantidad
                    FROM student_groups, student_profile
                    WHERE student_groups.id_group = '".$linea_2->id."'
                    AND student_groups.id_student = student_profile.id
                    AND student_profile.id_state = 1
                    AND student_groups.deleted_at IS null"));
            foreach($cant_linea_2 as $cant){
                $grupo->cant_linea_2 = $cant->cantidad; 
            }

            $linea_3 = Group::where('name', $grupo->name)->whereBetween('id', [50, 89])->select('id')->firstOrfail();
            
            $cant_linea_3 = collect(DB::select("
                    select COUNT(student_groups.id) as cantidad
                    FROM student_groups, student_profile
                    WHERE student_groups.id_group = '".$linea_3->id."'
                    AND student_groups.id_student = student_profile.id
                    AND student_profile.id_state = 1
                    AND student_groups.deleted_at IS null"));
            foreach($cant_linea_3 as $cant){
                $grupo->cant_linea_3 = $cant->cantidad; 
            }
            //dd($grupo);
        });
        return datatables()->of($grupos)->toJson();
    }
}
