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
        /* $aspirante = DB::table('users')
        ->select(
            DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
            'CAT_CARRERA.CLAVE as CLAVE_CARRERA',
            'CAT_ASPIRANTE.FOLIO_CENEVAL',
            'users.name as NOMBRE',
            'users.PRIMER_APELLIDO',
            DB::raw("CASE WHEN users.SEGUNDO_APELLIDO IS NULL THEN '' ELSE users.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO")
        )
        ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
        ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
        ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CAT_ASPIRANTE.FK_EXAMEN_ADMISION')
        ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
        ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
        ->where([
            ['CATR_ESPACIO.PK_ESPACIO', '=', $request->PK_ESPACIO],
            ['CAT_TURNO.DIA', '=', $request->DIA],
            ['CAT_TURNO.HORA', '=', $request->HORA]
        ])
        ->get(); */

        $aspirante = DB::table('CAT_USUARIO')
        ->select(
            DB::raw('LTRIM(RTRIM(CAT_ASPIRANTE.PREFICHA)) as PREFICHA'),
            'CAT_CARRERA.CLAVE as CLAVE_CARRERA',
            'CAT_ASPIRANTE.FOLIO_CENEVAL',
            'CAT_USUARIO.name as NOMBRE',
            'CAT_USUARIO.PRIMER_APELLIDO',
            DB::raw("CASE WHEN CAT_USUARIO.SEGUNDO_APELLIDO IS NULL THEN '' ELSE CAT_USUARIO.SEGUNDO_APELLIDO END as SEGUNDO_APELLIDO")
        )
        ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'CAT_USUARIO.PK_USUARIO')
        ->join('TR_CARRERA_CAMPUS', 'TR_CARRERA_CAMPUS.FK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
        ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS.FK_CARRERA')
        ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CAT_ASPIRANTE.FK_EXAMEN_ADMISION')
        ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
        ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
        ->where([
            ['CATR_ESPACIO.PK_ESPACIO', '=', $request->PK_ESPACIO],
            ['CAT_TURNO.DIA', '=', $request->DIA],
            ['CAT_TURNO.HORA', '=', $request->HORA]
        ])
        ->get();

        return $aspirante;
        /* ->join('CAT_ASPIRANTE', 'CAT_ASPIRANTE.FK_PADRE', '=', 'users.PK_USUARIO')
        ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'CAT_ASPIRANTE.FK_CARRERA_1')
        ->join('CATR_EXAMEN_ADMISION', 'CATR_EXAMEN_ADMISION.PK_EXAMEN_ADMISION', '=', 'CAT_ASPIRANTE.FK_EXAMEN_ADMISION')
        ->join('CAT_TURNO', 'CAT_TURNO.PK_TURNO', '=', 'CATR_EXAMEN_ADMISION.FK_TURNO')
        ->join('CATR_ESPACIO', 'CATR_ESPACIO.PK_ESPACIO', '=', 'CATR_EXAMEN_ADMISION.FK_ESPACIO')
        ->join('CATR_EDIFICIO', 'CATR_EDIFICIO.PK_EDIFICIO', '=', 'CATR_ESPACIO.FK_EDIFICIO')
        ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS') */
    }
}
