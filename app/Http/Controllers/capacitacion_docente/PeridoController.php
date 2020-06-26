<?php

namespace App\Http\Controllers\capacitacion_docente;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\PeriodoCADO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PeridoController extends Controller
{

    public function busca_periodo_con_cursos($id)
    {

        return response()->json(
            DB::table('CAT_PERIODO_CADO')
                ->join('CAT_CURSO_CADO', 'CAT_PERIODO_CADO.PK_PERIODO_CADO', '=',  'CAT_CURSO_CADO.FK_PERIODO_CADO')
                ->where('PK_PERIODO_CADO',$id)
                ->where('CAT_CURSO_CADO.BORRADO',0)
                ->get(),
            Response::HTTP_OK // 200
        );
    }

    public function consulta_periodos_activos()
    {
        // echo PeriodoCADO::all();
        // return DB::table('CAT_PERIODO_CADO')->where('BORRADO',0)->get();
        $mytime = Carbon::now();
         $mytime->toDateTimeString();
        return response()->json(
            DB::table('CAT_PERIODO_CADO')
//                ->where('FECHA_FIN','>',$mytime->toDateTimeString())
                ->where('BORRADO',0)
                ->orderBy('FECHA_FIN', 'desc')
                ->get(),
            Response::HTTP_OK // 200
        );
    }
    public function consulta_un_periodo($id){
        return response()->json(
            PeriodoCADO::all()->find($id),
            Response::HTTP_OK // 200
        );
    }

    /**
     * @author : Armando Díaz
     * @since  : 9/4/2020
     * @requerimiento : RF - 25	Modificación de información de CV
     * @version : 1.0.0
     * @description: OBTIENE LA FICHA TECNICA RELACIONADA CON EL CURSO
     *  HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @param $request   Request al que se desea acceder para guardar
     * @return JsonResponse
     */
    public function consulta_periodos() {
        return response()->json(
            DB::table('CAT_PERIODO_CADO')
                ->where('BORRADO',0)
                ->orderBy('FECHA_FIN', 'desc')
                ->get(),
            Response::HTTP_OK // 200
        );
    }

    /**
     * @author : Armando Díaz
     * @since  : 9/4/2020
     * @requerimiento : RF - 25	Modificación de información de CV
     * @version : 1.0.0
     * @description: OBTIENE LA FICHA TECNICA RELACIONADA CON EL CURSO
     *  HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @param $request   Request al que se desea acceder para guardar
     * @return JsonResponse
     */
    public function registro_periodo(Request $request) {
        // Creamos una nueva instancia de la clase PeriodoCADO
        $periodo = new PeriodoCADO;
        $periodo->NOMBRE_PERIODO = $request->nombre_periodo;
        // Obtenemos los datos de la Request y se realiza el mapeo a la clase PeriodoCADO
        $periodo->FECHA_INICIO   = $request->fecha_inicio;
        $periodo->FECHA_FIN      = $request->fecha_fin;
        // Con la función save() de Model  se persiste el objeto en la base de datos
        if($periodo->save()) {
            // Si la operación es exitosa, regresamos un valor true con status 200
            return response()->json(true,Response::HTTP_OK);// 200
        } else {
            //De lo contrario regresamos un valor false con un mensaje de error
            return response()->json(
                ['error' => 'No se pudo guardar el periodo'],
                Response::HTTP_NOT_FOUND// 404
            );
        } // fin else
    } // fin método registro_periodo

    /**
     * @author : Armando Díaz
     * @since  : 9/4/2020
     * @requerimiento : RF - 25	Modificación de información de CV
     * @version : 1.0.0
     * @description: OBTIENE LA FICHA TECNICA RELACIONADA CON EL CURSO
     *  HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @param $request   Request al que se desea acceder para guardar
     * @return JsonResponse
     */
    public function modificar_periodo(Request $request){
        $PK_PERIODO_CADO = $request->pk_periodo_cado;
        $periodo = PeriodoCADO::find($PK_PERIODO_CADO);
        $periodo->NOMBRE_PERIODO = $request->nombre_periodo;
        $periodo->FECHA_INICIO   = $request->fecha_inicio;
        $periodo->FECHA_FIN      = $request->fecha_fin;
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

    /**
     * @author : Armando Díaz
     * @since  : 9/4/2020
     * @requerimiento : RF - 25	Modificación de información de CV
     * @version : 1.0.0
     * @description: OBTIENE LA FICHA TECNICA RELACIONADA CON EL CURSO
     *  HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @param $request   Request al que se desea acceder para guardar
     * @return JsonResponse
     */
    public function  eliminar_periodo(Request $request){
        // recuperamos la pk del periodo que está dentro de la request
        $PK_PERIODO_CADO = $request->pk_periodo_cado;
        //Buscamos el periodo de la base de datos por su pk
        $periodo = PeriodoCADO::find($PK_PERIODO_CADO);
        // Realizamos el borrado lógico colocando el valor del campo BORRADO en 1
        $periodo->BORRADO  = 1;
        // Actualizamso el registro en la base de datos
        if($periodo->save()) {
            // Si realizó el UPDATE exitosamente devolvemos true
            return response()->json(true,Response::HTTP_OK ); // 200
        } else {
            // si no consiguió actualizar el registro, envía un mensaje de error
            return response()->json(
                ['error' => 'No se pudo eliminar el periodo'],
                Response::HTTP_NOT_FOUND// 404
            );
        }
    } // fin metodo eliminar periodo
}
