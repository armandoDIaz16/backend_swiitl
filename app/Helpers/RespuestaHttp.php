<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class RespuestaHttp
 * @package App\Helpers
 */
class RespuestaHttp {

    /**
     * @param $data
     * @param string $message
     * @param bool $error
     * @return object
     */
    public static function make_reponse_ok($data, $message = 'Procesado con éxito') {
        return (object)[
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * @param $data
     * @param string $message
     * @param bool $error
     * @return object
     */
    public static function make_reponse_error($message = 'No se encontraron datos') {
        return (object)[
            'code' => Response::HTTP_NOT_FOUND,
            'message' => $message,
            'data' => []
        ];
    }
}
