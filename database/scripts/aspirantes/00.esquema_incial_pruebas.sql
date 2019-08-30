create table dbo.CATR_REFERENCIA_BANCARIA_USUARIO
(
	PK_REFERENCIA_BANCARIA_USER int identity
		primary key,
	FK_USUARIO int not null
		references dbo.users (PK_USUARIO),
	REFERENCIA_BANCO varchar(255) not null,
	MONTO numeric(18) not null,
	CONCEPTO varchar(255) not null,
	CANTIDAD int not null,
	TIPO_PAGO varchar(255) not null,
	FECHA_PAGO date not null,
	FECHA_LIMIE date not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	ARCHIVO_REGISTRO varchar(255) not null
)
go

create table dbo.CAT_AREA_ACADEMICA
(
	PK_AREA_ACADEMICA int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CATR_CARRERA
(
	PK_CARRERA int identity
		primary key,
	CLAVE nvarchar(255) not null,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_AREA_ACADEMICA int not null
		constraint catr_carrera_fk_area_academica_foreign
			references dbo.CAT_AREA_ACADEMICA,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null,
	CAMPUS varchar(255),
	CLAVE_CARRERA varchar(255)
)
go

create table dbo.CAT_ASENTAMIENTO
(
	PK_ASENTAMIENTO int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CATR_COLONIA
(
	PK_COLONIA int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	FK_ASENTAMIENTO int not null
		constraint catr_colonia_fk_asentamiento_foreign
			references dbo.CAT_ASENTAMIENTO,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_CARRERA_UNIVERSIDAD
(
	PK_CARRERA_UNIVERSIDAD int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_DEPENDENCIA
(
	PK_DEPENDENCIA int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_ENTIDAD_FEDERATIVA
(
	PK_ENTIDAD_FEDERATIVA int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CATR_CIUDAD
(
	PK_CIUDAD int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	FK_ENTIDAD_FEDERATIVA int not null
		constraint catr_ciudad_fk_entidad_federativa_foreign
			references dbo.CAT_ENTIDAD_FEDERATIVA,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CATR_CODIGO_POSTAL
(
	PK_NUMERO_CODIGO_POSTAL int not null
		constraint catr_codigo_postal_pk_numero_codigo_postal_primary
			primary key,
	FK_CIUDAD int not null
		constraint catr_codigo_postal_fk_ciudad_foreign
			references dbo.CATR_CIUDAD,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_BACHILLERATO
(
	PK_BACHILLERATO int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	PAIS nvarchar(255),
	FK_CIUDAD int
		constraint cat_bachillerato_fk_ciudad_foreign
			references dbo.CATR_CIUDAD,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_CIUDAD
(
	PK_CIUDAD int identity
		constraint PRK_CIUDAD_CAT_CIUDAD
			primary key,
	FK_ENTIDAD_FEDERATIVA int not null
		constraint FRK_ENTIDAD_FEDERATIVA_CAT_CIUDAD
			references dbo.CAT_ENTIDAD_FEDERATIVA,
	NOMBRE nvarchar(100) not null,
	ALIAS nvarchar(100) default NULL,
	NUMERO int default NULL,
	ABREVIATURA nvarchar(10) default NULL,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.CAT_CODIGO_POSTAL
(
	PK_CODIGO_POSTAL int identity
		constraint PRK_CODIGO_POSTAL_CAT_CODIGO_POSTAL
			primary key,
	FK_CIUDAD int not null
		constraint FRK_CIUDAD_CAT_CODIGO_POSTAL
			references dbo.CAT_CIUDAD,
	NUMERO nvarchar(10) not null,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.CAT_ESTADO_CIVIL
(
	PK_ESTADO_CIVIL int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_ESTATUS_ASPIRANTE
(
	PK_ESTATUS_ASPIRANTE int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_GRUPO_SANGUINEO
(
	PK_GRUPO_SANGUINEO int identity
		constraint PRK_GRUPO_SANGUINEO_CAT_GRUPO_SANGUINEO
			primary key,
	NOMBRE nvarchar(20) not null,
	ABREVIATURA nvarchar(10) not null,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.CAT_INCAPACIDAD
(
	PK_INCAPACIDAD int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_PAIS
(
	PK_PAIS int identity
		constraint PRK_PAIS_CAT_PAIS
			primary key,
	NOMBRE nvarchar(100) not null,
	ALIAS nvarchar(100) default NULL,
	NUMERO int default NULL,
	ABREVIATURA nvarchar(10) default NULL,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.CAT_PERIODO_PREFICHAS
(
	PK_PERIODO_PREFICHAS int identity
		primary key,
	FECHA_INICIO date not null,
	FECHA_FIN date not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null,
	MONTO_PREFICHA int default 1600,
	FECHA_INCIO_CURSO date default getdate(),
	FECHA_FIN_CURSO date default getdate(),
	MONTO_CURSO int default 550,
	FECHA_INCIO_INSCRIPCION date default getdate(),
	FECHA_FIN_INSCRIPCION date default getdate(),
	MONTO_INSCRIPCION int default 4050,
	FECHA_INCIO_INSCRIPCION_BIS date default getdate(),
	FECHA_FIN_INSCRIPCION_BIS date default getdate(),
	MONTO_INSCRIPCION_BIS int default 4050,
	FECHA_INICIO_CURSO date default getdate(),
	FECHA_INICIO_INSCRIPCION date default getdate(),
	FECHA_INICIO_INSCRIPCION_BIS date default getdate()
)
go

create table dbo.CAT_PROPAGANDA_TECNOLOGICO
(
	PK_PROPAGANDA_TECNOLOGICO int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CAT_TECNM
(
	PK_TECNM int identity
		primary key,
	NOMBRE varchar(100) not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default 0 not null,
	CLAVE_CIE int
)
go

create table dbo.CAT_CAMPUS
(
	PK_CAMPUS int identity
		primary key,
	NOMBRE varchar(100) not null,
	FK_TECNM int
		references dbo.CAT_TECNM,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default 0 not null
)
go

create table dbo.CATR_EDIFICIO
(
	PK_EDIFICIO int identity
		primary key,
	FK_CAMPUS int
		references dbo.CAT_CAMPUS,
	NOMBRE varchar(100),
	PREFIJO varchar(100) not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default 0 not null
)
go

create table dbo.CAT_TIPO_ASENTAMIENTO
(
	PK_TIPO_ASENTAMIENTO int identity
		constraint PRK_TIPO_ASENTAMIENTO_CAT_TIPO_ASENTAMIENTO
			primary key,
	NOMBRE nvarchar(100) not null,
	ALIAS nvarchar(50) default NULL,
	ABREVIATURA nvarchar(10) default NULL,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.CAT_COLONIA
(
	PK_COLONIA int identity
		constraint PRK_COLONIA_CAT_COLONIA
			primary key,
	FK_TIPO_ASENTAMIENTO int not null
		constraint FRK_TIPO_ASENTAMIENTO_CAT_COLONIA
			references dbo.CAT_TIPO_ASENTAMIENTO,
	NOMBRE nvarchar(100) not null,
	ALIAS nvarchar(50) default NULL,
	ABREVIATURA nvarchar(10) default NULL,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.CAT_TIPO_ESPACIO
(
	PK_TIPO_ESPACIO int identity
		primary key,
	NOMBRE varchar(100) not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default 0 not null
)
go

create table dbo.CATR_ESPACIO
(
	PK_ESPACIO int identity
		primary key,
	FK_EDIFICIO int
		references dbo.CATR_EDIFICIO,
	FK_TIPO_ESPACIO int
		references dbo.CAT_TIPO_ESPACIO,
	NOMBRE varchar(100),
	IDENTIFICADOR varchar(50),
	CAPACIDAD int,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default 0 not null,
	constraint NOMBRE_IDENTIFICADOR
		unique (NOMBRE, IDENTIFICADOR)
)
go

create table dbo.CAT_TURNO
(
	PK_TURNO int identity
		primary key,
	DIA date,
	HORA varchar(15),
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default 0 not null,
	constraint DIA_HORA
		unique (DIA, HORA)
)
go

create table dbo.CATR_EXAMEN_ADMISION
(
	PK_EXAMEN_ADMISION int identity
		primary key,
	FK_ESPACIO int
		references dbo.CATR_ESPACIO,
	FK_TURNO int
		references dbo.CAT_TURNO,
	LUGARES_OCUPADOS int,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default 0 not null,
	constraint ESPACIO_TURNO
		unique (FK_ESPACIO, FK_TURNO)
)
go

create table dbo.CAT_UNIVERSIDAD
(
	PK_UNIVERSIDAD int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.CATR_ASPIRANTE
(
	PK_ASPIRANTE int identity
		primary key,
	PREFICHA nchar(10) not null,
	NUMERO_PREFICHA int,
	PADRE_TUTOR nvarchar(255),
	MADRE nvarchar(255),
	ESPECIALIDAD nvarchar(255),
	PROMEDIO decimal(3,1),
	NACIONALIDAD nvarchar(255) not null,
	TRABAJAS_Y_ESTUDIAS nchar(1) default '0' not null,
	AVISO_PRIVACIDAD nchar(1) default '0' not null,
	AYUDA_INCAPACIDAD nvarchar(255),
	FK_PERIODO int not null
		constraint catr_aspirante_fk_periodo_foreign
			references dbo.CAT_PERIODO_PREFICHAS,
	FK_BACHILLERATO int
		constraint catr_aspirante_fk_bachillerato_foreign
			references dbo.CAT_BACHILLERATO,
	FK_CARRERA_1 int not null
		constraint catr_aspirante_fk_carrera_1_foreign
			references dbo.CATR_CARRERA,
	FK_CARRERA_2 int
		constraint catr_aspirante_fk_carrera_2_foreign
			references dbo.CATR_CARRERA,
	FK_PADRE int not null
		constraint catr_aspirante_fk_padre_foreign
			references dbo.users (PK_USUARIO),
	FK_DEPENDENCIA int not null
		constraint catr_aspirante_fk_dependencia_foreign
			references dbo.CAT_DEPENDENCIA,
	FK_CIUDAD int
		constraint catr_aspirante_fk_ciudad_foreign
			references dbo.CATR_CIUDAD,
	FK_CARRERA_UNIVERSIDAD int
		constraint catr_aspirante_fk_carrera_universidad_foreign
			references dbo.CAT_CARRERA_UNIVERSIDAD,
	FK_PROPAGANDA_TECNOLOGICO int not null
		constraint catr_aspirante_fk_propaganda_tecnologico_foreign
			references dbo.CAT_PROPAGANDA_TECNOLOGICO,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null,
	FK_UNIVERSIDAD int
		constraint FK_UNIVERSIDAD
			references dbo.CAT_UNIVERSIDAD,
	FK_ESTATUS int
		constraint FK_ESTATUS
			references dbo.CAT_ESTATUS_ASPIRANTE,
	FOLIO_CENEVAL varchar(255),
	FK_EXAMEN_ADMISION int
		constraint foreign_examen
			references dbo.CATR_EXAMEN_ADMISION
)
go

create table dbo.CAT_USUARIO
(
	PK_USUARIO int identity
		primary key,
	NOMBRE nvarchar(255),
	email nvarchar(255) not null,
	email_verified_at datetime,
	PASSWORD varchar(255),
	remember_token nvarchar(100),
	created_at datetime,
	updated_at datetime,
	PRIMER_APELLIDO nvarchar(255),
	SEGUNDO_APELLIDO nvarchar(255),
	FECHA_NACIMIENTO date,
	CURP nvarchar(18) not null,
	ESTADO smallint,
	TELEFONO_CASA nvarchar(255),
	TELEFONO_MOVIL nvarchar(255),
	CORREO1 nvarchar(255),
	CORREO2 nvarchar(255),
	CORREO_INSTITUCIONAL nvarchar(255),
	CALLE nvarchar(255),
	NUMERO_EXTERIOR int,
	NUMERO_INTERIOR int,
	NACIONALIDAD nvarchar(255),
	SEXO nchar(1),
	TIPO_SANGUINEO nvarchar(255),
	NSS nvarchar(11),
	NOMBRE_CONTACTO nvarchar(255),
	TELEFONO_CONTACTO nvarchar(255),
	CORREO_CONTACTO nvarchar(255),
	FK_COLONIA int
		constraint users_fk_colonia_foreign
			references dbo.CATR_COLONIA,
	FK_ESTADO_CIVIL int
		constraint users_fk_estado_civil_foreign
			references dbo.CAT_ESTADO_CIVIL,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1),
	NUMERO_CONTROL nvarchar(8)
)
go

create unique index users_email_unique
	on dbo.CAT_USUARIO (email)
go

create unique index users_curp_unique
	on dbo.CAT_USUARIO (CURP)
go

create table dbo.CAT_ZONA
(
	PK_ZONA int identity
		constraint PRK_ZONA_CAT_ZONA
			primary key,
	NOMBRE nvarchar(100) not null,
	ALIAS nvarchar(100) default NULL,
	NUMERO int default NULL,
	ABREVIATURA nvarchar(10) default NULL,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.CAT_INSTITUCION
(
	PK_INSTITUCION int identity
		constraint PRK_INSTITUCION_CAT_INSTITUCION
			primary key,
	FK_ZONA int not null
		constraint FRK_ZONA_CAT_INSTITUCION
			references dbo.CAT_ZONA,
	FK_ENTIDAD_FEDERATIVA int not null
		constraint FRK_ENTIDAD_FEDERATIVA_CAT_INSTITUCION
			references dbo.CAT_ENTIDAD_FEDERATIVA,
	NOMBRE nvarchar(200) not null,
	ALIAS nvarchar(100) default NULL,
	NUMERO int default NULL,
	ABREVIATURA nvarchar(10) default NULL,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.PER_CAT_MODULO
(
	PK_MODULO int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	ORDEN smallint not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.PER_CAT_ACCION
(
	PK_ACCION int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	ORDEN smallint not null,
	CLAVE_ACCION nvarchar(255) not null,
	FK_MODULO int not null
		constraint per_catr_accion_fk_modulo_foreign
			references dbo.PER_CAT_MODULO,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.PER_CAT_SISTEMA
(
	PK_SISTEMA int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.PER_CAT_ROL
(
	PK_ROL int identity
		primary key,
	NOMBRE nvarchar(255) not null,
	ESTADO smallint not null,
	FK_SISTEMA int not null
		constraint per_catr_rol_fk_sistema_foreign
			references dbo.PER_CAT_SISTEMA,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.PER_TR_PERMISO
(
	PK_PERMISO int identity
		primary key,
	FK_ROL int not null
		constraint per_tr_permiso_fk_rol_foreign
			references dbo.PER_CATR_ROL (PK_ROL),
	FK_ACCION int not null
		constraint per_tr_permiso_fk_accion_foreign
			references dbo.PER_CATR_ACCION (PK_ACCION),
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.PER_TR_ROL_MODULO
(
	PK_ROL_MODULO int identity
		primary key,
	FK_ROL int not null
		constraint per_tr_rol_modulo_fk_rol_foreign
			references dbo.PER_CATR_ROL (PK_ROL),
	FK_MODULO int not null
		constraint per_tr_rol_modulo_fk_modulo_foreign
			references dbo.PER_CAT_MODULO,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.PER_TR_ROL_USUARIO
(
	PK_ROL_USUARIO int identity
		primary key,
	FK_ROL int not null
		constraint per_tr_rol_usuario_fk_rol_foreign
			references dbo.PER_CATR_ROL (PK_ROL),
	FK_USUARIO int not null
		constraint per_tr_rol_usuario_fk_usuario_foreign
			references dbo.users (PK_USUARIO),
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.TR_COLONIA_CODIGO_POSTAL
(
	PK_COLONIA_CODIGO_POSTAL int identity
		constraint PRK_COLONIA_CODIGO_POSTAL_TR_COLONIA_CODIGO_POSTAL
			primary key,
	FK_COLONIA int not null
		constraint FRK_COLONIA_TR_COLONIA_CODIGO_POSTAL
			references dbo.CAT_COLONIA,
	FK_CODIGO_POSTAL int not null
		constraint FRK_CODIGO_POASTAL_TR_COLONIA_CODIGO_POSTAL
			references dbo.CAT_CODIGO_POSTAL,
	ESTADO smallint default 1 not null,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO smallint default 0 not null
)
go

create table dbo.TR_INCAPACIDAD_ASPIRANTE
(
	FK_ASPIRANTE int not null
		constraint tr_incapacidad_aspirante_fk_aspirante_foreign
			references dbo.CATR_ASPIRANTE,
	FK_INCAPACIDAD int not null
		constraint tr_incapacidad_aspirante_fk_incapacidad_foreign
			references dbo.CAT_INCAPACIDAD,
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null,
	constraint tr_incapacidad_aspirante_fk_aspirante_fk_incapacidad
		primary key (FK_ASPIRANTE, FK_INCAPACIDAD)
)
go

create table dbo.TR_RESTABLECE_CONTRASENA
(
	PK_RESTABLECE_CONTRASENA int identity
		primary key,
	FECHA_GENERACION datetime not null,
	FECHA_EXPIRACION datetime not null,
	TOKEN nvarchar(255) not null,
	ESTADO smallint not null,
	FK_USUARIO int not null
		constraint tr_restablece_contrasena_fk_usuario_foreign
			references dbo.users (PK_USUARIO),
	FK_USUARIO_REGISTRO int,
	FECHA_REGISTRO datetime default getdate() not null,
	FK_USUARIO_MODIFICACION int,
	FECHA_MODIFICACION datetime,
	BORRADO nchar(1) default '0' not null
)
go

create table dbo.migrations
(
	id int identity
		primary key,
	migration nvarchar(255) not null,
	batch int not null
)
go

create table dbo.password_resets
(
	email nvarchar(255) not null,
	token nvarchar(255) not null,
	created_at datetime
)
go

create index password_resets_email_index
	on dbo.password_resets (email)
go

