<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PK_PERIODO_PREFICHAS = Periodo::max('PK_PERIODO_PREFICHAS');

        $periodo = Periodo::select('PK_PERIODO_PREFICHAS','FECHA_INICIO','FECHA_FIN')
        ->where('PK_PERIODO_PREFICHAS',$PK_PERIODO_PREFICHAS)
        ->get();
        
        if(isset ($periodo[0])){
            return [
                array(
                'PK_PERIODO_PREFICHAS' => $periodo[0]->PK_PERIODO_PREFICHAS,
                'FECHA_INICIO' => $periodo[0]->FECHA_INICIO,
                'FECHA_FIN' => $periodo[0]->FECHA_FIN,
                'FECHA_ACTUAL' => $this->fechaActual()
                )
            ];
        }
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
        if($request->PK_PERIODO_PREFICHAS){        
            $periodo = Periodo::select('PK_PERIODO_PREFICHAS','FECHA_INICIO','FECHA_FIN','FK_USUARIO_MODIFICACION')
            ->where('PK_PERIODO_PREFICHAS',$request->PK_PERIODO_PREFICHAS)
            ->update(['FECHA_INICIO' => $request->FECHA_INICIO,
                        'FECHA_FIN' => $request->FECHA_FIN,
                        'FK_USUARIO_MODIFICACION' => $request->FK_USUARIO_MODIFICACION]);

        }else{
            $periodo = new Periodo();
            $periodo->FECHA_INICIO = $request->FECHA_INICIO;
            $periodo->FECHA_FIN = $request->FECHA_FIN;
            $periodo->FK_USUARIO_REGISTRO = $request->FK_USUARIO_REGISTRO;
            $periodo->save();

            return Periodo::max('PK_PERIODO_PREFICHAS');
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
