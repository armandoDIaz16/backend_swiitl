/*********************  INICIO MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************
 * CONTROL DE CAMBIOS EN AMBIENTES
 * LOCAL:      PENDIENTE (FECHA DE APLICACIÓN)
 * PRUEBAS:    PENDIENTE (FECHA DE APLICACIÓN)
 * PRODUCCIÓN: PENDIENTE (FECHA DE APLICACIÓN)
*/

CREATE PROCEDURE GENERAR_PREFICHA @periodo INT,
-- Datos tabla CAT_USUARIO
                                  @NOMBRE VARCHAR(255),
                                  @PRIMER_APELLIDO VARCHAR(255),
                                  @SEGUNDO_APELLIDO VARCHAR(255),
                                  @FECHA_NACIMIENTO DATE,
                                  @SEXO CHAR(1),
                                  @CURP VARCHAR(18),
                                  @FK_ESTADO_CIVIL INT,
                                  @CALLE VARCHAR(255),
                                  @NUMERO_EXTERIOR INT,
                                  @NUMERO_INTERIOR INT,
                                  @CP INT,
                                  @FK_COLONIA INT,
                                  @TELEFONO_CASA VARCHAR(255),
                                  @TELEFONO_MOVIL VARCHAR(255),
                                  @CORREO1 VARCHAR(255),
-- Datos tabla CAT_ASPIRANTE
                                  @PADRE_TUTOR VARCHAR(255),
                                  @MADRE VARCHAR(255),
                                  @FK_BACHILLERATO INT,
                                  @ESPECIALIDAD NVARCHAR(255),
                                  @PROMEDIO DECIMAL(3, 1),
                                  @NACIONALIDAD NVARCHAR(255),
                                  @FK_CIUDAD INT,
                                  @FK_CARRERA_1 INT,
                                  @FK_CARRERA_2 INT,
                                  @FK_PROPAGANDA_TECNOLOGICO INT,
                                  @FK_UNIVERSIDAD INT,
                                  @FK_CARRERA_UNIVERSIDAD INT,
                                  @FK_DEPENDENCIA INT,
                                  @TRABAJAS_Y_ESTUDIAS CHAR(1),
                                  @AYUDA_INCAPACIDAD NVARCHAR(255)
AS
DECLARE
    @PREFICHA        VARCHAR(10),
    @NUMERO_PREFICHA INT,
    @FK_PADRE        int

    SET NOCOUNT ON
    IF ((SELECT COUNT(CAT_USUARIO.CURP)
         FROM CAT_ASPIRANTE
                  LEFT JOIN CAT_USUARIO ON CAT_USUARIO.PK_USUARIO = CAT_ASPIRANTE.FK_PADRE
         WHERE CAT_USUARIO.CURP = @CURP) <> 0)
        BEGIN
            IF ((SELECT COUNT(CAT_USUARIO.CURP)
                 FROM CAT_ASPIRANTE
                          LEFT JOIN CAT_USUARIO ON CAT_USUARIO.PK_USUARIO = CAT_ASPIRANTE.FK_PADRE
                 WHERE FK_PERIODO = @periodo) <> 0)
                BEGIN
                    SELECT 1 AS RESPUESTA; -- YA ESTA REGISTRADA ESA CURP EN ESTE PERIODO
                END

            ELSE
                IF ((SELECT COUNT(CAT_USUARIO.CORREO1) FROM CAT_USUARIO WHERE CORREO1 = @CORREO1 AND CURP <> @CURP) <>
                    0)
                    BEGIN
                        SELECT 2 AS RESPUESTA; -- YA ESTA REGISTRADO ESE CORREO A OTRO USUARIO
                    END

                ELSE
                    IF (((SELECT ESTADO FROM CAT_USUARIO WHERE CURP = @CURP) = 0) OR
                        ((SELECT ESTADO FROM CAT_USUARIO WHERE CURP = @CURP) = 5))
                        BEGIN
                            IF ((SELECT COUNT(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) <> 0)
                                BEGIN
                                    IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                         FROM CAT_ASPIRANTE
                                         WHERE FK_PERIODO = (@periodo)) = 1)
                                        SELECT @PREFICHA =
                                               CONCAT('TL', FORMAT(GETDATE(), 'yy'), '000', NUMERO_PREFICHA + 1),
                                               @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                        FROM CAT_ASPIRANTE
                                        WHERE FK_PERIODO = (@periodo)
                                        GROUP BY NUMERO_PREFICHA;
                                    ELSE
                                        IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                             FROM CAT_ASPIRANTE
                                             WHERE FK_PERIODO = (@periodo)) = 2)
                                            SELECT @PREFICHA =
                                                   CONCAT('TL', FORMAT(GETDATE(), 'yy'), '00', NUMERO_PREFICHA + 1),
                                                   @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                            FROM CAT_ASPIRANTE
                                            WHERE FK_PERIODO = (@periodo)
                                            GROUP BY NUMERO_PREFICHA;
                                        ELSE
                                            IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                                 FROM CAT_ASPIRANTE
                                                 WHERE FK_PERIODO = (@periodo)) = 3)
                                                SELECT @PREFICHA =
                                                       CONCAT('TL', FORMAT(GETDATE(), 'yy'), '0', NUMERO_PREFICHA + 1),
                                                       @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                                FROM CAT_ASPIRANTE
                                                WHERE FK_PERIODO = (@periodo)
                                                GROUP BY NUMERO_PREFICHA;
                                            ELSE
                                                IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                                     FROM CAT_ASPIRANTE
                                                     WHERE FK_PERIODO = (@periodo)) = 4)
                                                    SELECT @PREFICHA =
                                                           CONCAT('TL', FORMAT(GETDATE(), 'yy'), '', NUMERO_PREFICHA + 1),
                                                           @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                                    FROM CAT_ASPIRANTE
                                                    WHERE FK_PERIODO = (@periodo)
                                                    GROUP BY NUMERO_PREFICHA;
                                END
                            ELSE
                                BEGIN
                                    SELECT @PREFICHA = CONCAT('TL', FORMAT(GETDATE(), 'yy'), '000', 1),
                                           @NUMERO_PREFICHA = 1
                                END

                            UPDATE CAT_USUARIO
                            SET NOMBRE=@NOMBRE,
                                PRIMER_APELLIDO=@PRIMER_APELLIDO,
                                SEGUNDO_APELLIDO=@SEGUNDO_APELLIDO,
                                FECHA_NACIMIENTO=@FECHA_NACIMIENTO,
                                SEXO=@SEXO,
                                CURP=@CURP,
                                FK_ESTADO_CIVIL=@FK_ESTADO_CIVIL,
                                CALLE=@CALLE,
                                NUMERO_EXTERIOR=@NUMERO_EXTERIOR,
                                NUMERO_INTERIOR=@NUMERO_INTERIOR,
                                FK_COLONIA=@FK_COLONIA,
                                TELEFONO_CASA=@TELEFONO_CASA,
                                TELEFONO_MOVIL=@TELEFONO_MOVIL,
                                CORREO1=@CORREO1,
                                FK_CODIGO_POSTAL=(SELECT PK_CODIGO_POSTAL FROM CAT_CODIGO_POSTAL WHERE NUMERO = @CP)
                            WHERE CURP = @CURP

                            SELECT @FK_PADRE = PK_USUARIO FROM CAT_USUARIO WHERE CURP = @CURP;

                            INSERT INTO CAT_ASPIRANTE (FK_PERIODO, PREFICHA, NUMERO_PREFICHA, PADRE_TUTOR, MADRE,
                                                       FK_BACHILLERATO, ESPECIALIDAD, PROMEDIO, NACIONALIDAD, FK_CIUDAD,
                                                       FK_CARRERA_1, FK_CARRERA_2, FK_PROPAGANDA_TECNOLOGICO,
                                                       FK_UNIVERSIDAD, FK_CARRERA_UNIVERSIDAD, FK_DEPENDENCIA,
                                                       TRABAJAS_Y_ESTUDIAS, AYUDA_INCAPACIDAD, AVISO_PRIVACIDAD,
                                                       FK_PADRE, FK_ESTATUS)
                            VALUES ( @periodo, @PREFICHA, @NUMERO_PREFICHA, @PADRE_TUTOR, @MADRE, @FK_BACHILLERATO
                                   , @ESPECIALIDAD, @PROMEDIO, @NACIONALIDAD, @FK_CIUDAD, @FK_CARRERA_1, @FK_CARRERA_2
                                   , @FK_PROPAGANDA_TECNOLOGICO, @FK_UNIVERSIDAD, @FK_CARRERA_UNIVERSIDAD
                                   , @FK_DEPENDENCIA, @TRABAJAS_Y_ESTUDIAS, @AYUDA_INCAPACIDAD
                                   , 1, @FK_PADRE, 1);


                            SELECT 3 AS RESPUESTA, PK_USUARIO, CURP, CORREO1
                            FROM CAT_USUARIO
                            where CURP = @CURP; -- SE ACTUALIZO USUARIO Y SE REGISTRO LA PREFICHA

                        END

        END
    ELSE
        IF ((SELECT COUNT(CAT_USUARIO.CORREO1) FROM CAT_USUARIO WHERE CORREO1 = @CORREO1) <> 0)
            BEGIN
                SELECT 4 AS RESPUESTA; -- YA ESTA REGISTRADO ESE CORREO A OTRO USUARIO
            END
        ELSE
            BEGIN
                IF ((SELECT COUNT(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) <> 0)
                    BEGIN
                        IF ((SELECT LEN(MAX(NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) = 1 AND
                            (SELECT MAX(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) <> 9)
                            SELECT @PREFICHA = CONCAT('TL', FORMAT(GETDATE(), 'yy'), '000', NUMERO_PREFICHA + 1),
                                   @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                            FROM CAT_ASPIRANTE
                            WHERE FK_PERIODO = (@periodo)
                            GROUP BY NUMERO_PREFICHA;
                        ELSE
                            IF ((SELECT LEN(MAX(NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) =
                                1 AND
                                (SELECT MAX(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) = 9)
                                SELECT @PREFICHA = CONCAT('TL', FORMAT(GETDATE(), 'yy'), '00', NUMERO_PREFICHA + 1),
                                       @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                FROM CAT_ASPIRANTE
                                WHERE FK_PERIODO = (@periodo)
                                GROUP BY NUMERO_PREFICHA;
                            ELSE
                                IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                     FROM CAT_ASPIRANTE
                                     WHERE FK_PERIODO = (@periodo)) = 2 AND
                                    (SELECT MAX(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) <>
                                    99)
                                    SELECT @PREFICHA = CONCAT('TL', FORMAT(GETDATE(), 'yy'), '00', NUMERO_PREFICHA + 1),
                                           @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                    FROM CAT_ASPIRANTE
                                    WHERE FK_PERIODO = (@periodo)
                                    GROUP BY NUMERO_PREFICHA;
                                ELSE
                                    IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                         FROM CAT_ASPIRANTE
                                         WHERE FK_PERIODO = (@periodo)) = 2 AND
                                        (SELECT MAX(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)) =
                                        99)
                                        SELECT @PREFICHA =
                                               CONCAT('TL', FORMAT(GETDATE(), 'yy'), '0', NUMERO_PREFICHA + 1),
                                               @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                        FROM CAT_ASPIRANTE
                                        WHERE FK_PERIODO = (@periodo)
                                        GROUP BY NUMERO_PREFICHA;
                                    ELSE
                                        IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                             FROM CAT_ASPIRANTE
                                             WHERE FK_PERIODO = (@periodo)) = 3 AND (SELECT MAX(NUMERO_PREFICHA)
                                                                                     FROM CAT_ASPIRANTE
                                                                                     WHERE FK_PERIODO = (@periodo)) <>
                                                                                    999)
                                            SELECT @PREFICHA =
                                                   CONCAT('TL', FORMAT(GETDATE(), 'yy'), '0', NUMERO_PREFICHA + 1),
                                                   @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                            FROM CAT_ASPIRANTE
                                            WHERE FK_PERIODO = (@periodo)
                                            GROUP BY NUMERO_PREFICHA;
                                        ELSE
                                            IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                                 FROM CAT_ASPIRANTE
                                                 WHERE FK_PERIODO = (@periodo)) = 3 AND (SELECT MAX(NUMERO_PREFICHA)
                                                                                         FROM CAT_ASPIRANTE
                                                                                         WHERE FK_PERIODO = (@periodo)) =
                                                                                        999)
                                                SELECT @PREFICHA =
                                                       CONCAT('TL', FORMAT(GETDATE(), 'yy'), '', NUMERO_PREFICHA + 1),
                                                       @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                                FROM CAT_ASPIRANTE
                                                WHERE FK_PERIODO = (@periodo)
                                                GROUP BY NUMERO_PREFICHA;
                                            ELSE
                                                IF ((SELECT LEN(MAX(NUMERO_PREFICHA))
                                                     FROM CAT_ASPIRANTE
                                                     WHERE FK_PERIODO = (@periodo)) = 4)
                                                    SELECT @PREFICHA =
                                                           CONCAT('TL', FORMAT(GETDATE(), 'yy'), '', NUMERO_PREFICHA + 1),
                                                           @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA) + 1
                                                    FROM CAT_ASPIRANTE
                                                    WHERE FK_PERIODO = (@periodo)
                                                    GROUP BY NUMERO_PREFICHA;
                    END
                ELSE
                    BEGIN
                        SELECT @PREFICHA = CONCAT('TL', FORMAT(GETDATE(), 'yy'), '000', 1),
                               @NUMERO_PREFICHA = 1
                    END

                INSERT INTO CAT_USUARIO (NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, FECHA_NACIMIENTO, SEXO, CURP,
                                         FK_ESTADO_CIVIL, CALLE, NUMERO_EXTERIOR, NUMERO_INTERIOR, FK_COLONIA,
                                         TELEFONO_CASA, TELEFONO_MOVIL, CORREO1, ESTADO, FK_CODIGO_POSTAL)
                VALUES (@NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @SEXO, @CURP, @FK_ESTADO_CIVIL,
                        @CALLE, @NUMERO_EXTERIOR, @NUMERO_INTERIOR, @FK_COLONIA, @TELEFONO_CASA, @TELEFONO_MOVIL,
                        @CORREO1, 1, (SELECT PK_CODIGO_POSTAL FROM CAT_CODIGO_POSTAL WHERE NUMERO = @CP));

                SELECT @FK_PADRE = PK_USUARIO FROM CAT_USUARIO WHERE CURP = @CURP;

                INSERT INTO CAT_ASPIRANTE (FK_PERIODO, PREFICHA, NUMERO_PREFICHA, PADRE_TUTOR, MADRE, FK_BACHILLERATO,
                                           ESPECIALIDAD, PROMEDIO, NACIONALIDAD, FK_CIUDAD, FK_CARRERA_1, FK_CARRERA_2,
                                           FK_PROPAGANDA_TECNOLOGICO, FK_UNIVERSIDAD, FK_CARRERA_UNIVERSIDAD,
                                           FK_DEPENDENCIA, TRABAJAS_Y_ESTUDIAS, AYUDA_INCAPACIDAD, AVISO_PRIVACIDAD,
                                           FK_PADRE, FK_ESTATUS)
                VALUES ( @periodo, @PREFICHA, @NUMERO_PREFICHA, @PADRE_TUTOR, @MADRE, @FK_BACHILLERATO, @ESPECIALIDAD
                       , @PROMEDIO, @NACIONALIDAD, @FK_CIUDAD, @FK_CARRERA_1, @FK_CARRERA_2, @FK_PROPAGANDA_TECNOLOGICO
                       , @FK_UNIVERSIDAD, @FK_CARRERA_UNIVERSIDAD, @FK_DEPENDENCIA, @TRABAJAS_Y_ESTUDIAS
                       , @AYUDA_INCAPACIDAD
                       , 1, @FK_PADRE, 1);

                INSERT INTO PER_TR_ROL_USUARIO (FK_ROL, FK_USUARIO)
                VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE NOMBRE = 'Aspirante'), @FK_PADRE);

                SELECT 5 AS RESPUESTA, PK_USUARIO, CURP, CORREO1
                FROM CAT_USUARIO
                where CURP = @CURP; -- SE REGISTRO CORRECTAMENTE
            END
    SET NOCOUNT OFF
    ;


    CREATE PROCEDURE INSERTAR_INCAPACIDAD @CURP VARCHAR(18),
                                          @FK_INCAPACIDAD INT
    AS
        SET NOCOUNT ON
    DECLARE
        @FK_PADRE     INT,
        @FK_ASPIRANTE INT

    SELECT @FK_PADRE = PK_USUARIO
    FROM CAT_USUARIO
    WHERE CURP = @CURP;

    SELECT @FK_ASPIRANTE = MAX(PK_ASPIRANTE)
    FROM CAT_ASPIRANTE
    WHERE FK_PADRE = @FK_PADRE;

    INSERT INTO TR_INCAPACIDAD_ASPIRANTE(FK_ASPIRANTE, FK_INCAPACIDAD)
    VALUES (@FK_ASPIRANTE, @FK_INCAPACIDAD);
    SELECT 1 AS RESPUESTA; -- SE REGISTRO CORRECTAMENTE
        SET NOCOUNT OFF
        ;

/*********************  FIN MODIFICACIONES (RANGO DE FECHA O DÍA) (EJEMPLO LUNES 8 DE ABRIL) *********************************/

CREATE FUNCTION OBTENER_FICHA(@periodo as INT, @tipo as int )
RETURNS @fichas TABLE (
    PREFICHA VARCHAR(10),
    NUMERO_PREFICHA INT not null
)
AS
BEGIN
       DECLARE
        @PREFICHA VARCHAR(10),
        @NUMERO_PREFICHA int,
        @PREFIJO NVARCHAR(4)

        IF(FORMAT(GETDATE(),'MM')>6)
            BEGIN
        SELECT @PREFIJO= CONCAT('T',FORMAT(GETDATE(),'yy')+1,1)
            END
       ELSE
           BEGIN
        SELECT @PREFIJO = CONCAT('T',FORMAT(GETDATE(),'yy'),2)
           END

       IF (@tipo = 1)
           BEGIN
               IF ((SELECT COUNT(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))<>0)
        BEGIN
            IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=1)
                SELECT @PREFICHA = CONCAT(@PREFIJO,'000',NUMERO_PREFICHA+1),
                    @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                GROUP BY NUMERO_PREFICHA;
            ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=2)
                SELECT @PREFICHA = CONCAT(@PREFIJO,'00',NUMERO_PREFICHA+1),
                    @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                GROUP BY NUMERO_PREFICHA;
            ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=3)
                SELECT @PREFICHA = CONCAT(@PREFIJO,'0',NUMERO_PREFICHA+1),
                    @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                GROUP BY NUMERO_PREFICHA;
            ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=4)
                SELECT @PREFICHA = CONCAT(@PREFIJO,'',NUMERO_PREFICHA+1),
                    @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                GROUP BY NUMERO_PREFICHA;
        END
    ELSE
            BEGIN
                SELECT @PREFICHA = CONCAT(@PREFIJO,'000',1),
                @NUMERO_PREFICHA = 1
            END
           END
       ELSE IF (@tipo = 2)
           BEGIN
                IF ((SELECT COUNT(NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))<>0)
                BEGIN
                    IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=1 AND (SELECT MAX (NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))<>9)
                        SELECT @PREFICHA = CONCAT(@PREFIJO,'000',NUMERO_PREFICHA+1),
                            @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                        GROUP BY NUMERO_PREFICHA;
                    ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=1 AND (SELECT MAX (NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=9)
                        SELECT @PREFICHA = CONCAT(@PREFIJO,'00',NUMERO_PREFICHA+1),
                            @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                        GROUP BY NUMERO_PREFICHA;
                    ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=2 AND (SELECT MAX (NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))<>99)
                        SELECT @PREFICHA = CONCAT(@PREFIJO,'00',NUMERO_PREFICHA+1),
                            @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                        GROUP BY NUMERO_PREFICHA;
                    ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=2 AND (SELECT MAX (NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=99)
                        SELECT @PREFICHA = CONCAT(@PREFIJO,'0',NUMERO_PREFICHA+1),
                            @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                        GROUP BY NUMERO_PREFICHA;
                    ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=3 AND (SELECT MAX (NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))<>999)
                        SELECT @PREFICHA = CONCAT(@PREFIJO,'0',NUMERO_PREFICHA+1),
                            @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                        GROUP BY NUMERO_PREFICHA;
                    ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=3 AND (SELECT MAX (NUMERO_PREFICHA) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=999)
                        SELECT @PREFICHA = CONCAT(@PREFIJO,'',NUMERO_PREFICHA+1),
                            @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                        GROUP BY NUMERO_PREFICHA;
                    ELSE IF ((SELECT LEN ( MAX (NUMERO_PREFICHA)) FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo))=4)
                        SELECT @PREFICHA = CONCAT(@PREFIJO,'',NUMERO_PREFICHA+1),
                            @NUMERO_PREFICHA = MAX(NUMERO_PREFICHA)+1 FROM CAT_ASPIRANTE WHERE FK_PERIODO = (@periodo)
                        GROUP BY NUMERO_PREFICHA;
                END
            ELSE
                BEGIN
                    SELECT @PREFICHA = CONCAT(@PREFIJO,'000',1),
                    @NUMERO_PREFICHA = 1
                END
           END
       INSERT @fichas
       SELECT @PREFICHA, @NUMERO_PREFICHA
     RETURN;
END;




CREATE PROCEDURE GENERAR_PREFICHA

@periodo INT,
-- Datos tabla CAT_USUARIO
@NOMBRE VARCHAR(255),
@PRIMER_APELLIDO VARCHAR(255),
@SEGUNDO_APELLIDO VARCHAR(255),
@FECHA_NACIMIENTO DATE,
@SEXO CHAR(1),
@CURP VARCHAR(18),
@FK_ESTADO_CIVIL INT,
@CALLE VARCHAR(255),
@NUMERO_EXTERIOR nvarchar(10),
@NUMERO_INTERIOR nvarchar(10),
@CP INT,
@FK_COLONIA INT,
@TELEFONO_CASA VARCHAR(255),
@TELEFONO_MOVIL VARCHAR(255),
@CORREO1 VARCHAR(255),
-- Datos tabla CAT_ASPIRANTE
@PADRE_TUTOR VARCHAR(255),
@MADRE VARCHAR(255),
@FK_BACHILLERATO INT,
@ESPECIALIDAD NVARCHAR(255),
@PROMEDIO DECIMAL(3,1),
@NACIONALIDAD NVARCHAR(255),
@FK_CIUDAD INT,
@FK_CARRERA_1 INT,
@FK_CARRERA_2 INT,
@FK_PROPAGANDA_TECNOLOGICO INT,
@FK_UNIVERSIDAD INT,
@FK_CARRERA_UNIVERSIDAD INT,
@FK_DEPENDENCIA INT,
@TRABAJAS_Y_ESTUDIAS CHAR(1),
@AYUDA_INCAPACIDAD NVARCHAR(255)
AS  
    DECLARE @PREFICHA VARCHAR(10),
        @NUMERO_PREFICHA INT,
        @FK_PADRE int

    SET NOCOUNT ON



    IF ((SELECT COUNT(CAT_USUARIO.CURP) FROM CAT_ASPIRANTE LEFT JOIN CAT_USUARIO ON CAT_USUARIO.PK_USUARIO = CAT_ASPIRANTE.FK_PADRE WHERE CAT_USUARIO.CURP = @CURP)<>0)
        BEGIN
            IF ((SELECT COUNT(CAT_USUARIO.CURP) FROM CAT_ASPIRANTE LEFT JOIN CAT_USUARIO ON CAT_USUARIO.PK_USUARIO = CAT_ASPIRANTE.FK_PADRE WHERE FK_PERIODO = @periodo)<>0)
                BEGIN
                    SELECT 1 AS RESPUESTA; -- YA ESTA REGISTRADA ESA CURP EN ESTE PERIODO
                END
            
            ELSE IF ((SELECT COUNT(CAT_USUARIO.CORREO1) FROM CAT_USUARIO WHERE CORREO1 = @CORREO1 AND CURP <> @CURP)<>0)
                BEGIN
                    SELECT 2 AS RESPUESTA; -- YA ESTA REGISTRADO ESE CORREO A OTRO USUARIO
                END   
            
            ELSE IF(((SELECT ESTADO FROM CAT_USUARIO WHERE CURP=@CURP)=0) OR ((SELECT ESTADO FROM CAT_USUARIO WHERE CURP=@CURP)=5))
                BEGIN
                        SELECT @PREFICHA = PREFICHA FROM dbo.OBTENER_FICHA(1,1)
                        SELECT @NUMERO_PREFICHA = NUMERO_PREFICHA FROM dbo.OBTENER_FICHA(1,1)
                        UPDATE CAT_USUARIO
                        SET NOMBRE=@NOMBRE,PRIMER_APELLIDO=@PRIMER_APELLIDO,SEGUNDO_APELLIDO=@SEGUNDO_APELLIDO,FECHA_NACIMIENTO=@FECHA_NACIMIENTO,SEXO=@SEXO,CURP=@CURP,FK_ESTADO_CIVIL=@FK_ESTADO_CIVIL,CALLE=@CALLE,NUMERO_EXTERIOR=@NUMERO_EXTERIOR,NUMERO_INTERIOR=@NUMERO_INTERIOR,FK_COLONIA=@FK_COLONIA,TELEFONO_CASA=@TELEFONO_CASA,TELEFONO_MOVIL=@TELEFONO_MOVIL,CORREO1=@CORREO1,FK_CODIGO_POSTAL=(SELECT PK_CODIGO_POSTAL FROM CAT_CODIGO_POSTAL WHERE NUMERO = @CP)
                        WHERE CURP= @CURP

                        SELECT @FK_PADRE = PK_USUARIO FROM CAT_USUARIO WHERE CURP = @CURP;

                        INSERT INTO CAT_ASPIRANTE (FK_PERIODO, PREFICHA, NUMERO_PREFICHA,PADRE_TUTOR,MADRE,FK_BACHILLERATO,ESPECIALIDAD,PROMEDIO,NACIONALIDAD,FK_CIUDAD,FK_CARRERA_1,FK_CARRERA_2,FK_PROPAGANDA_TECNOLOGICO, FK_UNIVERSIDAD, FK_CARRERA_UNIVERSIDAD,FK_DEPENDENCIA,TRABAJAS_Y_ESTUDIAS, AYUDA_INCAPACIDAD, AVISO_PRIVACIDAD,FK_PADRE,FK_ESTATUS)
                        VALUES (@periodo, @PREFICHA, @NUMERO_PREFICHA, @PADRE_TUTOR, @MADRE, @FK_BACHILLERATO, @ESPECIALIDAD, @PROMEDIO, @NACIONALIDAD, @FK_CIUDAD, @FK_CARRERA_1, @FK_CARRERA_2, @FK_PROPAGANDA_TECNOLOGICO, @FK_UNIVERSIDAD, @FK_CARRERA_UNIVERSIDAD, @FK_DEPENDENCIA, @TRABAJAS_Y_ESTUDIAS, @AYUDA_INCAPACIDAD
                    ,1,@FK_PADRE,1);


                    
                    SELECT 3 AS RESPUESTA, PK_USUARIO, CURP, CORREO1 FROM  CAT_USUARIO where CURP = @CURP; -- SE ACTUALIZO USUARIO Y SE REGISTRO LA PREFICHA

                END
            
        END
    ELSE IF ((SELECT COUNT(CAT_USUARIO.CORREO1) FROM CAT_USUARIO WHERE CORREO1 = @CORREO1)<>0)
        BEGIN
            SELECT 4 AS RESPUESTA; -- YA ESTA REGISTRADO ESE CORREO A OTRO USUARIO
        END 
    ELSE
        BEGIN
            SELECT @PREFICHA = PREFICHA FROM dbo.OBTENER_FICHA(1,2)
            SELECT @NUMERO_PREFICHA = NUMERO_PREFICHA FROM dbo.OBTENER_FICHA(1,2)
            INSERT INTO CAT_USUARIO (NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO,FECHA_NACIMIENTO,SEXO,CURP,FK_ESTADO_CIVIL,CALLE,NUMERO_EXTERIOR,NUMERO_INTERIOR,FK_COLONIA,TELEFONO_CASA,TELEFONO_MOVIL,CORREO1, ESTADO, FK_CODIGO_POSTAL) 
            VALUES (@NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @SEXO, @CURP, @FK_ESTADO_CIVIL, @CALLE, @NUMERO_EXTERIOR, @NUMERO_INTERIOR, @FK_COLONIA, @TELEFONO_CASA, @TELEFONO_MOVIL, @CORREO1, 1,(SELECT PK_CODIGO_POSTAL FROM CAT_CODIGO_POSTAL WHERE NUMERO = @CP));

            SELECT @FK_PADRE = PK_USUARIO FROM CAT_USUARIO WHERE CURP = @CURP;

            INSERT INTO CAT_ASPIRANTE (FK_PERIODO, PREFICHA, NUMERO_PREFICHA,PADRE_TUTOR,MADRE,FK_BACHILLERATO,ESPECIALIDAD,PROMEDIO,NACIONALIDAD,FK_CIUDAD,FK_CARRERA_1,FK_CARRERA_2,FK_PROPAGANDA_TECNOLOGICO, FK_UNIVERSIDAD, FK_CARRERA_UNIVERSIDAD,FK_DEPENDENCIA,TRABAJAS_Y_ESTUDIAS, AYUDA_INCAPACIDAD, AVISO_PRIVACIDAD,FK_PADRE,FK_ESTATUS)
            VALUES (@periodo, @PREFICHA, @NUMERO_PREFICHA, @PADRE_TUTOR, @MADRE, @FK_BACHILLERATO, @ESPECIALIDAD, @PROMEDIO, @NACIONALIDAD, @FK_CIUDAD, @FK_CARRERA_1, @FK_CARRERA_2, @FK_PROPAGANDA_TECNOLOGICO, @FK_UNIVERSIDAD, @FK_CARRERA_UNIVERSIDAD, @FK_DEPENDENCIA, @TRABAJAS_Y_ESTUDIAS, @AYUDA_INCAPACIDAD
        ,1,@FK_PADRE,1);

            INSERT INTO PER_TR_ROL_USUARIO (FK_ROL,FK_USUARIO) VALUES ((SELECT PK_ROL FROM PER_CAT_ROL WHERE NOMBRE = 'Aspirante'),@FK_PADRE);
                    
                    SELECT 5 AS RESPUESTA, PK_USUARIO, CURP, CORREO1 FROM  CAT_USUARIO where CURP = @CURP; -- SE REGISTRO CORRECTAMENTE
        END            
        SET NOCOUNT OFF
go




-- --------------------------------------------------------------------------------------------------------------------------------
