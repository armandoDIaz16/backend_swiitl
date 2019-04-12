<?php

namespace App\Http\Controllers;

use App\PAAE;
use Illuminate\Http\Request;

class PAAE_Periodo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PK_PAAE_PERIODO = PAAE::select('FECHA_INICIO','FECHA_FIN')->max('PK_PAAE_PERIODO');

        $periodo = PAAE::select('FECHA_INICIO','FECHA_FIN')
        ->where('PK_PAAE_PERIODO',$PK_PAAE_PERIODO)
        ->get()[0];
        
        return [
            array(
            'FECHA_INICIO' => $periodo->FECHA_INICIO,
            'FECHA_FIN' => $periodo->FECHA_FIN,
            'FECHA_ACTUAL' => $this->fechaActual()
            )
        ];
    }

    public function fechaActual(){
        $fechaActual = Date('Y').'-';
        $fechaActual = $fechaActual .Date('m').'-';
        $fechaActual = $fechaActual .Date('d');
        return $fechaActual;
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
        if($request->FK_USUARIO_REGISTRO){
            $periodo = new PAAE();
            $periodo->FECHA_INICIO = $request->FECHA_INICIO;
            $periodo->FECHA_FIN = $request->FECHA_FIN;
            $periodo->FK_USUARIO_REGISTRO = $request->FK_USUARIO_REGISTRO;
            $periodo->save();
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
