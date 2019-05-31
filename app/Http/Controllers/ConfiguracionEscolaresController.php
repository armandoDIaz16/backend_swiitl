<?php

namespace App\Http\Controllers;

use App\ConfiguracionEscolares;
use App\CreditosSiia;
use Illuminate\Http\Request;

class ConfiguracionEscolaresController extends Controller
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
        $info = new ConfiguracionEscolares();
        $periodo = new CreditosSiia();

        $info->FOLIO = $request->FOLIO;
        $info->FECHA = $request->FECHA;
        $info->PERIODO = $periodo->periodo();
        $info->save();
        return response()->json('Gusrdado con exito');
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
