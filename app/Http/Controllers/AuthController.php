<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','signup','signupAdminCredito']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['curp', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Correo o contraseña no registrada brow'], 401);
        }

        return $this->respondWithToken($token);

    }

    public function signup(SignUpRequest $request)
    {
        //todo Cambiar a generación de objeto de usaurio de forma explícita
        User::create($request->all());

        $alumno = DB::table('users')
        ->select('PK_USUARIO')
        ->where('NUMERO_CONTROL',$request->NUMERO_CONTROL)
        ->get();

        //return $alumno[0]->PK_USUARIO;
       // echo( $numero);

        DB::table('PER_TR_ROL_USUARIO')->insert([
            'FK_ROL' => 4,
            'FK_USUARIO' => $alumno[0]->PK_USUARIO
        ]);

        return response()->json(['data' => true], Response::HTTP_OK);
        //return $this->login($request);
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
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $id = DB::table('users')
            ->select('PK_USUARIO','NUMERO_CONTROL')
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

    public function signupAdminCredito(SignUpRequest $request)
    {
        //todo Cambiar a generación de objeto de usaurio de forma explícita
        User::create($request->all());


        return response()->json(['data' => true], Response::HTTP_OK);
        //return $this->login($request);
    }
}
