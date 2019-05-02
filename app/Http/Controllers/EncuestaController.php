<?php

namespace App\Http\Controllers;

use App\Encuesta;
use App\Mensaje;
use App\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET
         $encuestas = Encuesta::get();
         echo json_encode($encuestas);
        //echo "Hello";
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
        //$encuesta->FECHA_REGISTRO = date('Y-m-d H:i:s');
        try {
            $encuesta = new Encuesta();
            $encuesta->NOMBRE = $request->input('NOMBRE');
            $encuesta->OBJETIVO = $request->input('OBJETIVO');
            $encuesta->INSTRUCCIONES = $request->input('INSTRUCCIONES');
            $encuesta->save();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::CREADO, $encuesta));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, $exception, $encuesta));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encuesta  $encuesta_id
     * @return \Illuminate\Http\Response
     */
    public function show($encuesta_id)
    {
        //get
        $encuesta = Encuesta::find($encuesta_id);
        echo json_encode($encuesta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encuesta  $encuesta_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $encuesta_id)
    {
        //PUT
        try{
            $encuesta = Encuesta::find($encuesta_id);
            $encuesta->NOMBRE = $request->input('NOMBRE');
            $encuesta->OBJETIVO = $request->input('OBJETIVO');
            $encuesta->INSTRUCCIONES = $request->input('INSTRUCCIONES');
            $encuesta->save();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::ACTUALIZADO, $encuesta));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $encuesta));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encuesta  $encuesta_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($encuesta_id)
    {
        //DELETE
        try{
        $encuesta = Encuesta::find($encuesta_id);
        $encuesta->delete();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::BORRADO, $encuesta));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $encuesta));
        }
    }
}
