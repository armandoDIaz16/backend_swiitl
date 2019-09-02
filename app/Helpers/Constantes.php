<?php

namespace App\Helpers;

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

}
