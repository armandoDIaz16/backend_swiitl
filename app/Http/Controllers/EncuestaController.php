<?php

namespace App\Http\Controllers;

use App\Encuesta;
use App\Pregunta;
use App\Respuesta_Posible;
use App\Seccion_Encuesta;
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


    public function showEncuestas(Request $request){
        //POST
        $encuesta_id = $request->id_encuesta;

        $array_secciones = array();
        $array_preguntas = array();

        $encuesta = Encuesta::where('PK_ENCUESTA', $encuesta_id)
            ->select('PK_ENCUESTA','NOMBRE','CAT_ENCUESTA.OBJETIVO','CAT_ENCUESTA.INSTRUCCIONES')
            ->first();



        $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $encuesta_id)->get();
            foreach ($secciones as $seccion) {
                $array_secciones[] = array(
                    'PK_MODULO' => $seccion->PK_SECCION,
                    'NOMBRE' => $seccion->NOMBRE_SECCION,
                    'NUMERO_SECCION' => $seccion->NUMERO_SECCION,
                    'OBJETIVO' => $seccion->OBJETIVO,
                    'INSTRUCCIONES' => $seccion->INSTRUCCIONES,
                    "PREGUNTAS" => $array_preguntas
                );

                $preguntas = Pregunta::where('FK_SECCION', $seccion->PK_SECCION)->get();
                foreach ($preguntas as $pregunta) {
                    $array_preguntas[] = array(
                        'PK_MODEL' => $pregunta->PK_PREGUNTA,
                        'ORDEN' => $pregunta->ORDEN,
                        'PLANTEAMIENTO' => $pregunta->PLANTEAMIENTO,
                        'TEXTO_GUIA' => $pregunta->TEXTO_GUIA,
                        "RESPUESTAS" => Respuesta_Posible::where('FK_PREGUNTA', $pregunta->PK_PREGUNTA)->get()
                    );
                }
            }
        return  array(
            "encuesta" => array(
                "PK_ENCUESTA"   => $encuesta->PK_ENCUESTA,
                "NOMBRE"        => $encuesta->NOMBRE,
                "OBJETIVO"      => $encuesta->OBJETIVO,
                "INSTRUCCIONES" => $encuesta->INSTRUCCIONES,
                "SECCIONES"     => $array_secciones
            )
        );


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
