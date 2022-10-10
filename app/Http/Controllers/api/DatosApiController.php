<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\perfilEstudiante;
use App\User;
use Illuminate\Support\Facades\Auth;

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

    /* public function signup(Request $request)
    {
        $request->validate([
            'cedula' => 'required|integer',
            'name' => 'required',
            'apellidos_user' => 'required',
            'tipo_documento_user' => 'required',
            'email' => 'required|string|email',
            'rol_id' => 'required',
            'password' => 'required|string'
        ]);

        User::create([
            'cedula' => $request->cedula,
            'name' => $request->name,
            'apellidos_user' => $request->apellidos_user,
            'tipo_documento_user' => $request->tipo_documento_user,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */
    /*public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|integer',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    /*public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Obtener el objeto User como json
     */
    /*public function user(Request $request)
    {
        return response()->json($request->user());
    }*/
}
