<?php

namespace App\Http\Controllers;

use App\ConvenioContrato;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ConvenioContratoController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $convenio = new ConvenioContrato();
        $info = $convenio->Informacion($id);
        $mes = $convenio->mes();
        $mes2 = $convenio->mes2();
        $empresa = [];

        foreach ($info as $in) {
            $empresa = array(
                'NombreEmpresa' => $in->NOMBRE_EMPRESA,
                'NombreRepresentante' => $in->NOMBRE_REPRESENTANTE,
                'ActaConstitutiva' => $in->NO_ACTA_CONSTITUTIVA,
                'FechaFirma' => $in->FECHA_FIRMA,
                'NombreNotario' => $in->NOMBRE_NOTARIO,
                'NoNotaria' => $in->NO_NOTARIA,
                'EntidadFederativa' => $in->ENTIDAD_FEDERATIVA,
                'FechaRegistroE' => $in->FECHA_REGISTRO_E,
                'FolioMercantil' => $in->FOLIO_MERCANTIL,
                'NoVolumen' => $in->NO_VOLUMEN,
                'ObjetoSocial' => $in->OBJETO_SOCIAL,
                'NoEscritura' => $in->NO_ESCRITURA,
                'FechaNotario' => $in->FECHA_NOTARIO,
                'NombreNotarioNotario' => $in->NOMBRE_NOTARIO_NOTARIO,
                'NoNotariaNotario' => $in->NO_NOTARIA_NOTARIO,
                'EntidadFederativaNotario' => $in->ENTIDAD_FEDERATIVA_NOTARIO,
                'NoRFC' => $in->NO_RFC,
                'DirEmpresa' => $in->DIR_EMPRESA,
                'NombreTestigo' => $in->NOMBRE_TESTIGO,
                'Logo' => public_path().'/'.$in->LOGO_EMPRESA
            );
        }

        $mpdf = new Mpdf(['orientation' => 'p']);


        $imagen = public_path().'/files/Escudo-ITL.jpg';

        $data = array(
            'empresa' => ($empresa),
            'mes' => $mes,
            'mes2' => $mes2
        );

        $html_final = view('constancias.convenio', $data);
        /*Fuentes*/
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

        $path = public_path() . '/img/pagtec.jpg';
        \Log::debug($path);
        $mpdf->SetDefaultBodyCSS('background', "url('".$path."')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

        $mpdf->WriteHTML($html_final);
        return $mpdf->Output();
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
