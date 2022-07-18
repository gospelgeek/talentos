<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Exports\SabanaExport;
use App\Exports\SabanaExportCompleta;
use App\Exports\ReporteExport;
use App\perfilEstudiante;
use App\AdmissionScores;
use App\SocioeconomicData;
use App\PreviousAcademicData;
use App\LogsCrudActions;
use App\User;
use App\Comune;
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
use App\Group;
use App\Cohort;
use App\AsignementStudents;
use App\StudentGroup;
use App\AssignmentStudent;
use App\SocioEducationalFollowUp;
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
use App\EconomicalSupport;



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

        return view('perfilEstudiante.index', compact('tipo_documento', 'depNacimiento', 'muni_nacimiento', 'sexo','genero', 'comunas', 'barrios', 'tutor','cohorte', 'grupo'));
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
            'actividad_realizada'      => 'SE CREÓ UN ESTUDIANTE',
        ]);

        return $mensaje;
    }

    public function verPerfilEstudiante($id)
    {

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

        $verDatosPerfil = perfilEstudiante::findOrFail($id);
        //dd($verDatosPerfil);
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

        return view('perfilEstudiante.verDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'seguimientos', 'cohorte', 'grupos', 'asignacion', 'apoyo_economico'));
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

        //dd('entro a estudiante editar');
        $verDatosPerfil = perfilEstudiante::findOrFail($id);
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


        return view('perfilEstudiante.verEditarDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'depNacimiento', 'muni_nacimiento', 'ciudad', 'seguimientos', 'cohorte', 'grupos', 'asignacion', 'apoyo_economico'));
    }



   public function updatePerfilEstudiante($id, Request $request)
    {

        $data = perfilEstudiante::findOrFail($id);
        $dataOld = perfilEstudiante::findOrFail($id);

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
        if($request->ajax())
        {   
            $borrar = Withdrawals::where('id_student', $id)->get();
            //return $borrar;
            
            if($request['id_state'] != 1){
                if($borrar != null){
                   $estado2 = perfilEstudiante::withTrashed()->where('id', $id)->update(['id_state' => $request['id_state']]);
                }else{
                    $estado = perfilEstudiante::findOrFail($id);        
                    $estado->id_state = $request['id_state'];
                    $estado->save();  
                    $estado -> delete();
                }
            
            //eliminarPerfilEstudiante($id);
            }
            
            if($request['id_state'] == 1){
                if($borrar != null){
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
                if($borrar == ""){
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
            if(($request['id_state'] == 2) || ($request['id_state'] == 3) ){
                    if($borrar == ""){
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

        
        $estudiantes = perfilEstudiante::where('id_state', 1)->select('id', 'college', 'registration_date', 'email', 'name', 'lastname', 'id_document_type', 'document_number', 'document_expedition_date', 'landline', 'cellphone', 'phone', 'id_birth_city', 'direction', 'id_neighborhood', 'id_gender', 'id_tutor', 'birth_date')->get();

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

        return Excel::download($exportar, "sábana_export.xlsx");   
    }
    
    public function exportar_completa(){

         $estudiantes = perfilEstudiante::where('id_state', 1)->select('id', 'photo','college', 'registration_date', 'email', 'name', 'lastname', 'id_document_type', 'document_number', 'url_document_type', 'document_expedition_date', 'landline', 'cellphone', 'phone', 'id_birth_city', 'direction', 'id_neighborhood', 'id_gender', 'id_tutor', 'birth_date', 'sex')->get();

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


        $collection1 = Excel::toArray(new CsvImport, 'codigo.xlsx');
        //dd($collection);
        foreach ($collection1 as $var) {

            foreach ($var as $key => $value) {
                //var_dump($value);
                //echo $value['codigo'],' : ',$value['id_moodle'],'<br>';
                $insertar = perfilEstudiante::where('student_code', $value['codigo'])->update(['id_moodle' => $value['id_moodle']]);
            }
        }

        $collection2 = Excel::toArray(new CsvImport, 'document.xlsx');
        //dd($collection);
        foreach ($collection1 as $var) {

            foreach ($var as $key => $value) {
                //var_dump($value);
                //echo $value['codigo'],' : ',$value['id_moodle'],'<br>';
                $insertar = perfilEstudiante::where('document_number', $value['document'])->update(['id_moodle' => $value['id_moodle']]);
            }
        }

        //dd($request);
        $collection = Excel::toArray(new CsvImport, request()->file('file'));
        //dd($collection);
        foreach ($collection[1] as $var) {
            //var_dump($var['nombres']);
            $id_student = perfilEstudiante::where('document_number', $var['no_documento'])->get('id');
            $consultar_grupo = Group::where('id_cohort', $var['linea'])->where('name', $var['nuevo_grupo'])->get('id');
            //dd($consultar_grupo);
            $id_students = 0;
            foreach ($id_student as $student) {
                $id_students = $student->id;
            }
            //dd($id_students);
            $id_group = 0;
            foreach ($consultar_grupo as $id) {
                $id_group = $id->id;
            }
            //dd($id_group);
            $cambio_grupo = StudentGroup::where('id_student', $id_students)->update(['id_group' => $id_group]);
            //dd($cambio_grupo);
        }
        foreach ($collection[0] as $var) {
            //var_dump($var['nombres']);
            $id_student = perfilEstudiante::where('document_number', $var['no_documento'])->get('id');
            $consultar_grupo = Group::where('id_cohort', $var['linea'])->where('name', $var['nuevo_grupo'])->get('id');
            //dd($consultar_grupo);
            $id_students = 0;
            foreach ($id_student as $student) {
                $id_students = $student->id;
            }
            //dd($id_students);
            $id_group = 0;
            foreach ($consultar_grupo as $id) {
                $id_group = $id->id;
            }
            //dd($id_group);
            $cambio_grupo = StudentGroup::where('id_student', $id_students)->update(['id_group' => $id_group]);
            //dd($cambio_grupo);
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
    public function json_inasistencias(Request $request){
        if(Storage::disk('local')->exists('vistaasistencias.json')) {
            $asistencias    = json_decode(Storage::get('vistaasistencias.json'));
            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
        }else{
            $estudiantes = perfilEstudiante::Estudiantes_cohort();
            $estudiantes = collect($estudiantes);
            $estudiantes->map(function($estudiante){
            
                $estudiante->cursos = CourseMoodle::asistencias($estudiante->grupo,$estudiante->id_moodle);
                unset($estudiante->grupo);
                unset($estudiante->id_moodle);
            //dd($estudiante);
            });
        //dd($estudiantes);
            $estudiantes = json_encode($estudiantes);

            Storage::disk('local')->put('vistaasistencias.json', $estudiantes);

            $asistencias    = json_decode(Storage::get('vistaasistencias.json'));

            $estudiantes = collect($asistencias);
               
            return datatables()->of($estudiantes)->toJson();
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
        $verDatosPerfil  = perfilEstudiante::withTrashed()->get();
        $estado = Condition::pluck('name', 'id');
        $motivos = Reasons::pluck('name', 'id');
        return view('perfilEstudiante.estado.index', compact('verDatosPerfil','estado','motivos'));
    }

    public function edit_Estado($id, Request $request){
        $verDatosPerfil  = perfilEstudiante::withTrashed()->where('id',$id)->get();
        $data = $verDatosPerfil[0]->condition;
        $data2 = $verDatosPerfil[0]->withdrawals;
        if($request->ajax()){
            return Response::json($verDatosPerfil);
        };
    }

    public function excel_asistencias(){
        $asistencias = json_decode(Storage::get('asistencias.json'));
        $sesiones    = json_decode(Storage::get('students.json'));
        //dd($sesiones);

        $asistio = array();
        foreach($asistencias as $key => $info){
            //dd($info);
            foreach($info->courses as $course){
                foreach($course->attendance->fullsessionslog as $asistieron){
                    //dump($asistieron->sessionid);
                    $asistio[] = array('id_sesion'=>$asistieron->sessionid);
                    
                }
            }

        }

        $collection;
        foreach($sesiones as $key => $sesion){
            $date = new Carbon();
            $contador = 0;
            $total=0;
            $prom=0;
            foreach($sesion->sessions as $session){
                //dd($session);
                $horas = $session->duration/60;
                $date = Carbon::now()->subMinutes($horas);
                $date2 = new Carbon($session->sessdate);
                //dd($date);
                if($date >= $date2){
                    $total = $total + $this->contar_valores($asistio,$session->id);
                    $contador++;
                }
                
            }
            if($contador != 0){
                 $prom = $total/$contador;
            }
           
            $collection[$key] = array('courseid'=>$sesion->courseid,'shortname'=>$sesion->shortname,'total-sesiones'=>$contador,'total-asistencias'=>$total,'Promedio-asistencias'=>intval($prom));
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

        $activos_linea2 = perfilEstudiante::activos_linea2();
        $desertores_linea2 = perfilEstudiante::desertados_linea2();
        $desestimientos_linea2 = perfilEstudiante::desestimientos_linea2();

        $activos_linea3 = perfilEstudiante::activos_linea3();
        $desertores_linea3 = perfilEstudiante::desertados_linea3();
        $desestimientos_linea3 = perfilEstudiante::desestimientos_linea3();
        
        $linea1_activos;
        $linea1_desertores;
        $linea1_desestimientos;

        $linea2_activos;
        $linea2_desertores;
        $linea2_desestimientos;

        $linea3_activos;
        $linea3_desertores;
        $linea3_desestimientos;

        foreach($activos_linea1 as $activos){
            $linea1_activos = $activos->activos;
        }
        foreach($desertores_linea1 as $desertores){
            $linea1_desertores = $desertores->desertados;
        }
        foreach($desestimientos_linea1 as $desestimientos){
            $linea1_desestimientos = $desestimientos->desestimientos;
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

        foreach($activos_linea3 as $activos){
            $linea3_activos = $activos->activos;
        }
        foreach($desertores_linea3 as $desertores){
            $linea3_desertores = $desertores->desertados;
        }
        foreach($desestimientos_linea3 as $desestimientos){
            $linea3_desestimientos = $desestimientos->desestimientos;
        }

        $linea_1 = array();
        $linea_1 = array('linea' => 'LINEA 1',
                        'activos' => $linea1_activos,
                        'desertores' => $linea1_desertores,
                        'desestimientos' => $linea1_desestimientos,
                        'total' => $linea1_activos + $linea1_desertores + $linea1_desestimientos);

        $linea_2 = array();
        $linea_2 = array('linea' => 'LINEA 2',
                        'activos' => $linea2_activos,
                        'desertores' => $linea2_desertores,
                        'desestimientos' => $linea2_desestimientos,
                        'total' => $linea2_activos + $linea2_desertores + $linea2_desestimientos);

        $linea_3 = array();
        $linea_3 = array('linea' => 'LINEA 3',
                        'activos' => $linea3_activos,
                        'desertores' => $linea3_desertores,
                        'desestimientos' => $linea3_desestimientos,
                        'total' => $linea3_activos + $linea3_desertores + $linea3_desestimientos);

        $total_activos = $linea1_activos + $linea2_activos + $linea3_activos;
        $total_desertados = $linea1_desertores + $linea2_desertores + $linea3_desertores;
        $total_desestimientos = $linea1_desestimientos + $linea2_desestimientos + $linea3_desestimientos;
        $totales = array();
        $totales = array('linea' => 'TOTAL',
                        'activos' => $total_activos,
                        'desertores' => $total_desertados,
                        'desestimientos' => $total_desestimientos,
                        'total' => $total_activos + $total_desertados + $total_desestimientos);


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
}
