use SWIITL;

/*********************  INICIO MODIFICACIONES LUNES 8 DE MAYO 2019 *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
*/
-- AQUÍ SE INDICAN TODOS LOS CAMBIOS QUE SE HAGAN DURANTE EL DÍA O RANGO DE FECHAS


/*********************  FIN MODIFICACIONES MARTES 16 DE ABRIL 2019  *********************************/

INSERT INTO CAT_NIVEL(NIVEL, NOMBRE) VALUES (0, 'EXTERNO');
INSERT INTO CAT_NIVEL(NIVEL, NOMBRE) VALUES (1, 'LICENCIATURA');
INSERT INTO CAT_NIVEL(NIVEL, NOMBRE) VALUES (2, 'MAESTRÍA');
INSERT INTO CAT_NIVEL(NIVEL, NOMBRE) VALUES (3, 'DOCTORADO');
INSERT INTO CAT_NIVEL(NIVEL, NOMBRE) VALUES (4, 'EGRESADO');
INSERT INTO CAT_NIVEL(NIVEL, NOMBRE) VALUES (5, 'ASPIRANTE');

INSERT INTO CAT_VALE(NOMBRE, ESTATUS, MONTO) VALUES ('COPIA/IMPRESIÓN', 1, 1.00);

INSERT INTO CAT_CONCEPTO(FK_AREA_ACADEMICA, NOMBRE, DESCRIPCION, MONTO, VIGENCIA_INICIAL, VIGENCIA_FINAL, ES_MONTO_VARIABLE, ES_CANTIDAD_VARIABLE, CLAVE_CONTPAQ, CLAVE_CONTPAQ_TECNM) VALUES
(1, 'Certificado parcial', 'Certificado parcial', 375, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-001-002-000'), 
(2, 'Certificado maestría o doctorado', 'Certificado maestría o doctorado', 400, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-001-003-000'), 
(3, 'Duplicado de certificado', 'Duplicado de certificado', 250, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-001-005-000'), 
(4, 'Convalidación de Materias', 'Convalidación de Materias', 1500, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-002-001-000'), 
(1, 'Equivalencia de estudios', 'Equivalencia de estudios', 1600, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-002-003-000'), 
(2, 'Constancia de asignaturas con calificaciones', 'Constancia de asignaturas con calificaciones', 35, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-001-003-000'), 
(3, 'Constancia de avance de carrera de inglés', 'Constancia de avance de carrera de inglés', 25, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-001-007-000'), 
(4, 'Constancia de actividades complementarias', 'Constancia de actividades complementarias', 30, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-001-010-000'), 
(1, 'Constancia de terminación de estudios', 'Constancia de terminación de estudios', 150, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-001-012-000'), 
(2, 'Constancia de no inconveniencia para titulación externa', 'Constancia de no inconveniencia para titulación externa', 1000, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-001-014-000'), 
(3, 'Constancia por trámite de traslado', 'Constancia por trámite de traslado', 2000, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-001-015-000'), 
(4, 'Trámites de titulación', 'Trámites de titulación', 4500, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-002-001-000'), 
(1, 'Trámites de titulación y emisión de cédula profesional', 'Trámites de titulación y emisión de cédula profesional', 1200, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-002-002-000'), 
(2, 'Trámites de titulación maestría', 'Trámites de titulación maestría', 3500, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-002-003-000'), 
(3, 'Duplicado de acta de examen profesional', 'Duplicado de acta de examen profesional', 150, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-002-005-000'), 
(4, 'Credenciales', 'Credenciales', 100, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-003-001-000'), 
(1, 'Duplicado de credenciales', 'Duplicado de credenciales', 100, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-003-002-000'), 
(2, 'Constancia de Servicio Social', 'Constancia de Servicio Social', 50, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-005-001-000'), 
(3, 'Reposición de constancia de servicio social', 'Reposición de constancia de servicio social', 100, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-005-002-000'), 
(4, 'Duplicado de carga académica (horario)', 'Duplicado de carga académica (horario)', 50, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-008-001-000'), 
(1, 'ENEIT para residencias profesionales', 'ENEIT para residencias profesionales', 1600, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A002-009-001-000'), 
(2, 'Exámenes especiales (por materia)', 'Exámenes especiales (por materia)', 1000, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A003-003-001-000'), 
(3, 'Examen de admisión o selección ', 'Examen de admisión o selección ', 1500, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A003-005-001-000'), 
(4, 'Ficha de examen admisión a maestría', 'Ficha de examen admisión a maestría', 500, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A003-006-002-000'), 
(1, 'Consulta de archivo', 'Consulta de archivo', 140, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A004-001-001-000'), 
(2, 'Autorización para titularse en otro campus TecNM', 'Autorización para titularse en otro campus TecNM', 500, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A004-005-001-000'), 
(3, 'Movilidad estudiantil', 'Movilidad estudiantil', 100, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A004-006-001-000'), 
(4, 'Retraso en la entrega bibliográfica por día', 'Retraso en la entrega bibliográfica por día', 15, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A004-099-001-000'), 
(1, 'Matriculación de nuevo ingreso en licenciatura y especialidad', 'Matriculación de nuevo ingreso en licenciatura y especialidad', 3900, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-001-001-000'), 
(2, 'Sistema escolarizado (semestre cero)', 'Sistema escolarizado (semestre cero)', 2600, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-001-003-000'), 
(3, 'Matriculación 2o Enero Junio 2020', 'Matriculación 2o Enero Junio 2020', 3900, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-006-001-000'), 
(4, 'Matriculación 3o y 4o semestre Enero Junio 2020', 'Matriculación 3o y 4o semestre Enero Junio 2020', 3000, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-006-001-000'), 
(1, 'Matriculación 5o y 6o semestre Enero Junio 2020', 'Matriculación 5o y 6o semestre Enero Junio 2020', 2800, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-006-001-000'), 
(2, 'Matriculación de 7o semestre en adelante Enero Junio 2020', 'Matriculación de 7o semestre en adelante Enero Junio 2020', 2500, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-006-002-000'), 
(3, 'Matriculación en maestría primer semestre', 'Matriculación en maestría primer semestre', 6700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-003-001-000'), 
(4, 'Matriculación en maestría segundo semestre', 'Matriculación en maestría segundo semestre', 6700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-004-001-000'), 
(1, 'Matriculación en maestría  tercero semestre', 'Matriculación en maestría  tercero semestre', 5200, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-004-001-000'), 
(2, 'Matriculación en maestría cuarto semestre', 'Matriculación en maestría cuarto semestre', 2200, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-004-001-000'), 
(3, 'Matriculación en doctorado primer semestre', 'Matriculación en doctorado primer semestre', 8700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(4, 'Matriculación en doctorado segundo semestre', 'Matriculación en doctorado segundo semestre', 8700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(1, 'Matriculación en doctorado  tercer semestre', 'Matriculación en doctorado  tercer semestre', 5100, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(2, 'Matriculación en doctorado cuarto semestre', 'Matriculación en doctorado cuarto semestre', 8700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(3, 'Matriculación en doctorado quinto semestre', 'Matriculación en doctorado quinto semestre', 8700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(1, 'Matriculación en doctorado sexto semestre', 'Matriculación en doctorado sexto semestre', 8700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(2, 'Matriculación en doctorado séptimo semestre', 'Matriculación en doctorado séptimo semestre', 8700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(3, 'Matriculación en doctorado octavo semestre', 'Matriculación en doctorado octavo semestre', 9300, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B001-005-001-000'), 
(4, 'Curso y/o seminario de titulación por persona', 'Curso y/o seminario de titulación por persona', 7700, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B002-001-001-000'), 
(3, 'Curso de homogenización a nivel licenciatura (nivelación)', 'Curso de homogenización a nivel licenciatura (nivelación)', 600, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','B002-001-002-000');

INSERT INTO CAT_CONCEPTO(FK_AREA_ACADEMICA, NOMBRE, DESCRIPCION, MONTO, VIGENCIA_INICIAL, VIGENCIA_FINAL, ES_MONTO_VARIABLE, ES_CANTIDAD_VARIABLE, CLAVE_CONTPAQ, CLAVE_CONTPAQ_TECNM, FK_VALE) VALUES
(1, 'Vale para 20 impresiones', 'Vale para 20 impresiones', 20, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-001-002-000', 1), 
(2, 'Vale para 30 impresiones', 'Vale para 30 impresiones', 30, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-001-003-000', 1), 
(3, 'Vale para 50 impresiones', 'Vale para 50 impresiones', 50, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-001-005-000', 1), 
(4, 'Vale para 100 impresiones', 'Vale para 100 impresiones', 50, GETDATE(), DATEADD(month, 1, GETDATE()), 0, 0, '12345','A001-002-001-000', 1); 

-- --------------------------------------------------------------------------------------------------------------------------------
