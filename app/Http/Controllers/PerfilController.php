<?php

namespace App\Http\Controllers;

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
    public function save_perfil() {

    }
}
