<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Hash;

/**
 * Class UsuariosHelper
 * @package App\Helpers
 */
class EncriptarUsuario {

    /**
     * @param $pk_usuario
     * @param $fecha_registro
     * @return string
     */

    public static function getPkEncriptada($pk_usuario, $fecha_registro) {
        $remplazo = array("\\", "/");
        return str_replace($remplazo,'',Hash::make($pk_usuario . $fecha_registro));
    }
}
