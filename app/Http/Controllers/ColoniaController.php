<?php

namespace App\Http\Controllers;

use App\Colonia;
use Illuminate\Http\Request;

class ColoniaController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colonias = Colonia::select('CAT_COLONIA.PK_COLONIA','CAT_COLONIA.NOMBRE')
        ->join('TR_COLONIA_CODIGO_POSTAL', 'TR_COLONIA_CODIGO_POSTAL.FK_COLONIA', '=', 'CAT_COLONIA.PK_COLONIA')
        ->join('CAT_CODIGO_POSTAL', 'CAT_CODIGO_POSTAL.PK_CODIGO_POSTAL', '=', 'TR_COLONIA_CODIGO_POSTAL.FK_CODIGO_POSTAL')
            ->where('CAT_CODIGO_POSTAL.NUMERO', $id)
            ->get();
        return $colonias;
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
