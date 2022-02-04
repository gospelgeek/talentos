<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
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
use App\InstitutionType;
use App\Course;
use App\Group;
use App\StudentGroup;
use App\Http\Requests\perfilEstudianteRequest;
use App\Http\Requests\DatosSocioeconomicosRequest;
use App\Http\Requests\DatosAcademicosRequest;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
use Session;
use Redirect;
use DB;



class perfilEstudianteController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function indexPerfilEstudiante(){
       // dd('mango');
        $perfilEstudiantes = perfilEstudiante::all();
        //$perfilEstudiantes = DB::table('student_profile')->get();
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

        $verDatosPerfil = perfilEstudiante::findOrFail($id);
        //dd($verDatosPerfil);  
        $genero = Gender::pluck('name','id');
        $sexo = array('F' => 'Femenino',
                      'M' => 'Masculino' );
        if($verDatosPerfil->socioeconomicdata->sex_document_identidad == 'H'){
           $sexo1 = "Masculino";     
        }elseif($verDatosPerfil->socioeconomicdata->sex_document_identidad == 'M'){
            $sexo1 = "Femenino"; 
        }

        if($verDatosPerfil->socioeconomicdata->internet_home == 0){
            $internet_home = "SI";
        }elseif($verDatosPerfil->socioeconomicdata->internet_home == 1){
            $internet_home = "NO";

        }

        if($verDatosPerfil->socioeconomicdata->internet_zon == 0){
            $internet_zone = "SI";
        }elseif($verDatosPerfil->socioeconomicdata->internet_zon == 1){
            $internet_zone = "NO";

        }
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


        $foto = explode("/",$verDatosPerfil->photo);    

        return view('perfilEstudiante.verDatos', compact('motivos','foto','estado','verDatosPerfil','internet_zone','internet_home','genero','sexo','sexo1','tipo_documento','documento','edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios'));   
    }
  
    public function verDatosSocieconomicos($id) {
        //dd($id_student);
        //$datos = SocioeconomicData::all()->where('id_student', $id_student); 
        $datos = perfilEstudiante::findOrFail($id);
        //dd($datos);

        return view('perfilEstudiante.datosSocioeconomicos', compact('datos'));
    }

 

    public function updatedatossocioeconomicos($id, Request $request) {
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

        $foto = explode("/",$verDatosPerfil->photo);

        $depNacimiento = BirthDepartament::pluck('name','id');

        $muni_nacimiento = BirthCity::pluck('name','id');

        $ciudad = BirthCity::pluck('name', 'id');

        return view('perfilEstudiante.verEditarDatos', compact('motivos','foto','estado','verDatosPerfil','genero','sexo','tipo_documento','documento','edad', 'ciudad_nacimiento', 'barrio', 'ocupacion', 'estado_civil', 'residencia', 'vivienda', 'regimen', 'condicion', 'discapacidad', 'etnia', 'estado', 'beneficios', 'depNacimiento', 'muni_nacimiento', 'ciudad'));
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
        $grupos = Group::all()->where('id_cohort',$id);
        //dd($grupos);

        return view('perfilEstudiante.asignaturas.grupos',compact('grupos'));
    }

    public function vernotas($id)
    {
        $notas = StudentGroup::all()->where('id_group', $id);
        //dd($notas);

        return view('perfilEstudiante.asignaturas.notas',compact('notas'));
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

    public function store_seguimiento() {

        dd('entro al store de seguimiento');
    }
}


















