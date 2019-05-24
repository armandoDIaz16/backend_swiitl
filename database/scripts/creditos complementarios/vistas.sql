SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

 CREATE VIEW [dbo].[actividades_v] AS
 SELECT A.PK_ACTIVIDAD, A.NOMBRE, A.DESCRIPCION, A.LUGAR, 
    replace(convert(NVARCHAR, a.FECHA, 106), ' ', '/') as FECHA,
    A.HORA + ' HRS' as HORA, A.CUPO, B.NOMBRE AS FK_LINEAMIENTO, C.NOMBRE AS FK_TIPO, (D.PRIMER_APELLIDO + ' ' + D.SEGUNDO_APELLIDO + ' ' + D.name)  AS FK_RESPONSABLE
    FROM dbo.ACTIVIDADES A
    JOIN dbo.LINEAMIENTOS B ON A.FK_LINEAMIENTO = B.PK_LINEAMIENTO
    JOIN dbo.TIPOS C ON A.FK_TIPO = c.PK_TIPO
    JOIN dbo.users D ON A.FK_RESPONSABLE = D.PK_USUARIO
GO

CREATE VIEW [dbo].[responsables_v] AS
 Select  u.PK_USUARIO, (u.PRIMER_APELLIDO + ' ' + u.SEGUNDO_APELLIDO + ' ' + u.name) As NOMBRE
 FROM dbo.users u
 JOIN dbo.PER_TR_ROL_USUARIO ru ON u.PK_USUARIO = ru.FK_USUARIO
 WHERE ru.FK_ROL = 1002
GO