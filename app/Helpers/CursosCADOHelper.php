<?php

namespace App\Helpers;

use App\User;
use App\Usuario;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsuariosHelper
 * @package App\Helpers
 */
class CursosCADOHelper {



    /**
     * @param $subirectorio   Directorio al que se desea acceder para guardar
     * @return null
     */
    public static function get_url_carpeta_curso( $pk_curso,$periodo, $subirectorio) {
        $url = null;
        // armara la carpete similar a capacitacion_docente/AGO2019-ENE2020/cursos/12/
        $url =
            'capacitacion_docente/'
            .$periodo.'/'
            .'cursos/'
            .$pk_curso.'/'
            .$subirectorio.'/';

        // validar si existe la carpeta
        if (!is_dir($url)) {
            // crear directorio
            mkdir($url, 0777, true);
        }
        return $url;
    }
}
