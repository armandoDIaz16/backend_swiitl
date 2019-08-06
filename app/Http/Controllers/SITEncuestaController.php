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

class SITEncuestaController extends Controller
{

    public function guarda_respuestas_pasatiempos(Request $request) {
        // TODO guardar respuestas de alumno
        $aplicacion = Aplicacion_Encuesta::where('PK_APLICACION_ENCUESTA', $request->PK_APLICACION)->first();
        $aplicacion->FECHA_RESPUESTA = date('Y-m-d H:i:s');
        $aplicacion->ESTADO = 2;
        $aplicacion->save();

        return response()->json(
            ['data' => true],
            Response::HTTP_OK
        );
    }

    public function get_cuestionarios_usuarios($id_usuario)
    {
        $encuestas = DB::table('VIEW_LISTA_ENCUESTAS')
            ->where('FK_USUARIO', $id_usuario)
            ->get();

        if (count($encuestas) > 0){
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

    public function get_encuesta($pk_cuestionario)
    {
        $encuesta = $this->get_encuesta_por_pk($pk_cuestionario);

        if ($encuesta > 0){
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

    public function get_encuesta_aplicacion($pk_aplicacion_encuesta) {
        $encuesta = DB::table('VIEW_LISTA_ENCUESTAS')
            ->where('PK_APLICACION_ENCUESTA', $pk_aplicacion_encuesta)
            ->first();

        $encuesta = $this->get_encuesta_por_pk($encuesta->PK_ENCUESTA);

        if ($encuesta > 0){
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

    private function get_encuesta_por_pk($pk_encuesta){
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
                            'ORDEN' => $respuesta->ORDEN
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
