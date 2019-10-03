<?php

namespace App\Http\Controllers\ServicioSocial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ServicioSocial\Convocatoria;
use App\ServicioSocial\DatoConvocatoria;


class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $convocatoria = new Convocatoria;
        $datoConvocatoria = new DatoConvocatoria;
        $convocatoria->NO_CONTROL_CONV = $request->NO_CONTROL_CONV;

        $datoConvocatoria->FK_CONVOCATOTIA = $request->FK_CONVOCATOTIA;   
        $datoConvocatoria->TURNO = $request->TURNO;
        $datoConvocatoria->FK_ESPACIO_CONVOCATORIA = $request->FK_ESPACIO_CONVOCATORIA;
        $datoConvocatoria->HORARIO_INICIO = $request->HORARIO_INICIO;
        $datoConvocatoria->HORARIO_FIN = $request->HORARIO_FIN;
        $datoConvocatoria->FECHA_CONVOCATORIA = $request->FECHA_CONVOCATORIA;
        $datoConvocatoria->PERIODO = $request->PERIODO;
        $convocatoria->save();
        $datoConvocatoria->save();
        return 200;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Convocatoria::where('PK_CONVOCATORIA',$id)->get();
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
