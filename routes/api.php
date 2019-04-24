<?php

use Illuminate\Http\Request;

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('sendPasswordResetLink','ResetPasswordController@sendEmail');
    Route::post('resetPassword', 'ChangePasswordController@process');
    Route::post('control', 'NumeroControl@getControl');

    Route::group(['middleware' => ['jwt.auth']], function() {
        Route::get('logout', 'AuthController@logout');
        Route::post('Periodo','PeriodoController@store');
        //Route::post('control', 'NumeroControl@getControl');

    });
    //Route::post('periodo', 'PAAE_Periodo@getPeriodo');

});

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('Aspirante', 'AspiranteController');
Route::resource('Universidad', 'UniversidadController');
Route::resource('Carrera_Universidad', 'Carrera_UniversidadController');
Route::resource('Carrera', 'CarreraController');
Route::resource('Dependencia', 'DependenciaController');
Route::resource('Estado_Civil', 'Estado_CivilController');
Route::resource('Incapacidad', 'IncapacidadController');
Route::resource('Propaganda_Tecnologico', 'PropagandaController');
Route::resource('CreditosSiia','CreditosSiiaController');
Route::resource('Entidad_Federativa','Entidad_FederativaController');
Route::resource('ColoniaCodigoPostal','ColoniaCodigoPostalController');
Route::resource('Ciudad','CiudadController');
Route::resource('Colonia','ColoniaController');
Route::resource('CodigoPostal','CodigoPostalController');
Route::resource('Usuario_Rol','Usuario_RolController');
Route::resource('PAAE_Periodo','PAAE_Periodo');
<<<<<<< HEAD
Route::resource('Anteproyecto', 'AnteproyectoResidenciasController');
Route::resource('Documentacion', 'DocumentacionResidenciasController');
Route::resource('Reporte','ReporteResidenciaController');
Route::resource('proyecto','ProyectoController');
Route::post('documentacion', 'DocumentacionResidenciasController@updatesolicitud');
Route::post('documentacion2', 'DocumentacionResidenciasController@updateaceptacion');
Route::post('anteproyecto2', 'AnteproyectoResidenciasController@proyecto');
route::get('Periodo','PeriodoController@index');
route::get('Proyecto/{id}','AnteproyectoResidenciasController@alumno');
//Route::resource('Periodo','PeriodoController');
=======
Route::resource('Campus','CampusController');
Route::resource('TipoEspacio','TipoEspacioController');
Route::resource('Espacio','EspacioController');
Route::resource('TipoInstituto','TipoInstitutoController');
Route::resource('Edificio','EdificioController');
Route::resource('Tecnologico','TecnmController');
route::get     ('Periodo','PeriodoController@index');
//Route::resource('Periodo','PeriodoController');
>>>>>>> b3f06193eb9932c55c6bf925440e240a1a65decd
