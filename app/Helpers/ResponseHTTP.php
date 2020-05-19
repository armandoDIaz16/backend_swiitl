<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ResponseHTTP
{
    /**
     * @param $data
     * @param int $max
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response_ok($data, $max = 1, $message = 'Procesado con éxito') {
        return response()->json(
            self::make_reponse_ok($data, $max, $message),
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response_error($message = 'No se encontraron datos') {
        return response()->json(
            self::make_reponse_error($message),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @param $data
     * @param string $message
     * @param bool $error
     * @return object
     */
    private static function make_reponse_ok($data, $max = 1, $message = 'Procesado con éxito') {
        return (object)[
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
            'maxRecords' => $max,
        ];
    }

    /**
     * @param $data
     * @param string $message
     * @param bool $error
     * @return object
     */
    public static function make_reponse_error($message) {
        return (object)[
            'code' => Response::HTTP_NOT_FOUND,
            'message' => $message,
            'data' => []
        ];
    }
}
