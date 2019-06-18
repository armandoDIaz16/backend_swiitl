<?php

namespace App\Http\Controllers;

use App\Aplicacion_Encuesta;
use Illuminate\Http\Request;

class Aplicacion_EncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $aplicacion = Aplicacion_Encuesta::get();
        echo json_encode($aplicacion);
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
            $aplica_e = new Aplicacion_Encuesta();
            $aplica_e->FECHA_APLICACION = date('Y-m-d H:i:s');
            $aplica_e->save();
            return response()->json((array) new Respuesta('OK', 200, Mensaje::CREADO, $aplica_e));
        }catch (\Exception $exception){
            return response()->json((array) new Respuesta('ERROR', 400, Mensaje::BD_ERR, $aplica_e));
        }
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
