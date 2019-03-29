<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class NumeroControl extends Controller
{
    public function getControl(Request $request){
        $estado = DB::connection('sqlsrv2')
            ->table('view_alumnos')
            ->select('estado')
            ->where('NumeroControl',$request->control)
            ->get()->first();
        if ($estado->estado == 'BD' ) {
            return $this->failedResponse();
        }else{
            return $this->successResponse();

        }
    }
    public function failedResponse()
    {
        return response()->json([
            'error' => 'numero de control o estado del alumno no valido'
        ], Response::HTTP_NOT_FOUND);
    }
    public function successResponse()
    {
        return response()->json([
            'data' => 'Se encontrol el numero de control y el estado del alumno es valido.'
        ], Response::HTTP_OK);
    }
}
