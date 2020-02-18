<?php

namespace App\Http\Controllers;

use App\GrupoTutorias;
use App\Helpers\SiiaHelper;
use App\Http\Requests\SignUpRequest;
use App\Rol;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Carrera;
use App\User;
use App\Constantes_Alumnos;
use App\Usuario_Rol;
use App\ObtenerContrasenia;
use App\Models\General\Sistema;

use App\Helpers\Mailer;
use App\Helpers\UsuariosHelper;
use App\Helpers\Constantes;
use App\Helpers\EncriptarUsuario;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Función para validar cuenta en uso mediante CURP
     * generar nuevo registro y enviar correo para activación de cuenta
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registra_usuario(Request $request)
    {
        // verificar si está registrado
        $usuario = User::where('CURP', trim($request->curp))->first();
        if (!isset($usuario->CURP)) { // no está registrado
            // crear usuario
            $usuario = $this->crear_usuario($request);

            // asigna roles a usuario
            $this->asignar_roles($usuario);

            // genera token
            $token = $this->get_datos_token($usuario);

            // enviar correo de notificación
            if (!$this->notifica_usuario(
                $usuario->CORREO1,
                $token->TOKEN,
                $token->CLAVE_ACCESO
            )) {
                error_log("Error al enviar correo al receptor en activación de cuenta: " . $usuario->CORREO1);
                error_log("AuthController.php");
            }

            // llamada exitosa
            return response()->json(['data' => true], Response::HTTP_OK);
        } else { // ya se encuentra registrado
            // validar si la cuenta está activa
            if ($usuario->ESTADO == Constantes_Alumnos::ALUMNO_REGISTRADO) { // la cuenta no se ha activado
                // actualizar datos del usuario
                $this->crear_usuario($request, $usuario);

                // genera token
                $token = $this->get_datos_token($usuario);

                // enviar correo de notificación
                if (!$this->notifica_usuario(
                    $usuario->CORREO1,
                    $token->TOKEN,
                    $token->CLAVE_ACCESO
                )) {
                    error_log("Error al enviar correo al receptor en activación de cuenta: " . $usuario->CORREO1);
                    error_log("AuthController.php");
                }

                // llamada exitosa
                return response()->json(['data' => true], Response::HTTP_OK);
            } else { // mandar mensaje de cuenta activa y vinculada a CURP
                return response()->json(
                    ['error' => "La CURP proporcionada ya se encuentra asociada a una cuenta"],
                    Response::HTTP_NOT_FOUND
                );
            }
        }
    }

    /**
     * Función para obtener los datos de activación de cuenta mediante CURP encriptada
     * guarda contraseña, actualiza estatus y envía correo de confirmación
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_datos_activacion(Request $request)
    {
        $datos_token_vigente = ObtenerContrasenia::where('TOKEN', $request->token)
            ->where('FECHA_GENERACION', '>=', date('Y-m-d 00:00:00'))
            ->where('FECHA_GENERACION', '<=', date('Y-m-d 23:59:59'))
            ->where('ESTADO', 1)
            ->first();

        if ($datos_token_vigente) {
            $usuario = User::where('PK_USUARIO', $datos_token_vigente->FK_USUARIO)->first();
            if ($usuario->ESTADO == Constantes_Alumnos::ALUMNO_REGISTRADO || $usuario->ESTADO == Constantes_Alumnos::ALUMNO_CUENTA_ACTIVA) {
                return response()->json(
                    [
                        'data' => [
                            'CURP' => $usuario->CURP
                        ]
                    ],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(
                    ['error' => "La cuenta ya se encuentra activa, inténte recuperar su contraseña"],
                    Response::HTTP_NOT_FOUND
                );
            }
        } else {
            //mandar mensaje de Token no válido
            return response()->json(
                ['error' => "El token de seguridad ha expirado"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Función para activar la cuenta de un usuario mediante CURP
     * guarda contraseña, actualiza estatus y envía correo de confirmación
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activa_cuenta(Request $request)
    {
        // buscar token en tabla de solicitudes
        $datos_token = ObtenerContrasenia::where('TOKEN', $request->token)
            ->where('FECHA_GENERACION', '>=', date('Y-m-d 00:00:00'))
            ->where('FECHA_GENERACION', '<=', date('Y-m-d 23:59:59'))
            ->where('ESTADO', 1)
            ->first();
        if ($datos_token) {
            if ($datos_token->CLAVE_ACCESO == $request->clave) {
                // actualizar usuario
                $usuario = User::where('CURP', $request->curp)->first();
                $usuario->password = $request->password1;
                $usuario->ESTADO = Constantes_Alumnos::ALUMNO_CUENTA_ACTIVA;
                $usuario->FECHA_MODIFICACION = date('Y-m-d H:i:s');
                $usuario->save();

                // expirar token
                $datos_token->ESTADO = 2;
                $datos_token->save();

                // respuesta exitosa
                return response()->json(
                    ['data' => true],
                    Response::HTTP_OK
                );
            } else {
                //mandar mensaje de clave no válida
                return response()->json(
                    ['error' => "La clave proporcionada no es válida"],
                    Response::HTTP_NOT_FOUND
                );
            }
        } else {
            //mandar mensaje de Token no válido
            return response()->json(
                ['error' => "El token de seguridad ha expirado"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Función para validar cuenta en uso mediante CURP
     * generar nuevo registro y enviar correo para activación de cuenta
     *
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function signup(SignUpRequest $request)
    {
        error_log($request->curp);
        $usuario = User::where('CURP', $request->curp)->first();
        if (!isset($usuario->CURP)){
            //si el CURP no se encuentra registrado, registrar usuario y enviar correo
            $pk_usuario = $this->crear_usuario($request);
            // error_log($pk_usuario);
            $this->asignar_roles($pk_usuario);

            return response()->json(
                ['data' => true],
                Response::HTTP_OK
            );
        } else {
            //mandar mensaje de CURP registrada
            return response()->json(
                ['error' => "La CURP proporcionada ya se encuentra asociada a una cuenta"],
                Response::HTTP_NOT_FOUND
            );
        }
    }*/

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['curp', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'CURP o contraseña no registrados'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $this->verifica_primer_login();
        $this->revisa_roles(auth()->user()->PK_ENCRIPTADA);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->CORREO1,
            'IdUsuario' => auth()->user()->PK_USUARIO,
            'control' => auth()->user()->NUMERO_CONTROL,
            'perfil_completo' => auth()->user()->PERFIL_COMPLETO,
            'primer_login' => auth()->user()->PRIMER_LOGIN,
            'IdEncriptada' => auth()->user()->PK_ENCRIPTADA,
            'tipo_usuario' => auth()->user()->TIPO_USUARIO
        ]);
    }

    private function revisa_roles($pk_encriptada) {
        $usuario = UsuariosHelper::get_usuario($pk_encriptada);
        switch ($usuario->TIPO_USUARIO) {
            case Constantes::USUARIO_ALUMNO:
                // es alumno
                $this->actualiza_datos_alumno($usuario);
                break;
            case Constantes::USUARIO_DOCENTE:
                // es empleado
                $this->actualiza_datos_empleado($usuario);
                break;
            case Constantes::USUARIO_ASPIRANTE:
                // es aspirante
                $this->actualiza_datos_aspirante($usuario);
                $this->asigna_rol_tutorias_estudiante($usuario);
                break;
        }
    }

    private function asigna_rol_tutorias_estudiante(Usuario $usuario) {
        // ASIGNAR ROL DE TUTORIAS
        $rol = Rol::where('ABREVIATURA', 'EST_TUT')->first();
        if ($rol) {
            $rol_tutorias = Usuario_Rol::where('FK_USUARIO', $usuario->PK_USUARIO)
                ->where('FK_ROL', $rol->PK_ROL)
                ->first();

            if (!$rol_tutorias) {
                $rol_tutorias = new Usuario_Rol;
                $rol_tutorias->FK_USUARIO = $usuario->PK_USUARIO;
                $rol_tutorias->FK_ROL     = $rol->PK_ROL;

                $rol_tutorias->save();
            }
        }
    }

    private function actualiza_datos_aspirante(Usuario $usuario) {
        $alumno_siia = SiiaHelper::buscar_aspirante(
            $usuario->NOMBRE,
            $usuario->PRIMER_APELLIDO,
            $usuario->SEGUNDO_APELLIDO
        );

        if ($alumno_siia) {
            // ACTUALIZAR ALUMNO
            $carrera = Carrera::where('ABREVIATURA', trim($alumno_siia->ClaveCarrera))->first();
            $usuario->NOMBRE           = trim($alumno_siia->Nombre);
            if ($alumno_siia->ApellidoPaterno) {
                $usuario->PRIMER_APELLIDO  = trim($alumno_siia->ApellidoPaterno);
            }
            if ($alumno_siia->ApellidoMaterno) {
                $usuario->SEGUNDO_APELLIDO = trim($alumno_siia->ApellidoMaterno);
            }
            $usuario->NUMERO_CONTROL   = trim($alumno_siia->NumeroControl);
            $usuario->SEMESTRE         = trim($alumno_siia->Semestre);
            $usuario->FK_CARRERA       = $carrera->PK_CARRERA;

            // CAMBIAR EL TIPO DE USUARIO DE ASPIRANTE A ALUMNO
            $usuario->TIPO_USUARIO = Constantes::USUARIO_ALUMNO;

            // DATOS DE AUDITORIA
            $usuario->FECHA_MODIFICACION      = date('Y-m-d H:i:s');
            // el cero es para indicar que fue actualiación por sincronización con el siia
            $usuario->FK_USUARIO_MODIFICACION = 0;

            $usuario->save();

            // QUITAR ROL DE ASPIRANTE
            $rol = Rol::where('ABREVIATURA', 'ASP')->first();
            $rol_aspirante = Usuario_Rol::where('FK_USUARIO', $usuario->PK_USUARIO)
                ->where('FK_ROL', $rol->PK_ROL)
                ->first();

            if ($rol_aspirante) {
                $rol_aspirante->delete();
            }
        }
    }

    private function actualiza_datos_empleado(Usuario $usuario) {
        $empleado_siia = SiiaHelper::buscar_empleado($usuario->NUMERO_CONTROL);

        error_log(print_r($empleado_siia, true));

        if ($empleado_siia) {
            $usuario->NOMBRE           = trim($empleado_siia->Nombre);
            if ($empleado_siia->ApellidoPaterno) {
                $usuario->PRIMER_APELLIDO  = trim($empleado_siia->ApellidoPaterno);
            }
            if ($empleado_siia->ApellidoMaterno) {
                $usuario->SEGUNDO_APELLIDO = trim($empleado_siia->ApellidoMaterno);
            }

            $usuario->FECHA_MODIFICACION      = date('Y-m-d H:i:s');
            // el cero es para indicar que fue actualiación por sincronización con el siia
            $usuario->FK_USUARIO_MODIFICACION = 0;

            $usuario->save();
        }
    }

    private function actualiza_datos_alumno(Usuario $usuario) {
        $alumno_siia = SiiaHelper::buscar_alumno(
            $usuario->NUMERO_CONTROL,
            $usuario->NOMBRE,
            $usuario->PRIMER_APELLIDO,
            $usuario->SEGUNDO_APELLIDO
        );

        if ($alumno_siia) {
            $carrera = Carrera::where('ABREVIATURA', trim($alumno_siia->ClaveCarrera))->first();

            $usuario->NOMBRE           = trim($alumno_siia->Nombre);
            if ($alumno_siia->ApellidoPaterno) {
                $usuario->PRIMER_APELLIDO  = trim($alumno_siia->ApellidoPaterno);
            }
            if ($alumno_siia->ApellidoMaterno) {
                $usuario->SEGUNDO_APELLIDO = trim($alumno_siia->ApellidoMaterno);
            }
            $usuario->NUMERO_CONTROL   = trim($alumno_siia->NumeroControl);
            $usuario->SEMESTRE         = trim($alumno_siia->Semestre);
            $usuario->FK_CARRERA       = $carrera->PK_CARRERA;

            $usuario->FECHA_MODIFICACION      = date('Y-m-d H:i:s');
            // el cero es para indicar que fue actualiación por sincronización con el siia
            $usuario->FK_USUARIO_MODIFICACION = 0;

            $usuario->save();
        }
    }

    private function verifica_primer_login() {
        if (auth()->user()->PRIMER_LOGIN == 0) {
            $pk_encriptada = EncriptarUsuario::getPkEncriptada(
                auth()->user()->PK_USUARIO,
                auth()->user()->FECHA_REGISTRO
            );

            User::where(
                [
                    ['PRIMER_LOGIN', 0],
                    ['PK_USUARIO', auth()->user()->PK_USUARIO]
                ]
            )->update(
                [
                    'PRIMER_LOGIN' => 1,
                    'PK_ENCRIPTADA' => $pk_encriptada
                ]
            );

            auth()->user()->PK_ENCRIPTADA = $pk_encriptada;
        }
    }

    /* --------------------------
    Servicios para el registro de usuarios que no son alumnos en el sistema de CREDITOS COMPLEMENTARIOS
    --------------------------------
    */

    /**
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signupAdminCredito(SignUpRequest $request)
    {
        //todo Cambiar a generación de objeto de usaurio de forma explícita
        User::create($request->all());


        return response()->json(['data' => true], Response::HTTP_OK);
        //return $this->login($request);
    }

    private function get_datos_token($usuario)
    {
        // buscar token activo
        $datos_token = ObtenerContrasenia::where('FK_USUARIO', $usuario->PK_USUARIO)
            ->where('FECHA_GENERACION', '>=', date('Y-m-d 00:00:00'))
            ->where('FECHA_GENERACION', '<=', date('Y-m-d 23:59:59'))
            ->where('ESTADO', 1)
            ->first();

        if (!isset($datos_token->FK_USUARIO)) { // sí no tiene token activo
            // generar token y clave
            $fecha = date('Y-m-d H:i:s');
            $token = UsuariosHelper::get_token_contrasenia($usuario->CURP, $fecha);
            $clave = UsuariosHelper::get_clave_verificacion();

            // registro en tabla de contraseñas
            $datos_token = new ObtenerContrasenia;
            $datos_token->FK_USUARIO = $usuario->PK_USUARIO;
            $datos_token->TOKEN = $token;
            $datos_token->CLAVE_ACCESO = $clave;
            $datos_token->FECHA_GENERACION = $fecha;
            $datos_token->save();
        }

        return $datos_token;
    }

    /*
     * FUNCIONES PRIVADAS DE LA CASE
     * */
    private function notifica_usuario($correo_receptor, $token, $clave)
    {
        //enviar correo de notificación
        $mailer = new Mailer(
            array(
                // datos que se mostrarán del emisor
                // 'correo_emisor' => $datos_sistema->CORREO1,
                'correo_emisor' => 'tecvirtual@itleon.edu.mx',
                'nombre_emisor' => utf8_decode('Tecnológico Nacional de México en León'),

                // array correos receptores
                'correos_receptores' => array($correo_receptor),

                // asunto del correo
                'asunto' => utf8_decode('TecVirtual - Activación de cuenta'),

                // cuerpo en HTML del correo
                'cuerpo_html' => view(
                    'mails.activacion_cuenta',
                    ['token' => $token, 'clave' => $clave]
                )->render()
            )
        );

        return $mailer->send();
    }

    /**
     * Función para asignar roles a usuario
     * @param $pk_usuario
     * @return void
     */
    private function asignar_roles($usuario)
    {
        if ($usuario->TIPO_USUARIO == 1) { // lógica para alumnos
            if ($usuario->SEMESTRE == 1) { // alumno de primer semestre
                // asigna rol de tutorías
                $usuario_rol = new Usuario_Rol;
                $usuario_rol->FK_ROL     = 1;
                $usuario_rol->FK_USUARIO = $usuario->PK_USUARIO;
                $usuario_rol->save();

                // activa encuestas tutorías
                $this->activa_encuestas_tutorias($usuario->PK_USUARIO);
            } else { // es alumno de semestre 2 en delante

            }
        } else if ($usuario->TIPO_USUARIO == 2) { // lógica para docentes
            // consultar si es tutor en el periodo activo
            $es_tutor = $this->es_tutor_siia($usuario->NUMERO_CONTROL);
            if ($es_tutor) {
                // asigna rol de tutor
                $usuario_rol = new Usuario_Rol;
                $usuario_rol->FK_ROL     = 2;
                $usuario_rol->FK_USUARIO = $usuario->PK_USUARIO;
                $usuario_rol->save();

                $this->verifica_grupo_tutorias($es_tutor[0]->clavegrupo, $usuario->PK_USUARIO, Constantes::get_periodo(), $usuario->NUMERO_CONTROL);
            }
            // logica para asignar roles del Sistema de capacitación Docente
            // EL ROL A ASIGNAR ES EL ROL DE PARTICIPANTE EL CUAL DEBE TENERLO SIEMPRE UN DOCENTE DEL ITL PARA QUE PUEDA PROPONER CURSOS  O TOMARLOS
            $docente_rol = new Usuario_Rol;
            $docente_rol->FK_ROL     = 2;  // TODO CAMBIAR ESTE VALOR ES VARIABLE SEGUN EL ROL OBTENIDO EN LA EJECUCIÓN DEL SCRIPT DE BD
            $docente_rol->FK_USUARIO = $usuario->PK_USUARIO;
            $docente_rol->save();

        } else { // lógica para usuarios que no son docentes ni alumnos
            // logica para asignar roles del Sistema de capacitación Docente
            // EL ROL A ASIGNAR ES EL ROL DE PARTICIPANTE EL CUAL DEBE TENERLO UN PERSONAL ADMON DEL ITL PARA QUE PUEDA PROPONER CURSOS  O TOMARLOS
            // O UN DOCENTE EXTERNO
            $docente_rol = new Usuario_Rol;
            $docente_rol->FK_ROL     = 2;  // TODO CAMBIAR ESTE VALOR ES VARIABLE SEGUN EL ROL OBTENIDO EN LA EJECUCIÓN DEL SCRIPT DE BD
            $docente_rol->FK_USUARIO = $usuario->PK_USUARIO; // TODO PROBAR UN INSERT DE ESTE TIPO
            $docente_rol->save();
        }
    }

    private function verifica_grupo_tutorias($clave_grupo, $pk_tutor, $periodo, $numero_control)
    {
        // buscar grupo dado de alta
        $grupo = GrupoTutorias::where('CLAVE', $clave_grupo)
            ->where('FK_USUARIO', $pk_tutor)
            ->where('PERIODO', Constantes::get_periodo())
            ->where('ESTADO', 1)
            ->first();

        if (!isset($grupo->CLAVE)) { // no está registrado el grupo
            // buscar carrera del grupo en el siia
            $clave_carrera_siia = $this->get_carrera_grupo_siia($periodo, $clave_grupo)[0]->ClaveCarrera;

            //buscar lista de alumnos del grupo en el siia
            $grupo_siia = $this->get_grupo_siia($periodo, $numero_control);

            //buscar fk_carrera en TEC_VITRUAL
            $carrera = Carrera::where('CLAVE_TECLEON', $clave_carrera_siia)->first();

            // crear grupo
            $nuevo_grupo = new GrupoTutorias;
            $nuevo_grupo->FK_CARRERA = $carrera->PK_CARRERA;
            $nuevo_grupo->FK_USUARIO = $pk_tutor;
            $nuevo_grupo->PERIODO    = Constantes::get_periodo();
            $nuevo_grupo->CLAVE      = $clave_grupo;
            $nuevo_grupo->TIPO_GRUPO = Constantes::GRUPO_TUTORIA_INICIAL;
            $nuevo_grupo->FK_USUARIO_REGISTRO = $pk_tutor;
            $nuevo_grupo->save();

            //crear detalle de grupo
            $array_detalle_grupo = [];
            foreach ($grupo_siia as $alumno) {
                $usuario = Usuario::where('NUMERO_CONTROL', $alumno->NumeroControl)->first();
                if (isset($usuario->PK_USUARIO)) {
                    $array_detalle_grupo[] = [
                        'FK_GRUPO'   => $nuevo_grupo->PK_GRUPO_TUTORIA,
                        'FK_USUARIO' => $usuario->PK_USUARIO,
                        'FK_USUARIO_REGISTRO' => $usuario->PK_USUARIO
                    ];
                } else {
                    error_log(
                        'No se ha encontrado al alumno: '
                            . $alumno->NumeroControl
                            . ' en generación de grupo. AuthController'
                    );
                }
            }

            DB::table('TR_GRUPO_TUTORIA_DETALLE')->insert($array_detalle_grupo);
        } else { // sí está registrado el grupo
            // obtener alumnos del grupo del siia

            //actualizar el grupo en base de datos TEC_VIRTUAL
        }
    }

    private function get_grupo_siia($periodo, $pk_tutor)
    {
        $sql = "
        SELECT
            NumeroControl,
            Nombre,
            ApellidoPaterno,
            ApellidoMaterno,
            Semestre,
            ClaveCarrera
        FROM
            dbo.view_alumnos
        WHERE
            NumeroControl IN (
                SELECT DISTINCT
                    NumeroControl
                FROM
                    dbo.view_horarioalumno
                WHERE
                    IdPeriodoEscolar = $periodo
                    AND IdMaestro = $pk_tutor
                    AND clavemateria = 'PDH'
                    -- AND clavegrupo = ''
            )
        ;";

        return DB::connection('sqlsrv2')->select($sql);
    }

    private function get_carrera_grupo_siia($periodo, $clave_grupo)
    {
        $sql = "
        SELECT
            ClaveCarrera
        FROM
            dbo.view_alumnos
        WHERE
            NumeroControl = (
                SELECT TOP 1 NumeroControl
                FROM dbo.view_horarioalumno
                WHERE IdPeriodoEscolar = $periodo
                  AND clavemateria = 'PDH'
                  AND clavegrupo = $clave_grupo
            )
        ;";

        return DB::connection('sqlsrv2')->select($sql);
    }

    private function es_tutor_siia($numero_control)
    {
        $sql = "SELECT DISTINCT
                    IdMaestro,
                    clavegrupo
                FROM
                    view_horarioalumno
                WHERE
                    IdPeriodoEscolar = " . Constantes::get_periodo() . "
                    AND clavemateria = 'PDH'
                    AND IdMaestro    = " . $numero_control . ";";

        return DB::connection('sqlsrv2')->select($sql);
    }

    private function activa_encuestas_tutorias($pk_usuario)
    {
        // Activación de encuestas para primer semestre0
        $fecha = date('Y-m-d H:i:s');
        DB::table('TR_APLICACION_ENCUESTA')->insert([
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 1,
                'FECHA_APLICACION' => $fecha,
                'PERIODO' => Constantes::get_periodo()
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 2,
                'FECHA_APLICACION' => $fecha,
                'PERIODO' => Constantes::get_periodo()
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 3,
                'FECHA_APLICACION' => $fecha,
                'PERIODO' => Constantes::get_periodo()
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 4,
                'FECHA_APLICACION' => $fecha,
                'PERIODO' => Constantes::get_periodo()
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 5,
                'FECHA_APLICACION' => $fecha,
                'PERIODO' => Constantes::get_periodo()
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 6,
                'FECHA_APLICACION' => $fecha,
                'PERIODO' => Constantes::get_periodo()
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 8,
                'FECHA_APLICACION' => $fecha,
                'PERIODO' => Constantes::get_periodo()
            ]
        ]);
    }

    /**
     * Función para crear un nuevo usuario
     * @param $request
     * @return User
     */
    private function crear_usuario($request, $usuario = null)
    {
        if ($usuario) {
            $usuario->CORREO1        = $request->email;
            $usuario->TELEFONO_CASA  = $request->TELEFONO_FIJO;
            $usuario->TELEFONO_MOVIL = $request->TELEFONO_MOVIL;
        } else {
            // crea usuario
            $usuario = new User;
            if ($request->TIPO_USUARIO == 1) { // datos propios de alumno
                $carrera = Carrera::where('CLAVE_TECLEON', $request->CLAVE_CARRERA)->first();
                $usuario->FK_CARRERA   = $carrera->PK_CARRERA;
                $usuario->SEMESTRE     = $request->SEMESTRE;
            }

            $usuario->CORREO1 = $request->email;
            $usuario->NUMERO_CONTROL = $request->NUMERO_CONTROL;
            $usuario->NOMBRE = $request->name;
            $usuario->PRIMER_APELLIDO = $request->PRIMER_APELLIDO;
            $usuario->SEGUNDO_APELLIDO = $request->SEGUNDO_APELLIDO;
            $usuario->CURP = $request->curp;
            $usuario->TOKEN_CURP = Hash::make($request->curp);
            $usuario->TELEFONO_CASA = $request->TELEFONO_FIJO;
            $usuario->TELEFONO_MOVIL = $request->TELEFONO_MOVIL;
            $usuario->ESTADO = Constantes_Alumnos::ALUMNO_REGISTRADO;
            $usuario->TIPO_USUARIO = $request->TIPO_USUARIO;
        }

        $usuario->save();

        return $usuario;
    }
    public function recuperarContrasena(Request $request)
    {
        $usuario = Usuario::where('CURP', $request->CURP)->first();
        if (isset($usuario->PK_USUARIO)) {
            // error_log(print_r($usuario, true));
            $token = $this->get_datos_token($usuario);
            if (!$this->notifica_usuario(
                $usuario->CORREO1,
                $token->TOKEN,
                $token->CLAVE_ACCESO
            )) {
                error_log("Error al enviar correo al receptor en activación de cuenta: " . $usuario->CORREO1);
                error_log("AuthController.php");
            } else {
                return response()->json(
                    ['data' => true],
                    Response::HTTP_OK
                );
            }
        } else { // mandar mensaje de cuenta activa y vinculada a CURP
            return response()->json(
                ['error' => "La CURP proporcionada no se encuentra registrada"],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
