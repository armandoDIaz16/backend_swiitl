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
        $aspirante = DB::table('users')
        ->select(
            DB::raw('LTRIM(RTRIM(CATR_ASPIRANTE.PREFICHA)) as PREFICHA'),
            'CATR_CARRERA.CLAVE as CLAVE_CARRERA',
            'CATR_ASPIRANTE.FOLIO_CENEVAL',
            'users.name as NOMBRE',
            'users.PRIMER_APELLIDO',
            DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO")
        )
        ->join('CATR_ASPIRANTE', 'CATR_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
        ->join('CATR_CARRERA', 'CATR_CARRERA.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_1')
        ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CATR_ASPIRANTE.FK_EXAMEN_ADMISION')
        ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
        ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
        ->where([
            ['CATR_ESPACIO.PK_ESPACIO', '=', $request->PK_ESPACIO],
            ['CAT_TURNO.DIA', '=', $request->DIA],
            ['CAT_TURNO.HORA', '=', $request->HORA]
        ])
        ->get();

        return $aspirante;
        /* ->join('CATR_ASPIRANTE', 'CATR_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
        ->join('CATR_CARRERA', 'CATR_CARRERA.PK_CARRERA', '=',  'CATR_ASPIRANTE.FK_CARRERA_1')
        ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CATR_ASPIRANTE.FK_EXAMEN_ADMISION')
        ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
        ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
        ->join('CATR_EDIFICIO', 'CATR_EDIFICIO.PK_EDIFICIO', '=', 'CATR_ESPACIO.FK_EDIFICIO')
        ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS') */
    }
}
