/*********************  INICIO MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/


/* VISTA PARA EL LISTADO DE ENCUESTAS */
DROP VIEW IF EXISTS VIEW_LISTA_ENCUESTAS;
CREATE VIEW VIEW_LISTA_ENCUESTAS AS
SELECT
    TR_APLICACION_ENCUESTA.PK_APLICACION_ENCUESTA,
    TR_APLICACION_ENCUESTA.FK_USUARIO,
    TR_APLICACION_ENCUESTA.FECHA_APLICACION,
    TR_APLICACION_ENCUESTA.FECHA_RESPUESTA,
    TR_APLICACION_ENCUESTA.ESTADO AS ESTADO_APLICACION,
    CAT_ENCUESTA.PK_ENCUESTA,
    CAT_ENCUESTA.NOMBRE,
    CAT_ENCUESTA.ESTADO  AS ESTADO_ENCUESTA
FROM
    TR_APLICACION_ENCUESTA
        LEFT JOIN CAT_ENCUESTA on TR_APLICACION_ENCUESTA.FK_ENCUESTA = CAT_ENCUESTA.PK_ENCUESTA
;

/*********************  FIN MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------

