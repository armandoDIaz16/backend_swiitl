/* ROL ADMINISTRADOR */
INSERT INTO PER_CAT_ROL (FK_SISTEMA, NOMBRE, ABREVIATURA) VALUES (
    (SELECT PK_SISTEMA FROM PER_CAT_SISTEMA WHERE ABREVIATURA = 'SIT'),
    N'Administrador',
    N'ADM_TUT'
);

/* modulo GRUPOS INICIALES DE ADMINISRADOR */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA) VALUES
(
    'Tutoría inicial',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'grupos_inicial_administrador')), 3, 32 )),
    N'Grupos de tutoría inicial de administrador',
    'grupos_inicial_administrador'
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_administrador')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_administrador'),
    'VER_GRUPOS_TUTORIA_INICIAL'
);

INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_administrador'),
    'VER_PERFIL_GRUPAL'
);

INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_administrador'),
    'VER_DETALLES_GRUPO'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_GRUPOS_TUTORIA_INICIAL')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_PERFIL_GRUPAL')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_DETALLES_GRUPO')
);

/* MODULO DE DETALLE DE GRUPO */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Tutoría inicial detalle',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'grupos_inicial_detalle_administrador')), 3, 32 )),
    N'Detall de grupos de tutoría inicial administrador',
    'grupos_inicial_detalle_administrador',
    0
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_detalle_administrador')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_detalle_administrador'),
    'VER_HORARIO_ALUMNO'
);

INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_detalle_administrador'),
    'VER_DATOS_PERSONALES_ALUMNO'
);

INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_detalle_administrador'),
    'VER_DETALLE_ENCUESTAS_ALUMNO'
);

INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_detalle_administrador'),
    'VER_PERFIL_PERSONAL'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_HORARIO_ALUMNO')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_DATOS_PERSONALES_ALUMNO')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_DETALLE_ENCUESTAS_ALUMNO')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_PERFIL_PERSONAL')
);





/* MODULO DE RESPUESTAS DE ENCUESTA */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Respuestas de encuestas',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'respuesta_encuesta_alumno')), 3, 32 )),
    N'Respuesta de encuestas por parte de alumno',
    'respuesta_encuesta_alumno',
    0
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno'),
    'RESPUESTAS_ENCUESTA_PASATIEMPOS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno'),
    'RESPUESTAS_ENCUESTA_SALUD'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno'),
    'RESPUESTAS_ENCUESTA_COND_SOCIOECONOMICA'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno'),
    'RESPUESTAS_ENCUESTA_COND_ACADEMICA'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno'),
    'RESPUESTAS_ENCUESTA_COND_FAMILIAR'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno'),
    'RESPUESTAS_ENCUESTA_HABITOS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'respuesta_encuesta_alumno'),
    'RESPUESTAS_ENCUESTA_16PF'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'RESPUESTAS_ENCUESTA_PASATIEMPOS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'RESPUESTAS_ENCUESTA_SALUD')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'RESPUESTAS_ENCUESTA_COND_SOCIOECONOMICA')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'RESPUESTAS_ENCUESTA_COND_ACADEMICA')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'RESPUESTAS_ENCUESTA_COND_FAMILIAR')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'RESPUESTAS_ENCUESTA_HABITOS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'RESPUESTAS_ENCUESTA_16PF')
);




/* MODULO REPORTE DE ENCUESTA */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Reportes de encuestas',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'reporte_encuesta_alumno')), 3, 32 )),
    N'Reporte de encuestas de alumno',
    'reporte_encuesta_alumno',
    0
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno'),
    'REPORTE_ENCUESTA_PASATIEMPOS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno'),
    'REPORTE_ENCUESTA_SALUD'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno'),
    'REPORTE_ENCUESTA_COND_SOCIOECONOMICA'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno'),
    'REPORTE_ENCUESTA_COND_ACADEMICA'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno'),
    'REPORTE_ENCUESTA_COND_FAMILIAR'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno'),
    'REPORTE_ENCUESTA_HABITOS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'reporte_encuesta_alumno'),
    'REPORTE_ENCUESTA_16PF'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REPORTE_ENCUESTA_PASATIEMPOS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REPORTE_ENCUESTA_SALUD')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REPORTE_ENCUESTA_COND_SOCIOECONOMICA')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REPORTE_ENCUESTA_COND_ACADEMICA')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REPORTE_ENCUESTA_COND_FAMILIAR')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REPORTE_ENCUESTA_HABITOS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REPORTE_ENCUESTA_16PF')
);










/* MODULO ADMINISTRACIÓN DE USUARIOS */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Administrar usuarios',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'usuarios')), 3, 32 )),
    N'Módulo de administración de usuarios',
    'usuarios',
    1
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'usuarios')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'usuarios'),
    'EDITAR_USUARIO'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'usuarios'),
    'CORREO_RECUPERAR_CONTRASENIA'
)
;

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'EDITAR_USUARIO')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'CORREO_RECUPERAR_CONTRASENIA')
)
;







/* MODULO ADMINISTRACIÓN DE COORDINADORES INSTITUCIONALES */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Coordinadores Institucionales',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'coordinadores_institucionales')), 3, 32 )),
    N'Módulo de administración de coordinadores institucionales',
    'coordinadores_institucionales',
    1 -- IMPORTANTE ES MENU
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_institucionales')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_institucionales'),
    'VER_COORDINADORES'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_institucionales'),
    'MODIFICAR_COORDINADORES'
)
;
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_institucionales'),
    'QUITAR_ROL_COORDINADOR'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_COORDINADORES')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'MODIFICAR_COORDINADORES')
)
;
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'QUITAR_ROL_COORDINADOR')
);








/* MODULO ADMINISTRACIÓN DE COORDINADORES DEPARTAMENTALES */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Coordinadores Departamentales',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'coordinadores_departamentales')), 3, 32 )),
    N'Módulo de administración de coordinadores departamentales',
    'coordinadores_departamentales',
    1 -- IMPORTANTE ES MENU
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_departamentales')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_departamentales'),
    'VER_COORDINADORES_DEPARTAMENTALES'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_departamentales'),
    'MODIFICAR_COORDINADORES_DEPARTAMENTALES'
)
;
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'coordinadores_departamentales'),
    'QUITAR_ROL_COORDINADOR_DEPARTAMENTAL'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_COORDINADORES_DEPARTAMENTALES')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'MODIFICAR_COORDINADORES_DEPARTAMENTALES')
)
;
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'QUITAR_ROL_COORDINADOR_DEPARTAMENTAL')
);





/* MODULO GRUPOS DEL SIIA */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Grupos SIIA',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'grupos_tutorias_siia')), 3, 32 )),
    N'Módulo de grupos de tutoría del SIIA',
    'grupos_tutorias_siia',
    1 -- IMPORTANTE ES MENU
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_tutorias_siia')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_tutorias_siia'),
    'VER_GRUPOS_SIIA'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_tutorias_siia'),
    'VER_DETALLE_GRUPOS_SIIA'
)

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_GRUPOS_SIIA')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_DETALLE_GRUPOS_SIIA')
)
;





/* MODULO CONFERENCIAS */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Jornadas',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'conferencias_administrador')), 3, 32 )),
    N'Módulo de conferencias/jornadas',
    'conferencias_administrador',
    1 -- IMPORTANTE ES MENU
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'conferencias_administrador')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'conferencias_administrador'),
    'VER_CONFERENCIAS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'conferencias_administrador'),
    'REGISTRAR_CONFERENCIAS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'conferencias_administrador'),
    'EDITAR_CONFERENCIAS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'conferencias_administrador'),
    'DETALLES_CONFERENCIAS'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'conferencias_administrador'),
    'INVITAR_CONFERENCIAS'
)
;
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'conferencias_administrador'),
    'VER_CAPTURISTAS'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_CONFERENCIAS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REGISTRAR_CONFERENCIAS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'EDITAR_CONFERENCIAS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'DETALLES_CONFERENCIAS')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'INVITAR_CONFERENCIAS')
)
;
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_CAPTURISTAS')
)
;




/* MODULO APLICACIÓN DE ENCUESTAS */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Aplicación encuestas',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'aplicacion_encuesta')), 3, 32 )),
    N'Módulo de aplicación de encuestas',
    'aplicacion_encuesta',
    1 -- IMPORTANTE ES MENU
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'aplicacion_encuesta')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'aplicacion_encuesta'),
    'VER_APLICACION_ENCUSTA'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'aplicacion_encuesta'),
    'APLICAR_ENCUSTA'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'aplicacion_encuesta'),
    'ELIMINA_APLICACION_ENCUSTA'
)
;

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_APLICACION_ENCUSTA')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'APLICAR_ENCUSTA')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'ELIMINA_APLICACION_ENCUSTA')
)
;






/* MODULO GRUPOS DE SEGUIMIENTO */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA, ES_MENU) VALUES
(
    'Tutoría seguimiento',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'grupos_seguimiento_admin')), 3, 32 )),
    N'Módulo de grupos de seguimiento de tutoría',
    'grupos_seguimiento_admin',
    1 -- IMPORTANTE ES MENU
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin')
);

/* acciones */
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin'),
    'VER_GRUPOS_SEGUIMIENTO'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin'),
    'REGISTRAR_GRUPOS_SEGUIMIENTO'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin'),
    'EDITAR_GRUPOS_SEGUIMIENTO'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin'),
    'ADMINISTRAR_GRUPOS_SEGUIMIENTO'
),
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin'),
    'ACCION_TUTORIAL_GRUPOS_SEGUIMIENTO'
)
;
INSERT INTO PER_CAT_ACCION(FK_MODULO, CLAVE_ACCION) VALUES
(
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_seguimiento_admin'),
    'ELIMINAR_GRUPO_SEGUIMIENTO'
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_GRUPOS_SEGUIMIENTO')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'REGISTRAR_GRUPOS_SEGUIMIENTO')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'EDITAR_GRUPOS_SEGUIMIENTO')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'ADMINISTRAR_GRUPOS_SEGUIMIENTO')
),
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'ACCION_TUTORIAL_GRUPOS_SEGUIMIENTO')
)
;
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'ADM_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'ELIMINAR_GRUPO_SEGUIMIENTO')
)
;