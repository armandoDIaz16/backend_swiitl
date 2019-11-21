<?php

namespace App\Http\Controllers;

use App\AreaAcademica;
use App\Helpers\Constantes;
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
    public function get_area_academica() {
        $areas = AreaAcademica::where('ESTADO', Constantes::ESTADO_ACTIVO)
            ->where('BORRADO', 0)
            ->get();

        return response()->json(
            ['data' => $areas],
            Response::HTTP_ACCEPTED
        );
    }
}
