<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use Session;
use App\User;
use Redirect;
use Response;
use App\Group;
use App\Tutor;
use App\Cohort;
use App\Comune;
use App\Course;
use App\Gender;
use App\Rating;
use App\Rating2;
use App\Reasons;
use App\Benefits;
use App\Programs;
use App\BirthCity;
use App\Condition;
use App\Ethnicity;
use Carbon\Carbon;
use App\Disability;
use App\Occupation;
use App\CivilStatus;
use App\HousingType;
use App\Withdrawals;
use App\CourseMoodle;
use App\DocumentType;
use App\HealthRegime;
use App\IcfesStudent;
use App\Neighborhood;
use App\StudentGroup;
use App\Formalization;
use App\RecidenceTime;
use App\SessionCourse;
use App\ProgramOptions;
use App\AdmissionScores;
use App\InstitutionType;
use App\LogsCrudActions;
use App\ProgramOptions2;
use App\BirthDepartament;
use App\perfilEstudiante;
use App\SocialConditions;
use App\AssignmentStudent;
use App\AttendanceStudent;
use App\EconomicalSupport;
use App\Imports\CsvImport;
use App\SocioeconomicData;
use App\UpdateInformation;
use App\AsignementStudents;
use App\Session as sesiones;
use Illuminate\Http\Request;
use App\Exports\SabanaExport;
use App\PreviousAcademicData;
use App\Exports\ReporteExport;
use App\Exports\RetirosExport;
use App\Http\Controllers\Auth;
use App\SocioEducationalFollowUp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Exports\SabanaExportCompleta;
use App\Exports\SocioeducativoExport;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DatosAcademicosRequest;
use App\Http\Requests\perfilEstudianteRequest;
use App\Http\Requests\DatosSocioeconomicosRequest;

class perfilEstudianteController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }


     

    public function mostrar()
    {
       
        $perfilEstudiantes = DB::select("SELECT student_profile.id as idstudiante, student_profile.*,socioeconomic_data.id as idtabla, socioeconomic_data.id_student as idstudent, socioeconomic_data.id_civil_status as estadocivil, socioeconomic_data.id_ethnicity as etnia, previous_academic_data.institution_name as colegio,
            YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad,
            (SELECT document_type.name FROm document_type WHERE document_type.id = student_profile.id_document_type) as tipodocumento,
            (SELECT birth_departaments.name FROM birth_departaments WHERE student_profile.id_birth_department = birth_departaments.id) as departamentoN,
            (SELECT birth_city.name FROM birth_city WHERE student_profile.id_birth_city = birth_city.id) as ciudadN,
            (SELECT comune.name FROM comune WHERE student_profile.id_commune = comune.id) as comuna,
            (SELECT neighborhood.name FROM neighborhood WHERE student_profile.id_neighborhood = neighborhood.id) as barrio,
            (SELECT gender.name FROM gender WHERE gender.id = student_profile.id_gender) as genero,
            (SELECT tutor.name FROM tutor WHERE tutor.id = student_profile.id_tutor) as tutor,
            (SELECT conditions.name FROM conditions WHERE conditions.id = student_profile.id_state) as estado,
            (SELECT civil_statuses.name FROM civil_statuses WHERE socioeconomic_data.id_civil_status = civil_statuses.id) as nombreEstadocivil,
            (SELECT ethnicities.name FROM ethnicities WHERE socioeconomic_data.id_ethnicity = ethnicities.id) as nombreEtnia,
            (SELECT student_groups.id_group FROM student_groups WHERE student_groups.id_student = student_profile.id) as grupoid,
            (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as namegrupo,
            (SELECT cohorts.name FROM cohorts WHERE groups.id_cohort = cohorts.id) as cohorte
            FROM student_profile, socioeconomic_data, student_groups, groups, previous_academic_data
            WHERE student_profile.id = socioeconomic_data.id_student 
            AND student_groups.id_student = student_profile.id
            AND student_profile.id = previous_academic_data.id_student 
            AND student_groups.id_group = groups.id
        ");

        return datatables()->of($perfilEstudiantes)->toJson();
    }


    public function indexPerfilEstudiante()
    {
        $user = auth()->user();
        /*if($user['rol_id'] == 6){
            $iden = $user['id'];
            $perfilEstudiantes= perfilEstudiante::whereRaw("id IN (SELECT id_student FROM assignment_students WHERE id_user=?)", [$iden])->get();
            return view('perfilEstudiante.index',compact('perfilEstudiantes'));
        }else {
            $perfilEstudiantes = perfilEstudiante::all();
            return view('perfilEstudiante.index',compact('perfilEstudiantes'));
        }*/


        //return datatables()->of($perfilEstudiantes)->toJson();


        return view('perfilEstudiante.index');
    }

    public function mostrarMenores()
    {

        $mayoriaedad = DB::select("select student_profile.id, student_profile.*, YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad, 
            (SELECT student_groups.id_group FROM student_groups WHERE student_groups.id_student = student_profile.id) as grupoid,
            (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as namegrupo,
            (SELECT cohorts.name FROM cohorts WHERE groups.id_cohort = cohorts.id) as cohorte,
            (SELECT birth_departaments.name FROM birth_departaments WHERE student_profile.id_birth_department = birth_departaments.id) as departamentoN,
            (SELECT birth_city.name FROM birth_city WHERE student_profile.id_birth_city = birth_city.id) as ciudadN,
            (SELECT comune.name FROM comune WHERE student_profile.id_commune = comune.id) as comuna,
            (SELECT neighborhood.name FROM neighborhood WHERE student_profile.id_neighborhood = neighborhood.id) as barrio
            FROM student_profile, socioeconomic_data, student_groups, groups
            WHERE student_profile.id = socioeconomic_data.id_student 
            
            AND student_groups.id_student = student_profile.id 
            AND student_groups.id_group = groups.id
            AND student_profile.id_document_type = 2
            AND YEAR(birth_date) = 2004
            AND MONTH(birth_date) BETWEEN 02 AND MONTH(NOW())
            AND YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) = 18
        ");

        return datatables()->of($mayoriaedad)->toJson();
    }

    public function indexMenores()
    {
        return view('perfilEstudiante.indexMenores');
        $perfilEstudiantes = perfilEstudiante::all();
        //dd($perfilEstudiantes);
        return view('perfilEstudiante.index', compact('perfilEstudiantes'));
    }


    public function crearPerfilEstudiante()
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
        return view("perfilEstudiante.create", compact('genero', 'sexo', 'tipo_documento', 'depNacimiento', 'muni_nacimiento'), ['editarEstudiante' => new perfilEstudiante()]);
    }

    public function storePerfilEstudiante(perfilEstudianteRequest $request)
    {

        $idPerfilEstudiantes = perfilEstudiante::create([
            'name'                      =>  $request['nombres'],
            'lastname'                  =>  $request['apellidos'],
            'id_document_type'          =>  $request['tipo_documento'],
            'document_number'           =>  $request['numero_documento'],
            'birth_date'                =>  $request['fecha_nacimiento'],
            'document_expedition_date'  =>  $request['departamento_nacimiento'],
            'id_birth_city'             =>  $request['ciudad_nacimiento'],
            'sex'                       =>  $request['sexo'],
            'id_gender'                 =>  $request['genero'],
            'barrio_residencia'         =>  $request['barrio_residencia'],
            'direction'                 =>  $request['direccion'],
            'email'                     =>  $request['email'],
            'cellphone'                 =>  $request['telefono1'],
            'phone'                     =>  $request['telefono2'],
        ]);

        $ip = User::getRealIP();
        $id = auth()->user();
        $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y h:i:s A');
        //dd($fecha);
        $datos = LogsCrudActions::create([
            'identificacion'           => $id['id'],
            'rol'                      => $id['rol_id'],
            'ip'                       => $ip,
            'id_usuario_accion'        => $data['id'],
            'actividad_realizada'      => 'SE CREO UN REGISTRO',
        ]);

        return redirect('estudiante')->with('status', 'Perfil guardado exitosamente!');
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
            'identificacion'           => $id['id'],
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

        return view('perfilEstudiante.verDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'seguimientos', 'cohorte', 'grupos'));
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

            $socio->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            $fecha = Carbon::now();
            $fecha = $fecha->format('d-m-Y');

            $datos = LogsCrudActions::create([
                'identificacion'           => $id['id'],
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

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            $update = UpdateInformation::create([
                'id_log'              => $datos['id'],
                'id_student'          => $socio['id_student'],
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
                'identificacion'           => $id['id'],
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
                'id_student'          => $acade['id_student'],
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


        return view('perfilEstudiante.verEditarDatos', compact('motivos', 'foto', 'estado', 'verDatosPerfil', 'genero', 'sexo', 'tipo_documento', 'documento', 'edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'depNacimiento', 'muni_nacimiento', 'ciudad', 'seguimientos', 'cohorte', 'grupos'));
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

            $data->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            $fecha = Carbon::now();
            $fecha = $fecha->format('d-m-Y');

            $datos = LogsCrudActions::create([
                'identificacion'           => $id['id'],
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
                'id_student'          => $data['id'],
                'changed_information' => $guardarOld,
                'new_information'     => $guardarNew,
            ]);
        };

        return $mensaje;
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
        $repechaje = Rating2::count();

        if($repechaje > 0){
            $estado = 2;
        }else{
            $estado = 1;
        }

                                        echo 'Las categorias deben ser diligenciadas completamente';
                                    } else {


                $estudiantes = perfilEstudiante::select('student_profile.id')->join('student_groups','student_groups.id_student','=','student_profile.id')->join('groups','groups.id','=','student_groups.id_group')
                ->where('student_profile.document_number', $value['documento'])->where('groups.id_cohort',1)
                ->where('student_groups.deleted_at',null)->where('student_profile.id_state',1)->exists();

                //dd($estudiante);

                /*if(!$estudiantes){
                    $estudiante = perfilEstudiante::select('student_profile.id')->join('student_groups','student_groups.id_student','=','student_profile.id')->join('groups','groups.id','=','student_groups.id_group')->where(function($q){
                    $q->where(['student_profile.name' => $this->nombres, 'student_profile.lastname' => $this->apellidos])->Orwhere('student_profile.document_number',$this->documento)->Orwhere('student_profile.email', $this->email);
                })->where('groups.id_cohort',1)->where('student_groups.deleted_at',null)->where('student_profile.id_state',1)->first();
                    dd($value,$estudiante);
                }*/

                $estudiante = perfilEstudiante::select('student_profile.id')->join('student_groups','student_groups.id_student','=','student_profile.id')->join('groups','groups.id','=','student_groups.id_group')
                ->where('student_profile.document_number', $value['documento'])->where('groups.id_cohort',1)
                ->where('student_groups.deleted_at',null)->where('student_profile.id_state',1)->first();

                //dd($estudiante);
                /*$semestre_ingreso = explode("-",$value['respuesta_1'])[1];
                if($semestre_ingreso == 1){
                    $semestre_ingreso = "I-2023";
                }else{
                    $semestre_ingreso = "II-2023";
                }*/

                $semestre_ingreso = "II-2023";


                $primera_opcion_jornada = explode("- ",$value['opcion1']);
                $primera_opcion_jornada = substr($primera_opcion_jornada[1],0,1);

                $segunda_opcion_jornada = explode("- ",$value['opcion2']);
                $segunda_opcion_jornada = substr($segunda_opcion_jornada[1],0,1);

                $tercera_opcion_jornada = explode("- ",$value['opcion3']);
                $tercera_opcion_jornada = substr($tercera_opcion_jornada[1],0,1);

                $cuarta_opcion_jornada = explode("- ",$value['opcion4']);
                $cuarta_opcion_jornada = substr($cuarta_opcion_jornada[1],0,1);

                $quinta_opcion_jornada = explode("- ",$value['opcion5']);
                $quinta_opcion_jornada = substr($quinta_opcion_jornada[1],0,1);

                $id_primera_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$primera_opcion)->where('working_day',$primera_opcion_jornada)->first();  

                $id_segunda_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$segunda_opcion)->where('working_day',$segunda_opcion_jornada)->first();
                
                $id_tercera_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$tercera_opcion)->where('working_day',$tercera_opcion_jornada)->first();
                
                $id_cuarta_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$cuarta_opcion)->where('working_day',$cuarta_opcion_jornada)->first();
                  
                $id_quinta_opcion = Programs::select('id','weighting_test_specific')->where('code_program',$quinta_opcion)->where('working_day',$quinta_opcion_jornada)->first();
                                                        

                /*$validar = ProgramOptions::withTrashed()->where('id_estudiante',$estudiante ? $estudiante->id : 0)
                            ->where('deleted_at', null)->exists();*/

                /*if($validar && $semestre_ingreso != "II-2023"){
                    dd($value,$validar);
                }*/

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


                    $nota_ponderada5 = (((100-($id_quinta_opcion ? $id_quinta_opcion->weighting_test_specific : 0))*$icfes->total_score) + (($id_quinta_opcion ? $id_quinta_opcion->weighting_test_specific : 0 ) * $nota_prueba_5))/100;

                    $program_options = ProgramOptions2::Create([
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
                        'prioridad'         =>   $value['prioridad']
                    ]);
                }
                
                
                //echo $value['codigo'],' : ',$value['id_moodle'],'<br>';
                /*$insertar = perfilEstudiante::where('document_number',$value['documento'])->where('id','>=',3100)->update(['id_moodle' => $value['id_moodle']]);*/
            }
        //}
      
        return Redirect::back()->with('status', "el archivo" . " " . $request->file('file')->getClientOriginalName() . " " . "fue importado correctamente");
    }

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
                $group->id_group = $request['grupo'];

                $group->save();
            } else {
                return $error;
            }
        };

        return $mensaje;
    }


    public function export(){

        
        $estudiantes = perfilEstudiante::select('id', 'college', 'registration_date', 'email', 'name', 'lastname', 'id_document_type', 'document_number', 'document_expedition_date', 'landline', 'cellphone', 'phone', 'id_birth_city', 'direction', 'id_neighborhood', 'id_gender', 'id_tutor', 'birth_date')->get();

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

    public function CargarJSon(Request $request){
        //dd($request->file('sesiones')->getClientOriginalName());

        $verificar_nombre = explode("_", $request->file('sesiones')->getClientOriginalName());
        //dd($verificar_nombre);
        //Storage::disk('local')->put('', $request->file('sesiones')->originalName());

        
        if($verificar_nombre[0] == "sessionsbycoursereport"){
            $nombre = "students.json";
            Storage::delete($nombre);
            if(Storage::disk('local')->exists('inasistencias.json')) {
                Storage::delete('inasistencias.json');
            }           
            
            Storage::putFileAs('/', $request->file('sesiones'), $nombre);
            $exitCode = Artisan::call('optimize:clear');
            return back()->with('status', "el archivo"." ".$request->file('sesiones')->getClientOriginalName()." "."fue importado correctamente");
        }
        if($verificar_nombre[0] == "attendancereport"){
            $nombre = "asistencias.json";
            Storage::delete($nombre);
            if(Storage::disk('local')->exists('inasistencias.json')) {
                Storage::delete('inasistencias.json');
            }
            Storage::putFileAs('/', $request->file('sesiones'), $nombre);
            $exitCode = Artisan::call('optimize:clear');
            return back()->with('status', "el archivo"." ".$request->file('sesiones')->getClientOriginalName()." "."fue importado correctamente");
        }
        else{
            return back()->with('message-error', 'Por favor seleccione un archivo valido');
        }   
    }
    public function json_inasistencias(Request $request){
        if(Storage::disk('local')->exists('inasistencias.json')) {
            $inasistencias    = json_decode(Storage::get('inasistencias.json'));
            $prueba = collect($inasistencias);
               
            return datatables()->of($prueba)->toJson();     
        }
        else{
            $perfilEstudiantes = perfilEstudiante::select('id','name','lastname','document_number','id_moodle')->get();

            $perfilEstudiantes->map(function($estudiante){
                if($estudiante->id_moodle != null){
                    $estudiante->studentGroup->group->cohort;
                    $estudiante->inasistencia = $this->estudiantes_asistencias($estudiante->id_moodle);
                }else{
                    $estudiante->studentGroup->group->cohort;
                    $estudiante->inasistencia = "-";
                }
            });

            $perfilEstudiantes = json_encode($perfilEstudiantes);

            Storage::disk('local')->put('inasistencias.json', $perfilEstudiantes);

            $inasistencias    = json_decode(Storage::get('inasistencias.json'));

            $prueba = collect($inasistencias);
               
            return datatables()->of($prueba)->toJson();  
        }
    }
        
    public function indexEstudiantes(){
        
        return view('perfilEstudiante.Asistencias.Individuales.index');   
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
            /*if($contador != 0){
                 $prom = $total/$contador;
            }*/
           
            $collection[$key] = array('courseid'=>$sesion->courseid,'shortname'=>$sesion->shortname,'total-sesiones'=>$contador,'promedio-asistencias'=>$total);
        }

        $export = new ReporteExport([$collection]);
        
        return Excel::download($export, 'invoices.xlsx');      
    }

    function contar_valores($a,$buscado){
   
        if(!is_array($a)) return NULL;
        $i=0;
        foreach($a as $v)
        if($buscado==$v['id_sesion'])
        $i++;
        return $i;
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
            /*if($contador != 0){
                 $prom = $total/$contador;
            }*/
           
            $collection[$key] = array('courseid'=>$sesion->courseid,'shortname'=>$sesion->shortname,'total-sesiones'=>$contador,'promedio-asistencias'=>$total);
        }

        $export = new ReporteExport([$collection]);
        
        return Excel::download($export, 'invoices.xlsx');      
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
