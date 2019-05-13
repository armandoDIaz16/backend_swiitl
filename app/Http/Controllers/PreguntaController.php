<?php

namespace App\Http\Controllers;

use App\Pregunta;
use App\Mensaje;
use App\Respuesta;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Echo_;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pregunta = Pregunta::get();
        echo json_encode($pregunta);
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
        //POST
        try {
            $pregunta = new Pregunta();
            $pregunta->ORDEN  = $request->input('ORDEN');
            $pregunta->PLANTEAMIENTO = $request->input('PLANTEAMIENTO');
            $pregunta->TEXTO_GUIA = $request->input('TEXTO_GUIA');
            $pregunta->save();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::CREADO, $pregunta));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $pregunta));
           //return $exception;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $pregunta_id
     * @return \Illuminate\Http\Response
     */
    public function show($pregunta_id)
    {
        //get
        $pregunta = Pregunta::find($pregunta_id);
        echo json_encode($pregunta);
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
     * @param  int  $pregunta_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pregunta_id)
    {

        //PUT
        try {
            $pregunta = Pregunta::find($pregunta_id);
            $pregunta->ORDEN  = $request->input('ORDEN');
            $pregunta->PLANTEAMIENTO = $request->input('PLANTEAMIENTO');
            $pregunta->TEXTO_GUIA = $request->input('TEXTO_GUIA');
            $pregunta->save();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::ACTUALIZADO, $pregunta));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $pregunta));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $pregunta_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pregunta_id)
    {
        //DELETE
        try{
            $pregunta = Pregunta::find($pregunta_id);
            $pregunta->delete();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::BORRADO, $pregunta));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $pregunta));
        }
    }
}
