<?php

namespace App\Helpers;

/**
 * Class Base64ToFile
 * @package App\Helpers
 */
class Base64ToFile
{

    /**
     * Función para guardar en el servidor un archivo codificada con base 64
     * @param  String $name      Nombre y extencion el archivo
     * @param  String $sitema    Ruta donde se guardará el archivo
     * @param  String $content   Contenido codificado con base 64
     */
    function guardarArchivo($sistema, $name, $ext, $content)
    {
        $array_encoded = explode(',', $content);

        $carpetas = public_path('files/');

        $location = $carpetas . $sistema . '/' . $name . '.' . $ext;

        $current = base64_decode($array_encoded[1]);

        if (file_exists($carpetas . $sistema)) {
            if (file_exists($location)) {
                $this->guardarArchivo($sistema, $name . ' - copia', $ext, $content);
            }
        } else {
            mkdir($carpetas . $sistema, 0777, true);
        }
        file_put_contents($location, $current);

        $ruta = public_path('files/'. $sistema . '/' . $name . '.' . $ext);

        return $ruta;
    }

    /**
     * @param $ruta
     * @param $nombre
     * @param $extension
     * @param $contenido
     * @param $reemplazar
     * @return string
     */
    public static function guarda_archivo($ruta, $nombre, $extension, $contenido, $reemplazar = false)
    {
        $location = '';
        if (!$reemplazar) {
            do {
                $location = $ruta . $nombre .'.'. $extension;
                $nombre .='1';
            } while (file_exists($location));
        }

         if (file_put_contents($location, base64_decode(explode(',', $contenido)[1]))) {
             return $location;
         } else {
             return null;
         }
    }
}
