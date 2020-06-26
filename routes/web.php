<?php

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

use App\Http\Middleware\ApiAuthMiddleware;
//RUTAS PARA USER
Route::get('/user','UserController@index');
Route::get('/user/{id}','UserController@show');
Route::post('/user','UserController@register');
Route::post('/user/login','UserController@login');
Route::put('/user/update','UserController@update');
Route::post('/user/upload','UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/user/image/{filename}','UserController@getImage');
Route::put('/userDisable/{id}','UserController@disable');
Route::put('/userHabilitar/{id}','UserController@habilitar');
Route::put('/userRole/{id}','UserController@role');
Route::put('/userRoleU/{id}','UserController@roleU');
Route::delete('/user/{id}','UserController@destroy');

//rutas estudiante
Route::get('/estudiantes','EstudianteController@index');
Route::get('/estudiantesi','EstudianteController@index2');
Route::get('/estudiante/{id}','EstudianteController@show');
Route::post('/estudiante','EstudianteController@store');
Route::put('/estudiante/{id}','EstudianteController@update');
Route::post('/estudiante/upload','EstudianteController@upload');
Route::get('/estudiante/image/{filename}','EstudianteController@getImage');
Route::get('/estudiante/apoderado/{id}','EstudianteController@apoderadosporestudiante');
Route::get('/estudiante/diagnostico/{id}','EstudianteController@diagnosticosporestudiante');
Route::get('/estudiante/ultimodiagnostico/{id}','EstudianteController@ultimodiagnostico');
Route::get('/estudiante/ficha/{id}','EstudianteController@fichasporestudiante');
Route::get('/estudiante/documento/{id}','EstudianteController@documentosporestudiante');
Route::get('/estudiante/historial/{id}','EstudianteController@historialporestudiante');
Route::get('/estudiante/entrevista/{id}','EstudianteController@entrevistasporestudiante');
Route::get('/estudiante/doc/{id}','EstudianteController@doc');
Route::delete('/estudiante/{id}','EstudianteController@destroy');
Route::put('/estudianteDisable/{id}','EstudianteController@disable');


//rutas apoderado
Route::get('/apoderados','ApoderadoController@index');
Route::get('/apoderadosi','ApoderadoController@index2');
Route::get('/apoderado/{id}','ApoderadoController@show');
Route::post('/apoderado','ApoderadoController@store');
Route::put('/apoderado/{id}','ApoderadoController@update');
Route::put('/apoderadoDisable/{id}','ApoderadoController@disable');

//rutas estudianteapoderado
Route::get('/estudiantesapoderados','EstudianteApoderadoController@index');
Route::get('/estudianteapoderado/{id}','EstudianteApoderadoController@show');
Route::post('/estudianteapoderado','EstudianteApoderadoController@store');
Route::put('/estudianteapoderado/{id}','EstudianteApoderadoController@update');
Route::delete('/estudianteapoderado/{id}','EstudianteApoderadoController@destroy');

//rutas fichas
Route::get('/fichas','FichaSaludController@index');
Route::get('/fichasi','FichaSaludController@index2');
Route::get('/ficha/{id}','FichaSaludController@show');
Route::post('/ficha','FichaSaludController@store');
Route::put('/ficha/{id}','FichaSaludController@update');
Route::delete('/ficha/{id}','FichaSaludController@destroy');
Route::put('/fichaDisable/{id}','FichaSaludController@disable');

//rutas entrevistas
Route::get('/entrevistas','EntrevistaController@index');
Route::get('/entrevistasi','EntrevistaController@index2');
Route::get('/entrevista/{id}','EntrevistaController@show');
Route::post('/entrevista','EntrevistaController@store');
Route::put('/entrevista/{id}','EntrevistaController@update');
Route::delete('/entrevista/{id}','EntrevistaController@destroy');
Route::get('/entrevista/estudiante','EntrevistaController@estudiantesporentrevista');
Route::put('/entrevistaDisable/{id}','EntrevistaController@disable');

//rutas diagnosticos
Route::get('/diagnosticos','DiagnosticoController@index');
Route::get('/diagnosticosi','DiagnosticoController@index2');
Route::get('/diagnostico/{id}','DiagnosticoController@show');
Route::post('/diagnostico','DiagnosticoController@store');
Route::put('/diagnostico/{id}','DiagnosticoController@update');
Route::delete('/diagnostico/{id}','DiagnosticoController@destroy');
Route::put('/diagnosticoDisable/{id}','DiagnosticoController@disable');

//rutas documentos
Route::get('/documentos','DocumentoController@index');
Route::get('/documentosi','DocumentoController@index2');
Route::get('/documento/{id}','DocumentoController@show');
Route::post('/documento','DocumentoController@store');
Route::put('/documento/{id}','DocumentoController@update');
Route::delete('/documento/{id}','DocumentoController@destroy');
Route::put('/documentoDisable/{id}','DocumentoController@disable');

//rutas HistorialAcademico
Route::get('/historiales','HistorialAcademicoController@index');
Route::get('/historialesi','HistorialAcademicoController@index2');
Route::get('/historial/{id}','HistorialAcademicoController@show');
Route::post('/historial','HistorialAcademicoController@store');
Route::put('/historial/{id}','HistorialAcademicoController@update');
Route::delete('/historial/{id}','HistorialAcademicoController@destroy');
Route::put('/historialDisable/{id}','HistorialAcademicoController@disable');
Route::get('/ingresos','HistorialAcademicoController@ingresos');


Route::get('/', function () {
    return view('welcome');
});
Route::get('/hola', function () {
    return "<h1>bienvenido</h1>";
});
//Rutas del controlador de usuario
//Route::get('/api/estudiante','EstudianteController@index');
//Route::post('/api/login','UserController@login');
//Route::put('/api/user/update','UserController@update');
//Route::post('/api/user/upload','UserController@upload')->middleware(ApiAuthMiddleware::class);
//Route::get('/api/user/avatar/{filename}','UserController@getImage');   //retorna la imagen que se entrega por url
