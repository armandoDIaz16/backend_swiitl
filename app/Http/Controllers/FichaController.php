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

        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=', 'CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
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
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=', 'CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
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
                'CAT_TURNO_ESCRITO.DIA as DIA2',
                'CAT_TURNO_ESCRITO.DIA as NOMBRE_DIA2',
                'CAT_TURNO_ESCRITO.HORA as HORA2',
                'CAT_TURNO_INGLES.DIA as DIA_INGLES',
                'CAT_TURNO_INGLES.DIA as NOMBRE_DIA_INGLES',
                'CAT_TURNO_INGLES.HORA as HORA_INGLES',
                'CATR_EDIFICIO.NOMBRE as NOMBRE_EDIFICIO',
                'CATR_EDIFICIO.PREFIJO',
                'CATR_EDIFICIO_ESCRITO.NOMBRE as NOMBRE_EDIFICIO2',
                'CATR_EDIFICIO_ESCRITO.PREFIJO as PREFIJO2',
                'CATR_EDIFICIO_INGLES.NOMBRE as NOMBRE_EDIFICIO_INGLES',
                'CATR_EDIFICIO_INGLES.PREFIJO as PREFIJO_INGLES',
                'CAT_CAMPUS.NOMBRE as NOMBRE_CAMPUS',
                'CAT_CAMPUS_LINEA.NOMBRE as NOMBRE_CAMPUS_LINEA',
                'CAT_CAMPUS_ESCRITO.NOMBRE as NOMBRE_CAMPUS_ESCRITO',
                'CAT_CAMPUS_INGLES.NOMBRE as NOMBRE_CAMPUS_INGLES',
                'CATR_ESPACIO.NOMBRE as NOMBRE_ESPACIO',
                'CATR_ESPACIO_INGLES.NOMBRE as NOMBRE_ESPACIO_INGLES',
                'CATR_ESPACIO_INGLES.IDENTIFICADOR as IDENTIFICADOR_INGLES',
                'CAT_ASPIRANTE.FECHA_MODIFICACION',
                'CAT_PERIODO_PREFICHAS.TIPO_APLICACION',
                DB::raw("'' as MENSAJE")
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')

            ->leftJoin('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CAT_ASPIRANTE.FK_EXAMEN_ADMISION')
            ->leftJoin('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
            ->leftJoin('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
            ->leftJoin('CATR_EDIFICIO', 'CATR_EDIFICIO.PK_EDIFICIO', '=', 'CATR_ESPACIO.FK_EDIFICIO')

            ->leftJoin('CATR_EXAMEN_ADMISION_ESCRITO', 'CATR_EXAMEN_ADMISION_ESCRITO.PK_EXAMEN_ADMISION_ESCRITO', '=', 'CAT_ASPIRANTE.FK_EXAMEN_ADMISION_ESCRITO')
            ->leftJoin('CAT_TURNO_ESCRITO as CAT_TURNO_ESCRITO', 'CAT_TURNO_ESCRITO.PK_TURNO_ESCRITO', '=', 'CATR_EXAMEN_ADMISION_ESCRITO.FK_TURNO_ESCRITO')
            ->leftJoin('CATR_EDIFICIO as CATR_EDIFICIO_ESCRITO', 'CATR_EDIFICIO_ESCRITO.PK_EDIFICIO', '=', 'CATR_EXAMEN_ADMISION_ESCRITO.FK_EDIFICIO')

            ->leftJoin('CATR_EXAMEN_ADMISION_INGLES', 'CATR_EXAMEN_ADMISION_INGLES.PK_EXAMEN_ADMISION_INGLES', '=', 'CAT_ASPIRANTE.FK_EXAMEN_INGLES')
            ->leftJoin('CAT_TURNO_INGLES as CAT_TURNO_INGLES', 'CAT_TURNO_INGLES.PK_TURNO_INGLES', '=', 'CATR_EXAMEN_ADMISION_INGLES.FK_TURNO_INGLES')
            ->leftJoin('CATR_ESPACIO_INGLES as CATR_ESPACIO_INGLES', 'CATR_ESPACIO_INGLES.PK_ESPACIO_INGLES', '=', 'CATR_EXAMEN_ADMISION_INGLES.FK_ESPACIO_INGLES')
            ->leftJoin('CATR_EDIFICIO as CATR_EDIFICIO_INGLES', 'CATR_EDIFICIO_INGLES.PK_EDIFICIO', '=', 'CATR_ESPACIO_INGLES.FK_EDIFICIO')

            ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.FK_CARRERA', '=', 'CAT_ASPIRANTE.FK_CARRERA_1')
            ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=', 'TR_CARRERA_CAMPUS.FK_CAMPUS')
            ->join('CAT_CAMPUS AS CAT_CAMPUS_LINEA', 'CAT_CAMPUS_LINEA.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS')
            ->join('CAT_CAMPUS AS CAT_CAMPUS_ESCRITO', 'CAT_CAMPUS_ESCRITO.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS')
            ->join('CAT_CAMPUS AS CAT_CAMPUS_INGLES', 'CAT_CAMPUS_INGLES.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS')
            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=', 'TR_CARRERA_CAMPUS.FK_CARRERA')
            ->join('CAT_PERIODO_PREFICHAS', 'CAT_PERIODO_PREFICHAS.PK_PERIODO_PREFICHAS', '=', 'CAT_ASPIRANTE.FK_PERIODO')
            ->where([
                ['CAT_USUARIO.PK_ENCRIPTADA', '=', $id],
                ['CAT_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante]
            ])
            ->get();

        if ($aspirante[0]->TIPO_APLICACION == 1) {
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
            $aspirante[0]->MENSAJE = "
            Debes presentarte en el " . $aspirante[0]->NOMBRE_EDIFICIO . "(Edificio " . $aspirante[0]->PREFIJO . ")
            del Instituto Tecnológico de León Campus " . $aspirante[0]->NOMBRE_CAMPUS_LINEA . ",
            en el espacio " . '"' . $aspirante[0]->NOMBRE_ESPACIO . '"' . ",
            el día " . $aspirante[0]->NOMBRE_DIA . " " . $aspirante[0]->DIA . " a las " . $aspirante[0]->HORA;
        } else {
            $fecha = $aspirante[0]->FECHA_MODIFICACION;
            $aspirante[0]->FECHA_MODIFICACION = substr($fecha, 8, 2) . "/" . substr($fecha, 5, 2) . "/" . substr($fecha, 0, 4);


            $dayofweek = date('w', strtotime($aspirante[0]->NOMBRE_DIA2));
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

            $aspirante[0]->NOMBRE_DIA2 = $dayofweek;
            $aspirante[0]->NOMBRE_EDIFICIO2 = $aspirante[0]->NOMBRE_EDIFICIO2;
            $aspirante[0]->PREFIJO2 = $aspirante[0]->PREFIJO2;
            $dia = $aspirante[0]->DIA2;
            setlocale(LC_TIME, 'es_ES.UTF-8');
            $fecha = DateTime::createFromFormat('!m', substr($dia, 5, 2));
            $mes = strftime("%B", $fecha->getTimestamp()); // marzo
            $aspirante[0]->DIA2 = substr($dia, 8, 2) . " de " . $mes . " del " . substr($dia, 0, 4);
            $aspirante[0]->HORA2 = date("g:i a", strtotime($aspirante[0]->HORA2));
            $aspirante[0]->MENSAJE = "
            Debes presentarte en el " . $aspirante[0]->NOMBRE_EDIFICIO2 . "(Edificio " . $aspirante[0]->PREFIJO2 . ")
            del Instituto Tecnológico de León Campus " . $aspirante[0]->NOMBRE_CAMPUS_ESCRITO . ",
            el día " . $aspirante[0]->NOMBRE_DIA2 . " " . $aspirante[0]->DIA2 . " a las " . $aspirante[0]->HORA2;
        }

        $dayofweek = date('w', strtotime($aspirante[0]->NOMBRE_DIA_INGLES));
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

            $aspirante[0]->NOMBRE_DIA_INGLES = $dayofweek;

            $dia = $aspirante[0]->DIA_INGLES;
            setlocale(LC_TIME, 'es_ES.UTF-8');
            $fecha = DateTime::createFromFormat('!m', substr($dia, 5, 2));
            $mes = strftime("%B", $fecha->getTimestamp()); // marzo
            $aspirante[0]->DIA_INGLES = substr($dia, 8, 2) . " de " . $mes . " del " . substr($dia, 0, 4);
            $aspirante[0]->HORA_INGLES = date("g:i a", strtotime($aspirante[0]->HORA_INGLES));
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
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=', 'CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
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
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=', 'CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
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
        $fk_aspirante = DB::table('CAT_ASPIRANTE')->join('CAT_USUARIO', 'CAT_USUARIO.PK_USUARIO', '=', 'CAT_ASPIRANTE.FK_PADRE')->where('PK_ENCRIPTADA', $id)->max('PK_ASPIRANTE');
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
