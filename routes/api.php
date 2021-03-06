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
Route::post('recuperar_contrasena', 'AuthController@recuperarContrasena');

// CAMBIO DE CONTRASEÑA
Route::post('resetPassword', 'ChangePasswordController@process');

Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});

/* INICIO RUTAS GENERALES */
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::resource('situacion_residencia', 'SituacionResidenciaController');

    //función para obtener estado y municipio por código postal
    Route::post('procesa_codigo_postal', 'CodigoPostalController@procesa_codigo_postal');

    // OBTENER DATOS DE INICIO PARA COMPLETAR PERFIL
    Route::get('perfil', 'PerfilController@get_perfil');
    // OBTENER DATOS DE INICIO PARA PERFIL CV
    Route::post('get_perfil_CV', 'PerfilController@get_perfil');
    // OBTENER TIPO USUARIO
    Route::post('get_tipo_usuario', 'PerfilController@get_tipo_usuario');



    // GUARDAR DATOS PARA COMPLETAR PERFIL
    Route::post('actualiza_perfil', 'PerfilController@actualiza_perfil');

    // CAMBIAR IMAGEN DE PERFIL
    Route::post('actualiza_foto_perfil', 'PerfilController@actualiza_foto_perfil');
});
/* FIN RUTAS PARA COMPLETAR PERFIL */


Route::get('leer_archivo', 'AspiranteController@leer_archivo');


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

// Buscar roles para menú
Route::resource('Usuario_Rol', 'Usuario_RolController');

// Buscar roles por usuario
Route::post(
    'roles_usuario',
    'Usuario_RolController@roles_usuario'
);

/* Route::get('PAAE_Periodo', 'PAAE_Periodo@index');
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
Route::post('BorraSolicitud', 'PAAE_Periodo@borraSolicitud'); */
Route::resource('Encuestas', 'EncuestaController');
Route::resource('Seccion_Encuesta', 'Seccion_EncuestaController');
Route::resource('Tipo_Pregunta', 'Tipo_PreguntaController');
//Route::resource('PAAE_Periodo', 'PAAE_Periodo');
Route::resource('Entidad_Federativa', 'Entidad_FederativaController');
Route::resource('Ciudad', 'CiudadController');
//Route::resource('PAAE_Periodo', 'PAAE_Periodo');
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
Route::get('Proyecto3/{id}', 'AnteproyectoResidenciasController@ind3');
Route::get('docresalu/{id}', 'DocumentacionResidenciasController@archivos');
Route::get('Totalp', 'EstadisticasController@totalproyectos');
Route::get('GraficaMaestro/{id}', 'ProyectoController@maestros');
Route::get('Verdoc/{id}', 'DocumentacionResidenciasController@verdoc');
Route::resource('CreditosSiia', 'CreditosSiiaController');
Route::get('docresalu/{id}', 'DocumentacionResidenciasController@archivos');
//});
/*************************************************************************************
 * **********************************************************************************/


Route::resource('Entidad_Federativa', 'Entidad_FederativaController');
Route::resource('Ciudad', 'CiudadController');
// Route::resource('PAAE_Periodo', 'PAAE_Periodo');


route::get('GraficaAsesorados', 'GraficasAsesoriaController@graficaAsesorados');
route::get('GraficaNoAsesorados', 'GraficasAsesoriaController@graficaNoAsesorados');
route::get('GraficaMaterias', 'GraficasAsesoriaController@graficaMaterias');
route::get('Materias', 'GraficasAsesoriaController@materias');
route::get('Institucion', 'GraficasAsesoriaController@institucion');
route::get('CarreraMot', 'GraficasAsesoriaController@carrera');
route::get('GraficaMotivosMaterias', 'GraficasAsesoriaController@graficaMotivosMaterias');
route::get('GraficaMotivosInstitucion', 'GraficasAsesoriaController@graficaMotivosInstitucion');
route::get('GraficaMotivosCarera', 'GraficasAsesoriaController@graficaMotivosCarera');
route::get('GraficaGeneralEvalSemestre', 'GraficasAsesoriaController@graficaGeneralEvalSemestre');
route::get('GraficaGeneralEvalCarrera', 'GraficasAsesoriaController@graficaGeneralEvalCarrera');
route::get('GraficaGeneralEvalMateria', 'GraficasAsesoriaController@graficaGeneralEvalMateria');
route::get('GraficaIntegralEval', 'GraficasAsesoriaController@graficaIntegralEval');
route::get('GraficaIntegralMate', 'GraficasAsesoriaController@graficaIntegralMate');
route::get('GraficaIntegralCarre', 'GraficasAsesoriaController@graficaIntegralCarre');
route::get('GraficaGeneralSol', 'GraficasAsesoriaController@graficaGeneralSol');
route::get('GraficaGeneralSolMat', 'GraficasAsesoriaController@graficaGeneralSolMat');
route::get('GraficaGeneralSolCar', 'GraficasAsesoriaController@graficaGeneralSolCar');
route::get('GraficaGeneralSolCarMat', 'GraficasAsesoriaController@graficaGeneralSolCarMat');
route::get('GraficaGeneralAproRep', 'GraficasAsesoriaController@graficaGeneralAproRep');
route::get('GraficaGeneralAproRepMat', 'GraficasAsesoriaController@graficaGeneralAproRepMat');
route::get('GraficaGeneralAproRepCar', 'GraficasAsesoriaController@graficaGeneralAproRepCar');
route::get('GraficaGeneralAproRepCarMat', 'GraficasAsesoriaController@graficaGeneralAproRepCarMat');


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
//Route::group(['middleware' => ['jwt.verify']], function () {
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
Route::get('creditos-carrera/{CARRERA}', 'AlumnoCreditoController@getCreditosByCarrera');
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
 Route::post('generar-constancia', 'constanciasCreditosController@generarConstancia');
// Route::get('prueba-ver-pdf', 'pruebaVerPdf@verpdf');
// Route::get('generar-constancia/{PK_ALUMNO_CREDITO}', 'constanciasCreditosController@generarConstancia');
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
Route::get('get-clave-carrera/{PK_USUARIO}','AlumnoCreditoController@getClaveCarrera');
//});
//Route::get('prueba-fecha','constanciasCreditosController@pruebaFormatoFecha');
//Route::get('prueba-carrera/{PK_ALUMNO_CREDITO}','constanciasCreditosController@getCarrera');
/*************************************************************************************************************************/


/* ************************************** RUTAS DEL SISTEMA ASPIRANTES *************************************** */
Route::get('Periodo', 'PeriodoController@index');
Route::post('PeriodoAspirante', 'PeriodoController@indexAspirante');
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
Route::get('ReferenciaCurso/{preficha}', 'FichaController@descargarReferenciaCurso');
Route::get('ReferenciaInscripcion/{preficha}', 'FichaController@descargarReferenciaInscripcion');
Route::get('ReferenciaInscripcionCero/{preficha}', 'FichaController@descargarReferenciaInscripcionCero');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('Aspirante/{id}', 'AspiranteController@show');
    Route::post('Periodo', 'PeriodoController@store');
    Route::post('PeriodoCurso', 'PeriodoController@periodoCurso');
    Route::post('PeriodoInscripcion', 'PeriodoController@periodoInscripcion');
    Route::post('PeriodoInscripcionCero', 'PeriodoController@periodoInscripcionCero');
    Route::post('MontoPreficha', 'PeriodoController@montoPreficha');
    Route::post('MontoCurso', 'PeriodoController@montoCurso');
    Route::post('MontoInscripcion', 'PeriodoController@montoInscripcion');
    Route::post('MontoInscripcionCero', 'PeriodoController@montoInscripcionCero');
    Route::post('PublicarResultados', 'PeriodoController@publicarResultados');
    Route::post('ModificarTipoExamen', 'PeriodoController@modificarTipoExamen');
    Route::post('MensajesAceptacion', 'PeriodoController@mensajesAceptacion');
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
    Route::post('CargarArchivoResultados/{PK_PERIODO}', 'AspiranteController@cargarArchivoResultados');
    Route::post('CargarArchivoAceptados/{PK_PERIODO}', 'AspiranteController@cargarArchivoAceptados');
    Route::post('CargarArchivoAcistencia/{PK_PERIODO}', 'AspiranteController@cargarArchivoAsistencia');
    Route::post('Aspirante2', 'AspiranteController@modificarAspirante');
    Route::get('ListaGrupo', 'GrupoController@listaGrupos');
    Route::get('ListasGrupos/{PK_PERIODO}', 'GrupoController@datosListas');
    Route::get('ListasGruposIngles/{PK_PERIODO}', 'GrupoController@datosListasIngles');
    Route::get('Espacio2/{PK_PERIODO}', 'LugarExamenController@obtenerEspacio');
    Route::get('Turno/{PK_PERIODO}', 'LugarExamenController@obtenerTurno');
    Route::get('Turno2/{PK_PERIODO}', 'LugarExamenController@obtenerTurno2');
    Route::get('Grupo/{PK_PERIODO}', 'LugarExamenController@obtenerGrupo');
    Route::get('GrupoEscrito/{PK_PERIODO}', 'LugarExamenController@obtenerGrupoEscrito');
    Route::get('Edificio', 'LugarExamenController@obtenerEdificio');
    Route::get('TipoEspacio', 'LugarExamenController@obtenerTipoEspacio');
    Route::post('AgregarTurno', 'LugarExamenController@agregarTurno');
    Route::post('AgregarEspacio', 'LugarExamenController@agregarEspacio');
    Route::post('AgregarGrupo', 'LugarExamenController@agregarGrupo');
    Route::post('AgregarGrupoEscrito', 'LugarExamenController@agregarGrupoEscrito');
    Route::post('ModificarEspacio', 'LugarExamenController@modificarEspacio');
    Route::post('ModificarTurno', 'LugarExamenController@modificarTurno');
    Route::post('ModificarGrupo', 'LugarExamenController@modificarGrupo');
    Route::post('ModificarGrupoEscrito', 'LugarExamenController@modificarGrupoEscrito');
    Route::post('EnviarCorreos', 'AspiranteController@enviarCorreos');
    Route::get('PlantillaSIIA/{id}', 'PlantillaSIIAController@getPlantillaSIIA');

    Route::post('AgregarTurnoEscrito', 'LugarExamenController@agregarTurnoEscrito');
    Route::get('TurnoEscrito/{PK_PERIODO}', 'LugarExamenController@obtenerTurnoEscrito');
    Route::post('ModificarTurnoEscrito', 'LugarExamenController@modificarTurnoEscrito');
    Route::post('AgregarTurnoIngles', 'LugarExamenController@agregarTurnoIngles');
    Route::post('AgregarEspacioIngles', 'LugarExamenController@agregarEspacioIngles');
    Route::post('AgregarGrupoIngles', 'LugarExamenController@agregarGrupoIngles');
    Route::get('TurnoIngles/{PK_PERIODO}', 'LugarExamenController@obtenerTurnoIngles');
    Route::get('EspacioIngles/{PK_PERIODO}', 'LugarExamenController@obtenerEspacioIngles');
    Route::get('GrupoIngles/{PK_PERIODO}', 'LugarExamenController@obtenerGrupoIngles');
    Route::post('ModificarTurnoIngles', 'LugarExamenController@modificarTurnoIngles');
    Route::post('ModificarEspacioIngles', 'LugarExamenController@modificarEspacioIngles');
    Route::post('ModificarGrupoIngles', 'LugarExamenController@modificarGrupoIngles');

    Route::get('ReferenciasPagadas/{PK_PERIODO}', 'AspiranteController@getReferenciasPagadas');
    Route::post('ModificarReferencias', 'PeriodoController@modificarReferencias');
    Route::post('GuardarDocumento/{PK_PERIODO}', 'DocumentosController@guardarDocumento');
    Route::get('ObtenerDocumento', 'DocumentosController@obtenerDocumento');
    Route::get('CarreraFiltro/{PK_PERIODO}', 'CarreraController@carreraFiltro');
});


Route::get('Prueba', 'UsuarioController@prueba');
Route::get('Prueba2', 'UsuarioController@prueba2');


/* *********************************************************** *
 * ************* RUTAS PROTEGIDAS DEL SISTEMA DE TUTORIAS *************** *
 * *********************************************************** */
Route::group(['middleware' => ['jwt.verify']], function () {
    /* GRUPOS DE TUTORIA INICIAL */

    // Buscar grupos de tutoría inicial
    Route::get(
        'grupos_inicial',
        'tutorias\GruposInicialController@index'
    );

    // Buscar respuestas por pk_aplicacion
    Route::get(
        'respuestas_encuesta',
        'tutorias\EncuestaController@respuestas_encuesta'
    );



    /* ************* REPORTES DE TUTORIA *************** */
    // periodos de tutoría
    Route::get('periodos_tutoria', 'tutorias\ReportesController@periodos_tutoria');
    // lista de encuestas de tutoria
    Route::get('encuestas', 'Encuestas\EncuestasController@index');
    // lista de areas academicas
    Route::get('areas_academicas', 'AreaAcademicaController@index');
    // lista de carreras por areas academicas
    Route::get('get_lista_carreras', 'CarreraController@get_carreras');

    // generación de reporte de tutoria
    Route::get('reporte_tutoria', 'tutorias\ReportesController@index');




    // Buscar encuesta por pk de encuesta
    Route::get('cuestionario/{id}', 'tutorias\SITEncuestaController@get_encuesta');
    // Obtener todas las encuestas
    Route::get('get_encuestas_disponibles','tutorias\SITEncuestaController@get_encuestas_disponibles');
    // Obtener las carreras disponibles
    Route::get('get_carreras','tutorias\SITEncuestaController@get_carreras');

    // Buscar las encuestbuscar_usuariosas asignadas a un id de usuario
    Route::get('cuestionarios_usuario/{id_usuario}', 'tutorias\SITEncuestaController@get_cuestionarios_usuarios');

    // Buscar periodos de las encuestas asignadas a un id de usuario
    Route::get(
        'cuestionarios_usuario_periodos/{id_usuario}',
        'tutorias\SITEncuestaController@cuestionarios_usuario_periodos'
    );

    // Buscar encuesta por pk de aplicacion de encuesta
    Route::get('get_encuesta_aplicacion', 'tutorias\SITEncuestaController@get_encuesta_aplicacion');
    // Guarda respuestas de encuesta
    Route::post('guarda_respuestas_encuesta', 'tutorias\SITEncuestaController@guarda_respuestas_encuesta');
    // Buscar grupos por tutor
    Route::post('grupos_tutoria', 'tutorias\SITGruposController@get_grupos');
    // Buscar historico de grupos por tutor
    Route::post('get_historico_grupos_tutor', 'tutorias\SITGruposController@get_historico_grupos_tutor');
    // Buscar detalle de grupo por id
    Route::get('detalle_grupo', 'tutorias\GruposInicialController@detalle_grupo');
    // Buscar horario por pk usuario
    Route::get('get_horario_alumno/{id_usuario}', 'tutorias\SITAlumnoController@get_horario');
    // Buscar datos personales por pk usuario
    Route::get(
        'get_alumno/{pk_usuario}',
        'tutorias\SITAlumnoController@get_alumno'
    );

    // Buscar reporte por pk_aplicacion
    Route::get(
        'get_reporte_encuesta/{pk_aplicacion}',
        'tutorias\SITEncuestaReporteController@get_reporte_encuesta'
    );

    // Buscar coordinadores departamentales
    Route::get(
        'coordinadores_departamentales',
        'tutorias\SITUsuariosController@get_coordinadores_departamentales'
    );

    // Buscar areas academicas
    Route::get(
        'area_academica',
        'AreaAcademicaController@get_area_academica'
    );

    // Buscar usuarios docentes - administrativos
    Route::post(
        'coordinador_departamental',
        'tutorias\SITUsuariosController@coordinador_departamental'
    );

    // Buscar usuarios docentes - administrativos
    Route::post(
        'get_usuarios_docentes',
        'tutorias\SITUsuariosController@get_usuarios_docentes'
    );

    // Guardar coordinador de area academica
    Route::post(
        'guarda_coordinador',
        'tutorias\SITUsuariosController@guarda_coordinador'
    );

    // Obtener datos del tutor
    Route::post(
        'get_datos_tutor',
        'tutorias\SITUsuariosController@get_datos_tutor'
    );

    // Eliminar rol de coordinador de area academica
    Route::post(
        'elimina_rol_coordinador',
        'tutorias\SITUsuariosController@elimina_rol_coordinador'
    );

    // Buscar seguimiento por pk usuario encriptada
    Route::post(
        'get_seguimiento',
        'tutorias\SITAlumnoController@get_seguimiento'
    );

    // Buscar coordinadores institucionales
    Route::get(
        'coordinadores_institucionales',
        'tutorias\SITUsuariosController@get_coordinadores_institucionales'
    );

    // Jornadas/conferencias
    Route::resource('conferencias', 'tutorias\ConferenciaController');

    // Capturista de conferencias
    Route::resource('capturistas', 'tutorias\CapturistaConferenciaController');

    // Invitacion a jornadas/conferencias
    Route::resource('invitacion_conferencia', 'tutorias\InvitacionConferenciaController');

    /* ********************************************* *
     * **** RUTAS DEL COORDINADOR DEPARTAMENTAL **** *
     * ********************************************* */
    // Buscar jornadas/conferencias
    Route::post(
        'get_grupos_coordinador_departamental',
        'tutorias\SITGruposController@get_grupos_coordinador_departamental'
    );

    /* ********************************************* *
     * *********** RUTAS DEL ADMINISTRADOR ********* *
     * ********************************************* */
    // Buscar grupos de tutoría inicial
    Route::post(
        'get_grupos_admin',
        'tutorias\SITGruposController@get_grupos_admin'
    );

    // Buscar grupos de tutoría del siia
    Route::post(
        'get_grupos_siia',
        'tutorias\SITGruposSiiaController@get_grupos_siia'
    );

    // Buscar número de control
    Route::post(
        'valida_numero_control',
        'tutorias\SITUsuariosController@valida_numero_control'
    );

    // Obtener los tipos de aplicacion de las encuestas
    Route::get(
        'get_tipos_aplicacion',
        'tutorias\SITEncuestaController@get_tipos_aplicacion'
    );

    // Obtener histórico de aplicacion de las encuestas
    Route::get(
        'get_encuestas_historico',
        'tutorias\SITEncuestaController@get_encuestas_historico'
    );

    // Aplicar una encuesta
    Route::post(
        'aplicar_encuesta',
        'tutorias\SITEncuestaController@aplicar_encuesta'
    );

    // Guardar coordinador institucional
    Route::post(
        'guarda_coordinador_institucional',
        'tutorias\SITUsuariosController@guarda_coordinador_institucional'
    );

    // Eliminar rol de coordinador institucional
    Route::post(
        'elimina_rol_coordinador_institucional',
        'tutorias\SITUsuariosController@elimina_rol_coordinador_institucional'
    );

    /* INICIO GRUPOS DE SEGUIMIENTO */
    // CRERAR GRUPO DE SEGUIMIENTO
    Route::post(
        'guarda_grupo_seguimiento',
        'tutorias\SITGruposSeguimientoController@guarda_grupo_seguimiento'
    );

    // OBTENER GRUPOS DE TUTORÍA DE SEGUIMIENTO
    Route::post(
        'grupos_seguimiento_admin',
        'tutorias\SITGruposSeguimientoController@get_grupos_admin'
    );

    // BUSCAR GRUPO DE TUTORÍA DE SEGUIMIENTO
    Route::get(
        'get_grupo_seguimiento',
        'tutorias\SITGruposSeguimientoController@get_grupo_seguimiento'
    );

    // ACTUALIZAR GRUPO DE SEGUIMIENTO
    Route::put(
        'actualiza_grupo_seguimiento/{id}',
        'tutorias\SITGruposSeguimientoController@actualiza_grupo'
    );

    // ELIMINA GRUPO DE SEGUIMIENTO
    Route::delete(
        'elimina_grupo_seguimiento/{id}',
        'tutorias\SITGruposSeguimientoController@elimina_grupo_seguimiento'
    );
    /* FIN GRUPOS DE SEGUIMIENTO */

    /* INICIO DETALLE GRUPOS DE SEGUIMIENTO */
    // AGREGAR ALUMNO A GRUPO DE TUTORÍA DE SEGUIMIENTO
    Route::post(
        'agrega_alumno_grupo',
        'tutorias\SITGruposSeguimientoController@agrega_alumno_grupo'
    );

    // BUSCAR ALUMNOS DE GRUPO DE TUTORÍA DE SEGUIMIENTO
    Route::get(
        'get_alumnos_grupo',
        'tutorias\SITGruposSeguimientoController@get_alumnos_grupo'
    );

    // ELIMINAR ALUMNO DE GRUPO DE TUTORÍA DE SEGUIMIENTO
    Route::delete(
        'elimina_alumno_grupo/{id}',
        'tutorias\SITGruposSeguimientoController@elimina_alumno_grupo'
    );
    /* FIN DETALLE GRUPOS DE SEGUIMIENTO */


});

/* *********************************************************** *
 * ************* RUTAS LIBRES DEL SISTEMA DE TUTORIAS *************** *
 * *********************************************************** */
//Generar pdf perfil individual de ingreso
Route::get(
    'c413a63cce7f8f6a6f7b9179a20bfbe0', // reporte_perfil_personal_de_ingreso
    'tutorias\SITPdfController@perfil_personal'
);

//Generar pdf perfil grupal de ingreso
Route::get(
    'de99193444466a46d939f6e1fe025e10', // reporte_perfil_grupal_ingreso
    'tutorias\SITPdfController@perfil_grupal'
);

// Probar reportes de tutoria
/*Route::get(
    'test_reporte',
    'tutorias\SITPdfController@test_reporte'
);*/

/* *********************************************************** *
 * ************* RUTAS PROTEGIDAS DEL SISTEMA DE ROLES Y USUARIOS *************** *
 * *********************************************************** */
Route::group(['middleware' => ['jwt.verify']], function () {
    // get usuarios
    Route::get(
        'usuario',
        'UsuariosController@index'
    );

    // get alumno
    Route::get(
        'alumno',
        'UsuariosController@alumno'
    );

    // Buscar usuarios
    Route::post(
        'buscar_usuarios',
        'UsuariosController@buscar_usuarios'
    );

    // modifica correo principal de usuario por pk
    Route::post(
        'modifica_correo_usuario',
        'UsuariosController@modifica_correo_usuario'
    );
});

/* *********************************************************** *
 * ************* RUTAS LIBRES DEL SISTEMA DE ROLES Y USUARIOS *************** *
 * *********************************************************** */
//Generar pdf perfil individual de ingreso
/*Route::get(
    'get_pdf_perfil_personal_ingreso',
    'tutorias\SITPdfController@get_pdf_perfil_personal_ingreso'
);*/








///////////////////////////////// PAAE ////////////////////////////////////
Route::group(['middleware' => ['jwt.verify']], function () {
Route::get('PAAE_Periodo','PAAE_Periodo@index');
Route::get('Hora','PAAE_Periodo@horario');
Route::get('HoraAll','PAAE_Periodo@horarioAll');
Route::get('Materia','PAAE_Periodo@materia');
Route::get('Datos','PAAE_Periodo@getDatos');
Route::get('Promedio','PAAE_Periodo@promedio');
Route::get('MateriAsesor','PAAE_Periodo@materiAsesor');
Route::get('Asesor','PAAE_Periodo@getAsesor');
Route::get('AsesorAsigna','PAAE_Periodo@getAsesorAsigna');
Route::get('AsesorPeriodo','PAAE_Periodo@getAsesorPeriodo');
Route::get('Solicitudes','PAAE_Periodo@getSolicitud');
Route::get('SolicitudesAsigna','PAAE_Periodo@getSolicitudAsigna');
Route::get('SolicitudesPeriodo','PAAE_Periodo@getSolicitudPeriodo');
Route::get('Seguimiento','PAAE_Periodo@seguimiento');
Route::get('AllMaterias','PAAE_Periodo@allMaterias');
Route::get('ClaveGrupo','PAAE_Periodo@claveGrupo');
Route::get('ClaveHorario','PAAE_Periodo@claveHorario');
Route::get('Asesoria','PAAE_Periodo@getAsesoria');
Route::get('AsesoriaPeriodo','PAAE_Periodo@getAsesoriaPeriodo');
Route::get('AsesoriaGrupo','PAAE_Periodo@getAsesoriaGrupo');
Route::get('AsesoriaGrupoPeriodo','PAAE_Periodo@getAsesoriaGrupoPeriodo');
Route::get('AsesoriaId','PAAE_Periodo@getAsesoriaId');
Route::get('Docentes','PAAE_Periodo@allDocente');
Route::get('NameAses','PAAE_Periodo@nombreAsesor');
Route::get('AsesorSesion','PAAE_Periodo@allAsesor');
Route::get('AlumnosAsesoria','PAAE_Periodo@getAlumnoAsesorado');
Route::get('AlumnosAsesoriaMateria','PAAE_Periodo@getAlumnoAsesoradoMateria');
Route::get('Sesion','PAAE_Periodo@getSesion');
Route::get('PdfComplementaria','PAEEPDF@complementaria');
Route::get('PdfServicio','PAEEPDF@servicio');
Route::get('Reprobados','PAAE_Periodo@situacionAcademica');
Route::get('Recursando','PAAE_Periodo@recursando');
Route::get('MateriaRepeticion','PAAE_Periodo@materiaRepeticion');
Route::get('AsesorAsigna','PAAE_Periodo@getAsesorAsigna');
Route::get('SolicitudesAsigna','PAAE_Periodo@getSolicitudAsigna');
Route::get('AsesorFinal','PAAE_Periodo@AsesorEntregoFinal');
Route::get('AsesorFinalPeriodo','PAAE_Periodo@AsesorEntregoFinalPeriodo');
Route::get('TodosMotivos','PAAE_Periodo@allMotivos');
Route::get('MotivosPeriodo','PAAE_Periodo@allMotivosPeriodo');
Route::get('TodosCompromisoUser','PAAE_Periodo@allCompromisoUser');
Route::get('CompromisoUserPeriodo','PAAE_Periodo@allCompromisoUserPeriodo');
Route::get('TodosCompromisoAsesor','PAAE_Periodo@allCompromisoAsesor');
Route::get('CompromisoAsesorPeriodo','PAAE_Periodo@allCompromisoAsesorPeriodo');
Route::get('TodosEvaluacion','PAAE_Periodo@allEvaluacion');
Route::get('EvaluacionPeriodo','PAAE_Periodo@allEvaluacionPeriodo');
Route::get('TodosCalificacion','PAAE_Periodo@allCalificacion');
Route::get('CalificacionPeriodo','PAAE_Periodo@allCalificacionPeriodo');
Route::get('TodosSesiones','PAAE_Periodo@allReporteSesion');
Route::get('SesionesPeriodo','PAAE_Periodo@allReporteSesionPeriodo');
Route::get('TodosAsistencia','PAAE_Periodo@allAsistencia');
Route::get('AsistenciaPeriodo','PAAE_Periodo@allAsistenciaPeriodo');
Route::get('TodosReporteFinal','PAAE_Periodo@allReporteFinal');
Route::get('ReporteFinalPeriodo','PAAE_Periodo@allReporteFinalPeriodo');

//Route::get('TodosAsignacion','PAAE_Periodo@allSituacionAcademica');
Route::get('SituacionPeriodo','PAAE_Periodo@allSituacionAcademicaPeriodo');

Route::get('TodosAsesores','PAAE_Periodo@AsesoresListal');
Route::get('AsesoresPeriodo','PAAE_Periodo@AsesoresListalPeriodo');
Route::get('SesionAsesor','PAAE_Periodo@sesionPorAsesor');
Route::get('CorreosAlumnos','PAAE_Periodo@correosAlumnos');
Route::get('ListaAlumnos','PAAE_Periodo@listaAlumnos');
Route::get('CorreoIndividualAlumno','PAAE_Periodo@correoIndividualAlumno');
Route::get('CorreoAsesor','PAAE_Periodo@correoAsesor');
Route::post('SolicitudAsesoria','PAAE_Periodo@crearSolicitud');
Route::post('SolicitudAsesor','PAAE_Periodo@crearSolicitudAsesor');
Route::post('ActualizAsesor','PAAE_Periodo@actualizAsesor');
Route::post('ActualizaSolicitud','PAAE_Periodo@actualizaSolicitud');
Route::post('BorrAsesor','PAAE_Periodo@borrAsesor');
Route::post('BorraSolicitud','PAAE_Periodo@borraSolicitud');
Route::post('AsignaIndividual','PAAE_Periodo@asignacionIndividual');
Route::post('AsignaGrupal','PAAE_Periodo@asignacionGrupal');
Route::post('ActualizaInd','PAAE_Periodo@actualizAsigInd');
Route::post('BorraInd','PAAE_Periodo@borrInd');
Route::post('ActualizaGrupo','PAAE_Periodo@actualizGrupo');
Route::post('BorraGru','PAAE_Periodo@borrGru');
Route::post('Motivo','PAAE_Periodo@motivo');
Route::post('CompromisoUser','PAAE_Periodo@compromisoUser');
Route::post('EvaluacionSatisfaccion','PAAE_Periodo@evaluacionSatisfaccion');
Route::post('CompromisoAsesor','PAAE_Periodo@compromisoAsesor');
Route::post('CreaSesion','PAAE_Periodo@crearSesion');
Route::post('CreaLista','PAAE_Periodo@crearAsistencia');
Route::post('CreaFin','PAAE_Periodo@creaFinal');
Route::post('AsignaSituacion','PAAE_Periodo@asignacionSituacion');
Route::post('EnviarCorreoPAAE','PAAE_Periodo@enviarCorreos');
Route::post('CreaCalificacion','PAAE_Periodo@creaCalificacion');
});

/* *********************************************************** *
 * ************* RUTAS DE SISTEMA SERVICIO SOCIAL *************** *
 * *********************************************************** */

 Route::resource('convocatorias', 'ServicioSocial\ConvocatoriaController');
 Route::post('saveConvocatoria', 'ServicioSocial\ConvocatoriaController@saveConvocatoria');
 Route::get('getSalones/{edificio}','ServicioSocial\Convocatoriacontroller@getSalones');
 Route::get('getEdificios/{campus}','ServicioSocial\Convocatoriacontroller@getEdificios');
 Route::get('getCampus/{tecnm}','ServicioSocial\ConvocatoriaController@getCampus');
 Route::get('getEspacio','ServicioSocial\ConvocatoriaController@getEspacio');
 Route::get('busquedaConvocatoria/{dato}','ServicioSocial\ConvocatoriaController@busquedaConvocatoria');
 Route::get('allConvocatoria/','ServicioSocial\ConvocatoriaController@allConvocatoria');
 Route::get('convocatoriaPdf/{id}','ServicioSocial\ConvocatoriaController@convocatoriaPdf');

















 /* *********************************************************** *
 * ************* RUTAS REFERENCIAS *************** *
 * *********************************************************** */
Route::get('ReferenciaReInscripcion/{id}', 'ReferenciaController@referenciaReInscripcion');











/* ************************************************************************* *
 * ************* RUTAS PROTEGIDAS DEL SISTEMA DE REFERENCIAS *************** *
 * ************************************************************************* */
//Route::group(['middleware' => ['jwt.verify']], function () {
    /**************************
     *      MÓDULO NIVEL
     * ***********************/
    // Buscar todos los niveles
    Route::get(
        'a79eec2bd07a224f137dbe825aae22f2', // niveles
        'Referencias\NivelController@getNiveles'
    );

    // Buscar un nivel especificado por su PK
    Route::get(
        'a79eec2bd07a224f137dbe825aae22f2/{id}', // niveles/id
        'Referencias\NivelController@getNivel'
    );

    /**************************
     *      MÓDULO VALE
     * ***********************/
    // Buscar todos los vales
    Route::get(
        'ca24ce920d61b09e5043e174c7bc16f4', // vales
        'Referencias\ValeController@getVales'
    );

    // Buscar un vale especificado por su PK
    Route::get(
        'ca24ce920d61b09e5043e174c7bc16f4/{id}', // vales/id
        'Referencias\ValeController@getVale'
    );

    /**************************
     *     MÓDULO CONCEPTO
     * ***********************/
    // Buscar todos los conceptos
    Route::get(
        'e4ea811fdfd3f43bd4b0948734067104', // conceptos
        'Referencias\ConceptoController@getConceptos'
    );

    // Buscar un concepto especificado por su PK
    Route::get(
        'e4ea811fdfd3f43bd4b0948734067104/{id}', // conceptos/id
        'Referencias\ConceptoController@getConcepto'
    );

    // Crear un concepto
    Route::post(
        '80508ce673a395b9f30466b3693b126d',    // createConcepto
        'Referencias\ConceptoController@createConcepto'
    );

    // Actualizar un concepto
    Route::patch(
        'a4d60fe7d61c16bf5f0d74303ddd3e7d/{id}',    // updateConcepto/id
        'Referencias\ConceptoController@updateConcepto'
    );

    // Dar de baja a un concepto
    Route::delete(
        '6c5288dee70a3754c8632d17c82d374b/{id}',    // deleteConcepto/id
        'Referencias\ConceptoController@deleteConcepto'
    );

    /*******************************************
     *     MÓDULO RELACIÓN CONCEPTO-NIVEL
     * ****************************************/
    // Buscar todas las relaciones entre concepto - nivel
    Route::get(
        'bf6467e75eda50b466746bf5795e20f5', // conceptoNivel
        'Referencias\ConceptoNivelController@getAllConceptoNivel'
    );

    // Buscar una relación concepto - nivel especificado por su PK, número de nivel o nombre de nivel
    Route::post(
        'bf6467e75eda50b466746bf5795e20f5',    // conceptoNivel
        'Referencias\ConceptoNivelController@getConceptoNivel'
    );

    // Crear una relación concepto - nivel
    Route::post(
        '907c3b7e14835e1b9230e737a1f02fc5',  // createConceptoNivel
        'Referencias\ConceptoNivelController@createConceptoNivel'
    );

    // Actualizar una relación concepto - nivel
    Route::patch(
        '907f89dbb42acb073b322d38dbdd6c1f/{id}', // updateConceptoNivel/id
        'Referencias\ConceptoNivelController@updateConceptoNivel'
    );

    // Dar de baja a una relación concepto - nivel
    Route::delete(
        '92f7d5cb6226d5e17bc4f7462c81a0d6/{id}', // deleteConceptoNivel/id
        'Referencias\ConceptoNivelController@deleteConceptoNivel'
    );

    /***************************
     *     MÓDULO REFERENCIAS
     * ************************/
    // Buscar todos las referencias
    Route::get(
        'f44481864c5480bba492078f6e748da7',  // referencias
        'Referencias\ReferenciaController@getReferencias'
    );

    // Buscar una referencia por su PK.
    Route::get(
        'f44481864c5480bba492078f6e748da7/{id}',        // referencias/id
        'Referencias\ReferenciaController@getReferencia'
    );

    // Crear una referencia
    Route::post(
        '8b434114ba6920f69e3634341051e279',     // createReferencia
        'Referencias\ReferenciaController@createReferencia'
    );
//});

/* ********************************************************************* *
 * ************* RUTAS LIBRES DEL SISTEMA DE REFERENCIAS *************** *
 * ********************************************************************* */
//Generar pdf perfil individual de ingreso
/*Route::get(
    'get_pdf_perfil_personal_ingreso',
    'tutorias\SITPdfController@get_pdf_perfil_personal_ingreso'
);*/

// REFERENCIAS ESPECIALES
Route::get('referencia_especial_siia', 'ReferenciasEspeciales@generar_referencia_siia');
Route::get('referencia_especial', 'ReferenciasEspeciales@generar_referencia');
Route::get('referencia_especial_hijos', 'ReferenciasEspeciales@generar_referencia_hijos');
Route::get('referencia_propedeutico', 'ReferenciasEspeciales@referencia_propedeutico');


        /* *********************************************************** *
         * **** RUTAS PROTEGIDAS DEL SISTEMA DE  CAPACITACION DOCENTE *** *
         * *********************************************************** */
    Route::group(['middleware' => ['jwt.verify']], function () {
        //* ************* INICIO PERIODOS *************** *
        // Registro de periodo
        Route::post(
            'registro_periodo',
            'capacitacion_docente\PeridoController@registro_periodo'
        );

    // Consulta de periodos
    Route::get(
        'consulta_periodos',
        'capacitacion_docente\PeridoController@consulta_periodos'
    );




    // // Buscar un periodo por pk
    Route::get(
        'consulta_un_periodo/{id}',
        'capacitacion_docente\PeridoController@consulta_un_periodo'
    );


    // Modifciacion de un periodo
    Route::post(
        'modificar_periodo',
        'capacitacion_docente\PeridoController@modificar_periodo'
    );

    // ELIMINA  de un periodo
    Route::post(
        'eliminar_periodo',
        'capacitacion_docente\PeridoController@eliminar_periodo'
    );
    // Consulta de periodos
    Route::get(
        'consulta_periodos',
        'capacitacion_docente\PeridoController@consulta_periodos'
    );
    // Buscar un periodo con cursos por pk
    Route::get(
        'busca_periodo_con_cursos/{id}',
        'capacitacion_docente\PeridoController@busca_periodo_con_cursos'
    );
    // Consulta de periodos activos
    Route::get(
        'consulta_periodos_activos',
        'capacitacion_docente\PeridoController@consulta_periodos_activos'
    );
    //* ************* FIN  PERIODOS *************** *
    //* ************* INICIO  CURSOS *************** *

// busca  de un curso por pk
    Route::get(
        'busca_curso_por_pk/{pk_curso}',
        'capacitacion_docente\CursoController@busca_curso_por_pk'
    );
// modifica curso
    Route::post(
        'modifica_curso',
        'capacitacion_docente\CursoController@modifica_curso'
    );

    // ELIMINA  de un curso
    Route::post(
        'eliminar_curso',
        'capacitacion_docente\CursoController@eliminar_curso'
    );

    // Consulta de consulta_institutos
    Route::get(
        'consulta_institutos',
        'capacitacion_docente\CursoController@consulta_institutos'
    );

    // Consulta de eificios
    Route::get(
        'consulta_edificios',
        'capacitacion_docente\CursoController@consulta_edificios'
    );
// Consulta de areas
    Route::get(
        'consulta_area_academica',
        'capacitacion_docente\CursoController@consulta_area_academica'
    );
    // Consulta de estados del curso
    Route::get(
        'carga_estados_curso',
        'capacitacion_docente\CursoController@carga_estados_curso'
    );
// actualiza curso estatus
    Route::get(
        'actualiza_estatus_curso/{pk_curso}/{estatus}',
        'capacitacion_docente\CursoController@actualiza_estatus_curso'
    );

// filtro docente
    Route::get(
        'filtro_docente/{value?}',
        'capacitacion_docente\CursoController@filtro_docente'
    );
// registro curso
    Route::post(
        'registro_curso',
        'capacitacion_docente\CursoController@registro_curso'
    );
    // Asigna instructores de curso
    Route::post(
        'asigna_instructores_curso',
        'capacitacion_docente\CursoController@asigna_instructores_curso'
    );
    // Asigna instructores de curso
    Route::post(
        'modifica_instructores_curso',
        'capacitacion_docente\CursoController@modifica_instructores_curso'
    );

// Consulta de participante
    Route::get(
        'consulta_participante/{idUsuario}',
        'capacitacion_docente\CursoController@consulta_participante'
    );

    // Consulta de participante
    Route::get(
        'consulta_roles/{idUsuario}/{abreviatura_sistema}',
        'capacitacion_docente\CursoController@consulta_roles'
    );

// Consulta de cursos por instructor
    Route::get(
        'consulta_cursos_participante/{pk_participante}/{tipo_participante}',
        'capacitacion_docente\CursoController@consulta_cursos_participante'
    );
// Consulta de cursos por coordinador
    Route::get(
        'consulta_cursos_coordinador',
        'capacitacion_docente\CursoController@consulta_cursos_coordinador'
    );



// Consulta de cursos por instrcutor
    Route::get(
        'consulta_cursos_instructor/{pk_participante}',
        'capacitacion_docente\CursoController@consulta_cursos_instructor'
    );
  // Consulta de instructor
    Route::get(
        'busca_instructor/{pk_participante?}',
        'capacitacion_docente\CursoController@busca_instructor'
    );

//* ************* FIN  CURSOS *************** *
    //* ************* INICIO  FICHA TECNICA *************** *

// Crear ficha tecnica del curso
    Route::post(
        'crear_actualizar_ficha',
        'capacitacion_docente\FichaTecnicaController@crear_actualizar_ficha');

    // CAMBIAR IMAGEN DE CURSO
    Route::post(
        'registra_foto_curso',
        'capacitacion_docente\FichaTecnicaController@registra_foto_curso');
    // AÑADE UN ELEMENTO ADJUNTO A LOS  TEMAS
    Route::post(
        'registra_archivo_adjunto',
        'capacitacion_docente\FichaTecnicaController@registra_archivo_adjunto');

    // REGISTRA SECCION DESCRIPCION SERVICIO
    Route::post(
        'guardar_descripcion_servicio',
        'capacitacion_docente\FichaTecnicaController@guardar_descripcion_servicio'
    );
    // REGISTRA SECCION INFORMACION SERVICIO
    Route::post(
        'guardar_informacion_servicio',
        'capacitacion_docente\FichaTecnicaController@guardar_informacion_servicio'
    );
    // REGISTRA SECCION ELEMENTOS DIDACTICOS
    Route::post(
        'guardar_elementos_didacticos',
        'capacitacion_docente\FichaTecnicaController@guardar_elementos_didacticos'
    );
    // REGISTRA SECCION CRITERIOS DE EVALUACION
    Route::post(
        'guardar_criterios_evaluacion',
        'capacitacion_docente\FichaTecnicaController@guardar_criterios_evaluacion'
    );
    // REGISTRA SECCION COMPETENCIAS
    Route::post(
        'guardar_competencias',
        'capacitacion_docente\FichaTecnicaController@guardar_competencias'
    );
    // REGISTRA SECCION FUENTES DE INFORMACION
    Route::post(
        'guardar_fuentes_informacion',
        'capacitacion_docente\FichaTecnicaController@guardar_fuentes_informacion'
    );
    // REGISTRA SECCION CONTENIDO TEMATICO
    Route::post(
        'guardar_contenidos_tematicos',
        'capacitacion_docente\FichaTecnicaController@guardar_contenidos_tematicos'
    );
    // ELIMINA ARCHIVO DE TEMA
    Route::get(
        'elimina_archivo_por_pk/{pk_archivo}/{pk_ficha}',
        'capacitacion_docente\FichaTecnicaController@elimina_archivo_por_pk'
    );
// Consulta participante
    Route::get(
        'busca_participante_por_pk/{pk_participante}',
        'capacitacion_docente\FichaTecnicaController@busca_participante_por_pk'
    );
// Consulta cv de los intructores del curso
    Route::get(
        'busca_cv_instructor/{pk_curso}',
        'capacitacion_docente\FichaTecnicaController@busca_cv_instructor'
    );

    // REGISTRA SECCION CONTENIDO TEMATICO
    Route::post(
        'guarda_comentario',
        'capacitacion_docente\FichaTecnicaController@guarda_comentario'
    );


    //* ************* FIN  FICHA TECNICA *************** *

    //* ************* INICIO CONVOCATORIA  *************** *
// Consulta de  la convocatoria
    Route::get(
        'carga_convocatoria_cursos',
        'capacitacion_docente\ConvocatoriaController@carga_convocatoria_cursos'
    );

    // Consulta de los cursos del participante
    Route::get(
        'carga_mis_cursos/{pk_participante}',
        'capacitacion_docente\ConvocatoriaController@carga_mis_cursos'
    );

    // Consulta el cupo del curso para inscribir a un participante
    Route::get(
        'validar_cupo_curso/{pk_curso}',
        'capacitacion_docente\ConvocatoriaController@validar_cupo_curso'
    );
    // Consulta el cupo del curso para inscribir a un participante
    Route::get(
        'validar_horario_disponible/{pk_curso}/{pk_participante}/{pk_periodo}',
        'capacitacion_docente\ConvocatoriaController@validar_horario_disponible'
    );
// REGISTRA SECCION CONTENIDO TEMATICO
    Route::post(
        'inscribir_participante',
        'capacitacion_docente\ConvocatoriaController@inscribir_participante'
    );
    // REGISTRA SECCION CONTENIDO TEMATICO
    Route::post(
        'baja_participante',
        'capacitacion_docente\ConvocatoriaController@baja_participante'
    );

    // Consulta el cupo del curso para inscribir a un participante
    Route::get(
        'valida_inscripcion_curso/{pk_curso}/{pk_participante}',
        'capacitacion_docente\ConvocatoriaController@valida_inscripcion_curso'
    );


        //* ************* FIN CONVOCATORIA *************** *
 //* ************* INICIO CV  *************** *

// Crear ficha tecnica del curso
    Route::post(
        'crear_actualizar_cv',
        'capacitacion_docente\CurriculumController@crear_actualizar_cv');

// REGISTRA SECCION DATOS PERSONALES
    Route::post(
        'guardar_datos_personales',
        'capacitacion_docente\CurriculumController@guardar_datos_personales'
    );
    // Consulta de carga_tipos_formacion
    Route::get(
        'carga_tipos_formacion',
        'capacitacion_docente\CurriculumController@carga_tipos_formacion'
    );

    // REGISTRA SECCION FORMACION ACADEMICA
    Route::post(
        'guardar_formacion_academica',
        'capacitacion_docente\CurriculumController@guardar_formacion_academica'
    );
// REGISTRA SECCION EXPERIENCIA LABORAL
    Route::post(
        'guardar_experiencia_laboral',
        'capacitacion_docente\CurriculumController@guardar_experiencia_laboral'
    );
    // REGISTRA SECCION PRODUCTOS ACADEMICOS
    Route::post(
        'guardar_productos_academicos',
        'capacitacion_docente\CurriculumController@guardar_productos_academicos'
    );
    // REGISTRA SECCION PARTICIPACION INSTRUCTOR
    Route::post(
        'guardar_seccion_participacion_instructor',
        'capacitacion_docente\CurriculumController@guardar_seccion_participacion_instructor'
    );

    // REGISTRA SECCION EXPERIENCIA DOCENTE
    Route::post(
        'guardar_seccion_experiencia_docente',
        'capacitacion_docente\CurriculumController@guardar_seccion_experiencia_docente'
    );


//* ************* FIN CV  *************** *

});

/* *********************************************************** *
 * ************* RUTAS LIBRES DEL SISTEMA DE CAPACITACION DOCENTE *************** *
 * *********************************************************** */
// Consulta la ficha tecnica en PDF
Route::get(
    'reporteFichaTecnicaPDF/{pk_curso}',
    'capacitacion_docente\FichaTecnicaController@reporteFichaTecnicaPDF'
);
// Consulta el CV en PDF
Route::get(
    'reporteCVPDF/{pk_participante}',
    'capacitacion_docente\CurriculumController@reporteCVPDF'
);
// Consulta el CV en PDF
Route::get(
    'reporteCVHTML/{pk_participante}',
    'capacitacion_docente\CurriculumController@reporteCVHTML'
);
// ruta de prueba
/*Route::get(
    'pruebarelacionorm/',
    'capacitacion_docente\FichaTecnicaController@pruebarelacionorm'
);*/

// Consulta el cupo del curso para inscribir a un participante
/*Route::get(
    'validar_horario_disponible/{pk_curso}/{pk_participante}/{pk_periodo}',
    'capacitacion_docente\ConvocatoriaController@validar_horario_disponible'
);
// REGISTRA SECCION CONTENIDO TEMATICO
Route::post(
    'inscribir_participante',
    'capacitacion_docente\ConvocatoriaController@inscribir_participante'
);*/
/*// REGISTRA SECCION CONTENIDO TEMATICO
Route::post(
    'baja_participante',
    'capacitacion_docente\ConvocatoriaController@baja_participante'
);*/
// Consulta de cursos misma fecha
/*Route::get(
    'busca_curso_misma_hora/{fecha_inicio?}/{hora_inicio?}',
    'capacitacion_docente\CursoController@busca_curso_misma_hora'
);

 // Consulta de periodos
 Route::get(
    'consulta_periodos',
    'capacitacion_docente\PeridoController@consulta_periodos'
);

// Consulta de eificios
Route::get(
    'consulta_edificios',
    'capacitacion_docente\CursoController@consulta_edificios'
);
// Consulta de areas
Route::get(
    'consulta_area_academica',
    'capacitacion_docente\CursoController@consulta_area_academica'
);
// filtro docente
Route::get(
    'filtro_docente/{value?}',
    'capacitacion_docente\CursoController@filtro_docente'
);
// registro curso
Route::post(
    'registro_curso',
    'capacitacion_docente\CursoController@registro_curso'
);
// Consulta de participante
Route::get(
    'consulta_participante/{noControl}',
    'capacitacion_docente\CursoController@consulta_participante'
);
// Consulta de cursos por instructor
Route::get(
    'consulta_cursos_participante/{pk_participante}/{tipo_participante}',
    'capacitacion_docente\CursoController@consulta_cursos_participante'
);
// Consulta de cursos por coordinador
Route::get(
    'consulta_cursos_coordinador',
    'capacitacion_docente\CursoController@consulta_cursos_coordinador'
);
// Consulta de cursos por instrcutor
Route::get(
    'consulta_cursos_instructor/{pk_participante}',
    'capacitacion_docente\CursoController@consulta_cursos_instructor'
);
// Consulta de instructor
Route::get(
    'busca_instructor/{pk_participante?}',
    'capacitacion_docente\CursoController@busca_instructor'
);
*/

//     // Buscar un periodo por pk
//     Route::get(
//         'consulta_un_periodo/{id}',
//         'capacitacion_docente\PeridoController@consulta_un_periodo'
//     );

/* *********************************************************** *
 * ************* FIN RUTAS LIBRES DEL SISTEMA DE CAPACITACION DOCENTE *************** *
 * *********************************************************** */

//Generar pdf perfil individual de ingreso
// Route::get(
//     'get_pdf_perfil_personal_ingreso',
//     'tutorias\SITPdfController@get_pdf_perfil_personal_ingreso'
// );
