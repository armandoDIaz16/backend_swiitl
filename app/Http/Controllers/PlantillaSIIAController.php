<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PlantillaSIIAController extends Controller
{
    public function getPlantillaSIIA($id)
    {
        $spreadsheet = IOFactory::load('files/Aspirantes/PlantillaSIIA/SIIA_Plantilla_Aspirante.xlsx');

        $worksheet = $spreadsheet->getActiveSheet();

        $aspirantes = DB::table('CAT_USUARIO AS CU')
            ->select(
                'PREFICHA',
                'ACEPTADO',
                'CLAVE_TECNM',
                'CU.NOMBRE AS NOMBRE_USUARIO',
                'PRIMER_APELLIDO',
                'SEGUNDO_APELLIDO',
                'FECHA_NACIMIENTO',
                'CURP',
                'SEXO',
                'CALLE',
                'C.NOMBRE AS NOMBRE_COLONIA',
                'CC2.NOMBRE AS NOMBRE_CIUDAD',
                'CEF.NOMBRE AS NOMBRE_ESTADO',
                'CCP.NUMERO',
                'TELEFONO_CASA',
                'TELEFONO_MOVIL',
                'CORREO1',
                'CB.NOMBRE AS NOMBRE_BACHILLERATO',
                'ESPECIALIDAD',
                'PROMEDIO',
                'FECHA_INICIO'
            )
            ->join('CAT_ASPIRANTE AS CA', 'CU.PK_USUARIO', '=', 'CA.FK_PADRE')
            ->join('TR_CARRERA_CAMPUS AS TCC', 'CA.FK_CARRERA_1', '=', 'TCC.PK_CARRERA_CAMPUS')
            ->join('CAT_CARRERA AS CC', 'TCC.FK_CARRERA', '=', 'CC.PK_CARRERA')
            ->leftJoin('CAT_COLONIA AS C', 'CU.FK_COLONIA', '=', 'C.PK_COLONIA')
            ->leftJoin('CAT_CODIGO_POSTAL AS CCP', 'CU.FK_CODIGO_POSTAL', '=', 'CCP.PK_CODIGO_POSTAL')
            ->leftJoin('CAT_CIUDAD AS CC2', 'CCP.FK_CIUDAD', '=', 'CC2.PK_CIUDAD')
            ->leftJoin('CAT_ENTIDAD_FEDERATIVA AS CEF', 'CC2.FK_ENTIDAD_FEDERATIVA', '=', 'CEF.PK_ENTIDAD_FEDERATIVA')
            ->join('CAT_BACHILLERATO AS CB', 'CA.FK_BACHILLERATO', '=', 'CB.PK_BACHILLERATO')
            ->join('CAT_PERIODO_PREFICHAS AS CPP', 'CA.FK_PERIODO', '=', 'CPP.PK_PERIODO_PREFICHAS')
            ->where('FK_PERIODO', $id)
            ->orderBy('ACEPTADO', 'desc')
            ->get();


        $fecha = strtotime($aspirantes[0]->FECHA_INICIO);
        $mes = date("m", $fecha);
        $anio = date("Y", $fecha);
        if ($mes > 6) {
            $periodo = 'Enero_Junio_' . $anio;
        } else {
            $periodo = 'Agosto_Diciembre_' . $anio;
        }

        foreach ($aspirantes as $i => $aspirante) {
            $i = $i + 8;
            $worksheet->getCell('B' . $i)->setValue($aspirante->PREFICHA);
            $worksheet->getCell('E' . $i)->setValue($aspirante->ACEPTADO);
            $worksheet->getCell('F' . $i)->setValue($aspirante->CLAVE_TECNM);
            $worksheet->getCell('G' . $i)->setValue($aspirante->NOMBRE_USUARIO);
            $worksheet->getCell('H' . $i)->setValue($aspirante->PRIMER_APELLIDO);
            $worksheet->getCell('I' . $i)->setValue($aspirante->SEGUNDO_APELLIDO);
            $worksheet->getCell('J' . $i)->setValue($aspirante->FECHA_NACIMIENTO);
            $worksheet->getCell('K' . $i)->setValue($aspirante->CURP);
            $worksheet->getCell('L' . $i)->setValue($aspirante->SEXO);
            $worksheet->getCell('M' . $i)->setValue($aspirante->CALLE);
            $worksheet->getCell('N' . $i)->setValue($aspirante->NOMBRE_COLONIA);
            $worksheet->getCell('O' . $i)->setValue($aspirante->NOMBRE_CIUDAD);
            $worksheet->getCell('P' . $i)->setValue($aspirante->NOMBRE_ESTADO);
            $worksheet->getCell('Q' . $i)->setValue($aspirante->NUMERO);
            $worksheet->getCell('R' . $i)->setValue($aspirante->TELEFONO_CASA);
            $worksheet->getCell('S' . $i)->setValue($aspirante->TELEFONO_MOVIL);
            $worksheet->getCell('T' . $i)->setValue($aspirante->CORREO1);
            $worksheet->getCell('U' . $i)->setValue($aspirante->NOMBRE_BACHILLERATO);
            $worksheet->getCell('V' . $i)->setValue($aspirante->ESPECIALIDAD);
            $worksheet->getCell('W' . $i)->setValue($aspirante->PROMEDIO);
        }

        $writer =  IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('files/Aspirantes/PlantillaSIIA/SIIA_Aspirantes_' . $periodo . '.xls');

        return response()->json('files/Aspirantes/PlantillaSIIA/SIIA_Aspirantes_' . $periodo . '.xls');

        /*
        CONSULTA
        SELECT PREFICHA, ACEPTADO, CLAVE_TECNM, CU.NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, FECHA_NACIMIENTO, CURP, SEXO, CALLE, C.NOMBRE, CC2.NOMBRE, CEF.NOMBRE, CCP.NUMERO, TELEFONO_CASA, TELEFONO_MOVIL, CORREO1, CB.NOMBRE, ESPECIALIDAD, PROMEDIO
        FROM CAT_USUARIO AS CU
        JOIN CAT_ASPIRANTE AS CA on CU.PK_USUARIO = CA.FK_PADRE
        JOIN TR_CARRERA_CAMPUS AS TCC on CA.FK_CARRERA_1 = TCC.PK_CARRERA_CAMPUS
        JOIN CAT_CARRERA AS CC on TCC.FK_CARRERA = CC.PK_CARRERA
        LEFT JOIN CAT_COLONIA AS C on CU.FK_COLONIA = C.PK_COLONIA
        LEFT JOIN CAT_CODIGO_POSTAL AS CCP on CU.FK_CODIGO_POSTAL = CCP.PK_CODIGO_POSTAL
        LEFT JOIN CAT_CIUDAD AS CC2 on CCP.FK_CIUDAD = CC2.PK_CIUDAD
        LEFT JOIN CAT_ENTIDAD_FEDERATIVA AS CEF on CC2.FK_ENTIDAD_FEDERATIVA = CEF.PK_ENTIDAD_FEDERATIVA
        JOIN CAT_BACHILLERATO CB on CA.FK_BACHILLERATO = CB.PK_BACHILLERATO
        JOIN CAT_PERIODO_PREFICHAS CPP on CA.FK_PERIODO = CPP.PK_PERIODO_PREFICHAS
        WHERE FK_PERIODO = 1
        */
    }
}
