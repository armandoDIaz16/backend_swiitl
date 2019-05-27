<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{

    public function index()
    {
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $proyectos = DB::select('select count(NOMBRE) from CAT_ANTEPROYECTO_RESIDENCIA
                                        JOIN users on CAT_ANTEPROYECTO_RESIDENCIA.AUTOR =users.PK_USUARIO
                                        JOIN CATR_ALUMNO ON users.PK_USUARIO = CATR_ALUMNO.ID_PADRE
                                        WHERE PERIODO = :periodo',['periodo'=>$actual]);
        $proyectos1 = json_decode(json_encode($proyectos),true);
        $proyectos2 = array_pop($proyectos1);
        $proyectos3 = array_pop($proyectos2);
        return $proyectos3;
    }


    public function totalproyectos(){
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $proyectos = DB::select('SELECT COUNT(NOMBRE) AS Total FROM CAT_ANTEPROYECTO_RESIDENCIA
                                        WHERE PERIODO = :periodo',['periodo'=>$actual]);
        $proyectos1 = json_decode(json_encode($proyectos), true);
        $proyectos2 = array_pop($proyectos1);
        $proyectos3 = array_pop($proyectos2);

        return $proyectos3;
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $area = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :padre',['padre'=>$request->id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);
        $total = $request->total;
        if($total == 1){
            $reporte = DB::select('SELECT COUNT(PK_REPORTE_DOCENTE) AS Proyectos FROM CAT_REPORTE_DOCENTE
                                          JOIN CATR_DOCENTE ON CAT_REPORTE_DOCENTE.DOCENTE = CATR_DOCENTE.ID_PADRE
                                          WHERE PERIODO = :periodo
                                          AND CATR_DOCENTE.ID_AREA_ACADEMICA = :area',['periodo'=>$actual,'area'=>$area3]);
            $reporte1 = json_decode(json_encode($reporte),true);
            $reporte2 = array_pop($reporte1);
            $reporte3 = array_pop($reporte2);

            return $reporte3;
        }elseif($total == 2){
            $numero = $request->NUMERO;
            $reporte = DB::select('SELECT COUNT(PK_REPORTE_DOCENTE) AS Proyectos FROM CAT_REPORTE_DOCENTE
                                          JOIN CATR_DOCENTE ON CAT_REPORTE_DOCENTE.DOCENTE = CATR_DOCENTE.ID_PADRE
                                          WHERE PERIODO = :periodo
                                          AND CATR_DOCENTE.ID_AREA_ACADEMICA = :area
                                          AND CAT_REPORTE_DOCENTE.NUMERO = :numero',['periodo'=>$actual,'area'=>$area3,'numero'=>$numero]);
            $reporte1 = json_decode(json_encode($reporte),true);
            $reporte2 = array_pop($reporte1);
            $reporte3 = array_pop($reporte2);

            return $reporte3;
        }elseif ($total == 3){
            $reporte = DB::select('SELECT COUNT(PK_REPORTE_EXTERNO)
                                          FROM CAT_REPORTE_EXTERNO
                                          JOIN CATR_PROYECTO ON CAT_REPORTE_EXTERNO.EXTERNO = CATR_PROYECTO.FK_ASESOR_EXT
                                          JOIN CATR_DOCENTE ON CATR_PROYECTO.FK_DOCENTE = CATR_DOCENTE.ID_PADRE
                                          WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = :area
                                          AND CAT_REPORTE_EXTERNO.PERIODO = :periodo',['area'=>$area3,'periodo'=>$actual]);
            $reporte1 = json_decode(json_encode($reporte),true);
            $reporte2 = array_pop($reporte1);
            $reporte3 = array_pop($reporte2);

            return $reporte3;
        }elseif ($total == 4){
            $numero = $request->NUMERO;
            $reporte = DB::select('SELECT COUNT(PK_REPORTE_EXTERNO)
                                          FROM CAT_REPORTE_EXTERNO
                                          JOIN CATR_PROYECTO ON CAT_REPORTE_EXTERNO.EXTERNO = CATR_PROYECTO.FK_ASESOR_EXT
                                          JOIN CATR_DOCENTE ON CATR_PROYECTO.FK_DOCENTE = CATR_DOCENTE.ID_PADRE
                                          WHERE CATR_DOCENTE.ID_AREA_ACADEMICA = :area
                                          AND CAT_REPORTE_EXTERNO.PERIODO = :periodo
                                          AND CAT_REPORTE_EXTERNO.NUMERO = :numero',['area'=>$area3,'periodo'=>$actual, 'numero'=>$numero]);
            $reporte1 = json_decode(json_encode($reporte),true);
            $reporte2 = array_pop($reporte1);
            $reporte3 = array_pop($reporte2);

            return $reporte3;
        }
        return response()->json('Error');
    }


    public function reportestotal(Request $request){
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $area = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :padre',['padre'=>$request->id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);
        $total = $request->total;
        if($total == 1){
            $reporte = DB::select('SELECT COUNT(PK_PROYECTO)
                                          FROM CATR_PROYECTO
                                          JOIN CATR_DOCENTE ON CATR_PROYECTO.FK_DOCENTE = CATR_DOCENTE.ID_PADRE
                                          WHERE PERIODO = :periodo
                                          AND ID_AREA_ACADEMICA = :area',['periodo'=>$actual,'area'=>$area3]);
            $reporte1 = json_decode(json_encode($reporte),true);
            $reporte2 = array_pop($reporte1);
            $reporte3 = array_pop($reporte2);

            return $reporte3*3;
        }elseif($total == 2){
            $reporte = DB::select('SELECT COUNT(PK_PROYECTO)
                                          FROM CATR_PROYECTO
                                          JOIN CATR_DOCENTE ON CATR_PROYECTO.FK_DOCENTE = CATR_DOCENTE.ID_PADRE
                                          WHERE PERIODO = :periodo
                                          AND ID_AREA_ACADEMICA = :area',['periodo'=>$actual,'area'=>$area3]);
            $reporte1 = json_decode(json_encode($reporte),true);
            $reporte2 = array_pop($reporte1);
            $reporte3 = array_pop($reporte2);

            return $reporte3;
        }
        return response()->json('Error');
    }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }
}
