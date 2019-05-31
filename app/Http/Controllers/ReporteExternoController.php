<?php

namespace App\Http\Controllers;

use App\CargaArchivo;
use App\CreditosSiia;
use App\PeriodoResidencia;
use App\ReporteExterno;
use Illuminate\Http\Request;

class ReporteExternoController extends Controller
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
        $reporte = new ReporteExterno();
        $cargar = new CargaArchivo();
        $periodo = new CreditosSiia();
        $fecha = new PeriodoResidencia();
        $x = $request->ID;
        $y = 0;
        switch($x){
            case 1:
                $y = 3;
                break;
            case 2:
                $y = 4;
                break;
            case 3:
                $y = 5;
                break;
        }
        try{
        $diai = $fecha->FIniD($request->id, $y);
        $diaf = $fecha->FFinD($request->id, $y);
        }
        catch(\Exception $exception){
            return response()->json('Fecha aun no activa');
        }
        $dia = date('Y-m-d');
        if ($diai<=$dia && $dia<=$diaf) {
            $reporte->ALUMNO = $request->alumno;
            $reporte->PDF = $cargar->saveFile($request);
            $reporte->EXTERNO = $request->id;
            $reporte->NUMERO = $request->ID;
            $reporte->PERIODO = $periodo->periodo();
            try {
                $reporte->save();
                return json_encode('Guardado con exito!');
            } catch (\Exception $exception) {
                return json_encode('Error al subir archivo');
            }
        }
        return response()->json('Fuera de fecha para entregar reporte');
    }


    public function show($id)
    {
        $var = DB::select('SELECT * 
                           FROM CAT_REPORTE_EXTERNO 
                           JOIN CATR_EXTERNO ON CAT_REPORTE_EXTERNO.EXTERNO = CATR_EXTERNO.ID_PADRE
                           JOIN users ON CAT_REPORTE_EXTERNO.ALUMNO = users.PK_USUARIO
                           WHERE CATR_EXTERNO.ID_PADRE = :id',['id'=>$id]);
        return $var;
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
