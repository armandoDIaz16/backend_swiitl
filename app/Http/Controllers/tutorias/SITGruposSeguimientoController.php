<?php

namespace App\Http\Controllers\tutorias;

use App\AreaAcademica;
use App\AreaAcademicaCarrera;
use App\Carrera;
use App\CoordinadorDepartamentalTutoria;
use App\GrupoTutoriasDetalle;
use App\Helpers\Abreviaturas;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Helpers\UsuariosHelper;
use App\Http\Controllers\Controller;
use App\GrupoTutorias;
use App\Helpers\SiiaHelper;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SITGruposController
 * @package App\Http\Controllers\tutorias
 */
class SITGruposSeguimientoController extends Controller
{

    public function get_historico_grupos_admin(Request $request)
    {
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);

        if ($usuario) {
            $grupos_tutor = GrupoTutorias::where('FK_USUARIO', $usuario->PK_USUARIO)
                ->orderBy('PERIODO', 'DESC')
                ->get();
            $grupos = [];
            foreach ($grupos_tutor as $grupo) {
                $carrera = Carrera::where('PK_CARRERA', $grupo->FK_CARRERA)->first();

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

    public function get_grupos_coordinador_departamental(Request $request)
    {
        // buscar usuario
        $usuario = UsuariosHelper::get_usuario($request->pk_encriptada);
        if ($usuario) {
            // si el usuario existe
            // buscar áreas que coordina
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
     * @param $id_grupo
     * @return \Illuminate\Http\JsonResponse
     */
    public function detalle_grupo($id_grupo)
    {
        if ($id_grupo) {
            // consulto el grupo
            $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $id_grupo)->first();

            $condiciones_siia = [
                'CLAVE_GRUPO' => $grupo->CLAVE,
                'PERIODO' => Constantes::get_periodo(),
                'CLAVE_MATERIA' => 'PDH'
            ];

            $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

            $data[] = [
                'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                'FK_USUARIO' => $grupo->FK_USUARIO,
                'CLAVE' => $grupo->CLAVE,
                'AULA' => $horario_grupo[0]->Aula,
                'HORARIO' => $horario_grupo,
                'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
                'EVALUACION_GRUPO' => $grupo->EVALUACION,
                'LISTA_ALUMNOS' => $this->get_lista_grupo(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
                'PRIMER_NIVEL' => 1, // response.PRIMER_NIVEL
                'SEGUNDO_NIVEL' => [// response.SEGUNDO_NIVEL.PRIMER_NIVEL -> VALOR
                    'PRIMER_NIVEL' => [

                    ]
                ]
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
     * @param null $estado_encuesta
     * @param null $grupo
     * @param null $alumno
     * @return array
     */
    private function get_encuestas_grupo($estado_encuesta = null, $grupo = NULL, $alumno = NULL)
    {
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
            TR_APLICACION_ENCUESTA.PERIODO = '" . Constantes::get_periodo() . "'";

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

    /*
     * FUNCIONES IMPLEMENTADAS Y PROBADAS
     * */

    public function elimina_grupo_seguimiento($id)
    {
        // eliminar el grupo
        $grupo = GrupoTutorias::find($id);
        if ($grupo) {
            $grupo->borrado = Constantes::BORRADO_SI;
            $grupo->estado = Constantes::ESTADO_INACTIVO;

            // eliminar a todos los alumnos dados de alta en el grupo
            GrupoTutoriasDetalle::where('PK_GRUPO_TUTORIA_DETALLE', $grupo->PK_GRUPO_TUTORIA)->delete();

            ($grupo->save())
                ? ResponseHTTP::response_ok($grupo)
                : ResponseHTTP::response_error('Error al guardar');
        } else {
            ResponseHTTP::response_error('No se encontraron los datos');
        }
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function actualiza_grupo(Request $request, $id)
    {
        $grupo = GrupoTutorias::find($id);
        if ($grupo) {
            $grupo->FK_CARRERA = $request->carrera;
            $grupo->FK_USUARIO = $request->tutor;
            $grupo->CLAVE = $request->clave_grupo;

            ($grupo->save())
                ? ResponseHTTP::response_ok($grupo)
                : ResponseHTTP::response_error('Error al guardar');
        } else {
            ResponseHTTP::response_error('No se encontraron los datos');
        }
    }

    /**
     * @param Request $request
     */
    public function guarda_grupo_seguimiento(Request $request)
    {
        // CREAR GRUPO
        $grupo = new GrupoTutorias;

        $grupo->FK_CARRERA = $request->carrera;
        $grupo->FK_USUARIO = $request->tutor;
        $grupo->PERIODO = Constantes::get_periodo();
        $grupo->CLAVE = $request->clave_grupo;
        $grupo->TIPO_GRUPO = Constantes::GRUPO_TUTORIA_SEGUIMIENTO;

        if ($grupo->save()) {
            if (!UsuariosHelper::rol_usuario($request->tutor, Abreviaturas::TUTORIA_ROL_TUTOR, TRUE)) {
                error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                error_log('PK_USUARIO: ' . $request->tutor);
                error_log('ROL: ' . Abreviaturas::TUTORIA_ROL_TUTOR);
            }
            ResponseHTTP::response_ok($grupo);
        } else {
            ResponseHTTP::response_error('No se pudo registrar el grupo');
        }
    }

    /**
     * @param $id_tutor
     * @return object
     */
    public function get_grupo_seguimiento(Request $request)
    {
        if ($request->pk_grupo) {
            $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $request->pk_grupo)->first();

            $carrera = Carrera::where('PK_CARRERA', $grupo->FK_CARRERA)->first();

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

            $tutor = Usuario::find($grupo->FK_USUARIO);

            $grupo_array = [
                'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                'FK_USUARIO' => $grupo->FK_USUARIO,
                'TUTOR' => $tutor->NOMBRE . ' ' .
                    $tutor->PRIMER_APELLIDO . ' ' .
                    $tutor->SEGUNDO_APELLIDO,
                'CANTIDAD_ALUMNOS' =>
                    GrupoTutoriasDetalle::where('FK_GRUPO', $grupo->PK_GRUPO)->count(),
                'ENCUESTAS_ACTIVAS' => $encuestas_activas,
                'CLAVE' => $grupo->CLAVE,
                'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                'EVALUACION_GRUPO' => $grupo->EVALUACION,
                'PK_CARRERA' => $carrera->PK_CARRERA,
                'CARRERA' => $carrera->NOMBRE,
                'TIPO_GRUPO' => ($grupo->TIPO_GRUPO == Constantes::GRUPO_TUTORIA_SEGUIMIENTO)
                    ? 'Tutoría inicial'
                    : 'Tutoría seguimiento',
                'PERIODO' => $grupo->PERIODO,
                'TEXTO_PERIODO' => Constantes::get_periodo_texto($grupo->PERIODO),
            ];

            return ResponseHTTP::response_ok($grupo_array);
        } else {
            return ResponseHTTP::response_error('Datos enviados de forma errónea');
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
                    foreach ($carreras_area as $carrera_area) {
                        $carrera = Carrera::where('PK_CARRERA', $carrera_area->FK_CARRERA)->first();
                        // buscar grupos de cada carrera
                        $grupos_por_carrera = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                            ->where("FK_CARRERA", $carrera->PK_CARRERA)
                            ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_SEGUIMIENTO)
                            ->where('BORRADO', Constantes::BORRADO_NO)
                            ->where('BORRADO', Constantes::BORRADO_NO)
                            ->where('ESTADO', Constantes::ESTADO_ACTIVO)
                            ->get();

                        $grupos = [];
                        if ($grupos_por_carrera) {
                            foreach ($grupos_por_carrera as $grupo) {
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

                                $tutor = Usuario::find($grupo->FK_USUARIO);

                                $grupos[] = [
                                    'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
                                    'FK_USUARIO' => $grupo->FK_USUARIO,
                                    'TUTOR' => $tutor->NOMBRE . ' ' .
                                        $tutor->PRIMER_APELLIDO . ' ' .
                                        $tutor->SEGUNDO_APELLIDO,
                                    'CANTIDAD_ALUMNOS' =>
                                        GrupoTutoriasDetalle::where('FK_GRUPO', $grupo->PK_GRUPO)->count(),
                                    'ENCUESTAS_ACTIVAS' => $encuestas_activas,
                                    'CLAVE' => $grupo->CLAVE,
                                    'ENCUESTAS_CONTESTADAS' => $encuestas_respondidas,
                                    'EVALUACION_GRUPO' => $grupo->EVALUACION,
                                    'CARRERA' => $carrera->NOMBRE,
                                    'TIPO_GRUPO' => ($grupo->TIPO_GRUPO == Constantes::GRUPO_TUTORIA_SEGUIMIENTO)
                                        ? 'Tutoría inicial'
                                        : 'Tutoría seguimiento',
                                    'PERIODO' => $grupo->PERIODO,
                                    'TEXTO_PERIODO' => Constantes::get_periodo_texto($grupo->PERIODO),
                                ];
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

    /* DETALLES DE GRUPO */
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function agrega_alumno_grupo(Request $request)
    {
        // obtener usuario
        $usuario = UsuariosHelper::get_usuario($request->token_alumno);

        // buscar usuario en grupo
        $alumno_grupo = DB::table('TR_GRUPO_TUTORIA_DETALLE AS GD')
            ->leftJoin('TR_GRUPO_TUTORIA AS G', 'GD.FK_GRUPO', '=', 'G.PK_GRUPO_TUTORIA')
            ->select('GD.PK_GRUPO_TUTORIA_DETALLE')
            ->where('G.PERIODO', Constantes::get_periodo())
            ->where('GD.FK_USUARIO', $usuario->PK_USUARIO)
            ->first();

        if ($alumno_grupo) {
            $alumno_grupo = GrupoTutoriasDetalle::find($alumno_grupo->PK_GRUPO_TUTORIA_DETALLE);
            // eliminar usuario en grupo
            $alumno_grupo->delete();
        }

        // registrar nuevo usuario en grupo
        $alumno_grupo = new GrupoTutoriasDetalle;
        $alumno_grupo->FK_USUARIO = $usuario->PK_USUARIO;
        $alumno_grupo->FK_GRUPO = $request->pk_grupo;

        return ($alumno_grupo->save())
            ? ResponseHTTP::response_ok($alumno_grupo)
            : ResponseHTTP::response_error();
    }

    /**
     * @param $lista_alumnos
     * @return object
     */
    public function get_alumnos_grupo(Request $request)
    {
        if ($request->pk_grupo) {
            $lista = [];
            $grupo = GrupoTutorias::find($request->pk_grupo);
            $alumnos_grupo = GrupoTutoriasDetalle::where('FK_GRUPO', $request->pk_grupo)->get();
            $tutor = Usuario::find($grupo->FK_USUARIO);
            foreach ($alumnos_grupo as $alumno) {
                $usuario = Usuario::find($alumno->FK_USUARIO);
                $carrera = Carrera::find($usuario->FK_CARRERA);
                $lista[] = [
                    'PK_GRUPO_TUTORIA_DETALLE' => $alumno->PK_GRUPO_TUTORIA_DETALLE,
                    'PK_USUARIO' => $usuario->PK_USUARIO,
                    'PK_ENCRIPTADA' => $usuario->PK_ENCRIPTADA,
                    'NOMBRE' => $usuario->NOMBRE,
                    'PRIMER_APELLIDO' => $usuario->PRIMER_APELLIDO,
                    'SEGUNDO_APELLIDO' => $usuario->SEGUNDO_APELLIDO,
                    'CURP' => $usuario->CURP,
                    'NUMERO_CONTROL' => $usuario->NUMERO_CONTROL,
                    'SEMESTRE' => $usuario->SEMESTRE,
                    'FOTO_PERFIL' => $usuario->FOTO_PERFIL,
                    'PK_CARRERA' => $carrera->PK_CARRERA,
                    'CARRERA' => $carrera->NOMBRE,
                    'TUTOR' => $tutor->NOMBRE . ' ' . $tutor->PRIMER_APELLIDO . ' ' . $tutor->SEGUNDO_APELLIDO,
                ];
            }

            return ResponseHTTP::response_ok($lista);
        } else {
            return ResponseHTTP::response_error('Datos enviados de forma errónea');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function elimina_alumno_grupo($id)
    {
        $alumno_grupo = GrupoTutoriasDetalle::find($id);
        if ($alumno_grupo) {
            // eliminar usuario en grupo
            return ($alumno_grupo->delete())
                ? ResponseHTTP::response_ok([])
                : ResponseHTTP::response_error();
        } else {
            return ResponseHTTP::response_error();
        }
    }
}
