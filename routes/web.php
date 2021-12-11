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

//Rutas de CRUD estudiantes
Route::get('estudiante', 'perfilEstudianteController@indexPerfilEstudiante')->name('estudiante');
Route::get('crear_estudiante', 'perfilEstudianteController@crearPerfilEstudiante')->name('crear_estudiante');
Route::post('store_estudiante', 'perfilEstudianteController@storePerfilEstudiante')->name('store_estudiante');
Route::get('ver_estudiante/{id}', 'perfilEstudianteController@verPerfilEstudiante')->name('ver_estudiante');
Route::get('editar_estudiante/{id}', 'perfilEstudianteController@editarPerfilEstudiante')->name('editar_estudiante');
Route::put('update_estudiante/{id}', 'perfilEstudianteController@updatePerfilEstudiante')->name('update_estudiante');
Route::delete('delete_estudiante/{id}', 'perfilEstudianteController@eliminarPerfilEstudiante')->name('delete_estudiante');

//Rutas CRUD usuarios
Route::get('usuario', 'UsuarioController@index')->name('usuario');
Route::get('crear_usuario', 'UsuarioController@crear')->name('crear_usuario');
Route::post('store_usuario', 'UsuarioController@store')->name('store_usuario');
Route::get('ver_usuario/{id}', 'UsuarioController@show')->name('ver_usuario');
Route::get('editar_usuario/{id}', 'UsuarioController@editar')->name('editar_usuario');
Route::put('update_usuario/{id}', 'UsuarioController@update')->name('update_usuario');












