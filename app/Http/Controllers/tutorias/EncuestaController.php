<?php

namespace App\Http\Controllers\tutorias;

use App\Aplicacion_Encuesta_Detalle;
use App\Helpers\ResponseHTTP;
use App\Http\Controllers\Controller;
use App\RespuestaUsuarioEncuesta;
use Illuminate\Http\Request;
use App\Encuesta;
use App\Seccion_Encuesta;
use App\Respuesta_Posible;
use Illuminate\Support\Facades\DB;
use App\Aplicacion_Encuesta;

/**
 * Class SITEncuestaController
 * @package App\Http\Controllers
 */
class EncuestaController extends Controller
{
    /**
     * @param $pk_encuesta
     * @return \Illuminate\Http\JsonResponse
     */
    public function respuestas_encuesta(Request $request)
    {
        if ($request->pk_aplicacion) {
            $aplicacion = Aplicacion_Encuesta_Detalle::leftJoin('TR_APLICACION_ENCUESTA',
                'TR_APLICACION_ENCUESTA.PK_APLICACION', '=', 'FK_APLICACION_ENCUESTA')
                ->where('PK_APLICACION_ENCUESTA_DETALLE', $request->pk_aplicacion)
                ->first();
            if ($aplicacion) {
                if ($aplicacion->FK_ENCUESTA == 1) {
                    // es la encuesta de ordenar
                    $respuestas = $this->get_respuestas_pasatiempos($aplicacion->FK_ENCUESTA);
                } else {
                    $respuestas = $this->get_respuestas($aplicacion->FK_ENCUESTA, $request->pk_aplicacion);
                }
                return ResponseHTTP::response_ok($respuestas);
            } else {
                return ResponseHTTP::response_error();
            }
        } else {
            return ResponseHTTP::response_error();
        }
    }

    /**
     * @param $fk_encuesta
     * @param $pk_aplicacion
     * @return array
     */
    private function get_respuestas($fk_encuesta, $pk_aplicacion)
    {
        $cuestionario_completo = [];
        $array_secciones = array();
        $cuestionario = Encuesta::find($fk_encuesta);
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $array_preguntas = array();
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA',
                        'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA',
                        '=',
                        'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {

                    //consultar respuesta de usuario
                    $respuestas = RespuestaUsuarioEncuesta::leftJoin(
                            'CAT_RESPUESTA_POSIBLE',
                            'CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE',
                            '=',
                            'FK_RESPUESTA_POSIBLE'
                        )
                        ->leftJoin(
                            'TR_APLICACION_ENCUESTA_DETALLE',
                            'TR_APLICACION_ENCUESTA_DETALLE.PK_APLICACION_ENCUESTA_DETALLE',
                            '=',
                            'FK_APLICACION_ENCUESTA_DETALLE'
                        )
                        ->leftJoin(
                            'CAT_PREGUNTA',
                            'CAT_RESPUESTA_POSIBLE.FK_PREGUNTA',
                            '=',
                            'CAT_PREGUNTA.PK_PREGUNTA'
                        )
                        ->where('PK_APLICACION_ENCUESTA_DETALLE', $pk_aplicacion)
                        ->where('PK_PREGUNTA', $pregunta->PK_PREGUNTA)
                        ->get();
                    $array_respuestas = array();
                    foreach ($respuestas as $respuesta) {
                        $array_respuestas[] = array(
                            'PK_RESPUESTA_POSIBLE' => $respuesta->PK_RESPUESTA_POSIBLE,
                            'FK_PREGUNTA' => $respuesta->FK_PREGUNTA,
                            'RESPUESTA' => $respuesta->RESPUESTA,
                            'VALOR_NUMERICO' => $respuesta->VALOR_NUMERICO,
                            'MINIMO' => $respuesta->MINIMO,
                            'MAXIMO' => $respuesta->MAXIMO,
                            'ORDEN' => $respuesta->ORDEN,
                            'ES_MIXTA' => $respuesta->ES_MIXTA,
                            'ABIERTA' => $respuesta->RESPUESTA_ABIERTA
                        );
                    }
                    $array_preguntas[] = array(
                        'PK_PREGUNTA' => $pregunta->PK_PREGUNTA,
                        'FK_SECCION' => $pregunta->FK_SECCION,
                        'ORDEN' => $pregunta->ORDEN,
                        'PLANTEAMIENTO' => $pregunta->PLANTEAMIENTO,
                        'TEXTO_GUIA' => $pregunta->TEXTO_GUIA,
                        'FK_TIPO_PREGUNTA' => $pregunta->FK_TIPO_PREGUNTA,
                        'NOMBRE_TIPO_PREGUNTA' => $pregunta->NOMBRE_TIPO_PREGUNTA,
                        'RESPUESTAS' => $array_respuestas
                    );
                }
                $array_secciones[] = array(
                    'PK_SECCION' => $seccion->PK_SECCION,
                    'FK_ENCUESTA' => $seccion->FK_ENCUESTA,
                    'NOMBRE' => $seccion->NOMBRE,
                    'NUMERO' => $seccion->NUMERO,
                    'ORDEN' => $seccion->ORDEN,
                    'OBJETIVO' => $seccion->OBJETIVO,
                    'INSTRUCCIONES' => $seccion->INSTRUCCIONES,
                    'PREGUNTAS' => $array_preguntas
                );
            }
            $cuestionario_completo = array(
                'PK_ENCUESTA' => $cuestionario->PK_ENCUESTA,
                'NOMBRE' => $cuestionario->NOMBRE,
                'OBJETIVO' => $cuestionario->OBJETIVO,
                'INSTRUCCIONES' => $cuestionario->INSTRUCCIONES,
                'FUENTE_CITA' => $cuestionario->FUENTE_CITA,
                'ES_ADMINISTRABLE' => $cuestionario->ES_ADMINISTRABLE,
                'SECCIONES' => $array_secciones
            );
        }

        return $cuestionario_completo;
    }

    /**
     * @param $fk_encuesta
     * @return array
     */
    private function get_respuestas_pasatiempos($fk_encuesta)
    {
        $cuestionario_completo = [];
        $array_secciones = array();
        $cuestionario = Encuesta::find($fk_encuesta);
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $array_preguntas = array();
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA',
                        'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA',
                        '=',
                        'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {

                    //consultar respuesta de usuario
                    $respuestas = Respuesta_Posible::where('FK_PREGUNTA', $pregunta->PK_PREGUNTA)
                        ->orderBy('ORDEN', 'ASC')
                        ->get();
                    $array_respuestas = array();
                    foreach ($respuestas as $respuesta) {
                        $array_respuestas[] = array(
                            'PK_RESPUESTA_POSIBLE' => $respuesta->PK_RESPUESTA_POSIBLE,
                            'FK_PREGUNTA' => $respuesta->FK_PREGUNTA,
                            'RESPUESTA' => $respuesta->RESPUESTA,
                            'VALOR_NUMERICO' => $respuesta->VALOR_NUMERICO,
                            'MINIMO' => $respuesta->MINIMO,
                            'MAXIMO' => $respuesta->MAXIMO,
                            'ORDEN' => $respuesta->ORDEN,
                            'ES_MIXTA' => $respuesta->ES_MIXTA
                        );
                    }
                    $array_preguntas[] = array(
                        'PK_PREGUNTA' => $pregunta->PK_PREGUNTA,
                        'FK_SECCION' => $pregunta->FK_SECCION,
                        'ORDEN' => $pregunta->ORDEN,
                        'PLANTEAMIENTO' => $pregunta->PLANTEAMIENTO,
                        'TEXTO_GUIA' => $pregunta->TEXTO_GUIA,
                        'FK_TIPO_PREGUNTA' => $pregunta->FK_TIPO_PREGUNTA,
                        'NOMBRE_TIPO_PREGUNTA' => $pregunta->NOMBRE_TIPO_PREGUNTA,
                        'RESPUESTAS' => $array_respuestas
                    );
                }
                $array_secciones[] = array(
                    'PK_SECCION' => $seccion->PK_SECCION,
                    'FK_ENCUESTA' => $seccion->FK_ENCUESTA,
                    'NOMBRE' => $seccion->NOMBRE,
                    'NUMERO' => $seccion->NUMERO,
                    'ORDEN' => $seccion->ORDEN,
                    'OBJETIVO' => $seccion->OBJETIVO,
                    'INSTRUCCIONES' => $seccion->INSTRUCCIONES,
                    'PREGUNTAS' => $array_preguntas
                );
            }
            $cuestionario_completo = array(
                'PK_ENCUESTA' => $cuestionario->PK_ENCUESTA,
                'NOMBRE' => $cuestionario->NOMBRE,
                'OBJETIVO' => $cuestionario->OBJETIVO,
                'INSTRUCCIONES' => $cuestionario->INSTRUCCIONES,
                'FUENTE_CITA' => $cuestionario->FUENTE_CITA,
                'ES_ADMINISTRABLE' => $cuestionario->ES_ADMINISTRABLE,
                'SECCIONES' => $array_secciones
            );
        }

        return $cuestionario_completo;
    }
}
