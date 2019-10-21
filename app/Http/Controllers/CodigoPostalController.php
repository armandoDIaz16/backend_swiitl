<?php

namespace App\Http\Controllers;

use App\Ciudad;
use App\CodigoPostal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CodigoPostalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CodigoPostal::select('PK_NUMERO_CODIGO_POSTAL','FK_CIUDAD')->get();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($CP)
    {
        return CodigoPostal::where('PK_NUMERO_CODIGO_POSTAL', $CP)->select('PK_NUMERO_CODIGO_POSTAL','FK_CIUDAD')->get();

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

    public function  procesa_codigo_postal(Request $request) {
        error_log("CP: " . $request->codigo_postal);

        if ($request->codigo_postal) {
            $data = [];

            $sql = "
                SELECT
                    CAT_PAIS.PK_PAIS,
                    CAT_PAIS.NOMBRE AS NOMBRE_PAIS,
                    CAT_ENTIDAD_FEDERATIVA.PK_ENTIDAD_FEDERATIVA,
                    CAT_ENTIDAD_FEDERATIVA.NOMBRE AS NOMBRE_ENTIDAD_FEDERATIVA,
                    CAT_CIUDAD.PK_CIUDAD,
                    CAT_CIUDAD.NOMBRE AS NOMBRE_CIUDAD,
                    CAT_CODIGO_POSTAL.PK_CODIGO_POSTAL,
                    CAT_CODIGO_POSTAL.NUMERO AS CODIGO_POSTAL
                FROM
                    CAT_CODIGO_POSTAL
                    LEFT JOIN TR_COLONIA_CODIGO_POSTAL
                        ON CAT_CODIGO_POSTAL.PK_CODIGO_POSTAL = TR_COLONIA_CODIGO_POSTAL.FK_CODIGO_POSTAL
                    LEFT JOIN CAT_COLONIA
                        ON TR_COLONIA_CODIGO_POSTAL.FK_COLONIA = CAT_COLONIA.PK_COLONIA
                    LEFT JOIN CAT_TIPO_ASENTAMIENTO
                        ON CAT_COLONIA.FK_TIPO_ASENTAMIENTO = CAT_TIPO_ASENTAMIENTO.PK_TIPO_ASENTAMIENTO
                    LEFT JOIN CAT_CIUDAD
                        ON CAT_CODIGO_POSTAL.FK_CIUDAD = CAT_CIUDAD.PK_CIUDAD
                    LEFT JOIN CAT_ENTIDAD_FEDERATIVA
                        ON CAT_CIUDAD.FK_ENTIDAD_FEDERATIVA = CAT_ENTIDAD_FEDERATIVA.PK_ENTIDAD_FEDERATIVA
                    LEFT JOIN CAT_PAIS ON CAT_ENTIDAD_FEDERATIVA.FK_PAIS = CAT_PAIS.PK_PAIS
                WHERE
                    CAT_CODIGO_POSTAL.NUMERO = '".$request->codigo_postal."'
            ;";

            $datos = DB::select($sql);

            error_log(print_r($datos, true));
            error_log($sql);

            if ($datos) {
                $data['PK_PAIS']                   = $datos[0]->PK_PAIS;
                $data['NOMBRE_PAIS']               = $datos[0]->NOMBRE_PAIS;
                $data['PK_ENTIDAD_FEDERATIVA']     = $datos[0]->PK_ENTIDAD_FEDERATIVA;
                $data['NOMBRE_ENTIDAD_FEDERATIVA'] = $datos[0]->NOMBRE_ENTIDAD_FEDERATIVA;
                $data['PK_CIUDAD']                 = $datos[0]->PK_CIUDAD;
                $data['NOMBRE_CIUDAD']             = $datos[0]->NOMBRE_CIUDAD;
                $data['PK_CODIGO_POSTAL']          = $datos[0]->PK_CODIGO_POSTAL;
                $data['CODIGO_POSTAL']             = $datos[0]->CODIGO_POSTAL;
            }

            return response()->json(['data' => $data], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'No existe el código postal'], Response::HTTP_NOT_FOUND);
        }
    }
}
