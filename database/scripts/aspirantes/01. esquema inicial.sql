use SWIITL;

/*********************  INICIO MODIFICACIONES LUNES 15 DE ABRIL 2019 *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
*/
-- AQUÍ SE INDICAN TODOS LOS CAMBIOS QUE SE HAGAN DURANTE EL DÍA O RANGO DE FECHAS

-- SCRIPT INICIAL PARA LAS TABLAS DEL ESQUEMA TECNOLÓGICO

--Tabla para almacenar el turno en que pueden tomar el examen

alter table CAT_CARRERA
	add CLAVE_CARRERA nvarchar(30) default NULL
go

alter table CAT_INSTITUCION
	add CLAVE_CIE int
go

alter table CAT_INSTITUCION alter column FK_ZONA int null
go

alter table CAT_INSTITUCION alter column FK_ENTIDAD_FEDERATIVA int null
go

alter table CAT_AREA_ACADEMICA alter column NOMBRE nvarchar(50) not null
go

alter table CAT_AREA_ACADEMICA alter column ABREVIATURA nvarchar(10) null
go

alter table CAT_USUARIO alter column TOKEN_CURP nvarchar(150) null
go

alter table CAT_USUARIO alter column NUMERO_CONTROL nvarchar(8) null
go

alter table CAT_COLONIA alter column NOMBRE nvarchar(150) not null
go

alter table CAT_COLONIA alter column FK_TIPO_ASENTAMIENTO int null
go

alter table CAT_ENTIDAD_FEDERATIVA alter column FK_PAIS int null
go

CREATE TABLE dbo.CATR_REFERENCIA_BANCARIA_USUARIO 
  ( 
     PK_REFERENCIA_BANCARIA_USER INT IDENTITY PRIMARY KEY, 
     FK_USUARIO                  INT NOT NULL REFERENCES dbo.CAT_USUARIO ( 
     PK_USUARIO), 
     REFERENCIA_BANCO            VARCHAR(255) NOT NULL, 
     MONTO                       NUMERIC(18) NOT NULL, 
     CONCEPTO                    VARCHAR(255) NOT NULL, 
     CANTIDAD                    INT NOT NULL, 
     TIPO_PAGO                   VARCHAR(255) NOT NULL, 
     FECHA_PAGO                  DATE NOT NULL, 
     FECHA_LIMIE                 DATE NOT NULL, 
     ARCHIVO_REGISTRO            VARCHAR(255) NOT NULL, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 

CREATE TABLE dbo.CAT_CARRERA_UNIVERSIDAD 
  ( 
     PK_CARRERA_UNIVERSIDAD  INT IDENTITY PRIMARY KEY, 
     NOMBRE                  NVARCHAR(255) NOT NULL, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 

CREATE TABLE dbo.CAT_DEPENDENCIA 
  ( 
     PK_DEPENDENCIA          INT IDENTITY PRIMARY KEY, 
     NOMBRE                  NVARCHAR(255) NOT NULL,      
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 

CREATE TABLE dbo.CAT_BACHILLERATO 
  ( 
     PK_BACHILLERATO         INT IDENTITY PRIMARY KEY, 
     FK_CIUDAD               INT CONSTRAINT CAT_BACHILLERATO_FK_CIUDAD_FOREIGN 
     REFERENCES 
     dbo.CAT_CIUDAD,      
     NOMBRE                  NVARCHAR(255) NOT NULL, 
     PAIS                    NVARCHAR(255), 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 

CREATE TABLE dbo.CAT_ESTATUS_ASPIRANTE 
  ( 
     PK_ESTATUS_ASPIRANTE    INT IDENTITY PRIMARY KEY, 
     NOMBRE                  NVARCHAR(255) NOT NULL, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 

CREATE TABLE dbo.CAT_INCAPACIDAD 
  ( 
     PK_INCAPACIDAD          INT IDENTITY PRIMARY KEY, 
     NOMBRE                  NVARCHAR(255) NOT NULL, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 

CREATE TABLE dbo.CAT_PERIODO_PREFICHAS 
  ( 
     PK_PERIODO_PREFICHAS         INT IDENTITY PRIMARY KEY, 
     FECHA_INICIO                 DATE NOT NULL, 
     FECHA_FIN                    DATE NOT NULL,      
     MONTO_PREFICHA               INT DEFAULT 1600, 
     FECHA_INICIO_CURSO            DATE DEFAULT GETDATE(), 
     FECHA_FIN_CURSO              DATE DEFAULT GETDATE(), 
     MONTO_CURSO                  INT DEFAULT 550, 
     FECHA_INICIO_INSCRIPCION      DATE DEFAULT GETDATE(), 
     FECHA_FIN_INSCRIPCION        DATE DEFAULT GETDATE(), 
     MONTO_INSCRIPCION            INT DEFAULT 4050, 
     FECHA_INICIO_INSCRIPCION_BIS  DATE DEFAULT GETDATE(), 
     FECHA_FIN_INSCRIPCION_BIS    DATE DEFAULT GETDATE(), 
     MONTO_INSCRIPCION_BIS        INT DEFAULT 4050,  
	  MENSAJE_SEMESTRE varchar(255),
	  MENSAJE_SEMESTRE_BIS varchar(255),
	  RESULTADOS smallint default 0,
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 


CREATE TABLE dbo.CAT_PROPAGANDA_TECNOLOGICO 
  ( 
     PK_PROPAGANDA_TECNOLOGICO INT IDENTITY PRIMARY KEY, 
     NOMBRE                    NVARCHAR(255) NOT NULL, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 


CREATE TABLE dbo.CAT_TURNO 
  ( 
     PK_TURNO                INT IDENTITY PRIMARY KEY, 
     DIA                     DATE, 
     HORA                    VARCHAR(15), 
          ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0  ,
     CONSTRAINT DIA_HORA UNIQUE (DIA, HORA) 
  ); 

  CREATE TABLE dbo.CAT_TIPO_ESPACIO(
  PK_TIPO_ESPACIO INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
  NOMBRE VARCHAR (100) NOT NULL,
 ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
);


  CREATE TABLE dbo.CAT_CAMPUS (
  PK_CAMPUS INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
  NOMBRE VARCHAR (100) NOT NULL,
  FK_INSTITUCION INT,
  FOREIGN KEY (FK_INSTITUCION) REFERENCES CAT_INSTITUCION(PK_INSTITUCION),
 ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
);

CREATE TABLE dbo.CATR_EDIFICIO 
  ( 
     PK_EDIFICIO             INT IDENTITY PRIMARY KEY, 
     FK_CAMPUS               INT REFERENCES dbo.CAT_CAMPUS, 
     NOMBRE                  VARCHAR(100), 
     PREFIJO                 VARCHAR(100) NOT NULL, 
          ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 


CREATE TABLE dbo.CATR_ESPACIO 
  ( 
     PK_ESPACIO              INT IDENTITY PRIMARY KEY, 
     FK_EDIFICIO             INT REFERENCES dbo.CATR_EDIFICIO, 
     FK_TIPO_ESPACIO         INT REFERENCES dbo.CAT_TIPO_ESPACIO, 
     NOMBRE                  VARCHAR(100), 
     IDENTIFICADOR           VARCHAR(50), 
     CAPACIDAD               INT, 
          ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 ,
     CONSTRAINT NOMBRE_IDENTIFICADOR UNIQUE (NOMBRE, IDENTIFICADOR) 
  ); 


CREATE TABLE dbo.CATR_EXAMEN_ADMISION 
  ( 
     PK_EXAMEN_ADMISION      INT IDENTITY PRIMARY KEY, 
     FK_ESPACIO              INT REFERENCES dbo.CATR_ESPACIO, 
     FK_TURNO                INT REFERENCES dbo.CAT_TURNO, 
     LUGARES_OCUPADOS        INT, 
          ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0  ,
     CONSTRAINT ESPACIO_TURNO UNIQUE (FK_ESPACIO, FK_TURNO) 
  ); 

CREATE TABLE dbo.CAT_UNIVERSIDAD 
  ( 
     PK_UNIVERSIDAD          INT IDENTITY PRIMARY KEY, 
     NOMBRE                  NVARCHAR(255) NOT NULL, 
          ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0 
  ); 

CREATE TABLE dbo.TR_CARRERA_CAMPUS 
  ( 
     PK_CARRERA_CAMPUS              INT IDENTITY PRIMARY KEY,     
     FK_CARRERA            INT NOT NULL CONSTRAINT TR_CARRERA_CAMPUS_FK_CARRERA_FOREIGN REFERENCES dbo.CAT_CARRERA, 
     FK_CAMPUS          INT NOT NULL CONSTRAINT TR_CARRERA_CAMPUS_FK_CAMPUS_FOREIGN REFERENCES dbo.CAT_CAMPUS, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0,  
     CONSTRAINT FK_CARRERA_FK_CAMPUS UNIQUE (FK_CARRERA, FK_CAMPUS) 
  ); 

CREATE TABLE dbo.CAT_ASPIRANTE 
  ( 
     PK_ASPIRANTE              INT IDENTITY PRIMARY KEY, 
     PREFICHA                  NCHAR(10) NOT NULL, 
     NUMERO_PREFICHA           INT, 
     PADRE_TUTOR               NVARCHAR(255), 
     MADRE                     NVARCHAR(255), 
     ESPECIALIDAD              NVARCHAR(255), 
     PROMEDIO                  DECIMAL(3, 1), 
     NACIONALIDAD              NVARCHAR(255) NOT NULL, 
     TRABAJAS_Y_ESTUDIAS       NCHAR(1) DEFAULT '0' NOT NULL, 
     AVISO_PRIVACIDAD          NCHAR(1) DEFAULT '0' NOT NULL, 
     AYUDA_INCAPACIDAD         NVARCHAR(255), 
     FK_PERIODO                INT NOT NULL CONSTRAINT 
     CAT_ASPIRANTE_FK_PERIODO_FOREIGN REFERENCES 
     dbo.CAT_PERIODO_PREFICHAS, 
     FK_BACHILLERATO           INT CONSTRAINT 
     CAT_ASPIRANTE_FK_BACHILLERATO_FOREIGN REFERENCES 
     dbo.CAT_BACHILLERATO, 
     FK_CARRERA_1              INT NOT NULL CONSTRAINT      CAT_ASPIRANTE_FK_CARRERA_1_FOREIGN      REFERENCES      dbo.TR_CARRERA_CAMPUS, 
     FK_CARRERA_2              INT CONSTRAINT      CAT_ASPIRANTE_FK_CARRERA_2_FOREIGN REFERENCES      dbo.TR_CARRERA_CAMPUS, 
     FK_PADRE                  INT NOT NULL CONSTRAINT 
     CAT_ASPIRANTE_FK_PADRE_FOREIGN REFERENCES 
     dbo.CAT_USUARIO ( 
     PK_USUARIO), 
     FK_DEPENDENCIA            INT NOT NULL CONSTRAINT 
     CAT_ASPIRANTE_FK_DEPENDENCIA_FOREIGN 
     REFERENCES 
     dbo.CAT_DEPENDENCIA, 
     FK_CIUDAD                 INT CONSTRAINT CAT_ASPIRANTE_FK_CIUDAD_FOREIGN 
     REFERENCES 
     dbo.CAT_CIUDAD, 
     FK_CARRERA_UNIVERSIDAD    INT CONSTRAINT 
     CAT_ASPIRANTE_FK_CARRERA_UNIVERSIDAD_FOREIGN REFERENCES 
     dbo.CAT_CARRERA_UNIVERSIDAD, 
     FK_PROPAGANDA_TECNOLOGICO INT NOT NULL CONSTRAINT 
     CAT_ASPIRANTE_FK_PROPAGANDA_TECNOLOGICO_FOREIGN REFERENCES 
     dbo.CAT_PROPAGANDA_TECNOLOGICO, 
     FK_UNIVERSIDAD            INT CONSTRAINT FK_UNIVERSIDAD REFERENCES 
     dbo.CAT_UNIVERSIDAD, 
     FK_ESTATUS                INT CONSTRAINT FK_ESTATUS REFERENCES 
     dbo.CAT_ESTATUS_ASPIRANTE, 
     FOLIO_CENEVAL             VARCHAR(255), 
     FK_EXAMEN_ADMISION        INT CONSTRAINT FOREIGN_EXAMEN REFERENCES 
     dbo.CATR_EXAMEN_ADMISION     ,
	 ICNE INT,
	 DDD_MG_MAT SMALLINT,
     ASISTENCIA                     SMALLINT NOT NULL DEFAULT 0  ,
     ACEPTADO                    SMALLINT NOT NULL DEFAULT 0  ,
	 ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0  
  ); 


CREATE TABLE dbo.TR_INCAPACIDAD_ASPIRANTE 
  ( 
     FK_ASPIRANTE            INT NOT NULL CONSTRAINT 
     TR_INCAPACIDAD_ASPIRANTE_FK_ASPIRANTE_FOREIGN REFERENCES 
     dbo.CAT_ASPIRANTE, 
     FK_INCAPACIDAD          INT NOT NULL CONSTRAINT 
     TR_INCAPACIDAD_ASPIRANTE_FK_INCAPACIDAD_FOREIGN REFERENCES 
     dbo.CAT_INCAPACIDAD, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0,  
     CONSTRAINT TR_INCAPACIDAD_ASPIRANTE_FK_ASPIRANTE_FK_INCAPACIDAD PRIMARY KEY 
     (FK_ASPIRANTE, FK_INCAPACIDAD) 
  ); 


CREATE TABLE dbo.CAT_CORREO 
  ( 
     PK_CORREO              INT IDENTITY PRIMARY KEY,     
     DIRECCION            VARCHAR(100), 
     INDICIO            VARCHAR(100), 
     CANTIDAD          INT NOT NULL, 
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0,  
  ); 

  CREATE TABLE dbo.TR_ENVIO_CORREO 
  ( 
     PK_ENVIO_CORREO              INT IDENTITY PRIMARY KEY,
     FK_CORREO               INT CONSTRAINT CAT_CORREO_FK_CORREO_FOREIGN 
     REFERENCES 
     dbo.CAT_CORREO,     
     CANTIDAD            INT NOT NULL DEFAULT 0, 
     DIA                DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
     ESTADO                      SMALLINT NOT NULL DEFAULT 1, 
     FK_USUARIO_REGISTRO         INT, 
     FK_USUARIO_MODIFICACION     INT, 
     FECHA_REGISTRO              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     FECHA_MODIFICACION          DATETIME, 
     BORRADO                     SMALLINT NOT NULL DEFAULT 0,  
  ); 


/*********************  FIN MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************/

-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
