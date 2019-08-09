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
use App\Models\General\Sistema;

use App\Helpers\Mailer;


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
        $usuario = User::where('CURP', $request->curp)->first();
        if (!isset($usuario->CURP)) {
            //si el CURP no se encuentra registrado, registrar usuario
            $pk_usuario = $this->crear_usuario($request);
            if ($pk_usuario) {
                // asigna roles a usuario
                //$this->asignar_roles($pk_usuario);

                // enviar correo de notificación al usuario
                if (!$this->notifica_usuario($request->email)){
                    error_log("Error al enviar correo al receptor: " . $request->email);
                }

                return response()->json(
                    ['data' => true],
                    Response::HTTP_OK
                );
            }
        } else {
            //mandar mensaje de CURP registrada
            return response()->json(
                ['error' => "La CURP proporcionada ya se encuentra asociada a una cuenta"],
                Response::HTTP_NOT_FOUND
            );
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
        $usuario = User::where('TOKEN_CURP', $request->token)->first();
        if (isset($usuario->CURP)) {
            if ($usuario->ESTADO == Constantes_Alumnos::ALUMNO_REGISTRADO){
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
        $usuario = User::where('CURP', $request->curp)->first();
        if (isset($usuario->CURP)) {
            $usuario->password           = $request->password1;
            $usuario->ESTADO             = Constantes_Alumnos::ALUMNO_CUENTA_ACTIVA;
            $usuario->FECHA_MODIFICACION = date('Y-m-d H:i:s');
            $usuario->save();

            return response()->json(
                ['data' => true],
                Response::HTTP_OK
            );
        } else {
            //mandar mensaje de CURP registrada
            return response()->json(
                ['error' => "Ha ocurrido un error, por favor inténtelo de nuevo"],
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
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user()->CORREO1,
            'IdUsuario'    => auth()->user()->PK_USUARIO,
            'control'      => auth()->user()->NUMERO_CONTROL
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

    /*
     * FUNCIONES PRIVADAS DE LA CASE
     * */
    private function notifica_usuario($correo_receptor)
    {
        $datos_sistema = Sistema::where('ABREVIATURA', 'SIT')->first();
        $datos_usuario = User::where('CORREO1', $correo_receptor)->first();
        $curp_token = $datos_usuario->TOKEN_CURP;
        $mailer = new Mailer(
            array(
                // correo de origen
                'correo_origen'   =>  $datos_sistema->CORREO1,
                'password_origen' =>  $datos_sistema->INDICIO1,

                // datos que se mostrarán del emisor
                'correo_emisor' => $datos_sistema->CORREO1,
                'nombre_emisor' => 'Tecnológico Nacional de México en León',

                // array correos receptores
                'correos_receptores' => array($correo_receptor),

                // asunto del correo
                'asunto' => 'TecVirtual - Activación de cuenta',

                // cuerpo en HTML del correo
                'cuerpo_html' => view('mails.activacion_cuenta')->with('curp', $curp_token)->render()
            )
        );

        return $mailer->send();
    }

    /**
     * Función para asignar roles a usuario
     * @param $pk_usuario
     * @return void
     */
    private function asignar_roles($pk_usuario)
    {
        $usuario_rol = new Usuario_Rol;

        /* Inicio asignación de rol de alumno en sistema de tutorías */
        $usuario_rol->FK_ROL = 1;
        $usuario_rol->FK_USUARIO = $pk_usuario;
        $usuario_rol->save();
        /* Fin asignación de rol de alumno en sistema de tutorías */
    }

    /**
     * Función para crear un nuevo usuario
     * @param $request
     * @return User
     */
    private function crear_usuario($request)
    {
        $carrera = Carrera::where('CLAVE_TECLEON', $request->CLAVE_CARRERA)->first();

        $usuario = new User;

        $usuario->FK_CARRERA       = $carrera->PK_CARRERA;
        $usuario->CORREO1          = $request->email;
        $usuario->NUMERO_CONTROL   = $request->NUMERO_CONTROL;
        $usuario->NOMBRE           = $request->name;
        $usuario->PRIMER_APELLIDO  = $request->PRIMER_APELLIDO;
        $usuario->SEGUNDO_APELLIDO = $request->SEGUNDO_APELLIDO;
        $usuario->SEMESTRE         = $request->SEMESTRE;
        $usuario->CURP             = $request->curp;
        $usuario->TOKEN_CURP       = Hash::make($request->curp);
        $usuario->TELEFONO_CASA    = $request->TELEFONO_FIJO;
        $usuario->TELEFONO_MOVIL   = $request->TELEFONO_MOVIL;
        $usuario->ESTADO           = Constantes_Alumnos::ALUMNO_REGISTRADO;

        $usuario->save();

        return $usuario->PK_USUARIO;
    }
}
