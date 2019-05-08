<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InformeTecnico;
use App\CreditosSiia;
use App\PeriodoResidencia;
use App\CargaArchivo;

class InformeTecnicoController extends Controller
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
        $fecha = new PeriodoResidencia();
        $dia = ('Y-m-d');
        $diai = $fecha->FIniA($request->FK_ALUMNO,5);
        $diaf = $fecha->FFinD($request->FK_ALUMNO,5);
        if ($diai<=$dia && $dia<=$diaf){
            $informe = new InformeTecnico();
            $carga = new CargaArchivo();
            $periodo = new CreditosSiia();
            $ruta = $carga->saveFile($request);
            $informe->INFORME = $ruta;
            $informe->FK_ALUMNO = $request->FK_ALUMNO;
            $informe->PERIODO = $periodo->periodo();
            $informe->save();
            return response()->json('Guardado ocn exito');
        }
        return response()->json('Fuera de fecha permitida');
    }

    public function show($id)
    {
        //
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
