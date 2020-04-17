/*********************  INICIO MODIFICACIONES PUESTA EN PRODUCCIÓN (14-08-2019)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      OK
 * PRUEBAS:    OK
 * PRODUCCIÓN: OK
*/

/* VISTA PARA EL LISTADO DE CURSOS POR PERIODO */
DROP VIEW IF EXISTS VIEW_CURSOS_POR_PERIODO;
go
CREATE VIEW VIEW_CURSOS_POR_PERIODO AS
SELECT
    CC.PK_CAT_CURSO_CADO,
    CC.NOMBRE_CURSO,
    AA.NOMBRE AS NOMBRE_AREA,
    CC.FECHA_INICIO,
    CC.FECHA_FIN,
    CC.HORA_INICIO,
    CC.HORA_FIN,
    CC.TIPO_CURSO,
    CC.FK_PERIODO_CADO,
    CC.ESTADO,
    CC.RUTA_IMAGEN_CURSO
FROM CAT_CURSO_CADO CC
-- AREA ACADEMICA
    LEFT JOIN CAT_AREA_ACADEMICA AA ON AA.PK_AREA_ACADEMICA=CC.FK_AREA_ACADEMICA
--WHERE
    WHERE
        CC.BORRADO=0;
/*FIN VISTA*/
        
/* VISTA PARA EL LISTADO DE INSTRUCTORES  POR CURSO */
DROP VIEW IF EXISTS VIEW_INSTRUCTORES_CURSO;
go
CREATE VIEW VIEW_INSTRUCTORES_CURSO AS
SELECT
   CONCAT(U.NOMBRE,' ',U.PRIMER_APELLIDO,' ',U.SEGUNDO_APELLIDO) AS NOMBRE_INSTRUCTOR,
    PIC.FK_PARTICIPANTE_CADO AS PK_PARTICIPANTE_IMPARTE,
    PIC.FK_CAT_CURSO_CADO,
    U.PK_USUARIO,
    U.NOMBRE,
    U.PRIMER_APELLIDO,
    U.SEGUNDO_APELLIDO
FROM CATTR_PARTICIPANTE_IMPARTE_CURSO PIC
--PARTICIPANTE
    INNER JOIN CAT_PARTICIPANTE_CADO PC ON  PIC.FK_PARTICIPANTE_CADO = PC.PK_PARTICIPANTE_CADO
--USUARIO
    INNER JOIN CAT_USUARIO U ON PC.FK_USUARIO =U.PK_USUARIO
--WHERE
    WHERE
        PIC.BORRADO=0;

              
/* VISTA PARA EL LISTADO DE PERIODOS POR INSTURCTOR */
DROP VIEW IF EXISTS VIEW_PERIODOS_INSTRUCTOR;
go
CREATE VIEW VIEW_PERIODOS_INSTRUCTOR AS
SELECT
    PC.PK_PERIODO_CADO,
    PC.NOMBRE_PERIODO,
    PC.FECHA_INICIO,
    PC.FECHA_FIN,
    PIC.FK_PARTICIPANTE_CADO
FROM CAT_PERIODO_CADO PC
--CURSO
 INNER JOIN CAT_CURSO_CADO CC ON  CC.FK_PERIODO_CADO = PC.PK_PERIODO_CADO
--PARTICIPANTE IMPARTE
    INNER JOIN CATTR_PARTICIPANTE_IMPARTE_CURSO PIC ON  PIC.FK_CAT_CURSO_CADO = CC.PK_CAT_CURSO_CADO
--WHERE
    WHERE
        PC.BORRADO=0 AND CC.BORRADO=0;
/*fin vista*/

        /* VISTA PARA EL LISTADO DE CURSOS POR INSTRUCTOR */
DROP VIEW IF EXISTS VIEW_CURSOS_POR_PERIODO_INSTRUCTOR;
go
CREATE VIEW VIEW_CURSOS_POR_PERIODO_INSTRUCTOR AS
SELECT
    CC.PK_CAT_CURSO_CADO,
    CC.NOMBRE_CURSO,  
    AA.NOMBRE AS NOMBRE_AREA,
    CC.FECHA_INICIO,
    CC.FECHA_FIN,
    CC.HORA_INICIO,
    CC.HORA_FIN,
    CC.TIPO_CURSO,
    CC.FK_PERIODO_CADO,
    CC.ESTADO,
    CC.RUTA_IMAGEN_CURSO,
    PIC.FK_PARTICIPANTE_CADO
FROM CAT_CURSO_CADO CC
--PARTICIPANTE IMPARTE
    INNER JOIN CATTR_PARTICIPANTE_IMPARTE_CURSO PIC ON  PIC.FK_CAT_CURSO_CADO = CC.PK_CAT_CURSO_CADO
-- AREA ACADEMICA
    LEFT JOIN CAT_AREA_ACADEMICA AA ON AA.PK_AREA_ACADEMICA=CC.FK_AREA_ACADEMICA
--WHERE
    WHERE
        CC.BORRADO=0;
/*FIN VISTA*/

  /* VISTA PARA EL LISTADO DE CURSOS CON FORMATO DE HORA */
DROP VIEW IF EXISTS VIEW_CURSOS_FORMAT;
go
CREATE VIEW VIEW_CURSOS_FORMAT AS
SELECT  
        PK_CAT_CURSO_CADO,
        NOMBRE_CURSO,
        TIPO_CURSO,
        CUPO_ACTUAL,
        CUPO_MAXIMO,
        TOTAL_HORAS,
        FK_AREA_ACADEMICA,
        FECHA_INICIO,
        FECHA_FIN,
        --HORA_INCIO,
        HORA_FIN,
        FK_EDIFICIO,
        NOMBRE_ESPACIO,
        ESTADO,
        FK_FICHA_TECNICA_CADO,
        FK_PERIODO_CADO,
        FK_PARTICIPANTE_REGISTRO,
        FECHA_REGISTRO,
        BORRADO,
        FORMAT(CAST(HORA_INICIO AS datetime2), N'HH') AS HORA_INICIO
FROM CAT_CURSO_CADO 
--WHERE
    WHERE
       BORRADO=0;
/*FIN VISTA*/
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------

