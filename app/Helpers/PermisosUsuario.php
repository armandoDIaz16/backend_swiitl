<?php

namespace App\Helpers;

/**
 * Class PermisosUsuario
 * @package App\Helpers
 */
class PermisosUsuario {

    /**
     * @param $json_permisos
     * @param $sistema
     * @return mixed|null
     */
    public static function get_permisos_sistema($json_permisos, $sistema) {
        return (isset($json_permisos[$sistema]))
            ? $json_permisos[$sistema]
            : null;
    }

}
