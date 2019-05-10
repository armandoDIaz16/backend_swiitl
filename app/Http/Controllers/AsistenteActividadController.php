<?php

namespace App\Http\Controllers;

use App\asistenteActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AsistenteActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asistente_actividad = asistenteActividad::get();
        $response = Response::json($asistente_actividad);
        return $response;
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
        $sistente_actividad = new asistenteActividad();
        $sistente_actividad->FK_USUARIO = $request->FK_USUARIO;
        $sistente_actividad->FK_ACTIVIDAD = $request->FK_ACTIVIDAD;
        $sistente_actividad->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function show($pk_actividad)//muestra la lista de alumnos designados para tomar asistencia en alguna actividad en especifico
    {
        $asitentes = asistenteActividad::join('users','PK_USUARIO','=','FK_USUARIO')
                        ->select('PRIMER_APELLIDO','SEGUNDO_APELLIDO','name')
                        ->where('FK_ACTIVIDAD','=',$pk_actividad)
                        ->get();
    
        $response = Response::json($asitentes);
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function edit(asistenteActividad $asistenteActividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, asistenteActividad $asistenteActividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sistente_actividad = asistenteActividad::find($id);
        $sistente_actividad->delete();
    }
}
