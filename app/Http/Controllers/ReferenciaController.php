<?php

namespace App\Http\Controllers;

use App\Helpers\Referencia;
use Illuminate\Support\Facades\DB;

class ReferenciaController extends Controller
{
    public function referenciaReInscripcion($id)
    {
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                'NUMERO_CONTROL',
                DB::raw("CAT_USUARIO.NOMBRE + ' ' + CAT_USUARIO.PRIMER_APELLIDO + ' ' + CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as NOMBRE"),
                DB::raw("'' as REFERENCIA"),
                DB::raw("'' as FECHA_LIMITE_PAGO"),
                DB::raw("'' as CONSEPTO"),
                DB::raw("'' as CLAVE"),
                DB::raw("'' as MONTO")
            )
            ->where('CAT_USUARIO.PK_ENCRIPTADA', $id)
            ->get();
    
        $PK_PERIODO_PREFICHAS = DB::table('CAT_PERIODO_PREFICHAS')->max('PK_PERIODO_PREFICHAS');
    
        $periodo = DB::table('CAT_PERIODO_PREFICHAS')->select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO_INSCRIPCION_BIS', 'FECHA_FIN_INSCRIPCION_BIS', 'MONTO_INSCRIPCION_BIS', 'TIPO_PERSONA_SEMESTRE_CERO', 'APLICACION_SIIA_SEMESTRE_CERO', 'CONCEPTO_SEMESTRE_CERO')
            ->where('PK_PERIODO_PREFICHAS', $PK_PERIODO_PREFICHAS)
            ->get();
    
        $fecha = date('Y-m-j');
        $dia = date("d", strtotime($fecha));
        if ($dia > 15) {
            $anio = date("Y", strtotime($fecha));
            $mes = 1 + date("m", strtotime($fecha));
            $dia = 2;
        } else {
            $anio = date("Y", strtotime($fecha));
            $mes = date("m", strtotime($fecha));
            $dia = 17;
        }
        $nuevafecha = strtotime($anio . '-' . $mes . '-' . $dia);
        $fechaFin = strtotime($periodo[0]->FECHA_FIN_INSCRIPCION_BIS);
        if ($nuevafecha > $fechaFin) {
            $nuevafecha = $fechaFin;
        }
        $fechaLimitePago = date('Y-m-j', $nuevafecha);
    
        $datosReferencia =
            [
                'tipo_persona' => '4',
                'control' => $aspirante[0]->NUMERO_CONTROL,
                'servicio' => '009',
                'valorvariable' => '2',
                'monto' => $periodo[0]->MONTO_INSCRIPCION_BIS,
                'yearC' => date('Y', strtotime($fechaLimitePago)),
                'mesC' => date('m', strtotime($fechaLimitePago)),
                'diaC' => date('j', strtotime($fechaLimitePago)),
            ];
        $aspirante[0]->REFERENCIA = Referencia::RUTINA8250POSICIONES($datosReferencia);
    
    
        $aspirante[0]->FECHA_LIMITE_PAGO = $fechaLimitePago;
        $aspirante[0]->CONCEPTO = "Referencia de pago para reinscripción";
        $aspirante[0]->CLAVE = DB::table('CAT_INSTITUCION')->select('CLAVE_CIE')->where('NOMBRE', 'ITL')->get()[0]->CLAVE_CIE;
        $aspirante[0]->MONTO = $datosReferencia['monto'];
        return $aspirante;
        $this->generarPDF($aspirante, 'aspirante.referencia');
    }
}
