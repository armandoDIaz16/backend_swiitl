<?php

namespace App\Http\Controllers;

use App\PeriodoResidencia;
use App\CreditosSiia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodoResidenciaController extends Controller
{
    public function index()
    {
        return date('Y-m-d');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $anteproyecto = new PeriodoResidencia();
        $periodo = new CreditosSiia();
        if($request->FK_AREA_ACADEMICA != 5){
            $x = $request->FK_AREA_ACADEMICA;
            $id = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :id',['id'=>$x]);
            $id1 = json_decode(json_encode($id),true);
            $id2 = array_pop($id1);
            $id3 = array_pop($id2);
            $anteproyecto->FK_AREA_ACADEMICA = $id3;
        }else{
        $anteproyecto->FK_AREA_ACADEMICA = $request->FK_AREA_ACADEMICA;}
        $anteproyecto->ID_PROCESO = $request->ID_PROCESO;
        $anteproyecto->FECHA_INICIO = $request->FECHA_INICIO;
        $anteproyecto->FECHA_FIN = $request->FECHA_FIN;
        $anteproyecto->PERIODO = $periodo->periodo();
        $anteproyecto->save();
    }


    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $ID_ANTEPROYECTO)
    {

    }

    public function destroy($id)
    {
        //
    }
}
