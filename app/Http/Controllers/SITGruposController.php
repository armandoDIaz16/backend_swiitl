<?php

namespace App\Http\Controllers;

use App\GrupoTutorias;
use App\Helpers\Constantes;
use App\Helpers\SiiaHelper;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SITGruposController extends Controller
{
    public function detalle_grupo($id_grupo) {
        if ($id_grupo) {
            $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $id_grupo)->first();

            $condiciones_siia = [
                'CLAVE_GRUPO'   => $grupo->CLAVE,
                'PERIODO'       => Constantes::get_periodo(),
                'CLAVE_MATERIA' => 'PDH'
            ];

            $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

            $data[] = [
                'PK_GRUPO_TUTORIA'      => $grupo->PK_GRUPO_TUTORIA,
                'FK_USUARIO'            => $grupo->FK_USUARIO,
                'CLAVE'                 => $grupo->CLAVE,
                'AULA'                  => $horario_grupo[0]->Aula,
                'HORARIO'               => $horario_grupo,
                'CANTIDAD_ALUMNOS'      => count(SiiaHelper::get_lista_grupo($condiciones_siia)),
                'ENCUESTAS_ACTIVAS'     => 20,
                'ENCUESTAS_CONTESTADAS' => 17,
                'EVALUACION_GRUPO'      => $grupo->EVALUACION,
                'LISTA_ALUMNOS'         => $this->get_lista_grupo(SiiaHelper::get_lista_grupo($condiciones_siia))
            ];

            return response()->json(
                ['data' => ['GRUPOS' => $data]],
                Response::HTTP_ACCEPTED
            );

        } else {
            return response()->json(
                ['error' => "No se han encontrado grupos"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    private function get_lista_grupo($lista_alumnos) {
        $lista = [];
        foreach ($lista_alumnos as $alumno) {
            $usuario = Usuario::where('NUMERO_CONTROL', $alumno->NumeroControl)->first();
            if (isset($usuario->PK_USUARIO)) {
                $lista[] = [
                    'PK_USUARIO'       => $usuario->PK_USUARIO,
                    'NUMERO_CONTROL'   => $usuario->NUMERO_CONTROL,
                    'NOMBRE'           => $usuario->NOMBRE,
                    'PRIMER_APELLIDO'  => $usuario->PRIMER_APELLIDO,
                    'SEGUNDO_APELLIDO' => $usuario->SEGUNDO_APELLIDO,
                    'SEMESTRE'         => $alumno->Semestre,
                    'CARRERA'          => $alumno->ClaveCarrera
                ];
            }
        }

        return $lista;
    }

    public function get_grupos($id_tutor) {
        if ($id_tutor) {
            $grupos_tutor = GrupoTutorias::where('FK_USUARIO', $id_tutor)
                ->where('PERIODO', Constantes::get_periodo())
                ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                ->get();

            $data = [];
            foreach ($grupos_tutor as $grupo) {
                $condiciones_siia = [
                    'CLAVE_GRUPO'   => $grupo->CLAVE,
                    'PERIODO'       => Constantes::get_periodo(),
                    'CLAVE_MATERIA' => 'PDH'
                ];

                $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

                $data[] = [
                    'PK_GRUPO_TUTORIA'      => $grupo->PK_GRUPO_TUTORIA,
                    'FK_USUARIO'            => $grupo->FK_USUARIO,
                    'CLAVE'                 => $grupo->CLAVE,
                    'AULA'                  => $horario_grupo[0]->Aula,
                    'HORARIO'               => $horario_grupo,
                    'CANTIDAD_ALUMNOS'      => count(SiiaHelper::get_lista_grupo($condiciones_siia)),
                    'ENCUESTAS_ACTIVAS'     => 20,
                    'ENCUESTAS_CONTESTADAS' => 17,
                    'EVALUACION_GRUPO'      => $grupo->EVALUACION
                ];
            }

            return response()->json(
                ['data' => ['GRUPOS' => $data]],
                Response::HTTP_ACCEPTED
            );

        } else {
            return response()->json(
                ['error' => "No se han encontrado grupos"],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
