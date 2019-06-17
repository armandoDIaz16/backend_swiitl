<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Constantes_Alumnos;

class NumeroControl extends Controller
{
    public function getControl(Request $request){
        $alumno = DB::connection('sqlsrv2')
            ->table('view_alumnos')
            ->select('Estado', 'Nombre', 'ApellidoPaterno', 'ApellidoMaterno', 'NumeroControl','ClaveCarrera','Semestre')
            ->where('NumeroControl',$request->control)
            ->get()->first();

        if(!empty($alumno)){
            if ($alumno->Estado != Constantes_Alumnos::ALUMNO_BD)
                return $this->successResponse($alumno);
        }

        return $this->failedResponse();
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Numero de control no encontrado o estado de alumno no valido'
        ], Response::HTTP_NOT_FOUND);
    }
    public function successResponse($alumno){
        $datos_alumno = [
            'nombre'           => trim($alumno->Nombre),
            'primer_apellido' => trim($alumno->ApellidoPaterno),
            'segundo_apellido' => trim($alumno->ApellidoMaterno),
            'clave_carrera' => trim($alumno->ClaveCarrera),
            'semestre' => trim($alumno->Semestre),
            'numero_control'   => trim($alumno->NumeroControl)
        ];
        return response()->json(['data' => $datos_alumno], Response::HTTP_OK);
    }
}
