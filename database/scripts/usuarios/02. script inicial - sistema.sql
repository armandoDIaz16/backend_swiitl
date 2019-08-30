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
 * PRUEBAS:    PENDIENTE
 * LOCAL:      OENDIENTE
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
/* FIN REGISTROS DEL CATÁLOGO DE CARRERAS */


/*********************  FIN MODIFICACIONES ACTUALIZACIÓN DE DATOS (30-08-2019) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
