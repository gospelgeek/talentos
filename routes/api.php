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

Route::resource('datos_api/{user}/{token}/', 'api\DatosApiController');
Route::get('reporte_notas_linea_1/{user}/{token}/', 'api\DatosApiController@notas_linea_1')->name('reporte_notas_linea_1');

