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
	[NUMERO_SOLICITUDES] [int] NULL,
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




*******************************************FIN************************************************