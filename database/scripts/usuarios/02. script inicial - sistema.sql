use SWIITL;

/*********************  INICIO MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
*/

/* INICIO REGISTROS PROVISIONALES SIIA */
INSERT INTO SIIA(NOMBRE, APELLIDO_PATERNO, APELLIDO_MATERNO, NUMERO_CONTORL, CLAVE_CARRERA, FECHA_INGRESO, SEMESTRE, ESTADO, MOTIVO)
VALUES('MIGUEL ANGEL', 'PEÑA', 'LOPEZ', '10420419', 'ISX', '2013-08-19 00:00:00.000', 19, 'BD', 'Concluir Creditos Carrera');
/* FIN REGISTROS PROVISIONALES SIIA */

/* INICIO REGISTROS DEL CATÁLOGO DE CARRERAS */
INSERT INTO CAT_CARRERA(NOMBRE, ABREVIATURA, CLAVE_TECNM, CLAVE_TECLEON)
VALUES ('Ingeniería en Sistemas Computacionales', 'ISX', 'ISX', 'ISX');
/* FIN REGISTROS DEL CATÁLOGO DE CARRERAS */


/*********************  FIN MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
