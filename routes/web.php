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
Route::get('comuna_barrios/{id}', 'perfilEstudianteController@barrios')->name('comuna_barrios');
Route::get('cohorte_grupo/{id}', 'perfilEstudianteController@gruposCreate')->name('cohorte_grupo');

Route::get('estudiante', 'perfilEstudianteController@indexPerfilEstudiante')->name('estudiante');
Route::get('crear_estudiante', 'perfilEstudianteController@crearPerfilEstudiante')->name('crear_estudiante');
Route::post('create_student', 'perfilEstudianteController@storePerfilEstudiante')->name('create_student');
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


Route::get('asistencias/estudiantes', 'perfilEstudianteController@indexEstudiantes')->name('asistencias.estudiantes');
Route::get('asistencias/estudiantes', 'perfilEstudianteController@indexEstudiantes')->name('asistencias.estudiantes');
Route::get('asistencias_linea_1', 'perfilEstudianteController@asistencias_linea_1')->name('asistencias_linea_1');
Route::get('asistencias_linea_2', 'perfilEstudianteController@asistencias_linea_2')->name('asistencias_linea_2');
Route::get('asistencias_linea_3', 'perfilEstudianteController@asistencias_linea_3')->name('asistencias_linea_3');
//Route::get('asistencias/estudiante/{id}', 'perfilEstudianteController@ver_Asistencias')->name('ver_asistencias');
Route::get('asistencias/reporte_general', 'perfilEstudianteController@excel_asistencias')->name('crear_excel_json');

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
Route::post('updatecohortegrupo/{id}', 'perfilEstudianteController@updateCohorteGrupo')->name('updatecohortegrupo');

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

//Exportar excel sabana
Route::get('sabana_export', 'perfilEstudianteController@export')->name('sabana_export');
Route::get('sabana_completa_export', 'perfilEstudianteController@exportar_completa')->name('sabana_completa_export');
//Rutas filtros
//Route::get('linea1', 'perfilEstudianteController@primerfiltro')->name('linea1.estudiantes');

//Formalizacion

//index formalizacion
Route::get('formalizacion', 'FormalizacionController@index')->name('formalizacion');
//datos formalizacion por ajax
Route::get('datos.formalizacion', 'FormalizacionController@formalizacionDatos')->name('datos.formalizacion');

//Actualiar formalizacion
Route::put('updateformalizacion/{id}', 'FormalizacionController@formalizacionupdate')->name('updateformalizacion');


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

Route::post('verDatosExcel', 'SocioEducativoController@verificarInfo')->name('ejm');

//graphics
Route::get('graficas', 'GraphicsController@index')->name('graficas');
Route::get('sex/{tipo}/linea/{cohorte}', 'GraphicsController@sexoPorCohorte')->name('sexoCohorte');
Route::get('edad/{edad}/linea/{cohorte}', 'GraphicsController@edadPorCohorte')->name('edadCohorte');
Route::get('anio/{anio}/linea/{cohorte}', 'GraphicsController@anioGraduacion')->name('icfesPuntajeCohorte');
Route::get('puntaje/{icfesI}/{icfesF}/linea/{cohorte}', 'GraphicsController@puntajeIcfes')->name('icfesPuntajeCohorte');
Route::get('estado/{estado}/linea/{cohorte}', 'GraphicsController@civilEstado')->name('civilEstadoCohorte');
Route::get('etnia/{etnia}/linea/{cohorte}', 'GraphicsController@etniaPorLinea')->name('etniaCohorte');
Route::get('ocupacion/{ocup}/linea/{cohorte}', 'GraphicsController@ocupacionLinea')->name('ocupacionCohorte');
Route::get('hijos/{hijos}/linea/{cohorte}', 'GraphicsController@numeroDeHijos')->name('numeroDeHijosCohorte');
Route::get('regimen/{regimen}/linea/{cohorte}', 'GraphicsController@regimenSalud')->name('regimenSaludCohorte');
Route::get('sisben/{sisben}/linea/{cohorte}', 'GraphicsController@categoriaDeSisben')->name('categoriaSisbenCohorte');
Route::get('beneficios/{beneficios}/linea/{cohorte}', 'GraphicsController@beneficios')->name('beneficiosCohorte');
Route::get('internetZona/{zona}/linea/{cohorte}', 'GraphicsController@internetZona')->name('internetZonaCohorte');
Route::get('internetHome/{home}/linea/{cohorte}', 'GraphicsController@internetHome')->name('internetHomeCohorte');
Route::get('condicion/{condicion}/linea/{cohorte}', 'GraphicsController@socialCondicion')->name('condicionSocialCohorte');
Route::get('discapacidad/{discapacidad}/linea/{cohorte}', 'GraphicsController@discapacidad')->name('discapacidadCohorte');

//RUTA INDEXESTADO ESTUDIANTES
Route::get('estudiantes/estado', 'perfilEstudianteController@index_Estados')->name('estudiantes.estado');
Route::get('estudiante/estado/edit/{id}', 'perfilEstudianteController@edit_Estado')->name('estudiantes.estado_edit');
Route::get('get_Estados', 'perfilEstudianteController@get_Estados')->name('estudiantes.get_Estados');

//Rutas almuerzos
Route::get('almuerzos_estudiantes', 'AlmuerzosController@index')->name('almuerzos_estudiantes');
Route::post('almacenar_registro_almuerzos', 'AlmuerzosController@store')->name('almacenar_registro_almuerzos');
Route::get('datos.almuerzos', 'AlmuerzosController@datos_almuerzos')->name('datos.almuerzos');
Route::get('editar_registro_almuerzo/{id}', 'AlmuerzosController@editar')->name('editar_registro_almuerzo');
Route::put('actualizar_registro_almuerzos/{id}', 'AlmuerzosController@actualizar')->name('actualizar_registro_almuerzos');
Route::delete('eliminar_registro_almuerzo/{id}', 'AlmuerzosController@delete')->name('eliminar_registro_almuerzo');

//rutas sesiones
Route::get('sesiones', 'SesionesController@index')->name('sesiones');
//traer grupos
Route::get('grupos_to_sesion/{id}', 'SesionesController@traerGrupos')->name('grupos_to_sesion');
//traer asignaturas
Route::get('asignatura_to_sesion/{id}', 'SesionesController@traerAsignaturas')->name('asignatura_to_sesion');
Route::post('almacenar_registro_sesion', 'SesionesController@store')->name('almacenar_registro_sesion');
Route::get('datos.sessiones', 'SesionesController@datos')->name('datos.sessiones');
Route::get('editar_registro_sesion/{id}', 'SesionesController@edit')->name('editar_registro_sesion');
Route::put('actualizar_registro_sesion/{id}', 'SesionesController@update')->name('actualizar_registro_sesion');
Route::delete('eliminar_registro_sesion/{id}', 'SesionesController@delete')->name('eliminar_registro_sesion');

//PDFS grupos
Route::get('listado_estudiantes_grupo/{cohorte}', 'PdfsReportesController@descargarPDFgrupos')->name('listado.estudiante.grupo');


//RUTAS CONTROLADOR ASISTENCIAS

Route::get('ver_asistencias/{id_moodle}/{id_grupo}', 'AsistenciasController@ver_asistencias')->name('estudiante.ver_asistencias');
Route::post('cargar_asistencias', 'AsistenciasController@cargar_asistencias')->name('estudiante.cargar_asistencias');



