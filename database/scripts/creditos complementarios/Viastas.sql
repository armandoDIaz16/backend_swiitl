
 CREATE VIEW [dbo].[actividades_v] AS
 SELECT A.PK_ACTIVIDAD, A.NOMBRE, A.DESCRIPCION, A.LUGAR, 
    replace(convert(NVARCHAR, a.FECHA, 106), ' ', '/') as FECHA,
    A.HORA + ' HRS' as HORA, A.CUPO, B.NOMBRE AS FK_LINEAMIENTO, C.NOMBRE AS FK_TIPO, (D.PRIMER_APELLIDO + ' ' + D.SEGUNDO_APELLIDO + ' ' + D.NOMBRE)  AS FK_RESPONSABLE
    FROM dbo.ACTIVIDADES A
    JOIN dbo.LINEAMIENTOS B ON A.FK_LINEAMIENTO = B.PK_LINEAMIENTO
    JOIN dbo.TIPOS C ON A.FK_TIPO = c.PK_TIPO
    JOIN dbo.CAT_USUARIO D ON A.FK_RESPONSABLE = D.PK_USUARIO
GO

/* --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

CREATE VIEW [dbo].[responsables_v] AS
Select u.PK_USUARIO, (u.PRIMER_APELLIDO + ' ' + u.SEGUNDO_APELLIDO + ' ' + u.NOMBRE) As NOMBRE
 FROM dbo.CAT_USUARIO u
 JOIN dbo.PER_TR_ROL_USUARIO ru ON u.PK_USUARIO = ru.FK_USUARIO
 JOIN dbo.PER_CAT_ROL rol on ru.FK_ROL = rol.PK_ROL
 WHERE rol.NOMBRE = 'Responsable de actividad';
GO

