<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use DateTime;

class PAEEPDF extends Controller
{
    public function complementaria(Request $request)
    {

      /*   $motivos = DB::table('TR_ASESORIA_MOTIVO')
        ->select('CAT_MOTIVO_ASESORIA_ACADEMICA.NOMBRE')
        ->distinct()
        ->join('CAT_MOTIVO_ASESORIA_ACADEMICA', 'CAT_MOTIVO_ASESORIA_ACADEMICA.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
        ->where([['TR_ASESORIA_MOTIVO.MATERIA_APOYO1','ADMINISTRACIÓN DE LA CALIDAD']])
        ->get(); */
   
        /* select CAT_MOTIVO_ASESORIA_ACADEMICA.NOMBRE  from TR_ASESORIA_MOTIVO
JOIN CAT_MOTIVO_ASESORIA_ACADEMICA ON
 CAT_MOTIVO_ASESORIA_ACADEMICA.PK_MOTIVO_ASESORIA_ACADEMICA 
 = TR_ASESORIA_MOTIVO.FK_MOTIVO  
 where TR_ASESORIA_MOTIVO.MATERIA_APOYO1 = 'ADMINISTRACIÓN DE LA CALIDAD' */

        $aspirante = DB::table('TR_ASESORIA_MOTIVO')
            ->select(
                DB::raw("'' as DESTINATARIO"),
                DB::raw("'' as SUSCRIBE"),
                DB::raw("'' as ESTUDIANTE"),
                DB::raw("'' as CONTROL"),
                DB::raw("'' as CARRERA"),
                DB::raw("'' as ACTIVIDAD"),
                DB::raw("'' as DESEMPENO"),
                DB::raw("'' as VALOR"),
                DB::raw("'' as PERIODO"),
                DB::raw("'' as EXTIENDE"),
                DB::raw("'' as NOMBRE1"),
                DB::raw("'' as CARGO1"),
                DB::raw("'' as NOMBRE2"),
                DB::raw("'' as CARGO2")


                
                )
            ->get();

            $aspirante[0]->DESTINATARIO = $request->destinatario;
            $aspirante[0]->SUSCRIBE = $request->suscribe;
            $aspirante[0]->ESTUDIANTE = $request->estudiante;
            $aspirante[0]->CONTROL = $request->control;
            $aspirante[0]->CARRERA = $request->carrera;
            $aspirante[0]->ACTIVIDAD = $request->actividad;
            $aspirante[0]->DESEMPENO = $request->desempeno;
            $aspirante[0]->VALOR = $request->valor;
            $aspirante[0]->PERIODO = $request->periodo;
            $aspirante[0]->EXTIENDE = $request->extiende;
            $aspirante[0]->NOMBRE1 = $request->nombre1;
            $aspirante[0]->CARGO1 = $request->cargo1;
            $aspirante[0]->NOMBRE2 = $request->nombre2;
            $aspirante[0]->CARGO2 = $request->cargo2;
            //$aspirante[0]->MOTIVO2 = $motivos[9]->NOMBRE;
            
        return $this->generarPDF($aspirante,'asesoria.complementaria'); 

    }

    public function servicio(Request $request)
    {

      /*   $motivos = DB::table('TR_ASESORIA_MOTIVO')
        ->select('CAT_MOTIVO_ASESORIA_ACADEMICA.NOMBRE')
        ->distinct()
        ->join('CAT_MOTIVO_ASESORIA_ACADEMICA', 'CAT_MOTIVO_ASESORIA_ACADEMICA.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
        ->where([['TR_ASESORIA_MOTIVO.MATERIA_APOYO1','ADMINISTRACIÓN DE LA CALIDAD']])
        ->get(); */
   
        /* select CAT_MOTIVO_ASESORIA_ACADEMICA.NOMBRE  from TR_ASESORIA_MOTIVO
JOIN CAT_MOTIVO_ASESORIA_ACADEMICA ON
 CAT_MOTIVO_ASESORIA_ACADEMICA.PK_MOTIVO_ASESORIA_ACADEMICA 
 = TR_ASESORIA_MOTIVO.FK_MOTIVO  
 where TR_ASESORIA_MOTIVO.MATERIA_APOYO1 = 'ADMINISTRACIÓN DE LA CALIDAD' */

        $aspirante = DB::table('TR_ASESORIA_MOTIVO')
            ->select(
                DB::raw("'' as FECHA"),
                DB::raw("'' as OFICIO"),
                DB::raw("'' as ASUNTO"),
                DB::raw("'' as DIRECTOR"),
                DB::raw("'' as ATENCION"),
                DB::raw("'' as PRESTADOR"),
                DB::raw("'' as CARRERASER"),
                DB::raw("'' as CONTROLSER"),
                DB::raw("'' as PERIODOSER"),
                DB::raw("'' as CARACTER"),
                DB::raw("'' as DIASMES"),
                DB::raw("'' as ATENTAMENTE")

                
                )
            ->get();
            $hoy = getdate();
        $year = $hoy['year'];
        $month = $hoy['mon'];
        $day = $hoy['mday'];

        $fecha = $day.'/'.$month.'/'.$year;

            $aspirante[0]->FECHA = $fecha;
            $aspirante[0]->OFICIO = $request->oficio;
            $aspirante[0]->ASUNTO = $request->asunto;
            $aspirante[0]->DIRECTOR = $request->director;
            $aspirante[0]->ATENCION = $request->atencion;
            $aspirante[0]->PRESTADOR = $request->prestador;
            $aspirante[0]->CARRERASER = $request->carreraSer;
            $aspirante[0]->CONTROLSER = $request->controlSer;
            $aspirante[0]->PERIODOSER = $request->periodoSer;
            $aspirante[0]->CARACTER = $request->caracter;
            $aspirante[0]->DIASMES = $request->diasmes;
            $aspirante[0]->ATENTAMENTE = $request->atentamente;
            
        return $this->generarPDF($aspirante,'asesoria.servicio'); 

    }


    public function generarPDF($data,$plantilla){
        $mpdf = new Mpdf(['orientation' => 'p']);

        $html_final = view($plantilla,['DATA' => $data]);
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

        $path = public_path() . '/img/marca_agua.jpg';
        \Log::debug($path);
        $mpdf->SetDefaultBodyCSS('background', "url('".$path."')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

        $mpdf->WriteHTML($html_final);
        return $mpdf->Output();
    }
}

