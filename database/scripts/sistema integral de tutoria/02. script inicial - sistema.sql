/*********************  INICIO MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/

/* ******************************** *
  * ****** CATÁLOGO DE TIPOS DE PREGUNTAS ********** *
  * ******************************** */
-- CATÁLOGO DE TIPOS DE PREGUNTAS --
SET IDENTITY_INSERT CAT_TIPO_PREGUNTA ON;
INSERT INTO CAT_TIPO_PREGUNTA(
    PK_TIPO_PREGUNTA,
    NOMBRE_TIPO_PREGUNTA
) VALUES
(1, 'Dicotómica'),
(2, 'Politómica'),
(3, 'Mixta'),
(4, 'Escala numérica'),
(5, 'Opción múltiple'),
(6, 'Pregunta abierta'),
(7, 'Ordenamiento')
;
SET IDENTITY_INSERT CAT_TIPO_PREGUNTA OFF;

/* ******************************** *
  * ****** ENCUESTA PASATIEMPOS ********** *
  * ******************************** */
-- ENCUESTA PASATIEMPOS --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    1,
    'Pasatiempos',
    'Enumera del 1 al 15 las actividades que realizas en tu tiempo libre, donde el 1 es lo que más haces y el 15 lo que menos realizas',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA PASATIEMPOS --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    1,
    1,
    'Sección 1 - Pasatiempos',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTA GENÉRICA DE ENCUESTA PASATIEMPOS
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES (
    1,
    1,
    7,
    1,
    'ORDENAR LAS RESPUESTAS',
    'NA'
);
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA PASATIEMPOS
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(1, 'SALIR EN FAMILIA', 1),
(1, 'REUNIRME CON AMIGOS', 2),
(1, 'VER TV', 3),
(1, 'SALIR CON LA PAREJA', 4),
(1, 'HACER DEPORTE', 5),
(1, 'ESCUCHAR MUSICA', 6),
(1, 'IR AL PARQUE', 7),
(1, 'IR A BAILAR', 8),
(1, 'IR AL CINE', 9),
(1, 'CONECTARME A INTERNET', 10),
(1, 'JUGAR VIDEOJUEGOS', 11),
(1, 'LEER', 12),
(1, 'IR DE COMPRAS', 13),
(1, 'TOCAR ALGUN INSTRUMENTO MUSICAL', 14),
(1, 'PERTENECER A ALGUN GRUPO MUSICAL, ARTÍSTICO Y/O RELIGIOSO', 15)
;

 /* ******************************** *
  * ****** ENCUESTA SALUD ********** *
  * ******************************** */
-- ENCUESTA SALUD --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    2,
    'Salud',
    'En cada pregunta señala la opción que determine su situación',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA SALUD --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    2,
    2,
    'Sección 1 - Salud',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA SALUD
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(2, 2, 1, 2, '¿Actualmente fumas?', ''),
(3, 2, 1, 3, '¿Alguna vez has consumido bebidas alcoholicas?', ''),
(4, 2, 1, 4, '¿Haces ejercicio por lo menos tres veces a la semana?', ''),
(5, 2, 1, 5, '¿Has tenido relaciones sexuales?', ''),
(6, 2, 1, 6, '¿Conoces los métodos anticonceptivos?', ''),
(7, 2, 1, 7, '¿Tienes algún familiar o amigo que se droga?', ''),
(8, 2, 1, 8, '¿Es frecuente que te enfermes?', ''),
(9, 2, 3, 9,'¿Padeces alguna enfermedad crónica?', ''),
(10, 2, 1, 10, '¿Conoces el "plato del buen comer"?', ''),
(11, 2, 1, 11, '¿La mayor parte del tiempo te sientes con energía para realizar tus actividades diarias?', ''),
(12, 2, 1, 12, 'Tu peso, ¿es algo que constantemente te preocupa?', ''),
(13, 2, 1, 13, 'Cuando duermes ¿sientes que descansas?', ''),
(14, 2, 2, 14, 'Regularmente ¿cuántas horas duermes por la noche?', ''),
(15, 2, 2, 15, '¿Cuántas comidas haces al día?', ''),
(16, 2, 2, 16, 'En general ¿cómo calificas tu salud física?', ''),
(17, 2, 2, 17, '¿Cómo evaluas tus habilidades para Enfrentar los obstáculos de la vida?', ''),
(18, 2, 2, 18, '¿Cómo evaluas tus habilidades para Reconocer cuando te equivocas ?', ''),
(19, 2, 2, 19, '¿Cómo evaluas tus habilidades para Evaluar tu capacidad para hacer muchas cosas?', ''),
(20, 2, 2, 20, '¿Cómo evaluas tus habilidades para Expresar lo que piensas y sientes?', ''),
(21, 2, 2, 21, '¿Cómo evaluas tus habilidades para Brindar sugerencias para resolver problemas?', ''),
(22, 2, 2, 22, '¿Cómo evaluas tus habilidades para Encuentrar alternativas cuando se te presentan obstáculos?', ''),
(23, 2, 2, 23, '¿Cómo evaluas tus habilidades para Tener claro qué hacer y cómo en situaciones difíciles?', ''),
(24, 2, 2, 24, '¿Cómo evaluas tus habilidades para Expresar tus sentimientos sin ocultarte?', ''),
(25, 2, 2, 25, '¿Cómo evaluas tus habilidades para Hacer cosas que te gustan cuando estás estresado.?', ''),
(26, 2, 2, 26, '¿Cómo evaluas tus habilidades para Relacionarte con tus maestros?', ''),
(27, 2, 2, 27, '¿Cómo evaluas tus habilidades para Relacionarte coin tus padres?', ''),
(28, 2, 2, 28, '¿Cómo evaluas tus habilidades para Relacionarte con tus compañeros?', ''),
(29, 2, 2, 29, '¿Cómo evaluas tus habilidades para Relacionarte con personas del sexo opuesto?', ''),
(30, 2, 2, 30, 'La mayor parte del tiempo me siento…', ''),
(31, 2, 1, 31, '¿Prefieres las redes sociales para hacer amigos?', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA SALUD
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    ES_MIXTA
) VALUES
(2, 'SÍ', 1, 0), 	(2, 'No', 2, 0),
(3, 'SÍ', 1, 0), 	(3, 'No', 2, 0),
(4, 'SÍ', 1, 0), 	(4, 'No', 2, 0),
(5, 'SÍ', 1, 0), 	(5, 'No', 2, 0),
(6, 'SÍ', 1, 0), 	(6, 'No', 2, 0),
(7, 'SÍ', 1, 0), 	(7, 'No', 2, 0),
(8, 'SÍ', 1, 0), 	(8, 'No', 2, 0),
(9, 'SÍ (Indica cuál)', 1, 1), 	(9, 'No', 2, 0),
(10, 'Sí', 1, 0), 	(10, 'No', 2, 0),
(11, 'Sí', 1, 0), 	(11, 'No', 2, 0),
(12, 'Sí', 1, 0), 	(12, 'No', 2, 0),
(13, 'Sí', 1, 0), 	(13, 'No', 2, 0),
(14, '1 a 4', 1, 0), 	(14, '5 a 8', 2, 0), 	(14, 'Más de 8', 3, 0),
(15, '3', 1, 0), 	(15, '2', 2, 0), 	(15, '1', 3, 0),
(16, 'Excelente', 1, 0), 	(16, 'Buena', 2, 0), 	(16, 'Regular', 3, 0), 	(16, 'Mala', 4, 0),
(17, 'Excelente', 1, 0), 	(17, 'Buena', 2, 0), 	(17, 'Regular', 3, 0), 	(17, 'Mala', 4, 0),
(18, 'Excelente', 1, 0), 	(18, 'Buena', 2, 0), 	(18, 'Regular', 3, 0), 	(18, 'Mala', 4, 0),
(19, 'Excelente', 1, 0), 	(19, 'Buena', 2, 0), 	(19, 'Regular', 3, 0), 	(19, 'Mala', 4, 0),
(20, 'Excelente', 1, 0), 	(20, 'Buena', 2, 0), 	(20, 'Regular', 3, 0), 	(20, 'Mala', 4, 0),
(21, 'Excelente', 1, 0), 	(21, 'Buena', 2, 0), 	(21, 'Regular', 3, 0), 	(21, 'Mala', 4, 0),
(22, 'Excelente', 1, 0), 	(22, 'Buena', 2, 0), 	(22, 'Regular', 3, 0), 	(22, 'Mala', 4, 0),
(23, 'Excelente', 1, 0), 	(23, 'Buena', 2, 0), 	(23, 'Regular', 3, 0), 	(23, 'Mala', 4, 0),
(24, 'Excelente', 1, 0), 	(24, 'Buena', 2, 0), 	(24, 'Regular', 3, 0), 	(24, 'Mala', 4, 0),
(25, 'Excelente', 1, 0), 	(25, 'Buena', 2, 0), 	(25, 'Regular', 3, 0), 	(25, 'Mala', 4, 0),
(26, 'Excelente', 1, 0), 	(26, 'Buena', 2, 0), 	(26, 'Regular', 3, 0), 	(26, 'Mala', 4, 0),
(27, 'Excelente', 1, 0), 	(27, 'Buena', 2, 0), 	(27, 'Regular', 3, 0), 	(27, 'Mala', 4, 0),
(28, 'Excelente', 1, 0), 	(28, 'Buena', 2, 0), 	(28, 'Regular', 3, 0), 	(28, 'Mala', 4, 0),
(29, 'Excelente', 1, 0), 	(29, 'Buena', 2, 0), 	(29, 'Regular', 3, 0), 	(29, 'Mala', 4, 0),
(30, 'Triste', 1, 0), 	(30, 'Alegre', 2, 0), 	(30, 'Ansioso', 3, 0), 	(30, 'Tranquilo', 4, 0),
(31, 'Sí', 1, 0), 	(31, 'No', 2, 0)
;

/* ******************************** *
  * ****** ENCUESTA CONDICIÓN SOCIOECONÓMICA ********** *
  * ******************************** */
  -- ENCUESTA CONDICIÓN SOCIOECONÓMICA --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    3,
    'Condición Socioeconómica',
    'Contesta las siguientes preguntas, seleccionando la repuesta que mejor describa tu situación',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA CONDICIÓN SOCIOECONÓMICA --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    3,
    3,
    'Sección 1 - Condición Socioeconómica',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA CONDICIÓN SOCIOECONÓMICA
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(32, 3, 2, 32, '¿Con quién vives?', ''),
(33, 3, 2, 33, 'Estado civil', ''),
(34, 3, 2, 34, '¿Trabajas?', ''),
(35, 3, 2, 35, '¿Cuántas horas a la semana trabajas?', ''),
(36, 3, 2, 36, '¿Cuál es el motivo por el que trabajas?', ''),
(37, 3, 2, 37, '¿Económicamente depende alguien de ti?', ''),
(38, 3, 2, 38, 'Tacha el paréntesis que mencione la escolaridad máxima de tu padre', ''),
(39, 3, 2, 39, 'Tacha el paréntesis que mencione la escolaridad máxima de tu madre', ''),
(40, 3, 3, 40, '¿Qué persona (s) es la que principalmente aporta los recursos económicos, para que realices tus estudios?', ''),
(41, 3, 2, 41, '¿Cómo consideras los recursos económicos destinados a realizar tus estudios?', ''),
(42, 3, 6, 42, '¿En qué colonia vives?', ''),
(43, 3, 2, 43, '¿Qué situación (es)  atraviesa regularmente la colonia dónde vives? Puedes seleccionar varios si es el caso', ''),
(44, 3, 2, 44, '¿Cuál es el medio de transporte que frecuentemente utilizas para trasladarte a la escuela?', ''),
(45, 3, 2, 45, '¿Cuál es el total de cuartos, piezas o habitaciones con que cuenta su hogar? (Por favor, no incluya baños, pasillos, patios y zotehuelas)', ''),
(46, 3, 2, 46, '¿Cuántos baños completos con regadera y W.C. (excusado) hay para uso exclusivo de los integrantes de su hogar?', ''),
(47, 3, 1, 47, '¿En su hogar cuenta con regadera funcionando en alguno de los baños?', ''),
(48, 3, 2, 48, 'Contando todos los focos que utiliza para iluminar su hogar, incluyendo los de techos, paredes y lámparas de buró o piso, dígame ¿cuántos focos tiene su vivienda?', ''),
(49, 3, 1, 49, '¿El piso de su hogar es predominantemente de tierra, o de cemento, o de algún otro tipo de acabado?', ''),
(50, 3, 2, 50, '¿Cuántos automóviles propios, excluyendo taxis, tiene en su hogar?', ''),
(51, 3, 1, 51, '¿En este hogar cuenta con estufa de gas o eléctrica?', ''),
(52, 3, 2, 52, 'Pensando en la persona que aporta la mayor parte del ingreso en este hogar, ¿Cuál fue el último año de estudios que completó?', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA CONDICIÓN SOCIOECONÓMICA
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    ES_MIXTA
) VALUES
(32, 'Padres', 1, 0), 	(32, 'Solo', 2, 0), 	(32, 'Con familiares', 3, 0), 	(32, 'Otro', 4, 0),
(33, 'Soltero', 1, 0), 	(33, 'Casado', 2, 0), 	(33, 'Divorciado', 3, 0), 	(33, 'Unión libre', 4, 0),
(34, 'Sí     ', 1, 0), 	(34, 'No  (pasa a la pregunta no. 7)', 2, 0),
(35, 'Menos de 10 hrs', 1, 0), 	(35, 'De 10 a 20 hrs', 2, 0), 	(35, 'De 21 a 30 hrs', 3, 0),
(36, 'Apoyar a la familia', 1, 0), 	(36, 'Solventar mis estudios', 2, 0), 	(36, 'Tener ingreso para gastos personales', 3, 0), 	(36, 'Todas las anteriores', 4, 0),
(37, 'Sí', 1, 0), 	(37, 'No', 2, 0),
(38, 'Sin estudio', 1, 0), 	(38, 'Primaria incompleta', 2, 0), 	(38, 'Primaria terminada', 3, 0), 	(38, 'Secundaria incompleta', 4, 0), 	(38, 'Secundaria terminada', 5, 0), 	(38, 'Bachillerato incompleto', 6, 0), 	(38, 'Bachillerato terminado', 7, 0), 	(38, 'Estudios técnicos', 8, 0), 	(38, 'TSU', 9, 0), 	(38, 'Licenciatura incompleta', 10, 0), 	(38, 'Licenciatura terminada', 11, 0), 	(38, 'Postgrado', 12, 0), 	(38, 'Otro', 13, 0), 	(38, 'Lo desconozco', 14, 0),
(39, 'Sin estudio', 1, 0), 	(39, 'Primaria incompleta', 2, 0), 	(39, 'Primaria terminada', 3, 0), 	(39, 'Secundaria incompleta', 4, 0), 	(39, 'Secundaria terminada', 5, 0), 	(39, 'Bachillerato incompleto', 6, 0), 	(39, 'Bachillerato terminado', 7, 0), 	(39, 'Estudios técnicos', 8, 0), 	(39, 'TSU', 9, 0), 	(39, 'Licenciatura incompleta', 10, 0), 	(39, 'Licenciatura terminada', 11, 0), 	(39, 'Postgrado', 12, 0), 	(39, 'Otro', 13, 0), 	(39, 'Lo desconozco', 14, 0),
(40, 'Mi padre', 1, 0), 	(40, 'Mi madre', 2, 0), 	(40, 'Yo', 3, 0), 	(40, 'Todos los que trabajan en mi familia', 4, 0), 	(40, 'Otro (indica quién)', 5, 1),
(41, 'Altos', 1, 0), 	(41, 'Regulares', 2, 0), 	(41, 'Bajos', 3, 0), 	(41, 'Muy bajos', 4, 0),
(42, '', 1, 0),
(43, 'Robo a casa habitación', 1, 0), 	(43, 'Pandillerismo', 2, 0), 	(43, 'Robo de autos', 3, 0), 	(43, 'Drogas', 4, 0), 	(43, 'Asalto a peatones', 5, 0), 	(43, 'Otro (especifica)', 6, 0), 	(43, 'Ninguno', 7, 0),
(44, 'Autobús', 1, 0), 	(44, 'Auto propio', 2, 0), 	(44, 'Auto de la familia', 3, 0), 	(44, 'Motocicleta', 4, 0), 	(44, 'Bicicleta', 5, 0), 	(44, 'Taxi', 6, 0), 	(44, 'Caminando', 7, 0), 	(44, 'Otro', 8, 0)
;

INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    VALOR_NUMERICO
) VALUES
(45, '1 a 4', 1, 0), 		(45, '5 a 6', 2, 8), 		(45, '7 o más', 3, 13),
(46, '0', 1, 0), 		(46, '1', 2, 16), 		(46, '2', 3, 36), 		(46, '3', 4, 36), 		(46, '4 o más ', 5, 52),
(47, 'Sí', 1, 10), 		(47, 'No', 2, 0),
(48, '0 - 5', 1, 0), 		(48, '06 - 10', 2, 15), 		(48, '11 - 15', 3, 27), 		(48, '16 - 20', 4, 32), 		(48, '21 o  más', 5, 46),
(49, '(firme de) Tierra o cemento', 1, 0), 		(49, 'Otro tipo de material o acabado', 2, 11),
(50, '0', 1, 0), 		(50, '1', 2, 32), 		(50, '2', 3, 41), 		(50, '3 o más', 4, 58),
(51, 'Sí', 1, 20), 		(51, 'No', 2, 0),
(52, 'No estudió', 1, 0), 		(52, 'Primaria incompleta', 2, 0), 		(52, 'Primaria completa', 3, 22),
(52, 'Secundaria incompleta', 4, 22), 		(52, 'Secundaria completa', 5, 22),
(52, 'Carrera comercial', 6, 38), 		(52, 'Carrera técnica', 7, 38),
(52, 'Preparatoria incompleta', 8, 38), 		(52, 'Preparatoria completa', 9, 38),
(52, 'Licenciatura incompleta', 10, 52), 		(52, 'Licenciatura completa', 11, 52),
(52, 'Diplomado o Maestría', 12, 72), 		(52, 'Doctorado', 13, 72),
(52, 'No sé', 14, 0)
;

/* ******************************** *
  * ****** ENCUESTA CONDICIÓN ACADÉMICA ********** *
  * ******************************** */
-- ENCUESTA CONDICIÓN ACADÉMICA --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    4,
    'Condición Académica',
    'Lee con atención y selecciona la respuesta que corresponda a tu situación',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA CONDICIÓN ACADÉMICA --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    4,
    4,
    'Sección 1 - Condición Académica',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA CONDICIÓN ACADÉMICA
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(53, 4, 1, 53, '¿Qué tipo de escuela era la preparatoria donde estudiaste?', ''),
(54, 4, 1, 54, '¿Qué modalidad era la prepa donde estudiaste', ''),
(55, 4, 6, 55, '¿Cuál fue la especialidad o área de la que egresaste en el bachillerato?', ''),
(56, 4, 2, 56, '¿Cuántos años te llevó terminar la preparatoria?  2  - 3  - más de 3', ''),
(57, 4, 2, 57, '¿Cuánto tiempo pasó del egreso de bachillerato a tu ingreso a nivel superior?', ''),
(58, 4, 2, 58, '¿Cuál fue el promedio general de calificación, con que egresaste de preparatoria?', ''),
(59, 4, 6, 59, 'Menciona tres materias en las que tuviste dificultad en preparatoria', ''),
(60, 4, 1, 60, 'El Tecnológico de León ¿fue tu primera opción?', ''),
(61, 4, 1, 61, 'La carrera en que estás ¿fue tu primera opción de estudio?', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA CONDICIÓN ACADÉMICA
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(53, 'Pública (De Gobierno)', 1), (53, 'Privada (particular)', 1),
(54, 'Escolarizada (100% presencial)', 1), (54, 'Abierta semipresencial)', 1),
(55, '', 1),
(56, '2 años', 1), (56, '3 años', 1),
(57, 'Enseguida de egresar de preparatoria', 1), (57, 'De 6 meses a un año', 1),
(58, '70 a 80', 1), (58, '81 a 90', 1),
(59, '', 1),
(60, 'Sí', 1), (60, 'No', 1),
(61, 'Sí', 1), (61, 'No', 1)
;

/* ******************************** *
  * ****** ENCUESTA CONDICIÓN FAMILIAR ********** *
  * ******************************** */
-- ENCUESTA CONDICIÓN FAMILIAR --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    5,
    'Condición Familiar',
    'A continuación, se presentan una serie de enunciados con aspectos que se producen en las familias y entre los familiares. Indica en qué condición se encuentra tu familia',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA CONDICIÓN FAMILIAR --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    5,
    5,
    'Sección 1 - Condición Familiar',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA CONDICIÓN FAMILIAR
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(62, 5, 2, 62, '¿Cuántos integrantes conforman tu familia?', ''),
(63, 5, 2, 63, '¿Cuántos hermanos tienes?', ''),
(64, 5, 2, 64, 'Lugar que ocupas entre tus hermanos', ''),
(65, 5, 3, 65, '¿De qué tipo es tu familia?', ''),
(66, 5, 2, 66, 'Comunicación', ''),
(67, 5, 2, 67, 'Expresión de afecto', ''),
(68, 5, 2, 68, 'Establecimiento de normas', ''),
(69, 5, 2, 69, 'Relación entre tus padres', ''),
(70, 5, 2, 70, 'Relación entre hermanos', ''),
(71, 5, 2, 71, 'Relación padres e hijos', ''),
(72, 5, 2, 72, 'Convivencia familiar', ''),
(73, 5, 2, 73, 'Manejo y solución de conflictos', ''),
(74, 5, 2, 74, 'Apoyo ante los problemas', ''),
(75, 5, 2, 75, 'Salud física', ''),
(76, 5, 2, 76, '4. Dentro de las prioridades de la familia, ¿Qué lugar crees que ocupan tus estudios?', ''),
(77, 5, 2, 77, 'Los miembros de la familia se sienten muy cercanos unos a otros.', ''),
(78, 5, 2, 78, 'Cuando hay que resolver problemas, se siguen las propuestas de los hijos.', ''),
(79, 5, 2, 79, 'En nuestra familia la disciplina (normas, obligaciones, consecuencias, castigos) es justa.', ''),
(80, 5, 2, 80, 'Los miembros de la familia asumen las decisiones que se toman de manera conjunta como familia.', ''),
(81, 5, 2, 81, 'Los miembros de la familia nos pedimos ayuda mutuamente', ''),
(82, 5, 2, 82, 'En cuanto a su disciplina, se tiene en cuenta la opinión de los hijos (normas, obligaciones).', ''),
(83, 5, 2, 83, 'Cuando surgen problemas, negociamos para encontrar una solución.', ''),
(84, 5, 2, 84, 'En nuestra familia hacemos cosas juntos.', ''),
(85, 5, 2, 85, 'Los miembros de la familia dicen lo que quieren libremente.', ''),
(86, 5, 2, 86, 'En nuestra familia nos reunimos todos juntos en la misma habitación (sala, cocina).', ''),
(87, 5, 2, 87, 'A los miembros de la familia les gusta pasar sus tiempos libres juntos.', ''),
(88, 5, 2, 88, 'En nuestra familia, a todos nos resulta fácil expresar nuestra opinión.', ''),
(89, 5, 2, 89, 'Los miembros de la familia se apoyan unos a otros en los momentos difíciles.', ''),
(90, 5, 2, 90, 'En nuestra familia se intentan nuevas formas de resolver los problemas.', ''),
(91, 5, 2, 91, 'Los miembros de la familia comparten intereses y hobbies.', ''),
(92, 5, 2, 92, 'Todos tenemos voz y voto en las decisiones familiares importantes.', ''),
(93, 5, 2, 93, 'Los miembros de la familia se consultan unos a otros sus decisiones.', ''),
(94, 5, 2, 94, 'Los padres y los hijos hablan juntos sobre el castigo.', ''),
(95, 5, 2, 95, 'La unidad familiar es una preocupación principal.', ''),
(96, 5, 2, 96, 'Los miembros de la familia comentamos los problemas y nos sentimos muy bien con las soluciones encontradas.', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA CONDICIÓN FAMILIAR
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(62, '2 a 3', 1), (62, '4 a 6', 1), (62, '7 a 10', 1), (62, 'Más de 10', 1),
(63, 'Ninguno', 1), (63, '1', 1), (63, '2', 1), (63, '3', 1), (63, '4', 1), (63, '5', 1),
(64, '1º', 1), (64, '2º', 1), (64, '3º', 1), (64, '4º', 1)
;

INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    ES_MIXTA
) VALUES
(65, 'Nuclear (papá, mamá e hijos)', 1, 0),
(65, 'Extensa (viven en casa papá, mamá, hijos y otros familiares)', 1, 0),
(65, 'Monoparental (Madre o padre soltero)', 1, 0),
(65, 'Padres separados', 1, 0),
(65, 'Padres divorciados', 1, 0),
(65, 'Otro (especifica)', 1, 1)
;

INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(66, 'Excelente', 1), (66, 'Buena', 1), (66, 'Regular', 1), (66, 'Deficiente', 1),
(67, 'Excelente', 1), (67, 'Buena', 1), (67, 'Regular', 1), (67, 'Deficiente', 1),
(68, 'Excelente', 1), (68, 'Buena', 1), (68, 'Regular', 1), (68, 'Deficiente', 1),
(69, 'Excelente', 1), (69, 'Buena', 1), (69, 'Regular', 1), (69, 'Deficiente', 1),
(70, 'Excelente', 1), (70, 'Buena', 1), (70, 'Regular', 1), (70, 'Deficiente', 1),
(71, 'Excelente', 1), (71, 'Buena', 1), (71, 'Regular', 1), (71, 'Deficiente', 1),
(72, 'Excelente', 1), (72, 'Buena', 1), (72, 'Regular', 1), (72, 'Deficiente', 1),
(73, 'Excelente', 1), (73, 'Buena', 1), (73, 'Regular', 1), (73, 'Deficiente', 1),
(74, 'Excelente', 1), (74, 'Buena', 1), (74, 'Regular', 1), (74, 'Deficiente', 1),
(75, 'Excelente', 1), (75, 'Buena', 1), (75, 'Regular', 1), (75, 'Deficiente', 1),
(76, 'Muy alto', 1), (76, 'Alto', 1), (76, 'Medio', 1), (76, 'Bajo', 1), (76, 'Muy bajo', 1)
;

INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    VALOR_NUMERICO
) VALUES
(77, 'Nunca o casi nunca', 1, 1), (77, 'Pocas veces', 1, 2), (77, 'A veces', 1, 3), (77, 'Con frecuencia', 1, 4), (77, 'Casi siempre', 1, 5),
(78, 'Nunca o casi nunca', 1, 1), (78, 'Pocas veces', 1, 2), (78, 'A veces', 1, 3), (78, 'Con frecuencia', 1, 4), (78, 'Casi siempre', 1, 5),
(79, 'Nunca o casi nunca', 1, 1), (79, 'Pocas veces', 1, 2), (79, 'A veces', 1, 3), (79, 'Con frecuencia', 1, 4), (79, 'Casi siempre', 1, 5),
(80, 'Nunca o casi nunca', 1, 1), (80, 'Pocas veces', 1, 2), (80, 'A veces', 1, 3), (80, 'Con frecuencia', 1, 4), (80, 'Casi siempre', 1, 5),
(81, 'Nunca o casi nunca', 1, 1), (81, 'Pocas veces', 1, 2), (81, 'A veces', 1, 3), (81, 'Con frecuencia', 1, 4), (81, 'Casi siempre', 1, 5),
(82, 'Nunca o casi nunca', 1, 1), (82, 'Pocas veces', 1, 2), (82, 'A veces', 1, 3), (82, 'Con frecuencia', 1, 4), (82, 'Casi siempre', 1, 5),
(83, 'Nunca o casi nunca', 1, 1), (83, 'Pocas veces', 1, 2), (83, 'A veces', 1, 3), (83, 'Con frecuencia', 1, 4), (83, 'Casi siempre', 1, 5),
(84, 'Nunca o casi nunca', 1, 1), (84, 'Pocas veces', 1, 2), (84, 'A veces', 1, 3), (84, 'Con frecuencia', 1, 4), (84, 'Casi siempre', 1, 5),
(85, 'Nunca o casi nunca', 1, 1), (85, 'Pocas veces', 1, 2), (85, 'A veces', 1, 3), (85, 'Con frecuencia', 1, 4), (85, 'Casi siempre', 1, 5),
(86, 'Nunca o casi nunca', 1, 1), (86, 'Pocas veces', 1, 2), (86, 'A veces', 1, 3), (86, 'Con frecuencia', 1, 4), (86, 'Casi siempre', 1, 5),
(87, 'Nunca o casi nunca', 1, 1), (87, 'Pocas veces', 1, 2), (87, 'A veces', 1, 3), (87, 'Con frecuencia', 1, 4), (87, 'Casi siempre', 1, 5),
(88, 'Nunca o casi nunca', 1, 1), (88, 'Pocas veces', 1, 2), (88, 'A veces', 1, 3), (88, 'Con frecuencia', 1, 4), (88, 'Casi siempre', 1, 5),
(89, 'Nunca o casi nunca', 1, 1), (89, 'Pocas veces', 1, 2), (89, 'A veces', 1, 3), (89, 'Con frecuencia', 1, 4), (89, 'Casi siempre', 1, 5),
(90, 'Nunca o casi nunca', 1, 1), (90, 'Pocas veces', 1, 2), (90, 'A veces', 1, 3), (90, 'Con frecuencia', 1, 4), (90, 'Casi siempre', 1, 5),
(91, 'Nunca o casi nunca', 1, 1), (91, 'Pocas veces', 1, 2), (91, 'A veces', 1, 3), (91, 'Con frecuencia', 1, 4), (91, 'Casi siempre', 1, 5),
(92, 'Nunca o casi nunca', 1, 1), (92, 'Pocas veces', 1, 2), (92, 'A veces', 1, 3), (92, 'Con frecuencia', 1, 4), (92, 'Casi siempre', 1, 5),
(93, 'Nunca o casi nunca', 1, 1), (93, 'Pocas veces', 1, 2), (93, 'A veces', 1, 3), (93, 'Con frecuencia', 1, 4), (93, 'Casi siempre', 1, 5),
(94, 'Nunca o casi nunca', 1, 1), (94, 'Pocas veces', 1, 2), (94, 'A veces', 1, 3), (94, 'Con frecuencia', 1, 4), (94, 'Casi siempre', 1, 5),
(95, 'Nunca o casi nunca', 1, 1), (95, 'Pocas veces', 1, 2), (95, 'A veces', 1, 3), (95, 'Con frecuencia', 1, 4), (95, 'Casi siempre', 1, 5),
(96, 'Nunca o casi nunca', 1, 1), (96, 'Pocas veces', 1, 2), (96, 'A veces', 1, 3), (96, 'Con frecuencia', 1, 4), (96, 'Casi siempre', 1, 5)
;

/* ******************************** *
  * ****** ENCUESTA HÁBITOS DE ESTUDIO ********** *
  * ******************************** */
-- ENCUESTA HÁBITOS DE ESTUDIO --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    6,
    'Hábitos de estudio',
    'En cada pregunta señala la opción que determine la frecuencia de su respuesta',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA HÁBITOS DE ESTUDIO --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    6,
    6,
    'Sección 1 - Hábitos de estudio',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA HÁBITOS DE ESTUDIO
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(97, 6, 2, 97, '¿Tomo en cuenta todas mis materias al distribuir el tiempo de estudio?', ''),
(98, 6, 2, 98, '¿Culpo de mis fracasos académicos a otras personas o a las circunstancias?', ''),
(99, 6, 2, 99, '¿Hay personas conversando o ruidos que me molesten o distraigan mientras estudio?', ''),
(100, 6, 2, 100, '¿Escribo notas de todas mis clases?', ''),
(101, 6, 2, 101, '¿Adopto una actitud crítica ante lo que leo y obtengo mis propias conclusiones?', ''),
(102, 6, 2, 102, '¿Durante un examen distribuyo mi tiempo de acuerdo con el número de preguntas formuladas?', ''),
(103, 6, 2, 103, '¿Falto a mis clases?', ''),
(104, 6, 2, 104, '¿Planifico mis actividades?', ''),
(105, 6, 2, 105, '¿Siento satisfacción al intervenir en actividades relacionadas con el estudio?', ''),
(106, 6, 2, 106, '¿Interfieren mis problemas personales con mis intenciones de estudio?', ''),
(107, 6, 2, 107, '¿Utilizo abreviaturas para escribir notas más rápido?', ''),
(108, 6, 2, 108, '¿Subrayo las ideas que me parecen más  importantes durante la lectura?', ''),
(109, 6, 2, 109, '¿En los exámenes señalo de manera   visible las respuestas?', ''),
(110, 6, 2, 110, '¿Frecuento a compañeros que presentan   un bajo rendimiento académico?', ''),
(111, 6, 2, 111, '¿Concentro mi atención solo en la clase que estoy tomando?', ''),
(112, 6, 2, 112, '¿Estoy seguro (a) de que realmente me   gusta estudiar?', ''),
(113, 6, 2, 113, '¿Mientras estudio me distraigo con asuntos ajenos al tema?', ''),
(114, 6, 2, 114, '¿Anoto textualmente las fórmulas, las leyes, los principios, las reglas, etc., que expone el maestro en la clase?', ''),
(115, 6, 2, 115, '¿Exploro e investigo el contenido general de un libro antes de empezar su lectura sistemática?', ''),
(116, 6, 2, 116, '¿Durante un examen leo dos veces la misma pregunta?', ''),
(117, 6, 2, 117, '¿Aclaro mis dudas al profesor?', ''),
(118, 6, 2, 118, '¿Elaboro un horario de estudio antes de empezar mi periodo de clases?', ''),
(119, 6, 2, 119, '¿Me siento frustrado por ser estudiante?', ''),
(120, 6, 2, 120, '¿Cuándo estudio tengo cerca distractores visuales como la televisión, el retrato de mi  novio (a), artistas o carteles?', ''),
(121, 6, 2, 121, '¿Me resulta fácil concentrarme durante las clases?', ''),
(122, 6, 2, 122, '¿Utilizo alguna estrategia para recuperar lo que considero  más relevante de un material escrito para así asimilarlo?', ''),
(123, 6, 2, 123, '¿Tengo confianza en mis conocimientos o capacidades antes de empezar un examen?', ''),
(124, 6, 2, 124, '¿Adopto actitudes positivas ente mis compañeros y maestros?', ''),
(125, 6, 2, 125, '¿Inicio y concluyo puntualmente cada una de mis actividades?', ''),
(126, 6, 2, 126, '¿Encuentro agradable el ambiente de la institución educativa en la que estudio?', ''),
(127, 6, 2, 127, 'Cuando estudio, ¿tengo demasiados objetos sobre mi mesa?', ''),
(128, 6, 2, 128, '¿Cuento con hojas y pluma o lápiz durante cada una de mis clases?', ''),
(129, 6, 2, 129, '¿Me pongo a leer aunque me sienta cansado?', ''),
(130, 6, 2, 130, '¿Estoy nervioso (a) antes de presentar un examen al grado de impedirme un buen desempeño?', ''),
(131, 6, 2, 131, '¿Cumplo con mis tareas o actividades extraclase?', ''),
(132, 6, 2, 132, '¿Cuándo estudio, ¿me concentro durante periodos cortos y dedico más tiempo a fantasear?', ''),
(133, 6, 2, 133, '¿Dudo cuando tengo que tomar una decisión respecto a mis estudios?', ''),
(134, 6, 2, 134, '¿Busco apuntes o libros en los momentos en que debería estar estudiando?', ''),
(135, 6, 2, 135, '¿Copio los ejemplos que proporciona el maestro?', ''),
(136, 6, 2, 136, '¿Elaboro cuadros sinópticos, mapas conceptuales o diagramas a fin de seleccionar y sintetizar lo que he leído?', ''),
(137, 6, 2, 137, '¿Duermo normalmente la noche anterior al examen?', ''),
(138, 6, 2, 138, '¿Investigo por iniciativa propia aspectos  relacionados con las diferentes materias de estudio?', ''),
(139, 6, 2, 139, '¿Reviso diariamente el horario que elaboré por escrito para saber cuál es la actividad planeada para determinada hora?', ''),
(140, 6, 2, 140, '¿Considero que el estudio es tedioso y desagradable?', ''),
(141, 6, 2, 141, '¿Cuento con un área bien ventilada, iluminada y ordenada para estudiar?', ''),
(142, 6, 2, 142, '¿Pido prestados apuntes a mis compañeros de clase?', ''),
(143, 6, 2, 143, '¿Tengo dificultades para comprender lo que   leo?', ''),
(144, 6, 2, 144, '¿Reviso las respuestas en los exámenes antes de entregarlos?', ''),
(145, 6, 2, 145, '¿Me quedo con dudas sobre lo expuesto por el profesor?', ''),
(146, 6, 2, 146, '¿Utilizo la mayor parte de mi tiempo en actividades productivas y significativas?', ''),
(147, 6, 2, 147, '¿Por lo general, estoy dispuesto y tengo deseos de estudiar en cualquier momento?', ''),
(148, 6, 2, 148, '¿Acudo a bibliotecas o centros de   información?', ''),
(149, 6, 2, 149, '¿Mis apuntes de clase están limpios, Ordenados y legibles, de tal manera que puedo entenderlos posteriormente?', ''),
(150, 6, 2, 150, '¿Consulto el diccionario cuando desconozco el significado de una palabra?', ''),
(151, 6, 2, 151, '¿Escribo legiblemente mis respuestas en los exámenes?', ''),
(152, 6, 2, 152, '¿Estudio diariamente en mis apuntes de clase?', ''),
(153, 6, 2, 153, '¿Tengo un registro del tiempo que destino al estudio cada día?', ''),
(154, 6, 2, 154, '¿Me fijo una calificación mínima por obtener en cada una de mis materias de un periodo escolar?', ''),
(155, 6, 2, 155, '¿Escucho música que me distrae, mientras estudio?', ''),
(156, 6, 2, 156, '¿Vuelvo a leer los apuntes de clases  anteriores?', ''),
(157, 6, 2, 157, '¿Me formulo preguntas a partir de las lecturas que realizo?', ''),
(158, 6, 2, 158, '¿Respondo de manera precisa las preguntas que se me formulan en los  exámenes?', ''),
(159, 6, 2, 159, '¿Durante la clase intercambio con mis compañeros comentarios ajenos a la misma?', ''),
(160, 6, 2, 160, '¿Cuento con un programa de actividades diarias?', ''),
(161, 6, 2, 161, '¿Cuándo tengo que estudiar me encuentro cansado o somnoliento?', ''),
(162, 6, 2, 162, '¿Antes de empezar a estudiar consigo papel, goma de borrar, pluma o lápiz y demás recursos necesarios?', ''),
(163, 6, 2, 163, '¿Utilizo mis propias palabras para redactar los apuntes de clase?', ''),
(164, 6, 2, 164, '¿Elaboro resúmenes, empleando mis propias palabras, sobre los temas expuestos en un libro?', ''),
(165, 6, 2, 165, '¿Preparo con anticipación los exámenes?', ''),
(166, 6, 2, 166, '¿Asisto puntualmente a cada una de mis clases?', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA HÁBITOS DE ESTUDIO
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    VALOR_NUMERICO
) VALUES
(97, 'Siempre', 1, 3), (97, 'A menudo', 1, 2), (97, 'Rara vez', 1, 1), (97, 'Nunca', 1, 0),
(98, 'Siempre', 1, 0), (98, 'A menudo', 1, 1), (98, 'Rara vez', 1, 2), (98, 'Nunca', 1, 3),
(99, 'Siempre', 1, 0), (99, 'A menudo', 1, 1), (99, 'Rara vez', 1, 2), (99, 'Nunca', 1, 3),
(100, 'Siempre', 1, 3), (100, 'A menudo', 1, 2), (100, 'Rara vez', 1, 1), (100, 'Nunca', 1, 0),
(101, 'Siempre', 1, 3), (101, 'A menudo', 1, 2), (101, 'Rara vez', 1, 1), (101, 'Nunca', 1, 0),
(102, 'Siempre', 1, 3), (102, 'A menudo', 1, 2), (102, 'Rara vez', 1, 1), (102, 'Nunca', 1, 0),
(103, 'Siempre', 1, 0), (103, 'A menudo', 1, 1), (103, 'Rara vez', 1, 2), (103, 'Nunca', 1, 3),
(104, 'Siempre', 1, 3), (104, 'A menudo', 1, 2), (104, 'Rara vez', 1, 1), (104, 'Nunca', 1, 0),
(105, 'Siempre', 1, 3), (105, 'A menudo', 1, 2), (105, 'Rara vez', 1, 1), (105, 'Nunca', 1, 0),
(106, 'Siempre', 1, 0), (106, 'A menudo', 1, 1), (106, 'Rara vez', 1, 2), (106, 'Nunca', 1, 3),
(107, 'Siempre', 1, 3), (107, 'A menudo', 1, 2), (107, 'Rara vez', 1, 1), (107, 'Nunca', 1, 0),
(108, 'Siempre', 1, 3), (108, 'A menudo', 1, 2), (108, 'Rara vez', 1, 1), (108, 'Nunca', 1, 0),
(109, 'Siempre', 1, 3), (109, 'A menudo', 1, 2), (109, 'Rara vez', 1, 1), (109, 'Nunca', 1, 0),
(110, 'Siempre', 1, 0), (110, 'A menudo', 1, 1), (110, 'Rara vez', 1, 2), (110, 'Nunca', 1, 3),
(111, 'Siempre', 1, 3), (111, 'A menudo', 1, 2), (111, 'Rara vez', 1, 1), (111, 'Nunca', 1, 0),
(112, 'Siempre', 1, 3), (112, 'A menudo', 1, 2), (112, 'Rara vez', 1, 1), (112, 'Nunca', 1, 0),
(113, 'Siempre', 1, 0), (113, 'A menudo', 1, 1), (113, 'Rara vez', 1, 2), (113, 'Nunca', 1, 3),
(114, 'Siempre', 1, 3), (114, 'A menudo', 1, 2), (114, 'Rara vez', 1, 1), (114, 'Nunca', 1, 0),
(115, 'Siempre', 1, 3), (115, 'A menudo', 1, 2), (115, 'Rara vez', 1, 1), (115, 'Nunca', 1, 0),
(116, 'Siempre', 1, 3), (116, 'A menudo', 1, 2), (116, 'Rara vez', 1, 1), (116, 'Nunca', 1, 0),
(117, 'Siempre', 1, 3), (117, 'A menudo', 1, 2), (117, 'Rara vez', 1, 1), (117, 'Nunca', 1, 0),
(118, 'Siempre', 1, 3), (118, 'A menudo', 1, 2), (118, 'Rara vez', 1, 1), (118, 'Nunca', 1, 0),
(119, 'Siempre', 1, 0), (119, 'A menudo', 1, 1), (119, 'Rara vez', 1, 2), (119, 'Nunca', 1, 3),
(120, 'Siempre', 1, 0), (120, 'A menudo', 1, 1), (120, 'Rara vez', 1, 2), (120, 'Nunca', 1, 3),
(121, 'Siempre', 1, 3), (121, 'A menudo', 1, 2), (121, 'Rara vez', 1, 1), (121, 'Nunca', 1, 0),
(122, 'Siempre', 1, 3), (122, 'A menudo', 1, 2), (122, 'Rara vez', 1, 1), (122, 'Nunca', 1, 0),
(123, 'Siempre', 1, 3), (123, 'A menudo', 1, 2), (123, 'Rara vez', 1, 1), (123, 'Nunca', 1, 0),
(124, 'Siempre', 1, 3), (124, 'A menudo', 1, 2), (124, 'Rara vez', 1, 1), (124, 'Nunca', 1, 0),
(125, 'Siempre', 1, 3), (125, 'A menudo', 1, 2), (125, 'Rara vez', 1, 1), (125, 'Nunca', 1, 0),
(126, 'Siempre', 1, 3), (126, 'A menudo', 1, 2), (126, 'Rara vez', 1, 1), (126, 'Nunca', 1, 0),
(127, 'Siempre', 1, 0), (127, 'A menudo', 1, 1), (127, 'Rara vez', 1, 2), (127, 'Nunca', 1, 3),
(128, 'Siempre', 1, 3), (128, 'A menudo', 1, 2), (128, 'Rara vez', 1, 1), (128, 'Nunca', 1, 0),
(129, 'Siempre', 1, 0), (129, 'A menudo', 1, 1), (129, 'Rara vez', 1, 2), (129, 'Nunca', 1, 3),
(130, 'Siempre', 1, 0), (130, 'A menudo', 1, 1), (130, 'Rara vez', 1, 2), (130, 'Nunca', 1, 3),
(131, 'Siempre', 1, 3), (131, 'A menudo', 1, 2), (131, 'Rara vez', 1, 1), (131, 'Nunca', 1, 0),
(132, 'Siempre', 1, 0), (132, 'A menudo', 1, 1), (132, 'Rara vez', 1, 2), (132, 'Nunca', 1, 3),
(133, 'Siempre', 1, 0), (133, 'A menudo', 1, 1), (133, 'Rara vez', 1, 2), (133, 'Nunca', 1, 3),
(134, 'Siempre', 1, 0), (134, 'A menudo', 1, 1), (134, 'Rara vez', 1, 2), (134, 'Nunca', 1, 3),
(135, 'Siempre', 1, 3), (135, 'A menudo', 1, 2), (135, 'Rara vez', 1, 1), (135, 'Nunca', 1, 0),
(136, 'Siempre', 1, 3), (136, 'A menudo', 1, 2), (136, 'Rara vez', 1, 1), (136, 'Nunca', 1, 0),
(137, 'Siempre', 1, 3), (137, 'A menudo', 1, 2), (137, 'Rara vez', 1, 1), (137, 'Nunca', 1, 0),
(138, 'Siempre', 1, 3), (138, 'A menudo', 1, 2), (138, 'Rara vez', 1, 1), (138, 'Nunca', 1, 0),
(139, 'Siempre', 1, 3), (139, 'A menudo', 1, 2), (139, 'Rara vez', 1, 1), (139, 'Nunca', 1, 0),
(140, 'Siempre', 1, 0), (140, 'A menudo', 1, 1), (140, 'Rara vez', 1, 2), (140, 'Nunca', 1, 3),
(141, 'Siempre', 1, 3), (141, 'A menudo', 1, 2), (141, 'Rara vez', 1, 1), (141, 'Nunca', 1, 0),
(142, 'Siempre', 1, 3), (142, 'A menudo', 1, 2), (142, 'Rara vez', 1, 1), (142, 'Nunca', 1, 0),
(143, 'Siempre', 1, 0), (143, 'A menudo', 1, 1), (143, 'Rara vez', 1, 2), (143, 'Nunca', 1, 3),
(144, 'Siempre', 1, 3), (144, 'A menudo', 1, 2), (144, 'Rara vez', 1, 1), (144, 'Nunca', 1, 0),
(145, 'Siempre', 1, 0), (145, 'A menudo', 1, 1), (145, 'Rara vez', 1, 2), (145, 'Nunca', 1, 3),
(146, 'Siempre', 1, 3), (146, 'A menudo', 1, 2), (146, 'Rara vez', 1, 1), (146, 'Nunca', 1, 0),
(147, 'Siempre', 1, 3), (147, 'A menudo', 1, 2), (147, 'Rara vez', 1, 1), (147, 'Nunca', 1, 0),
(148, 'Siempre', 1, 3), (148, 'A menudo', 1, 2), (148, 'Rara vez', 1, 1), (148, 'Nunca', 1, 0),
(149, 'Siempre', 1, 3), (149, 'A menudo', 1, 2), (149, 'Rara vez', 1, 1), (149, 'Nunca', 1, 0),
(150, 'Siempre', 1, 3), (150, 'A menudo', 1, 2), (150, 'Rara vez', 1, 1), (150, 'Nunca', 1, 0),
(151, 'Siempre', 1, 3), (151, 'A menudo', 1, 2), (151, 'Rara vez', 1, 1), (151, 'Nunca', 1, 0),
(152, 'Siempre', 1, 3), (152, 'A menudo', 1, 2), (152, 'Rara vez', 1, 1), (152, 'Nunca', 1, 0),
(153, 'Siempre', 1, 3), (153, 'A menudo', 1, 2), (153, 'Rara vez', 1, 1), (153, 'Nunca', 1, 0),
(154, 'Siempre', 1, 3), (154, 'A menudo', 1, 2), (154, 'Rara vez', 1, 1), (154, 'Nunca', 1, 0),
(155, 'Siempre', 1, 0), (155, 'A menudo', 1, 1), (155, 'Rara vez', 1, 2), (155, 'Nunca', 1, 3),
(156, 'Siempre', 1, 3), (156, 'A menudo', 1, 2), (156, 'Rara vez', 1, 1), (156, 'Nunca', 1, 0),
(157, 'Siempre', 1, 3), (157, 'A menudo', 1, 2), (157, 'Rara vez', 1, 1), (157, 'Nunca', 1, 0),
(158, 'Siempre', 1, 3), (158, 'A menudo', 1, 2), (158, 'Rara vez', 1, 1), (158, 'Nunca', 1, 0),
(159, 'Siempre', 1, 0), (159, 'A menudo', 1, 1), (159, 'Rara vez', 1, 2), (159, 'Nunca', 1, 3),
(160, 'Siempre', 1, 3), (160, 'A menudo', 1, 2), (160, 'Rara vez', 1, 1), (160, 'Nunca', 1, 0),
(161, 'Siempre', 1, 0), (161, 'A menudo', 1, 1), (161, 'Rara vez', 1, 2), (161, 'Nunca', 1, 3),
(162, 'Siempre', 1, 3), (162, 'A menudo', 1, 2), (162, 'Rara vez', 1, 1), (162, 'Nunca', 1, 0),
(163, 'Siempre', 1, 3), (163, 'A menudo', 1, 2), (163, 'Rara vez', 1, 1), (163, 'Nunca', 1, 0),
(164, 'Siempre', 1, 3), (164, 'A menudo', 1, 2), (164, 'Rara vez', 1, 1), (164, 'Nunca', 1, 0),
(165, 'Siempre', 1, 3), (165, 'A menudo', 1, 2), (165, 'Rara vez', 1, 1), (165, 'Nunca', 1, 0),
(166, 'Siempre', 1, 3), (166, 'A menudo', 1, 2), (166, 'Rara vez', 1, 1), (166, 'Nunca', 1, 0)
;

/* ******************************** *
  * ****** ENCUESTA DE EVALUACIÓN DE TUTORÍA 1ER SEMESTRE ********** *
  * ******************************** */
-- ENCUESTA HÁBITOS DE EVALUACIÓN DE TUTORÍA 1ER SEMESTRE --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    OBJETIVO,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    7,
    'Evaluación de tutoría',
    'Con el objetivo de identificar áreas de mejora, contesta las siguientes afirmaciones respecto al desempeño de tu Tutor y al Programa de Tutoría',
    'De acuerdo a la escala, selecciona la opción que consideres pertinente.',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA EVALUACIÓN DE TUTORÍA 1ER SEMESTRE --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    7,
    7,
    'Sección 1 - Evaluación de tutoría',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA EVALUACIÓN DE TUTORÍA 1ER SEMESTRE
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(167, 7, 2, 167, 'El tutor se comunica de manera clara y efectiva con los alumnos.', ''),
(168, 7, 2, 168, 'El tutor escucha los comentarios y necesidades de los alumnos.', ''),
(169, 7, 2, 169, 'Mi tutor me atendió cada vez que lo solicité.', ''),
(170, 7, 2, 170, 'Nos trata con respeto y atención.', ''),
(171, 7, 2, 171, 'Tiene capacidad para orientar, en función de nuestras necesidades, a los diferentes servicios que ofrece la institución.', ''),
(172, 7, 2, 172, 'El tutor entregó y dio seguimiento al programa de la materia.', ''),
(173, 7, 2, 173, 'El tutor cumplió con los temas previstos en la materia y/o nos acompañò en el taller', ''),
(174, 7, 2, 174, 'En general, la evaluación que le doy a mi tutor es…', ''),
(175, 7, 2, 175, 'La actividad tutorial me permitió conocer la filosofía y políticas del ITL.', ''),
(176, 7, 2, 176, 'La actividad tutorial me permitió  conocer más los servicios y departamentos del TEC.', ''),
(177, 7, 2, 177, 'Me permitió tener un mayor conocimiento de mí mismo y como estudiante.', ''),
(178, 7, 2, 178, 'Me facilitó plantearme metas a corto y mediano plazo en mi vida como estudiante.', ''),
(179, 7, 2, 179, 'Gracias a la actividad tutorial tengo una visión más amplia sobre el perfil profesional y su campo laboral.', ''),
(180, 7, 2, 180, 'Desarrollé algunas habilidades sociales, de pensamiento y emocional que fortalecen mi desarrollo integral.', ''),
(181, 7, 2, 181, 'En general, la evaluación que le doy a Tutoría es…', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA DE EVALUACIÓN DE TUTORÍA 1ER SEMESTRE
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(167, 'Excelente', 1), 	(167, 'Buena', 1), 	(167, 'Mala', 1), 	(167, 'Deficiente', 1),
(168, 'Excelente', 1), 	(168, 'Buena', 1), 	(168, 'Mala', 1), 	(168, 'Deficiente', 1),
(169, 'Excelente', 1), 	(169, 'Buena', 1), 	(169, 'Mala', 1), 	(169, 'Deficiente', 1),
(170, 'Excelente', 1), 	(170, 'Buena', 1), 	(170, 'Mala', 1), 	(170, 'Deficiente', 1),
(171, 'Excelente', 1), 	(171, 'Buena', 1), 	(171, 'Mala', 1), 	(171, 'Deficiente', 1),
(172, 'Excelente', 1), 	(172, 'Buena', 1), 	(172, 'Mala', 1), 	(172, 'Deficiente', 1),
(173, 'Excelente', 1), 	(173, 'Buena', 1), 	(173, 'Mala', 1), 	(173, 'Deficiente', 1),
(174, 'Excelente', 1), 	(174, 'Buena', 1), 	(174, 'Mala', 1), 	(174, 'Deficiente', 1),
(175, 'Excelente', 1), 	(175, 'Buena', 1), 	(175, 'Mala', 1), 	(175, 'Deficiente', 1),
(176, 'Excelente', 1), 	(176, 'Buena', 1), 	(176, 'Mala', 1), 	(176, 'Deficiente', 1),
(177, 'Excelente', 1), 	(177, 'Buena', 1), 	(177, 'Mala', 1), 	(177, 'Deficiente', 1),
(178, 'Excelente', 1), 	(178, 'Buena', 1), 	(178, 'Mala', 1), 	(178, 'Deficiente', 1),
(179, 'Excelente', 1), 	(179, 'Buena', 1), 	(179, 'Mala', 1), 	(179, 'Deficiente', 1),
(180, 'Excelente', 1), 	(180, 'Buena', 1), 	(180, 'Mala', 1), 	(180, 'Deficiente', 1),
(181, 'Excelente', 1), 	(181, 'Buena', 1), 	(181, 'Mala', 1), 	(181, 'Deficiente', 1)
;

/* ******************************** *
  * ****** ENCUESTA CASUSAS DE REPROBACIÓN ********** *
  * ******************************** */
-- ENCUESTA CASUSAS DE REPROBACIÓN --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    OBJETIVO,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    9,
    'Causas de reprobación',
    'Te solicitamos contestes la siguiente encuesta cuyo objetivo es identificar las principales causas de reprobación para generar estrategias de apoyo a tu desempeño académico',
    'En cada materia marca con una “X”, tres de los factores que consideres influyeron en tus resultados',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA CASUSAS DE REPROBACIÓN --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    9,
    9,
    'Sección 1 - Causas de reprobación',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTA GENÉRICA DE ENCUESTA CASUSAS DE REPROBACIÓN
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(182, 9, 2, 1, 'SELECCIONA DOS MATERIAS', 'NA'),
(183, 9, 6, 1, 'Señalal otra causa que afectó en tu resultado', ''),
(184, 9, 6, 1, 'Comentarios generales', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA CASUSAS DE REPROBACIÓN
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(182, 'Malos hábitos de estudio. ', 1),
(182, 'Inasistencia y/o impuntualidad del docente.', 1),
(182, 'Dificultades con la forma de enseñar del docente.', 1),
(182, 'Poco tiempo para la revisión de contenidos de la materia.', 1),
(182, 'Inasistencia a clase por parte del alumno.', 1),
(182, 'Ausencia de conocimientos previos a la materia.', 1),
(182, 'Desconocimiento de los criterios de evaluación.', 1),
(182, 'Falta de tiempo para estudiar.', 1),
(182, 'Técnicas poco adecuadas para estudiar la materia (memorización, análisis de casos, ejercicios, resumen, mapas mentales).', 1),
(182, 'Explicación insuficiente al contenido de la materia.', 1),
(182, 'Desinterés de mi parte por la materia.', 1),
(182, 'Problemas para comprender la materia.', 1),
(182, 'Poca disponibilidad del maestro para resolver dudas.', 1),
(182, 'Distracción por situaciones familiares y/o personales.', 1),
(183, '', 1),
(184, '', 1)
;

/* ******************************** *
  * ****** ENCUESTA DE EVALUACIÓN DE TUTORÍA 2DO SEMESTRE EN DELANTE********** *
  * ******************************** */
-- ENCUESTA DE EVALUACIÓN DE TUTORÍA 2DO SEMESTRE EN DELANTE --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    OBJETIVO,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    10,
    'Evaluación de tutoría',
    'Con el objetivo de identificar áreas de mejora, contesta las siguientes afirmaciones respecto al desempeño de tu Tutor y al Programa de Tutoría',
    'Lee las siguientes afirmaciones y marca con una X la opción de la escala que más se acerque a tu experiencia',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA EVALUACIÓN DE TUTORÍA 2DO SEMESTRE EN DELANTE --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    10,
    10,
    'Sección 1 - Evaluación de tutoría',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA EVALUACIÓN DE TUTORÍA 2DO SEMESTRE EN DELANTE
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(185, 10, 1, 185, 'El tutor se reunió conmigo personalmente al menos una vez al semestre para dar seguimiento a mi desempeño académico.', ''),
(186, 10, 1, 186, 'El tutor tenia disponibilidad para atenderme, cada vez que lo solicitaba', ''),
(187, 10, 2, 187, 'El tutor escuchó con atención mis inquietudes y necesidades.', ''),
(188, 10, 2, 188, 'El tutor se comunicó de manera clara y efectiva.', ''),
(189, 10, 2, 189, 'Me trató con respeto y atención', ''),
(190, 10, 2, 190, 'Mostró empatía ante mis inquietudes y necesidades', ''),
(191, 10, 2, 191, 'Me asesoró en función de mi seguimiento académico y trayectoria escolar', ''),
(192, 10, 2, 192, 'Me informó y/o canalizó a los diferentes servicios que ofrece el ITL, en función de mis necesidades ', ''),
(193, 10, 2, 193, 'Las actividades de tutoría contribuyeron a mi formación integral.', ''),
(194, 10, 2, 194, 'La acción tutorial favoreció rendimiento académico y desempeño escolar', ''),
(195, 10, 4, 195, 'En general, la evaluación que le doy a mi tutor es …', ''),
(196, 10, 4, 196, 'En general, la evaluación que le doy a la actividad Tutorial es …', ''),
(197, 10, 6, 197, 'Comentarios y sugerencias', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA DE EVALUACIÓN DE TUTORÍA 2DO SEMESTRE EN DELANTE
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(185, 'Sí', 1), (185, 'No', 1),
(186, 'Sí', 1), (186, 'No', 1),
(187, 'Siempre', 1), (187, 'Casi siempre', 1), (187, 'A veces', 1), (187, 'Nunca', 1),
(188, 'Siempre', 1), (188, 'Casi siempre', 1), (188, 'A veces', 1), (188, 'Nunca', 1),
(189, 'Siempre', 1), (189, 'Casi siempre', 1), (189, 'A veces', 1), (189, 'Nunca', 1),
(190, 'Siempre', 1), (190, 'Casi siempre', 1), (190, 'A veces', 1), (190, 'Nunca', 1),
(191, 'Siempre', 1), (191, 'Casi siempre', 1), (191, 'A veces', 1), (191, 'Nunca', 1),
(192, 'Siempre', 1), (192, 'Casi siempre', 1), (192, 'A veces', 1), (192, 'Nunca', 1),
(193, 'Siempre', 1), (193, 'Casi siempre', 1), (193, 'A veces', 1), (193, 'Nunca', 1),
(194, 'Siempre', 1), (194, 'Casi siempre', 1), (194, 'A veces', 1), (194, 'Nunca', 1),
(197, '', 1)
;

INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    MINIMO,
    MAXIMO
) VALUES
(195, '', 1, 0, 10),
(196, '', 1, 0, 10)
;

/* ******************************** *
  * ****** ENCUESTA DE 16 FACTORES DE PESONALIDAD ********** *
  * ******************************** */
-- ENCUESTA DE 16 FACTORES DE PESONALIDAD --
SET IDENTITY_INSERT CAT_ENCUESTA ON;
INSERT INTO CAT_ENCUESTA(
    PK_ENCUESTA,
    NOMBRE,
    OBJETIVO,
    INSTRUCCIONES,
    ES_ADMINISTRABLE
) VALUES (
    8,
    '16 PF',
    'Con el fin de proporcionarte una mejor orientación para tu desempeño escolar, se solicita contestes las frases que permitirán conocer tus intereses y actitudes.',
    'A continuación se presentan frases y cada una tiene tres posibles respuesta (A, B y C), normalmente la alternativa B es una interrogante que puedes elegir cuando no es posible decidirte entre la A y la C. Da clic en tu elección. Recuerda que no existen contestaciones correctas o incorrectas, porque las personas tienen distintos intreses y ven las cosas desde distintos puntos de vista. Contesta con sinceridad.
    \nAl contestar ten encuenta lo siguiente:  - No pienses demasiado el contenido de las frases, ni emplees mucho tiempo en contestarlas pues tienes 30 minutos para terminar. -Evita señalar la resuesta B (?), excepto cuando te sea imposible decidirte por cualquiera de las otras dos.  -Procura no dejar ninguna frase sin contestar. Es posible que alguna frase no tenga nada que ver contigo, sin embargo intenta elegir la respuesta que vaya mejor con tu modo de ser.   - Contesta sinceramente. No elijas tus respuesta pensando en lo que es bueno o lo que interesa para impresionar al examinador.
    \nLee los ejemplos que se presentan a continuación para hacer un poco de práctica, y piensa cómo los contestarás. Si tienes dudas pregunta al aplicador.',
    0
);
SET IDENTITY_INSERT CAT_ENCUESTA OFF;

-- SECCIONES DE ENCUESTA 16 FACTORES DE PESONALIDAD --
SET IDENTITY_INSERT CAT_SECCION ON;
INSERT INTO CAT_SECCION(
    PK_SECCION,
    FK_ENCUESTA,
    NOMBRE,
    NUMERO,
    ORDEN,
    OBJETIVO,
    INSTRUCCIONES
)  VALUES (
    8,
    8,
    'Sección 1 - 16 PF',
    1,
    1,
    'Objetivo de sección',
    'Instrucciones de la sección'
);
SET IDENTITY_INSERT CAT_SECCION OFF;

-- PREGUNTAS DE ENCUESTA 16 FACTORES DE PESONALIDAD
SET IDENTITY_INSERT CAT_PREGUNTA ON;
INSERT INTO CAT_PREGUNTA(
    PK_PREGUNTA,
    FK_SECCION,
    FK_TIPO_PREGUNTA,
    ORDEN,
    PLANTEAMIENTO,
    TEXTO_GUIA
) VALUES
(198, 8, 2, 198, 'Entendí perfectamente las instrucciones de este cuestionario.', ''),
(199, 8, 2, 199, 'Estoy dispuesto a contestar cada pregunta sinceramente como me sea posible.', ''),
(200, 8, 2, 200, 'Yo preferiría pasar las vacaciones en:', ''),
(201, 8, 2, 201, 'Cuando estoy en un lugar pequeño, apretujado (como un elevador lleno de gente) tengo la desagradable sensación de estar "encerrado".', ''),
(202, 8, 2, 202, 'De repente me encuentro pensando una y otra vez en problemas sin importancia y tengo que hacer un esfuerzo muy grande para quitármelos de la cabeza. ', ''),
(203, 8, 2, 203, 'Si sé que una persona está equivocada en su forma de pensar, yo prefiero:', ''),
(204, 8, 2, 204, 'Mis ideas parecen estar:', ''),
(205, 8, 2, 205, 'Yo no soy muy aficionado a decir chistes novedosos ni a contar cuentos divertidos.', ''),
(206, 8, 2, 206, 'Es mejor alcanzar una vejez tranquila que agotarse sirviendo a la comunidad.', ''),
(207, 8, 2, 207, 'He participado activamente en la organización de un club, equipo o grupo similar.', ''),
(208, 8, 2, 208, 'No puedo evitar el ser sentimental.', ''),
(209, 8, 2, 209, 'Preferiría leer un libro sobre:', ''),
(210, 8, 2, 210, 'Son muy pocos los temas que me molestan con facilidad.', ''),
(211, 8, 2, 211, 'Las aptitudes y características que heredamos de los padres son más importantes de lo que mucha gente está dispuesta a admitir.', ''),
(212, 8, 2, 212, 'Pienso que las tareas rutinarias siempre deben cumplirse, aun cuando un poco de inventiva indique que esto no es necesario.', ''),
(213, 8, 2, 213, 'Está bien bromear acerca de la muerte y generalmente esto no es de mal gusto.', ''),
(214, 8, 2, 214, 'Me gusta que me digan cómo hacer las cosas en vez de investigar por mí mismo.', ''),
(215, 8, 2, 215, 'A veces, a pesar de encontrarme en un grupo, me dominan sentimientos de soledad y de inutilidad.', ''),
(216, 8, 2, 216, 'Mi memoria no cambia mucho de un día a otro.', ''),
(217, 8, 2, 217, 'Creo que uno debe quejarse con el mesero o el administrador de un restaurante, cuando sirven mala comida.', ''),
(218, 8, 2, 218, 'Para descansar prefiero:', ''),
(219, 8, 2, 219, 'En comparación con otras personas, yo he participado:', ''),
(220, 8, 2, 220, 'Cuando hago planes, frecuentemente me gusta confiar en la suerte.', ''),
(221, 8, 2, 221, 'Cuando estoy comiendo, trabajando, etc.:', ''),
(222, 8, 2, 222, 'Me siento inquieto como si quisiera hacer algo pero sin saber qué:', ''),
(223, 8, 2, 223, 'En una fábrica preferiría estar encargado de:', ''),
(224, 8, 2, 224, 'Preferiría leer un libro sobre:', ''),
(225, 8, 2, 225, '¿Cuál de las siguientes palabras no corresponde a las otras dos?', ''),
(226, 8, 2, 226, 'Si otra vez pudiera volver a vivir mi vida:', ''),
(227, 8, 2, 227, 'Las decisiones tomadas en mi vida y en mi trabajo nunca me ocasionaron problemas por la falta de comprensión de mi familia.', ''),
(228, 8, 2, 228, 'Yo evito decir las cosas raras que incomodan a la gente.', ''),
(229, 8, 2, 229, 'Si tuviera una pistola en mis manos y supiera que está cargada me sentiría nervioso hasta que no la descargara.', ''),
(230, 8, 2, 230, 'Me gusta mucho jugarle bromas a la gene, sin ninguna malicia.', ''),
(231, 8, 2, 231, 'Hay gente que utiliza mucho de su tiempo libre en tareas y asuntos comunes con sus vecinos.', ''),
(232, 8, 2, 232, 'A veces siento que por falta de seguridad en mí mismo, no tengo suficiente éxito social.', ''),
(233, 8, 2, 233, 'Yo disfruto conversando, y rara vez dejo pasar la oportunidad de hablar con un extraño.', ''),
(234, 8, 2, 234, 'El encabezado de periódico que más me interesaría sería:', ''),
(235, 8, 2, 235, 'Dudo de la franqueza de la gente que es más amistosa de lo que yo esperaba.', ''),
(236, 8, 2, 236, 'Mi consejo para la gente es:', ''),
(237, 8, 2, 237, 'Para mí es más importante:', ''),
(238, 8, 2, 238, 'Me gusta soñar despierto.', ''),
(239, 8, 2, 239, 'Me gusta más un trabajo que requiera de decisiones ingeniosas de mi parte, que uno que exija respuestas rápidas y rutinarias.', ''),
(240, 8, 2, 240, 'Siento que mis amistades no me necesitan tanto como yo a ellas.', ''),
(241, 8, 2, 241, 'Si alguien pensara mal de mí, me preocuparía:', ''),
(242, 8, 2, 242, 'He sufrido accidentes por estar sumido en mis pensamientos.', ''),
(243, 8, 2, 243, 'En mi periódico me gusta leer:', ''),
(244, 8, 2, 244, 'Me entretienen más los libros que la compañía de alguien.', ''),
(245, 8, 2, 245, 'Por más difíciles y desagradables que sean los obstáculos, yo siempre insisto y mantengo mis intenciones originales.', ''),
(246, 8, 2, 246, 'Ciertos ruidos me alteran los nervios: una puerta que rechina me provoca escalofrío y se me hace insoportable.', ''),
(247, 8, 2, 247, 'Cuando me despierto en la mañana, frecuentemente me siento cansado.', ''),
(248, 8, 2, 248, 'Con el mismo sueldo, preferiría ser:', ''),
(249, 8, 2, 249, 'Vender cosas o pedir fondos para ayudar a una causa en la que yo creo, es  para mí:', ''),
(250, 8, 2, 250, '¿Cuál de los siguientes tres números no corresponde a la misma clase que los otros dos?', ''),
(251, 8, 2, 251, '"Perro" es a "hueso", como "vaca" es a:', ''),
(252, 8, 2, 252, 'Los cambios de temperatura generalmente no afectan mi eficiencia, ni mi estado de ánimo.', ''),
(253, 8, 2, 253, 'En una ciudad extraña:', ''),
(254, 8, 2, 254, 'Es más importante:', ''),
(255, 8, 2, 255, 'Yo creo:', ''),
(256, 8, 2, 256, 'Cuando me dan una serie de reglas, las sigo cuando personalmente me convienen, en lugar de seguirlas al pie de la letra.', ''),
(257, 8, 2, 257, 'En mis relaciones sociales a veces me preocupa un sentimiento de inferioridad sin que haya motivo alguno.', ''),
(258, 8, 2, 258, 'Me siento algo incómodo cuando estoy en compañía de otros, y  no me muestro a ellos tan bien como debiera.', ''),
(259, 8, 2, 259, 'Preferiría:', ''),
(260, 8, 2, 260, 'La mayoría de las personas aceptan su propia culpa, aunque pueden echársela a otros.', ''),
(261, 8, 2, 261, 'En realidad a nadie le gustaría verme en dificultades.', ''),
(262, 8, 2, 262, 'Para un hombre es más importante preocuparse por:', ''),
(263, 8, 2, 263, 'Estar mucho tiempo encerrado, lejos del aire libre, me hace sentir rancio.', ''),
(264, 8, 2, 264, 'Se me ocurren ideas poco usuales sobre gran variedad de cosas; demasiadas para ponerlas en práctica.', ''),
(265, 8, 2, 265, 'Por lo general soy optimista a pesar de que tropiece con muchas dificultades.', ''),
(266, 8, 2, 266, 'De noche me cuesta trabajo dormir por preocuparme por un incidente desafortunado.', ''),
(267, 8, 2, 267, 'Preferiría ver:', ''),
(268, 8, 2, 268, 'Mis amistades piensan que es difícil conocerme a fondo.', ''),
(269, 8, 2, 269, 'Resuelvo mejor un problema:', ''),
(270, 8, 2, 270, 'Cuando tengo que hacer decisiones rápidas:', ''),
(271, 8, 2, 271, 'Algunas veces encuentro que pensamientos y recuerdos inútiles me dan vuelta en la mente.', ''),
(272, 8, 2, 272, 'En las discusiones nunca me siento tan molesto como para no poder controlar mi voz.', ''),
(273, 8, 2, 273, 'Cuando viajo prefiero mirar el paisaje que conversar con la gente.', ''),
(274, 8, 2, 274, '¿"Perder" es un mejor opuesto a "revelar" que la palabra "esconder"?', ''),
(275, 8, 2, 275, '"Negro" es a "gris" como "dolor" es a:', ''),
(276, 8, 2, 276, 'Se me hace difícil aceptar un "no" como respuesta, aun cuando sé que estoy pidiendo lo imposible.', ''),
(277, 8, 2, 277, 'Con frecuencia, la forma como me dicen las cosas me duele más que lo que me están diciendo.', ''),
(278, 8, 2, 278, 'Me incomoda tener sirvientes que me atiendan.', ''),
(279, 8, 2, 279, 'Cuando un grupo de amigos sostiene una conversación animada:', ''),
(280, 8, 2, 280, 'Me gusta estar en medio de mucha excitación, bullicio y ruido.', ''),
(281, 8, 2, 281, 'En el trabajo, es más importante ser popular con la gente importante que hacer un trabajo de primera.', ''),
(282, 8, 2, 282, 'Si la gente me observa en la calle o en una tienda me siento ligeramente avergonzado.', ''),
(283, 8, 2, 283, 'Mis ideas no siempre pueden ponerse fácilmente en palabras, por eso no intervengo tanto en la conversación como la mayoría de la gente.', ''),
(284, 8, 2, 284, 'Siempre estoy interesasdo en asuntos de mecánica, por ejemplo en carros y aeroplanos.', ''),
(285, 8, 2, 285, 'Lo que hace que la mayor parte de la gente se abstenga de realizar actos criminales o deshonestos es principalmente el temor a ser aprehendida.', ''),
(286, 8, 2, 286, 'Realmente en el mundo hay más gente simpática que indeseable.', ''),
(287, 8, 2, 287, 'Los sujetos indiferentes que dicen "lo mejor de la vida es gratis", no han trabajado para conseguir mucho.', ''),
(288, 8, 2, 288, 'Si en una junta la gente sólo habla sin llegar al grano:', ''),
(289, 8, 2, 289, 'Una persona cuyas ambiciones lastiman o dañan a un amigo cercano, a pesar de eso puede ser considerada todavía como un ciudadano común y corriente.', ''),
(290, 8, 2, 290, 'Cuando pequeñas cosas me salen mal, una tras otra, yo:', ''),
(291, 8, 2, 291, 'Me aquejan sentimientos de culpa o remordimiento, en relación a asuntos insignificantes.', ''),
(292, 8, 2, 292, 'Sería mejor si toda la gente se reuniera en prácticas religiosas públicas con regularidad.', ''),
(293, 8, 2, 293, 'Cuando se proyectan salidas en grupo:', ''),
(294, 8, 2, 294, 'Mucha gente me platica sus problemas y me pide consejo cuando necesitan a alguien con quien hablar.', ''),
(295, 8, 2, 295, 'Si mis amigos me excluyen de algo que están haciendo:', ''),
(296, 8, 2, 296, 'En ciertos estados de ánimo, fácilmente me alejo del trabajo que estoy haciendo por distracciones y ensoñaciones.', ''),
(297, 8, 2, 297, 'No me precipito para aceptar o rechazar a las personas que acabo de conocer.', ''),
(298, 8, 2, 298, 'Preferiría ser:', ''),
(299, 8, 2, 299, '"Abril" es a "marzo", como "martes" es a:', ''),
(300, 8, 2, 300, '¿Cuál de las siguientes palabras es distinta a las otras dos?', ''),
(301, 8, 2, 301, 'Cruzo la calle para evitar encontrarme con gente que no deseo ver.', ''),
(302, 8, 2, 302, 'El número de problemas que se me presentan y que no puedo resolver por mi propia cuenta, en un día ordinario, son:', ''),
(303, 8, 2, 303, 'Si estuviera en desacuerdo con los puntos de vista de un maestro, por lo general:', ''),
(304, 8, 2, 304, 'Cuando hablo con personas del sexo opuesto, evito cualquier tema sexual vergonzoso.', ''),
(305, 8, 2, 305, 'Realmente no tengo éxito cuando trato a la gente.', ''),
(306, 8, 2, 306, 'Me agrada dar lo mejor de mí tiempo y energía a:', ''),
(307, 8, 2, 307, 'Cuando trato de impresionar favorablemente a la gente con mi personalidad:', ''),
(308, 8, 2, 308, 'Prefiero tener:', ''),
(309, 8, 2, 309, 'Preferiría ser filósofo que ingeniero mecánico.', ''),
(310, 8, 2, 310, 'Tiendo a criticar el trabajo de otras personas.', ''),
(311, 8, 2, 311, 'Me agrada planear cuidadosamente el cómo influir sobre mis compañeros para que me ayuden a lograr mis metas.', ''),
(312, 8, 2, 312, 'Pienso que soy más sensible que  la mayoría de las personas a las cualidades artísticas de lo que me rodea.', ''),
(313, 8, 2, 313, 'Mis amigos creen que soy algo distraído y poco práctico.', ''),
(314, 8, 2, 314, 'Con mis conocidos prefiero:', ''),
(315, 8, 2, 315, 'A veces soy tan feliz, que me asusta pensar que mi felicidad no pueda ser duradera.', ''),
(316, 8, 2, 316, 'En ocasiones tengo períodos en que me siento deprimido, miserable y pesimista sin razón suficiente.', ''),
(317, 8, 2, 317, 'En mi trabajo la mayoría de los problemas son ocasionados por personas que:', ''),
(318, 8, 2, 318, 'Me agrada que mis conocidos me consideren como uno de los suyos.', ''),
(319, 8, 2, 319, 'Cuando busco una calle en una ciudad desconocida:', ''),
(320, 8, 2, 320, 'Algunas veces alboroto a mis amigos para que salgamos cuando en realidad ellos quieren quedarse en casa.', ''),
(321, 8, 2, 321, 'Cuando he estado muy activo o he trabajado demasiado, sufro de indigestión o estreñimiento.', ''),
(322, 8, 2, 322, 'Si alguien me molesta:', ''),
(323, 8, 2, 323, 'Sería más interesante ser vendedor de seguros que granjero.', ''),
(324, 8, 2, 324, '"Estatua" es a "forma" como "canción" es a:', ''),
(325, 8, 2, 325, '¿Cuáles de las siguientes palabras es distinta a las otras dos?', ''),
(326, 8, 2, 326, 'Creo que en la vida moderna se tienen demasiadas frustraciones y restricciones, desagradables.', ''),
(327, 8, 2, 327, 'Me siento preparado para la vida y sus exigencias.', ''),
(328, 8, 2, 328, 'Yo francamente hago más planes y soy más  energético y ambicioso que muchos que han alcanzado el mismo éxito que yo.', ''),
(329, 8, 2, 329, 'Casi siempre me gustan las emociones fuertes.', ''),
(330, 8, 2, 330, 'Sería más interesante ser', ''),
(331, 8, 2, 331, 'Me parece conveniente hacer palnes para evitar pérdida de tiempo entre trabajo y trabajo.', ''),
(332, 8, 2, 332, 'En un grupo generalmente estoy:', ''),
(333, 8, 2, 333, 'Cuando me uno a un grupo nuevo, me parece que encajo de inmediato.', ''),
(334, 8, 2, 334, 'Me gusta mucho el humorismo picante y grotesco de algunos programas de televisión.', ''),
(335, 8, 2, 335, 'Preferiría leer sobre:', ''),
(336, 8, 2, 336, 'Generalmente no pierdo las esperanzas frente a las dificultades ordinarias.', ''),
(337, 8, 2, 337, 'Estoy menos interesado en tener éxito en las cosas prácticas y financieras que en buscar verdades artísticas y espirituales.', ''),
(338, 8, 2, 338, 'Me gustaria más bien leer:', ''),
(339, 8, 2, 339, 'En las discusiones sobre arte, religión o política, rara vez me involucro o excito tanto, como para olvidar la cortesía y las relaciones humanas.', ''),
(340, 8, 2, 340, 'Cuando voy a tomar un tren,  me siento un poco apurado, tenso o ansioso aunque sepa que me queda tiempo.', ''),
(341, 8, 2, 341, 'Me gusta enfrentarme a los problemas que otras personas han dejado enredados.', ''),
(342, 8, 2, 342, 'La socidad debería estar guiada más por el pensamiento lógico  y menos por creecias tradicionales y sentimentales.', ''),
(343, 8, 2, 343, 'Cuando hago lo que quiero, por lo general me parece que:', ''),
(344, 8, 2, 344, 'La situaciones molestas tienden a aturdirme y a excitarme demasiado.', ''),
(345, 8, 2, 345, 'Hago lo posible por no distraerme ni olvidarme de los detalles.', ''),
(346, 8, 2, 346, 'A veces quedo tembloroso y exhausto a raíz de una discusión acalorada, o cuando he estado a punto de sufrir un accidente, de forma tal que no puedo volver a lo que estaba haciendo.', ''),
(347, 8, 2, 347, 'Me siento a punto de estallar, debido a mis sentimientos.', ''),
(348, 8, 2, 348, 'Como pasatiempo preferiría pertenecer a:', ''),
(349, 8, 2, 349, '"Combinar" es a "mezclar", como "equipo" es a:', ''),
(350, 8, 2, 350, '"Reloj" es a "tiempo" como "sastre" es a:', ''),
(351, 8, 2, 351, 'Me es difícil seguir lo que algunas personas están tratando de decir por el extraño uso que hacen de las palabras comunes.', ''),
(352, 8, 2, 352, 'Los agentes del ministerio público están interesados principalmente en:', ''),
(353, 8, 2, 353, 'La gente algunas veces me ha llamado orgulloso y creído.', ''),
(354, 8, 2, 354, 'Preferiría la vida de un impresor artístico que la de un promotor y publicista.', ''),
(355, 8, 2, 355, 'Tiendo más bien a hablar pausadamente.', ''),
(356, 8, 2, 356, 'Cuando hago algo, mi principal preocupación es que:', ''),
(357, 8, 2, 357, 'Yo pienso que la mayoría de los cuentos y de las películas deberían enseñar principios  éticos.', ''),
(358, 8, 2, 358, 'Iniciar conversaciones con extraños:', ''),
(359, 8, 2, 359, 'Siempre me divierte herir la dignidad de los maestros, de los jueces y de la gente "culta".', ''),
(360, 8, 2, 360, 'En la televisión preferiría ver:', ''),
(361, 8, 2, 361, 'Me irrita la gente que adopta actitudes moralmente superiores.', ''),
(362, 8, 2, 362, 'Preferiría ocupar mi tiempo disfrutando de:', ''),
(363, 8, 2, 363, 'A veces no me decido a utilizar mis propias ideas por temor a que no sean prácticas.', ''),
(364, 8, 2, 364, 'Siempre soy cortés y diplomático con la gente poco razonable o poco imaginativa, y no creo que sea prudente señalarle su falta de criterio.', ''),
(365, 8, 2, 365, 'Preferiría vivir en una ciudad progresista que en una aldea tranquila en el campo.', ''),
(366, 8, 2, 366, 'Cuando estoy en desacuerdo con alguien sobre cuestiones sociales, me gusta:', ''),
(367, 8, 2, 367, 'Creo que la gente debe meditar más antes de condenar la sabiduría del pasado.', ''),
(368, 8, 2, 368, 'Obtengo tantas ideas al leer un libro yo mismo, como cuando discuto sus temas con otras personas.', ''),
(369, 8, 2, 369, 'Algunas personas critican mi sentido de responsabilidad.', ''),
(370, 8, 2, 370, 'Yo me considero como:', ''),
(371, 8, 2, 371, 'A veces mis sentimientos y emociones me impiden controlarme.', ''),
(372, 8, 2, 372, 'Me siento tan furioso que quisiera azotar una puerta, o tal vez romper el vidrio de una ventana.', ''),
(373, 8, 2, 373, 'Disfrutaría más:', ''),
(374, 8, 2, 374, '"Justicia" es a "leyes", como "idea" es a:', ''),
(375, 8, 2, 375, '¿Cuál de las siguientes palabras no corresponde a las otras dos?', ''),
(376, 8, 2, 376, 'Preferiría llevar:', ''),
(377, 8, 2, 377, 'Yo pienso que la cosa más importante en la vida es hacer lo que a mí me gusta.', ''),
(378, 8, 2, 378, 'Mi voz es:', ''),
(379, 8, 2, 379, 'Me gusta actuar impulsivamente, aun cuando esto me traiga problemas posteriores.', ''),
(380, 8, 2, 380, 'Se me describe adecuadamente como una persona alegre y despreocupada.', ''),
(381, 8, 2, 381, 'Me disgusta mucho ver el desorden.', ''),
(382, 8, 2, 382, 'Siempre reviso con mucho cuidado el estado en que devuelo o me devuelven las cosas que presto o me prestan.', ''),
(383, 8, 2, 383, 'En grupos sociales me molesta darme cuenta de mi timidez.', ''),
(384, 8, 2, 384, 'Estoy seguro de haber contestado correctamente, y de no haber dejado ninguna pregunta sin contestar.', '')
;
SET IDENTITY_INSERT CAT_PREGUNTA OFF;

-- RESPUESTAS POSIBLES ENCUESTA 16 FACTORES DE PESONALIDAD
INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN
) VALUES
(198, 'Verdadero.', 1),     (198, '?', 2),      (198, 'Falso.', 3),
(199, 'Verdadero.', 1),     (199, '?', 2),      (199, 'Falso.', 3),
(200, 'un centro turístico atendido.', 1), 	(200, 'algo entre a y b.', 2), 	(200, 'una cabaña tranquila lejos del ruido.', 3),
(201, 'nunca.', 1),         (201, 'rara vez.', 2), 	(201, 'en algunas ocasiones.', 3),
(202, 'Verdadero.', 1),     (202, '?', 2), 	(202, 'Falso.', 3),
(203, 'quedarme callado.', 1), 	(203, '?', 2), 	(203, 'decírselo.', 3),
(204, 'adelantadas a la época.', 1), 	(204, '?', 2), 	(204, 'de acuerdo a la época.', 3),
(205, 'Verdadero.', 1), 	(205, '?', 2), 	(205, 'Falso.', 3),
(206, 'Verdadero.', 1), 	(206, '?', 2), 	(206, 'Falso.', 3),
(207, 'sí, con frecuencia.', 1), 	(207, 'en ocasiones.', 2), 	(207, 'nunca.', 3),
(208, 'en ocasiones. ', 1), 	(208, 'con alguna frecuencia.', 2), 	(208, 'muchas veces.', 3),
(209, 'grandes enseñanzas religiosas.', 1), 	(209, '?', 2), 	(209, 'nuestra organización política.', 3),
(210, 'Verdadero.', 1), 	(210, '?', 2), 	(210, 'Falso.', 3),
(211, 'Verdadero.', 1), 	(211, '?', 2), 	(211, 'Falso.', 3),
(212, 'Verdadero.', 1), 	(212, '?', 2), 	(212, 'Falso.', 3),
(213, 'Verdadero.', 1), 	(213, '?', 2), 	(213, 'Falso.', 3),
(214, 'Verdadero.', 1), 	(214, '?', 2), 	(214, 'Falso.', 3),
(215, 'Verdadero.', 1), 	(215, '?', 2), 	(215, 'Falso.', 3),
(216, 'Verdadero.', 1), 	(216, '?', 2), 	(216, 'Falso.', 3),
(217, 'Verdadero.', 1), 	(217, '?', 2), 	(217, 'Falso.', 3),
(218, 'deportes o juegos.', 1), 	(218, '?', 2), 	(218, 'debates o pasatiempos intelectuales.', 3),
(219, 'en muchas actividades sociales.', 1), 	(219, '?', 2), 	(219, 'en pocas actividades sociales.', 3),
(220, 'Verdadero.', 1), 	(220, '?', 2), 	(220, 'Falso.', 3),
(221, 'doy la impresión de pasar rápidamente de una cosa a otra.', 1), 	(221, '?', 2), 	(221, 'me conduzco en forma metódica y cuidadosa.', 3),
(222, 'muy rara vez.', 1), 	(222, 'en ocasiones.', 2), 	(222, 'a menudo.', 3),
(223, 'aspectos mecánicos.', 1), 	(223, '?', 2), 	(223, 'entrevistar y contratar personal.', 3),
(224, 'viajes espaciales.', 1), 	(224, '?', 2), 	(224, 'educación en la familia.', 3),
(225, 'perro.', 1), 	(225, 'pájaro.', 2), 	(225, 'vaca.', 3),
(226, 'haría planes diferentes.', 1), 	(226, '?', 2), 	(226, 'me gustaría que fuera casi igual.', 3),
(227, 'Verdadero.', 1), 	(227, '?', 2), 	(227, 'Falso.', 3),
(228, 'Verdadero.', 1), 	(228, '?', 2), 	(228, 'Falso.', 3),
(229, 'Verdadero.', 1), 	(229, '?', 2), 	(229, 'Falso.', 3),
(230, 'Verdadero.', 1), 	(230, '?', 2), 	(230, 'Falso.', 3),
(231, 'Verdadero.', 1), 	(231, '?', 2), 	(231, 'Falso.', 3),
(232, 'Verdadero.', 1), 	(232, '?', 2), 	(232, 'Falso.', 3),
(233, 'Verdadero.', 1), 	(233, '?', 2), 	(233, 'Falso.', 3),
(234, '"Líderes religiosos discuten sobre un credo unificado".', 1), 	(234, '?', 2), 	(234, '"Mejoras en la producción y el mercado".', 3),
(235, 'Verdadero.', 1), 	(235, '?', 2), 	(235, 'Falso.', 3),
(236, 'siga adelante, inténtelo; no pierde nada.', 1), 	(236, '?', 2), 	(236, 'primero piénselo bien, no vaya a hacer una tontería.', 3),
(237, 'expresarme con libertad.', 1), 	(237, '?', 2), 	(237, 'establecer buenas relaciones con las personas.', 3),
(238, 'Verdadero.', 1), 	(238, '?', 2), 	(238, 'Falso.', 3),
(239, 'Verdadero.', 1), 	(239, '?', 2), 	(239, 'Falso.', 3),
(240, 'Verdadero.', 1), 	(240, '?', 2), 	(240, 'Falso.', 3),
(241, 'casi nunca.', 1), 	(241, 'ocasionalmente.', 2), 	(241, 'muy a menudo.', 3),
(242, 'casi nunca.', 1), 	(242, '?', 2), 	(242, 'varias veces.', 3),
(243, 'una discusión sobre aspectos sociales básicos del mundo moderno.', 1), 	(243, '?', 2), 	(243, 'un buen reportaje de todas las noticias locales.', 3),
(244, 'Verdadero.', 1), 	(244, '?', 2), 	(244, 'Falso.', 3),
(245, 'Verdadero.', 1), 	(245, '?', 2), 	(245, 'Falso.', 3),
(246, 'a menudo.', 1), 	(246, 'Algunas veces.', 2), 	(246, 'nunca.', 3),
(247, 'Verdadero.', 1), 	(247, '?', 2), 	(247, 'Falso.', 3),
(248, 'investigador químico.', 1), 	(248, '?', 2), 	(248, 'administrador de un hotel.', 3),
(249, 'bastante agradable.', 1), 	(249, '?', 2), 	(249, 'un trabajo desagradable.', 3),
(250, '7', 1), 	(250, '9', 2), 	(250, '13', 3),
(251, 'leche.', 1), 	(251, 'pasto.', 2), 	(251, 'sal.', 3),
(252, 'Verdadero.', 1), 	(252, '?', 2), 	(252, 'Falso.', 3),
(253, 'caminaría por donde quisiera.', 1), 	(253, '?', 2), 	(253, 'evitaría las partes de la ciudad consideradas peligrosas.', 3),
(254, 'llevarla bien con la gente.', 1), 	(254, '?', 2), 	(254, 'poner en práctica las ideas propias.', 3),
(255, 'en el dicho de "ríe y sé feliz" en la mayoría de las ocasiones.', 1), 	(255, '?', 2), 	(255, 'ser apropiadamente serio en los asuntos cotidianos.', 3),
(256, 'Verdadero.', 1), 	(256, '?', 2), 	(256, 'Falso.', 3),
(257, 'Verdadero, no me siento mal.', 1), 	(257, '?', 2), 	(257, 'Falso.', 3),
(258, 'Verdadero.', 1), 	(258, '?', 2), 	(258, 'Falso.', 3),
(259, 'trabajar con varias personas bajo mis ordenes.', 1), 	(259, '?', 2), 	(259, 'trabajar con un comité.', 3),
(260, 'Verdadero.', 1), 	(260, '?', 2), 	(260, 'Falso.', 3),
(261, 'Verdadero.', 1), 	(261, '?', 2), 	(261, 'Falso.', 3),
(262, 'el significado básico de la vida.', 1), 	(262, '?', 2), 	(262, 'obtener un buen ingreso para su familia.', 3),
(263, 'siempre.', 1), 	(263, 'algunas veces.', 2), 	(263, 'casi nunca.', 3),
(264, 'sí.', 1), 	(264, 'Algunas veces.', 2), 	(264, 'no.', 3),
(265, 'Verdadero.', 1), 	(265, '?', 2), 	(265, 'Falso.', 3),
(266, 'a menudo.', 1), 	(266, 'ocasionalmente.', 2), 	(266, 'pocas veces.', 3),
(267, 'una buena sátira cinematrográfica sobre la sociedad del futuro.', 1), 	(267, '?', 2), 	(267, 'una buena película del oeste.', 3),
(268, 'Verdadero.', 1), 	(268, '?', 2), 	(268, 'Falso.', 3),
(269, 'estudiando solo.', 1), 	(269, '?', 2), 	(269, 'discutiéndolo con otros.', 3),
(270, 'me apoyo en un razonamiento objetivo, tranquilo y lógico.', 1), 	(270, '?', 2), 	(270, 'me pongo tenso, excitable, incapaz de pensar claramente.', 3),
(271, 'Verdadero.', 1), 	(271, '?', 2), 	(271, 'Falso.', 3),
(272, 'Verdadero.', 1), 	(272, '?', 2), 	(272, 'Falso.', 3),
(273, 'Verdadero.', 1), 	(273, '?', 2), 	(273, 'Falso.', 3),
(274, 'Verdadero.', 1), 	(274, '?', 2), 	(274, 'Falso.', 3),
(275, 'torcedura.', 1), 	(275, 'aflicción.', 2), 	(275, 'comezón.', 3),
(276, 'Verdadero.', 1), 	(276, '?', 2), 	(276, 'Falso.', 3),
(277, 'Verdadero.', 1), 	(277, '?', 2), 	(277, 'Falso.', 3),
(278, 'Verdadero.', 1), 	(278, '?', 2), 	(278, 'Falso.', 3),
(279, 'prefiero escuchar con atención.', 1), 	(279, '?', 2), 	(279, 'doy más opiniones que la mayoría de ellos.', 3),
(280, 'Verdadero.', 1), 	(280, '?', 2), 	(280, 'Falso.', 3),
(281, 'Verdadero.', 1), 	(281, '?', 2), 	(281, 'Falso.', 3),
(282, 'Verdadero.', 1), 	(282, '?', 2), 	(282, 'Falso.', 3),
(283, 'Verdadero.', 1), 	(283, '?', 2), 	(283, 'Falso.', 3),
(284, 'Verdadero.', 1), 	(284, '?', 2), 	(284, 'Falso.', 3),
(285, 'Verdadero.', 1), 	(285, '?', 2), 	(285, 'Falso.', 3),
(286, 'Verdadero.', 1), 	(286, '?', 2), 	(286, 'Falso.', 3),
(287, 'Verdadero.', 1), 	(287, '?', 2), 	(287, 'Falso.', 3),
(288, 'las insto a que lleguen a él.', 1), 	(288, '?', 2), 	(288, 'actúo en forma práctica para mantener la armonía.', 3),
(289, 'Verdadero.', 1), 	(289, '?', 2), 	(289, 'Falso.', 3),
(290, 'continúo como si nada hubiera sucedido.', 1), 	(290, '?', 2), 	(290, 'me siento agobiado.', 3),
(291, 'sí, a menudo.', 1), 	(291, 'a veces.', 2), 	(291, 'no.', 3),
(292, 'Verdadero.', 1), 	(292, '?', 2), 	(292, 'Falso.', 3),
(293, 'siempre me complace participar integramente.', 1), 	(293, '?', 2), 	(293, 'me gusta reservarme el derecho a cancelar mi participación.', 3),
(294, 'Verdadero.', 1), 	(294, '?', 2), 	(294, 'Falso.', 3),
(295, 'hago alboroto.', 1), 	(295, '?', 2), 	(295, 'lo tomo con calma, pensando que tienen algún motivo.', 3),
(296, 'Verdadero.', 1), 	(296, '?', 2), 	(296, 'Falso.', 3),
(297, 'Verdadero.', 1), 	(297, '?', 2), 	(297, 'Falso.', 3),
(298, 'administrador de una oficina de negocios.', 1), 	(298, '?', 2), 	(298, 'arquitecto.', 3),
(299, 'miércoles.', 1), 	(299, 'viernes.', 2), 	(299, 'lunes.', 3),
(300, 'prudente o sensato.', 1), 	(300, 'adorable.', 2), 	(300, 'amable.', 3),
(301, 'nunca.', 1), 	(301, 'algunas veces.', 2), 	(301, 'pocas veces.', 3),
(302, 'apenas uno.', 1), 	(302, '?', 2), 	(302, 'más de media docena.', 3),
(303, 'me guardaría mi opinión.', 1), 	(303, '?', 2), 	(303, 'le diría que mi opinión es diferente.', 3),
(304, 'Verdadero.', 1), 	(304, '?', 2), 	(304, 'Falso.', 3),
(305, 'Verdadero.', 1), 	(305, '?', 2), 	(305, 'Falso.', 3),
(306, 'mi hogar y las necesidades reales de mis amigos.', 1), 	(306, '?', 2), 	(306, 'actividades sociales y pasatiempos personales.', 3),
(307, 'casi siempre tengo éxito.', 1), 	(307, 'algunas veces tengo éxito.', 2), 	(307, 'por lo general estoy inseguro de mi éxito.', 3),
(308, 'un gran número de conocidos.', 1), 	(308, '?', 2), 	(308, 'solo pocos amigos leales.', 3),
(309, 'Verdadero.', 1), 	(309, '?', 2), 	(309, 'Falso.', 3),
(310, 'Verdadero.', 1), 	(310, '?', 2), 	(310, 'Falso.', 3),
(311, 'Verdadero.', 1), 	(311, '?', 2), 	(311, 'Falso.', 3),
(312, 'Verdadero.', 1), 	(312, '?', 2), 	(312, 'Falso.', 3),
(313, 'Verdadero.', 1), 	(313, '?', 2), 	(313, 'Falso.', 3),
(314, 'platicar sobre hechos y asuntos impersonales.', 1), 	(314, '?', 2), 	(314, 'charlar con la gente y de sus sentimientos.', 3),
(315, 'Verdadero.', 1), 	(315, '?', 2), 	(315, 'Falso.', 3),
(316, 'Verdadero.', 1), 	(316, '?', 2), 	(316, 'Falso.', 3),
(317, 'cambian constantemente los métodos que ya estaban bien.', 1), 	(317, '?', 2), 	(317, 'se rehusan a emplear métodos más modernos.', 3),
(318, 'Verdadero.', 1), 	(318, '?', 2), 	(318, 'Falso.', 3),
(319, 'le pregunto a la gente dónde se encuentra esa calle.', 1), 	(319, '?', 2), 	(319, 'la busco en un mapa.', 3),
(320, 'Verdadero.', 1), 	(320, '?', 2), 	(320, 'Falso.', 3),
(321, 'ocasionalmente.', 1), 	(321, 'casi nunca.', 2), 	(321, 'nunca.', 3),
(322, 'me aguanto.', 1), 	(322, '?', 2), 	(322, 'tengo que hablar con alguien para descargar mi enojo.', 3),
(323, 'Verdadero.', 1), 	(323, '?', 2), 	(323, 'Falso.', 3),
(324, 'belleza.', 1), 	(324, 'notas.', 2), 	(324, 'tonada.', 3),
(325, 'tararear.', 1), 	(325, 'hablar. ', 2), 	(325, 'xooo.', 3),
(326, 'Verdadero.', 1), 	(326, '?', 2), 	(326, 'Falso.', 3),
(327, 'Verdadero.', 1), 	(327, '?', 2), 	(327, 'Falso.', 3),
(328, 'Verdadero.', 1), 	(328, '?', 2), 	(328, 'Falso.', 3),
(329, 'Verdadero.', 1), 	(329, '?', 2), 	(329, 'Falso.', 3),
(330, 'actor.', 1), 	(330, '?', 2), 	(330, 'constructor de casas.', 3),
(331, 'Verdadero.', 1), 	(331, '?', 2), 	(331, 'Falso.', 3),
(332, 'al tanto de lo que pasa a mi alrededor.', 1), 	(332, '?', 2), 	(332, 'envuelto en mis propios pensamientos o asuntos recientes.', 3),
(333, 'Verdadero.', 1), 	(333, '?', 2), 	(333, 'Falso.', 3),
(334, 'Verdadero.', 1), 	(334, '?', 2), 	(334, 'Falso.', 3),
(335, 'el descubrimiento de pinturas indígenas antiguas.', 1), 	(335, '?', 2), 	(335, 'asesinatos de indios.', 3),
(336, 'Verdadero.', 1), 	(336, '?', 2), 	(336, 'Falso.', 3),
(337, 'Verdadero.', 1), 	(337, '?', 2), 	(337, 'Falso.', 3),
(338, 'una buena novela histórica.', 1), 	(338, '?', 2), 	(338, 'un ensayo científico sobre el aprovechamiento de los recursos mundiales.', 3),
(339, 'Verdadero.', 1), 	(339, '?', 2), 	(339, 'Falso.', 3),
(340, 'sí.', 1), 	(340, 'a veces.', 2), 	(340, 'no.', 3),
(341, 'Verdadero.', 1), 	(341, '?', 2), 	(341, 'Falso.', 3),
(342, 'Verdadero.', 1), 	(342, '?', 2), 	(342, 'Falso.', 3),
(343, 'me comprenden solamente mis amigos íntimos.', 1), 	(343, '?', 2), 	(343, 'estoy haciendo lo que la mayoría de la gente piensa que está bien.', 3),
(344, 'Verdadero.', 1), 	(344, '?', 2), 	(344, 'Falso.', 3),
(345, 'Verdadero.', 1), 	(345, '?', 2), 	(345, 'Falso.', 3),
(346, 'Verdadero.', 1), 	(346, '?', 2), 	(346, 'Falso.', 3),
(347, 'rara vez.', 1), 	(347, 'ocasionalmente.', 2), 	(347, 'con frecuencia.', 3),
(348, 'un club fotográfico.', 1), 	(348, '?', 2), 	(348, 'un club de debates.', 3),
(349, 'grupo.', 1), 	(349, 'ejército.', 2), 	(349, 'juego.', 3),
(350, 'cinta métrica.', 1), 	(350, 'tijeras.', 2), 	(350, 'ropa.', 3),
(351, 'Verdadero.', 1), 	(351, '?', 2), 	(351, 'Falso.', 3),
(352, 'encontrar pruebas condenatorias.', 1), 	(352, '?', 2), 	(352, 'proteger al inocente.', 3),
(353, 'Verdadero.', 1), 	(353, '?', 2), 	(353, 'Falso.', 3),
(354, 'Verdadero.', 1), 	(354, '?', 2), 	(354, 'Falso.', 3),
(355, 'Sí.', 1), 	(355, '?', 2), 	(355, 'No.', 3),
(356, 'sea realmente lo que yo quiero hacer.', 1), 	(356, '?', 2), 	(356, 'que no tenga consecuencias nocivas para mis compañeros.', 3),
(357, 'Verdadero.', 1), 	(357, '?', 2), 	(357, 'Falso.', 3),
(358, 'es difícil para mí.', 1), 	(358, '?', 2), 	(358, 'nunca me causa problema.', 3),
(359, 'Verdadero, puedo afrontarlos fácilmente.', 1), 	(359, '?', 2), 	(359, 'Falso.', 3),
(360, 'a una gran concertista.', 1), 	(360, '?', 2), 	(360, 'un programa práctico e informativo sobre nuevos inventos.', 3),
(361, 'Verdadero, puedo afrontarlos fácilmente.', 1), 	(361, '?', 2), 	(361, 'Falso.', 3),
(362, 'un juego de cartas con mis amigos.', 1), 	(362, '?', 2), 	(362, 'los hermosos objetos de una galería de arte.', 3),
(363, 'Verdadero.', 1), 	(363, '?', 2), 	(363, 'Falso.', 3),
(364, 'Verdadero.', 1), 	(364, '?', 2), 	(364, 'Falso.', 3),
(365, 'Verdadero.', 1), 	(365, '?', 2), 	(365, 'Falso.', 3),
(366, 'encontrar básicamente cuál es nuestra diferencia.', 1), 	(366, '?', 2), 	(366, 'llegar a una solución satisfactoria para ambos.', 3),
(367, 'Verdadero.', 1), 	(367, '?', 2), 	(367, 'Falso.', 3),
(368, 'Verdadero.', 1), 	(368, '?', 2), 	(368, 'Falso.', 3),
(369, 'Verdadero.', 1), 	(369, '?', 2), 	(369, 'Falso.', 3),
(370, 'una persona activa y práctica.', 1), 	(370, '?', 2), 	(370, 'un soñador.', 3),
(371, 'Verdadero.', 1), 	(371, '?', 2), 	(371, 'Falso.', 3),
(372, 'muy rara vez.', 1), 	(372, 'ocasionalmente.', 2), 	(372, 'con bastante frecuencia.', 3),
(373, 'estando encargado de juegos de niños.', 1), 	(373, '?', 2), 	(373, 'ayudando a un relojero.', 3),
(374, 'palabras.', 1), 	(374, 'sentimientos.', 2), 	(374, 'teorías.', 3),
(375, 'segundo.', 1), 	(375, 'una vez.', 2), 	(375, 'único.', 3),
(376, 'el mismo tipo de vida que llevo ahora.', 1), 	(376, '?', 2), 	(376, 'una vida más tranquila con menos dificultades que tuviera que enfrentar.', 3),
(377, 'Verdadero.', 1), 	(377, '?', 2), 	(377, 'Falso.', 3),
(378, 'fuerte.', 1), 	(378, 'termino medio.', 2), 	(378, 'suave.', 3),
(379, 'Verdadero.', 1), 	(379, '?', 2), 	(379, 'Falso.', 3),
(380, 'Verdadero.', 1), 	(380, '?', 2), 	(380, 'Falso.', 3),
(381, 'Verdadero.', 1), 	(381, '?', 2), 	(381, 'Falso.', 3),
(382, 'Verdadero.', 1), 	(382, '?', 2), 	(382, 'Falso.', 3),
(383, 'nunca.', 1), 	(383, 'algunas veces.', 2), 	(383, 'con frecuencia.', 3),
(384, 'sí.', 1), 	(384, '?', 2), 	(384, 'no.', 3)
;

UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 198 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 198 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 198 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 199 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 199 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 199 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 200 AND RESPUESTA = 'un centro turístico atendido.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 200 AND RESPUESTA = 'algo entre a y b.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 200 AND RESPUESTA = 'una cabaña tranquila lejos del ruido.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 201 AND RESPUESTA = 'nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 201 AND RESPUESTA = 'rara vez.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 201 AND RESPUESTA = 'en algunas ocasiones.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 202 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 202 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 202 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 203 AND RESPUESTA = 'quedarme callado.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 203 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 203 AND RESPUESTA = 'decírselo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 204 AND RESPUESTA = 'adelantadas a la época.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 204 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 204 AND RESPUESTA = 'de acuerdo a la época.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 205 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 205 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 205 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 206 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 206 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 206 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 207 AND RESPUESTA = 'sí, con frecuencia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 207 AND RESPUESTA = 'en ocasiones.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 207 AND RESPUESTA = 'nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 208 AND RESPUESTA = 'en ocasiones. ';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 208 AND RESPUESTA = 'con alguna frecuencia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 208 AND RESPUESTA = 'muchas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 209 AND RESPUESTA = 'grandes enseñanzas religiosas.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 209 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 209 AND RESPUESTA = 'nuestra organización política.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 210 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 210 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 210 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 211 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 211 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 211 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 212 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 212 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 212 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 213 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 213 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 213 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 214 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 214 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 214 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 215 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 215 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 215 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 216 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 216 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 216 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 217 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 217 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 217 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 218 AND RESPUESTA = 'deportes o juegos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 218 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 218 AND RESPUESTA = 'debates o pasatiempos intelectuales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 219 AND RESPUESTA = 'en muchas actividades sociales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 219 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 219 AND RESPUESTA = 'en pocas actividades sociales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 220 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 220 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 220 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 221 AND RESPUESTA = 'doy la impresión de pasar rápidamente de una cosa a otra.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 221 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 221 AND RESPUESTA = 'me conduzco en forma metódica y cuidadosa.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 222 AND RESPUESTA = 'muy rara vez.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 222 AND RESPUESTA = 'en ocasiones.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 222 AND RESPUESTA = 'a menudo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 223 AND RESPUESTA = 'aspectos mecánicos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 223 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 223 AND RESPUESTA = 'entrevistar y contratar personal.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 224 AND RESPUESTA = 'viajes espaciales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 224 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 224 AND RESPUESTA = 'educación en la familia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 225 AND RESPUESTA = 'perro.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 225 AND RESPUESTA = 'pájaro.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 225 AND RESPUESTA = 'vaca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 226 AND RESPUESTA = 'haría planes diferentes.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 226 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 226 AND RESPUESTA = 'me gustaría que fuera casi igual.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 227 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 227 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 227 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 228 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 228 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 228 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 229 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 229 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 229 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 230 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 230 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 230 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 231 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 231 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 231 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 232 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 232 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 232 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 233 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 233 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 233 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 234 AND RESPUESTA = '"Líderes religiosos discuten sobre un credo unificado".';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 234 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 234 AND RESPUESTA = '"Mejoras en la producción y el mercado".';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 235 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 235 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 235 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 236 AND RESPUESTA = 'siga adelante, inténtelo; no pierde nada.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 236 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 236 AND RESPUESTA = 'primero piénselo bien, no vaya a hacer una tontería.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 237 AND RESPUESTA = 'expresarme con libertad.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 237 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 237 AND RESPUESTA = 'establecer buenas relaciones con las personas.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 238 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 238 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 238 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 239 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 239 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 239 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 240 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 240 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 240 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 241 AND RESPUESTA = 'casi nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 241 AND RESPUESTA = 'ocasionalmente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 241 AND RESPUESTA = 'muy a menudo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 242 AND RESPUESTA = 'casi nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 242 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 242 AND RESPUESTA = 'varias veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 243 AND RESPUESTA = 'una discusión sobre aspectos sociales básicos del mundo moderno.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 243 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 243 AND RESPUESTA = 'un buen reportaje de todas las noticias locales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 244 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 244 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 244 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 245 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 245 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 245 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 246 AND RESPUESTA = 'a menudo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 246 AND RESPUESTA = 'Algunas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 246 AND RESPUESTA = 'nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 247 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 247 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 247 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 248 AND RESPUESTA = 'investigador químico.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 248 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 248 AND RESPUESTA = 'administrador de un hotel.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 249 AND RESPUESTA = 'bastante agradable.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 249 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 249 AND RESPUESTA = 'un trabajo desagradable.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 250 AND RESPUESTA = '7';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 250 AND RESPUESTA = '9';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 250 AND RESPUESTA = '13';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 251 AND RESPUESTA = 'leche.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 251 AND RESPUESTA = 'pasto.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 251 AND RESPUESTA = 'sal.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 252 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 252 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 252 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 253 AND RESPUESTA = 'caminaría por donde quisiera.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 253 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 253 AND RESPUESTA = 'evitaría las partes de la ciudad consideradas peligrosas.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 254 AND RESPUESTA = 'llevarla bien con la gente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 254 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 254 AND RESPUESTA = 'poner en práctica las ideas propias.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 255 AND RESPUESTA = 'en el dicho de "ríe y sé feliz" en la mayoría de las ocasiones.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 255 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 255 AND RESPUESTA = 'ser apropiadamente serio en los asuntos cotidianos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 256 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 256 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 256 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 257 AND RESPUESTA = 'Verdadero, no me siento mal.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 257 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 257 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 258 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 258 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 258 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 259 AND RESPUESTA = 'trabajar con varias personas bajo mis ordenes.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 259 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 259 AND RESPUESTA = 'trabajar con un comité.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 260 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 260 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 260 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 261 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 261 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 261 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 262 AND RESPUESTA = 'el significado básico de la vida.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 262 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 262 AND RESPUESTA = 'obtener un buen ingreso para su familia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 263 AND RESPUESTA = 'siempre.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 263 AND RESPUESTA = 'algunas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 263 AND RESPUESTA = 'casi nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 264 AND RESPUESTA = 'sí.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 264 AND RESPUESTA = 'Algunas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 264 AND RESPUESTA = 'no.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 265 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 265 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 265 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 266 AND RESPUESTA = 'a menudo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 266 AND RESPUESTA = 'ocasionalmente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 266 AND RESPUESTA = 'pocas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 267 AND RESPUESTA = 'una buena sátira cinematrográfica sobre la sociedad del futuro.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 267 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 267 AND RESPUESTA = 'una buena película del oeste.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 268 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 268 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 268 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 269 AND RESPUESTA = 'estudiando solo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 269 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 269 AND RESPUESTA = 'discutiéndolo con otros.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 270 AND RESPUESTA = 'me apoyo en un razonamiento objetivo, tranquilo y lógico.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 270 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 270 AND RESPUESTA = 'me pongo tenso, excitable, incapaz de pensar claramente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 271 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 271 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 271 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 272 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 272 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 272 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 273 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 273 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 273 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 274 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 274 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 274 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 275 AND RESPUESTA = 'torcedura.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 275 AND RESPUESTA = 'aflicción.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 275 AND RESPUESTA = 'comezón.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 276 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 276 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 276 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 277 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 277 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 277 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 278 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 278 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 278 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 279 AND RESPUESTA = 'prefiero escuchar con atención.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 279 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 279 AND RESPUESTA = 'doy más opiniones que la mayoría de ellos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 280 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 280 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 280 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 281 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 281 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 281 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 282 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 282 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 282 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 283 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 283 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 283 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 284 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 284 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 284 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 285 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 285 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 285 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 286 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 286 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 286 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 287 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 287 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 287 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 288 AND RESPUESTA = 'las insto a que lleguen a él.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 288 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 288 AND RESPUESTA = 'actúo en forma práctica para mantener la armonía.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 289 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 289 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 289 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 290 AND RESPUESTA = 'continúo como si nada hubiera sucedido.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 290 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 290 AND RESPUESTA = 'me siento agobiado.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 291 AND RESPUESTA = 'sí, a menudo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 291 AND RESPUESTA = 'a veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 291 AND RESPUESTA = 'no.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 292 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 292 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 292 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 293 AND RESPUESTA = 'siempre me complace participar integramente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 293 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 293 AND RESPUESTA = 'me gusta reservarme el derecho a cancelar mi participación.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 294 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 294 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 294 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 295 AND RESPUESTA = 'hago alboroto.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 295 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 295 AND RESPUESTA = 'lo tomo con calma, pensando que tienen algún motivo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 296 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 296 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 296 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 297 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 297 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 297 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 298 AND RESPUESTA = 'administrador de una oficina de negocios.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 298 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 298 AND RESPUESTA = 'arquitecto.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 299 AND RESPUESTA = 'miércoles.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 299 AND RESPUESTA = 'viernes.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 299 AND RESPUESTA = 'lunes.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 300 AND RESPUESTA = 'prudente o sensato.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 300 AND RESPUESTA = 'adorable.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 300 AND RESPUESTA = 'amable.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 301 AND RESPUESTA = 'nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 301 AND RESPUESTA = 'algunas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 301 AND RESPUESTA = 'pocas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 302 AND RESPUESTA = 'apenas uno.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 302 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 302 AND RESPUESTA = 'más de media docena.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 303 AND RESPUESTA = 'me guardaría mi opinión.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 303 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 303 AND RESPUESTA = 'le diría que mi opinión es diferente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 304 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 304 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 304 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 305 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 305 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 305 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 306 AND RESPUESTA = 'mi hogar y las necesidades reales de mis amigos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 306 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 306 AND RESPUESTA = 'actividades sociales y pasatiempos personales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 307 AND RESPUESTA = 'casi siempre tengo éxito.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 307 AND RESPUESTA = 'algunas veces tengo éxito.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 307 AND RESPUESTA = 'por lo general estoy inseguro de mi éxito.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 308 AND RESPUESTA = 'un gran número de conocidos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 308 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 308 AND RESPUESTA = 'solo pocos amigos leales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 309 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 309 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 309 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 310 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 310 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 310 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 311 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 311 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 311 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 312 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 312 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 312 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 313 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 313 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 313 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 314 AND RESPUESTA = 'platicar sobre hechos y asuntos impersonales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 314 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 314 AND RESPUESTA = 'charlar con la gente y de sus sentimientos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 315 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 315 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 315 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 316 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 316 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 316 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 317 AND RESPUESTA = 'cambian constantemente los métodos que ya estaban bien.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 317 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 317 AND RESPUESTA = 'se rehusan a emplear métodos más modernos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 318 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 318 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 318 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 319 AND RESPUESTA = 'le pregunto a la gente dónde se encuentra esa calle.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 319 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 319 AND RESPUESTA = 'la busco en un mapa.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 320 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 320 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 320 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 321 AND RESPUESTA = 'ocasionalmente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 321 AND RESPUESTA = 'casi nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 321 AND RESPUESTA = 'nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 322 AND RESPUESTA = 'me aguanto.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 322 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 322 AND RESPUESTA = 'tengo que hablar con alguien para descargar mi enojo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 323 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 323 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 323 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 324 AND RESPUESTA = 'belleza.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 324 AND RESPUESTA = 'notas.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 324 AND RESPUESTA = 'tonada.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 325 AND RESPUESTA = 'tararear.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 325 AND RESPUESTA = 'hablar. ';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 325 AND RESPUESTA = 'xooo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 326 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 326 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 326 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 327 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 327 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 327 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 328 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 328 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 328 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 329 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 329 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 329 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 330 AND RESPUESTA = 'actor.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 330 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 330 AND RESPUESTA = 'constructor de casas.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 331 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 331 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 331 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 332 AND RESPUESTA = 'al tanto de lo que pasa a mi alrededor.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 332 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 332 AND RESPUESTA = 'envuelto en mis propios pensamientos o asuntos recientes.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 333 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 333 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 333 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 334 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 334 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 334 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 335 AND RESPUESTA = 'el descubrimiento de pinturas indígenas antiguas.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 335 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 335 AND RESPUESTA = 'asesinatos de indios.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 336 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 336 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 336 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 337 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 337 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 337 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 338 AND RESPUESTA = 'una buena novela histórica.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 338 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 338 AND RESPUESTA = 'un ensayo científico sobre el aprovechamiento de los recursos mundiales.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 339 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 339 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 339 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 340 AND RESPUESTA = 'sí.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 340 AND RESPUESTA = 'a veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 340 AND RESPUESTA = 'no.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 341 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 341 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 341 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 342 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 342 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 342 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 343 AND RESPUESTA = 'me comprenden solamente mis amigos íntimos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 343 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 343 AND RESPUESTA = 'estoy haciendo lo que la mayoría de la gente piensa que está bien.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 344 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 344 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 344 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 345 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 345 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 345 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 346 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 346 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 346 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 347 AND RESPUESTA = 'rara vez.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 347 AND RESPUESTA = 'ocasionalmente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 347 AND RESPUESTA = 'con frecuencia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 348 AND RESPUESTA = 'un club fotográfico.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 348 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 348 AND RESPUESTA = 'un club de debates.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 349 AND RESPUESTA = 'grupo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 349 AND RESPUESTA = 'ejército.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 349 AND RESPUESTA = 'juego.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 350 AND RESPUESTA = 'cinta métrica.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 350 AND RESPUESTA = 'tijeras.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 350 AND RESPUESTA = 'ropa.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 351 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 351 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 351 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 352 AND RESPUESTA = 'encontrar pruebas condenatorias.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 352 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 352 AND RESPUESTA = 'proteger al inocente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 353 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 353 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 353 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 354 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 354 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 354 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 355 AND RESPUESTA = 'Sí.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 355 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 355 AND RESPUESTA = 'No.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 356 AND RESPUESTA = 'sea realmente lo que yo quiero hacer.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 356 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 356 AND RESPUESTA = 'que no tenga consecuencias nocivas para mis compañeros.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 357 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 357 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 357 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 358 AND RESPUESTA = 'es difícil para mí.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 358 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 358 AND RESPUESTA = 'nunca me causa problema.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 359 AND RESPUESTA = 'Verdadero, puedo afrontarlos fácilmente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 359 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 359 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 360 AND RESPUESTA = 'a una gran concertista.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 360 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 360 AND RESPUESTA = 'un programa práctico e informativo sobre nuevos inventos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 361 AND RESPUESTA = 'Verdadero, puedo afrontarlos fácilmente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 361 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 361 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 362 AND RESPUESTA = 'un juego de cartas con mis amigos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 362 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 362 AND RESPUESTA = 'los hermosos objetos de una galería de arte.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 363 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 363 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 363 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 364 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 364 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 364 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 365 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 365 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 365 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 366 AND RESPUESTA = 'encontrar básicamente cuál es nuestra diferencia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 366 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 366 AND RESPUESTA = 'llegar a una solución satisfactoria para ambos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 367 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 367 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 367 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 368 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 368 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 368 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 369 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 369 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 369 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 370 AND RESPUESTA = 'una persona activa y práctica.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 370 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 370 AND RESPUESTA = 'un soñador.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 371 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 371 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 371 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 372 AND RESPUESTA = 'muy rara vez.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 372 AND RESPUESTA = 'ocasionalmente.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 372 AND RESPUESTA = 'con bastante frecuencia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 373 AND RESPUESTA = 'estando encargado de juegos de niños.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 373 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 373 AND RESPUESTA = 'ayudando a un relojero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 374 AND RESPUESTA = 'palabras.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 374 AND RESPUESTA = 'sentimientos.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 374 AND RESPUESTA = 'teorías.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 375 AND RESPUESTA = 'segundo.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 375 AND RESPUESTA = 'una vez.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 375 AND RESPUESTA = 'único.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 376 AND RESPUESTA = 'el mismo tipo de vida que llevo ahora.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 376 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 376 AND RESPUESTA = 'una vida más tranquila con menos dificultades que tuviera que enfrentar.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 377 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 377 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 377 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 378 AND RESPUESTA = 'fuerte.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 378 AND RESPUESTA = 'termino medio.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 378 AND RESPUESTA = 'suave.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 379 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 379 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 379 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 380 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 380 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 380 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 381 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 381 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 381 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 382 AND RESPUESTA = 'Verdadero.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 382 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 382 AND RESPUESTA = 'Falso.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 2 WHERE FK_PREGUNTA = 383 AND RESPUESTA = 'nunca.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 1 WHERE FK_PREGUNTA = 383 AND RESPUESTA = 'algunas veces.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 383 AND RESPUESTA = 'con frecuencia.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 384 AND RESPUESTA = 'sí.';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 384 AND RESPUESTA = '?';
UPDATE CAT_RESPUESTA_POSIBLE SET VALOR_NUMERICO = 0 WHERE FK_PREGUNTA = 384 AND RESPUESTA = 'no.';


/*********************  FIN MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
