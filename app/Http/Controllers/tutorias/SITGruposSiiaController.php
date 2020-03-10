<?php

namespace App\Http\Controllers\tutorias;

use App\Helpers\Constantes;
use App\Helpers\RespuestaHttp;
use App\Helpers\SiiaHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class SITGruposSiiaController extends Controller
{
    public function get_grupos_siia(Request $request) {
        $clave_materia = 'PDH';
        $periodo = ($request->periodo) ? $request->periodo : Constantes::get_periodo();
        $grupos = SiiaHelper::get_grupos($periodo, $clave_materia);

        if ($grupos) {
            return response()->json(
                RespuestaHttp::make_reponse_ok($grupos),
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                RespuestaHttp::make_reponse_error(),
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
