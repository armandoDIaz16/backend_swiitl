use SWIITL;

/*********************  INICIO MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL)  *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
*/

ALTER TABLE CATR_RESPUESTA_POSIBLE ALTER COLUMN RESPUESTA VARCHAR(250) NULL;
ALTER TABLE CATR_RESPUESTA_POSIBLE ADD MINIMO INT DEFAULT NULL;
ALTER TABLE CATR_RESPUESTA_POSIBLE ADD MAXIMO INT DEFAULT NULL;

/* ****************************************************** *
 * ********** ELIMINACIÓN DE TABLAS DE  ******** *
 * ****************************************************** */
DROP TABLE IF EXISTS ;

/* *************************************************** *
 * ********** CREACIÓN DE TABLAS DE  ******** *
 * *************************************************** */

/* INICIO TABLA PARA  */
CREATE TABLE
(
    PK_SECCION              INT          NOT NULL IDENTITY (1,1),
    FK_ENCUESTA             INT,

    FK_USUARIO_REGISTRO     INT,
    FK_USUARIO_MODIFICACION INT,
    FECHA_REGISTRO          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FECHA_MODIFICACION      DATETIME,
    BORRADO                 SMALLINT     NOT NULL DEFAULT 0
);

ALTER TABLE CATR_SECCION
    ADD CONSTRAINT PRK_SECCION PRIMARY KEY (PK_SECCION ASC);
ALTER TABLE CATR_SECCION
    ADD CONSTRAINT FRK_ENCUESTA FOREIGN KEY (FK_ENCUESTA) REFERENCES CAT_ENCUESTA (PK_ENCUESTA)
/* FIN TABLA PARA  */


/*********************  FIN MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************/

-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
-- --------------------------------------------------------------------------------------------------------------------------------
