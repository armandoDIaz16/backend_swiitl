/*********************  INICIO MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/


/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE CAPACITACION DOCENTE ******** *
 * *************************************************** */


/* INICIO TABLA PARA ESTADOS DEL PERIODO */
/*CREATE TABLE CF_ESTADOS_PERIODO(
    PK_VALOR INT NOT NULL,
    DESCRIPCION    VARCHAR(100),
    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);
ALTER TABLE CF_ESTADOS_PERIODO
    ADD CONSTRAINT PRK_VALOR_CF_ESTADOS_PERIODO PRIMARY KEY (PK_VALOR ASC);


INSERT INTO CF_ESTADOS_PERIODO(PK_VALOR, DESCRIPCION)
VALUES(0, 'TERMINADO' )
VALUES(1, 'EN CURSO' )
VALUES(1, 'EN CURSO' );*/
/* FIN TABLA PARA ESTADOS DEL PERIODO */

/* INICIO TABLA PARA PERIODOS */
CREATE TABLE CAT_PERIODO_CADO(
    PK_PERIODO_CADO        INT  NOT NULL IDENTITY (1,1),
    NOMBRE_PERIODO        VARCHAR(100) NOT NULL,
    FECHA_INICIO          DATETIME NOT NULL,
    FECHA_FIN             DATETIME NOT NULL,
        -- DEFAULT IN ALL TABLES ------>
    -- ESTADO                  SMALLINT     NOT NULL DEFAULT 1,
    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);
ALTER TABLE CAT_PERIODO_CADO
    ADD CONSTRAINT PRK_PERIODO_CADO_CAT_PERIODO_CADO PRIMARY KEY (PK_PERIODO_CADO ASC);
    -- ADD CONSTRAINT FRK_CAT_PERIODO_CADO_CF_ESTADOS_PERIODO FOREIGN KEY (FK_USUARIO_REGISTRO) REFERENCES CF_ESTADOS_PERIODO(PK_VALOR);
/* FIN TABLA PARA PERIODOS */


/* INICIO TABLA PARA CURSOS */
CREATE TABLE CAT_PERIODO_CADO(
    PK_PERIODO_CADO        INT  NOT NULL IDENTITY (1,1),
    NOMBRE_PERIODO        VARCHAR(100) NOT NULL,
    FECHA_INICIO          DATETIME NOT NULL,
    FECHA_FIN             DATETIME NOT NULL,
        -- DEFAULT IN ALL TABLES ------>
    -- ESTADO                  SMALLINT     NOT NULL DEFAULT 1,
    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);
ALTER TABLE CAT_PERIODO_CADO
    ADD CONSTRAINT PRK_PERIODO_CADO_CAT_PERIODO_CADO PRIMARY KEY (PK_PERIODO_CADO ASC);
    -- ADD CONSTRAINT FRK_CAT_PERIODO_CADO_CF_ESTADOS_PERIODO FOREIGN KEY (FK_USUARIO_REGISTRO) REFERENCES CF_ESTADOS_PERIODO(PK_VALOR);
/* FIN TABLA PARA CURSOS */



/*************************************************** *
 * ********** FINALIZA LA CREACIÓN DE TABLAS DE CAPACITACION DOCENTE ******** *
 * *************************************************** */
-- INICIA CREACION DE TABLA CURSOS
CREATE TABLE CAT_CURSO_CADO(
    PK_CURSO_CADO        INT  NOT NULL IDENTITY (1,1),

    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,
    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);
ALTER TABLE CAT_CURSO_CADO
    ADD CONSTRAINT PrK_CURSO_CADO_CAT_CURSO_CADO PRIMARY KEY (PK_CURSO_CADO ASC);
-- TEMINA CREACION DE TABLA DE CURSOS



/******************************************************************************************************* *
 * ********** COMIENZA LA CREACIÓN DEL SISTEMA, LOS MODULOS Y ROLES DEL SISTEMA DE  CAPACITACION DOCENTE ******** *
 * ******************************************************************************************************************** */


-- CREACION DEL SISTEMA
INSERT INTO PER_CAT_SISTEMA(NOMBRE, RUTA_ANGULAR, ABREVIATURA, CORREO1, INDICIO1)
VALUES('Capacitación docente', 'capacitacion', 'CADO', 'cado@itleon.edu.mx', 'cado');

--select * from PER_CAT_SISTEMA;
--se debE asignar el FK_SISTEMA obtenido al realizar el insert anterior
INSERT INTO PER_CAT_ROL(FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (1, 'Coordinador', 'COORD_CADO');

INSERT INTO PER_CAT_ROL(FK_SISTEMA, NOMBRE, ABREVIATURA)
VALUES (1, 'Participante', 'PART_CADO');

--select * from PER_CAT_ROL;

--SE CREAN LOS MODULOS
--INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN)VALUES ('Periodos', 1, 1);
INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Periodos',1,1,  'e990c920d0d77fa0937fce0bc4e5a67b' ,  'Lista de periodos intersemestrales'
 ,  'periodos');
 INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Cursos',1,1,  'fdf484eeeb011a5fb52cf33751b4e22f' ,
  'Lista de Cursos de Capacitación' , 'cursos');
INSERT INTO PER_CAT_MODULO(NOMBRE, ESTADO, ORDEN, RUTA_MD5, DESCRIPCION, RUTA)
VALUES ('Captura cursos',1,1,  '7b44125ec5b3b7b61b000cdee93c6796' ,
  'Módulo de Captura' , 'captura_cursos');

--select * from PER_CAT_MODULO

--select * from CAT_USUARIO
-- EL ROL Y EL MODULO SE DEBEN RELACIONAR ACORDE A LAS PK OBTENIDAS CON LOS INSERTS ANTERIORES
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (1, 1);
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (1, 2);
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO)
VALUES (2, 2);
-- INSERT PARA ASIGNAR EL ROL AL USUARIO
--INSERT INTO PER_TR_ROL_USUARIO(FK_ROL, FK_USUARIO)
--VALUES (1, 1);

-- SELECT * FROM PER_TR_ROL_USUARIO


/******************************************************************************************************* *
 * ********** FINALIZA LA CREACIÓN DEL SISTEMA, LOS MODULOS Y ROLES DEL SISTEMA DE  CAPACITACION DOCENTE ******** *
 * ******************************************************************************************************************** */
