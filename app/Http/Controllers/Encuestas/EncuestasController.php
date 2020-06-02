<?php

namespace App\Http\Controllers\Encuestas;

use App\Encuesta;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EncuestasController extends Controller
{
    public function index(Request $request) {
        $encuestas = Encuesta::where('BORRADO', Constantes::BORRADO_NO);

        if ($request->sistema) {
            $encuestas->where('FK_SISTEMA', $request->sistema);
        }

        return ResponseHTTP::response_ok($encuestas->get());
    }
}
