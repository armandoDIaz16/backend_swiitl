<?php

namespace App\Http\Controllers\tutorias;

use App\AreaAcademicaCarrera;
use App\Carrera;
use App\CoordinadorDepartamentalTutoria;
use App\Helpers\Abreviaturas;
use App\Helpers\ResponseHTTP;
use App\Helpers\UsuariosHelper;
use App\Http\Controllers\Controller;
use App\GrupoTutorias;
use App\Helpers\Constantes;
use App\Helpers\SiiaHelper;
use App\Usuario;
use Illuminate\Http\Request;

/**
 * Class SITGruposController
 * @package App\Http\Controllers\tutorias
 */
class GruposInicialController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->token && $request->rol) {
            $usuario = UsuariosHelper::get_usuario($request->token);
            if ($usuario) {
                return ResponseHTTP::response_ok($this->get_grupos_rol($request->rol, $usuario));
            } else {
                return ResponseHTTP::response_error('Parámetros incorrectos');
            }
        } else {
            return ResponseHTTP::response_error('Parámetros incorrectos');
        }
    }

    public function detalle_grupo(Request $request) {
        if ($request->grupo) {
            $grupo = GrupoTutorias::find($request->grupo);
            if ($grupo) {
                return ResponseHTTP::response_ok($this->get_datos_grupo_alumnos($grupo));
            } else {
                return ResponseHTTP::response_error();
            }
        } else {
            return ResponseHTTP::response_error();
        }
    }

    /**
     * @param $rol
     * @param Usuario $usuario
     * @return array
     */
    private function get_grupos_rol($rol, Usuario $usuario)
    {
        switch ($rol) {
            case Abreviaturas::TUTORIA_ROL_ADMINISTRADOR:
                $grupos = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                    ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                    ->leftJoin('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=', 'FK_CARRERA')
                    ->get();
                return $this->agrupar_grupos_por_carrera($grupos);

            case Abreviaturas::TUTORIA_ROL_COORDINADOR_INS:
                $grupos = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                    ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                    ->leftJoin('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=', 'FK_CARRERA')
                    ->get();
                return $this->agrupar_grupos_por_carrera($grupos);

            case Abreviaturas::TUTORIA_ROL_COORDINADOR_DEP:
                $areas_coordina = CoordinadorDepartamentalTutoria::where('FK_USUARIO', $usuario->PK_USUARIO)->get();
                $area_carrera = AreaAcademicaCarrera::where('BORRADO', Constantes::BORRADO_NO);
                foreach ($areas_coordina as $area_coordina) {
                    $area_carrera->where('FK_AREA_ACADEMICA', $area_coordina->FK_AREA_ACADEMICA);
                }
                $area_carrera = $area_carrera->get();

                $grupos = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                    ->leftJoin('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=', 'FK_CARRERA')
                    ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL);
                foreach ($area_carrera as $area) {
                    $grupos->where('FK_CARRERA', $area->FK_CARRERA);
                }
                return $this->agrupar_grupos_por_carrera($grupos->get());

            case Abreviaturas::TUTORIA_ROL_TUTOR:
                $grupos = GrupoTutorias::where('PERIODO', Constantes::get_periodo())
                    ->leftJoin('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=', 'FK_CARRERA')
                    ->where('TIPO_GRUPO', Constantes::GRUPO_TUTORIA_INICIAL)
                    ->where('FK_USUARIO', $usuario->PK_USUARIO)
                    ->get();
                return $this->agrupar_grupos_por_carrera($grupos);
        }
    }

    private function agrupar_grupos_por_carrera($grupos)
    {
        $lista_grupos = [];
        $carreras = [];
        foreach ($grupos as $grupo) {
            $carreras[] = Carrera::find($grupo->FK_CARRERA);
        }
        $carreras = array_unique($carreras);

        foreach ($carreras as $carrera) {
            $array_grupos = [];

            foreach ($grupos as $grupo) {
                if ($grupo->FK_CARRERA == $carrera->PK_CARRERA) {
                    // se agrega la carrera al grupo
                    $array_grupos[] = $this->get_datos_grupo($grupo);
                }
            }
            $lista_grupos[] = [
                'carrera' => $carrera->NOMBRE,
                'grupos' => $array_grupos
            ];
        }

        return $lista_grupos;
    }

    private function get_datos_grupo($grupo)
    {
        $condiciones_siia = [
            'CLAVE_GRUPO' => $grupo->CLAVE,
            'PERIODO' => Constantes::get_periodo(),
            'CLAVE_MATERIA' => 'PDH'
        ];

        $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

        $usuario = UsuariosHelper::get_usuario_pk($grupo->FK_USUARIO);
        $tutor = 'N/A';
        if ($usuario) {
            $tutor = $usuario->NOMBRE .' '. $usuario->PRIMER_APELLIDO .' '. $usuario->SEGUNDO_APELLIDO;
        }

        return [
            'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
            'FK_USUARIO' => $grupo->FK_USUARIO,
            'TUTOR' => $tutor,
            'CLAVE' => $grupo->CLAVE,
            'AULA' => $horario_grupo[0]->Aula,
            'HORARIO' => $horario_grupo,
            'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
            'ENCUESTAS_ACTIVAS' => $this->get_encuestas_grupo(
                Constantes::ENCUESTA_PENDIENTE,
                $grupo->PK_GRUPO_TUTORIA
            )[0]->CANTIDAD_ENCUESTAS,
            'ENCUESTAS_CONTESTADAS' => $this->get_encuestas_grupo(
                Constantes::ENCUESTA_RESPONDIDA,
                $grupo->PK_GRUPO_TUTORIA
            )[0]->CANTIDAD_ENCUESTAS,
            'EVALUACION_GRUPO' => $grupo->EVALUACION
        ];
    }

    private function get_datos_grupo_alumnos($grupo)
    {
        $condiciones_siia = [
            'CLAVE_GRUPO' => $grupo->CLAVE,
            'PERIODO' => Constantes::get_periodo(),
            'CLAVE_MATERIA' => 'PDH'
        ];

        $horario_grupo = SiiaHelper::get_horario_grupo($condiciones_siia);

        $usuario = UsuariosHelper::get_usuario_pk($grupo->FK_USUARIO);
        $tutor = 'N/A';
        if ($usuario) {
            $tutor = $usuario->NOMBRE .' '. $usuario->PRIMER_APELLIDO .' '. $usuario->SEGUNDO_APELLIDO;
        }

        return [
            'PK_GRUPO_TUTORIA' => $grupo->PK_GRUPO_TUTORIA,
            'FK_USUARIO' => $grupo->FK_USUARIO,
            'TUTOR' => $tutor,
            'CLAVE' => $grupo->CLAVE,
            'AULA' => $horario_grupo[0]->Aula,
            'HORARIO' => $horario_grupo,
            'CANTIDAD_ALUMNOS' => count(SiiaHelper::get_lista_grupo_siia($condiciones_siia)),
            'ENCUESTAS_ACTIVAS' => $this->get_encuestas_grupo(
                Constantes::ENCUESTA_PENDIENTE,
                $grupo->PK_GRUPO_TUTORIA
            )[0]->CANTIDAD_ENCUESTAS,
            'ENCUESTAS_CONTESTADAS' => $this->get_encuestas_grupo(
                Constantes::ENCUESTA_RESPONDIDA,
                $grupo->PK_GRUPO_TUTORIA
            )[0]->CANTIDAD_ENCUESTAS,
            'EVALUACION_GRUPO' => $grupo->EVALUACION,
            'LISTA_ALUMNOS' => $this->get_lista_grupo(SiiaHelper::get_lista_grupo_siia($condiciones_siia))
        ];
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
            TR_APLICACION_ENCUESTA_DETALLE
            LEFT JOIN TR_APLICACION_ENCUESTA
                ON TR_APLICACION_ENCUESTA.PK_APLICACION = TR_APLICACION_ENCUESTA_DETALLE.FK_APLICACION_ENCUESTA
            LEFT JOIN TR_GRUPO_TUTORIA_DETALLE
                ON TR_GRUPO_TUTORIA_DETALLE.FK_USUARIO = TR_APLICACION_ENCUESTA_DETALLE.FK_USUARIO
            LEFT JOIN TR_GRUPO_TUTORIA
                ON TR_GRUPO_TUTORIA.PK_GRUPO_TUTORIA = TR_GRUPO_TUTORIA_DETALLE.FK_GRUPO
        WHERE
            TR_APLICACION_ENCUESTA.PERIODO = '" . Constantes::get_periodo() . "'";

        if ($estado_encuesta) {
            $sql .= " AND TR_APLICACION_ENCUESTA_DETALLE.ESTADO = $estado_encuesta ";
        }

        if ($grupo) {
            $sql .= " AND TR_GRUPO_TUTORIA.PK_GRUPO_TUTORIA = $grupo ";
        }

        if ($alumno) {
            $sql .= " AND TR_GRUPO_TUTORIA_DETALLE.FK_USUARIO = $alumno ";
        }

        return Constantes::procesa_consulta_general($sql);
    }
}
