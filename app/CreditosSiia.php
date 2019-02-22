<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreditosSiia extends Model
{
    protected $connection = 'sqlsrv2';

    public function get_creditos_aprobados($numero_control){
        $pdo = DB::connection('sqlsrv2')->select('SELECT 
            view_alumnos.NumeroControl,
            SUM(view_reticula.Creditos) AS creditos_cursados
            /*(
            BUSCAR TOTAL DE CREDITOS POR CARRERA 
            )*/
        FROM 
            view_seguimiento 
            LEFT JOIN view_reticula on view_seguimiento.ClaveMateria  = view_reticula.ClaveMateria 
            LEFT JOIN view_alumnos  on view_seguimiento.NumeroControl = view_alumnos.NumeroControl 
        WHERE 
            Calificacion >= 70  
            AND view_reticula.ClaveCarrera = :carrera
            AND view_alumnos.NumeroControl = :numero_control
        GROUP BY
            view_alumnos.NumeroControl',['carrera'=>$this->carrera($numero_control),'numero_control'=>$numero_control]);
        return $pdo;

    }


    public  function get_creditos_horario($numero_control){
        $pdo = DB::connection('sqlsrv2')->select('SELECT distinct 
    view_horarioalumno.NumeroControl, 
    SUM(view_reticula.Creditos) as creditos_actuales
     
FROM 
    view_horarioalumno
    join view_reticula on view_horarioalumno.clavemateria = view_reticula.ClaveMateria 
    JOIN view_alumnos  on view_horarioalumno.NumeroControl = view_alumnos.NumeroControl 
WHERE 
    view_horarioalumno.NumeroControl = :numero_control
    AND view_reticula.ClaveCarrera = :carrera 
    and view_horarioalumno.IdPeriodoEscolar = :periodo       
    AND (view_horarioalumno.Dia=1 or view_horarioalumno.Dia = 2)
GROUP BY
    view_horarioalumno.NumeroControl',['carrera'=>$this->carrera($numero_control),'numero_control'=>$numero_control, 'periodo'=>$this->periodo()]);
        return $pdo;
    }

    public function carrera($numero_control){
        $carrera = DB::connection('sqlsrv2')->table('view_alumnos')
            ->whereRaw('view_alumnos.NumeroControl= :NumeroControl',['NumeroControl'=>$numero_control])
            ->select('ClaveCarrera')->get()->first();
        $return = $carrera ->ClaveCarrera;
        return $return;

    }

    public function periodo(){
        $periodo = Date('Y');
        if(Date('m')<=6):
            $periodo = $periodo . "1";
        else:
            $periodo = $periodo . "2";
        endif;
        return $periodo;
    }
}
