/* ROL TUTOR */
INSERT INTO PER_CAT_ROL (FK_SISTEMA, NOMBRE, ABREVIATURA) VALUES (
    (SELECT PK_SISTEMA FROM PER_CAT_SISTEMA WHERE ABREVIATURA = 'SIT'),
    N'Tutor',
    N'TUT_TUT'
);

/* modulo GRUPOS INICIALES DE TUTOR */
INSERT INTO PER_CAT_MODULO(NOMBRE, RUTA_MD5, DESCRIPCION, RUTA) VALUES
(
    'Tutoría inicial',
    (SELECT SUBSTRING(master.dbo.fn_varbintohexstr(HashBytes('MD5', 'grupos_inicial_tutor')), 3, 32 )),
    N'Grupos de tutoría inicial de tutor',
    'grupos_inicial_tutor'
);

/* relacion rol modulo */
INSERT INTO PER_TR_ROL_MODULO(FK_ROL, FK_MODULO) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_MODULO FROM PER_CAT_MODULO WHERE RUTA = 'grupos_inicial_tutor')
);

/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_GRUPOS_TUTORIA_INICIAL')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_PERFIL_GRUPAL')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_DETALLES_GRUPO')
);


/* permisos */
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_HORARIO_ALUMNO')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_DATOS_PERSONALES_ALUMNO')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_DETALLE_ENCUESTAS_ALUMNO')
);
INSERT INTO PER_TR_PERMISO(FK_ROL, FK_ACCION) VALUES
(
    (SELECT PK_ROL FROM PER_CAT_ROL WHERE ABREVIATURA = 'TUT_TUT'),
    (SELECT PK_ACCION FROM PER_CAT_ACCION WHERE CLAVE_ACCION = 'VER_PERFIL_PERSONAL')
);