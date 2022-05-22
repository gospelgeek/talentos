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
use Session;
use Redirect;
use DB;
use Response;
use Excel;
use App\Imports\CsvImport;
use Illuminate\Support\Facades\Storage;




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
            
                $estudiantes = perfilEstudiante::estudiantes_admitidos_asignacion();
            
                return datatables()->of($estudiantes)->toJson();

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
            
            return datatables()->of($estudiantes)->toJson();

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

        

        return view('perfilEstudiante.index', compact('tipo_documento', 'depNacimiento', 'muni_nacimiento', 'sexo','genero', 'comunas', 'barrios', 'tutor','cohorte', 'grupo', 'profersinal'));
    }

    public function mostrarMenores()
    {

        $mayoriaedad = perfilEstudiante::mayoriaEdad();

        return datatables()->of($mayoriaedad)->toJson();
    }

    public function indexMenores()
    {
        return view('perfilEstudiante.indexMenores');
        $perfilEstudiantes = perfilEstudiante::all();
        //dd($perfilEstudiantes);
        return view('perfilEstudiante.index', compact('perfilEstudiantes'));
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

        $verDatosPerfil = perfilEstudiante::withTrashed()->findOrFail($id);
        $asignacion = AssignmentStudent::where('id_student', $id)->firstOrFail();
        $cohort = $verDatosPerfil->studentGroup->group->cohort->id;
        $grupos = Group::where('id_cohort', $cohort)->pluck('name', 'id');
        //return $grupos;

        $seguimientos = SocioEducationalFollowUp::all()->where('id_student', $verDatosPerfil['id']);


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

        return view('perfilEstudiante.verDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'seguimientos', 'cohorte', 'grupos', 'asignacion', 'iden'));
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


        $seguimientos = SocioEducationalFollowUp::all()->where('id_student', $verDatosPerfil['id']);


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


        return view('perfilEstudiante.verEditarDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'depNacimiento', 'muni_nacimiento', 'ciudad', 'seguimientos', 'cohorte', 'grupos', 'asignacion', 'iden'));
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
        if($request->ajax())
        {   
            $borrar = Withdrawals::where('id_student', $id)->exists();
            //dd($borrar);

            if($request['id_state'] != 1){
                if($borrar != false){
                   $estado2 = perfilEstudiante::withTrashed()->where('id', $id)->update(['id_state' => $request['id_state']]);

                }else{
                    $estado = perfilEstudiante::findOrFail($id);        
                    $estado->id_state = $request['id_state'];
                    $estado->save();  
                    $estado->delete();
                }
            
            //eliminarPerfilEstudiante($id);
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
                 ]);
                return 'true';
            }else{
                $borrar = Withdrawals::where('id_student', $id)->delete();
                $datos = Withdrawals::create([
                'id_student'   =>  $id,
                'observation'  =>  $request['observation'],
                 ]);
                return 'true';
            }
                 
            }
            if(($request['id_state'] == 2) || ($request['id_state'] == 3) || ($request['id_state'] == 5)){
                    if($borrar == false){
                        $datos = Withdrawals::create([
                        'id_student'   =>  $id,
                        'id_reasons'   =>  $request['id_reasons'],
                        'observation'  =>  $request['observation'],
                        'url'          =>  $request['url'],
                        ]);
                        return 'true'; 
                    }else{
                        $borrar = Withdrawals::where('id_student', $id)->delete();
                        $datos = Withdrawals::create([
                        'id_student'   =>  $id,
                        'id_reasons'   =>  $request['id_reasons'],
                        'observation'  =>  $request['observation'],
                        'url'          =>  $request['url'],
                        ]);
                        return 'true'; 
                    }                        
            }                                 
        };
    }


    public function indexAsistencias()
    {

        $asignaturas = Course::All();

        //dd($asignaturas);

        return view('perfilEstudiante.Asistencias.index', compact('asignaturas'));
    }

    public function Grupos_Asignaturas($id)
    {
        $name = Course::where('id', $id)->first();
        $grupos = Group::all()->where('id_cohort', $name->id_cohort);

        //dd($name);

        return view('perfilEstudiante.Asistencias.grupos', compact('grupos', 'name'));
    }

    public function Asistencias_grupo($course, $id, $id_session)
    {
        $grupo = Group::where('id', $id)->first();
        $name = Course::where('id', $course)->first();
        $notas = StudentGroup::all()->where('id_group', $id);

        //dd($grupo);

        return view('perfilEstudiante.Asistencias.notas', compact('notas', 'grupo', 'name', 'id_session'));
    }

    public function sesiones($course, $id)
    {

        $grupo = Group::where('id', $id)->first();
        $name = Course::where('id', $course)->first();
        $notas = StudentGroup::where('id_group', $id)->get('id_student');
        $id_moole = array();
        $contador = 0;
        foreach ($notas as $student) {

            $moodle = perfilEstudiante::where('id', $student['id_student'])->get('id_moodle');

            foreach ($moodle as $id) {
                $id_moole[$contador] = $id->id_moodle;
            }
            $contador++;
        }

        return view('perfilEstudiante.Asistencias.sesiones', compact('grupo', 'name', 'id_moole'));
    }
    public function store_seguimiento(Request $request)
    {

        $mensaje = 'Seguimiento creado correctamente';
        $error = 'no puede crear';
        $id = auth()->user();

        if ($request->ajax()) {

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']), 'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindiV']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacadE']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfamiL'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkeconoM']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuniC']), 'Observaciones' => ($request['textareobservaciones'])];

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

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']), 'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindi']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacad']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfami'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkecono']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuni']), 'Observaciones' => ($request['textareobservaciones'])];

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
                //$group->id_group = $request['grupo'];
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
                    'id_student'  => $group->id_student, 
                    'id_group'    => $request['grupo'],
                ]);

                $datos = LogsCrudActions::create([
                    'id_user'                  => $id['id'],
                    'rol'                      => $id['rol_id'],
                    'ip'                       => $ip,
                    'id_usuario_accion'        => $newregister['id'],
                    'actividad_realizada'      => 'NUEVO REGISTRO STUDENTGROUP',
                ]);
                
            } else {
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

        $collection2 = Excel::toArray(new CsvImport, request()->file('file'));
        //dd($collection2[0][990]);
        foreach ($collection2 as $var) {
            //dd($var);
            foreach ($var as $key => $value) {
                //var_dump($value);
                //echo $value['codigo'],' : ',$value['id_moodle'],'<br>';
                $insertar = perfilEstudiante::where('document_number',$value['documento'])->where('id','>=',3100)->update(['id_moodle' => $value['id_moodle']]);
            }
        }
        
      
        return redirect('estudiante')->with('success', 'File imported successfully!');
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

        $this->from_date = $request->from_date;
        $this->to_date = $request->to_date;

        if(Storage::disk('local')->exists('asistencias_linea_1.json') 
            && $request->from_date == null && $request->from_date == null) {
            $asistencias    = json_decode(Storage::get('asistencias_linea_1.json'));
            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
        }else{
            $estudiantes = perfilEstudiante::Estudiantes_cohort_linea1();
            $estudiantes = collect($estudiantes);
            $estudiantes->map(function($estudiante){
                
                $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->from_date,$this->to_date);

                $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->from_date,$this->to_date);

                unset($estudiante->grupo);
                unset($estudiante->id_moodle);
            //dd($estudiante);
            });
        //dd($estudiantes);
            
            if(Storage::disk('local')->exists('asistencias_linea_1.json')){
                 
                return datatables()->of($estudiantes)->toJson();
            }else{
            $estudiantes = json_encode($estudiantes);
            Storage::disk('local')->put('asistencias_linea_1.json', $estudiantes);

            $asistencias    = json_decode(Storage::get('asistencias_linea_1.json'));

            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
            }    
        }      
    }
    public function asistencias_linea_2(Request $request){
        $this->from_date = $request->from_date;
        $this->to_date = $request->to_date;
        if(Storage::disk('local')->exists('asistencias_linea_2.json')
          && $request->from_date == null && $request->from_date == null) {
            $asistencias    = json_decode(Storage::get('asistencias_linea_2.json'));
            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
        }else{
            $estudiantes = perfilEstudiante::Estudiantes_cohort_linea2();
            $estudiantes = collect($estudiantes);
            $estudiantes->map(function($estudiante){
            
                $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->from_date,$this->to_date);

                $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->from_date,$this->to_date);

                unset($estudiante->grupo);
                unset($estudiante->id_moodle);
            //dd($estudiante);
            });
        //dd($estudiantes);
            if(Storage::disk('local')->exists('asistencias_linea_2.json')){
                 
                return datatables()->of($estudiantes)->toJson();
            }else{
            $estudiantes = json_encode($estudiantes);
            Storage::disk('local')->put('asistencias_linea_2.json', $estudiantes);

            $asistencias    = json_decode(Storage::get('asistencias_linea_2.json'));

            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
            }
        }      
    }
    public function asistencias_linea_3(Request $request){
        $this->from_date = $request->from_date;
        $this->to_date = $request->to_date;
        if(Storage::disk('local')->exists('asistencias_linea_3.json')
          && $request->from_date == null && $request->from_date == null) {
            $asistencias    = json_decode(Storage::get('asistencias_linea_3.json'));
            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
        }else{
            $estudiantes = perfilEstudiante::Estudiantes_cohort_linea3();
            $estudiantes = collect($estudiantes);
            $estudiantes->map(function($estudiante){
            
                $estudiante->cursos_virtuales = CourseMoodle::asistencias_virtuales($estudiante->grupo,$estudiante->id_moodle,$this->from_date,$this->to_date);

                $estudiante->cursos_presenciales = CourseMoodle::asistencias_presenciales($estudiante->grupo,$estudiante->id_moodle,$this->from_date,$this->to_date);
                
                unset($estudiante->grupo);
                unset($estudiante->id_moodle);
            //dd($estudiante);
            });
        //dd($estudiantes);
            if(Storage::disk('local')->exists('asistencias_linea_3.json')){
                
                return datatables()->of($estudiantes)->toJson();
            }else{
            $estudiantes = json_encode($estudiantes);
            Storage::disk('local')->put('asistencias_linea_3.json', $estudiantes);

            $asistencias    = json_decode(Storage::get('asistencias_linea_3.json'));

            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
            }
        }      
    }
        
    public function indexEstudiantes(){
        $cohorte = Cohort::pluck('name','id');
        return view('perfilEstudiante.Asistencias.Individuales.index',compact('cohorte'));   
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
        return view('perfilEstudiante.estado.index', compact('estado','motivos','motivs'));
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

        $verDatosPerfil  = perfilEstudiante::withTrashed()->get(['id','name','lastname','document_number','id_state']);
        $verDatosPerfil->map(function($estudiante){
            $estudiante->cohort = $estudiante->studentGroup->group->cohort->name;
            $estudiante->grupo = $estudiante->studentGroup->group->name;
            $estudiante->condicion = $estudiante->condition->name;
            $withdrawals = Withdrawals::where('id_student', $estudiante->id)->exists();
            //dd($withdrawals);
            if($withdrawals == true){
                $estudiante->motivo = $estudiante->withdrawals->reasons ? $estudiante->withdrawals->reasons->name : null;
            }else{
                $estudiante->motivo = null;
            }
            unset($estudiante->withdrawals);
            unset($estudiante->studentGroup);
            unset($estudiante->condition);
            //dd($estudiante);
        });

        return datatables()->of($verDatosPerfil)->toJson();
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
    
    
}
