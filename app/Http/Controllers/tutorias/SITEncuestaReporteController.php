<?php

namespace App\Http\Controllers;

use App\Helpers\Constantes;
use Illuminate\Http\Request;
use App\Encuesta;
use App\Seccion_Encuesta;
use App\Pregunta;
use App\Tipo_Pregunta;
use App\Respuesta_Posible;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\IFTTTHandler;
use Symfony\Component\HttpFoundation\Response;
use App\Aplicacion_Encuesta;
use App\RespuestaUsuarioEncuesta;

/**
 * Class SITEncuestaController
 * @package App\Http\Controllers
 */
class SITEncuestaReporteController extends Controller
{
    /**
     * @param $pk_encuesta
     * @return array
     */
    public function get_reporte_encuesta($pk_aplicacion)
    {
        $aplicacion = Aplicacion_Encuesta::where('PK_APLICACION_ENCUESTA', $pk_aplicacion)->first();

        if (isset($aplicacion->FK_ENCUESTA)) {
            switch ($aplicacion->FK_ENCUESTA) {
                case 1: // Pasatiempos
                case 2: // Salud
                case 4: // Condición Académica
                    // solo se muestran resultados del cuestionario
                    $reporte =
                        $this->get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 3: // Condición Socioeconómica
                    $reporte =
                        $this->get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 14);
                    $reporte['CONDICION_SOCIOECONOMICA'] =
                        $this->get_condicion_socioeconomica($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 5: // Condición Familiar
                    $reporte =
                        $this->get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 16);
                    $reporte['CONDICION_FAMILIAR'] =
                        $this->get_condicion_familiar($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 6: // Hábitos de estudio
                    $reporte =
                        $this->get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 2);
                    $reporte['HABITOS_ESTUDIO'] =
                        $this->get_habitos_estudio($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 8: // 16 PF
                    $reporte =
                        $this->get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 2);
                    $reporte['PF_16'] =
                        $this->get_factores($aplicacion->FK_ENCUESTA, $pk_aplicacion, 16);
                    break;
            }

            return response()->json(
                ['data' => $reporte],
                Response::HTTP_OK
            );
        } else {
            // aplicacion no encontrada
            return response()->json(
                ['error' => "Ha ocurrido un error, inténtelo de nuevo"],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    private function get_factores($fk_encuesta, $pk_aplicacion)
    {
        $array_A  = [200, 223, 224, 248, 249, 273, 298, 323, 348, 373];
        $array_C  = [201, 202, 226, 227, 252, 276, 277, 301, 302, 326, 327, 351, 376];
        $array_F  = [205, 230, 255, 279, 280, 304, 305, 329, 330, 354, 355, 379, 380];
        $array_H  = [207, 232, 233, 257, 258, 282, 283, 307, 308, 332, 333, 358, 383];
        $array_L  = [210, 235, 260, 261, 285, 286, 310, 311, 336, 361];
        $array_N  = [213, 214, 238, 239, 263, 264, 289, 314, 339, 364];
        $array_Q1 = [217, 218, 242, 243, 267, 292, 317, 342, 366, 367];
        $array_Q3 = [220, 221, 245, 270, 295, 320, 345, 344, 369, 370];
        $array_B  = [225, 250, 251, 274, 275, 299, 300, 324, 325, 349, 350, 374, 375];
        $array_E  = [203, 204, 228, 229, 253, 254, 278, 303, 328, 352, 353, 377, 378];
        $array_G  = [206, 231, 256, 281, 306, 331, 356, 357, 381, 382];
        $array_I  = [208, 209, 234, 259, 284, 309, 334, 335, 359, 360];
        $array_M  = [211, 212, 236, 237, 262, 287, 288, 312, 313, 337, 338, 362, 363];
        $array_O = [215, 216, 240, 241, 265, 266, 290, 291, 315, 316, 340, 341, 365];
        $array_Q2 = [219, 244, 268, 269, 293, 294, 318, 319, 343, 368];
        $array_Q4 = [222, 246, 247, 271, 272, 296, 297, 321, 322, 346, 347, 371, 372];

        $sumatoria_A  = 0;
        $sumatoria_C  = 0;
        $sumatoria_F  = 0;
        $sumatoria_H  = 0;
        $sumatoria_L  = 0;
        $sumatoria_N  = 0;
        $sumatoria_Q1 = 0;
        $sumatoria_Q3 = 0;
        $sumatoria_B  = 0;
        $sumatoria_E  = 0;
        $sumatoria_G  = 0;
        $sumatoria_I  = 0;
        $sumatoria_M  = 0;
        $sumatoria_O = 0;
        $sumatoria_Q2 = 0;
        $sumatoria_Q4 = 0;

        $cuestionario = Encuesta::where('PK_ENCUESTA', $fk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);

                    if (in_array($pregunta->PK_PREGUNTA, $array_A)) {
                        $sumatoria_A += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_C)) {
                        $sumatoria_C += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_F)) {
                        $sumatoria_F += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_H)) {
                        $sumatoria_H += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_L)) {
                        $sumatoria_L += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_N)) {
                        $sumatoria_N += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q1)) {
                        $sumatoria_Q1 += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q3)) {
                        $sumatoria_Q3 += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_B)) {
                        $sumatoria_B += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_E)) {
                        $sumatoria_E += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_G)) {
                        $sumatoria_G += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_I)) {
                        $sumatoria_I += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_M)) {
                        $sumatoria_M += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_O)) {
                        $sumatoria_O += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q2)) {
                        $sumatoria_Q2 += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q4)) {
                        $sumatoria_Q4 += $respuestas->SUMATORIA;
                    }
                }
            }
        }

        return [
            'sumatoria_A' =>  $sumatoria_A,
            'sumatoria_C' =>  $sumatoria_C,
            'sumatoria_F' =>  $sumatoria_F,
            'sumatoria_H' =>  $sumatoria_H,
            'sumatoria_L' =>  $sumatoria_L,
            'sumatoria_N' =>  $sumatoria_N,
            'sumatoria_Q1' => $sumatoria_Q1,
            'sumatoria_Q3' => $sumatoria_Q3,
            'sumatoria_B' =>  $sumatoria_B,
            'sumatoria_E' =>  $sumatoria_E,
            'sumatoria_G' =>  $sumatoria_G,
            'sumatoria_I' =>  $sumatoria_I,
            'sumatoria_M' =>  $sumatoria_M,
            'sumatoria_O' =>  $sumatoria_O,
            'sumatoria_Q2' => $sumatoria_Q2,
            'sumatoria_Q4' => $sumatoria_Q4

            /*'sumatoria_A' =>  $this->evalua_factor($sumatoria_A, 'A'),
            'sumatoria_C' =>  $this->evalua_factor($sumatoria_C, 'C'),
            'sumatoria_F' =>  $this->evalua_factor($sumatoria_F, 'F'),
            'sumatoria_H' =>  $this->evalua_factor($sumatoria_H, 'H'),
            'sumatoria_L' =>  $this->evalua_factor($sumatoria_L, 'L'),
            'sumatoria_N' =>  $this->evalua_factor($sumatoria_N, 'N'),
            'sumatoria_Q1' => $this->evalua_factor($sumatoria_Q1, 'Q1'),
            'sumatoria_Q3' => $this->evalua_factor($sumatoria_Q3, 'Q3'),
            'sumatoria_B' =>  $this->evalua_factor($sumatoria_B, 'B'),
            'sumatoria_E' =>  $this->evalua_factor($sumatoria_E, 'E'),
            'sumatoria_G' =>  $this->evalua_factor($sumatoria_G, 'G'),
            'sumatoria_I' =>  $this->evalua_factor($sumatoria_I, 'I'),
            'sumatoria_M' =>  $this->evalua_factor($sumatoria_M, 'M'),
            'sumatoria_O' =>  $this->evalua_factor($sumatoria_O, 'O'),
            'sumatoria_Q2' => $this->evalua_factor($sumatoria_Q2, 'Q2'),
            'sumatoria_Q4' => $this->evalua_factor($sumatoria_Q4, 'Q4')*/
        ];
    }

    private function evalua_factor($sumatoria, $factor) {
        switch ($factor) {
            case 'A':
                if ($sumatoria >= 0 && $sumatoria <= 3) return 1;
                if ($sumatoria >= 4 && $sumatoria <= 5) return 2;
                if ($sumatoria >= 6 && $sumatoria <= 7) return 3;
                if ($sumatoria == 8) return 4;
                if ($sumatoria >= 9 && $sumatoria <= 10) return 5;
                if ($sumatoria >= 11 && $sumatoria <= 12) return 6;
                if ($sumatoria == 13) return 7;
                if ($sumatoria >= 14 && $sumatoria <= 15) return 8;
                if ($sumatoria == 16) return 9;
                if ($sumatoria >= 18 && $sumatoria <= 20) return 10;
            case 'C':
                if ($sumatoria >= 0 && $sumatoria <= 1) return 1;
                if ($sumatoria == 2) return 2;
                if ($sumatoria >= 3 && $sumatoria <= 4) return 3;
                if ($sumatoria == 5) return 4;
                if ($sumatoria == 6) return 5;
                if ($sumatoria == 7) return 6;
                if ($sumatoria == 8) return 7;
                // if ($sumatoria == 9) return 8;
                if ($sumatoria == 9) return 9;
                if ($sumatoria >= 10 && $sumatoria <= 13) return 10;
            case 'F':
                if ($sumatoria >= 0 && $sumatoria <= 3) return 1;
                if ($sumatoria >= 4 && $sumatoria <= 5) return 2;
                if ($sumatoria >= 6 && $sumatoria <= 7) return 3;
                if ($sumatoria == 8) return 4;
                if ($sumatoria >= 9 && $sumatoria <= 10) return 5;
                if ($sumatoria >= 11 && $sumatoria <= 12) return 6;
                if ($sumatoria == 13) return 7;
                if ($sumatoria >= 14 && $sumatoria <= 15) return 8;
                if ($sumatoria == 16) return 9;
                if ($sumatoria >= 18 && $sumatoria <= 20) return 10;
            case 'H': break;
            case 'L': break;
            case 'N': break;
            case 'Q1': break;
            case 'Q2': break;
            case 'B': break;
            case 'E': break;
            case 'G': break;
            case 'I': break;
            case 'M': break;
            case 'O': break;
            case 'Q2': break;
            case 'Q4': break;
        }
    }

    private function get_habitos_estudio($fk_encuesta, $pk_aplicacion)
    {
        $array_DT = [97, 104, 111, 118, 125, 132, 139, 146, 153, 160];
        $sumatoria_DT = 0;

        $array_ME = [98, 105, 112, 119, 126, 133, 140, 147, 154, 161];
        $sumatoria_ME = 0;

        $array_DE = [99, 106, 113, 120, 127, 134, 141, 148, 155, 162];
        $sumatoria_DE = 0;

        $array_NC = [100, 107, 114, 121, 128, 135, 142, 149, 156, 163];
        $sumatoria_NC = 0;

        $array_OL = [101, 108, 115, 122, 129, 136, 143, 150, 157, 164];
        $sumatoria_OL = 0;

        $array_PE = [102, 109, 116, 123, 130, 137, 144, 151, 158, 165];
        $sumatoria_PE = 0;

        $array_AC = [103, 110, 117, 124, 131, 138, 145, 152, 159, 166];
        $sumatoria_AC = 0;

        $cuestionario = Encuesta::where('PK_ENCUESTA', $fk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);

                    if (in_array($pregunta->PK_PREGUNTA, $array_DT)) {
                        $sumatoria_DT += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_ME)) {
                        $sumatoria_ME += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_DE)) {
                        $sumatoria_DE += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_NC)) {
                        $sumatoria_NC += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_OL)) {
                        $sumatoria_OL += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_PE)) {
                        $sumatoria_PE += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_AC)) {
                        $sumatoria_AC += $respuestas->SUMATORIA;
                    }
                }
            }
        }

        return [
            'sumatoria_DT' => $sumatoria_DT,
            'sumatoria_ME' => $sumatoria_ME,
            'sumatoria_DE' => $sumatoria_DE,
            'sumatoria_NC' => $sumatoria_NC,
            'sumatoria_OL' => $sumatoria_OL,
            'sumatoria_PE' => $sumatoria_PE,
            'sumatoria_AC' => $sumatoria_AC
        ];
    }

    private function get_condicion_familiar($fk_encuesta, $pk_aplicacion)
    {
        $array_cohesion = [77, 80, 83, 85, 86, 89, 91, 93, 94, 96];
        $sumatoria_cohesion = 0;

        $array_adaptabilidad = [78, 79, 81, 82, 84, 87, 88, 90, 92, 95];
        $sumatoria_adaptabilidad = 0;
        $cuestionario = Encuesta::where('PK_ENCUESTA', $fk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);
                    if (in_array($pregunta->PK_PREGUNTA, $array_cohesion)) {
                        $sumatoria_cohesion += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_adaptabilidad)) {
                        $sumatoria_adaptabilidad += $respuestas->SUMATORIA;
                    }
                }
            }
        }

        return [
            'COHESION'      => $sumatoria_cohesion,
            'ADAPTABILIDAD' => $sumatoria_adaptabilidad
        ];
    }

    private function get_condicion_socioeconomica($fk_encuesta, $pk_aplicacion)
    {
        $sumatoria = 0;
        $cuestionario = Encuesta::where('PK_ENCUESTA', $fk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);
                    $sumatoria += $respuestas->SUMATORIA;
                }
            }
        }

        return $sumatoria;
    }

    private function get_cuestionario_resuelto($fk_encuesta, $pk_aplicacion, $cantidad_preguntas = null)
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
                $contador = 0;
                foreach ($preguntas as $pregunta) {
                    $contador++;

                    //consultar respuesta de usuario
                    $sql = "SELECT
                                PK_RESPUESTA_POSIBLE,
                                FK_PREGUNTA,
                                RESPUESTA,
                                TR_RESPUESTA_USUARIO_ENCUESTA.RESPUESTA_ABIERTA AS ABIERTA,
                                VALOR_NUMERICO,
                                MINIMO,
                                MAXIMO,
                                TR_RESPUESTA_USUARIO_ENCUESTA.ORDEN,
                                ES_MIXTA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                            ORDER BY
                                TR_RESPUESTA_USUARIO_ENCUESTA.ORDEN ASC
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql);
                    $array_respuestas = array();
                    if ($cantidad_preguntas)
                        if ($cantidad_preguntas == $contador)
                            break;
                    foreach ($respuestas as $respuesta) {
                        $array_respuestas[] = array(
                            'PK_RESPUESTA_POSIBLE' => $respuesta->PK_RESPUESTA_POSIBLE,
                            'FK_PREGUNTA' => $respuesta->FK_PREGUNTA,
                            'RESPUESTA' => $respuesta->RESPUESTA,
                            'ABIERTA' => $respuesta->ABIERTA,
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
