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
    Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    //Route::post('sendAspirantePasswordLink','AspirantePasswordController@sendEmail');
    Route::post('resetPassword', 'ChangePasswordController@process');
    Route::post('control', 'NumeroControl@getControl');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('logout', 'AuthController@logout');
        Route::post('Periodo', 'PeriodoController@store');


        Route::resource('Salon', 'SalonController');
        Route::resource('Turno', 'TurnoController');
        route::get('Referencia/{preficha}', 'AspiranteController@referencia');
        route::get('Aspirantes/{PK_PERIODO}', 'AspiranteController@aspirantes');
        route::get('Aspirantes2', 'AspiranteController@aspirantes2');
        route::get('Aspirantes3/{PK_PERIODO}', 'AspiranteController@aspirantes3');
        route::get('EstatusAspirante/', 'AspiranteController@estatusAspirante');
        route::get('GraficaEstatus/{PK_PERIODO}', 'AspiranteController@graficaEstatus');
        route::get('GraficaCarreras/{PK_PERIODO}', 'AspiranteController@graficaCarreras');
        route::get('GraficaCampus/{PK_PERIODO}', 'AspiranteController@graficaCampus');
        route::post('CargarArchivoBanco/{PK_PERIODO}', 'AspiranteController@cargarArchivoBanco');
        route::post('CargarArchivoPreRegistroCENEVAL/{PK_PERIODO}', 'AspiranteController@cargarArchivoPreRegistroCENEVAL');
        route::post('CargarArchivoRegistroCENEVAL/{PK_PERIODO}', 'AspiranteController@cargarArchivoRegistroCENEVAL');
        route::post('Aspirante2', 'AspiranteController@modificarAspirante');
        route::get('Ficha/{preficha}', 'FichaController@descargarFicha');
        Route::get('Grupo', 'GrupoController@listaGrupos');
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
Route::resource('CreditosSiia', 'CreditosSiiaController');
Route::resource('Entidad_Federativa', 'Entidad_FederativaController');
Route::resource('Ciudad', 'CiudadController');
Route::resource('Usuario_Rol', 'Usuario_RolController');
Route::resource('PAAE_Periodo', 'PAAE_Periodo');
route::resource('Bachillerato', 'BachilleratoController');
route::resource('Colonia', 'ColoniaController');
route::get('Periodo', 'PeriodoController@index');





/* Route::get('Ficha/{preficha}',function(){
    $pdf = PDF::loadView('ficha');
        return $pdf->download('archivo.pdf');
}); */


//Route::resource('Periodo','PeriodoController');
