<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class LugarExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerTurno($pkPeriodo)
    {
        $dias = DB::table('CAT_TURNO')
            ->select('DIA')
            ->where('FK_PERIODO', $pkPeriodo)
            ->distinct()
            ->get();

        $horas = DB::table('CAT_TURNO')
            ->select('HORA')
            ->where('FK_PERIODO', $pkPeriodo)
            ->distinct()
            ->get();

        return array(
            [
                'DIAS' => $dias,
                'HORAS' => $horas
            ]
        );
    }

    public function obtenerEspacio($pkPeriodo)
    {
        return DB::table('CATR_ESPACIO')
            ->select('PK_ESPACIO', 'NOMBRE', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_ESPACIO) AS ESPACIO'), 'FK_EDIFICIO', 'FK_TIPO_ESPACIO', 'NOMBRE', 'IDENTIFICADOR', 'CAPACIDAD')
            ->where('FK_PERIODO', $pkPeriodo)
            ->orderby('PK_ESPACIO')
            ->get();
    }

    public function modificarEspacio(Request $request)
    {
        try{
            DB::table('CATR_ESPACIO')
            ->where('PK_ESPACIO', $request->PK_ESPACIO)
            ->update([
                'FK_EDIFICIO' => $request->FK_EDIFICIO,
                'FK_TIPO_ESPACIO' => $request->FK_TIPO_ESPACIO,
                'NOMBRE' => $request->NOMBRE,
                'IDENTIFICADOR' => $request->IDENTIFICADOR,
                'CAPACIDAD' => $request->CAPACIDAD
            ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('El nombre y el identificador ya estan registrados');
        }
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

    public function obtenerTurno2($pkPeriodo)
    {
        return DB::table('CAT_TURNO')
            ->select('PK_TURNO', 'DIA', 'HORA', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_TURNO) AS TURNO'))
            ->where('FK_PERIODO', $pkPeriodo)
            ->orderby('PK_TURNO')
            ->get();
    }

    public function modificarTurno(Request $request)
    {
        try{
        DB::table('CAT_TURNO')
            ->where('PK_TURNO', $request->PK_TURNO)
            ->update([
                'DIA' => $request->DIA,
                'HORA' => $request->HORA
            ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('La fecha y la hora ya estan registradas');
        }
    }



    public function obtenerGrupo($pkPeriodo)
    {
        return DB::table('CATR_EXAMEN_ADMISION')
            ->select('PK_EXAMEN_ADMISION', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_EXAMEN_ADMISION) AS GRUPO'), 'FK_ESPACIO', 'FK_TURNO')
            ->where('FK_PERIODO', $pkPeriodo)
            ->orderby('PK_EXAMEN_ADMISION')
            ->get();
    }
    public function modificarGrupo(Request $request)
    {
        try{
         DB::table('CATR_EXAMEN_ADMISION')
            ->where('PK_EXAMEN_ADMISION', $request->PK_EXAMEN_ADMISION)
            ->update([
                'FK_ESPACIO' => $request->FK_ESPACIO,
                'FK_TURNO' => $request->FK_TURNO
            ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('El espacio y el turno ya estan registrados');
        }
    }

    public function agregarTurno(Request $request)
    {
        try {
            DB::table('CAT_TURNO')->insert([
                'DIA' => $request->DIA,
                'HORA' => $request->HORA,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('La fecha y la hora ya estan registradas');
        }
    }

    public function agregarEspacio(Request $request)
    {
        try {
            DB::table('CATR_ESPACIO')->insert([
                'FK_EDIFICIO' => $request->FK_EDIFICIO,
                'FK_TIPO_ESPACIO' => $request->FK_TIPO_ESPACIO,
                'NOMBRE' => $request->NOMBRE,
                'IDENTIFICADOR' => $request->IDENTIFICADOR,
                'CAPACIDAD' => $request->CAPACIDAD,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('El nombre y el identificador ya estan registrados');
        }
    }

    public function agregarGrupo(Request $request)
    {
        try {
            DB::table('CATR_EXAMEN_ADMISION')->insert([
                'FK_ESPACIO' => $request->FK_ESPACIO,
                'FK_TURNO' => $request->FK_TURNO,
                'LUGARES_OCUPADOS' => 0,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('El espacio y el turno ya estan registrados');
        }
    }

    public function agregarGrupoEscrito(Request $request)
    {
        try {
            DB::table('CATR_EXAMEN_ADMISION_ESCRITO')->insert([
                'FK_CARRERA' => $request->FK_CARRERA,
                'FK_EDIFICIO' => $request->FK_EDIFICIO,
                'FK_TURNO' => $request->FK_TURNO,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('La carrera, el edificio y el turno ya estan registrados');
        }
    }
}
