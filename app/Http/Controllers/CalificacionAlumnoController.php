<?php

namespace App\Http\Controllers;

use App\CalificacionAlumno;
use App\CreditosSiia;
use http\Env\Response;
use Illuminate\Http\Request;
use App\PeriodoResidencia;
use Illuminate\Support\Facades\DB;

class CalificacionAlumnoController extends Controller
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
        $dia = date('Y-m-d');
        $fecha = new PeriodoResidencia();
        $diai = $fecha->FIniD($request->FK_DOCENTE,5);
        $diaf = $fecha->FFinD($request->FK_DOCENTE,5);
        \Log::debug('dia: '.$dia.' dia inicio: '.$diai.' dia fin: '.$diaf);
        if($diai<=$dia && $dia<=$diaf){
            $calificacion = new CalificacionAlumno();
            $periodo = new CreditosSiia();
            $cal = DB::select('SELECT CATR_CALIFICACION_ALUMNO.CALIFICACION FROM CATR_CALIFICACION_ALUMNO WHERE FK_ALUMNO = :id',['id'=>$request->FK_ALUMNO]);
            if($cal != null){
                return respose()->json('Alumno ya estaba calificado');
            }else {
                $calificacion->CALIFICACION = $request->CALIFICACION;
                $calificacion->TITULACION = $request->TITULACION;
                $calificacion->OBSERVACIONES = $request->OBSERVACIONES;
                $calificacion->FK_ALUMNO = $request->FK_ALUMNO;
                $calificacion->FK_DOCENTE = $request->FK_DOCENTE;
                $calificacion->PERIODO = $periodo->periodo();
                $calificacion->save();
                return response()->json('Guardada con exito');
            }
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
