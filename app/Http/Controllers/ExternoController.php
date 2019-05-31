<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExternoController extends Controller
{

    public function index()
    {
        $externo = DB::select('SELECT name, ID_PADRE FROM users JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE');
        return $externo;
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $area = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :id',['id'=>$id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);
        $externo = DB::select('SELECT name, PK_USUARIO 
                                      FROM users
                                      JOIN CATR_EXTERNO ON users.PK_USUARIO = CATR_EXTERNO.ID_PADRE
                                      JOIN CATR_PROYECTO ON CATR_EXTERNO.ID_PADRE = CATR_PROYECTO.FK_ASESOR_EXT
                                      JOIN CATR_DOCENTE ON CATR_PROYECTO.FK_DOCENTE = CATR_DOCENTE.ID_PADRE
                                      WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = :area',['area'=>$area3]);
        return $externo;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
