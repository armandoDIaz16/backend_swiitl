<?php

namespace App\Http\Controllers;

use App\ReporteResidencia;
use Illuminate\Http\Request;

class ReporteResidenciaController extends Controller
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
        $reporte = new ReporteResidencia();
        $File = $request -> file('myfile');
        $sub_path = 'files';
        $real_name =  /* 'Reporte'.$id.$request->ID; */ $File -> getClientOriginalName();
        $destination_path = public_path($sub_path);
        $File->move($destination_path,  $real_name);
        $Ruta = $sub_path.'/'.$real_name;
        $reporte->NOMBRE = $real_name;
        $reporte->ALUMNO = $request->id;
        $reporte->PDF = $Ruta;
        $reporte->NUMERO = $request->ID;
        $reporte->save();
        return response()->json('Reporte guardado');
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
