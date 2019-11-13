<?php

namespace App\Http\Controllers\tutorias;

use App\Helpers\SITHelper;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Aplicacion_Encuesta;

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
                        SITHelper::get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 3: // Condición Socioeconómica
                    $reporte =
                        SITHelper::get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 14);
                    $reporte['CONDICION_SOCIOECONOMICA'] =
                        SITHelper::reporte_condicion_socioeconomica($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 5: // Condición Familiar
                    $reporte =
                        SITHelper::get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 16);
                    $reporte['CONDICION_FAMILIAR'] =
                        SITHelper::reporte_condicion_familiar($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 6: // Hábitos de estudio
                    $reporte =
                        SITHelper::get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 2);
                    $reporte['HABITOS_ESTUDIO'] =
                        SITHelper::reporte_habitos_estudio($aplicacion->FK_ENCUESTA, $pk_aplicacion);
                    break;

                case 8: // 16 PF
                    $reporte =
                        SITHelper::get_cuestionario_resuelto($aplicacion->FK_ENCUESTA, $pk_aplicacion, 2);
                    $reporte['PF_16'] =
                        SITHelper::reporte_factores_personalidad($aplicacion->FK_ENCUESTA, $pk_aplicacion);
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
}
