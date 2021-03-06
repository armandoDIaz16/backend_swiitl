

CREATE PROC [dbo].[get_usuariolineamiento]
@pk_asistencia_alumno_actividad INT
AS
SELECT dbo.ALUMNO_ACTIVIDAD.FK_ALUMNO as alumno, dbo.ACTIVIDADES.FK_LINEAMIENTO as lineamiento
FROM dbo.ACTIVIDADES
JOIN dbo.ALUMNO_ACTIVIDAD ON dbo.ACTIVIDADES.PK_ACTIVIDAD = DBO.ALUMNO_ACTIVIDAD.FK_ACTIVIDAD
JOIN dbo.ASISTENCIA_ALUMNO_ACTIVIDAD ON dbo.ALUMNO_ACTIVIDAD.PK_ALUMNO_ACTIVIDAD = dbo.ASISTENCIA_ALUMNO_ACTIVIDAD.FK_ALUMNO_ACTIVIDAD
WHERE dbo.ASISTENCIA_ALUMNO_ACTIVIDAD.PK_ASISTENCIA_ALUMNO_ACTIVIDAD = @pk_asistencia_alumno_actividad;
GO

/** ------------------------------------------------------------------------------------------------------------------------------------------------------------ */


CREATE PROC [dbo].[getNumRegistrosRolAsistente]
@pk_rol INT,
@pk_usuario INT
AS
 select COUNT(PK_ROL_USUARIO) as registros
 from PER_TR_ROL_USUARIO
 where FK_ROL = @pk_rol AND FK_USUARIO = @pk_usuario
GO


/** ------------------------------------------------------------------------------------------------------------------------------------------------------------ */


CREATE PROC [dbo].[get_sumatorialineamiento]
@alumno INT,
@lineamiento INT
AS
SELECT l.PK_LINEAMIENTO as pk_lineamiento, SUM(t.VALOR) AS total
FROM dbo.LINEAMIENTOS as l
JOIN dbo.ACTIVIDADES as a ON l.PK_LINEAMIENTO = a.FK_LINEAMIENTO
JOIN dbo.TIPOS as t ON a.FK_TIPO = t.PK_TIPO
JOIN dbo.ALUMNO_ACTIVIDAD as aa ON a.PK_ACTIVIDAD = aa.FK_ACTIVIDAD
JOIN dbo.ASISTENCIA_ALUMNO_ACTIVIDAD as aaa ON aa.PK_ALUMNO_ACTIVIDAD = aaa.FK_ALUMNO_ACTIVIDAD
JOIN dbo.CAT_USUARIO as u on aa.FK_ALUMNO = u.PK_USUARIO
WHERE u.PK_USUARIO = @alumno AND l.PK_LINEAMIENTO = @lineamiento AND aaa.SALIDA = 1
GROUP BY l.PK_LINEAMIENTO
GO


/** ------------------------------------------------------------------------------------------------------------------------------------------------------------ */

CREATE PROC [dbo].[insert_alumnocreditos]
@alumno INT,
@lineamiento INT
AS
BEGIN
SET NOCOUNT ON;
INSERT INTO dbo.ALUMNO_CREDITO([FK_ALUMNO],[FK_LINEAMIENTO])
VALUES(@alumno, @lineamiento)
END
GO


/** ------------------------------------------------------------------------------------------------------------------------------------------------------------ */


CREATE PROC [dbo].[num_creditosbylineamiento]
@lineamiento INT,
@alumno INT
AS
SELECT u.PK_USUARIO AS alumno, COUNT(ac.FK_LINEAMIENTO) AS registros
FROM dbo.ALUMNO_CREDITO as ac 
RIGHT JOIN dbo.CAT_USUARIO AS u ON ac.FK_ALUMNO = u.PK_USUARIO
WHERE ac.FK_LINEAMIENTO = @lineamiento AND U.PK_USUARIO = @alumno
GROUP BY u.PK_USUARIO
GO

/** ------------------------------------------------------------------------------------------------------------------------------------------------------------ */

