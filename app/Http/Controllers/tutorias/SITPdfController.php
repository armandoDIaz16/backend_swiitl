<?php

namespace App\Http\Controllers\tutorias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

/**
 * Class SITPdfController
 * @package App\Http\Controllers\tutorias
 */
class SITPdfController extends Controller
{
    /**
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function get_pdf_perfil_grupal_ingreso()
    {
        $mpdf = new Mpdf(['orientation' => 'p']);

        $html_final = view('tutorias.perfil_grupal_ingreso');
        /* Fuentes */
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

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


        $mpdf->WriteHTML($html_final);
        return $mpdf->Output();
    }

    /**
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function get_pdf_perfil_personal_ingreso()
    {
        $mpdf = new Mpdf(['orientation' => 'p']);

        $html_final = view('tutorias.perfil_individual_ingreso');

        /* Fuentes */
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

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


        $mpdf->WriteHTML($html_final);
        return $mpdf->Output();
    }
}
