<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*iniciar la aplicacion*/ 
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

//Rutas de loguin 
Route::post('logout',  'Auth\LoginController@logout')->name('logout');
Route::get('logout',   'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

//Rutas de CRUD
Route::get('/estudiante', 'perfilEstudianteController@indexPerfilEstudiante')->name('estudiante');

Route::get('/indexPerfilEstudiante', 'perfilEstudianteController@indexPerfilEstudiante')->name('indexPerfilEstudiante');

Route::get('/crearPerfilEstudiante', 'perfilEstudianteController@crearPerfilEstudiante')->name('crearPerfilEstudiante');

Route::post('/storePerfilEstudiante', 'perfilEstudianteController@storePerfilEstudiante')->name('storePerfilEstudiante');

Route::get('/verPerfilEstudiante/{id}', 'perfilEstudianteController@verPerfilEstudiante')->name('verPerfilEstudiante');

Route::get('/editarPerfilEstudiante/{id}', 'perfilEstudianteController@editarPerfilEstudiante')->name('editarPerfilEstudiante');

Route::put('/updatePerfilEstudiante/{id}', 'perfilEstudianteController@updatePerfilEstudiante')->name('updatePerfilEstudiante');

Route::delete('eliminarPerfilEstudiante/{id}', 'perfilEstudianteController@eliminarPerfilEstudiante')->name('eliminarPerfilEstudiante');















