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
            //si existe el alumno, validar que no esté dado de baja definitiva
            if ($alumno->Estado != NULL) {
                if ($this->valida_cuenta($request->control)) {
                    $alumno->tipo_usuario = 1;
                    return $this->successResponse($alumno);
                } else {
                    return $this->failedResponse(
                        "El número de control ya tiene una cuenta activa. 
                        Inicie sesión o recupere su contraseña"
                    );
                }
            }
        } else {
            //si no existe el alumno, buscar a docente
            $docente = $this->get_docente_siia($request->control);
            if (!empty($docente)) {
                if ($this->valida_cuenta($request->control)) {
                    $docente->tipo_usuario = 2;
                    return $this->successResponse($docente);
                } else {
                    return $this->failedResponse(
                        "El número de control ya tiene una cuenta activa. 
                        Inicie sesión o recupere su contraseña"
                    );
                }
            } else {
                return $this->failedResponse(
                    "Número de control no encontrado o estado de usuario no válido"
                );
            }
        }
    }

    private function valida_cuenta($numero_control)
    {
        // Validar que no tenga su cuenta activa
        $usuario = User::where('NUMERO_CONTROL', $numero_control)->first();
        if (!isset($usuario->NUMERO_CONTROL)) {
            return true;
        } else if ($usuario->ESTADO == 1) {
            return true;
        }

        return false;
    }

    /**
     * @param $error string del error correspondiente
     * @return \Illuminate\Http\JsonResponse
     */
    public function failedResponse($error)
    {
        return response()->json(
            ['error' => $error],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @param $persona
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($persona)
    {
        // CUANDO SE CONECTA CON TABLA LOCAL
        /* $datos_alumno = [
             'nombre'           => trim($alumno->NOMBRE),
             'primer_apellido'  => trim($alumno->APELLIDO_PATERNO),
             'segundo_apellido' => trim($alumno->APELLIDO_MATERNO),
             'clave_carrera'    => trim($alumno->CLAVE_CARRERA),
             'semestre'         => trim($alumno->SEMESTRE),
             'numero_control'   => trim($alumno->NUMERO_CONTORL)
         ];*/

        // CUANDO SE CONECTA CON EL SIIA
        if ($persona->tipo_usuario == 1) {
            // es alumno
            $datos_persona = [
                'nombre' => trim($persona->Nombre),
                'primer_apellido' => trim($persona->ApellidoPaterno),
                'segundo_apellido' => trim($persona->ApellidoMaterno),
                'clave_carrera' => trim($persona->ClaveCarrera),
                'semestre' => trim($persona->Semestre),
                'numero_control' => trim($persona->NumeroControl),
                'tipo_usuario' => trim($persona->tipo_usuario)
            ];
        } else {
            // es docente
            $datos_persona = [
                'nombre' => trim($persona->Nombre),
                'primer_apellido' => trim($persona->ApellidoPaterno),
                'segundo_apellido' => trim($persona->ApellidoMaterno),
                'clave_carrera' => 0,
                'semestre' => 0,
                'numero_control' => trim($persona->Idusuario),
                'tipo_usuario' => trim($persona->tipo_usuario)
            ];
        }

        return response()->json(
            ['data' => $datos_persona],
            Response::HTTP_OK
        );
    }

    private function get_alumno_siia($numero_control)
    {
        // CUANDO SE CONECTA CON TABLA LOCAL
        /*return
            DB::connection('sqlsrv')
                ->table('SIIA')
                ->select('*')
                ->where('NUMERO_CONTORL', $numero_control)
                ->get()
                ->first();*/

        // CUANDO SE CONECTA CON EL SIIA
        return DB::connection('sqlsrv2')
            ->table('view_alumnos')
            ->select('Estado', 'Nombre', 'ApellidoPaterno', 'ApellidoMaterno', 'NumeroControl', 'ClaveCarrera', 'Semestre')
            ->where('NumeroControl', $numero_control)
            ->get()
            ->first();

    }

    private function get_docente_siia($numero_control)
    {
        // CUANDO SE CONECTA CON TABLA LOCAL
        /*return
            DB::connection('sqlsrv')
                ->table('SIIA')
                ->select('*')
                ->where('NUMERO_CONTORL', $numero_control)
                ->get()
                ->first();*/

        // CUANDO SE CONECTA CON EL SIIA
        return DB::connection('sqlsrv2')
            ->table('view_docentes')
            ->where('Idusuario', $numero_control)
            ->get()
            ->first();
    }
}
