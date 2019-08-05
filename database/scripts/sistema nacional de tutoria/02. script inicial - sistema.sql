use SWIITL;

/*********************  INICIO MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
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
    ORDEN
) VALUES
(2, 'SÍ', 1),  (2, 'No', 1),
(3, 'SÍ', 1),  (3, 'No', 1),
(4, 'SÍ', 1),  (4, 'No', 1),
(5, 'SÍ', 1),  (5, 'No', 1),
(6, 'SÍ', 1),  (6, 'No', 1),
(7, 'SÍ', 1),  (7, 'No', 1),
(8, 'SÍ', 1),  (8, 'No', 1),
(9, 'SÍ', 1),  (9, 'No', 1),
(10, 'Sí', 1), (10, 'No', 1),
(11, 'Sí', 1), (11, 'No', 1),
(12, 'Sí', 1), (12, 'No', 1),
(13, 'Sí', 1), (13, 'No', 1),
(14, '1 a 4', 1), (14, '5 a 8', 1), (14, 'Más de 8', 1),
(15, '3', 1), (15, '2', 1), (15, '1', 1),
(16, 'Excelente', 1), (16, 'Buena', 1), (16, 'Regular', 1), (16, 'Mala', 1),
(17, 'Excelente', 1), (17, 'Buena', 1), (17, 'Regular', 1), (17, 'Mala', 1),
(18, 'Excelente', 1), (18, 'Buena', 1), (18, 'Regular', 1), (18, 'Mala', 1),
(19, 'Excelente', 1), (19, 'Buena', 1), (19, 'Regular', 1), (19, 'Mala', 1),
(20, 'Excelente', 1), (20, 'Buena', 1), (20, 'Regular', 1), (20, 'Mala', 1),
(21, 'Excelente', 1), (21, 'Buena', 1), (21, 'Regular', 1), (21, 'Mala', 1),
(22, 'Excelente', 1), (22, 'Buena', 1), (22, 'Regular', 1), (22, 'Mala', 1),
(23, 'Excelente', 1), (23, 'Buena', 1), (23, 'Regular', 1), (23, 'Mala', 1),
(24, 'Excelente', 1), (24, 'Buena', 1), (24, 'Regular', 1), (24, 'Mala', 1),
(25, 'Excelente', 1), (25, 'Buena', 1), (25, 'Regular', 1), (25, 'Mala', 1),
(26, 'Excelente', 1), (26, 'Buena', 1), (26, 'Regular', 1), (26, 'Mala', 1),
(27, 'Excelente', 1), (27, 'Buena', 1), (27, 'Regular', 1), (27, 'Mala', 1),
(28, 'Excelente', 1), (28, 'Buena', 1), (28, 'Regular', 1), (28, 'Mala', 1),
(29, 'Excelente', 1), (29, 'Buena', 1), (29, 'Regular', 1), (29, 'Mala', 1),
(30, 'Triste', 1), (30, 'Alegre', 1), (30, 'Ansioso', 1), (30, 'Tranquilo', 1),
(31, 'Sí', 1), (31, 'No', 1)
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
    ORDEN
) VALUES
(32, 'Padres', 1), (32, 'Solo', 1), (32, 'Con familiares', 1), (32, 'Otro', 1),
(33, 'Soltero', 1), (33, 'Casado', 1), (33, 'Divorciado', 1), (33, 'Unión libre', 1),
(34, 'Sí', 1), (34, 'No', 1),
(35, 'Menos de 10 hrs', 1), (35, 'De 10 a 20 hrs', 1), (35, 'De 21 a 30 hrs', 1),
(36, 'Apoyar a la familia', 1), (36, 'Solventar mis estudios', 1), (36, 'Tener ingreso para gastos personales', 1), (36, 'Todas las anteriores', 1),
(37, 'Sí', 1), (37, 'No', 1),
(38, 'Sin estudio', 1), (38, 'Primaria incompleta', 1), (38, 'Primaria terminada', 1), (38, 'Secundaria incompleta', 1), (38, 'Secundaria terminada', 1), (38, 'Bachillerato incompleto', 1), (38, 'Bachillerato terminado', 1), (38, 'Estudios técnicos', 1), (38, 'TSU', 1), (38, 'Licenciatura incompleta', 1), (38, 'Licenciatura terminada', 1), (38, 'Postgrado', 1), (38, 'Otro', 1), (38, 'Lo desconozco', 1),
(39, 'Sin estudio', 1), (39, 'Primaria incompleta', 1), (39, 'Primaria terminada', 1), (39, 'Secundaria incompleta', 1), (39, 'Secundaria terminada', 1), (39, 'Bachillerato incompleto', 1), (39, 'Bachillerato terminado', 1), (39, 'Estudios técnicos', 1), (39, 'TSU', 1), (39, 'Licenciatura incompleta', 1), (39, 'Licenciatura terminada', 1), (39, 'Postgrado', 1), (39, 'Otro', 1), (39, 'Lo desconozco', 1),
(40, 'Mi padre', 1), (40, 'Mi madre', 1), (40, 'Yo', 1), (40, 'Todos los que trabajan en mi familia', 1), (40, 'Otro (indica quién)', 1),
(41, 'Altos', 1), (41, 'Regulares', 1), (41, 'Bajos', 1), (41, 'Muy bajos', 1),
(42, '', 1),
(43, 'Robo a casa habitación', 1), (43, 'Pandillerismo', 1), (43, 'Robo de autos', 1), (43, 'Drogas', 1), (43, 'Asalto a peatones', 1), (43, 'Otro (especifica)', 1), (43, 'Ninguno', 1),
(44, 'Autobús', 1), (44, 'Auto propio', 1), (44, 'Auto de la familia', 1), (44, 'Motocicleta', 1), (44, 'Bicicleta', 1), (44, 'Taxi', 1), (44, 'Caminando', 1), (44, 'Otro', 1)
;

INSERT INTO CAT_RESPUESTA_POSIBLE(
    FK_PREGUNTA,
    RESPUESTA,
    ORDEN,
    VALOR_NUMERICO
) VALUES
(45, '1 a 4', 1, 0), (45, '5 a 6', 1, 8), (45, '7 o más', 1, 13),
(46, '0', 1, 0), (46, '1', 1, 16), (46, '2', 1, 36), (46, '3', 1, 36), (46, '4 o más ', 1, 52),
(47, 'Sí', 1, 10), (47, 'No', 1, 0),
(48, '0 - 5', 1, 0), (48, '06 - 10', 1, 15), (48, '11 - 15', 1, 27), (48, '16 - 20', 1, 32), (48, '21 o  más', 1, 46),
(49, '(firme de) Tierra o cemento', 1, 0), (49, 'Otro tipo de material o acabado', 1, 11),
(50, '0', 1, 0), (50, '1', 1, 32), (50, '2', 1, 41), (50, '3 o más', 1, 58),
(51, 'Sí', 1, 20), (51, 'No', 1, 0),
(52, 'No estudió', 1, 0), (52, 'Primaria incompleta', 1, 0), (52, 'Primaria completa', 1, 22), (52, 'Secundaria incompleta', 1, 22),
(52, 'Secundaria completa', 1, 22), (52, 'Carrera comercial', 1, 38), (52, 'Carrera técnica', 1, 38), (52, 'Preparatoria incompleta', 1, 38),
(52, 'Preparatoria completa', 1, 38), (52, 'Licenciatura incompleta', 1, 52), (52, 'Licenciatura completa', 1, 52), (52, 'Diplomado o Maestría', 1, 72),
(52, 'Doctorado', 1, 72), (52, 'No sé', 1, 0)
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
(65, 5, 2, 65, '¿De qué tipo es tu familia?', ''),
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
(64, '1º', 1), (64, '2º', 1), (64, '3º', 1), (64, '4º', 1),
(65, 'Nuclear (papá, mamá e hijos)', 1), (65, 'Extensa (viven en casa papá, mamá, hijos y otros familiares)', 1),
(65, 'Monoparental (Madre o padre soltero)', 1), (65, 'Padres separados', 1), (65, 'Padres divorciados', 1), (65, 'Otro (especifica)', 1),
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

/*********************  FIN MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************/


-- --------------------------------------------------------------------------------------------------------------------------------
