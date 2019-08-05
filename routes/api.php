<?php

use Illuminate\Http\Request;

// BUSCAR Y VALIDAR NÚMERO DE CONTROL EN OBTENCIÓN DE CONTRASEÑA
Route::post('control', 'NumeroControl@getControl');

// REGISTRO EN SISTEMA
// Route::post('signup', 'AuthController@signup');
Route::post('signup', 'AuthController@registra_usuario');

// OBTENCIÓN DE DATOS PARA ACTIVACIÓN DE CUENTA
Route::post('get_datos_activacion', 'AuthController@get_datos_activacion');

// ACTIVACIÓN DE CUENTA
Route::post('activar_cuenta', 'AuthController@activa_cuenta');

// INICIO DE SESIÓN
Route::post('login', 'AuthController@login');

// TERMINAR SESIÓN
Route::post('logout', 'AuthController@logout');

Route::post('refresh', 'AuthController@refresh');

Route::post('me', 'AuthController@me');

// ENVIAR URL PARA REESTABLECER CONTRASEÑA
Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');

// CAMBIO DE CONTRASEÑA
Route::post('resetPassword', 'ChangePasswordController@process');


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('GraficaCampus5/{PK_PERIODO}', 'AspiranteController@graficaCampus');
});

Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});

/* Route::group([

    'middleware' => 'api',

], function ($Router) {

}); */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API Routes for your application. These
| Routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('Usuario_Rol', 'Usuario_RolController');
Route::get('PAAE_Periodo', 'PAAE_Periodo@index');
Route::get('Hora', 'PAAE_Periodo@horario');
Route::get('HoraAll', 'PAAE_Periodo@horarioAll');
Route::get('Materia', 'PAAE_Periodo@materia');
Route::get('Datos', 'PAAE_Periodo@getDatos');
Route::get('Promedio', 'PAAE_Periodo@promedio');
Route::get('MateriAsesor', 'PAAE_Periodo@materiAsesor');
Route::get('Asesor', 'PAAE_Periodo@getAsesor');
Route::get('AsesorPeriodo', 'PAAE_Periodo@getAsesorPeriodo');
Route::get('Solicitudes', 'PAAE_Periodo@getSolicitud');
Route::get('SolicitudesPeriodo', 'PAAE_Periodo@getSolicitudPeriodo');
Route::get('Seguimiento', 'PAAE_Periodo@seguimiento');
Route::get('AllMaterias', 'PAAE_Periodo@allMaterias');
Route::get('ClaveGrupo', 'PAAE_Periodo@claveGrupo');
Route::get('ClaveHorario', 'PAAE_Periodo@claveHorario');
Route::get('Asesoria', 'PAAE_Periodo@getAsesoria');
Route::get('AsesoriaPeriodo', 'PAAE_Periodo@getAsesoriaPeriodo');
Route::get('AsesoriaGrupo', 'PAAE_Periodo@getAsesoriaGrupo');
Route::get('AsesoriaGrupoPeriodo', 'PAAE_Periodo@getAsesoriaGrupoPeriodo');
Route::get('AsesoriaId', 'PAAE_Periodo@getAsesoriaId');
Route::get('Docentes', 'PAAE_Periodo@allDocente');
Route::get('NameAses', 'PAAE_Periodo@nombreAsesor');
Route::get('AsesorSesion', 'PAAE_Periodo@allAsesor');
Route::post('SolicitudAsesoria', 'PAAE_Periodo@crearSolicitud');
Route::post('SolicitudAsesor', 'PAAE_Periodo@crearSolicitudAsesor');
Route::post('ActualizAsesor', 'PAAE_Periodo@actualizAsesor');
Route::post('ActualizaSolicitud', 'PAAE_Periodo@actualizaSolicitud');
Route::post('BorrAsesor', 'PAAE_Periodo@borrAsesor');
Route::post('BorraSolicitud', 'PAAE_Periodo@borraSolicitud');
Route::resource('Encuestas', 'EncuestaController');
Route::resource('Seccion_Encuesta', 'Seccion_EncuestaController');
Route::resource('Tipo_Pregunta', 'Tipo_PreguntaController');
Route::resource('PAAE_Periodo', 'PAAE_Periodo');
Route::resource('Entidad_Federativa', 'Entidad_FederativaController');
Route::resource('Ciudad', 'CiudadController');
Route::resource('PAAE_Periodo', 'PAAE_Periodo');
route::resource('Bachillerato', 'BachilleratoController');
route::resource('Colonia', 'ColoniaController');
route::get('Periodo', 'PeriodoController@index');


/* *****************************************************************************
************** RUTAS DEL SISTEMA DE RESIDENCIAS PROFESIONALES ******************
***************************************************************************** */

Route::resource('Convenio', 'ConveniosController');
Route::resource('Informe', 'InformeTecnicoController');
Route::resource('CalificacionR', 'CalificacionAlumnoController');
Route::resource('ExternoR', 'ExternoController');
Route::resource('Repexterno', 'ReporteExternoController');
Route::post('documentacion', 'DocumentacionResidenciasController@updatesolicitud');
Route::post('documentacion2', 'DocumentacionResidenciasController@updateaceptacion');
Route::post('anteproyecto2', 'AnteproyectoResidenciasController@proyecto');
route::get('Periodo', 'PeriodoController@index');
route::get('Proyecto/{id}', 'AnteproyectoResidenciasController@alumno');
Route::get('Pdf/{id}', 'FichaUnicaController@FUApdf');
Route::get('Proyecto1/{id}', 'AnteproyectoResidenciasController@ind1');
Route::get('Proyecto2/{id}', 'AnteproyectoResidenciasController@ind2');
//Route::resource('Periodo','PeriodoController');
Route::resource('Pregunta', 'PreguntaController');

Route::resource('Usuario', 'UsuarioController');
Route::resource('Aplicacion_Encuesta', 'Aplicacion_EncuestaController');

Route::resource('Campus', 'CampusController');
Route::resource('TipoEspacio', 'TipoEspacioController');
Route::resource('Espacio', 'EspacioController');
Route::resource('TipoInstituto', 'TipoInstitutoController');
Route::resource('Edificio', 'EdificioController');
Route::resource('Tecnologico', 'TecnmController');

Route::resource('Respuesta_Posible', 'Respuesta_PosibleController');
route::get('Periodo', 'PeriodoController@index');

//Route::group(['middleware' => ['jwt.auth']], function() {
Route::resource('Anteproyecto', 'AnteproyectoResidenciasController');
Route::resource('Documentacion', 'DocumentacionResidenciasController');
Route::resource('Reporte', 'ReporteResidenciaController');
Route::resource('proyecto', 'ProyectoController');
Route::resource('Docente', 'DocenteController');
Route::resource('Comentario', 'ComentariosController');
Route::resource('Repdocente', 'ReporteDocenteController');
Route::resource('Alumnor', 'AlumnoController');
Route::resource('PeriodoR', 'PeriodoResidenciaController');
Route::resource('Informe', 'InformeTecnicoController');
Route::resource('CalificacionR', 'CalificacionAlumnoController');
Route::resource('ExternoR', 'ExternoController');
Route::resource('Repexterno', 'ReporteExternoController');
Route::resource('Estadisticas', 'EstadisticasController');
Route::resource('CartaFinalR', 'CartaFinalizacionController');
Route::resource('BajaAlumnoR', 'BajaAlumnoController');
Route::resource('ConvenioContrato', 'ConvenioContratoController');
Route::resource('ActaResidencias', 'ActaResidenciasController');
Route::resource('ConfiguracionE', 'ConfiguracionEscolaresController');
Route::resource('InfoActaR', 'InformacionActaCalificacionController');
Route::resource('BaseResidencias', 'BaseResidenciasController');
Route::post('documentacion', 'DocumentacionResidenciasController@updatesolicitud');
Route::post('documentacion2', 'DocumentacionResidenciasController@updateaceptacion');
Route::post('anteproyecto2', 'AnteproyectoResidenciasController@proyecto');
Route::post('Totalr', 'EstadisticasController@reportestotal');
Route::get('ProyectoAlumno/{id}', 'ProyectoController@alumnos');
route::get('Periodo', 'PeriodoController@index');
route::get('Proyecto/{id}', 'AnteproyectoResidenciasController@alumno');
Route::get('Pdf/{id}', 'FichaUnicaController@FUApdf');
Route::get('Proyecto1/{id}', 'AnteproyectoResidenciasController@ind1');
Route::get('Proyecto2/{id}', 'AnteproyectoResidenciasController@ind2');
Route::get('Totalp', 'EstadisticasController@totalproyectos');
Route::resource('CreditosSiia', 'CreditosSiiaController');
//});
/*************************************************************************************
 * **********************************************************************************/


Route::resource('Entidad_Federativa', 'Entidad_FederativaController');
Route::resource('Ciudad', 'CiudadController');
Route::resource('PAAE_Periodo', 'PAAE_Periodo');


route::get('GraficaAsesorados', 'GraficasAsesoriaController@graficaAsesorados');
route::get('GraficaNoAsesorados', 'GraficasAsesoriaController@graficaNoAsesorados');
route::get('GraficaMaterias', 'GraficasAsesoriaController@graficaMaterias');


/* Route::get('Ficha/{preficha}',function(){
    $pdf = PDF::loadView('ficha');
        return $pdf->download('archivo.pdf');
}); */


//Route::resource('Periodo','PeriodoController');
Route::resource('Campus', 'CampusController');
Route::resource('TipoEspacio', 'TipoEspacioController');
Route::resource('Espacio', 'EspacioController');
Route::resource('TipoInstituto', 'TipoInstitutoController');
Route::resource('Edificio', 'EdificioController');
Route::resource('Tecnologico', 'TecnmController');

//Route::resource('Periodo','PeriodoController');
//Route::get     ('pdf/{orientation}','PdfController@pdf');
Route::get('pdf', 'PdfController@pdf');


Route::resource('Pregunta', 'PreguntaController');

Route::get('pdf1', function () {
    $pdf = PDF::loadView('vista');
    return $pdf->download('archivo.pdf');
});

/**********************************RUTAS SISTEMA CREDITOS COMPLEMENTARIOS ************************************************/
Route::resource('lineamientos', 'LineamientoController');
Route::resource('tipos', 'TipoController');
Route::resource('actividades', 'ActividadController');
Route::get('actividad-por-id/{PK_ACTIVIDAD}', 'ActividadController@getActividadById');
Route::get('actividades-raw', 'ActividadController@getActRaw');
Route::resource('alumno-actividades', 'AlumnoActividadController');
Route::resource('asistencia-alumnos', 'AsistenciaAlumnoActividadController');
Route::get('asistencia-alumnos-salida/{FK_ALUMNO_ACTIVIDAD}', 'AsistenciaAlumnoActividadController@regSalida');
Route::resource('alumno-creditos', 'AlumnoCreditoController');
Route::get('creditos-por-validar', 'AlumnoCreditoController@getCreditosPorValidar');
Route::get('creditos-por-validar-nc/{NUMERO_CONTROL}', 'AlumnoCreditoController@getCreditosPorValidarByNumC');
Route::get('creditos-validados-nc/{NUMERO_CONTROL}', 'AlumnoCreditoController@getCreditosValidadosByNumC');
Route::get('creditos-por-validar-ln/{LINEAMIENTO}', 'AlumnoCreditoController@getCreditosPorValidarByLin');
Route::get('creditos-validados-ln/{LINEAMIENTO}', 'AlumnoCreditoController@getCreditosValidadosByLin');
Route::put('validar-credito/{PK_ALUMNO_CREDITO}', 'AlumnoCreditoController@validarCreditos');
Route::get('creditos-validados', 'AlumnoCreditoController@getCreditosValidados');
Route::get('actividades-disponibles/{id_alumno}', 'ActividadController@actividadesDisponibles');
Route::get('lista-actividades/{FK_LINEAMIENTO}/{FK_ALUMNO}', 'AsistenciaAlumnoActividadController@actividadesList');
Route::resource('responsables-actividad', 'ResponsableActividadController');
Route::get('responsable-lista-asistentes/{pk_actividad}', 'ResponsableActividadController@getListaAsistentes');
Route::resource('asistentes-actividad', 'AsistenteActividadController');

Route::post('getAllEncuesta', 'EncuestaController@showEncuestas');

Route::resource('responsables-actividad', 'ResponsableActividadController');
Route::get('responsable-lista-asistentes/{pk_actividad}', 'ResponsableActividadController@getListaAsistentes');
Route::resource('asistentes-actividad', 'AsistenteActividadController');
Route::get('alumnos-num-control/{NUM_CONTROL}', 'AsistenteActividadController@getAlumnoByNc');
Route::get('alumnos-num-control/{PRIMER_APELLIDO}/{SEGUNDO_APELLIDO}/{name}', 'AsistenteActividadController@getPkuserByName');
Route::get('registrar-asistencia', 'AsistenteActividadController@habilitarTomaAsistencia');
Route::get('userid-num-control/{NUM_CONTROL}', 'AsistenteActividadController@getPkuserByNc');
Route::get('registrar-asistencia/{PK_ACTIVIDAD}', 'AsistenteActividadController@habilitarTomaAsistencia');
Route::get('actividades-tomar-asistencia/{PK_USUARIO}', 'AsistenteActividadController@listaActividades');
Route::get('eliminar-asistente-act/{PK_USUARIO}/{PK_ACTIVIDAD}', 'AsistenteActividadController@eliminarAsistente');
Route::get('eliminar-rol-asistente/{PK_USUARIO}', 'AsistenteActividadController@eliminarRolAsistente');
Route::get('lista-actividades-creditos/{FK_ALUMNO_ACTIVIDAD}', 'AsistenciaAlumnoActividadController@pruebaActByLineamiento');
Route::get('actividades-credito-cumplidos/{PK_ALUMNO_CREDITO}', 'CreditoActividadController@getActByCredito');
Route::get('prueba-ver-pdf', 'pruebaVerPdf@verpdf');
Route::get('generar-constancia/{PK_ALUMNO_CREDITO}', 'constanciasCreditosController@generarConstancia');
Route::get('constancia-view-o_o_s_e/{PK_ALUMNO_CREDITO}', 'constanciasCreditosController@verConstanciaOficial');
Route::get('constancia-preview/{PK_ALUMNO_CREDITO}', 'constanciasCreditosController@verConstanciaVistaPrevia');
Route::post('signupAdminCC', 'AuthController@signupAdminCredito');
Route::get('usuario-by-curp/{curp}', 'gestionRolesCreditosComController@getUsuarioByCurp');
Route::get('agregar-user-ca/{PK_USUARIO}', 'gestionRolesCreditosComController@setRolComite');
Route::get('agregar-user-jc/{PK_USUARIO}', 'gestionRolesCreditosComController@setRolJefeCarr');
Route::get('agregar-user-ra/{PK_USUARIO}', 'gestionRolesCreditosComController@setRolRespAct');
Route::get('agregar-user-te/{PK_USUARIO}', 'gestionRolesCreditosComController@setRolTutoescolares');
Route::post('import-excel-ac', 'excelAcController@importarCreditos');
Route::get('generar-excel-ac', 'excelAcController@generarExcel');
Route::get('id-alumno-actividades/{PK_ACTIVIDAD}/{PK_ALUMNO}', 'AlumnoActividadController@ctlAlumnoActividad');
//Route::get('prueba-fecha','constanciasCreditosController@pruebaFormatoFecha');
//Route::get('prueba-carrera/{PK_ALUMNO_CREDITO}','constanciasCreditosController@getCarrera');
/*************************************************************************************************************************/


/* ************************************** RUTAS DEL SISTEMA ASPIRANTES *************************************** */
Route::get('Periodo', 'PeriodoController@index');
Route::post('Aspirante', 'AspiranteController@store');
Route::resource('Universidad', 'UniversidadController');
Route::resource('Carrera_Universidad', 'Carrera_UniversidadController');
Route::resource('Carrera', 'CarreraController');
Route::resource('Dependencia', 'DependenciaController');
Route::resource('Estado_Civil', 'Estado_CivilController');
Route::resource('Incapacidad', 'IncapacidadController');
Route::resource('Propaganda_Tecnologico', 'PropagandaController');
Route::resource('CreditosSiia', 'CreditosSiiaController');
Route::resource('Entidad_Federativa', 'Entidad_FederativaController');
Route::resource('ColoniaCodigoPostal', 'ColoniaCodigoPostalController');
Route::resource('Ciudad', 'CiudadController');
Route::resource('Colonia', 'ColoniaController');
Route::resource('Bachillerato', 'BachilleratoController');
Route::resource('CodigoPostal', 'CodigoPostalController');
Route::get('Ficha/{preficha}', 'FichaController@descargarFicha');
Route::get('Referencia/{preficha}', 'FichaController@descargarReferencia');
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('Aspirante/{id}', 'AspiranteController@show');
    Route::post('Periodo', 'PeriodoController@store');
    Route::get('Aspirantes/{PK_PERIODO}', 'AspiranteController@aspirantes');
    Route::get('Aspirantes2', 'AspiranteController@aspirantes2');
    Route::get('Aspirantes3/{PK_PERIODO}', 'AspiranteController@aspirantes3');
    Route::get('EstatusAspirante/', 'AspiranteController@estatusAspirante');
    Route::get('GraficaEstatus/{PK_PERIODO}', 'AspiranteController@graficaEstatus');
    Route::get('GraficaCarreras/{PK_PERIODO}', 'AspiranteController@graficaCarreras');
    Route::get('GraficaCampus/{PK_PERIODO}', 'AspiranteController@graficaCampus');
    Route::post('CargarArchivoBanco/{PK_PERIODO}', 'AspiranteController@cargarArchivoBanco');
    Route::post('CargarArchivoPreRegistroCENEVAL/{PK_PERIODO}', 'AspiranteController@cargarArchivoPreRegistroCENEVAL');
    Route::post('CargarArchivoRegistroCENEVAL/{PK_PERIODO}', 'AspiranteController@cargarArchivoRegistroCENEVAL');
    Route::post('CargarArchivoAceptados/{PK_PERIODO}', 'AspiranteController@cargarArchivoAceptados');
    Route::post('Aspirante2', 'AspiranteController@modificarAspirante');
    Route::get('Grupo', 'GrupoController@listaGrupos');

    Route::get('Espacio', 'LugarExamenController@obtenerEspacio');
    Route::get('Turno', 'LugarExamenController@obtenerTurno');
    Route::get('Turno2', 'LugarExamenController@obtenerTurno2');
    Route::get('Edificio', 'LugarExamenController@obtenerEdificio');
    Route::get('TipoEspacio', 'LugarExamenController@obtenerTipoEspacio');
    Route::post('AgregarTurno', 'LugarExamenController@agregarTurno');
    Route::post('AgregarEspacio', 'LugarExamenController@agregarEspacio');
    Route::post('AgregarGrupo', 'LugarExamenController@agregarGrupo');

    Route::post('EnviarCorreos', 'AspiranteController@enviarCorreos');
});


///////////////////////////////// PAAE ////////////////////////////////////
Route::get('PAAE_Periodo', 'PAAE_Periodo@index');
Route::get('Hora', 'PAAE_Periodo@horario');
Route::get('HoraAll', 'PAAE_Periodo@horarioAll');
Route::get('Materia', 'PAAE_Periodo@materia');
Route::get('Datos', 'PAAE_Periodo@getDatos');
Route::get('Promedio', 'PAAE_Periodo@promedio');
Route::get('MateriAsesor', 'PAAE_Periodo@materiAsesor');
Route::get('Asesor', 'PAAE_Periodo@getAsesor');
Route::get('AsesorAsigna', 'PAAE_Periodo@getAsesorAsigna');
Route::get('AsesorPeriodo', 'PAAE_Periodo@getAsesorPeriodo');
Route::get('Solicitudes', 'PAAE_Periodo@getSolicitud');
Route::get('SolicitudesAsigna', 'PAAE_Periodo@getSolicitudAsigna');
Route::get('SolicitudesPeriodo', 'PAAE_Periodo@getSolicitudPeriodo');
Route::get('Seguimiento', 'PAAE_Periodo@seguimiento');
Route::get('AllMaterias', 'PAAE_Periodo@allMaterias');
Route::get('ClaveGrupo', 'PAAE_Periodo@claveGrupo');
Route::get('ClaveHorario', 'PAAE_Periodo@claveHorario');
Route::get('Asesoria', 'PAAE_Periodo@getAsesoria');
Route::get('AsesoriaPeriodo', 'PAAE_Periodo@getAsesoriaPeriodo');
Route::get('AsesoriaGrupo', 'PAAE_Periodo@getAsesoriaGrupo');
Route::get('AsesoriaGrupoPeriodo', 'PAAE_Periodo@getAsesoriaGrupoPeriodo');
Route::get('AsesoriaId', 'PAAE_Periodo@getAsesoriaId');
Route::get('Docentes', 'PAAE_Periodo@allDocente');
Route::get('NameAses', 'PAAE_Periodo@nombreAsesor');
Route::get('AsesorSesion', 'PAAE_Periodo@allAsesor');
Route::get('AlumnosAsesoria', 'PAAE_Periodo@getAlumnoAsesorado');
Route::get('AlumnosAsesoriaMateria', 'PAAE_Periodo@getAlumnoAsesoradoMateria');
Route::get('Sesion', 'PAAE_Periodo@getSesion');
Route::get('PdfComplementaria', 'PAEEPDF@complementaria');
Route::get('PdfServicio', 'PAEEPDF@servicio');
Route::get('Reprobados', 'PAAE_Periodo@situacionAcademica');
Route::get('Recursando', 'PAAE_Periodo@recursando');
Route::get('MateriaRepeticion', 'PAAE_Periodo@materiaRepeticion');
Route::get('AsesorAsigna', 'PAAE_Periodo@getAsesorAsigna');
Route::get('SolicitudesAsigna', 'PAAE_Periodo@getSolicitudAsigna');
Route::get('AsesorFinal', 'PAAE_Periodo@AsesorEntregoFinal');
Route::get('AsesorFinalPeriodo', 'PAAE_Periodo@AsesorEntregoFinalPeriodo');
Route::get('TodosMotivos', 'PAAE_Periodo@allMotivos');
Route::get('MotivosPeriodo', 'PAAE_Periodo@allMotivosPeriodo');
Route::get('TodosCompromisoUser', 'PAAE_Periodo@allCompromisoUser');
Route::get('CompromisoUserPeriodo', 'PAAE_Periodo@allCompromisoUserPeriodo');
Route::get('TodosCompromisoAsesor', 'PAAE_Periodo@allCompromisoAsesor');
Route::get('CompromisoAsesorPeriodo', 'PAAE_Periodo@allCompromisoAsesorPeriodo');
Route::get('TodosEvaluacion', 'PAAE_Periodo@allEvaluacion');
Route::get('EvaluacionPeriodo', 'PAAE_Periodo@allEvaluacionPeriodo');
Route::get('TodosCalificacion', 'PAAE_Periodo@allCalificacion');
Route::get('CalificacionPeriodo', 'PAAE_Periodo@allCalificacionPeriodo');
Route::get('TodosSesiones', 'PAAE_Periodo@allReporteSesion');
Route::get('SesionesPeriodo', 'PAAE_Periodo@allReporteSesionPeriodo');
Route::get('TodosAsistencia', 'PAAE_Periodo@allAsistencia');
Route::get('AsistenciaPeriodo', 'PAAE_Periodo@allAsistenciaPeriodo');
Route::get('TodosReporteFinal', 'PAAE_Periodo@allReporteFinal');
Route::get('ReporteFinalPeriodo', 'PAAE_Periodo@allReporteFinalPeriodo');
Route::get('TodosAsignacion', 'PAAE_Periodo@allSituacionAcademica');
Route::get('SituacionPeriodo', 'PAAE_Periodo@allSituacionAcademicaPeriodo');
Route::get('TodosAsesores', 'PAAE_Periodo@AsesoresListal');
Route::get('AsesoresPeriodo', 'PAAE_Periodo@AsesoresListalPeriodo');
Route::get('SesionAsesor', 'PAAE_Periodo@sesionPorAsesor');
Route::get('CorreosAlumnos', 'PAAE_Periodo@correosAlumnos');
Route::get('ListaAlumnos', 'PAAE_Periodo@listaAlumnos');
Route::get('CorreoAsesor', 'PAAE_Periodo@correoAsesor');
Route::post('SolicitudAsesoria', 'PAAE_Periodo@crearSolicitud');
Route::post('SolicitudAsesor', 'PAAE_Periodo@crearSolicitudAsesor');
Route::post('ActualizAsesor', 'PAAE_Periodo@actualizAsesor');
Route::post('ActualizaSolicitud', 'PAAE_Periodo@actualizaSolicitud');
Route::post('BorrAsesor', 'PAAE_Periodo@borrAsesor');
Route::post('BorraSolicitud', 'PAAE_Periodo@borraSolicitud');
Route::post('AsignaIndividual', 'PAAE_Periodo@asignacionIndividual');
Route::post('AsignaGrupal', 'PAAE_Periodo@asignacionGrupal');
Route::post('ActualizaInd', 'PAAE_Periodo@actualizAsigInd');
Route::post('BorraInd', 'PAAE_Periodo@borrInd');
Route::post('ActualizaGrupo', 'PAAE_Periodo@actualizGrupo');
Route::post('BorraGru', 'PAAE_Periodo@borrGru');
Route::post('Motivo', 'PAAE_Periodo@motivo');
Route::post('CompromisoUser', 'PAAE_Periodo@compromisoUser');
Route::post('EvaluacionSatisfaccion', 'PAAE_Periodo@evaluacionSatisfaccion');
Route::post('CompromisoAsesor', 'PAAE_Periodo@compromisoAsesor');
Route::post('CreaSesion', 'PAAE_Periodo@crearSesion');
Route::post('CreaLista', 'PAAE_Periodo@crearAsistencia');
Route::post('CreaFin', 'PAAE_Periodo@creaFinal');
Route::post('AsignaSituacion', 'PAAE_Periodo@asignacionSituacion');
Route::post('EnviarCorreoPAAE', 'PAAE_Periodo@enviarCorreos');
Route::post('CreaCalificacion', 'PAAE_Periodo@creaCalificacion');

/* *********************************************************** *
 * ************* RUTAS DEL SISTEMA DE TUTORIAS *************** *
 * *********************************************************** */
// Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('cuestionario/{id}', 'SITCuestionarioController@get_cuestionario');
// });
