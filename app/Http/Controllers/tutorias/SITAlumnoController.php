<?php

namespace App\Http\Controllers\tutorias;

use App\Helpers\UsuariosHelper;
use App\Http\Controllers\Controller;

use App\Carrera;
use App\Helpers\Constantes;
use App\Helpers\SiiaHelper;
use App\Usuario;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SITAlumnoController
 * @package App\Http\Controllers\tutorias
 */
class SITAlumnoController extends Controller
{

    /**
     * @param Request $request
     */
    public function get_seguimiento(Request $request) {
        $alumno      = UsuariosHelper::get_usuario($request->pk_encriptada);
        $seguimiento = NULL;
        if ($alumno) {
            $carrera = Carrera::where('PK_CARRERA', $alumno->FK_CARRERA)->first();
            $seguimiento = SiiaHelper::get_seguimiento($alumno->NUMERO_CONTROL, $carrera->CLAVE_TECLEON);
        }

        return response()->json(
            $seguimiento,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @param NULL $pk_usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_alumno($pk_usuario = NULL) {
        if ($pk_usuario) {
            $usuario = Usuario::where('PK_USUARIO', $pk_usuario)->first();
            return response()->json(
                ['data' => $usuario],
                Response::HTTP_ACCEPTED
            );
        } else {
            return response()->json(
                ['error' => "No se han encontrado al estudiante"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param $id_usuario
     * @return array|bool|\Illuminate\Http\JsonResponse
     */
    public function get_horario($pk_encriptada) {
        //buscar numero de control
        $usuario = UsuariosHelper::get_usuario($pk_encriptada);
        if (isset($usuario->PK_USUARIO)) {
            $carrera = Carrera::where('PK_CARRERA', $usuario->FK_CARRERA)->first();
            $materias = [];
            //buscar materias
            $materias = SiiaHelper::get_materias_alumno([
                'NUMERO_CONTROL' => $usuario->NUMERO_CONTROL,
                'CLAVE_CARRERA'  => $carrera->ABREVIATURA,
                'PERIODO'        => Constantes::get_periodo()
            ]);

            //buscar horario por materia
            if ($materias) {
                foreach ($materias as $materia) {
                    $materia->PERIODO = Constantes::get_periodo_texto();
                    $horario = [
                        'LUNES'     => NULL,
                        'MARTES'    => NULL,
                        'MIERCOLES' => NULL,
                        'JUEVES'    => NULL,
                        'VIERNES'   => NULL,
                    ];
                    $horario_siia = SiiaHelper::get_horario_materia(
                        [
                            'NUMERO_CONTROL' => $usuario->NUMERO_CONTROL,
                            'CLAVE_CARRERA'  => $carrera->ABREVIATURA,
                            'PERIODO'        => Constantes::get_periodo(),
                            'CLAVE_MATERIA'  => $materia->ClaveMateria
                        ]
                    );

                    foreach ($horario_siia as $dia) {
                        if ($dia->Lunes) {
                            $horario['LUNES'] = $dia->Lunes;
                        }
                        if ($dia->Martes) {
                            $horario['MARTES'] = $dia->Martes;
                        }
                        if ($dia->Miercoles) {
                            $horario['MIERCOLES'] = $dia->Miercoles;
                        }
                        if ($dia->Jueves) {
                            $horario['JUEVES'] = $dia->Jueves;
                        }
                        if ($dia->Viernes) {
                            $horario['VIERNES'] = $dia->Viernes;
                        }
                    }

                    $materia->DIAS = $horario;
                }
            }

            $usuario->HORARIO = $materias;

            return response()->json(
                ['data' => $usuario],
                Response::HTTP_ACCEPTED
            );

            return $materias;

        } else {
            return response()->json(
                ['error' => "No se han encontrado al estudiante"],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
