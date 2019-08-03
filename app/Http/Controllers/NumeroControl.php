<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Constantes_Alumnos;

/**
 * Class NumeroControl
 * @package App\Http\Controllers
 */
class NumeroControl extends Controller
{
    /**
     * Función para validar el número de control de un nuevo usuario y
     * obtener sus datos para el registro en el sistema
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getControl(Request $request)
    {
        // Buscar alumno en el siia
        $alumno = $this->get_alumno_siia($request->control);
        if (!empty($alumno)) {
            // Validar que no esté dado de baja definitiva
            if ($alumno->ESTADO != NULL) {
                // Validar que no tenga su cuenta activa
                $usuario  = User::where('NUMERO_CONTROL', $request->control)->first();
                if (!isset($usuario->NUMERO_CONTROL)) {
                    return $this->successResponse($alumno);
                } else {
                    return $this->failedResponse(
                        "El número de control ya tiene una cuenta activa. 
                        Inicie sesión o recupere su contraseña"
                    );
                }
            }
        } else {
            return $this->failedResponse(
                "Número de control no encontrado o estado de usuario no válido"
            );
        }
    }

    /**
     * @param $error string del error correspondiente
     * @return \Illuminate\Http\JsonResponse
     */
    public function failedResponse($error)
    {
        return response()->json(
            [ 'error' => $error ],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @param $alumno
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($alumno)
    {
        $datos_alumno = [
            'nombre'           => trim($alumno->NOMBRE),
            'primer_apellido'  => trim($alumno->APELLIDO_PATERNO),
            'segundo_apellido' => trim($alumno->APELLIDO_MATERNO),
            'clave_carrera'    => trim($alumno->CLAVE_CARRERA),
            'semestre'         => trim($alumno->SEMESTRE),
            'numero_control'   => trim($alumno->NUMERO_CONTORL)
        ];

        return response()->json(
            ['data' => $datos_alumno],
            Response::HTTP_OK
        );
    }

    private function get_alumno_siia($numero_control)
    {
        return
            DB::connection('sqlsrv')
                ->table('SIIA')
                ->select('*')
                ->where('NUMERO_CONTORL', $numero_control)
                ->get()
                ->first();
    }
}
