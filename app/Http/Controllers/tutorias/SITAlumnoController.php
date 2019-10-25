<?php

namespace App\Http\Controllers\tutorias;

use App\Http\Controllers\Controller;

use App\Carrera;
use App\Helpers\Constantes;
use App\Helpers\SiiaHelper;
use App\Usuario;
use Illuminate\Http\Request;
use Monolog\Handler\IFTTTHandler;
use Symfony\Component\HttpFoundation\Response;

class SITAlumnoController extends Controller
{

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

    public function get_horario($id_usuario) {
        //buscar numero de control
        $usuario = Usuario::where('PK_USUARIO', $id_usuario)->first();
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
