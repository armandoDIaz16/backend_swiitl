<?php

namespace App\Http\Controllers\tutorias;

use App\Conferencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ConferenciaController extends Controller
{
    public function get_conferencias() {
        $conferencias = Conferencia::all();

        return response()->json(
            $conferencias,
            Response::HTTP_ACCEPTED
        );
    }
}
