<?php

namespace App\Http\Controllers;

use App\CargaArchivo;
use App\CartaFinalizacion;
use App\CreditosSiia;
use App\DocumentacionResidencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartaFinalizacionController extends Controller
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
        $periodo = new CreditosSiia();
        $carta = DocumentacionResidencias::where([['ALUMNO',$request->FK_ALUMNO],['PERIODO',$periodo->periodo()]])->get();
        $carga = new CargaArchivo();
        $fecha = new PeriodoResidencia();
        try{
        $diai = $fecha->FIniA($request->FK_ALUMNO, 5);
        $diaf = $fecha->FFinA($request->FK_ALUMNO, 5);
        }
        catch(\Exception $exception){
            return response()->json('Fecha aun no activa');
        }
        $dia = date('Y-m-d');
        if ($diai<=$dia && $dia<=$diaf) {
            $Ruta = $carga->saveFile($request);
            $carta->CARTA = $Ruta;
            $carta->save();
            return response()->json('Carta guardada');
        }
        return response()->json('No se puede entregar fuera de fecha');
    }


    public function show($id)
    {
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $carta = DB::select('SELECT CARTA FROM CAT_CARTA_FINALIZACION_RESIDENCIAS
                                    JOIN CATR_ALUMNO ON CAT_CARTA_FINALIZACION_RESIDENCIAS.FK_ALUMNO = CATR_ALUMNO.ID_PADRE
                                    JOIN CATR_CARRERA ON CATR_ALUMNO.CLAVE_CARRERA = CATR_CARRERA.CLAVE 
                                    WHERE CATR_CARRERA.FK_AREA_ACADEMICA = :caa
                                    AND CAT_CARTA_FINALIZACION_RESIDENCIAS.PERIODO = :periodo',['caa'=>$id,'periodo'=>$actual]);

        return $carta;
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
