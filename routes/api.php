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
});
/* FIN RUTAS GENERALES */

Route::group(['middleware' => ['jwt.verify']], function () {
    /* INICIO RUTAS PARA COMPLETAR PERFIL */
    // OBTENER DATOS DE INICIO PARA COMPLETAR PERFIL
    Route::get('perfil/{id_usuario}', 'PerfilController@get_perfil');

    // GUARDAR DATOS PARA COMPLETAR PERFIL
    Route::post('perfil', 'PerfilController@save_perfil');
    /* FIN RUTAS PARA COMPLETAR PERFIL */
});


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


Route::resource('Usuario_Rol', 'Usuario_RolController');
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
Route::get('Totalp', 'EstadisticasController@totalproyectos');
Route::get('GraficaMaestro/{id}', 'ProyectoController@maestros');
Route::get('Verdoc/{id}', 'DocumentacionResidenciasController@verdoc');
Route::resource('CreditosSiia', 'CreditosSiiaController');
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
// Route::post('generar-constancia', 'constanciasCreditosController@generarConstancia');
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
});


Route::get('Prueba', 'UsuarioController@prueba');
Route::get('Prueba2', 'UsuarioController@prueba2');


/* *********************************************************** *
 * ************* RUTAS PROTEGIDAS DEL SISTEMA DE TUTORIAS *************** *
 * *********************************************************** */
Route::group(['middleware' => ['jwt.verify']], function () {
    // Buscar encuesta por pk de encuesta
    Route::get(
        'cuestionario/{id}',
        'tutorias\SITEncuestaController@get_encuesta'
    );

    // Buscar las encuestas asignadas a un id de usuario
    Route::get(
        'cuestionarios_usuario/{id_usuario}',
        'tutorias\SITEncuestaController@get_cuestionarios_usuarios'
    );

    // Buscar encuesta por pk de aplicacion de encuesta
    Route::get(
        'get_encuesta_aplicacion/{pk_aplicacion_encuesta}',
        'tutorias\SITEncuestaController@get_encuesta_aplicacion'
    );

    // Guarda respuestas de encuesta
    Route::post(
        'guarda_respuestas_encuesta',
        'tutorias\SITEncuestaController@guarda_respuestas_encuesta'
    );

    // Buscar grupos por tutor
    Route::get(
        'grupos_tutoria/{id_tutor}',
        'tutorias\SITGruposController@get_grupos'
    );

    // Buscar detalle de grupo por id
    Route::get(
        'detalle_grupo/{id_grupo}',
        'tutorias\SITGruposController@detalle_grupo'
    );

    // Buscar horario por pk usuario
    Route::get(
        'get_horario_alumno/{id_usuario}',
        'tutorias\SITAlumnoController@get_horario'
    );

    // Buscar datos personales por pk usuario
    Route::get(
        'get_alumno/{pk_usuario}',
        'tutorias\SITAlumnoController@get_alumno'
    );

    // Buscar respuestas por pk_aplicacion
    Route::get(
        'get_encuesta_resuelta_aplicacion/{pk_aplicacion}',
        'tutorias\SITEncuestaController@get_encuesta_resuelta_aplicacion'
    );

    // Buscar reporte por pk_aplicacion
    Route::get(
        'get_reporte_encuesta/{pk_aplicacion}',
        'tutorias\SITEncuestaReporteController@get_reporte_encuesta'
    );
});

/* *********************************************************** *
 * ************* RUTAS LIBRES DEL SISTEMA DE TUTORIAS *************** *
 * *********************************************************** */
//Generar pdf perfil individual de ingreso
Route::get(
    'get_pdf_perfil_personal_ingreso',
    'tutorias\SITPdfController@get_pdf_perfil_personal_ingreso'
);

//Generar pdf perfil grupal de ingreso
Route::get(
    'get_pdf_perfil_grupal_ingreso',
    'tutorias\SITPdfController@get_pdf_perfil_grupal_ingreso'
);








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
