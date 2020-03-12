/* CAMBIOS PARA ADMNISTRAR COORDINADORES DEPARTAMENTALES */
-- BUSCAR CONSTRAINT
ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    DROP CONSTRAINT DF__TR_RESPUE__RESPU__336AA144;

ALTER TABLE TR_RESPUESTA_USUARIO_ENCUESTA
    ALTER COLUMN RESPUESTA_ABIERTA NVARCHAR(500) NULL
;

-- Modulo de grupos del tutor
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Grupos', 1, 1, 'a20e50d69f0242136be5a392524da972', 'Lista de grupos del tutor', 'grupos_tutor');

-- actualización de modulo de grupos a tutor
UPDATE PER_TR_ROL_MODULO SET FK_MODULO = 47 WHERE PK_ROL_MODULO = 2;

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
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'EST_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Datos tutor')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'EST_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Horario')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'EST_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Seguimiento académico')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Grupos')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORI_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Grupos')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores institucionales')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Usuarios')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores departamentales')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Grupos SIIA')
);

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
   (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORI_TUT'),
   (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores departamentales')
);


/* ************************ *
    * PRODUCCIÓN: PENDIENTE *
 * ************************ */

/* ASIGNACIÓN DE ROL A ADMINISTRADOR */
-- SIIA: 1501 NOMBRE: MARÍA ELENA	MARTINEZ	HERNÁNDEZ
INSERT INTO PER_TR_ROL_USUARIO(FK_ROL, FK_USUARIO)
VALUES (5, (SELECT PK_USUARIO FROM CAT_USUARIO WHERE NUMERO_CONTROL = '1501'));

UPDATE PER_CAT_SISTEMA SET NOMBRE = 'Tutorías' WHERE NOMBRE = 'tutorias';

UPDATE PER_CAT_MODULO SET NOMBRE = 'Grupos actuales' WHERE NOMBRE = 'Grupos';

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
DELETE FROM PER_TR_ROL_MODULO WHERE FK_ROL = (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'COORD_TUT');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Tutoría inicial',
                                                                                  1,
                                                                                  'a37ecf663279036431a24c6d58f78618',
                                                                                  'Módulo para la visualización de los grupos de tutoría inicial del coordinador departamental',
                                                                                  'tinicial_coordinador_departamental'
                                                                              );

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Tutoría seguimiento',
                                                                                  2,
                                                                                  '4bf2cf43829cc6001200347fff5b9e1a',
                                                                                  'Módulo para la visualización de los grupos de tutoría de seguimiento del coordinador departamental',
                                                                                  'tseguimiento_coordinador_departamental'
                                                                              );

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Histórico tutoría inicial',
                                                                                  3,
                                                                                  'cd626195c52adf7f302eac9836d4d5dc',
                                                                                  'Módulo para la visualización del histórico de grupos de tutoría inicial del coord departamental',
                                                                                  'historico_tinicial_coord_departamental'
                                                                              );

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Histórico tutoría seguimiento',
                                                                                  4,
                                                                                  '603c63398cb3fb82ce405fbb720fe7de',
                                                                                  'Módulo para la visualización del histórico de grupos de tutoría de seguimiento del coord dep',
                                                                                  'historico_tseguimiento_coord_departamental'
                                                                              );

-- MÓDULO DE REPORTES DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Reportes tutoría inicial',
                                                                                  5,
                                                                                  '82687bd5bee7e0cd367ff7ddec297ac0',
                                                                                  'Módulo para la visualización de reportes de tutoría inicial coord dep',
                                                                                  'reportes_inicial_coord'
                                                                              );

-- MÓDULO DE REPORTES DE TUTORÍA DESEGUIMIENTO PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Reportes tutoría seguimiento',
                                                                                  6,
                                                                                  '93f328174fb172ff87b73ac9c14fef4e',
                                                                                  'Módulo para la visualización de reportes de tutoría de seguimiento coord dep',
                                                                                  'reportes_seguimiento_coord'
                                                                              );

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
DELETE FROM PER_TR_ROL_MODULO WHERE FK_ROL = (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT');

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Tutoría inicial',
                                                                                  1,
                                                                                  '4781291c6bd5fdb69af66b8b5bdce033',
                                                                                  'Módulo para la visualización de los grupos de tutoría inicial del admin',
                                                                                  'grupos_inicial_admin'
                                                                              );

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Tutoría seguimiento',
                                                                                  2,
                                                                                  '45df774b0e447feee7fc7ecc8fad8e5d',
                                                                                  'Módulo para la visualización de los grupos de tutoría de seguimiento del admin',
                                                                                  'grupos_seguimiento_admin'
                                                                              );

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Histórico tutoría inicial',
                                                                                  3,
                                                                                  '3eed5738a17a74792e51c20f5e15813d',
                                                                                  'Módulo para la visualización del histórico de grupos de tutoría inicial del admin',
                                                                                  'historico_inicial_admin'
                                                                              );

-- MÓDULO DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Histórico tutoría seguimiento',
                                                                                  4,
                                                                                  '1543755fc7d55ceff9d0a28b32033f77',
                                                                                  'Módulo para la visualización del histórico de grupos de tutoría de seguimiento del admin',
                                                                                  'historico_seguimiento_admin'
                                                                              );

-- MÓDULO DE REPORTES DE TUTORÍA INICIAL PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Reportes tutoría inicial',
                                                                                  5,
                                                                                  'cbecad3686494a55dbb615d46ef33dfc',
                                                                                  'Módulo para la visualización de reportes de tutoría inicial admin',
                                                                                  'reportes_inicial_admin'
                                                                              );

-- MÓDULO DE REPORTES DE TUTORÍA DESEGUIMIENTO PARA COORDINADOR DEPARTAMENTAL
INSERT INTO PER_CAT_MODULO(NOMBRE, ORDEN, RUTA_MD5, DESCRIPCION, RUTA) VALUES (
                                                                                  'Reportes tutoría seguimiento',
                                                                                  6,
                                                                                  '8544a570296451efd329440be0762caf',
                                                                                  'Módulo para la visualización de reportes de tutoría de seguimiento admin',
                                                                                  'reportes_seguimiento_admin'
                                                                              );

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
VALUES (
           (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
           (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores institucionales')
       );

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
           (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
           (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Usuarios')
       );

INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (
           (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
           (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Coordinadores departamentales')
       );

/* ******************************************** *
 * ****** CAMBIOS EN APLICACIÓN DE ENCUESTAS ** *
 * ******************************************** */
/* Se crea la tabla que define los diferentes tipos de aplicación, 'CAT_TIPO_APLICACION' */
DROP TABLE IF EXISTS CAT_TIPO_APLICACION;
CREATE TABLE CAT_TIPO_APLICACION(
                                    PK_TIPO_APLICACION     INT             NOT NULL IDENTITY (1,1),
                                    NOMBRE                 VARCHAR(50)     NOT NULL
);

ALTER TABLE CAT_TIPO_APLICACION
    ADD CONSTRAINT PRK_TIPO_APLICACION_CAT_TIPO_APLICACION PRIMARY KEY (PK_TIPO_APLICACION ASC);

INSERT INTO CAT_TIPO_APLICACION (NOMBRE)
VALUES ('Institucional'), ('Carrera'), ('Semestre'), ('Grupo'), ('Individual');

SELECT * FROM CAT_TIPO_APLICACION;

/* Modificar 'TR_APLICACION_ENCUESTA' para hacer uso de 'CAT_APLICACION' */

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD FK_TIPO_APLICACION INT NULL;

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT FRK_TIPO_APLICACION_TR_APLICACION_ENCUESTA
        FOREIGN KEY (FK_TIPO_APLICACION) REFERENCES CAT_TIPO_APLICACION (PK_TIPO_APLICACION);

ALTER TABLE TR_APLICACION_ENCUESTA ADD APLICACION_SEMESTRE NVARCHAR(2) NULL;
ALTER TABLE TR_APLICACION_ENCUESTA ADD APLICACION_FK_CARRERA INT NULL;
ALTER TABLE TR_APLICACION_ENCUESTA ADD APLICACION_NUMERO_CONTROL INT NULL;

SELECT * FROM TR_APLICACION_ENCUESTA;

INSERT INTO TR_APLICACION_ENCUESTA(FK_USUARIO, FK_ENCUESTA, FK_TIPO_APLICACION, APLICACION_SEMESTRE, FECHA_APLICACION)
VALUES(1,1,3,9,GETDATE());


SELECT * FROM CAT_ENCUESTA

ALTER TABLE TR_APLICACION_ENCUESTA DROP COLUMN APLICACION_NUMERO_CONTROL;

UPDATE TR_APLICACION_ENCUESTA
SET FK_TIPO_APLICACION = 5
WHERE FK_TIPO_APLICACION IS NULL

SELECT * FROM CAT_USUARIO WHERE PK_USUARIO = 60;

DROP TABLE IF EXISTS RESPUESTA_ENCUESTA;
CREATE TABLE RESPUESTA_ENCUESTA(
    PK_RESPUESTA_ENCUESTA INT NOT NULL IDENTITY (1,1),
    FK_APLICACION INT,
    FK_USUARIO INT,
    FECHA_RESPUESTA DATETIME,
);

ALTER TABLE RESPUESTA_ENCUESTA
    ADD CONSTRAINT PRK_RESPUESTA_ENCUESTA_RESPUESTA_ENCUESTA PRIMARY KEY (PK_RESPUESTA_ENCUESTA ASC);

ALTER TABLE RESPUESTA_ENCUESTA
    ADD CONSTRAINT FRK_APLICACION_RESPUESTA_ENCUESTA
        FOREIGN KEY (FK_APLICACION) REFERENCES TR_APLICACION_ENCUESTA(PK_APLICACION_ENCUESTA);

ALTER TABLE RESPUESTA_ENCUESTA
    ADD CONSTRAINT FRK_USUARIO_RESPUESTA_ENCUESTA
        FOREIGN KEY (FK_USUARIO) REFERENCES CAT_USUARIO(PK_USUARIO);




/* ********************************************** *
 * * MODIFIACIONES PARA APLICACIÓN DE ENCUESTAS * *
 * ********************************************** */
/* TABLA PARA APLICACIÓN DE ENCUESTAS */
CREATE TABLE TR_APLICACION_ENCUESTA
(
    PK_APLICACION_ENCUESTA  INT        NOT NULL IDENTITY (1,1),

    FK_TIPO_APLICACION      INT        NULL,
    FK_ENCUESTA             INT        NULL,
    FK_CARRERA              INT        NULL,
    FK_USUARIO              INT        NULL,
    SEMESTRE                INT        NULL,
    FECHA_APLICACION        DATETIME   NOT NULL,
    PERIODO                 VARCHAR(5) NOT NULL,
    ESTADO                  SMALLINT   NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT   NOT NULL DEFAULT 0
);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT PRK_APLICACION_ENCUESTA_TR_APLICACION_ENCUESTA PRIMARY KEY (PK_APLICACION_ENCUESTA ASC);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT FRK_TIPO_APLICACION_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_TIPO_APLICACION)
        REFERENCES CAT_TIPO_APLICACION (PK_TIPO_APLICACION);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT FRK_ENCUESTA_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_ENCUESTA)
        REFERENCES CAT_ENCUESTA (PK_ENCUESTA);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT FRK_CARRERA_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_CARRERA)
        REFERENCES CAT_CARRERA (PK_CARRERA);

ALTER TABLE TR_APLICACION_ENCUESTA
    ADD CONSTRAINT FRK_USUARIO_TR_APLICACION_ENCUESTA FOREIGN KEY (FK_USUARIO)
        REFERENCES CAT_USUARIO (PK_USUARIO);
/* TABLA PARA APLICACION DE ENCUESTAS */

/* TABLA PARA RESPUESTAS DE ENCUESTAS */
CREATE TABLE TR_RESPUESTA_ENCUESTA
(
    PK_RESPUESTA            INT      NOT NULL IDENTITY (1,1),

    FK_APLICACION_ENCUESTA  INT      NULL,
    FK_USUARIO              INT      NULL,
    FECHA_RESPUESTA         DATETIME NOT NULL,
    ESTADO                  SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_RESPUESTA_ENCUESTA
    ADD CONSTRAINT PRK_RESPUESTA_TR_RESPUESTA_ENCUESTA PRIMARY KEY (PK_RESPUESTA ASC);

ALTER TABLE TR_RESPUESTA_ENCUESTA
    ADD CONSTRAINT FRK_APLICACION_ENCUESTA_TR_RESPUESTA_ENCUESTA FOREIGN KEY (FK_APLICACION_ENCUESTA)
        REFERENCES TR_APLICACION_ENCUESTA (PK_APLICACION_ENCUESTA);

ALTER TABLE TR_RESPUESTA_ENCUESTA
    ADD CONSTRAINT FRK_USUARIO_TR_RESPUESTA_ENCUESTA FOREIGN KEY (FK_USUARIO)
        REFERENCES CAT_USUARIO (PK_USUARIO);
/* TABLA PARA RESPUESTAS DE ENCUESTAS */

/* TABLA PARA DETALLE DE RESPUESTAS DE ENCUESTAS */
CREATE TABLE TR_RESPUESTA_ENCUESTA_DETALLE
(
    PK_RESPUESTA_DETALLE    INT      NOT NULL IDENTITY (1,1),

    FK_RESPUESTA            INT      NULL,
    FK_RESPUESTA_POSIBLE    INT      NULL,

    RESPUESTA_ABIERTA       TEXT              DEFAULT NULL,
    ORDEN                   SMALLINT          DEFAULT NULL,
    RANGO                   SMALLINT          DEFAULT NULL,
    ESTADO                  SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_RESPUESTA_ENCUESTA_DETALLE
    ADD CONSTRAINT PRK_RESPUESTA_DETALLE_TR_RESPUESTA_ENCUESTA_DETALLE PRIMARY KEY (PK_RESPUESTA_DETALLE ASC);

ALTER TABLE TR_RESPUESTA_ENCUESTA_DETALLE
    ADD CONSTRAINT FRK_RESPUESTA_TR_RESPUESTA_ENCUESTA_DETALLE FOREIGN KEY (FK_RESPUESTA)
        REFERENCES TR_APLICACION_ENCUESTA (PK_APLICACION_ENCUESTA);

ALTER TABLE TR_RESPUESTA_ENCUESTA_DETALLE
    ADD CONSTRAINT FK_RESPUESTA_POSIBLE_TR_RESPUESTA_ENCUESTA_DETALLE FOREIGN KEY (FK_RESPUESTA_POSIBLE)
        REFERENCES CAT_RESPUESTA_POSIBLE (PK_RESPUESTA_POSIBLE);
/* TABLA PARA DETALLE DE RESPUESTAS DE ENCUESTAS */

ALTER TABLE TR_GRUPO_TUTORIA ALTER COLUMN FK_USUARIO INT NULL;
