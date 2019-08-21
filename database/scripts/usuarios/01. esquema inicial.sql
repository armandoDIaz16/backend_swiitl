use SWIITL;

/*********************  INICIO MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
*/

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE PAISES ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_PAIS;
CREATE TABLE CAT_PAIS
(
    PK_PAIS                 INT           NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ALIAS                   NVARCHAR(100)          DEFAULT NULL,
    NUMERO                  INT                    DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_PAIS
    ADD CONSTRAINT PRK_PAIS_CAT_PAIS PRIMARY KEY (PK_PAIS ASC);
/* FIN TABLA PAISES */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE ENTIDADES FEDERATIVAS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_ENTIDAD_FEDERATIVA;
CREATE TABLE CAT_ENTIDAD_FEDERATIVA
(
    PK_ENTIDAD_FEDERATIVA   INT           NOT NULL IDENTITY (1,1),
    FK_PAIS                 INT           NOT NULL,

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ALIAS                   NVARCHAR(100)          DEFAULT NULL,
    NUMERO                  INT                    DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_ENTIDAD_FEDERATIVA
    ADD CONSTRAINT PRK_ENTIDAD_FEDERATIVA_CAT_ENTIDAD_FEDERATIVA PRIMARY KEY (PK_ENTIDAD_FEDERATIVA ASC);

ALTER TABLE CAT_ENTIDAD_FEDERATIVA
    ADD CONSTRAINT FRK_PAIS_CAT_ENTIDAD_FEDERATIVA FOREIGN KEY (FK_PAIS) REFERENCES CAT_PAIS (PK_PAIS);
/* FIN TABLA ENTIDADES FEDERATIVAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE CIUDADES ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_CIUDAD;
CREATE TABLE CAT_CIUDAD
(
    PK_CIUDAD               INT           NOT NULL IDENTITY (1,1),
    FK_ENTIDAD_FEDERATIVA   INT           NOT NULL,

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ALIAS                   NVARCHAR(100)          DEFAULT NULL,
    NUMERO                  INT                    DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_CIUDAD
    ADD CONSTRAINT PRK_CIUDAD_CAT_CIUDAD PRIMARY KEY (PK_CIUDAD ASC);

ALTER TABLE CAT_CIUDAD
    ADD CONSTRAINT FRK_ENTIDAD_FEDERATIVA_CAT_CIUDAD FOREIGN KEY (FK_ENTIDAD_FEDERATIVA) REFERENCES CAT_ENTIDAD_FEDERATIVA (PK_ENTIDAD_FEDERATIVA);
/* FIN TABLA CIUDADES */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE TIPOS DE ASENTAMIENTOS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_TIPO_ASENTAMIENTO;
CREATE TABLE CAT_TIPO_ASENTAMIENTO
(
    PK_TIPO_ASENTAMIENTO    INT           NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ALIAS                   NVARCHAR(50)           DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_TIPO_ASENTAMIENTO
    ADD CONSTRAINT PRK_TIPO_ASENTAMIENTO_CAT_TIPO_ASENTAMIENTO PRIMARY KEY (PK_TIPO_ASENTAMIENTO ASC);
/* FIN TABLA TIPOS DE ASENTAMIENTOS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE COLONIAS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_COLONIA;
CREATE TABLE CAT_COLONIA
(
    PK_COLONIA              INT           NOT NULL IDENTITY (1,1),
    FK_TIPO_ASENTAMIENTO    INT           NOT NULL,

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ALIAS                   NVARCHAR(50)           DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_COLONIA
    ADD CONSTRAINT PRK_COLONIA_CAT_COLONIA PRIMARY KEY (PK_COLONIA ASC);

ALTER TABLE CAT_COLONIA
    ADD CONSTRAINT FRK_TIPO_ASENTAMIENTO_CAT_COLONIA FOREIGN KEY (FK_TIPO_ASENTAMIENTO) REFERENCES CAT_TIPO_ASENTAMIENTO (PK_TIPO_ASENTAMIENTO);
/* FIN TABLA TIPOS DE COLONIAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA CODIGOS POSTALES ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_CODIGO_POSTAL;
CREATE TABLE CAT_CODIGO_POSTAL
(
    PK_CODIGO_POSTAL        INT          NOT NULL IDENTITY (1,1),
    FK_CIUDAD               INT          NOT NULL,

    NUMERO                  NVARCHAR(10) NOT NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_CODIGO_POSTAL
    ADD CONSTRAINT PRK_CODIGO_POSTAL_CAT_CODIGO_POSTAL PRIMARY KEY (PK_CODIGO_POSTAL ASC);

ALTER TABLE CAT_CODIGO_POSTAL
    ADD CONSTRAINT FRK_CIUDAD_CAT_CODIGO_POSTAL FOREIGN KEY (FK_CIUDAD) REFERENCES CAT_CIUDAD (PK_CIUDAD);
/* FIN TABLA CODIGOS POSTALES*/

/* *************************************************** *
 * ********** CREACIÓN DE TABLA CODIGOS POSTALES ******** *
 * *************************************************** */

DROP TABLE IF EXISTS TR_COLONIA_CODIGO_POSTAL;
CREATE TABLE TR_COLONIA_CODIGO_POSTAL
(
    PK_COLONIA_CODIGO_POSTAL INT      NOT NULL IDENTITY (1,1),
    FK_COLONIA               INT      NOT NULL,
    FK_CODIGO_POSTAL         INT      NOT NULL,

    ESTADO                   SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO      INT,
    FECHA_REGISTRO           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION  INT,
    FECHA_MODIFICACION       DATETIME,
    BORRADO                  SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_COLONIA_CODIGO_POSTAL
    ADD CONSTRAINT PRK_COLONIA_CODIGO_POSTAL_TR_COLONIA_CODIGO_POSTAL PRIMARY KEY (PK_COLONIA_CODIGO_POSTAL ASC);

ALTER TABLE TR_COLONIA_CODIGO_POSTAL
    ADD CONSTRAINT FRK_COLONIA_TR_COLONIA_CODIGO_POSTAL FOREIGN KEY (FK_COLONIA) REFERENCES CAT_COLONIA (PK_COLONIA);

ALTER TABLE TR_COLONIA_CODIGO_POSTAL
    ADD CONSTRAINT FRK_CODIGO_POASTAL_TR_COLONIA_CODIGO_POSTAL FOREIGN KEY (FK_CODIGO_POSTAL) REFERENCES CAT_CODIGO_POSTAL (PK_CODIGO_POSTAL);
/* FIN TABLA CODIGOS POSTALES*/

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE ZONAS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_ZONA;
CREATE TABLE CAT_ZONA
(
    PK_ZONA                 INT           NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ALIAS                   NVARCHAR(100)          DEFAULT NULL,
    NUMERO                  INT                    DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_ZONA
    ADD CONSTRAINT PRK_ZONA_CAT_ZONA PRIMARY KEY (PK_ZONA ASC);
/* FIN TABLA ZONAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE INSTITUCIONES ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_INSTITUCION;
CREATE TABLE CAT_INSTITUCION
(
    PK_INSTITUCION          INT           NOT NULL IDENTITY (1,1),
    FK_ZONA                 INT           NOT NULL,
    FK_ENTIDAD_FEDERATIVA   INT           NOT NULL,

    NOMBRE                  NVARCHAR(200) NOT NULL,
    ALIAS                   NVARCHAR(100)          DEFAULT NULL,
    NUMERO                  INT                    DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_INSTITUCION
    ADD CONSTRAINT PRK_INSTITUCION_CAT_INSTITUCION PRIMARY KEY (PK_INSTITUCION ASC);

ALTER TABLE CAT_INSTITUCION
    ADD CONSTRAINT FRK_ZONA_CAT_INSTITUCION FOREIGN KEY (FK_ZONA) REFERENCES CAT_ZONA (PK_ZONA);

ALTER TABLE CAT_INSTITUCION
    ADD CONSTRAINT FRK_ENTIDAD_FEDERATIVA_CAT_INSTITUCION FOREIGN KEY (FK_ENTIDAD_FEDERATIVA) REFERENCES CAT_ENTIDAD_FEDERATIVA (PK_ENTIDAD_FEDERATIVA);
/* FIN TABLA INSTITUCIONES */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE INSTITUCIONES ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_INSTITUCION;
CREATE TABLE CAT_INSTITUCION
(
    PK_INSTITUCION          INT           NOT NULL IDENTITY (1,1),
    FK_ZONA                 INT           NOT NULL,
    FK_ENTIDAD_FEDERATIVA   INT           NOT NULL,

    NOMBRE                  NVARCHAR(200) NOT NULL,
    ALIAS                   NVARCHAR(100)          DEFAULT NULL,
    NUMERO                  INT                    DEFAULT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_INSTITUCION
    ADD CONSTRAINT PRK_INSTITUCION_CAT_INSTITUCION PRIMARY KEY (PK_INSTITUCION ASC);

ALTER TABLE CAT_INSTITUCION
    ADD CONSTRAINT FRK_ZONA_CAT_INSTITUCION FOREIGN KEY (FK_ZONA) REFERENCES CAT_ZONA (PK_ZONA);

ALTER TABLE CAT_INSTITUCION
    ADD CONSTRAINT FRK_ENTIDAD_FEDERATIVA_CAT_INSTITUCION FOREIGN KEY (FK_ENTIDAD_FEDERATIVA) REFERENCES CAT_ENTIDAD_FEDERATIVA (PK_ENTIDAD_FEDERATIVA);
/* FIN TABLA INSTITUCIONES */


/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE GRUPOS SANGUINEOS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_GRUPO_SANGUINEO;

/* INICIO TABLA GRUPOS SANGUINEOS  */
CREATE TABLE CAT_GRUPO_SANGUINEO
(
    PK_GRUPO_SANGUINEO      INT          NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(20) NOT NULL,
    ABREVIATURA             NVARCHAR(10) NOT NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_GRUPO_SANGUINEO
    ADD CONSTRAINT PRK_GRUPO_SANGUINEO_CAT_GRUPO_SANGUINEO PRIMARY KEY (PK_GRUPO_SANGUINEO ASC);
/* FIN TABLA GRUPOS SANGUINEOS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA ESTADO CIVIL ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_ESTADO_CIVIL;
CREATE TABLE CAT_ESTADO_CIVIL
(
    PK_ESTADO_CIVIL         INT          NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(20) NOT NULL,
    ABREVIATURA             NVARCHAR(10) NOT NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_ESTADO_CIVIL
    ADD CONSTRAINT PRK_ESTADO_CIVIL_CAT_ESTADO_CIVIL PRIMARY KEY (PK_ESTADO_CIVIL ASC);
/* FIN TABLA ESTADO CIVIL */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA AREA ACADEMICA ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_AREA_ACADEMICA;
CREATE TABLE CAT_AREA_ACADEMICA
(
    PK_AREA_ACADEMICA       INT          NOT NULL IDENTITY (1,1),
    FK_INSTITUCION          INT          NOT NULL,

    NOMBRE                  NVARCHAR(20) NOT NULL,
    ABREVIATURA             NVARCHAR(10) NOT NULL,
    ESTADO                  SMALLINT     NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CAT_AREA_ACADEMICA
    ADD CONSTRAINT PRK_AREA_ACADEMICA_CAT_AREA_ACADEMICA PRIMARY KEY (PK_AREA_ACADEMICA ASC);

ALTER TABLE CAT_AREA_ACADEMICA
    ADD CONSTRAINT FRK_INSTITUCION_CAT_AREA_ACADEMICA FOREIGN KEY (FK_INSTITUCION) REFERENCES CAT_INSTITUCION (PK_INSTITUCION);
/* FIN TABLA AREA ACADEMICA */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA CARRERAS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_CARRERA;
CREATE TABLE CAT_CARRERA
(
    PK_CARRERA              INT           NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    CLAVE_TECNM             NVARCHAR(30)           DEFAULT NULL,
    CLAVE_TECLEON           NVARCHAR(30)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_CARRERA
    ADD CONSTRAINT PRK_CARRERA_CAT_CARRERA PRIMARY KEY (PK_CARRERA ASC);
/* FIN TABLA CARRERAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA CARRERAS POR AREA ACADEMICA ******** *
 * *************************************************** */

DROP TABLE IF EXISTS TR_AREA_ACADEMICA_CARRERA;
CREATE TABLE TR_AREA_ACADEMICA_CARRERA
(
    PK_AREA_ACADEMICA_CARRERA INT      NOT NULL IDENTITY (1,1),
    FK_CARRERA                INT      NOT NULL,
    FK_AREA_ACADEMICA         INT      NOT NULL,

    ESTADO                    SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO       INT,
    FECHA_REGISTRO            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION   INT,
    FECHA_MODIFICACION        DATETIME,
    BORRADO                   SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_AREA_ACADEMICA_CARRERA
    ADD CONSTRAINT PRK_AREA_ACADEMICA_CARRERA_TR_AREA_ACADEMICA_CARRERA PRIMARY KEY (PK_AREA_ACADEMICA_CARRERA ASC);

ALTER TABLE TR_AREA_ACADEMICA_CARRERA
    ADD CONSTRAINT FRK_CARRERA_TR_AREA_ACADEMICA_CARRERA FOREIGN KEY (FK_CARRERA) REFERENCES CAT_CARRERA (PK_CARRERA);

ALTER TABLE TR_AREA_ACADEMICA_CARRERA
    ADD CONSTRAINT FRK_AREA_ACADEMICA_TR_AREA_ACADEMICA_CARRERA FOREIGN KEY (FK_AREA_ACADEMICA) REFERENCES CAT_AREA_ACADEMICA (PK_AREA_ACADEMICA);
/* FIN TABLA CARRERAS POR AREA ACADEMICA */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA PLAN ESTUDIOS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_PLAN_ESTUDIOS;
CREATE TABLE CAT_PLAN_ESTUDIOS
(
    PK_PLAN_ESTUDIOS        INT           NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(100) NOT NULL,
    DESCRIPCION             TEXT          NOT NULL,
    ANIO                    NVARCHAR(4)   NOT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    CLAVE_TECNM             NVARCHAR(30)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_PLAN_ESTUDIOS
    ADD CONSTRAINT PRK_PLAN_ESTUDIOS_CAT_PLAN_ESTUDIOS PRIMARY KEY (PK_PLAN_ESTUDIOS ASC);
/* FIN TABLA PLAN ESTUDIOS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA PLAN ESTUDIOS POR CARRERA ******** *
 * *************************************************** */

DROP TABLE IF EXISTS TR_PLAN_ESTUDIOS_CARRERA;
CREATE TABLE TR_PLAN_ESTUDIOS_CARRERA
(
    PK_PLAN_ESTUDIOS_CARRERA INT      NOT NULL IDENTITY (1,1),
    FK_PLAN_ESTUDIOS         INT      NOT NULL,
    FK_CARRERA               INT      NOT NULL,
    FK_INSTITUCION           INT      NOT NULL,

    ESTADO                   SMALLINT NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO      INT,
    FECHA_REGISTRO           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION  INT,
    FECHA_MODIFICACION       DATETIME,
    BORRADO                  SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE TR_PLAN_ESTUDIOS_CARRERA
    ADD CONSTRAINT PRK_PLAN_ESTUDIOS_CARRERA_TR_PLAN_ESTUDIOS_CARRERA PRIMARY KEY (PK_PLAN_ESTUDIOS_CARRERA ASC);

ALTER TABLE TR_PLAN_ESTUDIOS_CARRERA
    ADD CONSTRAINT FRK_PLAN_ESTUDIOS_TR_PLAN_ESTUDIOS_CARRERA FOREIGN KEY (FK_PLAN_ESTUDIOS) REFERENCES CAT_PLAN_ESTUDIOS (PK_PLAN_ESTUDIOS);

ALTER TABLE TR_PLAN_ESTUDIOS_CARRERA
    ADD CONSTRAINT FRK_CARRERA_TR_PLAN_ESTUDIOS_CARRERA FOREIGN KEY (FK_CARRERA) REFERENCES CAT_CARRERA (PK_CARRERA);

ALTER TABLE TR_PLAN_ESTUDIOS_CARRERA
    ADD CONSTRAINT FRK_INSTITUCION_TR_PLAN_ESTUDIOS_CARRERA FOREIGN KEY (FK_INSTITUCION) REFERENCES CAT_INSTITUCION (PK_INSTITUCION);
/* FIN TABLA PLAN ESTUDIOS POR CARRERA */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE USUARIOS ******** *
 * *************************************************** */

DROP TABLE IF EXISTS CAT_USUARIO;

/* INICIO TABLA USUARIOS */
CREATE TABLE CAT_USUARIO
(
    PK_USUARIO              INT           NOT NULL IDENTITY (1,1),
    FK_COLONIA              INT                    DEFAULT NULL,
    FK_ESTADO_CIVIL         INT                    DEFAULT NULL,
    FK_CARRERA              INT           NOT NULL,
    FK_GRUPO_SANGUINEO      INT                    DEFAULT NULL,

    -- DATOS PERSONALES
    NOMBRE                  NVARCHAR(100) NOT NULL,
    PRIMER_APELLIDO         NVARCHAR(100) NOT NULL,
    SEGUNDO_APELLIDO        NVARCHAR(100)          DEFAULT NULL,
    FECHA_NACIMIENTO        DATE                   DEFAULT NULL,
    CURP                    NVARCHAR(18)  NOT NULL,
    TOKEN_CURP              NVARCHAR(150) NOT NULL,
    SEXO                    NCHAR(1)               DEFAULT NULL,
    NACIONALIDAD            NVARCHAR(100),
    ESTADO                  SMALLINT      NOT NULL DEFAULT 0,

    -- DATOS DE CONTACTO
    TELEFONO_CASA           NVARCHAR(255) NOT NULL,
    TELEFONO_MOVIL          NVARCHAR(255) NOT NULL,
    CORREO1                 NVARCHAR(255) NOT NULL,
    CORREO2                 NVARCHAR(255)          DEFAULT NULL,
    CORREO_INSTITUCIONAL    NVARCHAR(255)          DEFAULT NULL,
    PASSWORD                NVARCHAR(255)          DEFAULT NULL,
    NSS                     NVARCHAR(15),

    -- DATOS ACADÉMICOS
    NUMERO_CONTROL          NVARCHAR(8)   NOT NULL,
    SEMESTRE                NVARCHAR(2),

    -- DOMICILIO
    CALLE                   NVARCHAR(255),
    NUMERO_EXTERIOR         NVARCHAR(255),
    NUMERO_INTERIOR         NVARCHAR(255),

    -- CONTACTO DE EMERGENCIA
    NOMBRE_CONTACTO         NVARCHAR(255),
    TELEFONO_CONTACTO       NVARCHAR(255),
    CORREO_CONTACTO         NVARCHAR(255),

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE CAT_USUARIO
    ADD CONSTRAINT PRK_USUARIO_CAT_USUARIO PRIMARY KEY (PK_USUARIO ASC);

ALTER TABLE CAT_USUARIO
    ADD CONSTRAINT FRK_COLONIA_CAT_USUARIO FOREIGN KEY (FK_COLONIA) REFERENCES CAT_COLONIA (PK_COLONIA);

ALTER TABLE CAT_USUARIO
    ADD CONSTRAINT FRK_ESTADO_CIVIL_CAT_USUARIO FOREIGN KEY (FK_ESTADO_CIVIL) REFERENCES CAT_ESTADO_CIVIL (PK_ESTADO_CIVIL);

ALTER TABLE CAT_USUARIO
    ADD CONSTRAINT FRK_CARRERA_CAT_USUARIO FOREIGN KEY (FK_CARRERA) REFERENCES CAT_CARRERA (PK_CARRERA);

ALTER TABLE CAT_USUARIO
    ADD CONSTRAINT FRK_GRUPO_SANGUINEO_CAT_USUARIO FOREIGN KEY (FK_GRUPO_SANGUINEO) REFERENCES CAT_GRUPO_SANGUINEO (PK_GRUPO_SANGUINEO);
/* FIN TABLA USUARIOS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE SISTEMAS ******** *
 * *************************************************** */

/* INICIO TABLA SISTEMAS */
DROP TABLE IF EXISTS PER_CAT_SISTEMA;

CREATE TABLE PER_CAT_SISTEMA
(
    PK_SISTEMA              INT           NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    CORREO1                 NVARCHAR(100) NOT NULL,
    CORREO2                 NVARCHAR(100)          DEFAULT NULL,
    INDICIO1                NVARCHAR(100) NOT NULL,
    INDICIO2                NVARCHAR(100)          DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE PER_CAT_SISTEMA
    ADD CONSTRAINT PRK_SISTEMA_PER_CAT_SISTEMA PRIMARY KEY (PK_SISTEMA ASC);
/* FIN TABLA SISTEMAS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE ROLES ******** *
 * *************************************************** */

/* INICIO TABLA ROLES */
DROP TABLE IF EXISTS PER_CAT_ROL;

CREATE TABLE PER_CAT_ROL
(
    PK_ROL                  INT           NOT NULL IDENTITY (1,1),
    FK_SISTEMA              INT           NOT NULL,

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ABREVIATURA             NVARCHAR(10)           DEFAULT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE PER_CAT_ROL
    ADD CONSTRAINT PRK_ROL_PER_CAT_ROL PRIMARY KEY (PK_ROL ASC);

ALTER TABLE PER_CAT_ROL
    ADD CONSTRAINT FRK_SISTEMA_PER_CAT_ROL FOREIGN KEY (FK_SISTEMA) REFERENCES PER_CAT_SISTEMA (PK_SISTEMA);
/* FIN TABLA ROLES */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE ROLES POR USUARIO ******** *
 * *************************************************** */

/* INICIO TABLA ROLES POR USUARIO */
DROP TABLE IF EXISTS PER_TR_ROL_USUARIO;

CREATE TABLE PER_TR_ROL_USUARIO
(
    PK_ROL_USUARIO          INT      NOT NULL IDENTITY (1,1),
    FK_ROL                  INT      NOT NULL,
    FK_USUARIO              INT      NOT NULL,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE PER_TR_ROL_USUARIO
    ADD CONSTRAINT PRK_ROL_USUARIO_PER_TR_ROL_USUARIO PRIMARY KEY (PK_ROL_USUARIO ASC);

ALTER TABLE PER_TR_ROL_USUARIO
    ADD CONSTRAINT FRK_ROL_PER_TR_ROL_USUARIO FOREIGN KEY (FK_ROL) REFERENCES PER_CAT_ROL (PK_ROL);

ALTER TABLE PER_TR_ROL_USUARIO
    ADD CONSTRAINT FRK_USUARIO_PER_TR_ROL_USUARIO FOREIGN KEY (FK_USUARIO) REFERENCES CAT_USUARIO (PK_USUARIO);
/* FIN TABLA ROLES POR USUARIO */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE MODULOS ******** *
 * *************************************************** */

/* INICIO TABLA MODULOS */
DROP TABLE IF EXISTS PER_CAT_MODULO;

CREATE TABLE PER_CAT_MODULO
(
    PK_MODULO               INT           NOT NULL IDENTITY (1,1),

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,
    ORDEN                   SMALLINT      NOT NULL DEFAULT 1,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE PER_CAT_MODULO
    ADD CONSTRAINT PRK_MODULO_PER_CAT_MODULO PRIMARY KEY (PK_MODULO ASC);
/* FIN TABLA MODULOS */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE MODULOS POR ROL ******** *
 * *************************************************** */

/* INICIO TABLA MODULOS POR ROL */
DROP TABLE IF EXISTS PER_TR_ROL_MODULO;

CREATE TABLE PER_TR_ROL_MODULO
(

    PK_ROL_MODULO           INT      NOT NULL IDENTITY (1,1),
    FK_ROL                  INT      NOT NULL,
    FK_MODULO               INT      NOT NULL,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE PER_TR_ROL_MODULO
    ADD CONSTRAINT PRK_ROL_MODULO_PER_TR_ROL_MODULO PRIMARY KEY (PK_ROL_MODULO ASC);

ALTER TABLE PER_TR_ROL_MODULO
    ADD CONSTRAINT FRK_ROL_PER_TR_ROL_MODULO FOREIGN KEY (FK_ROL) REFERENCES PER_CAT_ROL (PK_ROL);

ALTER TABLE PER_TR_ROL_MODULO
    ADD CONSTRAINT FRK_MODULO_PER_TR_ROL_MODULO FOREIGN KEY (FK_MODULO) REFERENCES PER_CAT_MODULO (PK_MODULO);
/* FIN TABLA MODULOS POR ROL */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE ACCIONES POR MODULO ******** *
 * *************************************************** */

/* INICIO TABLA ACCIONES POR MODULO */
DROP TABLE IF EXISTS PER_CAT_ACCION;

CREATE TABLE PER_CAT_ACCION
(
    PK_ACCION               INT           NOT NULL IDENTITY (1,1),
    FK_MODULO               INT           NOT NULL,

    NOMBRE                  NVARCHAR(100) NOT NULL,
    ESTADO                  SMALLINT      NOT NULL DEFAULT 1,
    ORDEN                   SMALLINT      NOT NULL DEFAULT 1,
    CLAVE_ACCION            NVARCHAR(10)  NOT NULL,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT      NOT NULL DEFAULT 0
);

ALTER TABLE PER_CAT_ACCION
    ADD CONSTRAINT PRK_ACCION_PER_CAT_ACCION PRIMARY KEY (PK_ACCION ASC);

ALTER TABLE PER_CAT_ACCION
    ADD CONSTRAINT FRK_MODULO_PER_CAT_ACCION FOREIGN KEY (FK_MODULO) REFERENCES PER_CAT_MODULO (PK_MODULO);
/* FIN TABLA ACCIONES POR MODULO */

/* *************************************************** *
 * ********** CREACIÓN DE TABLA DE PERMISOS ******** *
 * *************************************************** */

/* INICIO TABLA PERMISOS */
DROP TABLE IF EXISTS PER_TR_PERMISO;

CREATE TABLE PER_TR_PERMISO
(
    PK_PERMISO              INT      NOT NULL IDENTITY (1,1),
    FK_ROL                  INT      NOT NULL,
    FK_ACCION               INT      NOT NULL,

    FK_USUARIO_REGISTRO     INT,
    FECHA_REGISTRO          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FK_USUARIO_MODIFICACION INT,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT NOT NULL DEFAULT 0
);

ALTER TABLE PER_TR_PERMISO
    ADD CONSTRAINT PRK_PERMISO_PER_TR_PERMISO PRIMARY KEY (PK_PERMISO ASC);

ALTER TABLE PER_TR_PERMISO
    ADD CONSTRAINT FRK_ROL_PER_TR_PERMISO FOREIGN KEY (FK_ROL) REFERENCES PER_CAT_ROL (PK_ROL);

ALTER TABLE PER_TR_PERMISO
    ADD CONSTRAINT FRK_ACCION_PER_TR_PERMISO FOREIGN KEY (FK_ACCION) REFERENCES PER_CAT_ACCION (PK_ACCION);
/* FIN TABLA PERMISOS */


/* *************************************************** *
 * ********** CREACIÓN DE TABLA PROVISIONAL DEL SIIA ******** *
 * *************************************************** */

/* INICIO TABLA PROVISIONAL DEL SIIA */
/*CREATE TABLE SIIA
(
    NOMBRE           NVARCHAR(100) NOT NULL,
    APELLIDO_PATERNO NVARCHAR(100) NOT NULL,
    APELLIDO_MATERNO NVARCHAR(100) NOT NULL,
    NUMERO_CONTORL   NVARCHAR(20)  NOT NULL,
    CLAVE_CARRERA    NVARCHAR(5)   NOT NULL,
    FECHA_INGRESO    DATETIME      NOT NULL,
    SEMESTRE         INT           NOT NULL,
    ESTADO           NVARCHAR(50)  NOT NULL,
    MOTIVO           NVARCHAR(50)  NOT NULL
);*/
/* FIN TABLA PROVISIONAL DEL SIIA */

ALTER TABLE PER_CAT_SISTEMA ADD RUTA_ANGULAR NVARCHAR(50) DEFAULT NULL;

ALTER TABLE CAT_USUARIO ADD PERFIL_COMPLETO SMALLINT DEFAULT 0;

ALTER TABLE CAT_USUARIO ADD PARENTESCO_CONTACTO NVARCHAR(100) DEFAULT NULL;

ALTER TABLE CAT_USUARIO ADD SITUACION_RESIDENCIA INT DEFAULT NULL;

/*********************  FIN MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************/

-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
