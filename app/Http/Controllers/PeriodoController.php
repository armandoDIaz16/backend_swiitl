<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PK_PERIODO_PREFICHAS = Periodo::max('PK_PERIODO_PREFICHAS');

        $periodo = Periodo::select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO', 'FECHA_FIN', 'MONTO_PREFICHA', 'FECHA_INICIO_CURSO', 'FECHA_FIN_CURSO', 'MONTO_CURSO', 'FECHA_INICIO_INSCRIPCION', 'FECHA_FIN_INSCRIPCION', 'MONTO_INSCRIPCION', 'FECHA_INICIO_INSCRIPCION_BIS', 'FECHA_FIN_INSCRIPCION_BIS', 'MONTO_INSCRIPCION_BIS', 'MENSAJE_SEMESTRE', 'MENSAJE_SEMESTRE_BIS', 'RESULTADOS', 'TIPO_APLICACION', 'MENSAJE_RECHAZADO')
            ->where('PK_PERIODO_PREFICHAS', $PK_PERIODO_PREFICHAS)
            ->get();

        if (isset($periodo[0])) {
            return [
                array(
                    'PK_PERIODO_PREFICHAS' => $periodo[0]->PK_PERIODO_PREFICHAS,
                    'FECHA_INICIO' => $periodo[0]->FECHA_INICIO,
                    'FECHA_FIN' => $periodo[0]->FECHA_FIN,
                    'FECHA_ACTUAL' => $this->fechaActual(),
                    'MONTO_PREFICHA' => $periodo[0]->MONTO_PREFICHA,
                    'FECHA_INICIO_CURSO' => $periodo[0]->FECHA_INICIO_CURSO,
                    'FECHA_FIN_CURSO' => $periodo[0]->FECHA_FIN_CURSO,
                    'MONTO_CURSO' => $periodo[0]->MONTO_CURSO,
                    'FECHA_INICIO_INSCRIPCION' => $periodo[0]->FECHA_INICIO_INSCRIPCION,
                    'FECHA_FIN_INSCRIPCION' => $periodo[0]->FECHA_FIN_INSCRIPCION,
                    'MONTO_INSCRIPCION' => $periodo[0]->MONTO_INSCRIPCION,
                    'FECHA_INICIO_INSCRIPCION_BIS' => $periodo[0]->FECHA_INICIO_INSCRIPCION_BIS,
                    'FECHA_FIN_INSCRIPCION_BIS' => $periodo[0]->FECHA_FIN_INSCRIPCION_BIS,
                    'MONTO_INSCRIPCION_BIS' => $periodo[0]->MONTO_INSCRIPCION_BIS,
                    'MENSAJE_SEMESTRE' => $periodo[0]->MENSAJE_SEMESTRE,
                    'MENSAJE_SEMESTRE_BIS' =>  $periodo[0]->MENSAJE_SEMESTRE_BIS,
                    'MENSAJE_RECHAZADO' =>  $periodo[0]->MENSAJE_RECHAZADO,
                    'RESULTADOS' => $periodo[0]->RESULTADOS,
                    'TIPO_APLICACION' => $periodo[0]->TIPO_APLICACION
                )
            ];
        }
    }

    public function fechaActual()
    {
        $fechaActual = Date('Y') . '-';
        $fechaActual = $fechaActual . Date('m') . '-';
        $fechaActual = $fechaActual . Date('d');
        return $fechaActual;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->PK_PERIODO_PREFICHAS) {
            $periodo = Periodo::select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO', 'FECHA_FIN', 'FK_USUARIO_MODIFICACION')
                ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
                ->update([
                    'FECHA_INICIO' => $request->FECHA_INICIO,
                    'FECHA_FIN' => $request->FECHA_FIN,
                    'FK_USUARIO_MODIFICACION' => $request->FK_USUARIO_MODIFICACION
                ]);
            return response()->json('Se modifico correctamente');
        } else {
            $periodo = new Periodo();
            $periodo->FECHA_INICIO = $request->FECHA_INICIO;
            $periodo->FECHA_FIN = $request->FECHA_FIN;
            $periodo->FK_USUARIO_REGISTRO = $request->FK_USUARIO_REGISTRO;
            $periodo->save();
            return response()->json('Se registro correctamente');
        }
    }

    public function periodoCurso(Request $request)
    {
        Periodo::select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO_CURSO', 'FECHA_FIN_CURSO')
            ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
            ->update([
                'FECHA_INICIO_CURSO' => $request->FECHA_INICIO_CURSO,
                'FECHA_FIN_CURSO' => $request->FECHA_FIN_CURSO
            ]);
        return response()->json('Se modifico correctamente');
    }
    public function periodoInscripcion(Request $request)
    {
        Periodo::select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO_INSCRIPCION', 'FECHA_FIN_INSCRIPCION')
            ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
            ->update([
                'FECHA_INICIO_INSCRIPCION' => $request->FECHA_INICIO_INSCRIPCION,
                'FECHA_FIN_INSCRIPCION' => $request->FECHA_FIN_INSCRIPCION
            ]);
        return response()->json('Se modifico correctamente');
    }
    public function periodoInscripcionCero(Request $request)
    {
        Periodo::select('PK_PERIODO_PREFICHAS', 'FECHA_INICIO_INSCRIPCION_BIS', 'FECHA_FIN_INSCRIPCION_BIS')
            ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
            ->update([
                'FECHA_INICIO_INSCRIPCION_BIS' => $request->FECHA_INICIO_INSCRIPCION_BIS,
                'FECHA_FIN_INSCRIPCION_BIS' => $request->FECHA_FIN_INSCRIPCION_BIS
            ]);
        return response()->json('Se modifico correctamente');
    }
    public function montoPreficha(Request $request)
    {
        Periodo::select('PK_PERIODO_PREFICHAS', 'MONTO_PREFICHA')
            ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
            ->update(['MONTO_PREFICHA' => $request->MONTO_PREFICHA]);
        return response()->json('Se modifico correctamente');
    }
    public function montoCurso(Request $request)
    {
        Periodo::select('PK_PERIODO_PREFICHAS', 'MONTO_CURSO')
            ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
            ->update(['MONTO_CURSO' => $request->MONTO_CURSO]);
        return response()->json('Se modifico correctamente');
    }
    public function montoInscripcion(Request $request)
    {
        Periodo::select('PK_PERIODO_PREFICHAS', 'MONTO_INSCRIPCION')
            ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
            ->update(['MONTO_INSCRIPCION' => $request->MONTO_INSCRIPCION]);
        return response()->json('Se modifico correctamente');
    }
    public function montoInscripcionCero(Request $request)
    {
        Periodo::select('PK_PERIODO_PREFICHAS', 'MONTO_INSCRIPCION_BIS')
            ->where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)
            ->update(['MONTO_INSCRIPCION_BIS' => $request->MONTO_INSCRIPCION_BIS]);
        return response()->json('Se modifico correctamente');
    }
    public function publicarResultados(Request $request)
    {
        Periodo::where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)->update(['RESULTADOS' => $request->RESULTADOS]);
        return response()->json('Se modifico correctamente');
    }
    public function mensajesAceptacion(Request $request)
    {
        Periodo::where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)->update(['MENSAJE_SEMESTRE' => $request->MENSAJE_SEMESTRE, 'MENSAJE_SEMESTRE_BIS' => $request->MENSAJE_SEMESTRE_BIS, 'MENSAJE_RECHAZADO' => $request->MENSAJE_RECHAZADO]);
        return response()->json('Se modifico correctamente');
    }
    public function modificarTipoExamen(Request $request)
    {
        Periodo::where('PK_PERIODO_PREFICHAS', $request->PK_PERIODO_PREFICHAS)->update(['TIPO_APLICACION' => $request->TIPO_APLICACION]);
        return response()->json('Se modifico correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
