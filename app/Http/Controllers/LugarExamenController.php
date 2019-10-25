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
        try {
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
        try {
            DB::table('CAT_TURNO')
                ->where(
                    [
                        ['PK_TURNO', $request->PK_TURNO],
                        ['FK_PERIODO', $request->FK_PERIODO]
                    ]
                )
                ->update([
                    'DIA' => $request->DIA,
                    'HORA' => $request->HORA
                ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('La fecha y la hora ya estan registradas');
            //return response()->json($ex->getMessage());
        }
    }

    public function modificarTurnoEscrito(Request $request)
    {
        try {
            DB::table('CAT_TURNO_ESCRITO')
                ->where(
                    [
                        ['PK_TURNO_ESCRITO', $request->PK_TURNO_ESCRITO],
                        ['FK_PERIODO', $request->FK_PERIODO]
                    ]
                )
                ->update([
                    'DIA' => $request->DIA,
                    'HORA' => $request->HORA
                ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('La fecha y la hora ya estan registradas');
            //return response()->json($ex->getMessage());
        }
    }



    public function obtenerGrupo($pkPeriodo)
    {
        return DB::table('CATR_EXAMEN_ADMISION AS CEA')
            ->select('PK_EXAMEN_ADMISION', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_EXAMEN_ADMISION) AS GRUPO'), 'FK_ESPACIO', 'FK_TURNO', 'NOMBRE', 'IDENTIFICADOR', 'DIA', 'HORA')
            ->join('CAT_TURNO AS CTI', 'CEA.FK_TURNO', '=', 'CTI.PK_TURNO')
            ->join('CATR_ESPACIO AS CEI', 'CEA.FK_ESPACIO', '=', 'CEI.PK_ESPACIO')
            ->where('CEA.FK_PERIODO', $pkPeriodo)
            ->orderby('PK_EXAMEN_ADMISION')
            ->get();
    }
    public function obtenerGrupoEscrito($pkPeriodo)
    {
        return DB::table('CATR_EXAMEN_ADMISION_ESCRITO AS CEAE')
            ->select('PK_EXAMEN_ADMISION_ESCRITO', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_EXAMEN_ADMISION_ESCRITO) AS GRUPO'), 'FK_CARRERA', 'FK_EDIFICIO', 'FK_TURNO_ESCRITO', 'FK_EDIFICIO', 'NOMBRE AS CARRERA')
            ->join('CAT_CARRERA AS CC', 'CEAE.FK_CARRERA', '=', 'CC.PK_CARRERA')
            ->where('FK_PERIODO', $pkPeriodo)
            ->orderby('PK_EXAMEN_ADMISION_ESCRITO')
            ->get();
    }
    public function modificarGrupo(Request $request)
    {
        try {
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

    public function modificarGrupoEscrito(Request $request)
    {
        try {
            DB::table('CATR_EXAMEN_ADMISION_ESCRITO')
                ->where('PK_EXAMEN_ADMISION_ESCRITO', $request->PK_EXAMEN_ADMISION_ESCRITO)
                ->update([
                    'FK_CARRERA' => $request->FK_CARRERA,
                    'FK_EDIFICIO' => $request->FK_EDIFICIO,
                    'FK_TURNO_ESCRITO' => $request->FK_TURNO_ESCRITO,
                    'FK_PERIODO' => $request->FK_PERIODO
                ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('La carrera, el edificio y el turno ya estan registrados');
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
                'FK_TURNO_ESCRITO' => $request->FK_TURNO_ESCRITO,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('La carrera, el edificio y el turno ya estan registrados');
        }
    }
    public function agregarTurnoIngles(Request $request)
    {
        try {
            DB::table('CAT_TURNO_INGLES')->insert([
                'DIA' => $request->DIA,
                'HORA' => $request->HORA,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('La fecha y la hora ya estan registradas');
        }
    }

    public function agregarTurnoEscrito(Request $request)
    {
        try {
            DB::table('CAT_TURNO_ESCRITO')->insert([
                'DIA' => $request->DIA,
                'HORA' => $request->HORA,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('La fecha y la hora ya estan registradas');
        }
    }

    public function obtenerTurnoIngles($pkPeriodo)
    {
        return DB::table('CAT_TURNO_INGLES')
            ->select('PK_TURNO_INGLES', 'DIA', 'HORA', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_TURNO_INGLES) AS TURNO'))
            ->where('FK_PERIODO', $pkPeriodo)
            ->orderby('PK_TURNO_INGLES')
            ->get();
    }

    public function obtenerTurnoEscrito($pkPeriodo)
    {
        return DB::table('CAT_TURNO_ESCRITO')
            ->select('PK_TURNO_ESCRITO', 'DIA', 'HORA', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_TURNO_ESCRITO) AS TURNO'))
            ->where('FK_PERIODO', $pkPeriodo)
            ->orderby('PK_TURNO_ESCRITO')
            ->get();
    }
    public function modificarTurnoIngles(Request $request)
    {
        try {
            DB::table('CAT_TURNO_INGLES')
                ->where(
                    [
                        ['PK_TURNO_INGLES', $request->PK_TURNO],
                        ['FK_PERIODO', $request->FK_PERIODO]
                    ]
                )
                ->update([
                    'DIA' => $request->DIA,
                    'HORA' => $request->HORA
                ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('La fecha y la hora ya estan registradas');
            //return response()->json($ex->getMessage());
        }
    }
    public function agregarEspacioIngles(Request $request)
    {
        try {
            DB::table('CATR_ESPACIO_INGLES')->insert([
                'FK_EDIFICIO' => $request->FK_EDIFICIO,
                'FK_TIPO_ESPACIO' => $request->FK_TIPO_ESPACIO,
                'NOMBRE' => $request->NOMBRE,
                'IDENTIFICADOR' => $request->IDENTIFICADOR,
                'CAPACIDAD' => $request->CAPACIDAD,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            //return response()->json($ex->getMessage());
            return response()->json('El nombre y el identificador ya estan registrados');
        }
    }
    public function obtenerEspacioIngles($pkPeriodo)
    {
        return DB::table('CATR_ESPACIO_INGLES')
            ->select('PK_ESPACIO_INGLES', 'NOMBRE', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_ESPACIO_INGLES) AS ESPACIO'), 'FK_EDIFICIO', 'FK_TIPO_ESPACIO', 'NOMBRE', 'IDENTIFICADOR', 'CAPACIDAD')
            ->where('FK_PERIODO', $pkPeriodo)
            ->orderby('PK_ESPACIO_INGLES')
            ->get();
    }

    public function agregarGrupoIngles(Request $request)
    {
        try {
            DB::table('CATR_EXAMEN_ADMISION_INGLES')->insert([
                'FK_ESPACIO_INGLES' => $request->FK_ESPACIO,
                'FK_TURNO_INGLES' => $request->FK_TURNO,
                'LUGARES_OCUPADOS' => 0,
                'FK_PERIODO' => $request->FK_PERIODO
            ]);
            return response()->json('Se registro correctamente');
        } catch (QueryException $ex) {
            return response()->json('El espacio y el turno ya estan registrados');
        }
    }
    public function modificarEspacioIngles(Request $request)
    {
        try {
            DB::table('CATR_ESPACIO_INGLES')
                ->where('PK_ESPACIO_INGLES', $request->PK_ESPACIO)
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
    public function obtenerGrupoIngles($pkPeriodo)
    {
        return DB::table('CATR_EXAMEN_ADMISION_INGLES AS CEAI')
            ->select('PK_EXAMEN_ADMISION_INGLES', DB::raw('ROW_NUMBER() OVER(ORDER BY PK_EXAMEN_ADMISION_INGLES) AS GRUPO'), 'FK_ESPACIO_INGLES', 'FK_TURNO_INGLES', 'NOMBRE', 'IDENTIFICADOR', 'DIA', 'HORA')
            ->join('CAT_TURNO_INGLES AS CTI', 'CEAI.FK_TURNO_INGLES', '=', 'CTI.PK_TURNO_INGLES')
            ->join('CATR_ESPACIO_INGLES AS CEI', 'CEAI.FK_ESPACIO_INGLES', '=', 'CEI.PK_ESPACIO_INGLES')
            ->where('CEAI.FK_PERIODO', $pkPeriodo)
            ->orderby('PK_EXAMEN_ADMISION_INGLES')
            ->get();
    }

    public function modificarGrupoIngles(Request $request)
    {
        try {
            DB::table('CATR_EXAMEN_ADMISION_INGLES')
                ->where('PK_EXAMEN_ADMISION_INGLES', $request->PK_EXAMEN_ADMISION_INGLES)
                ->update([
                    'FK_ESPACIO_INGLES' => $request->FK_ESPACIO_INGLES,
                    'FK_TURNO_INGLES' => $request->FK_TURNO_INGLES
                ]);
            return response()->json('Se modifico correctamente');
        } catch (QueryException $ex) {
            return response()->json('El espacio y el turno ya estan registrados');
        }
    }
}
