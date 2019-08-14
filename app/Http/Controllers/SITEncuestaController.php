<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Encuesta;
use App\Seccion_Encuesta;
use App\Pregunta;
use App\Tipo_Pregunta;
use App\Respuesta_Posible;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Aplicacion_Encuesta;
use App\RespuestaUsuarioEncuesta;

/**
 * Class SITEncuestaController
 * @package App\Http\Controllers
 */
class SITEncuestaController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function guarda_respuestas_encuesta(Request $request)
    {
        try {
            //guardar respuestas de encuesta
            if ($this->guarda_respuestas($request)) {
                // actualizar estatus de encuesta
                $aplicacion = Aplicacion_Encuesta::where('PK_APLICACION_ENCUESTA', $request->PK_APLICACION)->first();
                $aplicacion->FECHA_RESPUESTA = date('Y-m-d H:i:s');
                $aplicacion->FECHA_MODIFICACION = date('Y-m-d H:i:s');
                $aplicacion->FK_USUARIO_MODIFICACION = $aplicacion->FK_USUARIO;
                $aplicacion->ESTADO = 2;
                $aplicacion->save();

                return response()->json(
                    ['data' => true],
                    Response::HTTP_OK
                );
            }
        } catch (Exception $e) {
            error_log("Error en actualización de aplicación de encuesta: ");
            error_log("Detalles:");
            error_log($e->getMessage());

            return response()->json(
                ['error' => "Ha ocurrido un error, inténtelo de nuevo"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function guarda_respuestas(Request $request)
    {
        try {
            //guardar respuestas de encuesta
            if ($request->PK_ENCUESTA == 1) {
                DB::table('TR_RESPUESTA_USUARIO_ENCUESTA')->insert(
                    $this->get_respuestas_pasatiempos($request->PK_APLICACION, $request->RESPUESTAS)
                );
            } else {
                DB::table('TR_RESPUESTA_USUARIO_ENCUESTA')->insert(
                    $this->get_respuestas_encuesta($request->PK_APLICACION, $request->RESPUESTAS)
                );
            }

            return true;
        } catch (Exception $e) {
            error_log("Error guardar detalle de respuesta de encuesta: ");
            error_log("Detalles:");
            error_log($e->getMessage());

            return false;
        }
    }

    /**
     * @param $pk_aplicacion
     * @param $request
     * @return array
     */
    private function get_respuestas_encuesta($pk_aplicacion, $respuestas_request)
    {
        $respuestas = [];

        foreach ($respuestas_request['PREGUNTAS'] as $respuesta) {
            $respuestas[] = [
                'FK_RESPUESTA_POSIBLE'   => $respuesta['RESPUESTAS'][0]['PK_RESPUESTA'],
                'FK_APLICACION_ENCUESTA' => $pk_aplicacion,
                'RESPUESTA_ABIERTA'      => $respuesta['RESPUESTAS'][0]['ABIERTA'],
                'ORDEN'                  => 0,
                'RANGO'                  => $respuesta['RESPUESTAS'][0]['RANGO']
            ];
        }

        return $respuestas;
    }

    /**
     * @param $pk_aplicacion
     * @param $request
     * @return array
     */
    private function get_respuestas_pasatiempos($pk_aplicacion, $request)
    {
        $respuestas = [];

        foreach ($request as $respuesta) {
            $respuestas[] = [
                'FK_RESPUESTA_POSIBLE' => $respuesta['pk_respuesta'],
                'FK_APLICACION_ENCUESTA' => $pk_aplicacion,
                'ORDEN' => $respuesta['orden']
            ];
        }

        return $respuestas;
    }

    /**
     * @param $id_usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_cuestionarios_usuarios($id_usuario)
    {
        $encuestas = DB::table('VIEW_LISTA_ENCUESTAS')
            ->where('FK_USUARIO', $id_usuario)
            ->get();

        if (count($encuestas) > 0) {
            return response()->json(
                ['data' => $encuestas],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['data' => false],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param $pk_cuestionario
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_encuesta($pk_cuestionario)
    {
        $encuesta = $this->get_encuesta_por_pk($pk_cuestionario);

        if ($encuesta > 0) {
            return response()->json(
                ['data' => $encuesta],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['data' => false],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param $pk_aplicacion_encuesta
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_encuesta_aplicacion($pk_aplicacion_encuesta)
    {
        $encuesta = DB::table('VIEW_LISTA_ENCUESTAS')
            ->where('PK_APLICACION_ENCUESTA', $pk_aplicacion_encuesta)
            ->first();

        $encuesta = $this->get_encuesta_por_pk($encuesta->PK_ENCUESTA);

        if ($encuesta > 0) {
            return response()->json(
                ['data' => $encuesta],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['data' => false],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param $pk_encuesta
     * @return array
     */
    private function get_encuesta_por_pk($pk_encuesta)
    {
        $array_secciones = array();
        $cuestionario = Encuesta::where('PK_ENCUESTA', $pk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $array_preguntas = array();
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    $respuestas = Respuesta_Posible::where('FK_PREGUNTA', $pregunta->PK_PREGUNTA)->get();
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
