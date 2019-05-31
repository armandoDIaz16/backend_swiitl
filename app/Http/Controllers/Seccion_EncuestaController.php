<?php

namespace App\Http\Controllers;

use App\Seccion_Encuesta;
use App\Mensaje;
use App\Respuesta;
use Illuminate\Http\Request;

class Seccion_EncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET
        $seccion = Seccion_Encuesta::get();
        echo json_encode($seccion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST
        //$seccion_e->FECHA_REGISTRO = date('Y-m-d H:i:s');
        try {
            $seccion_e = new Seccion_Encuesta();
            $seccion_e->NOMBRE_SECCION = $request->input('NOMBRE_SECCION');
            $seccion_e->NUMERO_SECCION = $request->input('NUMERO_SECCION');
            $seccion_e->OBJETIVO = $request->input('OBJETIVO');
            $seccion_e->INSTRUCCIONES = $request->input('INSTRUCCIONES');
            $seccion_e->save();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::CREADO, $seccion_e));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $seccion_e));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $seccion_id
     * @return \Illuminate\Http\Response
     */
    public function show($seccion_id)
    {
        //get
        $seccion_e = Seccion_Encuesta::find($seccion_id);
        echo json_encode($seccion_e);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $seccion_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seccion_id)
    {
        //PUT
        try {
            $seccion_e = Seccion_Encuesta::find($seccion_id);
            $seccion_e->NOMBRE_SECCION = $request->input('NOMBRE_SECCION');
            $seccion_e->NUMERO_SECCION = $request->input('NUMERO_SECCION');
            $seccion_e->OBJETIVO = $request->input('OBJETIVO');
            $seccion_e->INSTRUCCIONES = $request->input('INSTRUCCIONES');
            $seccion_e->save();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::ACTUALIZADO, $seccion_e));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $seccion_e));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $seccion_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seccion_id)
    {
        //DELETE
        try{
            $seccion_e = Seccion_Encuesta::find($seccion_id);
            $seccion_e->delete();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::BORRADO, $seccion_e));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $seccion_e));
        }
    }
}
