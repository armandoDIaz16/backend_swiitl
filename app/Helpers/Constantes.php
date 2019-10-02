<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Class Constantes
 * @package App\Helpers
 */
class Constantes
{

    CONST GRUPO_TUTORIA_INICIAL     = 1;
    CONST GRUPO_TUTORIA_SEGUIMIENTO = 2;

    /**
     * @return int
     */
    public static function get_periodo()
    {
        return (date('m') > 6) ? date('Y') . '2' : date('Y') . '1';
    }

    /**
     * @return int
     */
    public static function get_periodo_texto()
    {
        return (date('m') > 6)
            ? 'Enero - Julio ' . date('Y')
            : 'Agosto - Diciembre ' . date('Y');
    }

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

}
