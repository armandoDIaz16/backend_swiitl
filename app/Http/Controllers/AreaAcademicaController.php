<?php

namespace App\Http\Controllers;

use App\AreaAcademica;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AreaAcademicaController
 * @package App\Http\Controllers
 */
class AreaAcademicaController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        $areas = AreaAcademica::where('ESTADO', Constantes::ESTADO_ACTIVO)
            ->where('BORRADO', 0);

        if ($request->academica) {
            $areas->where('ES_ACADEMICA', $request->academica);
        }

        return ResponseHTTP::response_ok($areas->get());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_area_academica() {
        $areas = AreaAcademica::where('ESTADO', Constantes::ESTADO_ACTIVO)
            ->where('BORRADO', 0)
            ->orderBy('NOMBRE', 'ASC')
            ->get();

        return response()->json(
            ['data' => $areas],
            Response::HTTP_ACCEPTED
        );
    }
}
