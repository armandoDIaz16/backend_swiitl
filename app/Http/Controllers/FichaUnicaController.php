<?php

namespace App\Http\Controllers;

use App\FichaUnica;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class FichaUnicaController extends Controller
{

    public function FUApdf($id){
        $pdf = new FichaUnica();
        $proyectos = $pdf->proyectos($id);
        $jefe = $pdf->jefe($id);
        $alumno = [];
        foreach ($proyectos as $po){
            $x = json_decode(json_encode($po),true);
            $y = array_pop($x);
            $alumnos = $pdf->alumnos($id,$y);
            foreach ($alumnos as $al){
                $alumno[] = array(
                    'Nombre' => $al->name,
                    'Carrera' => $al->NOMBRE,
                    'Numero' => $al->NUMERO_CONTROL,
                    'CorreoA' => $al->email,
                    'Proyecto' => $al->Proyecto,
                    'Empresa' => $al->Empresa,
                    'NombreDocente' => $al->NombreDocente,
                    'CorreoDocente' => $al->CorreoDocente,
                    'NombreExterno' => $al->NombreExterno,
                    'CorreoExterno' => $al->CorreoExterno
                );
            }
        }


        $mpdf = new Mpdf(['orientation' => 'p']);

        $data = array(
            'alumnoss' => ($alumno),
            'jefe' => $jefe
        );

        $html_final = view('constancias.fichaunica', $data);
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
