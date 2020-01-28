<?php

namespace App\Http\Controllers\Referencias;

use App\Referencias\Nivel;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class NivelController extends Controller
{
    /**
     * Muestra todos los niveles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNiveles()
    {
        $niveles = Nivel::all();

        return response()->json(
            $niveles,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Muestra un vale especificado por su PK.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getNivel($id)
    {
        $nivel = Nivel::where('PK_NIVEL', $id)->first();

        if (empty($nivel)) {
            return response()->json(
                'No existe ningún nivel con el ID enviado.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                $nivel,
                Response::HTTP_ACCEPTED
            );
        }
    }
}
