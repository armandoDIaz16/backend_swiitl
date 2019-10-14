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
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
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

    /* ASIGNACIÓN DE MÓDULO GRUPOS A ROL TUTOR */
SET IDENTITY_INSERT PER_TR_ROL_MODULO ON;
INSERT INTO PER_TR_ROL_MODULO(PK_ROL_MODULO, FK_ROL, FK_MODULO)
VALUES (2, 2, 2);
SET IDENTITY_INSERT PER_TR_ROL_MODULO OFF;


-- PENDIENTE DE SUBIR A PRODUCCIÓN

/* REGISTRO DE ROL COORDIANDOR DEPARTAMENTAL */
SET IDENTITY_INSERT PER_CAT_ROL ON;
INSERT INTO PER_CAT_ROL(PK_ROL, FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (3, 1, 'Coordinador departamental', 'COORDEP');
SET IDENTITY_INSERT PER_CAT_ROL OFF;

/* REGISTRO DE MÓDULO ENCUESTAS */
/*SET IDENTITY_INSERT PER_CAT_MODULO ON;
INSERT INTO PER_CAT_MODULO(PK_MODULO, NOMBRE, ESTADO, ORDEN)
VALUES (2, 'Grupos', 1, 1);
SET IDENTITY_INSERT PER_CAT_MODULO OFF;*/

/* ASIGNACIÓN DE MÓDULO GRUPOS A ROL TUTOR */
/*SET IDENTITY_INSERT PER_TR_ROL_MODULO ON;
INSERT INTO PER_TR_ROL_MODULO(PK_ROL_MODULO, FK_ROL, FK_MODULO)
VALUES (2, 2, 2);
SET IDENTITY_INSERT PER_TR_ROL_MODULO OFF;*/

/* REGISTRO DE ROL COORDIANDOR INSTITUCIONAL */
SET IDENTITY_INSERT PER_CAT_ROL ON;
INSERT INTO PER_CAT_ROL(PK_ROL, FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (4, 1, 'Coordinador institucional', 'COORINS');
SET IDENTITY_INSERT PER_CAT_ROL OFF;

/* REGISTRO DE MÓDULO ENCUESTAS */
/*SET IDENTITY_INSERT PER_CAT_MODULO ON;
INSERT INTO PER_CAT_MODULO(PK_MODULO, NOMBRE, ESTADO, ORDEN)
VALUES (2, 'Grupos', 1, 1);
SET IDENTITY_INSERT PER_CAT_MODULO OFF;*/

/* ASIGNACIÓN DE MÓDULO GRUPOS A ROL TUTOR */
/*SET IDENTITY_INSERT PER_TR_ROL_MODULO ON;
INSERT INTO PER_TR_ROL_MODULO(PK_ROL_MODULO, FK_ROL, FK_MODULO)
VALUES (2, 2, 2);
SET IDENTITY_INSERT PER_TR_ROL_MODULO OFF;*/


/* REGISTRO DE ROL ADMINISTRADOR */
SET IDENTITY_INSERT PER_CAT_ROL ON;
INSERT INTO PER_CAT_ROL(PK_ROL, FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (5, 1, 'Administrador', 'ADMIN');
SET IDENTITY_INSERT PER_CAT_ROL OFF;

/* ASIGNACIÓN DE MÓDULO GRUPOS ADMIN A ROL TUTOR */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (5, 2);

/* ASIGNACIÓN DE ROL A ADMINISTRADOR */
-- SIIA: 1501 NOMBRE: MARÍA ELENA	MARTINEZ	HERNÁNDEZ
INSERT INTO PER_TR_ROL_USUARIO(FK_ROL, FK_USUARIO)
VALUES (5, (SELECT PK_USUARIO FROM CAT_USUARIO WHERE NUMERO_CONTROL = '1501'));

/* REGISTRO DE MÓDULO ENCUESTAS */
/*SET IDENTITY_INSERT PER_CAT_MODULO ON;
INSERT INTO PER_CAT_MODULO(PK_MODULO, NOMBRE, ESTADO, ORDEN)
VALUES (2, 'Grupos', 1, 1);
SET IDENTITY_INSERT PER_CAT_MODULO OFF;*/

/* ASIGNACIÓN DE MÓDULO GRUPOS A ROL TUTOR */
/*SET IDENTITY_INSERT PER_TR_ROL_MODULO ON;
INSERT INTO PER_TR_ROL_MODULO(PK_ROL_MODULO, FK_ROL, FK_MODULO)
VALUES (2, 2, 2);
SET IDENTITY_INSERT PER_TR_ROL_MODULO OFF;*/





/*********************  FIN MODIFICACIONES PUESTA EN PRODUCCIÓN () *********************************/

-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------