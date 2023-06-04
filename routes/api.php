<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Datos generales
Route::resource('datos_api/{user}/{token}/', 'api\DatosApiController');
//reporte notas
Route::get('reporte_notas_linea_1/{user}/{token}/', 'api\DatosApiController@notas_linea_1')->name('reporte_notas_linea_1');
Route::get('reporte_notas_linea_2/{user}/{token}/', 'api\DatosApiController@notas_linea_2')->name('reporte_notas_linea_2');
Route::get('reporte_notas_linea_3/{user}/{token}/', 'api\DatosApiController@notas_linea_3')->name('reporte_notas_linea_3');
//comparativo icfes
Route::get('reporte_comparativo_icfes_l1/{user}/{token}/', 'api\DatosApiController@comparativo_icfes_l1')->name('reporte_comparativo_icfes_l1');
Route::get('reporte_comparativo_icfes_l2/{user}/{token}/', 'api\DatosApiController@comparativo_icfes_l2')->name('reporte_comparativo_icfes_l2');
Route::get('reporte_comparativo_icfes_l3/{user}/{token}/', 'api\DatosApiController@comparativo_icfes_l3')->name('reporte_comparativo_icfes_l3');

