<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Exports\SabanaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\perfilEstudiante;
use App\SocioeconomicData;
use App\PreviousAcademicData;
use App\LogsCrudActions;
use App\User;
use App\Gender;
use App\DocumentType;
use App\BirthDepartament;
use App\Tutor;
use App\Withdrawals;
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




class perfilEstudianteController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function mostrar() {
        
      $perfilEstudiantes= DB::select("SELECT student_profile.id as idstudiante, student_profile.*,socioeconomic_data.id as idtabla, socioeconomic_data.id_student as idstudent, socioeconomic_data.id_civil_status as estadocivil, socioeconomic_data.id_ethnicity as etnia, previous_academic_data.institution_name as colegio, YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad, 
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

   
    public function indexPerfilEstudiante(){
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

    public function mostrarMenores(){

        $mayoriaedad = DB::select("SELECT student_profile.id, student_profile.*, YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad, 
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

    public function indexMenores(){
        return view('perfilEstudiante.indexMenores');
        $perfilEstudiantes = perfilEstudiante::all();
        //dd($perfilEstudiantes);
        return view('perfilEstudiante.index',compact('perfilEstudiantes'));

    }


    public function crearPerfilEstudiante(){
        $genero = Gender::pluck('name','id');
        $sexo = array('F' => 'Fenemino',
                            'M' => 'Masculino' );
        $tipo_documento = array('1' => 'Cedula de Ciudadania',
                                '2' => 'Tarjeta de Identidad',
                                '3' => 'Cedula Extranjera' );

        $depNacimiento = BirthDepartament::pluck('name','id');
        $muni_nacimiento = BirthCity::pluck('name','id');
        return view("perfilEstudiante.create",compact('genero','sexo','tipo_documento','depNacimiento','muni_nacimiento'), ['editarEstudiante' => new perfilEstudiante()]);
    }

    public function storePerfilEstudiante(perfilEstudianteRequest $request){

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
            'identificacion'           => $id['cedula'],
            'rol'                      => $id['rol_id'],   
            'ip'                       => $ip,
            'id_usuario_accion'        => $data['id'],
            'actividad_realizada'      => 'SE CREO UN REGISTRO',
            ]); 
        
         return redirect('estudiante')->with('status', 'Perfil guardado exitosamente!');
         
      }

    public function verPerfilEstudiante($id){

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

          
        $genero = Gender::pluck('name','id');
        $sexo = array('F' => 'Femenino',
                      'M' => 'Masculino' );

        $tipo_documento = array('1' => 'Cedula de Ciudadania',
                                '2' => 'Tarjeta de Identidad',
                                '3' => 'Cedula Extranjera' );
        $documento = DocumentType::pluck('name','id');

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

        

        

        $ip = User::getRealIP();
        $id = auth()->user();
        $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y');

        $estado = Condition::pluck('name', 'id');
        $motivos = Reasons::pluck('name', 'id');
       //dd($fecha);
            $datos = LogsCrudActions::create([
            'identificacion'           => $id['cedula'],
            'rol'                      => $id['rol_id'],   
            'ip'                       => $ip,
            'id_usuario_accion'        => $verDatosPerfil['id'],
            'actividad_realizada'      => 'ANALISIS DE REGISTRO',
            ]);



         if($verDatosPerfil->photo == ""){
            $foto = null;
        }else{
            $foto = explode("/",$verDatosPerfil->photo);
            $foto = $foto[5];

        }    

        return view('perfilEstudiante.verDatos', compact('motivos','foto','estado','verDatosPerfil','genero','sexo','tipo_documento','documento','edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'seguimientos', 'cohorte', 'grupos'));  

        }  
      

    
  
    public function verDatosSocieconomicos($id) {
        //dd($id_student);
        //$datos = SocioeconomicData::all()->where('id_student', $id_student); 
        $datos = perfilEstudiante::findOrFail($id);
        //dd($datos);

        return view('perfilEstudiante.datosSocioeconomicos', compact('datos'));
    }

 

    public function updateDatosSocioeconomicos($id, Request $request) {
       // dd($id);
        $data = SocioeconomicData::findOrFail($id);
        //dd($data);
        $mensaje = "Datos Socieconomicos actualizados correctamente!!";

        if ($request->ajax()) {

            $data->id_ocupation            = $request['id_ocupation'];
            $data->id_civil_status         = $request['id_civil_status'];  
            $data->children_number         = $request['children_number'];
            $data->id_residence_time       = $request['id_residence_time'];
            $data->id_housing_type         = $request['id_housing_type'];
            $data->id_health_regime        = $request['id_health_regime'];
            $data->sisben_category         = $request['sisben_category'];
            $data->id_benefits             = $request['id_benefits'];
            $data->household_people        = $request['household_people'];
            $data->economic_possition      = $request['economic_possition'];
            $data->dependent_people        = $request['dependent_people'];
            $data->internet_zon            = $request['internet_zon'];
            $data->internet_home           = $request['internet_home'];
            $data->sex_document_identidad  = $request['sex_document_identidad'];
            $data->id_social_conditions    = $request['id_social_conditions'];
            $data->id_disability           = $request['id_disability'];
            $data->id_ethnicity            = $request['id_ethnicity'];
            
            $data->save();
            
        };
        
         return $mensaje;

    }

    public function verDatosAcademicos($id){
        $datos = perfilEstudiante::findOrFail($id);

        return view('perfilEstudiante.verdatosAcademicos', compact('datos'));
    }


    public function updateDatosAcademicos($id, Request $request) {
        $acade = PreviousAcademicData::findOrFail($id);
        //dd($acade);

        $mensaje = "Datos academicos previos actualizados correctamente!!";

        if ($request->ajax()) {

            $acade->institution_name    = $request['institution_name'];   
            $acade->year_graduation     = $request['year_graduation'];
            $acade->bachelor_title      = $request['bachelor_title'];
            $acade->icfes_date          = $request['icfes_date'];
            $acade->snp_register        = $request['snp_register'];
            $acade->icfes_score         = $request['icfes_score'];
            
            $acade->save();
            
        };
        
         return $mensaje;  
    }

    public function editarPerfilEstudiante($id){

        //dd('entro a estudiante editar');
        $verDatosPerfil = perfilEstudiante::findOrFail($id);

        $cohort = $verDatosPerfil->studentGroup->group->cohort->id;
        $grupos = Group::where('id_cohort', $cohort)->pluck('name', 'id');
        //return $grupos;

        
        $seguimientos = SocioEducationalFollowUp::all()->where('id_student', $verDatosPerfil['id']);


        $seguimientos = SocioEducationalFollowUp::all()->where('id_student', $verDatosPerfil['id']);

          
        $genero = Gender::pluck('name','id');
        $sexo = array('F' => 'Femenino',
                      'M' => 'Masculino' );

        
        $tipo_documento = array('1' => 'Cedula de Ciudadania',
                                '2' => 'Tarjeta de Identidad',
                                '3' => 'Cedula Extranjera' );
        $documento = DocumentType::pluck('name','id');

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


        if($verDatosPerfil->photo == ""){
            $foto = null;
        }else{
            $foto = explode("/",$verDatosPerfil->photo);
            $foto = $foto[5];
        } 
      
        $depNacimiento = BirthDepartament::pluck('name','id');

        $muni_nacimiento = BirthCity::pluck('name','id');

        $ciudad = BirthCity::pluck('name', 'id');


        return view('perfilEstudiante.verEditarDatos', compact('motivos','foto','estado','verDatosPerfil','genero','sexo','tipo_documento','documento','edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'depNacimiento', 'muni_nacimiento', 'ciudad', 'seguimientos', 'cohorte', 'grupos'));

    }

    

    public function updatePerfilEstudiante($id, Request $request) {

        $data = perfilEstudiante::findOrFail($id);
        
        $mensaje = "Datos generales actualizados correctamente!!";

        $depNacimiento = BirthDepartament::pluck('name','id');
        $muni_nacimiento = BirthCity::pluck('name','id');
        

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
            
        };
        
         return $mensaje;
    }

    public function eliminarPerfilEstudiante(Request $request, $id){

       $data = perfilEstudiante::findOrFail($id);

       $ip = User::getRealIP();
       $id = auth()->user();
       $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y h:i:s A');
       //dd($fecha);
            $datos = LogsCrudActions::create([
            'identificacion'           => $id['cedula'],
            'rol'                      => $id['rol_id'],   
            'ip'                       => $ip,
            'id_usuario_accion'        => $data['id'],
            'actividad_realizada'      => 'SE ELIMINO UN REGISTRO',
            ]); 

            $data -> delete();

        return redirect('estudiante')->with('status', 'Perfil eliminado exitosamente!');

    }

     public function eliminarPerfilEstudianteSystem(Request $request, $id){

       $data = perfilEstudiante::findOrFail($id);

       $ip = User::getRealIP();
       $id = auth()->user();
       $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y h:i:s A');
       //dd($fecha);
            $datos = LogsCrudActions::create([
            'identificacion'           => Auth::user()->identificacion,
            'rol'                      => Auth::user()->rol_id,   
            'ip'                       => $ip,
            'id_usuario_accion'        => $id,
            'actividad_realizada'      => 'SE ELIMINO UN REGISTRO',
            ]); 

            $data -> delete();
    }


    public function municipios(Request $request, $id)
    {
        $municipios = BirthCity::where('id_departament',$id)->get();
        //dd($municipios);
        if($request->ajax())
        {
         
          return response()->json($municipios);
        }
    }

    public function indexAsignaturas()
    {
        $asignaturas = Course::All();

        //dd($asignaturas);

        return view('perfilEstudiante.asignaturas.index',compact('asignaturas'));
    }

    public function verGrupos($id)
    {   
        $name = Course::where('id',$id)->first();
        $grupos = Group::all()->where('id_cohort',$name->id_cohort);
        
        //dd($name);

        return view('perfilEstudiante.asignaturas.grupos',compact('grupos','name'));
    }

    public function vernotas($id)
    {   
        $grupo = Group::where('id',$id)->first();

        $notas = StudentGroup::all()->where('id_group', $id);
        
        //dd($grupo);

        return view('perfilEstudiante.asignaturas.notas',compact('notas','id','grupo'));
    }

    public function updateEstado($id, Request $request){
       $status = "Estado actualizado correctamente!!";
        if($request->ajax())
        {
            $estado = perfilEstudiante::findOrFail($id);        
            $estado->id_state = $request['id_state'];
            $estado->save();
            if($request['id_state'] != 1){  
            $estado -> delete();
            //eliminarPerfilEstudiante($id);
            }
            $datos = Withdrawals::create([
                'id_student'   =>  $id,
                'id_reasons'   =>  $request['id_reasons'],
                'observation'  =>  $request['observation'],
            ]);
                        
            return 'true';            
        };
    }


    public function indexAsistencias() {

        $asignaturas = Course::All();

        //dd($asignaturas);

        return view('perfilEstudiante.Asistencias.index',compact('asignaturas'));
    }

    public function Grupos_Asignaturas($id)
    {   
        $name = Course::where('id',$id)->first();
        $grupos = Group::all()->where('id_cohort',$name->id_cohort);
        
        //dd($name);

        return view('perfilEstudiante.Asistencias.grupos',compact('grupos','name'));
    }

    public function Asistencias_grupo($course,$id,$id_session)
    {   
        $grupo = Group::where('id',$id)->first();
        $name = Course::where('id',$course)->first();
        $notas = StudentGroup::all()->where('id_group', $id);
        
        //dd($grupo);

        return view('perfilEstudiante.Asistencias.notas',compact('notas','grupo','name','id_session'));
    }

    public function sesiones($course,$id){
        
        $grupo=Group::where('id',$id)->first();
        $name = Course::where('id',$course)->first();
        $notas = StudentGroup::where('id_group', $id)->get('id_student');
        $id_moole = array();
        $contador = 0;
        foreach ($notas as $student){
   
            $moodle = perfilEstudiante::where('id', $student['id_student'])->get('id_moodle'); 

            foreach ($moodle as $id){
                $id_moole[$contador] = $id->id_moodle;
            }
            $contador++;
            
        }

        return view('perfilEstudiante.Asistencias.sesiones',compact('grupo','name','id_moole'));
    }
    public function store_seguimiento(Request $request) {

        $mensaje = 'Seguimiento creado correctamente';
        $error = 'no puede crear';
        $id = auth()->user();    

        if($request->ajax()){

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']),'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindiV']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacadE']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfamiL'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkeconoM']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuniC']), 'Observaciones' => ($request['textareobservaciones'])];

            $horainicio = $arreglo['HoraInicio']; 
            $horafin = $arreglo['HoraFin'];

            if ($horafin > $horainicio) {
                $validacionHora = 'true';
            }else{
                $validacionHora = 'false';
            }

            if($arreglo['Individual'] != null && $arreglo['RiesgoIndividual'] != null) {
                
                $vlrndvdal = 'true';
            }else{
                $vlrndvdal = 'false';
            }
            
            if($arreglo['Academico'] != null && $arreglo['RiesgoAcademico'] != null) {
                
                $vlracdmco = 'true';
            }else{
                $vlracdmco = 'false';
            }

            if($arreglo['Familiar'] != null && $arreglo['RiesgoFamiliar'] != null) {
                
                $vlrfmlar = 'true';
            }else{
                $vlrfmlar = 'false';
            }

            if($arreglo['Economico'] != null && $arreglo['RiesgoEconomico'] != null) {
                
                $vlrecnmco = 'true';
            }else{
                $vlrecnmco = 'false';
            }

            if($arreglo['VidaUniversitariaYciudad'] != null && $arreglo['RiesgoUc'] != null) {
                
                $vlruyc = 'true';
            }else{
                $vlruyc = 'false';
            }

            

                if($arreglo['fecha'] == null && $arreglo['Lugar'] == null && $arreglo['HoraInicio'] == null && $arreglo['HoraFin'] == null && $arreglo['Objetivos'] == null && $arreglo['Individual'] == null && $arreglo['RiesgoIndividual'] == null && $arreglo['Academico'] == null && $arreglo['RiesgoAcademico'] == null && $arreglo['Familiar'] == null && $arreglo['RiesgoFamiliar'] == null && $arreglo['Economico'] == null && $arreglo['RiesgoEconomico'] == null && $arreglo['VidaUniversitariaYciudad'] == null && $arreglo['RiesgoUc'] == null && $arreglo['Observaciones'] == null){  
                    
                    echo 'No es posible crear un seguimiento vacio';

                }else{
                    
                    if($arreglo['fecha'] != null && $arreglo['Lugar'] != null && $arreglo['HoraInicio'] != null && $arreglo['HoraFin'] != null && $arreglo['Objetivos'] != null){

                        if($arreglo['Individual'] != null || $arreglo['Academico'] != null || $arreglo['Familiar'] != null || $arreglo['Economico'] != null || $arreglo['VidaUniversitariaYciudad'] != null){

                            if($vlrndvdal == 'true' && $vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true'){
                                
                                if($validacionHora == 'true'){    
                                    $guardar = json_encode($arreglo);
                                    $datossegui = SocioEducationalFollowUp::create([
                                        'id_student'       => $request['id_student'],
                                        'id_user'          => $id['id'],
                                        'tracking_detail'  => $guardar,
                                    ]);
                                    return $mensaje;
                                }else{
                                    echo 'La hora final debe ser mayor a la hora inicial';
                                }
                                    

                            }else{
                                if($vlrndvdal == 'true'){
                                    $indi = $arreglo['Individual'];
                                    $riesgoindi = $arreglo['RiesgoIndividual'];

                                    if($vlracdmco == 'true' || $vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {
                                            if($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlruyc == 'true') {
                                                if($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                }else{
                                                        //echo 'guarde 1 2 3 y 5';
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                
                                            }else{
                                                if($vlracdmco == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true'){
                                                    if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';  
                                                    }else{
                                                        //echo 'guarde 1 2 4 y 5';
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                            
                                                    }
                                                    
                                                }else{
                                                    if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                                        if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        }else{
                                                            // echo 'guarde 1 3 4 y 5';
                                                            if($validacionHora == 'true'){    
                                                                $guardar = json_encode($arreglo);
                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                    'id_student'       => $request['id_student'],
                                                                    'id_user'          => $id['id'],
                                                                    'tracking_detail'  => $guardar,
                                                                ]);
                                                                return $mensaje;
                                                            }else{
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }                                                   
                                                        }
                                                    }else{

                                                        if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                            if ($arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            }else{
                                                             //   echo 'guarde 1 2 3 y 4';
                                                                if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                        'id_student'       => $request['id_student'],
                                                                        'id_user'          => $id['id'],
                                                                        'tracking_detail'  => $guardar,
                                                                    ]);
                                                                    return $mensaje;
                                                                }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        }else{
                                                            if($vlracdmco == 'true' && $vlrecnmco == 'true'){

                                                                if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){
                                                                    echo 'Las categorias deben ser diligenciadas completamente';  
                                                                }else{
                                                               //     echo 'guarde 1 2 y 4';
                                                                    if($validacionHora == 'true'){    
                                                                        $guardar = json_encode($arreglo);
                                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                            'id_student'       => $request['id_student'],
                                                                            'id_user'          => $id['id'],
                                                                            'tracking_detail'  => $guardar,
                                                                        ]);
                                                                        return $mensaje;
                                                                    }else{
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }else{
                                                                if($vlrfmlar == 'true' && $vlrecnmco == 'true'){
                                                                    if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){
                                                                        echo 'Las categorias deben ser diligenciadas completamente'; 

                                                                    }else{
                                                                 //       echo 'guarde 1 3 y 4';
                                                                        if($validacionHora == 'true'){    
                                                                            $guardar = json_encode($arreglo);
                                                                            $datossegui =
                                                                            SocioEducationalFollowUp::create([
                                                                                'id_student'       => $request['id_student'],
                                                                                'id_user'          => $id['id'],
                                                                                'tracking_detail'  => $guardar,
                                                                            ]);
                                                                            return $mensaje;
                                                                        }else{
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                }else{
                                                                    if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                                        if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                        }else{
                                                                   //         echo 'guarde 1 3 y 5';
                                                                            if($validacionHora == 'true'){    
                                                                                $guardar = json_encode($arreglo);
                                                                                $datossegui = 
                                                                                SocioEducationalFollowUp::create(
                                                                                    [
                                                                                    'id_student'       => $request['id_student'],
                                                                                    'id_user'          => $id['id'],
                                                                                    'tracking_detail'  => $guardar,
                                                                                    ]);
                                                                                return $mensaje;
                                                                            }else{
                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                            }
                                                                        }
                                                                    }else{
                                                                        if($vlracdmco == 'true' && $vlruyc == 'true'){
                                                                            if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){
                                                                                echo 'Las categorias deben ser diligenciadas completamente';

                                                                            }else{
                                                                     //           echo ' guarde 1 2 y 5';
                                                                                if($validacionHora == 'true'){    
                                                                                    $guardar = json_encode($arreglo);
                                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                                        'id_student'       => $request['id_student'],
                                                                                        'id_user'          => $id['id'],
                                                                                        'tracking_detail'  => $guardar,
                                                                                    ]);
                                                                                    return $mensaje;
                                                                                }else{
                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                }
                                                                            }
                                                                        }else{

                                                                            if($vlracdmco == 'true' && $vlrfmlar == 'true'){
                                                                                if($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                                }else{
                                                                                    //guarde 1 2 y 3
                                                                                    if($validacionHora == 'true'){    
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                                            'id_student'       => $request['id_student'],
                                                                                            'id_user'          => $id['id'],
                                                                                            'tracking_detail'  => $guardar,
                                                                                        ]);
                                                                                        return $mensaje;
                                                                                    }else{
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                            }else{
                                                                                if($vlrecnmco == 'true' && $vlruyc == 'true'){
                                                                                        if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null){
                                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                                }else{
                                                                       //             echo 'guarde 1 4 y 5';
                                                                                    if($validacionHora == 'true'){    
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                                            'id_student'       => $request['id_student'],
                                                                                            'id_user'          => $id['id'],
                                                                                            'tracking_detail'  => $guardar,
                                                                                        ]);
                                                                                        return $mensaje;
                                                                                    }else{
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                                }else{

                                                                                if($vlracdmco == 'true'){

                                                                                    if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                                                         echo 'Las categorias deben ser diligenciadas completamente';  
                                                                                    }else{
                                                                         //               echo 'guarde 1 y 2';
                                                                                        if($validacionHora == 'true'){    
                                                                                            $guardar = json_encode($arreglo);
                                                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                                                'id_student'       => $request['id_student'],
                                                                                                'id_user'          => $id['id'],
                                                                                                'tracking_detail'  => $guardar,
                                                                                            ]);
                                                                                            return $mensaje;
                                                                                        }else{
                                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                                        }
                                                                                    }
                                                
                                                                                }else{
                                                                                    if($vlrfmlar == 'true') {
                                                                                        if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){
                                                                                            echo 'Las categorias deben ser diligenciadas completamente';  
                                                                                        }else{
                                                                           //                 echo 'guarde 1 y 3';
                                                                                            if($validacionHora == 'true'){    
                                                                                                $guardar = json_encode($arreglo);
                                                                                                $datossegui = SocioEducationalFollowUp::create([
                                                                                                    'id_student'       => $request['id_student'],
                                                                                                    'id_user'          => $id['id'],
                                                                                                    'tracking_detail'  => $guardar,
                                                                                                ]);
                                                                                                return $mensaje;
                                                                                            }else{
                                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                                            }   
                                                                                        }   
                                                                                    }else{
                                                                                        if($vlrecnmco == 'true'){
                                                                                            if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                              
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                                            }else{
                                                                                           //     echo 'guarde 1 y 4';    
                                                                                                if($validacionHora == 'true'){    
                                                                                                    $guardar = json_encode($arreglo);
                                                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                                                        'id_student'       => $request['id_student'],
                                                                                                        'id_user'          => $id['id'],
                                                                                                        'tracking_detail'  => $guardar,
                                                                                                    ]);
                                                                                                    return $mensaje;
                                                                                                }else{
                                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                                }
                                                                                            }
                                                                                        }else{
                                                                                            if($vlruyc == 'true') {
                                                                                                if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';

                                                                                                }else{
                                                                                             //       echo 'guarde 1 y 5';
                                                                                                    if($validacionHora == 'true'){    
                                                                                                        $guardar = json_encode($arreglo);
                                                                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                                                            'id_student'       => $request['id_student'],
                                                                                                            'id_user'          => $id['id'],
                                                                                                            'tracking_detail'  => $guardar,
                                                                                                        ]);
                                                                                                        return $mensaje;
                                                                                                    }else{
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

                                    }else{
                                        if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){

                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        }else{

                                            
                                                //echo "guarde con lo del primero";    
                                                if($validacionHora == 'true'){    
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                }else{
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }

                                        }
                                        
                                    } 
                                }else{
                                    if($vlracdmco == 'true') {
                                        $acade = $arreglo['Academico'];
                                        $riesgoacade = $arreglo['RiesgoAcademico'];
                                        
                                        if($vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true'){
                                            
                                            
                                            if($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true'){
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                }else{
                                                    //echo 'guarde 2, 3 4 y 5';    
                                                    if($validacionHora == 'true'){    
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    }else{
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                                
                                            }else{
                                                if($vlrfmlar == 'true' && $vlrecnmco == 'true'){
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        
                                                        echo 'Las categorias deben ser diligenciadas completamente';                                                            
                                                    }else{
                                                        //guarda 2 3 y 4
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                               'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }      
                                                    }
                                                }else{

                                                    if($vlrfmlar == 'true' && $vlruyc == 'true'){
                                                        if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){
                                                            echo 'Las categorias deben ser diligenciada completamente'; 
                                                        }else{
                                                            //guarda 2 3 y 5
                                                            if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                        'id_student'       => $request['id_student'],
                                                                        'id_user'          => $id['id'],
                                                                        'tracking_detail'  => $guardar,
                                                                    ]);
                                                                    return $mensaje;
                                                            }else{
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }else{
                                                        if($vlrecnmco == 'true' && $vlruyc == 'true'){
                                                            if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                                echo 'Las categorias deben ser diligenciadas completamente'; 
                                                            }else{
                                                                //guarda 2 4 5
                                                                if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                        'id_student'       => $request['id_student'],
                                                                        'id_user'          => $id['id'],
                                                                        'tracking_detail'  => $guardar,
                                                                    ]);
                                                                    return $mensaje;
                                                                }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        }else{
                                                            if($vlrecnmco == 'true'){
                                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                }else{
                                                                    //guarda 2 y 4
                                                                    if($validacionHora == 'true'){    
                                                                        $guardar = json_encode($arreglo);
                                                                        $datossegui = SocioEducationalFollowUp::create([
                                                                            'id_student'       => $request['id_student'],
                                                                            'id_user'          => $id['id'],
                                                                            'tracking_detail'  => $guardar,
                                                                        ]);
                                                                        return $mensaje;
                                                                    }else{
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }else{
                                                                if($vlruyc == 'true'){
                                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                    }else{
                                                                        //guarda 2 y 5
                                                                        if($validacionHora == 'true'){    
                                                                            $guardar = json_encode($arreglo);
                                                                            $datossegui = 
                                                                            SocioEducationalFollowUp::create([
                                                                                'id_student'       => $request['id_student'],
                                                                                'id_user'          => $id['id'],
                                                                                'tracking_detail'  => $guardar,
                                                                            ]);
                                                                            return $mensaje;
                                                                        }else{
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }else{

                                            if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                echo 'Las categorias deben ser diligenciadas completamente';    
                                            }else{
                                                //guarda 2 solo
                                                if($validacionHora == 'true'){    
                                                    $guardar = json_encode($arreglo);
                                                    $datossegui = SocioEducationalFollowUp::create([
                                                        'id_student'       => $request['id_student'],
                                                        'id_user'          => $id['id'],
                                                        'tracking_detail'  => $guardar,
                                                    ]);
                                                    return $mensaje;
                                                }else{
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        
                                        }
                                        
                                    }else{
                                        if($vlrfmlar == 'true'){
                                            

                                            if($vlrecnmco == 'true' || $vlruyc == 'true'){
                                                

                                                if($vlrecnmco == 'true' && $vlruyc == 'true'){
                                                    //guarda 3 4 y 5
                                                    if($validacionHora == 'true'){    
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    }else{
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }    
                                                }else{

                                                    if($vlrecnmco == 'true'){
                                                        if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        }else{
                                                            //guarda 3 y 4
                                                            if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                        'id_student'       => $request['id_student'],
                                                                        'id_user'          => $id['id'],
                                                                        'tracking_detail'  => $guardar,
                                                                    ]);
                                                                    return $mensaje;
                                                            }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }else{
                                                        if($vlruyc == 'true'){
                                                            if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                            }else{
                                                                //guarda 3 y 5
                                                                if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $datossegui = SocioEducationalFollowUp::create([
                                                                        'id_student'       => $request['id_student'],
                                                                        'id_user'          => $id['id'],
                                                                        'tracking_detail'  => $guardar,
                                                                    ]);
                                                                    return $mensaje;
                                                                }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                            }else{
                                                if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null ||  $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                }else{
                                                    //guarda 3
                                                    if($validacionHora == 'true'){    
                                                        $guardar = json_encode($arreglo);
                                                        $datossegui = SocioEducationalFollowUp::create([
                                                            'id_student'       => $request['id_student'],
                                                            'id_user'          => $id['id'],
                                                            'tracking_detail'  => $guardar,
                                                        ]);
                                                        return $mensaje;
                                                    }else{
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            }
                                        }else{
                                            if ($vlrecnmco == 'true') {

                                                if($vlruyc == 'true'){
                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    }else{
                                                        //guarda 4 y 5                   
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::
                                                            create([
                                                                'id_student'       => $request['
                                                                 id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                }else{
                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    }else{
                                                    
                                                        //guarda 4
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                               'id_student'       => $request['id_student'],
                                                               'id_user'          => $id['id'],
                                                               'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }    
                                                    }
                                                }                                                               
                                            }else{
                                                if($vlruyc == 'true'){
                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                        echo 'Las categorias deben ser diligenciadas completamente';

                                                    }else{
                                                        //guarda 5                                                         
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $datossegui = SocioEducationalFollowUp::create([
                                                                'id_student'       => $request['id_student'],
                                                                'id_user'          => $id['id'],
                                                                'tracking_detail'  => $guardar,
                                                            ]);
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                }else{
                                                    echo 'No es posible crear un seguimiento con esa estructura';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        echo 'No es posible crear un seguimiento con esa estructura';
                    }
                }
            }else{
                echo 'No es posible crear un seguimiento con esa estructura';
            }
    }
            

    public function edit_seguimiento($id, Request $request){

        $seguimiento = SocioEducationalFollowUp::findOrFail($id);   
            
        if($request->ajax()){
            return Response::json($seguimiento); 
        };        
    }

    public function update_seguimiento($id, Request $request) {
        //dd($request);
        $data = SocioEducationalFollowUp::findOrFail($id);
        
        $mensaje = "Seguimiento socioeducativo actualizado correctamente!!";

        if ($request->ajax()) { 

            $arreglo = ['fecha' => ($request['date']), 'Lugar' => ($request['lugarsegui']), 'HoraInicio' => ($request['iniciohora']), 'HoraFin' => ($request['finhora']),'Objetivos' => ($request['textareaobjetivos']), 'Individual' => ($request['texareaindividual']), 'RiesgoIndividual' => ($request['checkindi']), 'Academico' => ($request['textareaacademico']), 'RiesgoAcademico' => ($request['checkacad']), 'Familiar' => ($request['textareafamil']), 'RiesgoFamiliar' => $request['checkfami'], 'Economico' => ($request['textareaecono']), 'RiesgoEconomico' => ($request['checkecono']), 'VidaUniversitariaYciudad' => ($request['textareavidauni']), 'RiesgoUc' => ($request['checkuni']), 'Observaciones' => ($request['textareobservaciones'])];

            $horainicio = $arreglo['HoraInicio']; 
            $horafin = $arreglo['HoraFin'];

            if ($horafin > $horainicio) {
                $validacionHora = 'true';
            }else{
                $validacionHora = 'false';
            }

            if($arreglo['Individual'] != null && $arreglo['RiesgoIndividual'] != null) {
                
                $vlrndvdal = 'true';
            }else{
                $vlrndvdal = 'false';
            }
            
            if($arreglo['Academico'] != null && $arreglo['RiesgoAcademico'] != null) {
                
                $vlracdmco = 'true';
            }else{
                $vlracdmco = 'false';
            }

            if($arreglo['Familiar'] != null && $arreglo['RiesgoFamiliar'] != null) {
                
                $vlrfmlar = 'true';
            }else{
                $vlrfmlar = 'false';
            }

            if($arreglo['Economico'] != null && $arreglo['RiesgoEconomico'] != null) {
                
                $vlrecnmco = 'true';
            }else{
                $vlrecnmco = 'false';
            }

            if($arreglo['VidaUniversitariaYciudad'] != null && $arreglo['RiesgoUc'] != null) {
                
                $vlruyc = 'true';
            }else{
                $vlruyc = 'false';
            }

            if($arreglo['fecha'] == null && $arreglo['Lugar'] == null && $arreglo['HoraInicio'] == null && $arreglo['HoraFin'] == null && $arreglo['Objetivos'] == null && $arreglo['Individual'] == null && $arreglo['RiesgoIndividual'] == null && $arreglo['Academico'] == null && $arreglo['RiesgoAcademico'] == null && $arreglo['Familiar'] == null && $arreglo['RiesgoFamiliar'] == null && $arreglo['Economico'] == null && $arreglo['RiesgoEconomico'] == null && $arreglo['VidaUniversitariaYciudad'] == null && $arreglo['RiesgoUc'] == null && $arreglo['Observaciones'] == null){  
                    
                    echo 'No es posible crear un seguimiento vacio';

                }else{
                    
                    if($arreglo['fecha'] != null && $arreglo['Lugar'] != null && $arreglo['HoraInicio'] != null && $arreglo['HoraFin'] != null && $arreglo['Objetivos'] != null){

                        if($arreglo['Individual'] != null || $arreglo['Academico'] != null || $arreglo['Familiar'] != null || $arreglo['Economico'] != null || $arreglo['VidaUniversitariaYciudad'] != null){

                            if($vlrndvdal == 'true' && $vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true'){
                                
                                if($validacionHora == 'true'){    
                                    $guardar = json_encode($arreglo);
                                    $data->tracking_detail = $guardar;
                                    $data->save();
                                    return $mensaje;
                                }else{
                                    echo 'La hora final debe ser mayor a la hora inicial';
                                }
                                    

                            }else{
                                if($vlrndvdal == 'true'){
                                    $indi = $arreglo['Individual'];
                                    $riesgoindi = $arreglo['RiesgoIndividual'];

                                    if($vlracdmco == 'true' || $vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true') {
                                            if($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlruyc == 'true') {
                                                if($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                }else{
                                                        //echo 'guarde 1 2 3 y 5';
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                
                                            }else{
                                                if($vlracdmco == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true'){
                                                    if ($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';  
                                                    }else{
                                                        //echo 'guarde 1 2 4 y 5';
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                            
                                                    }
                                                    
                                                }else{
                                                    if ($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true') {
                                                        if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null) {
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        }else{
                                                            // echo 'guarde 1 3 4 y 5';
                                                            if($validacionHora == 'true'){    
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                                }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }                                                   
                                                        }
                                                    }else{

                                                        if ($vlracdmco == 'true' && $vlrfmlar == 'true' && $vlrecnmco == 'true') {
                                                            if ($arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                            }else{
                                                             //   echo 'guarde 1 2 3 y 4';
                                                                if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                                }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        }else{
                                                            if($vlracdmco == 'true' && $vlrecnmco == 'true'){

                                                                if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){
                                                                    echo 'Las categorias deben ser diligenciadas completamente';  
                                                                }else{
                                                               //     echo 'guarde 1 2 y 4';
                                                                    if($validacionHora == 'true'){    
                                                                        $guardar = json_encode($arreglo);
                                                                        $data->tracking_detail = $guardar;
                                                                        $data->save();
                                                                         return $mensaje;
                                                                    }else{
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }else{
                                                                if($vlrfmlar == 'true' && $vlrecnmco == 'true'){
                                                                    if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){
                                                                        echo 'Las categorias deben ser diligenciadas completamente'; 

                                                                    }else{
                                                                 //       echo 'guarde 1 3 y 4';
                                                                        if($validacionHora == 'true'){    
                                                                            $guardar = json_encode($arreglo);
                                                                            $data->tracking_detail = $guardar;
                                                                            $data->save();
                                                                            return $mensaje;
                                                                        }else{
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                }else{
                                                                    if ($vlrfmlar == 'true' && $vlruyc == 'true') {
                                                                        if ($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                        }else{
                                                                   //         echo 'guarde 1 3 y 5';
                                                                            if($validacionHora == 'true'){    
                                                                                $guardar = json_encode($arreglo);
                                                                                $data->tracking_detail = $guardar;
                                                                                $data->save();
                                                                                return $mensaje;
                                                                            }else{
                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                            }
                                                                        }
                                                                    }else{
                                                                        if($vlracdmco == 'true' && $vlruyc == 'true'){
                                                                            if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){
                                                                                echo 'Las categorias deben ser diligenciadas completamente';

                                                                            }else{
                                                                     //           echo ' guarde 1 2 y 5';
                                                                                if($validacionHora == 'true'){    
                                                                                    $guardar = json_encode($arreglo);
                                                                                    $data->tracking_detail = $guardar;
                                                                                    $data->save();
                                                                                    return $mensaje;
                                                                                }else{
                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                }
                                                                            }
                                                                        }else{

                                                                            if($vlracdmco == 'true' && $vlrfmlar == 'true'){
                                                                                if($arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                                }else{
                                                                                    //guarde 1 2 y 3
                                                                                    if($validacionHora == 'true'){    
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $data->tracking_detail = $guardar;
                                                                                        $data->save();
                                                                                        return $mensaje;
                                                                                    }else{
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                            }else{
                                                                                if($vlrecnmco == 'true' && $vlruyc == 'true'){
                                                                                        if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null){
                                                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                                                }else{
                                                                       //             echo 'guarde 1 4 y 5';
                                                                                    if($validacionHora == 'true'){    
                                                                                        $guardar = json_encode($arreglo);
                                                                                        $data->tracking_detail = $guardar;
                                                                                        $data->save();
                                                                                        return $mensaje;
                                                                                    }else{
                                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                                    }
                                                                                }
                                                                                }else{

                                                                                if($vlracdmco == 'true'){

                                                                                    if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                                                         echo 'Las categorias deben ser diligenciadas completamente';  
                                                                                    }else{
                                                                         //               echo 'guarde 1 y 2';
                                                                                        if($validacionHora == 'true'){    
                                                                                            $guardar = json_encode($arreglo);
                                                                                            $data->tracking_detail = $guardar;
                                                                                            $data->save();
                                                                                            return $mensaje;
                                                                                        }else{
                                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                                        }
                                                                                    }
                                                
                                                                                }else{
                                                                                    if($vlrfmlar == 'true') {
                                                                                        if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){
                                                                                            echo 'Las categorias deben ser diligenciadas completamente';  
                                                                                        }else{
                                                                           //                 echo 'guarde 1 y 3';
                                                                                            if($validacionHora == 'true'){    
                                                                                                $guardar = json_encode($arreglo);
                                                                                                $data->tracking_detail = $guardar;
                                                                                                $data->save();
                                                                                                return $mensaje;
                                                                                            }else{
                                                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                                                            }   
                                                                                        }   
                                                                                    }else{
                                                                                        if($vlrecnmco == 'true'){
                                                                                            if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null) {
                                                              
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';
                                                                                            }else{
                                                                                           //     echo 'guarde 1 y 4';    
                                                                                                if($validacionHora == 'true'){    
                                                                                                    $guardar = json_encode($arreglo);
                                                                                                    $data->tracking_detail = $guardar;
                                                                                                    $data->save();
                                                                                                    return $mensaje;
                                                                                                }else{
                                                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                                                }
                                                                                            }
                                                                                        }else{
                                                                                            if($vlruyc == 'true') {
                                                                                                if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null) {
                                                                                                echo 'Las categorias deben ser diligenciadas completamente';

                                                                                                }else{
                                                                                             //       echo 'guarde 1 y 5';
                                                                                                    if($validacionHora == 'true'){    
                                                                                                        $guardar = json_encode($arreglo);
                                                                                                            $data->tracking_detail = $guardar;
                                                                                                            $data->save();
                                                                                                            return $mensaje;
                                                                                                    }else{
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

                                    }else{
                                        if($arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){

                                            echo 'Las categorias deben ser diligenciadas completamente';
                                        }else{

                                            
                                                //echo "guarde con lo del primero";    
                                                if($validacionHora == 'true'){    
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                }else{
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }

                                        }
                                        
                                    } 
                                }else{
                                    if($vlracdmco == 'true') {
                                        $acade = $arreglo['Academico'];
                                        $riesgoacade = $arreglo['RiesgoAcademico'];
                                        
                                        if($vlrfmlar == 'true' || $vlrecnmco == 'true' || $vlruyc == 'true'){
                                            
                                            
                                            if($vlrfmlar == 'true' && $vlrecnmco == 'true' && $vlruyc == 'true'){
                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                }else{
                                                    //echo 'guarde 2, 3 4 y 5';    
                                                    if($validacionHora == 'true'){    
                                                        $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                    }else{
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                                
                                            }else{
                                                if($vlrfmlar == 'true' && $vlrecnmco == 'true'){
                                                    if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        
                                                        echo 'Las categorias deben ser diligenciadas completamente';                                                            
                                                    }else{
                                                        //guarda 2 3 y 4
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }      
                                                    }
                                                }else{

                                                    if($vlrfmlar == 'true' && $vlruyc == 'true'){
                                                        if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){
                                                            echo 'Las categorias deben ser diligenciada completamente'; 
                                                        }else{
                                                            //guarda 2 3 y 5
                                                            if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                            }else{
                                                                echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }else{
                                                        if($vlrecnmco == 'true' && $vlruyc == 'true'){
                                                            if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                                echo 'Las categorias deben ser diligenciadas completamente'; 
                                                            }else{
                                                                //guarda 2 4 5
                                                                if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                                }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        }else{
                                                            if($vlrecnmco == 'true'){
                                                                if ($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                                }else{
                                                                    //guarda 2 y 4
                                                                    if($validacionHora == 'true'){    
                                                                        $guardar = json_encode($arreglo);
                                                                        $data->tracking_detail = $guardar;
                                                                        $data->save();
                                                                        return $mensaje;
                                                                    }else{
                                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                                    }
                                                                }
                                                            }else{
                                                                if($vlruyc == 'true'){
                                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                                    }else{
                                                                        //guarda 2 y 5
                                                                        if($validacionHora == 'true'){    
                                                                            $guardar = json_encode($arreglo);
                                                                            $data->tracking_detail = $guardar;
                                                                            $data->save();
                                                                            return $mensaje;
                                                                        }else{
                                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }else{

                                            if($arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                echo 'Las categorias deben ser diligenciadas completamente';    
                                            }else{
                                                //guarda 2 solo
                                                if($validacionHora == 'true'){    
                                                    $guardar = json_encode($arreglo);
                                                    $data->tracking_detail = $guardar;
                                                    $data->save();
                                                    return $mensaje;
                                                }else{
                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                }
                                            }
                                        
                                        }
                                        
                                    }else{
                                        if($vlrfmlar == 'true'){
                                            

                                            if($vlrecnmco == 'true' || $vlruyc == 'true'){
                                                

                                                if($vlrecnmco == 'true' && $vlruyc == 'true'){
                                                    //guarda 3 4 y 5
                                                    if($validacionHora == 'true'){    
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    }else{
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }    
                                                }else{

                                                    if($vlrecnmco == 'true'){
                                                        if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null){
                                                            echo 'Las categorias deben ser diligenciadas completamente';
                                                        }else{
                                                            //guarda 3 y 4
                                                            if($validacionHora == 'true'){    
                                                                $guardar = json_encode($arreglo);
                                                                $data->tracking_detail = $guardar;
                                                                $data->save();
                                                                return $mensaje;
                                                            }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                            }
                                                        }
                                                    }else{
                                                        if($vlruyc == 'true'){
                                                            if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                            }else{
                                                                //guarda 3 y 5
                                                                if($validacionHora == 'true'){    
                                                                    $guardar = json_encode($arreglo);
                                                                    $data->tracking_detail = $guardar;
                                                                    $data->save();
                                                                    return $mensaje;
                                                                }else{
                                                                    echo 'La hora final debe ser mayor a la hora inicial';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                            }else{
                                                if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null ||  $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                    echo 'Las categorias deben ser diligenciadas completamente';
                                                }else{
                                                    //guarda 3
                                                    if($validacionHora == 'true'){    
                                                        $guardar = json_encode($arreglo);
                                                        $data->tracking_detail = $guardar;
                                                        $data->save();
                                                        return $mensaje;
                                                    }else{
                                                        echo 'La hora final debe ser mayor a la hora inicial';
                                                    }
                                                }
                                            }
                                        }else{
                                            if ($vlrecnmco == 'true') {

                                                if($vlruyc == 'true'){
                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null){
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    }else{
                                                        //guarda 4 y 5                   
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                }else{
                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['VidaUniversitariaYciudad'] != null || $arreglo['RiesgoUc'] != null) {
                                                        echo 'Las categorias deben ser diligenciadas completamente';
                                                    }else{
                                                    
                                                        //guarda 4
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }    
                                                    }
                                                }                                                               
                                            }else{
                                                if($vlruyc == 'true'){
                                                    if($arreglo['Individual'] != null || $arreglo['RiesgoIndividual'] != null || $arreglo['Academico'] != null || $arreglo['RiesgoAcademico'] != null || $arreglo['Familiar'] != null || $arreglo['RiesgoFamiliar'] != null || $arreglo['Economico'] != null || $arreglo['RiesgoEconomico'] != null){

                                                        echo 'Las categorias deben ser diligenciadas completamente';

                                                    }else{
                                                        //guarda 5                                                         
                                                        if($validacionHora == 'true'){    
                                                            $guardar = json_encode($arreglo);
                                                            $data->tracking_detail = $guardar;
                                                            $data->save();
                                                            return $mensaje;
                                                        }else{
                                                            echo 'La hora final debe ser mayor a la hora inicial';
                                                        }
                                                    }
                                                }else{
                                                    echo 'No es posible crear un seguimiento con esa estructura';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        echo 'No es posible crear un seguimiento con esa estructura';
                    }
                }
            }else{
                echo 'No es posible crear un seguimiento con esa estructura';
            };
        }

    public function delete_seguimiento($id, Request $request){
        //dd('entro a eliminar');
        if($request->ajax())
        {
            $data = SocioEducationalFollowUp::findOrFail($id); 
            $data -> delete();
            return;
        }
    }

    public function grupos(Request $request, $id)
    {
        $grpos = Group::where('id_cohort',$id)->get();
        //return $grupos;
        if($request->ajax())
        {
         
          return response()->json($grpos);
        }
    }

    public function datosNuevos(Request $request, $id) {
        
        
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

    public function updateCohorteGrupo($id, Request $request) {
        
        $group = StudentGroup::findOrFail($id);
        
        $mensaje = "Datos actualizados correctamente!!";
        $error = 'El grupo seleccionado debe pertenecer a la cohorte correspondiente';

        $cohort = Group::where('id', $request['grupo'])->select('id_cohort')->first();
        $vlrchrte = $cohort->id_cohort;
        
        if ($request->ajax()) {

            if($vlrchrte == $request['cohorte']) {
                $group->id_group = $request['grupo'];
                
                $group->save();    
            }else{
                return $error; 
            }

        };
        
        return $mensaje;   

    }

<<<<<<< HEAD
    public function export(){

        return Excel::download(new SabanaExport, 'sabana.xlsx');
    }

    public function formalizacionupdate($id, Request $request){

        $data = Formalization::findOrFail($id);
        
        $mensaje = "Formalizacion generada correctamente!!";


        if ($request->ajax()) {

            $data->acceptance_v1      = $request['acceptance_v1'];
            $data->acceptance_v2      = $request['acceptance_v2'];   
            $data->tablets_v1         = $request['tablets_v1'];
            $data->tablets_v2         = $request['tablets_v2'];
            
            
            $data->save();
            
        };
        
         return $mensaje;
    }



    
=======
    public function excel(Request $request){

        $collection1 = Excel::toArray(new CsvImport, 'codigo.xlsx');
        //dd($collection);
        foreach($collection1 as $var) {

            foreach($var as $key => $value) {
                //var_dump($value);
                //echo $value['codigo'],' : ',$value['id_moodle'],'<br>';
                $insertar = perfilEstudiante::where('student_code',$value['codigo'])->update(['id_moodle' => $value['id_moodle']]);
            }    
        }

        $collection2 = Excel::toArray(new CsvImport, 'document.xlsx');
        //dd($collection);
        foreach($collection1 as $var) {

            foreach($var as $key => $value) {
                //var_dump($value);
                //echo $value['codigo'],' : ',$value['id_moodle'],'<br>';
                $insertar = perfilEstudiante::where('document_number',$value['document'])->update(['id_moodle' => $value['id_moodle']]);
            }    
        }

        //dd($request);
        $collection = Excel::toArray(new CsvImport, request()->file('file'));
        //dd($collection);
        foreach($collection[1] as $var) {
            //var_dump($var['nombres']);
            $id_student = perfilEstudiante::where('document_number',$var['no_documento'])->get('id');
            $consultar_grupo = Group::where('id_cohort',$var['linea'])->where('name',$var['nuevo_grupo'])->get('id');
            //dd($consultar_grupo);
            $id_students=0;
            foreach($id_student as $student){
                $id_students=$student->id;
            }
            //dd($id_students);
            $id_group =0;
            foreach($consultar_grupo as $id){
                $id_group=$id->id;
            }
            //dd($id_group);
            $cambio_grupo =StudentGroup::where('id_student',$id_students)->update(['id_group' => $id_group]);
            //dd($cambio_grupo);
        }
        foreach($collection[0] as $var) {
            //var_dump($var['nombres']);
            $id_student = perfilEstudiante::where('document_number',$var['no_documento'])->get('id');
            $consultar_grupo = Group::where('id_cohort',$var['linea'])->where('name',$var['nuevo_grupo'])->get('id');
            //dd($consultar_grupo);
            $id_students=0;
            foreach($id_student as $student){
                $id_students=$student->id;
            }
            //dd($id_students);
            $id_group =0;
            foreach($consultar_grupo as $id){
                $id_group=$id->id;
            }
            //dd($id_group);
            $cambio_grupo =StudentGroup::where('id_student',$id_students)->update(['id_group' => $id_group]);
            //dd($cambio_grupo);
        }
     

>>>>>>> ac7774a3ea96f1d9db2c780857df3a4824dd88ac
    
       return redirect('estudiante')->with('success', 'File imported successfully!');
    }
}


















