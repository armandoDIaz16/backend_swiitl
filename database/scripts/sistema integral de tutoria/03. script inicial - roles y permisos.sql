/*********************  INICIO MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/

/* REGISTRO DE SISTEMA TUTORÍAS */
SET IDENTITY_INSERT PER_CAT_SISTEMA ON;
INSERT INTO PER_CAT_SISTEMA(PK_SISTEMA, NOMBRE, RUTA_ANGULAR, ABREVIATURA, CORREO1, INDICIO1)
VALUES(1, 'tutorias', 'tutorias', 'SIT', 'tutorias@itleon.edu.mx', 'tutorias');
SET IDENTITY_INSERT PER_CAT_SISTEMA OFF;

/* REGISTRO DE ROL ESTUDIANTE */
SET IDENTITY_INSERT PER_CAT_ROL ON;
INSERT INTO PER_CAT_ROL(PK_ROL, FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (1, 1, 'Estudiante', 'Estudiante');
SET IDENTITY_INSERT PER_CAT_ROL OFF;

/* REGISTRO DE MÓDULO ENCUESTAS */
SET IDENTITY_INSERT PER_CAT_MODULO ON;
INSERT INTO PER_CAT_MODULO(PK_MODULO, NOMBRE, ESTADO, ORDEN)
VALUES (1, 'Encuestas', 1, 1);
SET IDENTITY_INSERT PER_CAT_MODULO OFF;

/* ASIGNACIÓN DE MÓDULO ENCUESTAS A ROL ESTUDIANTE */
SET IDENTITY_INSERT PER_TR_ROL_MODULO ON;
INSERT INTO PER_TR_ROL_MODULO(PK_ROL_MODULO, FK_ROL, FK_MODULO)
VALUES (1, 1, 1);
SET IDENTITY_INSERT PER_TR_ROL_MODULO OFF;

/*********************  FIN MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------

/*********************  INICIO MODIFICACIONES PARA GRUPOS DE TUTOR (20-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    PENDIENTE
 * PRODUCCIÓN: PENDIENTE
*/

/* REGISTRO DE ROL TUTOR */
SET IDENTITY_INSERT PER_CAT_ROL ON;
INSERT INTO PER_CAT_ROL(PK_ROL, FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (2, 1, 'Tutor', 'Tutor');
SET IDENTITY_INSERT PER_CAT_ROL OFF;

/* REGISTRO DE MÓDULO ENCUESTAS */
SET IDENTITY_INSERT PER_CAT_MODULO ON;
INSERT INTO PER_CAT_MODULO(PK_MODULO, NOMBRE, ESTADO, ORDEN)
VALUES (2, 'Grupos', 1, 1);
SET IDENTITY_INSERT PER_CAT_MODULO OFF;

/* ASIGNACIÓN DE MÓDULO ENCUESTAS A ROL ESTUDIANTE */
SET IDENTITY_INSERT PER_TR_ROL_MODULO ON;
INSERT INTO PER_TR_ROL_MODULO(PK_ROL_MODULO, FK_ROL, FK_MODULO)
VALUES (2, 2, 2);
SET IDENTITY_INSERT PER_TR_ROL_MODULO OFF;


/*********************  FIN MODIFICACIONES PUESTA EN PRODUCCIÓN () *********************************/

-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
