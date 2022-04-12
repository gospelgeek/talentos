<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Requests\AlmuerzosRequest;
use App\Lunches;
use App\LogsCrudActions;
use App\UpdateInformation;
use App\User;
use Session;
use Redirect;
use DB;
use Response;

class AlmuerzosController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }

    public function datos_almuerzos(){

        $almuerzos = Lunches::all();
        
        $almuerzos->map(function ($datos) {
            $datos->total = $this->total_almuerzos($datos->number_lunches_line1, $datos->number_lunches_line2, $datos->number_lunches_line3);
        });

        return datatables()->of($almuerzos)->toJson();
    }
    
    public function total_almuerzos($number_lunches_line1, $number_lunches_line2, $number_lunches_line3){
         $total = $number_lunches_line1 + $number_lunches_line2 + $number_lunches_line3;

         return $total;
    }

    public function index(){

        return view('perfilEstudiante.almuerzos.index');
    }

    public function store(AlmuerzosRequest $request){
        
        $mensaje = 'Registro de almuerzos creado corectamente!!';

        if($request->ajax())
        {
       
            $almuerzo = Lunches::create([
                'date'                 => $request['date'],
                'number_lunches_line1' => $request['number_lunches_line1'],            
                'number_lunches_line2' => $request['number_lunches_line2'],
                'number_lunches_line3' => $request['number_lunches_line3'],          
            ]);

            

            $ip = User::getRealIP();
            $id = auth()->user();
            

            $datos = LogsCrudActions::create([
                'id_user'                  => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $almuerzo['id'],
                'actividad_realizada'      => 'SE CREO UN REGISTRO DE ALMUERZOS',
            ]);
        }

        return $mensaje;
    }   

    public function editar($id,Request $request){

        $almuerzos = Lunches::findOrFail($id);   


        if($request->ajax()){
            return Response::json($almuerzos); 
        };
    }

    public function actualizar($id, Request $request){
        $almuerzo = Lunches::findOrFail($id);
        $almuerzoOld = Lunches::findOrFail($id);

        $mensaje = "Registro de almuerzo actualizado correctamente!!";

        if ($request->ajax()) {

            $almuerzo->date                  = $request['date'];
            $almuerzo->number_lunches_line1  = $request['number_lunches_line1'];
            $almuerzo->number_lunches_line2  = $request['number_lunches_line2'];
            $almuerzo->number_lunches_line3  = $request['number_lunches_line3'];

            $almuerzo->save();

            $ip = User::getRealIP();
            $id = auth()->user();
            

            $datos = LogsCrudActions::create([
                'id_user'           => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $almuerzo['id'],
                'actividad_realizada'      => 'SE ACTUALIZO UN REGISTRO DE ALMUERZOS',
            ]);

            $old = array();
            $new = array();

            if($almuerzoOld->date != $almuerzo->date){
                $old[] = array('fecha registro' => $almuerzoOld->date);
                $new[] = array('fecha registro' => $almuerzo->date);
            }
            if($almuerzoOld->number_lunches_line1 != $almuerzo->number_lunches_line1){
                $old[] = array('cantida almuerzos linea 1' => $almuerzoOld->number_lunches_line1);
                $new[] = array('cantida almuerzos linea 1' => $almuerzo->number_lunches_line1);
            }
            if($almuerzoOld->number_lunches_line2 != $almuerzo->number_lunches_line2){
                $old[] = array('cantida almuerzos linea 2' => $almuerzoOld->number_lunches_line2);
                $new[] = array('cantida almuerzos linea 2' => $almuerzo->number_lunches_line2);
            }
            if($almuerzoOld->number_lunches_line3 != $almuerzo->number_lunches_line3){
                $old[] = array('cantida almuerzos linea 3' => $almuerzoOld->number_lunches_line3);
                $new[] = array('cantida almuerzos linea 3' => $almuerzo->number_lunches_line3);
            }

            $guardarOld = json_encode($old);
            $guardarNew = json_encode($new);

            $update = UpdateInformation::create([
                'id_log'              => $datos['id'],
                'changed_information' => $guardarOld,
                'new_information'     => $guardarNew,
            ]);

        }

        return $mensaje;
    }

    public function delete($id, Request $request){
        
        $data = Lunches::findOrFail($id);
        $mensaje = 'Registro de almuerzo eliminado correctamente';
        if ($request->ajax()) {
            
            $data->delete();
            
        }

        $ip = User::getRealIP();
        $id = auth()->user();
            

            $datos = LogsCrudActions::create([
                'id_user'           => $id['id'],
                'rol'                      => $id['rol_id'],
                'ip'                       => $ip,
                'id_usuario_accion'        => $data['id'],
                'actividad_realizada'      => 'SE ELIMINÓ UN REGISTRO DE ALMUERZOS',
            ]);

        return $mensaje;   
    }
}
