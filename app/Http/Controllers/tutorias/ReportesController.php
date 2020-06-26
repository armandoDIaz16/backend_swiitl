<?php

namespace App\Http\Controllers\tutorias;

use App\GrupoTutorias;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function periodos_tutoria(Request $request) {
        $periodos = GrupoTutorias::select('PERIODO')
            ->distinct('PERIODO')
            ->orderBy('PERIODO', 'DESC')
            ->get();

        $periodos_array = [];
        foreach ($periodos as $periodo) {
            $periodos_array[] = (object)[
                'PERIODO' => $periodo->PERIODO,
                'NOMBRE' => Constantes::get_periodo_texto($periodo->PERIODO)
            ];
        }

        return ResponseHTTP::response_ok($periodos_array);
    }
}
