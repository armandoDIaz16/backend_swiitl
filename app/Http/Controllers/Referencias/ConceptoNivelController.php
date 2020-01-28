<?php

namespace App\Http\Controllers\Referencias;

use App\Referencias\ConceptoNivel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ConceptoNivelController extends Controller
{
    /**
     * Muestra todas las relaciones entre concepto - nivel.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllConceptoNivel()
    {

        $relaciones = DB::table('TR_CONCEPTO_NIVEL')
            ->join('CAT_CONCEPTO',
                'TR_CONCEPTO_NIVEL.FK_CONCEPTO', '=', 'CAT_CONCEPTO.PK_CONCEPTO')
            ->join('CAT_NIVEL',
                'TR_CONCEPTO_NIVEL.FK_NIVEL', '=', 'CAT_NIVEL.PK_NIVEL')
            ->where('TR_CONCEPTO_NIVEL.BORRADO', '=', '0')
            ->select('TR_CONCEPTO_NIVEL.*', 'CAT_CONCEPTO.NOMBRE AS NOMBRECONCEPTO', 'CAT_NIVEL.NIVEL',
                'CAT_NIVEL.NOMBRE AS NOMBRENIVEL')
            ->get();

        return response()->json(
            $relaciones,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Crea una nueva relación entre concepto y nivel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createConceptoNivel(Request $request)
    {
        $relacion = new ConceptoNivel;

        $relacion->FK_CONCEPTO = $request->FK_CONCEPTO;
        $relacion->FK_NIVEL = $request->FK_NIVEL;
        $relacion->SEMESTRE = $request->SEMESTRE;

        $existe = DB::table('TR_CONCEPTO_NIVEL')
            ->select('TR_CONCEPTO_NIVEL.FK_CONCEPTO', 'FK_NIVEL', 'SEMESTRE')
            ->where('FK_CONCEPTO', '=', $request->FK_CONCEPTO)
            ->where('FK_NIVEL', '=', $request->FK_NIVEL)
            ->where('SEMESTRE', '=', $request->SEMESTRE)
            ->where('BORRADO', '=', '0')
            ->first();

        if (empty($existe)) {
            $relacion->save();

            return response()->json(
                $relacion,
                Response::HTTP_CREATED
            );
        } else {
            return response()->json(
                'La relación entre concepto y nivel en ese semestre ya fue creado y está activo.',
                Response::HTTP_CONFLICT
            );
        }
    }

    /**
     * Muestra la relación entre concepto - nivel
     * especificado por su PK, número de nivel y
     * nombre de nivel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getConceptoNivel(Request $request)
    {
        if (isset($request->PK) && $request->PK > 0) {                                                     //Si manda un PK
            $columna = 'PK_CONCEPTO_NIVEL';
            $criterio = $request->PK;

            //Buscar que existe la relacion de concepto - nivel con ese ID y que no haya sido borrado
            $conceptoNivel = DB::table('TR_CONCEPTO_NIVEL')
                ->where('PK_CONCEPTO_NIVEL', '=', $request->PK)
                ->where('BORRADO', '=', '0')
                ->select('TR_CONCEPTO_NIVEL.*')
                ->first();

            if (empty($conceptoNivel)) {
                return response()->json(
                    'No existe ninguna relación entre el concepto y en nivel con el ID enviado.',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else if(isset($request->NUMERO_NIVEL) && $request->NUMERO_NIVEL >= 0){    //Si manda un número de nivel
            $columna = 'CAT_NIVEL.NIVEL';
            $criterio = $request->NUMERO_NIVEL;
        } else if(isset($request->NOMBRE_NIVEL)) {                                  //Si manda el nombre del nivel
            $columna = 'CAT_NIVEL.NOMBRE';
            $criterio =  $request->NOMBRE_NIVEL;
        } else {
            return response()->json(
                'No se puede buscar una relación entre un concepto y nivel utilizando ese atributo.',
                Response::HTTP_BAD_REQUEST
            );
        }

        $relacion = DB::table('TR_CONCEPTO_NIVEL')
            ->join('CAT_CONCEPTO',
                'TR_CONCEPTO_NIVEL.FK_CONCEPTO', '=', 'CAT_CONCEPTO.PK_CONCEPTO')
            ->join('CAT_NIVEL',
                'TR_CONCEPTO_NIVEL.FK_NIVEL', '=', 'CAT_NIVEL.PK_NIVEL')
            ->where($columna, '=', $criterio)
            ->where('TR_CONCEPTO_NIVEL.BORRADO', '=', '0')
            ->select('TR_CONCEPTO_NIVEL.*', 'CAT_CONCEPTO.NOMBRE AS NOMBRE_CONCEPTO', 'CAT_NIVEL.NIVEL',
                'CAT_NIVEL.NOMBRE AS NOMBRE_NIVEL')
            ->get();

        return response()->json(
            $relacion,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Actualiza una relación concepto - nivel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateConceptoNivel(Request $request, $id)
    {
        //Busca relación concepto - nivel no eliminado con el id enviado
        $relacion = DB::table('TR_CONCEPTO_NIVEL')
            ->where('PK_CONCEPTO_NIVEL', '=', $id)
            ->where('BORRADO', '=', '0')
            ->select('TR_CONCEPTO_NIVEL.*');

        if (empty($relacion->first())) {
            return response()->json(
                'La relación entre el concepto y nivel con el ID enviado no existe.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            $relacion->update($request->all());

            return response()->json(
                $relacion->first(),
                Response::HTTP_ACCEPTED
            );
        }
    }

    /**
     * Da de baja una relación concepto - nivel
     * indicando que se ha borrado con un 1.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteConceptoNivel($id)
    {
        $relacion = ConceptoNivel::find($id);

        if (empty($relacion)) {
            return response()->json(
                'La relación entre el concepto y nivel con el ID enviado no existe.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            $relacion->BORRADO = '1';

            $relacion->save();

            return response()->json(
                'La relación entre el concepto y el nivel fue eliminado.',
                Response::HTTP_ACCEPTED
            );
        }
    }
}
