/*********************  INICIO MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/

/* ****************************************************** *
 * ********** ELIMINACIÓN DE TABLAS DE ENCUESTAS ******** *
 * ****************************************************** */
DROP TABLE IF EXISTS TR_APLICACION_ENCUESTA;
DROP TABLE IF EXISTS TR_RESPUESTA_USUARIO_ENCUESTA;
DROP TABLE IF EXISTS CAT_RESPUESTA_POSIBLE;
DROP TABLE IF EXISTS CAT_PREGUNTA;
DROP TABLE IF EXISTS CAT_TIPO_PREGUNTA;
DROP TABLE IF EXISTS CAT_SECCION;
DROP TABLE IF EXISTS CAT_ENCUESTA;

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE ENCUESTAS ******** *
 * *************************************************** */

/* INICIO TABLA PARA ENCUESTAS */
CREATE TABLE CAT_ENCUESTA
(
    PK_ENCUESTA             INT          NOT NULL IDENTITY (1,1),

    NOMBRE                  VARCHAR(100) NOT NULL,
    OBJETIVO                TEXT,
    INSTRUCCIONES           TEXT,
    FUENTE_CITA             TEXT,
    ES_ADMINISTRABLE        SMALLINT     NOT NULL DEFAULT 1, -- Sí de administrable
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_ENCUESTA
    ADD CONSTRAINT PRK_ENCUESTA_CAT_ENCUESTA PRIMARY KEY (PK_ENCUESTA ASC);
/* FIN TABLA PARA ENCUESTAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE SECCIONES ******** *
 * *************************************************** */

/* INICIO TABLA PARA SECCIONES */
CREATE TABLE CAT_SECCION
(
    PK_SECCION              INT          NOT NULL IDENTITY (1,1),
    FK_ENCUESTA             INT,

    NOMBRE                  VARCHAR(100) NOT NULL,
    NUMERO                  INT          NOT NULL,
    ORDEN                   SMALLINT     NOT NULL DEFAULT 1,
    OBJETIVO                TEXT                  DEFAULT NULL,
    INSTRUCCIONES           TEXT                  DEFAULT NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_SECCION
    ADD CONSTRAINT PRK_SECCION_CAT_SECCION PRIMARY KEY (PK_SECCION ASC);
ALTER TABLE CAT_SECCION
    ADD CONSTRAINT FRK_ENCUESTA_CAT_SECCION FOREIGN KEY (FK_ENCUESTA) REFERENCES CAT_ENCUESTA (PK_ENCUESTA)
/* FIN TABLA PARA SECCIONES */

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE TIPOS DE PREGUNTA ******** *
 * *************************************************** */

/* INICIO TABLA PARA TIPOS DE PREGUNTA */
CREATE TABLE CAT_TIPO_PREGUNTA
(
    PK_TIPO_PREGUNTA        INT          NOT NULL IDENTITY (1,1),

    NOMBRE_TIPO_PREGUNTA    VARCHAR(100) NOT NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_TIPO_PREGUNTA
    ADD CONSTRAINT PRK_TIPO_PREGUNTA_CAT_TIPO_PREGUNTA PRIMARY KEY (PK_TIPO_PREGUNTA ASC);
/* FIN TABLA PARA TIPOS DE PREGUNTA */

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE PREGUNTAS ******** *
 * *************************************************** */

/* INICIO TABLA PARA PREGUNTAS */
CREATE TABLE CAT_PREGUNTA
(
    PK_PREGUNTA             INT          NOT NULL IDENTITY (1,1),
    FK_TIPO_PREGUNTA        INT,
    FK_SECCION              INT,

    ORDEN                   INT          NOT NULL,
    PLANTEAMIENTO           VARCHAR(300) NOT NULL,
    TEXTO_GUIA              VARCHAR(100) NOT NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_PREGUNTA
    ADD CONSTRAINT PRK_PREGUNTA_CAT_PREGUNTA PRIMARY KEY (PK_PREGUNTA ASC);
ALTER TABLE CAT_PREGUNTA
    ADD CONSTRAINT FRK_TIPO_PREGUNTA_CAT_PREGUNTA FOREIGN KEY (FK_TIPO_PREGUNTA) REFERENCES CAT_TIPO_PREGUNTA (PK_TIPO_PREGUNTA);
ALTER TABLE CAT_PREGUNTA
    ADD CONSTRAINT FRK_SECCION_CAT_PREGUNTA FOREIGN KEY (FK_SECCION) REFERENCES CAT_SECCION (PK_SECCION);
/* FIN TABLA PARA PREGUNTAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE POSIBLES RESPUESTAS ******** *
 * *************************************************** */

/* INICIO TABLA PARA POSIBLES RESPUESTAS */
CREATE TABLE CAT_RESPUESTA_POSIBLE
(
    PK_RESPUESTA_POSIBLE    INT      NOT NULL IDENTITY (1,1),
    FK_PREGUNTA             INT,

    RESPUESTA               NVARCHAR(255),
    VALOR_NUMERICO          INT               DEFAULT NULL,
    MINIMO                  INT               DEFAULT NULL,
    MAXIMO                  INT               DEFAULT NULL,
    ORDEN                   INT               DEFAULT 1,
    ESTADO                  SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE CAT_RESPUESTA_POSIBLE
    ADD CONSTRAINT PRK_RESPUESTA_POSIBLE_CAT_RESPUESTA_POSIBLE PRIMARY KEY (PK_RESPUESTA_POSIBLE ASC);
ALTER TABLE CAT_RESPUESTA_POSIBLE
    ADD CONSTRAINT FRK_PREGUNTA_CAT_RESPUESTA_POSIBLE FOREIGN KEY (FK_PREGUNTA) REFERENCES CAT_PREGUNTA (PK_PREGUNTA);
/* FIN TABLA PARA POSIBLES RESPUESTAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE APLICACIÓN ENCUESTAS ******** *
 * *************************************************** */

/* INICIO TABLA PARA APLICACIÓN DE ENCUESTAS */
CREATE TABLE TR_APLICACION_ENCUESTA
(
    PK_APLICACION_ENCUESTA  INT      NOT NULL IDENTITY (1,1),
    FK_USUARIO              INT,
    FK_ENCUESTA             INT,

    FECHA_APLICACION        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FECHA_RESPUESTA         DATETIME          DEFAULT NULL,
    ESTADO                  SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT PRK_APLICACION_ENCUESTA_TR_APLICACION_ENCUESTA PRIMARY KEY (PK_APLICACION_ENCUESTA ASC);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT FRK_USUARIO_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_USUARIO) REFERENCES CAT_USUARIO (PK_USUARIO);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT FRK_ENCUESTA_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_ENCUESTA) REFERENCES CAT_ENCUESTA (PK_ENCUESTA);
/* INICIO TABLA PARA APLICACIÓN DE ENCUESTAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE RESPUESTA DE ENCUESTAS ******** *
 * *************************************************** */

/* INICIO TABLA PARA RESPUESTA DE ENCUESTAS */
CREATE TABLE TR_RESPUESTA_USUARIO_ENCUESTA
(
    PK_RESPUESTA_USUARIO_ENCUESTA INT      NOT NULL IDENTITY (1,1),
    FK_RESPUESTA_POSIBLE          INT      NOT NULL,
    FK_APLICACION_ENCUESTA        INT      NOT NULL,

    RESPUESTA_ABIERTA             TEXT              DEFAULT NULL,
    ESTADO                        SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO           INT,
    FECHA_REGISTRO                DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION       INT,
    FECHA_MODIFICACION            DATETIME,
    BORRADO                       SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    ADD CONSTRAINT PRK_RESPUESTA_USUARIO_ENCUESTA_TR_RESPUESTA_USUARIO_ENCUESTA PRIMARY KEY (PK_RESPUESTA_USUARIO_ENCUESTA ASC);

ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    ADD CONSTRAINT FRK_RESPUESTA_POSIBLE_TR_RESPUESTA_USUARIO_ENCUESTA FOREIGN KEY (FK_RESPUESTA_POSIBLE) REFERENCES CAT_RESPUESTA_POSIBLE (PK_RESPUESTA_POSIBLE);

ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    ADD CONSTRAINT FRK_APLICACION_ENCUESTA_TR_RESPUESTA_USUARIO_ENCUESTA FOREIGN KEY (FK_APLICACION_ENCUESTA) REFERENCES TR_APLICACION_ENCUESTA (PK_APLICACION_ENCUESTA);

/* FIN TABLA PARA RESPUESTA DE ENCUESTAS */

/* *************************************************** *
 * ********** MODIFICACION DE TABLAS ******** *
 * *************************************************** */
ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    ADD ORDEN SMALLINT DEFAULT NULL;

ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    ADD RANGO SMALLINT DEFAULT NULL;

ALTER TABLE CAT_RESPUESTA_POSIBLE
    ADD ES_MIXTA SMALLINT DEFAULT 0;


/*********************  FIN MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019) *********************************/

-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------

/*********************  INICIO MODIFICACIONES VISTA DE TUTORES (25-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/

/* AGREGANDO PERIODO EN APLICACIÓN DE ENCUESTA */
ALTER TABLE TR_APLICACION_ENCUESTA
    ADD PERIODO NVARCHAR(5) NULL;

/* INICIO TABLA PARA GRUPO DE TUTORIAS */
CREATE TABLE TR_GRUPO_TUTORIA
(
    PK_GRUPO_TUTORIA        INT          NOT NULL IDENTITY (1,1),
    FK_CARRERA              INT          NOT NULL,
    FK_USUARIO              INT          NOT NULL,           -- ES EL TUTOR

    PERIODO                 NVARCHAR(5)  NOT NULL,
    CLAVE                   NVARCHAR(10) NOT NULL,
    TIPO_GRUPO              SMALLINT     NOT NULL, -- 1 PARA TUTORIA INICIAL, 2 PARA TUTORIA DE SEGUIMIENTO
    EVALUACION              SMALLINT     NOT NULL DEFAULT 0, -- CUANDO EL TUTOR EVALÚA AL GRUPO
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE TR_GRUPO_TUTORIA
    ADD CONSTRAINT PRK_GRUPO_TUTORIA_TR_GRUPO_TUTORIA PRIMARY KEY (PK_GRUPO_TUTORIA ASC);

ALTER TABLE TR_GRUPO_TUTORIA
    ADD CONSTRAINT FRK_CARRERA_TR_GRUPO_TUTORIA FOREIGN KEY (FK_CARRERA) REFERENCES CAT_CARRERA (PK_CARRERA);

ALTER TABLE TR_GRUPO_TUTORIA
    ADD CONSTRAINT FRK_USUARIO_TR_GRUPO_TUTORIA FOREIGN KEY (FK_USUARIO) REFERENCES CAT_USUARIO (PK_USUARIO);

/* FIN TABLA PARA GRUPO DE TUTORIAS */

/* INICIO TABLA PARA DETALLE GRUPO DE TUTORIAS */
CREATE TABLE TR_GRUPO_TUTORIA_DETALLE
(
    PK_GRUPO_TUTORIA_DETALLE        INT          NOT NULL IDENTITY (1,1),
    FK_GRUPO              INT          NOT NULL,
    FK_USUARIO              INT          NOT NULL,           -- ES CADA UNO DE LOS ALUMNOS

    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE TR_GRUPO_TUTORIA_DETALLE
    ADD CONSTRAINT PRK_GRUPO_TUTORIA_DETALLE_TR_GRUPO_TUTORIA_DETALLE PRIMARY KEY (PK_GRUPO_TUTORIA_DETALLE ASC);

ALTER TABLE TR_GRUPO_TUTORIA_DETALLE
    ADD CONSTRAINT FRK_GRUPO_TR_GRUPO_TUTORIA_DETALLE FOREIGN KEY (FK_GRUPO) REFERENCES TR_GRUPO_TUTORIA (PK_GRUPO_TUTORIA);

ALTER TABLE TR_GRUPO_TUTORIA_DETALLE
    ADD CONSTRAINT FRK_USUARIO_TR_GRUPO_TUTORIA_DETALLE FOREIGN KEY (FK_USUARIO) REFERENCES CAT_USUARIO (PK_USUARIO);

/* FIN TABLA PARA DETALLE GRUPO DE TUTORIAS */

/*********************  FIN INICIO MODIFICACIONES VISTA DE TUTORES (25-08-2019) *********************************/

-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------

/* CAMBIOS PARA ADMNISTRAR COORDINADORES DEPARTAMENTALES */
-- BUSCAR CONSTRAINT
ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    DROP CONSTRAINT DF__TR_RESPUE__RESPU__336AA144;

ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    ALTER COLUMN RESPUESTA_ABIERTA NVARCHAR(500) NULL;

-- Modulo de grupos del tutor
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Grupos', 1, 1, 'a20e50d69f0242136be5a392524da972', 'Lista de grupos del tutor', 'grupos_tutor');

-- actualización de modulo de grupos a tutor
UPDATE PER_TR_ROL_MODULO
SET FK_MODULO = 48
WHERE PK_ROL_MODULO = 2;

/* INICIO TABLA PARA COORDINADORES DE TUTORIAS */
CREATE TABLE TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
(
    PK_COORDINADOR          INT      NOT NULL IDENTITY (1,1),
    FK_USUARIO              INT      NOT NULL,
    FK_AREA_ACADEMICA       INT      NOT NULL,

    ESTADO                  SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
    ADD CONSTRAINT PRK_COORDINADOR_TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
        PRIMARY KEY (PK_COORDINADOR ASC);

ALTER TABLE TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
    ADD CONSTRAINT FRK_USUARIO_TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
        FOREIGN KEY (FK_USUARIO) REFERENCES CAT_USUARIO (PK_USUARIO);

ALTER TABLE TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
    ADD CONSTRAINT FRK_DEPARTAMENTO_TR_COORDINADOR_DEPARTAMENTAL_TUTORIA
        FOREIGN KEY (FK_AREA_ACADEMICA) REFERENCES CAT_AREA_ACADEMICA (PK_AREA_ACADEMICA);
/* FIN TABLA PARA COORDINADORES DE TUTORIAS */

-- REGISTRO DE ROLES
INSERT INTO PER_CAT_ROL(FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (1, 'Coordinador departamental', 'COORD_TUT');

INSERT INTO PER_CAT_ROL(FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (1, 'Coordinador institucional', 'COORI_TUT');

INSERT INTO PER_CAT_ROL(FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (1, 'Administrador', 'ADM_TUT');

-- REGISTRO DE MÓDULOS
INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)
VALUES ('Coordinadores institucionales', 1, 1);

INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)
VALUES ('Coordinadores departamentales', 1, 1);

INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)
VALUES ('Datos tutor', 1, 1);

INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)
VALUES ('Usuarios', 1, 1);

INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)
VALUES ('Horario', 1, 3);

INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)
VALUES ('Seguimiento académico', '', 1, 4);

INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)
VALUES ('Grupos SIIA', 1, 1);

-- ASIGNACIÓN DE MÓDULOS A ROLES
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'EST_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Datos tutor'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'EST_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Horario'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'EST_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Seguimiento académico'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Grupos'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORI_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Grupos'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores institucionales'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Usuarios'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores departamentales'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Grupos SIIA'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORI_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores departamentales'));


/* ************************ *
    * PRODUCCIÓN: PENDIENTE *
 * ************************ */
UPDATE PER_CAT_SISTEMA
SET NOMBRE = 'Tutorías'
WHERE NOMBRE = 'tutorias';

UPDATE PER_CAT_MODULO
SET NOMBRE = 'Grupos actuales'
WHERE NOMBRE = 'Grupos';

-- MÓDULO DE HISTÓRICO DE GRUPOS DE UN TUTOR
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA, RUTA_MD5, DESCRIPCION)
VALUES ('Histórico grupos', 2, 'historico_grupos_tutor', 'e150022cbe6813b2d7efe161c9641e93',
        'Histórico de grupos de un tutor');

-- -----------------------------------------
-- CAMBIOS PARA MÓDULO DE JORNDAS --
-- -----------------------------------------

/* INICIO TABLA PARA JORNADAS */
CREATE TABLE CAT_JORNADA
(
    PK_JORNADA              INT          NOT NULL IDENTITY (1,1),

    TEMA                    VARCHAR(100) NOT NULL,
    FECHA                   DATE         NOT NULL,
    LUGAR                   VARCHAR(30)  NOT NULL,
    DESCRIPCION             TEXT         NOT NULL,
    NOMBRE_EXPOSITOR        VARCHAR(50)  NOT NULL,
    CURRICULUM_EXPOSITOR    TEXT         NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_JORNADA
    ADD CONSTRAINT PRK_JORNADA_CAT_JORNADA PRIMARY KEY (PK_JORNADA ASC);
/* FIN TABLA PARA JORNADAS */


-- ELIMINAR RELACIÓN DE MÓDULOS DEL COORDINADOR DEPARTAMENTAL
DELETE
FROM PER_TR_ROL_MODULO
WHERE FK_ROL = (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Tutoría inicial',
        1,
        'a37ecf663279036431a24c6d58f78618',
        'Módulo para la visualización de los grupos de tutoría inicial del coordinador departamental',
        'tinicial_coordinador_departamental');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Tutoría seguimiento',
        2,
        '4bf2cf43829cc6001200347fff5b9e1a',
        'Módulo para la visualización de los grupos de tutoría de seguimiento del coordinador departamental',
        'tseguimiento_coordinador_departamental');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Histórico tutoría inicial',
        3,
        'cd626195c52adf7f302eac9836d4d5dc',
        'Módulo para la visualización del histórico de grupos de tutoría inicial del coord departamental',
        'historico_tinicial_coord_departamental');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Histórico tutoría seguimiento',
        4,
        '603c63398cb3fb82ce405fbb720fe7de',
        'Módulo para la visualización del histórico de grupos de tutoría de seguimiento del coord dep',
        'historico_tseguimiento_coord_departamental');

-- MÓDULO DE REPORTES DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Reportes tutoría inicial',
        5,
        '82687bd5bee7e0cd367ff7ddec297ac0',
        'Módulo para la visualización de reportes de tutoría inicial coord dep',
        'reportes_inicial_coord');

-- MÓDULO DE REPORTES DE TUTORÍA DESEGUIMIENTO PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Reportes tutoría seguimiento',
        6,
        '93f328174fb172ff87b73ac9c14fef4e',
        'Módulo para la visualización de reportes de tutoría de seguimiento coord dep',
        'reportes_seguimiento_coord');

-- ASIGNACIÓN DE ROLES A MÓDULO
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'tinicial_coordinador_departamental')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'tseguimiento_coordinador_departamental')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'historico_tinicial_coord_departamental')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'historico_tseguimiento_coord_departamental')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reportes_inicial_coord')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reportes_seguimiento_coord'));


-- ----------------------------------------------------------------------------------------
-- ELIMINAR RELACIÓN DE MÓDULOS DEL ADMINISTRADOR
DELETE
FROM PER_TR_ROL_MODULO
WHERE FK_ROL = (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Tutoría inicial',
        1,
        '4781291c6bd5fdb69af66b8b5bdce033',
        'Módulo para la visualización de los grupos de tutoría inicial del admin',
        'grupos_inicial_admin');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Tutoría seguimiento',
        2,
        '45df774b0e447feee7fc7ecc8fad8e5d',
        'Módulo para la visualización de los grupos de tutoría de seguimiento del admin',
        'grupos_seguimiento_admin');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Histórico tutoría inicial',
        3,
        '3eed5738a17a74792e51c20f5e15813d',
        'Módulo para la visualización del histórico de grupos de tutoría inicial del admin',
        'historico_inicial_admin');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Histórico tutoría seguimiento',
        4,
        '1543755fc7d55ceff9d0a28b32033f77',
        'Módulo para la visualización del histórico de grupos de tutoría de seguimiento del admin',
        'historico_seguimiento_admin');

-- MÓDULO DE REPORTES DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Reportes tutoría inicial',
        5,
        'cbecad3686494a55dbb615d46ef33dfc',
        'Módulo para la visualización de reportes de tutoría inicial admin',
        'reportes_inicial_admin');

-- MÓDULO DE REPORTES DE TUTORÍA DESEGUIMIENTO PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Reportes tutoría seguimiento',
        6,
        '8544a570296451efd329440be0762caf',
        'Módulo para la visualización de reportes de tutoría de seguimiento admin',
        'reportes_seguimiento_admin');

-- ASIGNACIÓN DE ROLES A MÓDULO
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_admin')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'historico_inicial_admin')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'historico_seguimiento_admin')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reportes_inicial_admin')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reportes_seguimiento_admin')),
       ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reportes_seguimiento_admin'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores institucionales'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Usuarios'));

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
        (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores departamentales'));

/* ******************************************** *
 * ****** CAMBIOS EN APLICACIÓN DE ENCUESTAS ** *
 * ******************************************** */
DROP TABLE IF EXISTS CAT_TIPO_APLICACION_ENCUESTA;
CREATE TABLE CAT_TIPO_APLICACION_ENCUESTA
(
    PK_TIPO_APLICACION      INT         NOT NULL IDENTITY (1,1),
    NOMBRE                  VARCHAR(50) NOT NULL,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT    NOT NULL DEFAULT 0
);

ALTER TABLE CAT_TIPO_APLICACION_ENCUESTA
    ADD CONSTRAINT PRK_TIPO_APLICACION_CAT_TIPO_APLICACION_ENCUESTA
        PRIMARY KEY (PK_TIPO_APLICACION ASC);

INSERT INTO CAT_TIPO_APLICACION_ENCUESTA (NOMBRE)
VALUES ('Institucional'),
       ('Por carrera'),
       ('Por semestre'),
       ('Por grupo'),
       ('Individual');

/* TABLA PARA APLICACIÓN DE ENCUESTAS */
CREATE TABLE TR_APLICACION_ENCUESTAS
(
    PK_APLICACION           INT        NOT NULL IDENTITY (1,1),

    FK_TIPO_APLICACION      INT        NULL,
    FK_ENCUESTA             INT        NULL,
    FK_CARRERA              INT        NULL,
    FK_USUARIO              INT        NULL,
    SEMESTRE                INT        NULL,
    FECHA_APLICACION        DATE       NOT NULL,
    PERIODO                 VARCHAR(5) NOT NULL,
    ESTADO                  SMALLINT   NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT   NOT NULL DEFAULT 0
);

ALTER TABLE TR_APLICACION_ENCUESTAS
    ADD CONSTRAINT PRK_APLICACION_ENCUESTA_TR_APLICACION_ENCUESTA
        PRIMARY KEY (PK_APLICACION ASC);

ALTER TABLE TR_APLICACION_ENCUESTAS
    ADD CONSTRAINT FRK_TIPO_APLICACION_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_TIPO_APLICACION)
        REFERENCES CAT_TIPO_APLICACION_ENCUESTA (PK_TIPO_APLICACION);

ALTER TABLE TR_APLICACION_ENCUESTAS
    ADD CONSTRAINT FRK_ENCUESTA_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_ENCUESTA)
        REFERENCES CAT_ENCUESTA (PK_ENCUESTA);

ALTER TABLE TR_APLICACION_ENCUESTAS
    ADD CONSTRAINT FRK_CARRERA_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_CARRERA)
        REFERENCES CAT_CARRERA (PK_CARRERA);

ALTER TABLE TR_APLICACION_ENCUESTAS
    ADD CONSTRAINT FRK_USUARIO_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_USUARIO)
        REFERENCES CAT_USUARIO (PK_USUARIO);
/* TABLA PARA APLICACION DE ENCUESTAS */

/* MODIFICAR NOMBRE DE TR_APLICACION_ENCUESTA POR TR_APLICACION_ENCUESTA_DETALLE */
EXEC sp_rename 'TR_APLICACION_ENCUESTA', TR_APLICACION_ENCUESTA_DETALLE, 'OBJECT';

/* MODIFICAR NOMBRE DE TR_APLICACION_ENCUESTAS POR TR_APLICACION_ENCUESTA */
EXEC sp_rename 'TR_APLICACION_ENCUESTAS', TR_APLICACION_ENCUESTA, 'OBJECT';

ALTER TABLE TR_APLICACION_ENCUESTA
    ALTER COLUMN FECHA_APLICACION DATE NOT NULL;

/* CREAR INSERTS DE APLICACION DE ENCUESTA INICIALES */
INSERT INTO TR_APLICACION_ENCUESTA(FK_TIPO_APLICACION, FK_ENCUESTA, SEMESTRE, FECHA_APLICACION, PERIODO)
VALUES (3, 1, 1, '2019-08-14', 20192),
       (3, 2, 1, '2019-08-14', 20192),
       (3, 3, 1, '2019-08-14', 20192),
       (3, 6, 1, '2019-08-14', 20192),
       (3, 4, 1, '2019-08-15', 20192),
       (3, 5, 1, '2019-08-15', 20192),
       (3, 8, 1, '2019-08-15', 20192);

/* MODIFICAR TABLA TR_APLICACION_ENCUESTA_DETALLE */
EXEC sp_rename 'TR_APLICACION_ENCUESTA_DETALLE.PK_APLICACION_ENCUESTA', PK_APLICACION_ENCUESTA_DETALLE, 'COLUMN';

/* AGREGAR COLUMNA DE APLICACIÓN A TR_APLICACION_ENCUESTA_DETALLE */
ALTER TABLE TR_APLICACION_ENCUESTA_DETALLE
    ADD FK_APLICACION_ENCUESTA INT;

ALTER TABLE TR_APLICACION_ENCUESTA_DETALLE
    ADD CONSTRAINT FRK_APLICACION_ENCUESTA_TR_APLICACION_ENCUESTA_DETALLE FOREIGN KEY (FK_APLICACION_ENCUESTA)
        REFERENCES TR_APLICACION_ENCUESTA (PK_APLICACION);

/* AGREGAR RELACIÓN DE APLICACIÓN A TR_APLICACION_ENCUESTA_DETALLE */
UPDATE TR_APLICACION_ENCUESTA_DETALLE
SET TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA = (
    SELECT TR_APLICACION_ENCUESTA.PK_APLICACION
    FROM TR_APLICACION_ENCUESTA
    WHERE TR_APLICACION_ENCUESTA.FK_ENCUESTA = 1
)
WHERE TR_APLICACION_ENCUESTA_DETALLE.FK_ENCUESTA = 1;
;

UPDATE TR_APLICACION_ENCUESTA_DETALLE
SET TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA = (
    SELECT TR_APLICACION_ENCUESTA.PK_APLICACION
    FROM TR_APLICACION_ENCUESTA
    WHERE TR_APLICACION_ENCUESTA.FK_ENCUESTA = 2
)
WHERE TR_APLICACION_ENCUESTA_DETALLE.FK_ENCUESTA = 2;
;

UPDATE TR_APLICACION_ENCUESTA_DETALLE
SET TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA = (
    SELECT TR_APLICACION_ENCUESTA.PK_APLICACION
    FROM TR_APLICACION_ENCUESTA
    WHERE TR_APLICACION_ENCUESTA.FK_ENCUESTA = 3
)
WHERE TR_APLICACION_ENCUESTA_DETALLE.FK_ENCUESTA = 3;
;

UPDATE TR_APLICACION_ENCUESTA_DETALLE
SET TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA = (
    SELECT TR_APLICACION_ENCUESTA.PK_APLICACION
    FROM TR_APLICACION_ENCUESTA
    WHERE TR_APLICACION_ENCUESTA.FK_ENCUESTA = 4
)
WHERE TR_APLICACION_ENCUESTA_DETALLE.FK_ENCUESTA = 4;
;

UPDATE TR_APLICACION_ENCUESTA_DETALLE
SET TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA = (
    SELECT TR_APLICACION_ENCUESTA.PK_APLICACION
    FROM TR_APLICACION_ENCUESTA
    WHERE TR_APLICACION_ENCUESTA.FK_ENCUESTA = 5
)
WHERE TR_APLICACION_ENCUESTA_DETALLE.FK_ENCUESTA = 5;
;

UPDATE TR_APLICACION_ENCUESTA_DETALLE
SET TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA = (
    SELECT TR_APLICACION_ENCUESTA.PK_APLICACION
    FROM TR_APLICACION_ENCUESTA
    WHERE TR_APLICACION_ENCUESTA.FK_ENCUESTA = 6
)
WHERE TR_APLICACION_ENCUESTA_DETALLE.FK_ENCUESTA = 6;
;

UPDATE TR_APLICACION_ENCUESTA_DETALLE
SET TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA = (
    SELECT TR_APLICACION_ENCUESTA.PK_APLICACION
    FROM TR_APLICACION_ENCUESTA
    WHERE TR_APLICACION_ENCUESTA.FK_ENCUESTA = 8
)
WHERE TR_APLICACION_ENCUESTA_DETALLE.FK_ENCUESTA = 8;
;

/* ELIMINAR COLUMNA FK_ENCUESTA DE TR_APLICACION_ENCUESTA_DETALLE
   BUSCAR CONSTRAINTS
*/
ALTER TABLE TR_APLICACION_ENCUESTA_DETALLE
    DROP COLUMN FK_ENCUESTA;

/* ELIMINAR COLUMNA FECHA_APLICACION DE TR_APLICACION_ENCUESTA_DETALLE
   BUSCAR CONSTRAINTS
*/
ALTER TABLE TR_APLICACION_ENCUESTA_DETALLE
    DROP COLUMN FECHA_APLICACION;

/* ELIMINAR COLUMNA PERIODO DE TR_APLICACION_ENCUESTA_DETALLE
*/
ALTER TABLE TR_APLICACION_ENCUESTA_DETALLE
    DROP COLUMN PERIODO;

/* RENOMBRAR FK EN RESPUESTA */
EXEC sp_rename 'TR_RESPUESTA_USUARIO_ENCUESTA.FK_APLICACION_ENCUESTA', FK_APLICACION_ENCUESTA_DETALLE, 'COLUMN';

/* PONER COMO NULL EL TUTOR EN LA TABLA GRUPO TUTORÍA*/
ALTER TABLE TR_GRUPO_TUTORIA
    ALTER COLUMN FK_USUARIO INT NULL;

/* AGREGAR COLUMNA DE SISTEMA A CAT_ENCUESTA */
ALTER TABLE CAT_ENCUESTA
    ADD FK_SISTEMA INT;

ALTER TABLE CAT_ENCUESTA
    ADD CONSTRAINT FRK_SISTEMA_CAT_ENCUESTA FOREIGN KEY (FK_SISTEMA)
        REFERENCES PER_CAT_SISTEMA (PK_SISTEMA);

/* AGREGAR FK_SISTEMA TUTORIA A LAS ENCUESTAS */
UPDATE CAT_ENCUESTA
SET FK_SISTEMA = 1;

/*
 * INVITACION A CONFERENCIAS
 */
/* TABLA PARA INVITACION DE CONFERENCIAS */
CREATE TABLE TR_INVITACION_CONFERENCIA
(
    PK_INVITACION           INT      NOT NULL IDENTITY (1,1),
    FK_JORNADA              INT      NOT NULL,
    FK_CARRERA              INT      NULL,

    TIPO_INVITACION         INT      NOT NULL,
    SEMESTRE                INT      NULL,
    FECHA_INVITACION        DATE     NOT NULL,
    ESTADO                  SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_INVITACION_CONFERENCIA
    ADD CONSTRAINT PRK_INVITACION_TR_INVITACION_CONFERENCIA
        PRIMARY KEY (PK_INVITACION ASC);

ALTER TABLE TR_INVITACION_CONFERENCIA
    ADD CONSTRAINT FRK_JORNADA_TR_INVITACION_CONFERENCIA FOREIGN KEY (FK_JORNADA)
        REFERENCES CAT_JORNADA (PK_JORNADA);

ALTER TABLE TR_INVITACION_CONFERENCIA
    ADD CONSTRAINT FRK_CARRERA_TR_INVITACION_CONFERENCIA FOREIGN KEY (FK_CARRERA)
        REFERENCES CAT_ENCUESTA (PK_ENCUESTA);
/* TABLA PARA INVITACION DE CONFERENCIAS */

/* TABLA PARA DETALLE DE INVITACION A CONFERENCIAS */
CREATE TABLE TR_INVITACION_CONFERENCIA_DETALLE
(
    PK_DETALLE                  INT      NOT NULL IDENTITY (1,1),
    FK_INVITACION               INT      NOT NULL,
    FK_USUARIO                  INT      NOT NULL,

    HORA_ENTRADA                TIME              DEFAULT NULL,
    HORA_SALIDA                 TIME              DEFAULT NULL,
    -- 1 PENDIENTE, 2 - ENTRADA, 3 - COMPLETA, 4 JUSTIFICADA
    ASISTENCIA                  INT               DEFAULT 1,
    OBSERVACIONES_JUSTIFICACION TEXT              DEFAULT NULL,
    ESTADO                      SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO         INT,
    FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION     INT,
    FECHA_MODIFICACION          DATETIME,
    BORRADO                     SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_INVITACION_CONFERENCIA_DETALLE
    ADD CONSTRAINT PRK_DETALLE_TR_INVITACION_CONFERENCIA_DETALLE
        PRIMARY KEY (PK_DETALLE ASC);

ALTER TABLE TR_INVITACION_CONFERENCIA_DETALLE
    ADD CONSTRAINT FRK_INVITACION_TR_INVITACION_CONFERENCIA_DETALLE FOREIGN KEY (FK_INVITACION)
        REFERENCES TR_INVITACION_CONFERENCIA (PK_INVITACION);

ALTER TABLE TR_INVITACION_CONFERENCIA_DETALLE
    ADD CONSTRAINT FRK_USUARIO_TR_INVITACION_CONFERENCIA_DETALLE FOREIGN KEY (FK_USUARIO)
        REFERENCES CAT_USUARIO (PK_USUARIO);
/* TABLA PARA DETALLE DE INVITACION A CONFERENCIAS */

/* TABLA PARA CAPTURISTAS DE CONFERENCIAS */
CREATE TABLE TR_CAPTURISTA_CONFERENCIA
(
    PK_CAPTURISTA           INT      NOT NULL IDENTITY (1,1),
    FK_JORNADA              INT      NOT NULL,
    FK_USUARIO              INT      NULL,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_CAPTURISTA_CONFERENCIA
    ADD CONSTRAINT PRK_CAPTURISTA_TR_CAPTURISTA_CONFERENCIA
        PRIMARY KEY (PK_CAPTURISTA ASC);

ALTER TABLE TR_CAPTURISTA_CONFERENCIA
    ADD CONSTRAINT FRK_JORNADA_TR_CAPTURISTA_CONFERENCIA FOREIGN KEY (FK_JORNADA)
        REFERENCES CAT_JORNADA (PK_JORNADA);

ALTER TABLE TR_CAPTURISTA_CONFERENCIA
    ADD CONSTRAINT FRK_USUARIO_TR_CAPTURISTA_CONFERENCIA FOREIGN KEY (FK_USUARIO)
        REFERENCES CAT_USUARIO (PK_USUARIO);
/* TABLA PARA CAPTURISTAS DE CONFERENCIAS */


-- CAMBIAR NOMBRE DE COLUMNA
EXEC sp_rename 'PRK_APLICACION_ENCUESTA_TR_APLICACION_ENCUESTA', PRK_APLICACION_ENCUESTA_DETALLE_TR_APLICACION_ENCUESTA_DETALLE, 'OBJECT';

--
exec sp_rename 'FRK_USUARIO_TR_APLICACION_ENCUESTA', FRK_USUARIO_TR_APLICACION_ENCUESTA_DETALLE, 'OBJECT';

