/*********************  INICIO MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/

/* INICIO REGISTROS PROVISIONALES PARA OBTENER USUARIO SIIA */
/*INSERT INTO SIIA(NOMBRE, APELLIDO_PATERNO, APELLIDO_MATERNO, NUMERO_CONTORL, CLAVE_CARRERA, FECHA_INGRESO, SEMESTRE, ESTADO, MOTIVO)
VALUES('MIGUEL ANGEL', 'PEÑA', 'LOPEZ', '10420419', 'ISX', '2013-08-19 00:00:00.000', 19, 'BD', 'Concluir Creditos Carrera');*/
/* FIN REGISTROS PROVISIONALES SIIA */

/* INICIO REGISTROS DEL CATÁLOGO DE CARRERAS */
INSERT INTO CAT_CARRERA(NOMBRE, ABREVIATURA, CLAVE_TECNM, CLAVE_TECLEON) VALUES
('INGENIERÍA ELECTRÓNICA',                                       'ELX', 'IELC-2010-211', 'ELX'),
('INGENIERÍA ELECTROMECÁNICA',                                   'EMX', 'IEME-2010-210', 'EMX'),
('INGENIERÍA EN GESTIÓN EMPRESARIAL',                            'GE9', 'IGEM-2009-201', 'GE9'),
('INGENIERÍA INDUSTRIAL',                                        'IIX', 'IIND-2010-227', 'IIX'),
('INGENIERÍA EN SISTEMAS COMPUTACIONALES',                       'ISX', 'ISIC-2010-224', 'ISX'),
('INGENIERÍA EN LOGÍSTICA',                                      'LOX', 'ILOG-2009-202', 'LOX'),
('INGENIERÍA MECATRÓNICA',                                       'MCX', 'IMCT-2010-229', 'MCX'),
('INGENIERÍA EN TECNOLOGÍAS DE LA INFORMACIÓN Y COMUNICACIONES', 'TIX', 'ITIC-2010-225', 'TIX ')
;
/* FIN REGISTROS DEL CATÁLOGO DE CARRERAS */


/*********************  FIN MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------

/*********************  INICIO MODIFICACIONES ACTUALIZACIÓN DE DATOS (30-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    PENDIENTE
 * PRODUCCIÓN: PENDIENTE
*/

/* INICIO REGISTROS DEL CATÁLOGO DE ESTADOS CIVILES */
INSERT INTO CAT_ESTADO_CIVIL(NOMBRE, ABREVIATURA) VALUES
('Soltero(a)',    'SOL'),
('Casado(a)',     'CAS'),
('Viudo(a)',      'VIU'),
('Divorciado(a)', 'DIV'),
('Concubinato',   'CON'),
('Unión libre',   'UNL')
;
/* FIN REGISTROS DEL CATÁLOGO DE ESTADOS CIVILES */

/* INICIO REGISTROS DEL CATÁLOGO DE CARRERAS */
SET IDENTITY_INSERT CAT_CARRERA ON;
INSERT INTO CAT_CARRERA(PK_CARRERA, NOMBRE, ABREVIATURA, CLAVE_TECNM, CLAVE_TECLEON) VALUES
(1, 'INGENIERÍA ELECTRÓNICA', 'ELX', 'IELC-2010-211', 'ELX'),
(2, 'INGENIERÍA ELECTROMECÁNICA', 'EMX', 'IEME-2010-210', 'EMX'),
(3, 'INGENIERÍA EN GESTIÓN EMPRESARIAL', 'GE9', 'IGEM-2009-201', 'GE9'),
(4, 'INGENIERÍA INDUSTRIAL', 'IIX', 'IIND-2010-227', 'IIX'),
(5, 'INGENIERÍA EN SISTEMAS COMPUTACIONALES', 'ISX', 'ISIC-2010-224', 'ISX'),
(6, 'INGENIERÍA EN LOGÍSTICA', 'LOX', 'ILOG-2009-202', 'LOX'),
(7, 'INGENIERÍA MECATRÓNICA', 'MCX', 'IMCT-2010-229', 'MCX'),
(8, 'INGENIERÍA EN TECNOLOGÍAS DE LA INFORMACIÓN Y COMUNICACIONES', 'TIX', 'ITIC-2010-225', 'TIX')
;
SET IDENTITY_INSERT CAT_CARRERA OFF;
/* FIN REGISTROS DEL CATÁLOGO DE CARRERAS */

/* INICIO REGISTROS DEL CATÁLOGO DE PAISES */
SET IDENTITY_INSERT CAT_PAIS ON;
INSERT INTO CAT_PAIS(PK_PAIS, NOMBRE, ALIAS, NUMERO, ABREVIATURA) VALUES
(1, 'México', 'MX', 1, 'MX')
;
SET IDENTITY_INSERT CAT_PAIS OFF;
/* FIN REGISTROS DEL CATÁLOGO DE PAISES */

/* INICIO REGISTROS DEL CATÁLOGO DE ENTIDADES FEDERATIVAS */
SET IDENTITY_INSERT CAT_ENTIDAD_FEDERATIVA ON;
INSERT INTO CAT_ENTIDAD_FEDERATIVA(PK_ENTIDAD_FEDERATIVA, FK_PAIS, NOMBRE, ALIAS, NUMERO, ABREVIATURA) VALUES
(1, 1,  'Aguascalientes', 'Ags', 1, 'Ags'),
(2, 1,  'Baja California', 'B. C', 2, 'B. C'),
(3, 1,  'Baja California Sur', 'B. C. S', 3, 'B. C. S'),
(4, 1,  'Campeche', 'Camp', 4, 'Camp'),
(5, 1,  'Chiapas', 'Chis', 5, 'Chis'),
(6, 1,  'Chihuahua', 'Chih', 6, 'Chih'),
(7, 1,  'Ciudad de México', 'CDMX', 7, 'CDMX'),
(8, 1,  'Coahuila de Zaragoza', 'Coah', 8, 'Coah'),
(9, 1,  'Colima', 'Col', 9, 'Col'),
(10, 1,  'Durango', 'Dgo', 10, 'Dgo'),
(11, 1,  'Guanajuato', 'Gto', 11, 'Gto'),
(12, 1,  'Guerrero', 'Gro', 12, 'Gro'),
(13, 1,  'Hidalgo', 'Hgo', 13, 'Hgo'),
(14, 1,  'Jalisco', 'Jal', 14, 'Jal'),
(15, 1,  'México', 'Méx', 15, 'Méx'),
(16, 1,  'Michoacán de Ocampo', 'Mich', 16, 'Mich'),
(17, 1,  'Morelos', 'Mor', 17, 'Mor'),
(18, 1,  'Nayarit', 'Nay', 18, 'Nay'),
(19, 1,  'Nuevo León', 'N. L', 19, 'N. L'),
(20, 1,  'Oaxaca', 'Oax', 20, 'Oax'),
(21, 1,  'Puebla', 'Pue', 21, 'Pue'),
(22, 1,  'Querétaro', 'Qro', 22, 'Qro'),
(23, 1,  'Quintana Roo', 'Q. R', 23, 'Q. R'),
(24, 1,  'San Luis Potosí', 'S. L. P', 24, 'S. L. P'),
(25, 1,  'Sinaloa', 'Sin', 25, 'Sin'),
(26, 1,  'Sonora', 'Son', 26, 'Son'),
(27, 1,  'Tabasco', 'Tab', 27, 'Tab'),
(28, 1,  'Tamaulipas', 'Tamps', 28, 'Tamps'),
(29, 1,  'Tlaxcala', 'Tlax', 29, 'Tlax'),
(30, 1,  'Veracruz de Ignacio de la Llave', 'Ver', 30, 'Ver'),
(31, 1,  'Yucatán', 'Yuc', 31, 'Yuc'),
(32, 1,  'Zacatecas', 'Zac', 32, 'Zac')
;
SET IDENTITY_INSERT CAT_ENTIDAD_FEDERATIVA OFF;
/* FIN REGISTROS DEL CATÁLOGO DE ENTIDADES FEDERATIVAS */

/* INICIO REGISTROS DEL CATÁLOGO DE ZONAS */
SET IDENTITY_INSERT CAT_ZONA ON;
INSERT INTO CAT_ZONA(PK_ZONA, NOMBRE, ALIAS, NUMERO, ABREVIATURA) VALUES
(1, 'Zona 1', 'Z1', 1, 'Z1'),
(2, 'Zona 2', 'Z2', 2, 'Z2'),
(3, 'Zona 3', 'Z3', 3, 'Z3'),
(4, 'Zona 4', 'Z4', 4, 'Z4'),
(5, 'Zona 5', 'Z5', 5, 'Z5'),
(6, 'Zona 6', 'Z6', 6, 'Z6'),
(7, 'Zona 7', 'Z7', 7, 'Z7')
;
SET IDENTITY_INSERT CAT_ZONA OFF;
/* FIN REGISTROS DEL CATÁLOGO DE ZONAS */

/* INICIO REGISTROS DEL CATÁLOGO DE INSTITUCIONES */
SET IDENTITY_INSERT CAT_INSTITUCION ON;
INSERT INTO CAT_INSTITUCION(PK_INSTITUCION, FK_ZONA, FK_ENTIDAD_FEDERATIVA, NOMBRE, ALIAS, NUMERO, ABREVIATURA) VALUES
(1, 3, 11, 'Instituto Tecnológico de León', 'ITL', 24, 'ITL')
;
SET IDENTITY_INSERT CAT_INSTITUCION OFF;
/* FIN REGISTROS DEL CATÁLOGO DE INSTITUCIONES */

/* INICIO REGISTROS DEL CATÁLOGO DE AREAS ACADEMICAS */
SET IDENTITY_INSERT CAT_AREA_ACADEMICA ON;
INSERT INTO CAT_AREA_ACADEMICA(PK_AREA_ACADEMICA, FK_INSTITUCION, NOMBRE, ABREVIATURA) VALUES
(1, 1, 'Sistemas y Computación', 'SyC'),
(2, 1, 'Ingeniería industrial', 'Ind'),
(3, 1, 'Metalmecánica', 'MM'),
(4, 1, 'Ciencias Económico Administrativas', 'CEA')
;
SET IDENTITY_INSERT CAT_AREA_ACADEMICA OFF;
/* FIN REGISTROS DEL CATÁLOGO DE AREAS ACADEMICAS */

/* INICIO REGISTROS DEL CATÁLOGO DE AREAS ACADEMICAS POR CARRERA */
INSERT INTO TR_AREA_ACADEMICA_CARRERA(FK_CARRERA, FK_AREA_ACADEMICA) VALUES
(5, 1), (8, 1), --SISTEMAS Y COMPUTACION
(4, 2), (6, 2), -- INDUSTRIAL
(1, 3), (7, 3), (2, 3),  -- METALMECANICA
(3, 4) --CIENCIAS ECONOMICO ADMINISTRATIVAS
;
/* FIN REGISTROS DEL CATÁLOGO DE AREAS ACADEMICAS POR CARRERA */

/*********************  FIN MODIFICACIONES ACTUALIZACIÓN DE DATOS (30-08-2019) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
