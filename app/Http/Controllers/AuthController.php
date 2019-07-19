<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

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
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(SignUpRequest $request)
    {
        error_log($request->curp);
        $usuario = User::where('CURP', $request->curp)->first();
        if (!isset($usuario->CURP)){
            //si el CURP no se encuentra registrado, registrar usuario y enviar correo
            $pk_usuario = $this->crear_usuario($request);
            error_log($pk_usuario);
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
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['curp', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Correo o contraseña no registrada brow :v'], 401);
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
        $id = DB::table('users')
            ->select('PK_USUARIO', 'NUMERO_CONTROL')
            ->where('email', auth()->user()->email)
            ->get()->first();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->email,
            'IdUsuario' => $id->PK_USUARIO,
            'control' => $id->NUMERO_CONTROL

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
    /**
     * Función para asignar roles a usuario
     * @param $pk_usuario
     * @return void
     */
    private function asignar_roles($pk_usuario){

    }

    /**
     * Función para crear un nuevo usuario
     * @param $request
     * @return User
     */
    private function crear_usuario($request){
        $usuario  = new User;

        $usuario->CORREO1          = $request->email;
        $usuario->NUMERO_CONTROL   = $request->NUMERO_CONTROL;
        $usuario->name             = $request->name;
        $usuario->PRIMER_APELLIDO  = $request->PRIMER_APELLIDO;
        $usuario->SEGUNDO_APELLIDO = $request->SEGUNDO_APELLIDO;
        $usuario->CLAVE_CARRERA    = $request->CLAVE_CARRERA;
        $usuario->SEMESTRE         = $request->SEMESTRE;
        $usuario->CURP             = $request->curp;
        $usuario->TELEFONO_CASA    = $request->TELEFONO_FIJO;
        $usuario->TELEFONO_MOVIL   = $request->TELEFONO_MOVIL;
        $usuario->FECHA_REGISTRO   = date('Y-m-d H:i:s');

        $usuario->save();
        return $usuario;
    }
}
