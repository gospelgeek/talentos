<?php

use Illuminate\Support\Facades\Artisan;
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
Route::post('store/save/usuarios',        'perfilEstudianteController@excel')->name('save.user');
Route::post('store/save/json', 'perfilEstudianteController@CargarJSon')->name('save.json');

/*iniciar la aplicacion*/ 
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');


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
Route::delete('delete_estudiante/{id}', 'perfilEstudianteController@eliminarPerfilEstudiante')->name('delete_estudiante');

Route::get('ver_datos_socioeconomicos/{id}', 'perfilEstudianteController@verDatosSocieconomicos')->name('ver_datos_socioeconomicos');
Route::get('editar_datos_socioeconomicos/{id}', 'perfilEstudianteController@editarDatosSocioeconomicos')->name('editar_datos_socioeconomicos');

Route::get('estudiantes_mayoria_edad', 'perfilEstudianteController@indexMenores')->name('estudiantes_mayoria_edad');
Route::get('menores', 'perfilEstudianteController@mostrarMenores')->name('datos.estudiantes.menores');


Route::get('ver_datos_academicos/{id}', 'perfilEstudianteController@verDatosAcademicos')->name('ver_datos_academicos');
Route::get('editar_datos_academicos/{id}', 'perfilEstudianteController@editarDatosAcademicos')->name('editar_datos_academicos');
Route::put('update_datos_academicos/{id}', 'perfilEstudianteController@updateDatosAcademicos')->name('update_datos_academicos');
Route::put('update_estado/{id}', 'perfilEstudianteController@updateEstado')->name('update_estado');

Route::get('asignaturas', 'perfilEstudianteController@indexAsignaturas')->name('asignaturas');
Route::get('grupos/{id}', 'perfilEstudianteController@verGrupos')->name('grupos');
Route::get('notas/{id}', 'perfilEstudianteController@vernotas')->name('notas');

Route::get('asistencias', 'perfilEstudianteController@indexAsistencias')->name('asistencias');
Route::get('Asistencias/{id}', 'perfilEstudianteController@Grupos_Asignaturas')->name('asistencias.grupos');
Route::get('/Asistencias/{course?}/grupo/{id?}', 'perfilEstudianteController@sesiones')->name('asistencias.sesiones');
Route::get('/Asistencias/{course?}/grupo/{id?}/session/{id_session?}', 'perfilEstudianteController@Asistencias_grupo')->name('asistencias.asignatura');

//RUTAS DE AJAX
//ruta estado
Route::put('updateestado/{id}', 'perfilEstudianteController@updateEstado')->name('updateestado');

//rutas para actualizar datos del estudiante
Route::put('updatedatosgenerales/{id}', 'perfilEstudianteController@updatePerfilEstudiante')->name('updatedatosgenerales');
Route::put('updatedatossocioeconomicos/{id}', 'perfilEstudianteController@updateDatosSocioeconomicos')->name('updatedatossocioeconomicos');
Route::put('updatedatosacademicosprevios/{id}', 'perfilEstudianteController@updateDatosAcademicos')->name('updatedatosacademicosprevios');

//rutas para seguimiento
Route::post('crearseguimiento', 'perfilEstudianteController@store_seguimiento')->name('crearseguimiento');
Route::get('editarseguimiento/{id}', 'perfilEstudianteController@edit_seguimiento')->name('editarseguimiento');
Route::put('updateseguimientosocioeducativo/{id}', 'perfilEstudianteController@update_seguimiento')->name('updateseguimientosocioeducativo');
Route::delete('deleteseguimiento/{id}', 'perfilEstudianteController@delete_seguimiento')->name('deleteseguimiento');

//Rutas para update cohorte-grupo
Route::get('grupos/{id}', 'perfilEstudianteController@grupos')->name('grupos');
Route::get('datos/{id}', 'perfilEstudianteController@datosNuevos')->name('datos');
Route::put('updatecohortegrupo/{id}', 'perfilEstudianteController@updateCohorteGrupo')->name('updatecohortegrupo');

//Rutas para cargar datos por ajax al index
Route::get('datos', 'perfilEstudianteController@mostrar')->name('datos.estudiantes');
Route::get('info', 'perfilEstudianteController@enviar')->name('info');



//Rutas CRUD usuarios
Route::get('usuario', 'UsuarioController@index')->name('usuario');
Route::get('crear_usuario', 'UsuarioController@crear')->name('crear_usuario');
Route::post('store_usuario', 'UsuarioController@store')->name('store_usuario');
Route::get('ver_usuario/{id}', 'UsuarioController@show')->name('ver_usuario');
Route::get('editar_usuario/{id}', 'UsuarioController@editar')->name('editar_usuario');
Route::put('update_usuario/{id}', 'UsuarioController@update')->name('update_usuario');
Route::delete('eliminar_usuario/{id}', 'UsuarioController@delete')->name('eliminar_usuario');

//Exportar pdf sabana
Route::get('sabana_export', 'perfilEstudianteController@export')->name('sabana_export');

//Rutas filtros
//Route::get('linea1', 'perfilEstudianteController@primerfiltro')->name('linea1.estudiantes');

//Formalizacion

//index formalizacion
Route::get('formalizacion', 'FormalizacionController@index')->name('formalizacion');
//datos formalizacion por ajax
Route::get('datos_formalizacion', 'FormalizacionController@formalizacionDatos')->name('datos.formalizacion');

//actualizar formalizacion
Route::put('updateformalizacion/{id}', 'perfilEstudianteController@formalizacionupdate')->name('updateformalizacion');



// borrar caché de la aplicación
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return redirect('estudiante')->with('status','limpieza');
});

 // borrar caché de ruta
 Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return redirect('estudiante')->with('status','limpieza');
});

// borrar caché de configuración
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return redirect('estudiante')->with('status','limpieza');
}); 

// borrar caché de vista
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return redirect('estudiante')->with('status','limpieza');
});
// Crear enlace simbolico
Route::get('/storage', function () {
    Artisan::call('storage:link');
    return redirect('estudiante')->with('status','Enlace Creado');
});
//Socioeducativo
Route::get('socio_educativo', 'SocioEducativoController@index')->name('socioeducativo');

Route::put('updateDato/{id}', 'SocioEducativoController@updateAssigment')->name('updateDato');
Route::get('datosAsignacion', 'SocioEducativoController@DataJson')->name('data.asignacion');

//RUTA INDEXESTADO ESTUDIANTES

Route::get('estudiantes/estado', 'perfilEstudianteController@index_Estados')->name('estudiantes.estado');
Route::get('estudiante/estado/edit/{id}', 'perfilEstudianteController@edit_Estado')->name('estudiantes.estado_edit');





