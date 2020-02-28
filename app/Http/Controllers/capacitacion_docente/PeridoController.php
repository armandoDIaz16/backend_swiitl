<?php

namespace App\Http\Controllers\capacitacion_docente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\PeriodoCADO;
use Illuminate\Support\Facades\DB;

class PeridoController extends Controller
{

    public function consulta_periodos()
    {
        // echo PeriodoCADO::all();
        // return DB::table('CAT_PERIODO_CADO')->where('BORRADO',0)->get();

        return response()->json(
            DB::table('CAT_PERIODO_CADO')->where('BORRADO',0)
                ->orderBy('FECHA_FIN', 'desc')->get(),
            Response::HTTP_OK // 200
        );
    }

    public function registro_periodo(Request $request)
    {
        $periodo = new PeriodoCADO;

        $periodo->NOMBRE_PERIODO = $request->nombre_periodo;
        // $periodo->TIPO_PERIODO   = $request->tipo_periodo;
        $periodo->FECHA_INICIO   = $request->fecha_inicio;
        $periodo->FECHA_FIN      = $request->fecha_fin;

        if($periodo->save()) {
            return response()->json(
                true,
                Response::HTTP_OK // 200
            );
        } else {
            return response()->json(
                ['error' => 'No se pudo guardar'],
                Response::HTTP_NOT_FOUND// 404
            );
        }
    }

    public function consulta_un_periodo($id)
    {
        // return PeriodoCADO::all()->find($id);
        // $periodo = PeriodoCADO::all()->where('PK_PERIODO_CADO',$id);
    //    echo $periodo;
        //  json_encode($informe)
        // json_decode(json_encode($informe), true);
        // if(!is_null($periodo)){
            // $periodo = PeriodoCADO::where('PK_PERIODO_CADO', $id);
            // var_dump($periodo);
            // return DB::table('CAT_PERIODO_CADO')->where('PK_PERIODO_CADO', $id);

            return response()->json(
                PeriodoCADO::all()->find($id),
                Response::HTTP_OK // 200
            );
        // }else{
        //     return response()->json(
        //         ['error' => 'No se pudo guardar'],
        //         Response::HTTP_NOT_FOUND// 404
        //     );
        // }

    }

    public function modificar_periodo(Request $request){
        $PK_PERIODO_CADO = $request->pk_periodo_cado;

        $periodo = PeriodoCADO::find($PK_PERIODO_CADO);

        $periodo->NOMBRE_PERIODO = $request->nombre_periodo;
        $periodo->FECHA_INICIO   = $request->fecha_inicio;
        $periodo->FECHA_FIN      = $request->fecha_fin;

// $flight->name = 'New Flight Name';

// $periodo->save();


        // $PK_PERIODO_CADO = $request->pk_periodo_cado;
        // $periodo->NOMBRE_PERIODO = $request->nombre_periodo;
        // $periodo->FECHA_INICIO   = $request->fecha_inicio;
        // $periodo->FECHA_FIN      = $request->fecha_fin;

        if($periodo->save()) {
            return response()->json(
                true,
                Response::HTTP_OK // 200
            );
        } else {
            return response()->json(
                ['error' => 'No se pudo editar el periodo'],
                Response::HTTP_NOT_FOUND// 404
            );
        }
    }

    public function  eliminar_periodo(Request $request){
        $PK_PERIODO_CADO = $request->pk_periodo_cado;
        $periodo = PeriodoCADO::find($PK_PERIODO_CADO);
        $periodo->BORRADO  = 1;

        if($periodo->save()) {
            return response()->json(
                true,
                Response::HTTP_OK // 200
            );
        } else {
            return response()->json(
                ['error' => 'No se pudo eliminar el periodo'],
                Response::HTTP_NOT_FOUND// 404
            );
        }


    }
}
