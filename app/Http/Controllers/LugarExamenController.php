<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LugarExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerTurno()
    {
        $dias = DB::table('CAT_TURNO')
            ->select('DIA')
            ->distinct()
            ->get();

        $horas = DB::table('CAT_TURNO')
            ->select('HORA')
            ->distinct()
            ->get();

        return array(
            [
                'DIAS' => $dias,
                'HORAS' => $horas
            ]
        );
    }

    public function obtenerEspacio()
    {
        return DB::table('CATR_ESPACIO')
            ->select('PK_ESPACIO', 'NOMBRE', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_ESPACIO) AS ESPACIO'), 'FK_EDIFICIO', 'FK_TIPO_ESPACIO', 'NOMBRE', 'IDENTIFICADOR', 'CAPACIDAD')
            ->orderby('PK_ESPACIO')
            ->get();
    }

    public function modificarEspacio(Request $request)
    {
        return DB::table('CATR_ESPACIO')
            ->where('PK_ESPACIO', $request->PK_ESPACIO)
            ->update([
                'FK_EDIFICIO' => $request->FK_EDIFICIO,
                'FK_TIPO_ESPACIO' => $request->FK_TIPO_ESPACIO,
                'NOMBRE' => $request->NOMBRE,
                'IDENTIFICADOR' => $request->IDENTIFICADOR,
                'CAPACIDAD' => $request->CAPACIDAD
            ]);
    }

    public function obtenerEdificio()
    {
        return DB::table('CATR_EDIFICIO')
            ->select(
                'CATR_EDIFICIO.PK_EDIFICIO',
                'CAT_CAMPUS.NOMBRE as CAMPUS',
                'CATR_EDIFICIO.NOMBRE as EDIFICIO',
                'PREFIJO'
            )
            ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=', 'CATR_EDIFICIO.FK_CAMPUS')
            ->orderBy('CATR_EDIFICIO.PK_EDIFICIO')
            ->get();
    }

    public function obtenerTipoEspacio()
    {
        return DB::table('CAT_TIPO_ESPACIO')
            ->select(
                'PK_TIPO_ESPACIO',
                'NOMBRE'
            )
            ->orderBy('PK_TIPO_ESPACIO')
            ->get();
    }

    public function obtenerTurno2()
    {
        return DB::table('CAT_TURNO')
            ->select('PK_TURNO', 'DIA', 'HORA', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_TURNO) AS TURNO'))
            ->orderby('PK_TURNO')
            ->get();
    }

    public function modificarTurno(Request $request)
    {
        return DB::table('CAT_TURNO')
            ->where('PK_TURNO', $request->PK_TURNO)
            ->update([
                'DIA' => $request->DIA,
                'HORA' => $request->HORA
            ]);
    }

    public function obtenerGrupo()
    {
        return DB::table('CATR_EXAMEN_ADMISION')
            ->select('PK_EXAMEN_ADMISION', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_EXAMEN_ADMISION) AS GRUPO'), 'FK_ESPACIO', 'FK_TURNO')
            ->orderby('PK_EXAMEN_ADMISION')
            ->get();
    }
    public function modificarGrupo(Request $request)
    {
        return DB::table('CATR_EXAMEN_ADMISION')
            ->where('PK_EXAMEN_ADMISION', $request->PK_EXAMEN_ADMISION)
            ->update([
                'FK_ESPACIO' => $request->FK_ESPACIO,
                'FK_TURNO' => $request->FK_TURNO
            ]);
    }

    public function agregarTurno(Request $request)
    {
        DB::table('CAT_TURNO')->insert([
            'DIA' => $request->DIA,
            'HORA' => $request->HORA
        ]);
    }

    public function agregarEspacio(Request $request)
    {
        DB::table('CATR_ESPACIO')->insert([
            'FK_EDIFICIO' => $request->FK_EDIFICIO,
            'FK_TIPO_ESPACIO' => $request->FK_TIPO_ESPACIO,
            'NOMBRE' => $request->NOMBRE,
            'IDENTIFICADOR' => $request->IDENTIFICADOR,
            'CAPACIDAD' => $request->CAPACIDAD
        ]);
    }

    public function agregarGrupo(Request $request)
    {
        DB::table('CATR_EXAMEN_ADMISION')->insert([
            'FK_ESPACIO' => $request->FK_ESPACIO,
            'FK_TURNO' => $request->FK_TURNO,
            'LUGARES_OCUPADOS' => 0
        ]);
    }
}
