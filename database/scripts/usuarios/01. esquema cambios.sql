/* ***************************************** *
   ***** CAMBIOS PENDIENTES EN SERVIDOR **** *
 * ***************************************** */

ALTER TABLE CAT_COLONIA
ALTER COLUMN FK_TIPO_ASENTAMIENTO INT NULL;

/* PARA ALUMNOS CON NUMERO DE CONTROL CON LETRA INICIAL EJ: M10420419*/
ALTER TABLE CAT_USUARIO ALTER COLUMN NUMERO_CONTROL NVARCHAR(9) NULL;

alter table PER_CAT_ACCION alter column CLAVE_ACCION nvarchar(50) not null;
alter table PER_CAT_ACCION alter column NOMBRE nvarchar(100) null;

alter table CAT_AREA_ACADEMICA add ES_ACADEMICA int default 0;
-- PONER EN 1 LAS QUE SÍ SON ACADÉMICAS

alter table PER_CAT_MODULO add ES_MENU smallint default 1;
-- PONER EN 1 TODOS LOS MODULSO
