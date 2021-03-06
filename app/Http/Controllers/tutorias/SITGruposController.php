<?php

namespace App\Http\Controllers\tutorias;

use App\AreaAcademica;
use App\AreaAcademicaCarrera;
use App\Carrera;
use App\CoordinadorDepartamentalTutoria;
use App\Helpers\Abreviaturas;
use App\Helpers\PermisosUsuario;
use App\Helpers\ResponseHTTP;
use App\Helpers\UsuariosHelper;
use App\Http\Controllers\Controller;
use App\GrupoTutorias;
use App\Helpers\Constantes;
use App\Helpers\SiiaHelper;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SITGruposController
 * @package App\Http\Controllers\tutorias
 */
class SITGruposController extends Controller
{
    /**
     * @param $id_grupo
     * @return \Illuminate\Http\JsonResponse
     */
    public function detalle_grupo($id_grupo)
    {
        if ($id_grupo) {
            $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $id_grupo)->first();

            $condiciones_siia = [
                'CLAVE_GRUPO' => $grupo->CLAVE,
                'PERIODO' => Constantes::get_periodo(),
                'CLAVE_MATERIA' => 'PDH'
            ];

            $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

            $encuestas_respondidas =
                $this->get_encuestas_grupo(
                    Constantes::ENCUESTA_RESPONDIDA,
                    $grupo->PK_GRUPO_TUTORIA
                )[0]->CANTIDAD_ENCUESTAS;

            $encuestas_activas =
                $this->get_encuestas_grupo(
                    Constantes::ENCUESTA_PENDIENTE,
                    $grupo->PK_GRUPO_TUTORIA
                )[0]->CANTIDAD_ENCUESTAS;

            $data[] = [
                'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                'FK_USUARIO' => $grupo->FK_USUARIO,
                'CLAVE' => $grupo->CLAVE,
                'AULA' => $horario_grupo[0]->Aula,
                'HORARIO' => $horario_grupo,
                'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
                'ENCUESTAS_ACTIVAS' => $encuestas_activas,
                'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                'EVALUACION_GRUPO' => $grupo->EVALUACION,
                'LISTA_ALUMNOS' => $this->get_lista_grupo(SiiaHelper::get_lista_grupo_siia($condiciones_siia))
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

    /**
     * @param $lista_alumnos
     * @return array
     */
    private function get_lista_grupo($lista_alumnos)
    {
        $lista = [];
        foreach ($lista_alumnos as $alumno) {
            $usuario = Usuario::where('NUMERO_CONTROL', trim($alumno->NumeroControl))->first();
            if (isset($usuario->PK_USUARIO)) {
                $lista[] = [
                    'PK_USUARIO' => $usuario->PK_USUARIO,
                    'PK_ENCRIPTADA' => $usuario->PK_ENCRIPTADA,
                    'NUMERO_CONTROL' => $usuario->NUMERO_CONTROL,
                    'NOMBRE' => $usuario->NOMBRE,
                    'PRIMER_APELLIDO' => $usuario->PRIMER_APELLIDO,
                    'SEGUNDO_APELLIDO' => $usuario->SEGUNDO_APELLIDO,
                    'SEMESTRE' => $alumno->Semestre,
                    'CARRERA' => $alumno->ClaveCarrera,
                    'PERFIL_COMPLETO' => $usuario->PERFIL_COMPLETO,
                    'ENCUESTAS_ACTIVAS' => $this->get_encuestas_grupo(
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

    /**
     * @param $id_tutor
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_grupos(Request $request)
    {
        $permisos = PermisosUsuario::get_permisos_sistema($request->permisos, 'tutorias');
        if ($permisos) {
            $usuario = UsuariosHelper::get_usuario($request->permisos['pk_encriptada']);
            if ($usuario) {
                $grupos_tutor = $this->filtra_grupos($permisos);
                $carreras = [];
                foreach ($grupos_tutor as $grupo) {
                    $carreras[] = Carrera::where('PK_CARRERA', $grupo->FK_CARRERA)->first();
                }
                $carreras = array_unique($carreras);
                $grupos_carrera = [];
                foreach ($carreras as $carrera) {
                    $grupos = [];
                    $grupos_tutor = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                        ->whereRaw("FK_CARRERA IN ($carrera->PK_CARRERA)")
                        ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL);

                    if ($permisos['tutor']) {
                        $grupos_tutor->where('PK_GRUPO_TUTORIA', $permisos['pk_grupo']);
                    }

                    $grupos_tutor = $grupos_tutor->get();
                    foreach ($grupos_tutor as $grupo) {
                        $condiciones_siia = [
                            'CLAVE_GRUPO' => $grupo->CLAVE,
                            'PERIODO' => Constantes::get_periodo(),
                            'CLAVE_MATERIA' => 'PDH'
                        ];

                        $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

                        $encuestas_respondidas =
                            $this->get_encuestas_grupo(
                                Constantes::ENCUESTA_RESPONDIDA,
                                $grupo->PK_GRUPO_TUTORIA
                            )[0]->CANTIDAD_ENCUESTAS;

                        $encuestas_activas =
                            $this->get_encuestas_grupo(
                                Constantes::ENCUESTA_PENDIENTE,
                                $grupo->PK_GRUPO_TUTORIA
                            )[0]->CANTIDAD_ENCUESTAS;

                        $grupos[] = [
                            'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                            'FK_USUARIO' => $grupo->FK_USUARIO,
                            'CLAVE' => $grupo->CLAVE,
                            'AULA' => $horario_grupo[0]->Aula,
                            'HORARIO' => $horario_grupo,
                            'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
                            'ENCUESTAS_ACTIVAS' => $encuestas_activas,
                            'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                            'EVALUACION_GRUPO' => $grupo->EVALUACION
                        ];
                    }

                    $grupos_carrera[] = [
                        'PK_CARRERA' => $carrera->PK_CARRERA,
                        'CARRERA' => $carrera->NOMBRE,
                        'GRUPOS' => $grupos
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
        } else {
            return response()->json(
                ['error' => "No tiene permisos de acceso"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function get_historico_grupos_tutor(Request $request)
    {
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);

        if ($usuario) {
            $grupos_tutor = GrupoTutorias::where('FK_USUARIO', $usuario->PK_USUARIO)
                ->orderBy('PERIODO', 'DESC')
                ->get();
            $grupos = [];
            foreach ($grupos_tutor as $grupo) {
                $carrera = Carrera::where('PK_CARRERA', $grupo->FK_CARRERA)->first();
                $condiciones_siia = [
                    'CLAVE_GRUPO' => $grupo->CLAVE,
                    'PERIODO' => $grupo->PERIODO,
                    'CLAVE_MATERIA' => 'PDH'
                ];

                $encuestas_respondidas =
                    $this->get_encuestas_grupo(
                        Constantes::ENCUESTA_RESPONDIDA,
                        $grupo->PK_GRUPO_TUTORIA
                    )[0]->CANTIDAD_ENCUESTAS;

                $encuestas_activas =
                    $this->get_encuestas_grupo(
                        Constantes::ENCUESTA_PENDIENTE,
                        $grupo->PK_GRUPO_TUTORIA
                    )[0]->CANTIDAD_ENCUESTAS;

                $grupos[] = [
                    'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                    'FK_USUARIO' => $grupo->FK_USUARIO,
                    'CLAVE' => $grupo->CLAVE,
                    'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
                    'ENCUESTAS_ACTIVAS' => $encuestas_activas,
                    'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                    'EVALUACION_GRUPO' => $grupo->EVALUACION,
                    'CARRERA' => $carrera->NOMBRE,
                    'TIPO_GRUPO' => ($grupo->TIPO_GRUPO == 1) ? 'Tutor??a inicial' : 'Tutor??a seguimiento',
                    'PERIODO' => $grupo->PERIODO,
                    'TEXTO_PERIODO' => Constantes::get_periodo_texto($grupo->PERIODO),
                ];
            }

            return response()->json(
                ['data' => $grupos],
                Response::HTTP_ACCEPTED
            );
        } else {
            return response()->json(
                ['error' => "No se han encontrado grupos"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function get_grupos_coordinador_departamental(Request $request) {
        // buscar usuario
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);
        if ($usuario) {
            // si el usuario existe
            // buscar ??reas que coordina
            $areas_coordinador = CoordinadorDepartamentalTutoria::where('FK_USUARIO', $usuario->PK_USUARIO)
                ->where('ESTADO', Constantes::ESTADO_ACTIVO)
                ->get();
            $grupos = [];
            $grupos_carrera = [];
            if ($areas_coordinador) {
                foreach ($areas_coordinador as $area) {
                    $carreras_area = AreaAcademicaCarrera::where('FK_AREA_ACADEMICA', $area->FK_AREA_ACADEMICA)->get();
                    foreach ($carreras_area as $carrera_area) {
                        $carrera = Carrera::where('PK_CARRERA', $carrera_area->FK_CARRERA)->first();
                        // buscar grupos de cada carrera
                        $grupos_carrera = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                            ->where("FK_CARRERA",  $carrera->PK_CARRERA)
                            ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                            ->get();

                        foreach ($grupos_carrera as $grupo) {
                            $condiciones_siia = [
                                'CLAVE_GRUPO' => $grupo->CLAVE,
                                'PERIODO' => $grupo->PERIODO,
                                'CLAVE_MATERIA' => 'PDH'
                            ];

                            $encuestas_respondidas =
                                $this->get_encuestas_grupo(
                                    Constantes::ENCUESTA_RESPONDIDA,
                                    $grupo->PK_GRUPO_TUTORIA
                                )[0]->CANTIDAD_ENCUESTAS;

                            $encuestas_activas =
                                $this->get_encuestas_grupo(
                                    Constantes::ENCUESTA_PENDIENTE,
                                    $grupo->PK_GRUPO_TUTORIA
                                )[0]->CANTIDAD_ENCUESTAS;

                            $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

                            $grupos[] = [
                                'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                                'FK_USUARIO' => $grupo->FK_USUARIO,
                                'CLAVE' => $grupo->CLAVE,
                                'AULA' => $horario_grupo[0]->Aula,
                                'HORARIO' => $horario_grupo,
                                'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
                                'ENCUESTAS_ACTIVAS' => $encuestas_activas,
                                'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                                'EVALUACION_GRUPO' => $grupo->EVALUACION,
                                'CARRERA' => $carrera->NOMBRE,
                                'TIPO_GRUPO' => ($grupo->TIPO_GRUPO == 1) ? 'Tutor??a inicial' : 'Tutor??a seguimiento',
                                'PERIODO' => $grupo->PERIODO,
                                'TEXTO_PERIODO' => Constantes::get_periodo_texto($grupo->PERIODO),
                            ];
                        }
                    }
                    $grupos_carrera[] = [
                        'PK_CARRERA' => $carrera->PK_CARRERA,
                        'CARRERA' => $carrera->NOMBRE,
                        'GRUPOS' => $grupos
                    ];
                }

                return response()->json(
                    ['CARRERAS' => $grupos_carrera],
                    Response::HTTP_ACCEPTED
                );
            } else {
                return response()->json(
                    ['error' => "No se han encontrado grupos"],
                    Response::HTTP_NOT_FOUND
                );
            }
        } else {
            return response()->json(
                ['error' => "No se han encontrado grupos"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param $id_tutor
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_grupos_admin(Request $request)
    {
        // buscar usuario
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);
        if ($usuario) {
            // si el usuario existe
            $areas_academicas = AreaAcademica::all();
            $grupos_carrera = [];
            if ($areas_academicas) {
                foreach ($areas_academicas as $area) {
                    $carreras_area = AreaAcademicaCarrera::where('FK_AREA_ACADEMICA', $area->PK_AREA_ACADEMICA)->get();
                    $grupos = [];
                    foreach ($carreras_area as $carrera_area) {
                        $carrera = Carrera::where('PK_CARRERA', $carrera_area->FK_CARRERA)->first();
                        // buscar grupos de cada carrera
                        $grupos_por_carrera = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                            ->where("FK_CARRERA",  $carrera->PK_CARRERA)
                            ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                            ->get();

                        if ($grupos_por_carrera) {
                            foreach ($grupos_por_carrera as $grupo) {
                                $condiciones_siia = [
                                    'CLAVE_GRUPO' => $grupo->CLAVE,
                                    'PERIODO' => $grupo->PERIODO,
                                    'CLAVE_MATERIA' => 'PDH'
                                ];

                                $encuestas_respondidas =
                                    $this->get_encuestas_grupo(
                                        Constantes::ENCUESTA_RESPONDIDA,
                                        $grupo->PK_GRUPO_TUTORIA
                                    )[0]->CANTIDAD_ENCUESTAS;

                                $encuestas_activas =
                                    $this->get_encuestas_grupo(
                                        Constantes::ENCUESTA_PENDIENTE,
                                        $grupo->PK_GRUPO_TUTORIA
                                    )[0]->CANTIDAD_ENCUESTAS;

                                $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

                                $grupos[] = [
                                    'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                                    'FK_USUARIO' => $grupo->FK_USUARIO,
                                    'CLAVE' => $grupo->CLAVE,
                                    'AULA' => $horario_grupo[0]->Aula,
                                    'HORARIO' => $horario_grupo,
                                    'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
                                    'ENCUESTAS_ACTIVAS' => $encuestas_activas,
                                    'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                                    'EVALUACION_GRUPO' => $grupo->EVALUACION,
                                    'CARRERA' => $carrera->NOMBRE,
                                    'TIPO_GRUPO' => ($grupo->TIPO_GRUPO == 1) ? 'Tutor??a inicial' : 'Tutor??a seguimiento',
                                    'PERIODO' => $grupo->PERIODO,
                                    'TEXTO_PERIODO' => Constantes::get_periodo_texto($grupo->PERIODO),
                                ];
                            }
                        }
                    }
                    if ($grupos) {
                        $grupos_carrera[] = [
                            'PK_CARRERA' => $carrera->PK_CARRERA,
                            'CARRERA' => $carrera->NOMBRE,
                            'GRUPOS' => $grupos
                        ];
                    }
                }

                return response()->json(
                    ['CARRERAS' => $grupos_carrera],
                    Response::HTTP_ACCEPTED
                );
            } else {
                return response()->json(
                    ['error' => "No se han encontrado grupos"],
                    Response::HTTP_NOT_FOUND
                );
            }
        } else {
            return response()->json(
                ['error' => "No se han encontrado grupos"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    private function filtra_grupos($permisos)
    {
        if ($permisos['administrador'] || $permisos['coord_institucional']) {
            return GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                ->get();
        }

        if ($permisos['coord_departamental']) {
            $areas = implode(",", $permisos['departamentos']);

            $carreras = AreaAcademicaCarrera::whereRaw("FK_AREA_ACADEMICA IN ($areas)")->get();
            $lista_carreras = [];
            foreach ($carreras as $carrera) {
                $lista_carreras[] = $carrera->FK_CARRERA;
            }

            $lista_carreras = array_unique($lista_carreras);
            $lista_carreras = implode(",", $lista_carreras);

            return GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                ->whereRaw("FK_CARRERA IN ($lista_carreras)")
                ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                ->get();
        }

        if ($permisos['tutor']) {
            return GrupoTutorias::where('PK_GRUPO_TUTORIA', $permisos['pk_grupo'])
                ->where('PERIODO', Constantes::get_periodo())
                ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                ->get();
        }
    }
}
