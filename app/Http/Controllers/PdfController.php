<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Mpdf\Mpdf;

class PdfController extends Controller{

    public function pdf(){

        $mpdf = new Mpdf(['orientation' => 'p']);//p=portrait || l=landscape

        $html_final = view('constancias.prueba');
        //$mpdf->WriteHTML('<h1>Hello world!</h1>');

        /*
         * Fuentes
         */

        $path = public_path() . '/img/marca_agua.jpg';
        \Log::debug($path);
        $mpdf->SetDefaultBodyCSS('background', "url('".$path."')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

        $mpdf->WriteHTML($html_final);
        $mpdf->Output();
    }
}
