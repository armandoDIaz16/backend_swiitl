<?php

namespace App\Http\Controllers;

use App\ActaResidencias;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ActaResidenciasController extends Controller
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
        $acta = new ActaResidencias();
        $info = $acta->info($id);
        $mes = $acta->mes();
        $periodo = $acta->periodo();
        $carta = [];

        foreach ($info as $in) {
            $carta = array(
                'empresa' => $in->EMPRESA,
                'nombre' => $in->NOMBRE,
                'numero_control' => $in->NUMERO_CONTROL,
                'nombre_alumno' => $in->name,
                'primer_apellido' => $in->PRIMER_APELLIDO,
                'segundo_apellido' => $in->SEGUNDO_APELLIDO,
                'carrera' => $in->CARRERA,
                'calificacion' => $in->CALIFICACION,
                'observaciones' => $in->OBSERVACIONES,
                'nombremaestro' => $in->NOMBREMAESTRO,
                'pamaestro' => $in->PAMAESTRO,
                'samaestro' => $in->SAMAESTRO,
                'nombreexterno' => $in->NOMBREEXTERNO,
                'paexterno' => $in->PAEXTERNO,
                'saexterno' => $in->SAEXTERNO,
                'folio' => $in->FOLIO_ASIGNADO
            );
        }

        $mpdf = new Mpdf(['orientation' => 'p']);



        $data = array(
            'carta' => ($carta),
            'mes' => $mes,
            'periodo' => $periodo
        );

        $html_final = view('constancias.actacrp', $data);
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
