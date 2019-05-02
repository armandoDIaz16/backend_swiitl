<?php

namespace App\Http\Controllers;

use App\CargaArchivo;
use App\CreditosSiia;
use App\ReporteDocente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteDocenteController extends Controller
{
    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $reporte = new ReporteDocente();
        $cargar = new CargaArchivo();
        $periodo = new CreditosSiia();
        $reporte->ALUMNO = $request->alumno;
        $reporte->PDF = $cargar->saveFile($request);
        $reporte->DOCENTE = $request->id;
        $reporte->NUMERO = $request->ID;
        $reporte->PERIODO = $periodo->periodo();
        try{
            $reporte->save();
            return json_encode('Guardado con exito!');}
        catch(\Exception $exception){
            return json_encode('Error al subir archivo');
        }
    }

    public function show($id)
    {
        $area = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :padre',['padre'=>$id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);
        $ianose = DB::select('SELECT * 
                                      FROM CAT_REPORTE_DOCENTE 
                                      JOIN CATR_DOCENTE ON CAT_REPORTE_DOCENTE.DOCENTE = CATR_DOCENTE.ID_PADRE
                                      WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = :id',['id'=>$area3]);
        return $ianose;
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
