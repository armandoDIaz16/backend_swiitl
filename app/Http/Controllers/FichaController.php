<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use DateTime;

class FichaController extends Controller
{
    public function descargarReferencia($id)
    {

        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO','CAT_USUARIO.PK_USUARIO','=','CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                DB::raw("CAT_USUARIO.NOMBRE + ' ' + CAT_USUARIO.PRIMER_APELLIDO + ' ' + CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as NOMBRE"),
                DB::raw("'' as REFERENCIA"),
                DB::raw("'' as FECHA_LIMITE_PAGO"),
                DB::raw("'' as CONSEPTO"),
                DB::raw("'' as CLAVE"),
                DB::raw("'' as MONTO")
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
            ->where([
                ['CAT_USUARIO.PK_ENCRIPTADA', '=', $id],
                ['CAT_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
            ])
            ->get();

        $PK_PERIODO_PREFICHAS = DB::table('CAT_PERIODO_PREFICHAS')->max('PK_PERIODO_PREFICHAS');

        $periodo = DB::table('CAT_PERIODO_PREFICHAS')->select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO', 'FECHA_FIN', 'MONTO_PREFICHA')
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
        $fechaFin = strtotime($periodo[0]->FECHA_FIN);
        if ($nuevafecha > $fechaFin) {
            $nuevafecha = strtotime('+2 day', $fechaFin);
        }
        $fechaLimitePago = date('Y-m-j', $nuevafecha);

        $datosReferencia =
            [
                'tipo_persona' => '0',
                'control' => $aspirante[0]->PREFICHA,
                'servicio' => '004',
                'valorvariable' => '2',
                'monto' => $periodo[0]->MONTO_PREFICHA,
                'yearC' => date('Y', strtotime($fechaLimitePago)),
                'mesC' => date('m', strtotime($fechaLimitePago)),
                'diaC' => date('j', strtotime($fechaLimitePago)),
            ];
        $aspirante[0]->REFERENCIA = $this->RUTINA8250POSICIONES($datosReferencia);
        $aspirante[0]->FECHA_LIMITE_PAGO = $fechaLimitePago;
        $aspirante[0]->CONCEPTO = "Solicitud de ficha de pago para examen de admisión";
        $aspirante[0]->CLAVE = DB::table('CAT_INSTITUCION')->select('CLAVE_CIE')->where('ALIAS', 'ITL')->get()[0]->CLAVE_CIE;
        $aspirante[0]->MONTO = $datosReferencia['monto'];

        return $this->generarPDF($aspirante, 'aspirante.referencia');
    }

    private function RUTINA8250POSICIONES($datos)
    {
        //return "fmdifj0jf0jf09j0f3900";
        $Amonto = array(7, 3, 1); //arreglo para obtener el importe concensado
        $ADV = array(11, 13, 17, 19, 23); //arreglo de digito verificador
        $letra = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5, 6, 7, 8, 9);

        $referencia = strtoupper($datos['tipo_persona'] . $datos['control'] . $datos['servicio']); //tipoalumno.control.servicio
        $rev = "";
        $ValorVariable = $datos['valorvariable'];
        foreach (str_split($referencia) as $char) {
            if ((ord($char) > 64 && ord($char) < 91)) {
                $rev .= $letra[ord($char) - 65];
            } else {
                $rev .= $char;
            }
        }
        $referencia = $rev;
        $monto = $datos['monto'];
        if (strpos($monto, '.') === false) {
            $monto = number_format($monto, 2, '.', '');
        }
        $fecha = "" . ((($datos['yearC'] - 2014) * 372) + (($datos['mesC'] - 1) * 31) + ($datos['diaC'] - 1));
        $monto = strrev(str_replace('.', '', $monto));
        $i = 0;
        $suma = 0;
        foreach (str_split($monto) as $dig) {
            $suma += ($Amonto[$i] * $dig);
            $i++;
            if ($i == count($Amonto)) {
                $i = 0;
            }
        }
        $monotoConde = "" . ($suma % 10);
        $referenciatemp = strrev($referencia . $fecha . '' . $monotoConde . '' . $ValorVariable);
        $i = 0;
        $suma = 0;
        foreach (str_split($referenciatemp) as $dig) {
            $suma += ($ADV[$i] * $dig);
            $i++;
            if ($i == count($ADV)) {
                $i = 0;
            }
        }
        $digitoVerificador = "" . (($suma % 97) + 1);
        $DV = (($suma % 97) + 1);
        if ($DV < 10) {
            $digitoVerificador = "0" . (($suma % 97) + 1);
        } else {
            $digitoVerificador = "" . (($suma % 97) + 1);
        }
        return $referencia . $fecha . $monotoConde . $ValorVariable . $digitoVerificador;
    }

    public function descargarFicha($id)
    {
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO','CAT_USUARIO.PK_USUARIO','=','CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_CARRERA.NOMBRE as NOMBRE_CARRERA',
                'CAT_CAMPUS.NOMBRE as CAMPUS',
                'CAT_ASPIRANTE.FOLIO_CENEVAL',
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
                'CAT_TURNO.DIA',
                'CAT_TURNO.DIA as NOMBRE_DIA',
                'CAT_TURNO.HORA',
                'CATR_EDIFICIO.NOMBRE as NOMBRE_EDIFICIO',
                'CATR_EDIFICIO.PREFIJO',
                'CAT_CAMPUS.NOMBRE as NOMBRE_CAMPUS',
                'CATR_ESPACIO.NOMBRE as NOMBRE_ESPACIO',
                'CAT_ASPIRANTE.FECHA_MODIFICACION'
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
            ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CAT_ASPIRANTE.FK_EXAMEN_ADMISION')
            ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
            ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
            ->join('CATR_EDIFICIO', 'CATR_EDIFICIO.PK_EDIFICIO', '=', 'CATR_ESPACIO.FK_EDIFICIO')
            ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.FK_CARRERA', '=', 'CAT_ASPIRANTE.FK_CARRERA_1')
            ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=', 'TR_CARRERA_CAMPUS.FK_CAMPUS')
            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=', 'TR_CARRERA_CAMPUS.FK_CARRERA')
            ->where([
                ['CAT_USUARIO.PK_ENCRIPTADA', '=', $id],
                ['CAT_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante]
            ])
            ->get();


        $fecha = $aspirante[0]->FECHA_MODIFICACION;
        $aspirante[0]->FECHA_MODIFICACION = substr($fecha, 8, 2) . "/" . substr($fecha, 5, 2) . "/" . substr($fecha, 0, 4);


        $dayofweek = date('w', strtotime($aspirante[0]->NOMBRE_DIA));
        switch ($dayofweek) {
            case 0:
                $dayofweek = "Domingo";
                break;
            case 1:
                $dayofweek = "Lunes";
                break;
            case 2:
                $dayofweek = "Martes";
                break;
            case 3:
                $dayofweek = "Miercoles";
                break;
            case 4:
                $dayofweek = "Jueves";
                break;
            case 5:
                $dayofweek = "Viernes";
                break;
            case 6:
                $dayofweek = "Sabado";
                break;
        }

        $aspirante[0]->NOMBRE_DIA = $dayofweek;

        $dia = $aspirante[0]->DIA;
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $fecha = DateTime::createFromFormat('!m', substr($dia, 5, 2));
        $mes = strftime("%B", $fecha->getTimestamp()); // marzo
        $aspirante[0]->DIA = substr($dia, 8, 2) . " de " . $mes . " del " . substr($dia, 0, 4);
        $aspirante[0]->HORA = date("g:i a", strtotime($aspirante[0]->HORA));

        return $this->generarPDF($aspirante, 'aspirante.ficha');
    }

    public function generarPDF($aspirante, $plantilla)
    {
        $mpdf = new Mpdf(['orientation' => 'p']);

        $html_final = view($plantilla, ['ASPIRANTE' => $aspirante]);
        /*Fuenres*/
        /** @noinspection PhpLanguageLevelInspection */
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        /** @noinspection PhpLanguageLevelInspection */
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '/custom/font/directory',
            ]),
            'fontdata' => $fontData + [
                    'montserrat' => [
                        'R' => 'Montserrat-Medium.ttf',
                        'B' => 'Montserrat-ExtraBold.ttf',
                    ]
                ],
            'default_font' => 'montserrat'
        ]);

        /* $path = public_path() . '/img/marca_agua.jpg';
        \Log::debug($path);
        $mpdf->SetDefaultBodyCSS('background', "url('".$path."')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6); */

        $mpdf->WriteHTML($html_final);
        return $mpdf->Output();
    }

    public function descargarReferenciaCurso($id)
    {
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO','CAT_USUARIO.PK_USUARIO','=','CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                DB::raw("CAT_USUARIO.NOMBRE + ' ' + CAT_USUARIO.PRIMER_APELLIDO + ' ' + CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as NOMBRE"),
                DB::raw("'' as REFERENCIA"),
                DB::raw("'' as FECHA_LIMITE_PAGO"),
                DB::raw("'' as CONSEPTO"),
                DB::raw("'' as CLAVE"),
                DB::raw("'' as MONTO")
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
            ->where([
                ['CAT_USUARIO.PK_ENCRIPTADA', '=', $id],
                ['CAT_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
            ])
            ->get();

        $PK_PERIODO_PREFICHAS = DB::table('CAT_PERIODO_PREFICHAS')->max('PK_PERIODO_PREFICHAS');

        $periodo = DB::table('CAT_PERIODO_PREFICHAS')->select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO_CURSO', 'FECHA_FIN_CURSO', 'MONTO_CURSO')
            ->where('PK_PERIODO_PREFICHAS', $PK_PERIODO_PREFICHAS)
            ->get();

        $fecha = date('Y-m-j');
        $fechaFin = strtotime($periodo[0]->FECHA_FIN_CURSO);
        $nuevafecha = strtotime('+3 day', strtotime($fecha));
        if ($nuevafecha > $fechaFin) {
            $nuevafecha = strtotime('+2 day', strtotime($fecha));
            if ($nuevafecha > $fechaFin) {
                $nuevafecha = strtotime('+1 day', strtotime($fecha));
                if ($nuevafecha > $fechaFin) {
                    $nuevafecha = strtotime('+0 day', strtotime($fecha));
                    if ($nuevafecha > $fechaFin) {
                        $nuevafecha = $fechaFin;
                    }
                }
            }
        }

        $fechaLimitePago = date('Y-m-j', $nuevafecha);

        $datosReferencia =
            [
                'tipo_persona' => '0',
                'control' => $aspirante[0]->PREFICHA,
                'servicio' => '004',
                'valorvariable' => '2',
                'monto' => $periodo[0]->MONTO_CURSO,
                'yearC' => date('Y', strtotime($fechaLimitePago)),
                'mesC' => date('m', strtotime($fechaLimitePago)),
                'diaC' => date('j', strtotime($fechaLimitePago)),
            ];

        $aspirante[0]->REFERENCIA = $this->RUTINA8250POSICIONES($datosReferencia);
        $aspirante[0]->FECHA_LIMITE_PAGO = $fechaLimitePago;
        $aspirante[0]->CONCEPTO = "Referencia de pago para curso de nivelación";
        $aspirante[0]->CLAVE = DB::table('CAT_INSTITUCION')->select('CLAVE_CIE')->where('ALIAS', 'ITL')->get()[0]->CLAVE_CIE;
        $aspirante[0]->MONTO = $datosReferencia['monto'];
        $fk_aspirante = DB::table('CAT_INSTITUCION')->where('ALIAS', 'ITL');
        return $this->generarPDF($aspirante, 'aspirante.referencia');
    }

    public function descargarReferenciaInscripcion($id)
    {
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO','CAT_USUARIO.PK_USUARIO','=','CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                DB::raw("CAT_USUARIO.NOMBRE + ' ' + CAT_USUARIO.PRIMER_APELLIDO + ' ' + CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as NOMBRE"),
                DB::raw("'' as REFERENCIA"),
                DB::raw("'' as FECHA_LIMITE_PAGO"),
                DB::raw("'' as CONSEPTO"),
                DB::raw("'' as CLAVE"),
                DB::raw("'' as MONTO")
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
            ->where([
                ['CAT_USUARIO.PK_ENCRIPTADA', '=', $id],
                ['CAT_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
            ])
            ->get();

        $PK_PERIODO_PREFICHAS = DB::table('CAT_PERIODO_PREFICHAS')->max('PK_PERIODO_PREFICHAS');

        $periodo = DB::table('CAT_PERIODO_PREFICHAS')->select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO_INSCRIPCION', 'FECHA_FIN_INSCRIPCION', 'MONTO_INSCRIPCION')
            ->where('PK_PERIODO_PREFICHAS', $PK_PERIODO_PREFICHAS)
            ->get();

        $fecha = date('Y-m-j');
        $fechaFin = strtotime($periodo[0]->FECHA_FIN_INSCRIPCION);
        $nuevafecha = strtotime('+3 day', strtotime($fecha));
        if ($nuevafecha > $fechaFin) {
            $nuevafecha = strtotime('+2 day', strtotime($fecha));
            if ($nuevafecha > $fechaFin) {
                $nuevafecha = strtotime('+1 day', strtotime($fecha));
                if ($nuevafecha > $fechaFin) {
                    $nuevafecha = strtotime('+0 day', strtotime($fecha));
                    if ($nuevafecha > $fechaFin) {
                        $nuevafecha = $fechaFin;
                    }
                }
            }
        }

        $fechaLimitePago = date('Y-m-j', $nuevafecha);

        $datosReferencia =
            [
                'tipo_persona' => '0',
                'control' => $aspirante[0]->PREFICHA,
                'servicio' => '004',
                'valorvariable' => '2',
                'monto' => $periodo[0]->MONTO_INSCRIPCION,
                'yearC' => date('Y', strtotime($fechaLimitePago)),
                'mesC' => date('m', strtotime($fechaLimitePago)),
                'diaC' => date('j', strtotime($fechaLimitePago)),
            ];

        $aspirante[0]->REFERENCIA = $this->RUTINA8250POSICIONES($datosReferencia);
        $aspirante[0]->FECHA_LIMITE_PAGO = $fechaLimitePago;
        $aspirante[0]->CONCEPTO = "Referencia de pago para inscripción";
        $aspirante[0]->CLAVE = DB::table('CAT_INSTITUCION')->select('CLAVE_CIE')->where('ALIAS', 'ITL')->get()[0]->CLAVE_CIE;
        $aspirante[0]->MONTO = $datosReferencia['monto'];
        $fk_aspirante = DB::table('CAT_INSTITUCION')->where('ALIAS', 'ITL');
        return $this->generarPDF($aspirante, 'aspirante.referencia');
    }

    public function descargarReferenciaInscripcionCero($id)
    {
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO','CAT_USUARIO.PK_USUARIO','=','CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                DB::raw("CAT_USUARIO.NOMBRE + ' ' + CAT_USUARIO.PRIMER_APELLIDO + ' ' + CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as NOMBRE"),
                DB::raw("'' as REFERENCIA"),
                DB::raw("'' as FECHA_LIMITE_PAGO"),
                DB::raw("'' as CONSEPTO"),
                DB::raw("'' as CLAVE"),
                DB::raw("'' as MONTO")
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
            ->where([
                ['CAT_USUARIO.PK_ENCRIPTADA', '=', $id],
                ['CAT_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
            ])
            ->get();

        $PK_PERIODO_PREFICHAS = DB::table('CAT_PERIODO_PREFICHAS')->max('PK_PERIODO_PREFICHAS');

        $periodo = DB::table('CAT_PERIODO_PREFICHAS')->select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO_INSCRIPCION_BIS', 'FECHA_FIN_INSCRIPCION_BIS', 'MONTO_INSCRIPCION_BIS')
            ->where('PK_PERIODO_PREFICHAS', $PK_PERIODO_PREFICHAS)
            ->get();

        $fecha = date('Y-m-j');
        $fechaFin = strtotime($periodo[0]->FECHA_FIN_INSCRIPCION_BIS);
        $nuevafecha = strtotime('+3 day', strtotime($fecha));
        if ($nuevafecha > $fechaFin) {
            $nuevafecha = strtotime('+2 day', strtotime($fecha));
            if ($nuevafecha > $fechaFin) {
                $nuevafecha = strtotime('+1 day', strtotime($fecha));
                if ($nuevafecha > $fechaFin) {
                    $nuevafecha = strtotime('+0 day', strtotime($fecha));
                    if ($nuevafecha > $fechaFin) {
                        $nuevafecha = $fechaFin;
                    }
                }
            }
        }

        $fechaLimitePago = date('Y-m-j', $nuevafecha);

        $datosReferencia =
            [
                'tipo_persona' => '0',
                'control' => $aspirante[0]->PREFICHA,
                'servicio' => '004',
                'valorvariable' => '2',
                'monto' => $periodo[0]->MONTO_INSCRIPCION_BIS,
                'yearC' => date('Y', strtotime($fechaLimitePago)),
                'mesC' => date('m', strtotime($fechaLimitePago)),
                'diaC' => date('j', strtotime($fechaLimitePago)),
            ];

        $aspirante[0]->REFERENCIA = $this->RUTINA8250POSICIONES($datosReferencia);
        $aspirante[0]->FECHA_LIMITE_PAGO = $fechaLimitePago;
        $aspirante[0]->CONCEPTO = "Referencia de pago para inscripción semestre cero";
        $aspirante[0]->CLAVE = DB::table('CAT_INSTITUCION')->select('CLAVE_CIE')->where('ALIAS', 'ITL')->get()[0]->CLAVE_CIE;
        $aspirante[0]->MONTO = $datosReferencia['monto'];
        $fk_aspirante = DB::table('CAT_INSTITUCION')->where('ALIAS', 'ITL');
        return $this->generarPDF($aspirante, 'aspirante.referencia');
    }
}
