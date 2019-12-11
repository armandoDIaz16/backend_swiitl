<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Class Constantes
 * @package App\Helpers
 */
class Constantes
{
    /**
     *
     */
    CONST USUARIO_ALUMNO    = 1;
    CONST USUARIO_DOCENTE   = 2;
    CONST USUARIO_ASPIRANTE = 3;

    /**
     *
     */
    CONST ESTADO_ACTIVO    = 1;
    CONST ESTADO_INACTIVO  = 0;

    /**
     *
     */
    CONST SEXO_MASCULINO = 1;
    CONST SEXO_FEMENINO  = 2;

    /**
     *
     */
    CONST ENCUESTA_PASATIEMPOS              = 1;
    CONST ENCUESTA_SALUD                    = 2;
    CONST ENCUESTA_CONDICION_SOCIOECONOMICA = 3;
    CONST ENCUESTA_CONDICION_ACADEMICA      = 4;
    CONST ENCUESTA_CONDICION_FAMILIAR       = 5;
    CONST ENCUESTA_HABITOS_DE_ESTUDIO       = 6;
    CONST ENCUESTA_EVALUACION_TUTOR_PRIMERO = 7;
    CONST ENCUESTA_16_PF                    = 8;

    /**
     *
     */
    CONST AMBIENTE = 1; // 0 LOCAL, 1 PRODUCCION

    /**
     *
     */
    CONST GRUPO_TUTORIA_INICIAL     = 1;
    CONST GRUPO_TUTORIA_SEGUIMIENTO = 2;

    /**
     * @return int
     */
    public static function get_periodo()
    {
        return (date('m') > 6) ? date('Y') . '2' : date('Y') . '1';
    }

    public static function get_periodo_anio_mes($anio, $mes) {
        return ($mes > 6) ? $anio.'2' : $anio.'1';
    }

    /**
     * @return int
     */
    public static function get_periodo_texto($periodo = null)
    {
        if ($periodo) {
            $anio    = substr($periodo, 0, strlen($periodo) - 1);
            $periodo = substr($periodo, strlen($periodo) - 1, strlen($periodo));
            return ($periodo == 1)
                ? 'Enero - Julio ' . $anio
                : 'Agosto - Diciembre ' . $anio;
        } else {
            return (date('m') > 6)
                ? 'Agosto - Diciembre ' . date('Y')
                : 'Enero - Julio ' . date('Y');
        }
    }

    /**
     *
     */
    CONST ENCUESTA_PENDIENTE  = 1;
    CONST ENCUESTA_RESPONDIDA = 2;

    /**
     * @param $sql
     * @param $bindings
     * @param $multi_result
     * @return array|bool
     */
    public static function procesa_consulta_general($sql, $multi_result = true) {
        $result = DB::connection()->select($sql);

        if ($result) {
            if ($multi_result) {
                return $result;
            } else {
                return $result[0];
            }
        } else {
            return false;
        }
    }

    /**
     * @param $fecha_nacimiento
     * @param null $fecha_actual
     * @return mixed
     */
    public static function calcula_edad($fecha_nacimiento, $fecha_actual = null) {
        $fecha_actual = ($fecha_actual) ? $fecha_actual : date('Y-m-d H:i:s');
        $fecha_nac = new \DateTime($fecha_nacimiento);
        $fecha_act = new \DateTime($fecha_actual);
        $diff = $fecha_act->diff($fecha_nac);

        // acceso a los años
        return $diff->y;
    }

}
