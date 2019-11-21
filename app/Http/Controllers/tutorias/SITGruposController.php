<?php

namespace App\Http\Controllers\tutorias;

use App\Carrera;
use App\Http\Controllers\Controller;
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
            $usuario = Usuario::where('NUMERO_CONTROL', trim($alumno->NumeroControl))->first();
            if (isset($usuario->PK_USUARIO)) {
                $lista[] = [
                    'PK_USUARIO'            => $usuario->PK_USUARIO,
                    'PK_ENCRIPTADA'         => $usuario->PK_ENCRIPTADA,
                    'NUMERO_CONTROL'        => $usuario->NUMERO_CONTROL,
                    'NOMBRE'                => $usuario->NOMBRE,
                    'PRIMER_APELLIDO'       => $usuario->PRIMER_APELLIDO,
                    'SEGUNDO_APELLIDO'      => $usuario->SEGUNDO_APELLIDO,
                    'SEMESTRE'              => $alumno->Semestre,
                    'CARRERA'               => $alumno->ClaveCarrera,
                    'PERFIL_COMPLETO'       => $usuario->PERFIL_COMPLETO,
                    'ENCUESTAS_ACTIVAS'     => $this->get_encuestas_grupo(
                        NULL,
                        NULL,
                        $usuario->PK_USUARIO
                    )[0]->CANTIDAD_ENCUESTAS,
                    'ENCUESTAS_CONTESTADAS' => $this->get_encuestas_grupo(
                        Constantes::ENCUESTA_RESPONDIDA,
                        NULL,
                        $usuario->PK_USUARIO
                    )[0]->CANTIDAD_ENCUESTAS
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

            $carreras = [];
            foreach ($grupos_tutor as $grupo) {
                $carreras[] = Carrera::where('PK_CARRERA', $grupo->FK_CARRERA)->first();
            }
            $carreras = array_unique($carreras);

            $grupos_carrera = [];
            foreach ($carreras as $carrera) {
                $grupos = [];
                foreach ($grupos_tutor as $grupo) {
                    $condiciones_siia = [
                        'CLAVE_GRUPO'   => $grupo->CLAVE,
                        'PERIODO'       => Constantes::get_periodo(),
                        'CLAVE_MATERIA' => 'PDH'
                    ];

                    $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

                    $encuestas_respondidas =
                        $this->get_encuestas_grupo(
                            Constantes::ENCUESTA_RESPONDIDA,
                            $grupo->PK_GRUPO_TUTORIA
                        )[0]->CANTIDAD_ENCUESTAS;

                    $encuestas_activas     =
                        $this->get_encuestas_grupo(
                            NULL,
                            $grupo->PK_GRUPO_TUTORIA
                        )[0]->CANTIDAD_ENCUESTAS;

                    $grupos[] = [
                        'PK_GRUPO_TUTORIA'      => $grupo->PK_GRUPO_TUTORIA,
                        'FK_USUARIO'            => $grupo->FK_USUARIO,
                        'CLAVE'                 => $grupo->CLAVE,
                        'AULA'                  => $horario_grupo[0]->Aula,
                        'HORARIO'               => $horario_grupo,
                        'CANTIDAD_ALUMNOS'      => count(SiiaHelper::get_lista_grupo($condiciones_siia)),
                        'ENCUESTAS_ACTIVAS'     => $encuestas_activas,
                        'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                        'EVALUACION_GRUPO'      => $grupo->EVALUACION
                    ];
                }

                $grupos_carrera[] = [
                    'PK_CARRERA' => $carrera->PK_CARRERA,
                    'CARRERA'    => $carrera->NOMBRE,
                    'GRUPOS'     => $grupos
                ];
            }

            return response()->json(
                ['data' => ['CARRERAS' => $grupos_carrera]],
                Response::HTTP_ACCEPTED
            );

        } else {
            return response()->json(
                ['error' => "No se han encontrado grupos"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    private function get_encuestas_grupo($estado_encuesta = null, $grupo = NULL, $alumno = NULL) {
        $sql = "
        SELECT
            COUNT(*) AS CANTIDAD_ENCUESTAS
        FROM
            TR_APLICACION_ENCUESTA
            LEFT JOIN TR_GRUPO_TUTORIA_DETALLE
                ON TR_GRUPO_TUTORIA_DETALLE.FK_USUARIO = TR_APLICACION_ENCUESTA.FK_USUARIO
            LEFT JOIN TR_GRUPO_TUTORIA
                ON TR_GRUPO_TUTORIA.PK_GRUPO_TUTORIA = TR_GRUPO_TUTORIA_DETALLE.FK_GRUPO
        WHERE 
            TR_APLICACION_ENCUESTA.PERIODO = '" . Constantes::get_periodo() ."' ";

        if ($estado_encuesta) {
            $sql .= " AND TR_APLICACION_ENCUESTA.ESTADO = $estado_encuesta ";
        }

        if ($grupo) {
            $sql .= " AND TR_GRUPO_TUTORIA.PK_GRUPO_TUTORIA = $grupo ";
        }

        if ($alumno) {
            $sql .= " AND TR_GRUPO_TUTORIA_DETALLE.FK_USUARIO = $alumno ";
        }

        return DB::select($sql);
    }
}
