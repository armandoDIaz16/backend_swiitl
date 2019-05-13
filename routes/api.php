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
   // Route::post('permisos', 'Sistema_permisos@getPermisos');

    Route::group(['middleware' => ['jwt.auth']], function() {
        Route::get('logout', 'AuthController@logout');
        Route::post('Periodo','PeriodoController@store');
        Route::post('PAAE_Periodo','PAAE_Periodo@store');

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
Route::get('PAAE_Periodo','PAAE_Periodo@index');
Route::get('Hora','PAAE_Periodo@horario');
Route::get('Materia','PAAE_Periodo@materia');
Route::resource('Encuestas', 'EncuestaController');
Route::resource('Seccion_Encuesta', 'Seccion_EncuestaController');
Route::resource('Tipo_Pregunta', 'Tipo_PreguntaController');
Route::resource('PAAE_Periodo','PAAE_Periodo');
Route::resource('Anteproyecto', 'AnteproyectoResidenciasController');
Route::resource('Documentacion', 'DocumentacionResidenciasController');
Route::resource('Reporte','ReporteResidenciaController');
Route::resource('proyecto','ProyectoController');
Route::resource('Docente','DocenteController');
Route::resource('Comentario','ComentariosController');
Route::resource('Repdocente','ReporteDocenteController');
Route::resource('Alumnor','AlumnoController');
Route::resource('PeriodoR','PeriodoResidenciaController');
Route::resource('Convenio','ConveniosController');
Route::resource('Informe','InformeTecnicoController');
Route::resource('CalificacionR','CalificacionAlumnoController');
Route::resource('ExternoR','ExternoController');
Route::resource('Repexterno','ReporteExternoController');
Route::resource('Estadisticas','EstadisticasController');
Route::post('documentacion', 'DocumentacionResidenciasController@updatesolicitud');
Route::post('documentacion2', 'DocumentacionResidenciasController@updateaceptacion');
Route::post('anteproyecto2', 'AnteproyectoResidenciasController@proyecto');
Route::post('Totalr','EstadisticasController@reportestotal');
route::get('Periodo','PeriodoController@index');
route::get('Proyecto/{id}','AnteproyectoResidenciasController@alumno');
Route::get('Pdf/{id}','FichaUnicaController@FUApdf');
Route::get('Proyecto1/{id}','AnteproyectoResidenciasController@ind1');
Route::get('Proyecto2/{id}','AnteproyectoResidenciasController@ind2');
Route::get('Totalp','EstadisticasController@totalproyectos');
//Route::resource('Periodo','PeriodoController');
Route::resource('Campus','CampusController');
Route::resource('TipoEspacio','TipoEspacioController');
Route::resource('Espacio','EspacioController');
Route::resource('TipoInstituto','TipoInstitutoController');
Route::resource('Edificio','EdificioController');
Route::resource('Tecnologico','TecnmController');

route::get     ('Periodo','PeriodoController@index');
//Route::resource('Periodo','PeriodoController');

//route::get     ('pdf/{orientation}','PdfController@pdf');
route::get     ('pdf','PdfController@pdf');

Route::resource('Pregunta', 'PreguntaController');
