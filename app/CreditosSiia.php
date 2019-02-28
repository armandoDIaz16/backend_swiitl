<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreditosSiia extends Model
{
    protected $connection = 'sqlsrv2';

    public function get_creditos_aprobados($numero_control){
        /*Consulta y suma los creditos de las materias aprobadas*/
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
        /*Consulta y suma los creditos del horario actual*/
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
        /*Consulta carrera alumno*/
        $carrera = DB::connection('sqlsrv2')->table('view_alumnos')
            ->whereRaw('view_alumnos.NumeroControl= :NumeroControl',['NumeroControl'=>$numero_control])
            ->select('ClaveCarrera')->get()->first();
        $return = $carrera ->ClaveCarrera;
        return $return;

    }

    public function periodo(){
        /*$periodo toma el valor del año en 4 digitos. Ejemplo: 2019*/
        $periodo = Date('Y');
        /*Se toma el mes actual en 2 digitos. Ejemplo Enero = 01*/
        /*Si es menor o igual a 6 el periodo es 1, si no es 2*/
        if(Date('m')<=6):
            $periodo = $periodo . "1";
        else:
            $periodo = $periodo . "2";
        endif;
        /*Regresa periodo. Ejemplo: 20191*/
        return $periodo;
    }

    public function alumnos(){
        /*Busca a todos los alumnos de 7 a 11*/
        $alumnos = DB::connection('sqlsrv2')->select('Select 
                NumeroControl 
        from 
            view_alumnos 
        where 
            (semestre>=7 AND semestre<12) 
            AND estado = :estado 
            AND (clavecarrera != :clave AND clavecarrera != :clave2 ) 
        ORDER BY 
            NumeroControl',['estado'=>'AR','clave'=>'DC1', 'clave2'=>'MC4']);
        $validos = array();
        $prueba = json_decode(json_encode($alumnos), true);
        /*Prueba alumnos 1 por 1 si son viables para residencias*/
        for($i=0; $i<count($alumnos); $i++) {
            /*Saca alumnos de los arreglos*/
            $pruebaa = array_pop($prueba);
            $H = array_pop($pruebaa);
            $I = $this->viable($H);
            if($I != null){
                array_push($validos, $I);
            }


        }
        /* regresa a los alumnos que pueden llevar residencias el proximo semestre*/
        return $validos;
    }

    public function correo(){
        /*regresa correos de alumnos viables a residencias*/
        $ncontrol = $this->alumnos();
        $tcorreo2 = array();
        /*Busca en la base de datos alumno por alumno y regresa el correo*/
        for($i=0;$i<count($ncontrol);$i++) {
            $nprimero = array_pop($ncontrol);
            $tcorreo = DB::connection('sqlsrv')->select('SELECT 
                Correo1 
            FROM 
                table_usuario 
                JOIN table_alumno ON table_usuario.id = table_alumno.Id_Padre 
            WHERE Numero_Control = :numerocontrol', ['numerocontrol' => $nprimero]);
            if($tcorreo != null){
                array_push($tcorreo2,$tcorreo);
            }
        }

        return $tcorreo2;
    }

    public function viable($numero_control){
        /*Busca todos los creditos aprobados*/
        $cursados = $this->get_creditos_aprobados($numero_control);
        $cursadosa = json_decode(json_encode($cursados),true);
        $cursadosb = array_pop($cursadosa);
        $cursadosc = array_pop($cursadosb);
        /*Suma todos los creditos del horario actual de los alumnos*/
        $actuales = $this->get_creditos_horario($numero_control);
        $actualesa = json_decode(json_encode($actuales),true);
        $actualesb = array_pop($actualesa);
        $actualesc = array_pop($actualesb);
        /*Comprueba que se tengan las actividades complementarias*/
        $accomp = $this->creditos($numero_control);
        /*Se suman todos los creditos del alumno*/
        $total = $cursadosc + $actualesc +$accomp;
        /* *** 208 es 80% del total de creditos de todas las carreas *** */
        if($total>=208 && $total<=250):
            return $numero_control;
        else:
            return null;
        endif;
    }

    public function creditos($numero_control){
        /*Valida si se tienen las actividades complementarias y regresa 5 creditos si estan cumplidas*/
        $var = DB::connection('sqlsrv2')->select('SELECT Calificacion FROM view_seguimiento WHERE ClaveMateria = :clave AND NumeroControl = :numero',['clave'=>'ACA','numero'=>$numero_control]);
        $var2 = array_pop($var);
        if($var2 = -2):
            $var3 = 5;
        else:
            $var3 = 0;
        endif;

        return $var3;
    }
}
