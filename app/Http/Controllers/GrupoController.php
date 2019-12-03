<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listaGrupos(Request $request)
    {
        /* $aspirante = DB::table('CAT_USUARIO')
            ->select(
                DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
                'CAT_CARRERA.CLAVE_CARRERA as CLAVE_CARRERA',
                'CAT_ASPIRANTE.FOLIO_CENEVAL',
                'CAT_USUARIO.NOMBRE as NOMBRE',
                'CAT_USUARIO.PRIMER_APELLIDO',
                DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO")
            )
            ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
            ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.PK_CARRERA_CAMPUS', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS.FK_CARRERA')
            ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CAT_ASPIRANTE.FK_EXAMEN_ADMISION')
            ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
            ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
            ->where([
                ['CATR_ESPACIO.PK_ESPACIO', '=', $request->PK_ESPACIO],
                ['CAT_TURNO.DIA', '=', $request->DIA],
                ['CAT_TURNO.HORA', '=', $request->HORA],
                ['CAT_ASPIRANTE.FK_PERIODO', '=', $request->FK_PERIODO]
            ])
            ->get(); */
        if ($request->TIPO_APLICACION == 1) {
            $aspirante = DB::table('CAT_USUARIO AS CU')
                ->select(
                    DB::raw('LTRIM(RTRIM(CA.PREFICHA)) as PREFICHA'),
                    'CC.CLAVE_CARRERA as CLAVE_CARRERA',
                    'CA.FOLIO_CENEVAL',
                    'CU.NOMBRE as NOMBRE',
                    'CU.PRIMER_APELLIDO',
                    DB::raw("CASE WHEN CU.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CU.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO")
                )
                ->join('CAT_ASPIRANTE AS CA', 'CA.FK_PADRE', '=', 'CU.PK_USUARIO')
                ->join('TR_CARRERA_CAMPUS AS TCC', 'TCC.PK_CARRERA_CAMPUS', '=',  'CA.FK_CARRERA_1')
                ->join('CAT_CARRERA AS CC', 'CC.PK_CARRERA', '=',  'TCC.FK_CARRERA')
                ->where([
                    ['CA.FK_EXAMEN_ADMISION', '=', $request->FK_GRUPO],
                    ['CA.FK_PERIODO', '=', $request->FK_PERIODO]
                ])
                ->get();
        } else {
            $aspirante = DB::table('CAT_USUARIO AS CU')
                ->select(
                    DB::raw('LTRIM(RTRIM(CA.PREFICHA)) as PREFICHA'),
                    'CC.CLAVE_CARRERA as CLAVE_CARRERA',
                    'CA.FOLIO_CENEVAL',
                    'CU.NOMBRE as NOMBRE',
                    'CU.PRIMER_APELLIDO',
                    DB::raw("CASE WHEN CU.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CU.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO")
                )
                ->join('CAT_ASPIRANTE AS CA', 'CA.FK_PADRE', '=', 'CU.PK_USUARIO')
                ->join('TR_CARRERA_CAMPUS AS TCC', 'TCC.PK_CARRERA_CAMPUS', '=',  'CA.FK_CARRERA_1')
                ->join('CAT_CARRERA AS CC', 'CC.PK_CARRERA', '=',  'TCC.FK_CARRERA')
                ->where([
                    ['CA.FK_EXAMEN_ADMISION_ESCRITO', '=', $request->FK_GRUPO],
                    ['CA.FK_PERIODO', '=', $request->FK_PERIODO]
                ])
                ->get();
        }
        return $aspirante;
    }

    public function datosListas($FK_PERIODO)
    {
        $TIPO_APLICACION = DB::table('CAT_PERIODO_PREFICHAS')->select('TIPO_APLICACION')->where('PK_PERIODO_PREFICHAS', $FK_PERIODO)->max('TIPO_APLICACION');

        if ($TIPO_APLICACION == 1) {
            $grupos = DB::table('CATR_EXAMEN_ADMISION as CEA')
                ->select(DB::raw("ROW_NUMBER() OVER(ORDER BY CEA.PK_EXAMEN_ADMISION ASC) AS NUMERO_GRUPO,CEA.PK_EXAMEN_ADMISION,CONCAT ('Edificio:(' ,CED.PREFIJO, ' - ',CE.NOMBRE, ')     Turno:',CT.DIA, ' ', CT.HORA) as GRUPO"))
                ->join('CATR_ESPACIO as CE', 'CEA.FK_ESPACIO', '=', 'CE.PK_ESPACIO')
                ->join('CATR_EDIFICIO AS CED', 'CE.FK_EDIFICIO', '=', 'CED.PK_EDIFICIO')
                ->join('CAT_TURNO as CT', 'CEA.FK_TURNO', '=', 'CT.PK_TURNO')
                ->where('CT.FK_PERIODO', $FK_PERIODO)
                ->orderBy('CEA.PK_EXAMEN_ADMISION')
                ->get();

            $array_grupos = [];
            foreach ($grupos as $grupo) {
                $array_grupos[] = array(
                    'NUMERO_GRUPO' => $grupo->NUMERO_GRUPO,
                    'GRUPO'     => $grupo->GRUPO,
                    'ASPIRANTES'      => $this->get_aspirantes($grupo->PK_EXAMEN_ADMISION)
                );
            }
        } else {
            $grupos = DB::table('CATR_EXAMEN_ADMISION_ESCRITO AS CEAE')
                ->select(DB::raw("ROW_NUMBER() OVER(ORDER BY CEAE.PK_EXAMEN_ADMISION_ESCRITO ASC) AS NUMERO_GRUPO, CEAE.PK_EXAMEN_ADMISION_ESCRITO, CONCAT ('Edificio:(' ,CE.PREFIJO, ' - ',CE.NOMBRE, ')     Carrera:', CC.NOMBRE , '     Turno:',CTE.DIA, ' ', CTE.HORA) as GRUPO"))
                ->join('CATR_EDIFICIO AS CE', 'CEAE.FK_EDIFICIO', '=', 'CE.PK_EDIFICIO')
                ->join('CAT_TURNO_ESCRITO AS CTE', 'CEAE.FK_TURNO_ESCRITO', '=', 'CTE.PK_TURNO_ESCRITO')
                ->join('CAT_CARRERA AS CC', 'CEAE.FK_CARRERA', '=', 'CC.PK_CARRERA')
                ->where('CTE.FK_PERIODO', $FK_PERIODO)
                ->orderBy('CEAE.PK_EXAMEN_ADMISION_ESCRITO')
                ->get();
            $array_grupos = [];
            foreach ($grupos as $grupo) {
                $array_grupos[] = array(
                    'NUMERO_GRUPO' => $grupo->NUMERO_GRUPO,
                    'GRUPO'     => $grupo->GRUPO,
                    'ASPIRANTES'      => $this->get_aspirantesEscrito($grupo->PK_EXAMEN_ADMISION_ESCRITO)
                );
            }
        }
        return $array_grupos;
    }

    public function datosListasIngles($FK_PERIODO)
    {
        $grupos = DB::table('CATR_EXAMEN_ADMISION_INGLES as CEAI')
            ->select(DB::raw("ROW_NUMBER() OVER(ORDER BY CEAI.PK_EXAMEN_ADMISION_INGLES ASC) AS NUMERO_GRUPO,CEAI.PK_EXAMEN_ADMISION_INGLES, CONCAT ('Edificio:(' ,CED.PREFIJO, ' - ',CEI.NOMBRE, ')     Turno:',CTI.DIA, ' ', CTI.HORA) as GRUPO"))
            ->join('CATR_ESPACIO_INGLES as CEI', 'CEAI.FK_ESPACIO_INGLES', '=', 'CEI.PK_ESPACIO_INGLES')
            ->join('CATR_EDIFICIO AS CED', 'CEI.FK_EDIFICIO', '=', 'CED.PK_EDIFICIO')
            ->join('CAT_TURNO_INGLES as CTI', 'CEAI.FK_TURNO_INGLES', '=', 'CTI.PK_TURNO_INGLES')
            ->where('CTI.FK_PERIODO', $FK_PERIODO)
            ->orderBy('CEAI.PK_EXAMEN_ADMISION_INGLES')
            ->get();

        $array_grupos = [];
        foreach ($grupos as $grupo) {
            $array_grupos[] = array(
                'NUMERO_GRUPO' => $grupo->NUMERO_GRUPO,
                'GRUPO'     => $grupo->GRUPO,
                'ASPIRANTES'      => $this->get_aspirantes($grupo->PK_EXAMEN_ADMISION_INGLES)
            );
        }
        return $array_grupos;
    }

    private function get_aspirantes($PK_EXAMEN_ADMISION)
    {
        $aspirantes = DB::table('CAT_ASPIRANTE as CA')
            ->select(DB::raw("PREFICHA, CONCAT(NOMBRE,' ',PRIMER_APELLIDO,' ',SEGUNDO_APELLIDO) as NOMBRE, CASE WHEN FK_ESTATUS = 5 THEN 1 ELSE 0 END AS ASISTENCIA"))
            ->join('CAT_USUARIO as CU', 'CA.FK_PADRE', '=', 'CU.PK_USUARIO')
            ->where('FK_EXAMEN_ADMISION', $PK_EXAMEN_ADMISION)
            ->get();

        return $aspirantes;
    }
    private function get_aspirantesEscrito($PK_EXAMEN_ADMISION_ESCRITO)
    {
        $aspirantes = DB::table('CAT_ASPIRANTE as CA')
            ->select(DB::raw("PREFICHA, CONCAT(NOMBRE,' ',PRIMER_APELLIDO,' ',SEGUNDO_APELLIDO) as NOMBRE, CASE WHEN FK_ESTATUS = 5 THEN 1 ELSE 0 END AS ASISTENCIA"))
            ->join('CAT_USUARIO as CU', 'CA.FK_PADRE', '=', 'CU.PK_USUARIO')
            ->where('FK_EXAMEN_ADMISION_ESCRITO', $PK_EXAMEN_ADMISION_ESCRITO)
            ->get();

        return $aspirantes;
    }
}
