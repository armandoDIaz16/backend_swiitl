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

        $fk_aspirante = DB::table('CATR_ASPIRANTE')->where('FK_PADRE', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('users')
            ->select(
                DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
                DB::raw("users.name + ' ' + users.PRIMER_APELLIDO + ' ' + CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as NOMBRE"),
                DB::raw("'' as REFERENCIA"),
                DB::raw("'' as FECHA_LIMITE_PAGO"),
                DB::raw("'' as CLAVE"),
                DB::raw("'' as MONTO")
                )
            ->join('CATR_ASPIRANTE', 'CATR_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
            ->where([
                ['users.PK_USUARIO', '=', $id],
                ['CATR_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante],
            ])
            ->get();

        $PK_PERIODO_PREFICHAS = DB::table('CAT_PERIODO_PREFICHAS')->max('PK_PERIODO_PREFICHAS');

        $periodo = DB::table('CAT_PERIODO_PREFICHAS')->select('PK_PERIODO_PREFICHAS','FECHA_INICIO','FECHA_FIN')
        ->where('PK_PERIODO_PREFICHAS',$PK_PERIODO_PREFICHAS)
        ->get();

        $fecha = date('Y-m-j');
        $fechaFin = strtotime($periodo[0]->FECHA_FIN);        
        $nuevafecha = strtotime('+3 day', strtotime($fecha));
        if($nuevafecha > $fechaFin){         
            $nuevafecha = strtotime('+2 day', strtotime($fecha));   
            if($nuevafecha > $fechaFin){
                $nuevafecha = strtotime('+1 day', strtotime($fecha)); 
                if($nuevafecha > $fechaFin){ 
                    $nuevafecha = strtotime('+0 day', strtotime($fecha)); 
                    if($nuevafecha > $fechaFin){
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
                'monto' => '1600',
                'yearC' => date('Y', strtotime($fechaLimitePago)),
                'mesC' => date('m', strtotime($fechaLimitePago)),
                'diaC' => date('j', strtotime($fechaLimitePago)),
            ];

        $aspirante[0]->REFERENCIA = $this->RUTINA8250POSICIONES($datosReferencia);
        $aspirante[0]->FECHA_LIMITE_PAGO = $fechaLimitePago;
        $aspirante[0]->CLAVE = 1369296;
        $aspirante[0]->MONTO = $datosReferencia['monto'];

        return $this->generarPDF($aspirante,'aspirante.referencia'); 

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
        $fk_aspirante = DB::table('CATR_ASPIRANTE')->where('FK_PADRE', $id)->max('PK_ASPIRANTE');
        $aspirante = DB::table('users')
        ->select(
            DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
            'CATR_CARRERA.NOMBRE as NOMBRE_CARRERA',
            'CATR_CARRERA.CAMPUS',
            'CATR_ASPIRANTE.FOLIO_CENEVAL',
            'users.name as NOMBRE',
            'users.PRIMER_APELLIDO',
            DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO"),
            'CAT_TURNO.DIA',
            'CAT_TURNO.DIA as NOMBRE_DIA',
            'CAT_TURNO.HORA',
            'CATR_EDIFICIO.NOMBRE as NOMBRE_EDIFICIO',
            'CATR_EDIFICIO.PREFIJO',
            'CAT_CAMPUS.NOMBRE as NOMBRE_CAMPUS',
            'CATR_ESPACIO.NOMBRE as NOMBRE_ESPACIO',
            'CATR_ASPIRANTE.FECHA_MODIFICACION'
        )
        ->join('CATR_ASPIRANTE', 'CATR_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
        ->join('CATR_CARRERA', 'CATR_CARRERA.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_1')
        ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CATR_ASPIRANTE.FK_EXAMEN_ADMISION')
        ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
        ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
        ->join('CATR_EDIFICIO', 'CATR_EDIFICIO.PK_EDIFICIO', '=', 'CATR_ESPACIO.FK_EDIFICIO')
        ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS')
        ->where([
            ['users.PK_USUARIO', '=', $id],
            ['CATR_ASPIRANTE.PK_ASPIRANTE', '=', $fk_aspirante]
        ])
        ->get();
        $fecha=$aspirante[0]->FECHA_MODIFICACION;
        $aspirante[0]->FECHA_MODIFICACION = substr($fecha, 8, 2)."/" .substr($fecha, 5, 2). "/".substr($fecha, 0, 4);

        
        $dayofweek = date('w', strtotime($aspirante[0]->NOMBRE_DIA));
        switch ($dayofweek){
                case 0: $dayofweek ="Domingo"; break; 
                case 1: $dayofweek ="Lunes"; break; 
                case 2: $dayofweek ="Martes"; break; 
                case 3: $dayofweek ="Miercoles"; break; 
                case 4: $dayofweek ="Jueves"; break; 
                case 5: $dayofweek ="Viernes"; break; 
                case 6: $dayofweek ="Sabado"; break; 
        }

        $aspirante[0]->NOMBRE_DIA = $dayofweek;

        $dia=$aspirante[0]->DIA;        
        setlocale(LC_TIME, 'es_ES.UTF-8');
        $fecha = DateTime::createFromFormat('!m', substr($dia, 5, 2));
        $mes = strftime("%B", $fecha->getTimestamp()); // marzo
        $aspirante[0]->DIA = substr($dia, 8, 2). " de " . $mes . " del " . substr($dia, 0, 4);
        $aspirante[0]->HORA = date("g:i a",strtotime($aspirante[0]->HORA));

        return $this->generarPDF($aspirante,'aspirante.ficha'); 
    }

    public function generarPDF($aspirante,$plantilla){
        $mpdf = new Mpdf(['orientation' => 'p']);

        $html_final = view($plantilla,['ASPIRANTE' => $aspirante]);
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
}

