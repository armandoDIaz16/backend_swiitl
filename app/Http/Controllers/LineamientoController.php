<?php

namespace App\Http\Controllers;

use App\lineamiento;
use Illuminate\Http\Request;

class LineamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lineamiento = Lineamiento::get();
        echo json_encode($lineamiento);
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
        $lineamiento = new Lineamiento();
        $lineamiento->NOMBRE = $request->input('NOMBRE');
        $lineamiento->LIMITE = $request->input('LIMITE');
        $lineamiento->save();
        echo json_encode($lineamiento);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\lineamiento  $lineamiento
     * @return \Illuminate\Http\Response
     */
    public function show(lineamiento $lineamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lineamiento  $lineamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(lineamiento $lineamiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lineamiento  $lineamiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lineamiento_id)
    {
        $lineamiento = Lineamiento::find($lineamiento_id);
        $lineamiento->NOMBRE = $request->input('NOMBRE');
        $lineamiento->LIMITE = $request->input('LIMITE');
        $lineamiento->save();
        echo json_encode($lineamiento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lineamiento  $lineamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy($lineamiento_id)
    {
        $lineamiento = Lineamiento::find($lineamiento_id);
        $lineamiento->delete();
    }
}

