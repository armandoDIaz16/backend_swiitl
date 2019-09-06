<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Hash;

/**
 * Class UsuariosHelper
 * @package App\Helpers
 */
class UsuariosHelper {

    /**
     * @param $curp
     * @param $fecha
     * @return string
     */
    public static function get_token_contrasenia($curp, $fecha) {
        return Hash::make($curp . $fecha);
    }

    /**
     * @param int $longitud
     * @return bool|string
     */
    public static function get_clave_verificacion($longitud = 6) {
        return substr( md5(microtime()), 1, $longitud);
    }

}
