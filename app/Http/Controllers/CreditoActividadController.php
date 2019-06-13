<?php

namespace App\Http\Controllers;

use App\credito_actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class CreditoActividadController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\credito_actividad  $credito_actividad
     * @return \Illuminate\Http\Response
     */
    public function show(credito_actividad $credito_actividad)
    {
        //
    }

    public function getActByCredito($pk_alumno_credito){
        $act = credito_actividad::join('ACTIVIDADES','FK_ACTIVIDAD','=','PK_ACTIVIDAD')
        ->selectRAW("ACTIVIDADES.PK_ACTIVIDAD, ACTIVIDADES.NOMBRE, replace(convert(NVARCHAR, ACTIVIDADES.FECHA, 106), ' ', '/') as FECHA")
        ->where('FK_ALUMNO_CREDITO','=',$pk_alumno_credito)
        ->get();
        $response = Response::json($act);
        return $response;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\credito_actividad  $credito_actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(credito_actividad $credito_actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\credito_actividad  $credito_actividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, credito_actividad $credito_actividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\credito_actividad  $credito_actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(credito_actividad $credito_actividad)
    {
        //
    }
}
