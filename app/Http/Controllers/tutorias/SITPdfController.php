<?php

namespace App\Http\Controllers\tutorias;

use App\Helpers\Constantes;
use App\Helpers\SiiaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function get_pdf_perfil_grupal_ingreso(Request $request)
    {
        if ($request->grupo) {
            $mpdf = new Mpdf(['orientation' => 'p']);

            $data_reporte['data'] = $this->get_datos_perfil_grupal($request->grupo);

            $html_final = view('tutorias.perfil_grupal_ingreso', $data_reporte);
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
        } else {
            return false;
        }
    }

    private function get_datos_perfil_grupal($pk_grupo) {
        $data = [];

        $datos_grupo = $this->get_tutor_grupo($pk_grupo);
        $data['tutor']            = $datos_grupo->NOMBRE .' '. $datos_grupo->PRIMER_APELLIDO .' '. $datos_grupo->SEGUNDO_APELLIDO;
        $data['grupo']            = $datos_grupo->CLAVE;
        $data['cantidad_alumnos'] = $this->get_cantidad_alumnos_grupo($pk_grupo);
        $data['carrera'] = $this->get_carrera_grupo($pk_grupo);

        return $data;
    }

    /**
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function get_pdf_perfil_personal_ingreso(Request $request)
    {
        $mpdf = new Mpdf(['orientation' => 'p']);
        $mpdf->use_kwt = true;

        $data_reporte['data'] = $this->get_datos_perfil_personal($request->grupo);

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

    private function get_datos_perfil_personal($pk_usuario) {
        $data = [];

        $datos_grupo = $this->get_tutor_grupo($pk_usuario);
        $data['tutor']            = $datos_grupo->NOMBRE .' '. $datos_grupo->PRIMER_APELLIDO .' '. $datos_grupo->SEGUNDO_APELLIDO;
        $data['grupo']            = $datos_grupo->CLAVE;
        $data['cantidad_alumnos'] = $this->get_cantidad_alumnos_grupo($pk_usuario);
        $data['carrera'] = $this->get_carrera_grupo($pk_usuario);

        return $data;
    }

    private function get_carrera_grupo($pk_grupo) {
        $sql = "
        SELECT
            CAT_CARRERA.NOMBRE AS CARRERA
        FROM
            CAT_USUARIO
            LEFT JOIN CAT_CARRERA ON CAT_USUARIO.FK_CARRERA = CAT_CARRERA.PK_CARRERA
        WHERE
            PK_USUARIO = (
                SELECT TOP 1 
                    FK_USUARIO 
                FROM 
                     TR_GRUPO_TUTORIA_DETALLE
                )
        ;";

        $result = DB::select($sql)[0];

        return $result->CARRERA;
    }

    private function get_cantidad_alumnos_grupo($pk_grupo) {
        $sql = "
        SELECT
            COUNT(*) AS CANTIDAD
        FROM
            TR_GRUPO_TUTORIA_DETALLE
        WHERE 
              FK_GRUPO = $pk_grupo
        ;";

        $result = DB::select($sql)[0];

        return $result->CANTIDAD;
    }

    private function get_tutor_grupo($pk_grupo) {
        $sql = "
        SELECT
            TR_GRUPO_TUTORIA.CLAVE,
            NOMBRE,
            PRIMER_APELLIDO,
            SEGUNDO_APELLIDO
        FROM
            TR_GRUPO_TUTORIA
            LEFT JOIN CAT_USUARIO ON TR_GRUPO_TUTORIA.FK_USUARIO = CAT_USUARIO.PK_USUARIO
        WHERE 
              PK_GRUPO_TUTORIA = $pk_grupo
              AND PERIODO = '".Constantes::get_periodo()."'
        ;";

        return DB::select($sql)[0];
    }
}
