<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PerfilController
 * @package App\Http\Controllers
 */
class PerfilController extends Controller
{
    /**
     * @param $id_usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_perfil($pk_usuario) {
        // error_log($pk_usuario);
        $perfil = DB::table('VW_PERFIL_ALUMNO')
            ->where('PK_ENCRIPTADA', $pk_usuario)
            ->first();

        if ($perfil){
            return response()->json($perfil, Response::HTTP_OK);
        } else {
            return response()->json(
                ['error' => false],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     *
     */
    public function actualiza_perfil(Request $request) {
        $usuario = Usuario::where('PK_USUARIO', $request->PK_USUARIO)->first();

        $usuario->FK_ESTADO_CIVIL         = $request->ESTADO_CIVIL;
        $usuario->FK_SITUACION_RESIDENCIA = $request->SITUACION_RESIDENCIA;
        $usuario->FK_COLONIA              = $request->COLONIA;

        $usuario->FECHA_NACIMIENTO    = $request->FECHA_NACIMIENTO;
        $usuario->SEXO                = $request->SEXO;
        $usuario->CORREO1             = $request->CORREO1;
        $usuario->CORREO2             = $request->CORREO2;
        $usuario->TELEFONO_CASA       = $request->TELEFONO_CASA;
        $usuario->TELEFONO_MOVIL      = $request->TELEFONO_MOVIL;
        $usuario->CALLE               = $request->CALLE;
        $usuario->NUMERO_EXTERIOR     = $request->NUMERO_EXTERIOR;
        $usuario->NUMERO_INTERIOR     = $request->NUMERO_INTERIOR;
        $usuario->NOMBRE_CONTACTO     = $request->NOMBRE_CONTACTO;
        $usuario->PARENTESCO_CONTACTO = $request->PARENTESCO_CONTACTO;
        $usuario->TELEFONO_CONTACTO   = $request->TELEFONO_CONTACTO;
        $usuario->CORREO_CONTACTO     = $request->CORREO_CONTACTO;
        $usuario->PERFIL_COMPLETO     = 1;

        if ($usuario->save()) {
            return response()->json(true, Response::HTTP_OK);
        } else {
            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }
}
