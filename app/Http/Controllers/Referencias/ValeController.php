<?php

namespace App\Http\Controllers\Referencias;

use App\Referencias\Vale;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ValeController extends Controller
{
    /**
     * Muestra todos los vales.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVales()
    {
        $vales = Vale::all();

        return response()->json(
            $vales,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Muestra un vale especificado por su PK.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getVale($id)
    {
        $vale = Vale::where('PK_VALE', $id)->first();

        if (empty($vale)) {
            return response()->json(
                'No existe ningún vale con el ID enviado.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                $vale,
                Response::HTTP_ACCEPTED
            );
        }
    }
}
