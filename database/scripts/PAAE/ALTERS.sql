http://sql.11sql.com/sql-inner-join.htm
***************************************10/04/2019*********************************************
-- Create a new table called '[PAAE_TECNOLOGICO]' in schema '[dbo]'
-- Drop the table if it already exists
IF OBJECT_ID('[dbo].[PAAE_TECNOLOGICO]', 'U') IS NOT NULL
DROP TABLE [dbo].[PAAE_TECNOLOGICO]
GO
-- Create the table in the specified schema
CREATE TABLE [dbo].[PAAE_TECNOLOGICO]
(
    [PK_TECNOLOGICO] [int] IDENTITY(1,1) NOT NULL PRIMARY KEY, -- Primary Key column
    [Nombre] NVARCHAR(50) NOT NULL,
    [Estado] NVARCHAR(50) NOT NULL,
    [Municipio] NVARCHAR(50) NOT NULL
);
GO

ALTER TABLE dbo.users ADD FK_TECNOLOGICO INT NULL;  

ALTER TABLE [dbo].[users]  WITH CHECK ADD  CONSTRAINT [users_fk_tecnologico_foreing] FOREIGN KEY([FK_TECNOLOGICO])
REFERENCES [dbo].[PAAE_TECNOLOGICO] ([PK_TECNOLOGICO])
GO
ALTER TABLE [dbo].[users] CHECK CONSTRAINT [users_fk_tecnologico_foreing]
GO

--como saber de que tec es cada usuario
SELECT name nombreestudiante,PAAE_TECNOLOGICO.NOMBRE FROM DBO.users INNER JOIN PAAE_TECNOLOGICO
ON users.FK_TECNOLOGICO = PAAE_TECNOLOGICO.PK_TECNOLOGICO

--CREAR PERIODO SOLICITUDES
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PAAE_PERIODO_SOLICITUD](
	[PK_PAAE_PERIODO] [int] IDENTITY(1,1) NOT NULL,
	[FECHA_INICIO] [date] NOT NULL,
	[FECHA_FIN] [date] NOT NULL,
	[FK_USUARIO_REGISTRO] [int] NULL,
	[FECHA_REGISTRO] [datetime] NOT NULL,
	[FK_USUARIO_MODIFICACION] [int] NULL,
	[FECHA_MODIFICACION] [datetime] NULL,
	[BORRADO] [nchar](1) NOT NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[PAAE_PERIODO_SOLICITUD] ADD PRIMARY KEY CLUSTERED 
(
	[PK_PAAE_PERIODO] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[PAAE_PERIODO_SOLICITUD] ADD  DEFAULT (getdate()) FOR [FECHA_REGISTRO]
GO
ALTER TABLE [dbo].[PAAE_PERIODO_SOLICITUD] ADD  DEFAULT ('0') FOR [BORRADO]
GO

*******************************************/*03/05/2019*/************************************************
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CATR_USER_ASESORIA_HORARIO](
	[PK_USER_ASESORIA_HORARIO] [int] IDENTITY(1,1) NOT NULL,
	[FK_USUARIO] INT NOT NULL,
	[MATERIA] NVARCHAR(50) NOT NULL,
	[DIA] NVARCHAR(12) NOT NULL,
	[HORA] NVARCHAR(20) NOT NULL,
  [PERIODO]  NVARCHAR(5) NOT NULL,
  [CAMPUS]  NVARCHAR(50) NOT NULL, 
	[FECHA_REGISTRO] [datetime] NOT NULL,
	[STATUS] NVARCHAR(20) NOT NULL,
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[CATR_USER_ASESORIA_HORARIO] ADD PRIMARY KEY CLUSTERED 
(
	[PK_USER_ASESORIA_HORARIO] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[CATR_USER_ASESORIA_HORARIO] ADD  DEFAULT (getdate()) FOR [FECHA_REGISTRO]
GO
ALTER TABLE [dbo].[CATR_USER_ASESORIA_HORARIO]  WITH CHECK ADD CONSTRAINT [fk_user_solicitud] FOREIGN KEY([FK_USUARIO])
REFERENCES [dbo].[users] ([PK_USUARIO])
GO

drop table CATR_USER_ASESORIA_HORARIO


***********************************************************************************************
ALTER TABLE dbo.users ADD NUMERO_CONTROL NVARCHAR(8);

ALTER TABLE [SWIITL].[dbo].[users] ADD CLAVE_CARRERA NVARCHAR(10);

  ALTER TABLE [SWIITL].[dbo].[users] ADD SEMESTRE NVARCHAR(2);


//
//

You can do like this:

$avg_stars = DB::table('your_table')
                ->avg('star');
//
//




************************************************************************************************
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CATR_ASESOR_ASESORIA_HORARIO]
(
    [PK_ASESOR_ASESORIA_HORARIO] [int] IDENTITY(1,1) NOT NULL,
    [FK_USUARIO] INT NOT NULL,
    [MATERIA] NVARCHAR(50) NOT NULL,
    [MATERIA1] NVARCHAR(50) NOT NULL,
    [MATERIA2] NVARCHAR(50) NOT NULL,
    [DIA] NVARCHAR(12) NOT NULL,
    [HORA] NVARCHAR(20) NOT NULL,
    [PERIODO] NVARCHAR(5) NOT NULL,
    [CAMPUS] NVARCHAR(50) NOT NULL,
    [VALIDA] NVARCHAR(30) NOT NULL,
    [FECHA_REGISTRO] [datetime] NOT NULL,
	  [STATUS] NVARCHAR(20) NOT NULL

) ON [PRIMARY]
GO
ALTER TABLE [dbo].[CATR_ASESOR_ASESORIA_HORARIO] ADD PRIMARY KEY CLUSTERED 
(
	[PK_ASESOR_ASESORIA_HORARIO] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[CATR_ASESOR_ASESORIA_HORARIO] ADD  DEFAULT (getdate()) FOR [FECHA_REGISTRO]
GO
ALTER TABLE [dbo].[CATR_ASESOR_ASESORIA_HORARIO]  WITH CHECK ADD CONSTRAINT [fk_asesor_solicitud] FOREIGN KEY([FK_USUARIO])
REFERENCES [dbo].[users] ([PK_USUARIO])
GO

drop table CATR_ASESOR_ASESORIA_HORARIO

**********************************************************************************************
SELECT distinct [ITL_SICH].[dbo].[view_reticula].Nombre, [view_seguimiento].ClaveMateria
from [ITL_SICH].[dbo].[view_seguimiento]
INNER JOIN [ITL_SICH].[dbo].[view_reticula]
ON [ITL_SICH].[dbo].[view_reticula].ClaveMateria = [ITL_SICH].[dbo].[view_seguimiento].ClaveMateria
where NumeroControl='18240602' and IdNivelCurso='CO' and Calificacion > 85

SELECT distinct ClaveMateria FROM view_seguimiento
where NumeroControl='18240602' and IdNivelCurso='CO' and Calificacion > 85

*************************************************************************************************
  select count(*) from CATR_ASESOR_ASESORIA_HORARIO 
  where FK_USUARIO='26' and VALIDA ='SERVICIO SOCIAL'

select users.name
from [CATR_ASESOR_ASESORIA_HORARIO]
INNER JOIN [users]
ON CATR_ASESOR_ASESORIA_HORARIO.FK_USUARIO = users.PK_USUARIO


*******************************************FIN************************************************
