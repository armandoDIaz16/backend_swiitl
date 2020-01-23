<?php

namespace App\Helpers;

use App\User;
use App\Usuario;
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

    /**
     * @param $pk_encriptada
     * @return |null
     */
    public static function get_usuario($pk_encriptada) {
        if ($pk_encriptada) {
            $usuario = Usuario::where('PK_ENCRIPTADA', $pk_encriptada)->first();
            if ($usuario) {
                return $usuario;
            }
        }

        return null;
    }

    /**
     * @param $numero_control Debe ser numero de control, de siia o de ficha
     * @param $tipo_usuario   El tipo de usuario de la base de datos
     * @param $subirectorio   Directorio al que se desea acceder para guardar
     * @return null
     */
    public static function get_url_expediente_usuario($numero_control, $tipo_usuario, $subirectorio) {
        $url = null;

        switch ($tipo_usuario) {
            case 1:
                // el usuario es alumno
                $numero_control = mb_ereg_replace("[a-zA-Z]","", $numero_control);

                $anio =
                    substr(date('Y'), 0,2)
                    .substr($numero_control, 0, 2);

                $url =
                    'usuarios/alumnos/'
                    .$anio.'/'
                    .$numero_control.'/'
                    .$subirectorio.'/';
                break;
            case 2:
                // el usuario es docente o administrativo
                $numero_control = trim($numero_control);
                $url =
                    'usuarios/empleados/'
                    .$numero_control.'/'
                    .$subirectorio.'/';
                break;
            case 3:
                // el usuario es aspirante
                $periodo = substr(trim($numero_control), 0, 4);

                $numero_control = mb_ereg_replace("[a-zA-Z]","", $numero_control);

                $anio =
                    substr(date('Y'), 0,2)
                    .substr($numero_control, 0, 2);

                $url =
                    'usuarios/aspirantes'
                    .$anio.'/'
                    .$periodo.'/'
                    .$numero_control.'/'
                    .$subirectorio.'/';
                break;
            default: break;
        }

        // validar si existe la carpeta
        if (!is_dir($url)) {
            // crear directorio
            mkdir($url, 0777, true);
        }

        return $url;
    }
}
