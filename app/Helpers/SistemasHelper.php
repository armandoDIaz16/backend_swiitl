<?php

namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsuariosHelper
 * @package App\Helpers
 */
class SistemasHelper {


    /**
     * @param $nombre_sistema
     * @param $subirectorio
     * @return string|null
     */
    public static function get_url_expediente_tutorias($subirectorio, $periodo, $grupo) {
        $periodo = trim($periodo);
        $anio = substr($periodo, 0,4);
        $url = 'modulos/tutorias/'
            .$anio.'/'
            .$periodo.'/'
            .$grupo.'/'
            .$subirectorio.'/';

        self::verifica_directorio($url);

        return $url;
    }


    /**
     * @param $url
     */
    private static function verifica_directorio($url) {
        // validar si existe la carpeta
        if (!is_dir($url)) {
            // crear directorio
            mkdir($url, 0777, true);
            error_log("Ruta creada: " . $url);
        } else {
            error_log("Ruta existente: " . $url);
        }
    }
}
