<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GraficasAsesoriaController extends Controller
{

    public function graficaNoAsesorados()
    {       
    $solicitadas = DB::table('CATR_USER_ASESORIA_HORARIO')
    ->select('MATERIA as NOMBRE',DB::raw('COUNT(MATERIA)AS CANTIDAD'))
    ->groupBy('MATERIA')
    ->get();

    return $solicitadas;
    }
    public function graficaAsesorados()
    {         
         $aceptadas = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('CATR_USER_ASESORIA_HORARIO.MATERIA as NOMBRE', DB::raw('CANTIDAD = ISNULL(CANTIDAD,0)'))
        ->distinct()
        ->leftJoin(DB::raw('(SELECT MATERIA, CANTIDAD = COUNT(* )  FROM CATR_ASESORIA_ACEPTADA GROUP BY MATERIA) x'), 'x.MATERIA', '=', 'CATR_USER_ASESORIA_HORARIO.MATERIA')
        ->get();

    return $aceptadas;
    }
 

    public function graficaMaterias()
    {
        $materias = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('MATERIA as NOMBRE',DB::raw('COUNT(MATERIA)AS CANTIDAD'))
        ->groupBy('MATERIA')
        ->get();
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }
    
}
