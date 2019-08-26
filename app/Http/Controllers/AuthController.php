<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
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
                $token->CLAVE_ACCESO)) {
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
                    $token->CLAVE_ACCESO)) {
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
            if ($usuario->ESTADO == Constantes_Alumnos::ALUMNO_REGISTRADO) {
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->CORREO1,
            'IdUsuario' => auth()->user()->PK_USUARIO,
            'control' => auth()->user()->NUMERO_CONTROL,
            'perfil_completo' => auth()->user()->PERFIL_COMPLETO
        ]);
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
        //obtener correo del sistema
        $datos_sistema = Sistema::where('ABREVIATURA', 'SIT')->first();

        //enviar correo de notificación
        $mailer = new Mailer(
            array(
                // correo de origen
                'correo_origen' => $datos_sistema->CORREO1,
                'password_origen' => $datos_sistema->INDICIO1,

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
            $es_tutor = true;
            if ($es_tutor) {
                // asigna rol de tutor
                $usuario_rol = new Usuario_Rol;
                $usuario_rol->FK_ROL     = 2;
                $usuario_rol->FK_USUARIO = $usuario->PK_USUARIO;
                $usuario_rol->save();
            }

        } else { // lógica para usuarios que no son docentes ni alumnos

        }
    }

    private function activa_encuestas_tutorias($pk_usuario) {
        // Activación de encuestas para primer semestre0
        $fecha = date('Y-m-d H:i:s');
        DB::table('TR_APLICACION_ENCUESTA')->insert([
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 1,
                'FECHA_APLICACION' => $fecha
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 2,
                'FECHA_APLICACION' => $fecha
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 3,
                'FECHA_APLICACION' => $fecha
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 4,
                'FECHA_APLICACION' => $fecha
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 5,
                'FECHA_APLICACION' => $fecha
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 6,
                'FECHA_APLICACION' => $fecha
            ],
            [
                'FK_USUARIO' => $pk_usuario,
                'FK_ENCUESTA' => 8,
                'FECHA_APLICACION' => $fecha
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
}
