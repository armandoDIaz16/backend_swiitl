<?php

namespace App\Http\Controllers\Referencias;

use App\Referencias\Concepto;
use App\Referencias\LogConcepto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ConceptoController extends Controller
{
    /**
     * Muestra todos los conceptos.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConceptos()
    {
        //Busca conceptos no eliminados
        $conceptos = DB::table('CAT_CONCEPTO')
            ->join('CAT_AREA_ACADEMICA',
                'CAT_CONCEPTO.FK_AREA_ACADEMICA', '=', 'CAT_AREA_ACADEMICA.PK_AREA_ACADEMICA')
            ->where('CAT_CONCEPTO.BORRADO', '=', '0')
            ->select('CAT_CONCEPTO.*', 'CAT_AREA_ACADEMICA.NOMBRE AS NOMBRE_AREA_ACADEMICA')
            ->get();

        return response()->json(
            $conceptos,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Crea un concepto y registra en la bitácora su creación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createConcepto(Request $request)
    {
        $concepto = new Concepto;
        $logConcepto = new LogConcepto;

        $concepto->FK_AREA_ACADEMICA = $request->FK_AREA_ACADEMICA;
        $concepto->NOMBRE = $request->NOMBRE;
        $concepto->DESCRIPCION = $request->DESCRIPCION;
        $concepto->MONTO = $request->MONTO;
        $concepto->VIGENCIA_INICIAL = $request->VIGENCIA_INICIAL;
        $concepto->VIGENCIA_FINAL = $request->VIGENCIA_FINAL;
        $concepto->ES_MONTO_VARIABLE = $request->ES_MONTO_VARIABLE;
        $concepto->ES_CANTIDAD_VARIABLE = $request->ES_CANTIDAD_VARIABLE;
        $concepto->CLAVE_CONTPAQ = $request->CLAVE_CONTPAQ;
        $concepto->ESTATUS = $request->ESTATUS;
        $concepto->CLAVE_CONTPAQ_TECNM = $request->CLAVE_CONTPAQ_TECNM;
        $concepto->FK_VALE = $request->FK_VALE;
        $concepto->GENERA_DOCUMENTO = $request->GENERA_DOCUMENTO;

        //Busca un concepto no eliminado con el mismo nombre, asignado a la misma area que el que se quiere crear
        $existe = DB::table('CAT_CONCEPTO')
            ->select('CAT_CONCEPTO.NOMBRE', 'CAT_CONCEPTO.FK_AREA_ACADEMICA')
            ->where('NOMBRE', '=', $request->NOMBRE)
            ->where('FK_AREA_ACADEMICA', '=', $request->FK_AREA_ACADEMICA)
            ->where('BORRADO', '=', '0')
            ->first();

        if (empty($existe)) {
            $concepto->save();

            $logConcepto->FK_CONCEPTO = $concepto->PK_CONCEPTO;
            $logConcepto->MONTO_ANTERIOR = $concepto->MONTO;
            $logConcepto->MONTO_NUEVO = $concepto->MONTO;

            $logConcepto->save();

            return response()->json(
                [$concepto, $logConcepto],
                Response::HTTP_CREATED
            );
        } else {
            return response()->json(
                'El concepto con ese nombre ligado a esa area académica ya existe.',
                Response::HTTP_CONFLICT
            );
        }
    }

    /**
     * Muestra un concepto especificado por su PK.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getConcepto($id)
    {
        //Busca un concepto no eliminado con el id enviado
        $concepto = DB::table('CAT_CONCEPTO')
            ->join('CAT_AREA_ACADEMICA',
                'CAT_CONCEPTO.FK_AREA_ACADEMICA', '=', 'CAT_AREA_ACADEMICA.PK_AREA_ACADEMICA')
            ->where('PK_CONCEPTO', '=', $id)
            ->where('CAT_CONCEPTO.BORRADO', '=', '0')
            ->select('CAT_CONCEPTO.*', 'CAT_AREA_ACADEMICA.NOMBRE AS NOMBRE_AREA_ACADEMICA')
            ->first();

        if (empty($concepto)) {
            return response()->json(
                'No existe ningún concepto con el ID enviado.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                $concepto,
                Response::HTTP_ACCEPTED
            );
        }
    }

    /**
     * Actualiza un concepto y registra la actualización en la
     * bitácora si el monto cambio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateConcepto(Request $request, $id)
    {
        //Busca concepto no eliminado con el id enviado
        $concepto = DB::table('CAT_CONCEPTO')
            ->where('PK_CONCEPTO', '=', $id)
            ->where('BORRADO', '=', '0')
            ->select('CAT_CONCEPTO.*');

        $logConcepto = new LogConcepto;

        if (empty($concepto->first())) {
            return response()->json(
                'El concepto con el ID enviado no existe.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            $logConcepto->FK_CONCEPTO = $concepto->first()->PK_CONCEPTO;
            $logConcepto->MONTO_ANTERIOR = $concepto->first()->MONTO;

            $concepto->update($request->all());

            $logConcepto->MONTO_NUEVO = $concepto->first()->MONTO;

            //Si el monto del concepto cambio, guardar en bitacora
            if ($logConcepto->MONTO_ANTERIOR != $logConcepto->MONTO_NUEVO) {
                $logConcepto->save();
            }

            return response()->json(
                [$concepto->first(), $logConcepto],
                Response::HTTP_ACCEPTED
            );
        }
    }

    /**
     * Da de baja un concepto cambiado su estatus a 0
     * e indicando que se ha borrado con un 1.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteConcepto($id)
    {
        //Busca concepto no eliminado con el id enviado
        $concepto = DB::table('CAT_CONCEPTO')
            ->where('PK_CONCEPTO', '=', $id)
            ->where('BORRADO', '=', '0')
            ->select('CAT_CONCEPTO.*');
        $conceptoFirst=$concepto->first();

        if (empty($conceptoFirst)) {
            return response()->json(
                'El concepto con el ID enviado no existe.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            $concepto->update([
                'ESTATUS' => 0,
                'BORRADO' => 1
            ]);

            return response()->json(
                'El concepto fue borrado.',
                Response::HTTP_ACCEPTED
            );
        }
    }
}
