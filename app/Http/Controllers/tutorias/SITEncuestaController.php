<?php

namespace App\Http\Controllers\tutorias;

use App\Aplicacion_Encuesta_Detalle;
use App\Carrera;
use App\Helpers\Constantes;
use App\Helpers\ResponseHTTP;
use App\Helpers\RespuestaHttp;
use App\Helpers\UsuariosHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Encuesta;
use App\Seccion_Encuesta;
use App\Respuesta_Posible;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Aplicacion_Encuesta;
use function GuzzleHttp\Promise\all;

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
                $aplicacion = Aplicacion_Encuesta_Detalle::find($request->PK_APLICACION);
                $aplicacion->FECHA_RESPUESTA = date('Y-m-d H:i:s');
                /*$aplicacion->FECHA_MODIFICACION = date('Y-m-d H:i:s');
                $aplicacion->FK_USUARIO_MODIFICACION = $aplicacion->FK_USUARIO;*/
                $aplicacion->ESTADO = Constantes::ENCUESTA_RESPONDIDA;
                $aplicacion->save();

                return ResponseHTTP::response_ok([]);
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
                'FK_RESPUESTA_POSIBLE' => $respuesta['RESPUESTAS'][0]['PK_RESPUESTA'],
                'FK_APLICACION_ENCUESTA_DETALLE' => $pk_aplicacion,
                'RESPUESTA_ABIERTA' => $respuesta['RESPUESTAS'][0]['ABIERTA'],
                'ORDEN' => 0,
                'RANGO' => $respuesta['RESPUESTAS'][0]['RANGO']
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
                'FK_APLICACION_ENCUESTA_DETALLE' => $pk_aplicacion,
                'ORDEN' => $respuesta['orden']
            ];
        }

        return $respuestas;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_encuestas_disponibles()
    {
        $encuestas = DB::table('CAT_ENCUESTA')->get();

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_tipos_aplicacion()
    {
        $encuestas = DB::table('CAT_TIPO_APLICACION_ENCUESTA')
            ->select('NOMBRE')
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

    public function get_carreras()
    {
        $carreras = Carrera::all();

        if (count($carreras) > 0) {
            return response()->json(
                ['data' => $carreras],
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_encuestas_historico()
    {
        $encuestas = DB::table('TR_APLICACION_ENCUESTA AS APE')
            ->select('APE.*', 'EN.NOMBRE AS NOMBRE_ENCUESTA', 'TIA.NOMBRE AS TIPO_APLICACION')
            ->leftJoin('CAT_ENCUESTA AS EN', 'APE.FK_ENCUESTA', '=', 'EN.PK_ENCUESTA')
            ->leftJoin('CAT_TIPO_APLICACION_ENCUESTA AS TIA', 'APE.FK_TIPO_APLICACION', '=', 'TIA.PK_TIPO_APLICACION')
            ->limit(50)
            ->orderBy('FECHA_APLICACION', 'DESC')
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function aplicar_encuesta(Request $request)
    {
        $encuesta = new Aplicacion_Encuesta;
        $usuario = UsuariosHelper::get_usuario($request->PK_ENCRIPTADA);

        $encuesta->FK_USUARIO_REGISTRO = $usuario->PK_USUARIO;
        $encuesta->FK_ENCUESTA = $request->PK_ENCUESTA;
        $encuesta->FK_TIPO_APLICACION = $request->PK_TIPO_APLICACION;
        $encuesta->PERIODO = Constantes::get_periodo();
        $encuesta->FECHA_APLICACION = date('Y-m-d H:i:s');
        $encuesta->FECHA_REGISTRO = date('Y-m-d H:i:s');

        switch ($request->TIPO_APLICACION) {
            case 2:
                // por carrera
                $encuesta->APLICACION_FK_CARRERA = $request->FK_CARRERA;
                break;
            case 3:
                // por semestre
                $encuesta->APLICACION_SEMESTRE = $request->SEMESTRE;
                break;
            case 5:
                // por usuario
                $usuario = UsuariosHelper::get_usuario_numero_control($request->NUMERO_CONTROL);
                $encuesta->FK_USUARIO = $usuario->PK_USUARIO;
                break;
        }

        if ($encuesta->save()) {
            $this->registra_detalle_aplicacion_encuesta($encuesta);

            return response()->json(
                RespuestaHttp::make_reponse_ok($encuesta),
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                RespuestaHttp::make_reponse_error(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    private function registra_detalle_aplicacion_encuesta(Aplicacion_Encuesta $encuesta)
    {
        switch ($encuesta->TIPO_APLICACION) {
            case 2:
                $this->aplica_carrera($encuesta->APLICACION_FK_CARRERA);
                break;
            case 3:
                $this->aplica_semestre($encuesta->APLICACION_SEMESTRE);
                break;
            case 5:
                $this->aplica_usuario($encuesta->FK_USUARIO);
                break;
        }
    }

    private function aplica_usuario($pk_usuario)
    {

    }

    private function aplica_semestre($semestre)
    {

    }

    private function aplica_carrera($pk_carrera)
    {

    }

    /**
     * @param $id_usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_cuestionarios_usuarios($pk_encriptada)
    {
        $usuario = UsuariosHelper::get_usuario($pk_encriptada);

        $encuestas = DB::table('VW_LISTA_ENCUESTAS')
            ->where('FK_USUARIO', $usuario->PK_USUARIO)
            ->orderBy('FECHA_APLICACION', 'DESC')
            ->get();

        foreach ($encuestas as $encuesta) {
            $encuesta->NOMBRE_PERIODO = Constantes::get_periodo_texto($encuesta->PERIODO);
        }

        return ResponseHTTP::response_ok($encuestas);
    }

    /**
     * @param $id_usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function cuestionarios_usuario_periodos($pk_encriptada)
    {
        $usuario = UsuariosHelper::get_usuario($pk_encriptada);

        $periodos = DB::table('VW_LISTA_ENCUESTAS')
            ->select('PERIODO')
            ->distinct()
            ->orderBy('PERIODO', 'DESC')
            ->get();

        /*$data_periodos = [];*/

        foreach ($periodos as $periodo) {
            /*$data_periodos[] = [
                'PERIODO' => $periodos->PERIODO,
                'NOBRE' => Constantes::get_periodo_texto($periodos->PERIODO)
            ];*/
            $periodo->NOMBRE = Constantes::get_periodo_texto($periodo->PERIODO);
        }

        /*return ResponseHTTP::response_ok((object)$data_periodos);*/
        return ResponseHTTP::response_ok($periodos);
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
     * @param $pk_detalle
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_encuesta_aplicacion(Request $request)
    {
        $usuario = UsuariosHelper::get_usuario($request->usuario);

        $aplicacion_encuesta = DB::table('VW_LISTA_ENCUESTAS')
            ->where('PK_APLICACION_ENCUESTA_DETALLE', $request->pk_detalle)
            ->where('FK_USUARIO', $usuario->PK_USUARIO)
            ->first();

        if ($aplicacion_encuesta->ESTADO_APLICACION == Constantes::ENCUESTA_PENDIENTE) {
            $encuesta = $this->get_encuesta_por_pk($aplicacion_encuesta->PK_ENCUESTA);

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

    /**
     * @param $pk_encuesta
     * @return array
     */
    public function get_encuesta_resuelta_aplicacion($pk_aplicacion)
    {
        // error_log($pk_aplicacion);
        $aplicacion = Aplicacion_Encuesta::where('PK_APLICACION_ENCUESTA', $pk_aplicacion)->first();

        if (isset($aplicacion->FK_ENCUESTA)) {
            if ($aplicacion->FK_ENCUESTA == 1) {
                // es la encuesta de ordenar
                $cuestionario_completo = $this->get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion);
            } else {
                $cuestionario_completo = [];
            }

            return $cuestionario_completo;
        } else {
            // encuesta no encontrada
            return [];
        }
    }

    private function get_cuestionario_resuelto($fk_encuesta, $pk_aplicacion)
    {
        $array_secciones = array();
        $cuestionario = Encuesta::where('PK_ENCUESTA', $fk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $array_preguntas = array();
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {

                    //consultar respuesta de usuario
                    $respuestas = Respuesta_Posible::where('FK_PREGUNTA', $pregunta->PK_PREGUNTA)->orderBy('ORDEN', 'ASC')->get();
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
