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
Route::get('/home', 'HomeController@index')->name('home');
//Perfiles
Route::get('perfiles',      'PerfilesController@index')->name('perfiles');
Route::post('tipoperfil',   'TipoPerfilController@redirigir')->name('redirigir');

//Route::get('sistemas', 'UsuarioController@index');
//Route::get('prueba', 'UsuarioController@prueba');

//Rutas de loguin 
Route::post('logout',  'Auth\LoginController@logout')->name('logout');
Route::get('logout',   'Auth\LoginController@logout');


//Rutas de CRUD estudiantes

Route::get('departamento/{id}', 'perfilEstudianteController@municipios')->name('municipio');

Route::get('estudiante', 'perfilEstudianteController@indexPerfilEstudiante')->name('estudiante');
Route::get('crear_estudiante', 'perfilEstudianteController@crearPerfilEstudiante')->name('crear_estudiante');
Route::post('store_estudiante', 'perfilEstudianteController@storePerfilEstudiante')->name('store_estudiante');
Route::get('ver_estudiante/{id}', 'perfilEstudianteController@verPerfilEstudiante')->name('ver_estudiante');
Route::get('editar_estudiante/{id}', 'perfilEstudianteController@editarPerfilEstudiante')->name('editar_estudiante');
/*Route::put('update_estudiante/{id}', 'perfilEstudianteController@updatePerfilEstudiante')->name('update_estudiante');*/
Route::delete('delete_estudiante/{id}', 'perfilEstudianteController@eliminarPerfilEstudiante')->name('delete_estudiante');

Route::get('ver_datos_socioeconomicos/{id}', 'perfilEstudianteController@verDatosSocieconomicos')->name('ver_datos_socioeconomicos');
Route::get('editar_datos_socioeconomicos/{id}', 'perfilEstudianteController@editarDatosSocioeconomicos')->name('editar_datos_socioeconomicos');
Route::put('update_datos_socioeconomicos/{id}', 'perfilEstudianteController@updateDatosSocioeconomicos')->name('update_datos_socioeconomicos');

Route::get('ver_datos_academicos/{id}', 'perfilEstudianteController@verDatosAcademicos')->name('ver_datos_academicos');
Route::get('editar_datos_academicos/{id}', 'perfilEstudianteController@editarDatosAcademicos')->name('editar_datos_academicos');
Route::put('update_datos_academicos/{id}', 'perfilEstudianteController@updateDatosAcademicos')->name('update_datos_academicos');

//RUTAS DE AJAX
//ruta estado
Route::put('updateestado/{id}', 'perfilEstudianteController@updateEstado')->name('updateestado');
Route::put('updatedatosgenerales/{id}', 'perfilEstudianteController@updatePerfilEstudiante')->name('updatedatosgenerales');
Route::put('updatedatossocioeconomicos/{id}', 'perfilEstudianteController@updateDatosSocioeconomicos')->name('updatedatossocioeconomicos');
Route::put('updatedatosacademicosprevios/{id}', 'perfilEstudianteController@updateDatosAcademicos')->name('updatedatosacademicosprevios');


//Rutas CRUD usuarios
Route::get('usuario', 'UsuarioController@index')->name('usuario');
Route::get('crear_usuario', 'UsuarioController@crear')->name('crear_usuario');
Route::post('store_usuario', 'UsuarioController@store')->name('store_usuario');
Route::get('ver_usuario/{id}', 'UsuarioController@show')->name('ver_usuario');
Route::get('editar_usuario/{id}', 'UsuarioController@editar')->name('editar_usuario');
Route::put('update_usuario/{id}', 'UsuarioController@update')->name('update_usuario');
Route::delete('eliminar_usuario/{id}', 'UsuarioController@delete')->name('eliminar_usuario');

Route::get('estudiantes', 'UsuarioController@indexPerfilEstudiante')->name('usuario.estudiante');
Route::get('ver_estudiantes/{id}', 'UsuarioController@verPerfilEstudiante')->name('usuario.ver_estudiante');
Route::get('editar_estudiantes/{id}', 'UsuarioController@editarPerfilEstudiante')->name('usuario.editar_estudiante');
Route::put('update_estudiantes/{id}', 'UsuarioController@updatePerfilEstudiante')->name('usuario.update_estudiante');
Route::get('crear_estudiantes', 'UsuarioController@crearPerfilEstudiante')->name('usuario.crear_estudiante');
Route::post('store_estudiantes', 'UsuarioController@storePerfilEstudiante')->name('usuario.store_estudiante');

Route::get('datos_academicos/{id}', 'UsuarioController@verDatosAcademicos')->name('usuario.ver_datos_academicos');
Route::get('edit_datos_academicos/{id}', 'UsuarioController@editarDatosAcademicos')->name('usuario.editar_datos_academicos');
Route::put('updat_datos_academicos/{id}', 'UsuarioController@updateDatosAcademicos')->name('usuario.update_datos_academicos');

Route::get('datos_socioeconomicos/{id}', 'UsuarioController@verDatosSocieconomicos')->name('usuario.ver_datos_socioeconomicos');
Route::get('edit_datos_socioeconomicos/{id}', 'UsuarioController@editarDatosSocioeconomicos')->name('usuario.editar_datos_socioeconomicos');
Route::put('updat_datos_socioeconomicos/{id}', 'UsuarioController@updateDatosSocioeconomicos')->name('usuario.update_datos_socioeconomicos');










