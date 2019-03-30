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

        if(!empty($estado)){
            if ($estado->estado == 'BD' ) {
                return $this->failedResponse();
            }else{
               return $this->getName($request->control);
            }
        }
        return $this->failedResponse();
    }

    public function getName($control){
        $name = DB::connection('sqlsrv2')
            ->table('view_alumnos')
            ->select('nombre')
            ->where('NumeroControl',$control)
            ->get()->first();
            return $this->successResponse($name->nombre);

    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Numero de control no encontrado o estado de alumno no valido'
        ], Response::HTTP_NOT_FOUND);
    }
    public function successResponse($name)
    {
        return response()->json([
            'data' => trim($name)
        ], Response::HTTP_OK);
    }
}
