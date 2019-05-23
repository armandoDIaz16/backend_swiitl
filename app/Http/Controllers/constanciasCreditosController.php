<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

use DB;

class constanciasCreditosController extends Controller
{
    public function generarConstancia($pk_alumno_credito){


        $mpdf = new Mpdf(['orientation' => 'p']);

        $datos = DB::table('ALUMNO_CREDITO as ac')
                ->join('users as u','ac.FK_ALUMNO','=','u.PK_USUARIO')
                ->join('LINEAMIENTOS as l','ac.FK_LINEAMIENTO','=','l.PK_LINEAMIENTO')
                ->select('ac.PK_ALUMNO_CREDITO', 'u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','l.NOMBRE','ac.CALIFICACION', 'ac.PERIODO')
                ->where('ac.PK_ALUMNO_CREDITO','=',$pk_alumno_credito)
                ->get()->first();

               /*  $response = Response::json($datos);
                return $response; */
        
                $html_final = view('constancias.creditosComplementarios',['DATOS'=>$datos]);
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
                $mpdf->Output(public_path().'/creditos-complementarios/constancias/constancias-oficiales/ConstanciaCreditos-folio-'.$datos->PK_ALUMNO_CREDITO.'.pdf','F');


                /*CONSTANCIA VERSION ALUMNOS */

                $html_final2 = view('constancias.creditosComplementarios',['DATOS'=>$datos]);
                /*Fuenres*/
                /** @noinspection PhpLanguageLevelInspection */
                $defaultConfig2 = (new \Mpdf\Config\ConfigVariables())->getDefaults();
                $fontDirs2 = $defaultConfig2['fontDir'];
        
                /** @noinspection PhpLanguageLevelInspection */
                $defaultFontConfig2 = (new \Mpdf\Config\FontVariables())->getDefaults();
                $fontData2 = $defaultFontConfig2['fontdata'];
        
                $mpdf2 = new Mpdf([
                    'fontDir' => array_merge($fontDirs2, [
                        __DIR__ . '/custom/font/directory',
                    ]),
                    'fontdata' => $fontData2 + [
                            'montserrat' => [
                                'R' => 'Montserrat-Medium.ttf',
                                'B' => 'Montserrat-ExtraBold.ttf',
                            ]
                        ],
                    'default_font' => 'montserrat'
                ]);
        
                $path2 = public_path() . '/img/marca_agua-vista-previa.jpeg';
                \Log::debug($path2);
                $mpdf2->SetDefaultBodyCSS('background', "url('".$path2."')");
                $mpdf2->SetDefaultBodyCSS('background-image-resize', 6);
        
                $mpdf2->WriteHTML($html_final2);
                $mpdf2->Output(public_path().'/creditos-complementarios/constancias/constancias-vista-previa/ConstanciaCreditos-preview-folio-'.$datos->PK_ALUMNO_CREDITO.'.pdf','F');


    }

    public function verConstanciaOficial($pk_alumno_credito){
        
        $ruta_archivo = public_path().'/creditos-complementarios/constancias/constancias-oficiales/ConstanciaCreditos-folio-'.$pk_alumno_credito.'.pdf';
 
        return Response::make(file_get_contents($ruta_archivo), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename= ConstanciaCreditos-folio-"'.$pk_alumno_credito.'".pdf'

]);
    }

    public function verConstanciaVistaPrevia($pk_alumno_credito){
        
        $ruta_archivo = public_path().'/creditos-complementarios/constancias/constancias-vista-previa/ConstanciaCreditos-preview-folio-'.$pk_alumno_credito.'.pdf';
 
        return Response::make(file_get_contents($ruta_archivo), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename= ConstanciaCreditos-folio-"'.$pk_alumno_credito.'".pdf'

]);
    }

    public function pruebaFormatoFecha(){/* 
         $fecha = Carbon::today()->format('j/F/Y H:i:s');
         return $fecha2 = Carbon::today()->format('j \d\e F \d\e\l Y'); */

         
      /*      $año_actual = Carbon::today()->format('Y');
           $fecha_actual = Carbon::today()->format('m-d');
           $inicio_año = Carbon::parse('01/01')->format('m-d');
           $medio_año = Carbon::parse("08/01")->format('m-d');

           if($fecha_actual > $inicio_año && $fecha_actual < $medio_año){
               $periodo = "Enero - Junio ".$año_actual;
           }else{
               $periodo = "Agosto - Diciembre".$año_actual;
           }

           echo $fecha_actual." --- ".$inicio_año."------".$medio_año;
           echo $periodo; */

           /* $fecha = Carbon::today()->format('j \d\e F \d\e\l Y');;
           $fecha2 = Carbon::today()->formatLocalized('%d de %B del %Y');

           echo $fecha." || ".$fecha2; */

        
         

    }

    public function getCarrera($pk_alumno_credito){
       /*  $datos = DB::table('SWIITL.ALUMNO_CREDITO as ac')
        ->join('SWIITL.users as u','ac.FK_ALUMNO','=','u.PK_USUARIO')
        ->join('SWIITL.LINEAMIENTOS as l','ac.FK_LINEAMIENTO','=','l.PK_LINEAMIENTO')
        ->join('ITL_SICH.view_alumnos as va','u.NUMERO_CONTROL','=','va.NumeroControl')
        ->join('ITL_SICH.view_carreras as vc','va.ClaveCarrera','=','vc.ClaveCarrera')
        ->select('ac.PK_ALUMNO_CREDITO', 'u.PRIMER_APELLIDO','u.SEGUNDO_APELLIDO','u.name','u.NUMERO_CONTROL','l.NOMBRE','ac.CALIFICACION', 'ac.PERIODO','vc.Nombre as CARRERA')
        ->where('ac.PK_ALUMNO_CREDITO','=',$pk_alumno_credito)
        ->get()->first(); */

        $carrera = DB::connection('sqlsrv2')->table('view_alumnos as va')
                    ->join('view_carreras as vc','va.ClaveCarrera','=','vc.ClaveCarrera')
                    ->select('vc.Nombre as CARRERA')
                    ->where('va.NUMEROCONTROL','=',$pk_alumno_credito)
                    ->get()->first();

        $response = Response::json($carrera);
        return $response;

    }
}
