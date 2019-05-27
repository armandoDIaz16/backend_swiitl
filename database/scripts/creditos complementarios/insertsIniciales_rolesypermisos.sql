use SWIITL;

/*********************  INICIO MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
*/

-- AQUÍ SE INDICAN TODOS LOS CAMBIO QUE SE HAGAN DURANTE EL DÍA O RANGO DE FECHAS

INSERT INTO PER_CAT_SISTEMA (NOMBRE, ESTADO) VALUES ('Creditos', 1);

INSERT INTO PER_CATR_ROL ( NOMBRE, ESTADO, FK_SISTEMA) VALUES ('Alumno', 1, (select PK_SISTEMA from PER_CAT_SISTEMA WHERE NOMBRE = 'Creditos'));
INSERT INTO PER_CATR_ROL ( NOMBRE, ESTADO, FK_SISTEMA) VALUES ('Comite academico', 1, (select PK_SISTEMA from PER_CAT_SISTEMA WHERE NOMBRE = 'Creditos'));
INSERT INTO PER_CATR_ROL ( NOMBRE, ESTADO, FK_SISTEMA) VALUES ('Jefe de carrera', 1, (select PK_SISTEMA from PER_CAT_SISTEMA WHERE NOMBRE = 'Creditos'));
INSERT INTO PER_CATR_ROL ( NOMBRE, ESTADO, FK_SISTEMA) VALUES ('Responsable de actividad', 1, (select PK_SISTEMA from PER_CAT_SISTEMA WHERE NOMBRE = 'Creditos'));
INSERT INTO PER_CATR_ROL ( NOMBRE, ESTADO, FK_SISTEMA) VALUES ('Registro de asistencias', 1, (select PK_SISTEMA from PER_CAT_SISTEMA WHERE NOMBRE = 'Creditos'));
INSERT INTO PER_CATR_ROL ( NOMBRE, ESTADO, FK_SISTEMA) VALUES ('Servicios escolares', 1, (select PK_SISTEMA from PER_CAT_SISTEMA WHERE NOMBRE = 'Creditos'));


INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Gestion de lineamientos', 1, 1);
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Gestion de actividades', 1, 1);
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Actividades', 1, 1);
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Seguimiento de actividades', 1, 1);
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Actividades designadas', 1, 1);
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Actividades designadas para asistencia', 1, 1);
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Creditos por validar', 1, 1);
INSERT INTO PER_CAT_MODULO (NOMBRE, ESTADO, ORDEN) VALUES ('Creditos validados', 1, 1);

INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Alumno'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Actividades'));
INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Alumno'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Seguimiento de actividades'));
INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Comite academico'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Gestion de lineamientos'));
INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Jefe de carrera'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Gestion de actividades'));
INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Responsable de actividad'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Actividades designadas'));
INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Registro de asistencias'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Actividades designadas para asistencia'));
INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Servicios escolares'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Creditos por validar'));
INSERT INTO PER_TR_ROL_MODULO (FK_ROL, FK_MODULO) VALUES ((SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = 'Servicios escolares'), (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE NOMBRE = 'Creditos validados'));





