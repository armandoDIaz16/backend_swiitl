/* AGREGAR EL CAMPO DE ESTADO DEL CONCEPTO */
ALTER TABLE CAT_CONCEPTO
ADD ESTATUS BIT DEFAULT 1;

/* CAMBIOS PARA AUMENTAR DECIMALES EN MONTOS DE TABLAS */
ALTER TABLE CAT_CONCEPTO
ALTER COLUMN MONTO DECIMAL(18,2);

ALTER TABLE TR_REFERENCIA
ALTER COLUMN MONTO DECIMAL(18,2);

ALTER TABLE LOG_CONCEPTO
ALTER COLUMN MONTO_ANTERIOR DECIMAL(18,2);

ALTER TABLE LOG_CONCEPTO
ALTER COLUMN MONTO_NUEVO DECIMAL(18,2);

ALTER TABLE CAT_VALE
ALTER COLUMN MONTO DECIMAL(18,2);

ALTER TABLE TR_MOVIMIENTO_VALE
ALTER COLUMN MONTO DECIMAL(18,2);

/* AGREGAR SEGUNDA COLUMNA DE CLAVES CONTPAQ TECNM */
ALTER TABLE CAT_CONCEPTO
ADD CLAVE_CONTPAQ_TECNM NVARCHAR(15) NULL;

/* ELIMINACION DE COLUMNA */
ALTER TABLE TR_REFERENCIA
DROP COLUMN CANTIDAD_SISTEMA;

/* AGREGAR COLUMNAS A TR_REFERENCIA */
ALTER TABLE TR_REFERENCIA
ADD MOCNTO_SISTEMA DECIMAL(18,2) NOT NULL;       --MONTO QUE CUESTA EN EL SISTEMA

ALTER TABLE TR_REFERENCIA
ADD MONTO_PAGADO DECIMAL(18,2) NULL;            --MONTO PAGADO AL BANCO

/* AGREGAR DEFAULT A COLUMNAS */
ALTER TABLE TR_REFERENCIA
ADD CONSTRAINT DEF_ESTATUS_REF
DEFAULT 0 FOR ESTATUS_REFERENCIA;

ALTER TABLE TR_REFERENCIA
ADD CONSTRAINT DEF_CANTIDAD
DEFAULT 1 FOR CANTIDAD_SOLICITADA;

/* AGREGAR COLUMNAS A CAT_CONCEPTO */
ALTER TABLE CAT_CONCEPTO
ADD FK_VALE INT NULL;

ALTER TABLE CAT_CONCEPTO
ADD GENERA_DOCUMENTO BIT NOT NULL;

/* AGREGAR RELACIÓN ENTRE TABLA DE CAT_CONCEPTO Y CAT_VALE */
ALTER TABLE CAT_CONCEPTO
ADD CONSTRAINT FRK_VALE_CONCEPTO FOREIGN KEY (FK_VALE) REFERENCES CAT_VALE(PK_VALE);

/* CAMBIAR CAMPOS DE CAT_CONCEPTO DE NULL A NOT NULL */
ALTER TABLE CAT_CONCEPTO
ALTER COLUMN CLAVE_CONTPAQ_TECNM NVARCHAR(20) NOT NULL;

ALTER TABLE CAT_CONCEPTO
ALTER COLUMN ESTATUS BIT NOT NULL;

/* AGREGAR DEFAULT A COLUMNAS */
ALTER TABLE CAT_CONCEPTO
ADD CONSTRAINT DEF_DOCUMENTO
DEFAULT 0 FOR GENERA_DOCUMENTO;

/* ************************ *
    * PRODUCCIÓN: PENDIENTE *
 * ************************ */
