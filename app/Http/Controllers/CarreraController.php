<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carreras = DB::table('TR_CARRERA_CAMPUS')
        ->select(DB::raw("TR_CARRERA_CAMPUS.PK_CARRERA_CAMPUS as PK_CARRERA, CAT_CARRERA.NOMBRE+' CAMPUS ' +CAT_CAMPUS.NOMBRE as NOMBRE"))
        ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS.FK_CAMPUS')
        ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS.FK_CARRERA')
        ->get();
        return $carreras;
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
