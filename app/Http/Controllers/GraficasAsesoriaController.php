<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
    
    public function materias()
    {
        $materias = DB::table('TR_ASESORIA_MOTIVO')
        ->select('MATERIA_APOYO1')
        ->distinct()
        ->get();
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }
    //modificar
    public function institucion()
    {
        $materias = DB::table('TR_ASESORIA_MOTIVO')
        ->select('p.PK_TECNOLOGICO','p.Nombre')
        ->join('users as a', 'a.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
        ->join('PAAE_TECNOLOGICO as p', 'p.PK_TECNOLOGICO', '=', 'a.FK_TECNOLOGICO')
        ->distinct()
        ->get();
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }
    //modificar
    public function carrera()
    {
        $materias = DB::table('TR_ASESORIA_MOTIVO')
        ->select('a.CLAVE_CARRERA')
        ->join('users as a', 'a.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
        ->distinct()
        ->get();
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }

    public function graficaMotivosInstitucion(Request $request)
    {
        $materias = DB::table('TR_ASESORIA_MOTIVO')
        ->select('a.NOMBRE as country',DB::raw('COUNT(a.NOMBRE)AS litres'))
        ->join('CAT_MOTIVO_ASESORIA_ACADEMICA as a', 'a.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
        ->join('users as s', 's.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
        ->where('s.FK_TECNOLOGICO',$request->tecnologico)
        ->groupBy('a.NOMBRE')
        ->get();
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }


    public function graficaMotivosMaterias(Request $request)
    {
        $materias = DB::table('TR_ASESORIA_MOTIVO')
        ->select('a.NOMBRE as country',DB::raw('COUNT(a.NOMBRE)AS litres'))
        ->join('CAT_MOTIVO_ASESORIA_ACADEMICA as a', 'a.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
        ->where('MATERIA_APOYO1',$request->materia)
        ->groupBy('a.NOMBRE')
        ->get();
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }
    
    public function graficaMotivosCarera(Request $request)
    {
        $materias = DB::table('TR_ASESORIA_MOTIVO')
        ->select('a.NOMBRE as country',DB::raw('COUNT(a.NOMBRE)AS litres'))
        ->join('CAT_MOTIVO_ASESORIA_ACADEMICA as a', 'a.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
        ->join('users as s', 's.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
        ->where('s.CLAVE_CARRERA',$request->carrera)
        ->groupBy('a.NOMBRE')
        ->get();
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }

    public function graficaGeneralEvalSemestre(Request $request)
    {
        //$materias = DB::table('TR_EVALUACION_SATISFACCION')
        $materias = DB::table('ITL_SICH.dbo.view_alumnos as db1')
        ->select('db1.Semestre as country',DB::raw('COUNT(db1.Semestre)AS litres'))
        ->join('SWIITL.dbo.users as db2', 'db1.NumeroControl', '=', 'db2.NUMERO_CONTROL')
        ->join('TR_EVALUACION_SATISFACCION as a', 'a.FK_USER', '=', 'db2.PK_USUARIO')
        //->where('db2.id', 5)
       ->groupBy('db1.Semestre')
        ->get();
        /* ->select('a.NOMBRE as country',DB::raw('COUNT(a.NOMBRE)AS litres'))
        ->join('CAT_MOTIVO_ASESORIA_ACADEMICA as a', 'a.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
        ->join('users as s', 's.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
        ->where('s.FK_TECNOLOGICO',$request->tecnologico)
        ->groupBy('a.NOMBRE')
        ->get(); */
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }

    public function graficaGeneralEvalCarrera(Request $request)
    {
        //$materias = DB::table('TR_EVALUACION_SATISFACCION')
        $materias = DB::table('ITL_SICH.dbo.view_alumnos as db1')
        ->select('db1.ClaveCarrera as country',DB::raw('COUNT(db1.ClaveCarrera)AS litres'))
        ->join('SWIITL.dbo.users as db2', 'db1.NumeroControl', '=', 'db2.NUMERO_CONTROL')
        ->join('TR_EVALUACION_SATISFACCION as a', 'a.FK_USER', '=', 'db2.PK_USUARIO')
        //->where('db2.id', 5)
       ->groupBy('db1.ClaveCarrera')
        ->get();
        /* ->select('a.NOMBRE as country',DB::raw('COUNT(a.NOMBRE)AS litres'))
        ->join('CAT_MOTIVO_ASESORIA_ACADEMICA as a', 'a.PK_MOTIVO_ASESORIA_ACADEMICA', '=', 'TR_ASESORIA_MOTIVO.FK_MOTIVO')
        ->join('users as s', 's.PK_USUARIO', '=', 'TR_ASESORIA_MOTIVO.FK_USER')
        ->where('s.FK_TECNOLOGICO',$request->tecnologico)
        ->groupBy('a.NOMBRE')
        ->get(); */
        //->leftJoin(DB::raw('(SELECT FK_ESTATUS, CANTIDAD = COUNT(* )  FROM CATR_ASPIRANTE WHERE FK_PERIODO=' . $PK_PERIODO . ' GROUP BY FK_ESTATUS) x'), 'x.FK_ESTATUS', '=', 'CAT_ESTATUS_ASPIRANTE.PK_ESTATUS_ASPIRANTE')
        

    return $materias;
    }

    public function graficaGeneralEvalMateria(Request $request)
    {
        $materias = DB::table('TR_EVALUACION_SATISFACCION')
        ->select('MATERIA as country',DB::raw('COUNT(MATERIA)AS litres'))
        ->groupBy('MATERIA')
        ->get();
    return $materias;
    }

    public function graficaIntegralEval(Request $request)
    {
        $pila = array();
        $pila2 = array();
        $nombres =  DB::table('CAT_AFIRMACIONES_EVALUACION')
        ->select('PK_AFIRMACIONES_EVALUACION', 'NOMBRE')
        ->distinct()
        ->get();
        foreach($nombres as $nombre){
        /*   $materias = DB::table('TR_EVALUACION_SATISFACCION as b')
        ->select('b.RESPUESTA as europe',DB::raw('COUNT(b.RESPUESTA)AS namerica'))
        ->where('b.FK_AFIRMACION',$nombre->FK_AFIRMACION)
        ->groupBy('b.RESPUESTA')
        ->get(); */

        /* 
                foreach ($contResult as $value) {
        $valuesAux = []
        $valuesAux['CategoryName'] = $value->CategoryName;
        $valuesAux['CategoryId'] = $value->CategoryId;
        $values[] = $valuesAux;
        }
        return json_encode($values); */

        //return $materias;
        /* $materias = DB::table('TR_EVALUACION_SATISFACCION as b')
        ->select('a.NOMBRE as year','b.RESPUESTA as europe',DB::raw('COUNT(b.RESPUESTA)AS namerica'))
        ->join('CAT_AFIRMACIONES_EVALUACION as a', 'a.PK_AFIRMACIONES_EVALUACION', '=', 'b.FK_AFIRMACION')
        ->where('b.FK_AFIRMACION',$nombre->FK_AFIRMACION)
        ->groupBy('a.NOMBRE')
        ->groupBy('b.RESPUESTA')
        ->groupBy('b.FK_AFIRMACION')
        ->orderBy('b.FK_AFIRMACION')        
        ->get(); */
        $respuestas_array = array();
        $respuestas = DB::select("SELECT 
                RESPUESTA,
                COUNT(RESPUESTA)  AS CANTIDAD
            FROM
                TR_EVALUACION_SATISFACCION
            WHERE 
                FK_AFIRMACION = ".$nombre->PK_AFIRMACIONES_EVALUACION."
            GROUP BY
                RESPUESTA
            ;");

        $respuestas_array = array_merge($respuestas_array, array('year'=>$nombre->PK_AFIRMACIONES_EVALUACION));
      
        foreach($respuestas as $respuesta){
            $respuestas_array = array_merge($respuestas_array, array($respuesta->RESPUESTA=>$respuesta->CANTIDAD));
            /* $respuestas_array[] = array(
                'respuesta' => $respuesta->RESPUESTA,
                'cantidad' => $respuesta->CANTIDAD
            );  */
        }
        //return $respuestas_array;
        //$pila = array_merge($pila, array('year' => $nombre->NOMBRE,$respuestas_array));
        // $pila = array_merge($pila, array($respuestas_array));
        //$pila = array_merge($pila, array('year' => $nombre->NOMBRE));
        //$pila = array_merge($pila, array($respuestas_array));
        //return $pila2;

        /*  $pila[] = array(
            'year' => $nombre->NOMBRE,
            
            //$respuestas[0]->RESPUESTA => $respuestas[0]->CANTIDAD,
            //'respuestas2' => $respuestas[0]->CANTIDAD
        ); */
        // $pila2 = array_merge($pila2, array('year' => $nombre->NOMBRE));

        $pila = array_merge($pila, array($respuestas_array));

        // $pila2= array_merge($pila,$respuestas_array);
       
        /* "asia": 2.1,
        "lamerica": 0.3,
        "meast": 0.2,
        "africa": 0.1 */
            }
        //return json_encode($materias);
                //return $respuestas_array;
    
        return $pila;
    }

    public function graficaIntegralMate(Request $request)
    {
        $pila = array();
        $pila2 = array();
        $nombres =  DB::table('TR_EVALUACION_SATISFACCION')
        ->select('MATERIA')
        ->distinct()
        ->get();
        foreach($nombres as $nombre){
        $respuestas_array = array();
        $respuestas = DB::table('TR_EVALUACION_SATISFACCION')
        ->select('RESPUESTA',DB::raw('COUNT(RESPUESTA)AS CANTIDAD'))
        ->where('MATERIA',$nombre->MATERIA)
        ->groupBy('RESPUESTA')
        ->get();

        $respuestas_array = array_merge($respuestas_array, array('year'=>$nombre->MATERIA));
      
        foreach($respuestas as $respuesta){
            $respuestas_array = array_merge($respuestas_array, array($respuesta->RESPUESTA=>$respuesta->CANTIDAD));
        }
        $pila = array_merge($pila, array($respuestas_array));
        }
        return $pila;

    }

    public function graficaIntegralCarre(Request $request)
    {
        $pila = array();
        $pila2 = array();
        $nombres =  DB::table('TR_EVALUACION_SATISFACCION as b')
        ->select('a.CLAVE_CARRERA','b.FK_USER')
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_USER')
        ->distinct()
        ->get();

        //return $nombres;
        foreach($nombres as $nombre){
        $respuestas_array = array();
        $respuestas = DB::table('TR_EVALUACION_SATISFACCION')
        ->select('RESPUESTA',DB::raw('COUNT(RESPUESTA)AS CANTIDAD'))
        ->where('FK_USER',$nombre->FK_USER)
        ->groupBy('RESPUESTA')
        ->get();
        //return $respuestas;

        $respuestas_array = array_merge($respuestas_array, array('year'=>$nombre->CLAVE_CARRERA));
      
        foreach($respuestas as $respuesta){
            $respuestas_array = array_merge($respuestas_array, array($respuesta->RESPUESTA=>$respuesta->CANTIDAD));
        }
        $pila = array_merge($pila, array($respuestas_array));
        }
        return $pila;

    }

    public function graficaGeneralSol(Request $request)
    {
        $resultado = array();
        $materias = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select(DB::raw("'SOLICITUD' as country"),DB::raw('COUNT(*)AS litres'))
        ->get();

        $materias1 = DB::table('CATR_ASESORIA_ACEPTADA')
        ->select(DB::raw("'ATENCION' as country"),DB::raw('COUNT(*)AS litres'))
        ->get();

        $resultado = array_merge($resultado, array($materias[0]));
        $resultado = array_merge($resultado, array($materias1[0]));
    return $resultado;
    }

    public function graficaGeneralSolMat(Request $request)
    {
        $resultado1 = array();        
        $solicitadas = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('MATERIA as NOMBRE',DB::raw('COUNT(MATERIA)AS CANTIDAD'))
        ->groupBy('MATERIA')
        ->get();
        $aceptadas = DB::table('CATR_USER_ASESORIA_HORARIO')
        ->select('CATR_USER_ASESORIA_HORARIO.MATERIA as NOMBRE', DB::raw('CANTIDAD = ISNULL(CANTIDAD,0)'))
        ->distinct()
        ->leftJoin(DB::raw('(SELECT MATERIA, CANTIDAD = COUNT(* )  FROM CATR_ASESORIA_ACEPTADA GROUP BY MATERIA) x'), 'x.MATERIA', '=', 'CATR_USER_ASESORIA_HORARIO.MATERIA')
        ->get();
        foreach($solicitadas as $index => $solicitada){
        $resultado = array();
        $resultado = array_merge($resultado, array('year' => $solicitada->NOMBRE));
        $resultado = array_merge($resultado, array('solicitudes' => $solicitada->CANTIDAD));
        $resultado = array_merge($resultado, array('aceptados' => $aceptadas[$index]->CANTIDAD));
        //$resultado = array_merge($solicitadas,$aceptadas); 
        $resultado1 = array_merge($resultado1, array($resultado));
        }
    
    return $resultado1;
    }

    public function graficaGeneralSolCar(Request $request)
    {
        $resultado1 = array();        
        $solicitadas = DB::table('CATR_USER_ASESORIA_HORARIO as b')
        ->select('CLAVE_CARRERA as NOMBRE',DB::raw('COUNT(CLAVE_CARRERA)AS CANTIDAD'))
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_USUARIO')
        ->groupBy('CLAVE_CARRERA')
        ->get();
        //return $solicitadas;
        /* $aceptadas = DB::table('CATR_USER_ASESORIA_HORARIO as b')
        ->select('b.MATERIA  as NOMBRE', DB::raw('CANTIDAD = ISNULL(CANTIDAD,0)'),'a.CLAVE_CARRERA as CARRERA')
        ->distinct()
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_USUARIO')
        ->leftJoin(DB::raw('(SELECT MATERIA, CANTIDAD = COUNT(* )  FROM CATR_ASESORIA_ACEPTADA GROUP BY MATERIA) x'), 'x.MATERIA', '=', 'b.MATERIA')
        ->get(); */
        $aceptadas = DB::table('CATR_ASESORIA_ACEPTADA as b')
        ->select('CLAVE_CARRERA as NOMBRE', DB::raw('COUNT(CLAVE_CARRERA)AS CANTIDAD'),'FK_ALUMNO')
        ->distinct()
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_ALUMNO')
        ->groupBy('CLAVE_CARRERA')
        ->groupBy('FK_ALUMNO')
        //->leftJoin(DB::raw('(SELECT MATERIA, CANTIDAD = COUNT(* )  FROM CATR_ASESORIA_ACEPTADA GROUP BY MATERIA) x'), 'x.MATERIA', '=', 'b.MATERIA')
        ->get();

        //return $aceptadas;
        foreach($solicitadas as $index => $solicitada){
        $resultado = array();
        $resultado = array_merge($resultado, array('year' => $solicitada->NOMBRE));
        $resultado = array_merge($resultado, array('solicitudes' => $solicitada->CANTIDAD));
        $resultado = array_merge($resultado, array('aceptados' => $aceptadas[$index]->CANTIDAD));
        //$resultado = array_merge($solicitadas,$aceptadas); 
        $resultado1 = array_merge($resultado1, array($resultado));
        }
    
    return $resultado1;
    }

    public function graficaGeneralSolCarMat(Request $request)
    {
        $resultado1 = array();        
        $solicitadas = DB::table('CATR_USER_ASESORIA_HORARIO as b')
        ->select('MATERIA as NOMBRE',DB::raw('COUNT(MATERIA)AS CANTIDAD'),'CLAVE_CARRERA as CARRERA')
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_USUARIO')
        ->groupBy('MATERIA')
        ->groupBy('CLAVE_CARRERA')
        ->get();
        //return $solicitadas;
        $aceptadas = DB::table('CATR_USER_ASESORIA_HORARIO as b')
        ->select('b.MATERIA as NOMBRE', DB::raw('CANTIDAD = ISNULL(CANTIDAD,0)'),'CLAVE_CARRERA AS CARRERA')
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_USUARIO')
        ->distinct()
        ->leftJoin(DB::raw('(SELECT MATERIA, CANTIDAD = COUNT(* )  FROM CATR_ASESORIA_ACEPTADA GROUP BY MATERIA) x'), 'x.MATERIA', '=', 'b.MATERIA')
        ->groupBy('a.CLAVE_CARRERA')
        ->groupBy('b.MATERIA')
        ->groupBy('CANTIDAD')
        ->get();
        /* $aceptadas = DB::table('CATR_ASESORIA_ACEPTADA as b')
        ->select('MATERIA as NOMBRE', DB::raw('COUNT(MATERIA)AS CANTIDAD'),'CLAVE_CARRERA as CARRERA')
        ->distinct()
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_ALUMNO')
        ->groupBy('CLAVE_CARRERA')
        ->groupBy('MATERIA')
        ->groupBy('FK_ALUMNO')
        //->leftJoin(DB::raw('(SELECT MATERIA, CANTIDAD = COUNT(* )  FROM CATR_ASESORIA_ACEPTADA GROUP BY MATERIA) x'), 'x.MATERIA', '=', 'b.MATERIA')
        ->get(); */
        //return $aceptadas;
        foreach($solicitadas as $index => $solicitada){
        $resultado = array();
        $resultado = array_merge($resultado, array('year' => $solicitada->CARRERA.$index));
        $resultado = array_merge($resultado, array('materia' => 'SOLICITADAS '.$solicitada->NOMBRE));
        $resultado = array_merge($resultado, array('materia1' => 'ACEPTADAS '.$solicitada->NOMBRE));
        $resultado = array_merge($resultado, array('SOLICITADAS '.$solicitada->NOMBRE => $solicitada->CANTIDAD));
        $resultado = array_merge($resultado, array('ACEPTADAS '.$solicitada->NOMBRE => $aceptadas[$index]->CANTIDAD));
        //$resultado = array_merge($solicitadas,$aceptadas); 
        $resultado1 = array_merge($resultado1, array($resultado));
        }
    
    return $resultado1;
    }

    public function graficaGeneralAproRep(Request $request)
    {
        $resultadoapro = array();    
        $resultadorepro = array();
        $final = array();
        $final1 = array();
        $solicitadas = DB::table('CATR_ASESORIA_ACEPTADA as b')
        ->select('NUMERO_CONTROL as CONTROL','MATERIA')
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_ALUMNO')
        ->groupBy('NUMERO_CONTROL')
        ->groupBy('MATERIA')
        ->get();
        //return $solicitadas;
        foreach($solicitadas as  $index => $solicitada){
        $resultado = array();
        //$materias = DB::table('ITL_SICH.dbo.view_seguimiento as db1')

        $materias = DB::table('ITL_SICH.dbo.view_seguimiento as db1')
        ->select('db1.Calificacion','db2.NOMBRE',DB::raw('COUNT(*)AS CANTIDAD'))
        ->join('ITL_SICH.dbo.view_reticula as db2', 'db1.ClaveMateria', '=', 'db2.ClaveMateria')
        ->where([['NumeroControl', $solicitada->CONTROL],
        ['db2.Nombre',trim($solicitada->MATERIA)]])
       ->groupBy('db1.Calificacion')
       ->groupBy('db2.NOMBRE')
        ->get();

        if($materias[0]->Calificacion >= 70){
            $resultado = array_merge($resultado, array('calificacion' => $materias[0]->Calificacion));
            $resultado = array_merge($resultado, array('nombre' => $materias[0]->NOMBRE));
            $resultado = array_merge($resultado, array('cantidad' => $materias[0]->CANTIDAD));
            $resultadoapro = array_merge($resultadoapro, array($resultado));
        }else{
            $resultado = array_merge($resultado, array('calificacion' => $materias[0]->Calificacion));
            $resultado = array_merge($resultado, array('nombre' => $materias[0]->NOMBRE));
            $resultado = array_merge($resultado, array('cantidad' => $materias[0]->CANTIDAD));
            $resultadorepro = array_merge($resultadorepro, array($resultado));

        }
        }
        $resultado = array_merge($resultado, array('calificacion' => $materias[0]->Calificacion));
        $resultadorepro = array_merge($resultadorepro, array($resultado));

        $final = array_merge($final, array('country' => 'aprobados'));
        $final = array_merge($final, array('litres' => count($resultadoapro)));
        $final1 = array_merge($final1, array($final));
        $final = array_merge($final, array('country' => 'reprobados'));
        $final = array_merge($final, array('litres' => count($resultadorepro)));
        $final1 = array_merge($final1, array($final));

        return $final1;
    }

    public function graficaGeneralAproRepMat(Request $request)
    {
        $resultadoapro = array();    
        $resultadorepro = array();
        $final = array();
        $final1 = array();
        $solicitadas = DB::table('CATR_ASESORIA_ACEPTADA as b')
        ->select('NUMERO_CONTROL as CONTROL','MATERIA')
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_ALUMNO')
        ->groupBy('NUMERO_CONTROL')
        ->groupBy('MATERIA')
        ->get();
        //return $solicitadas;
        foreach($solicitadas as  $index => $solicitada){
        $resultado = array();
        //$materias = DB::table('ITL_SICH.dbo.view_seguimiento as db1')

        $materias = DB::table('ITL_SICH.dbo.view_seguimiento as db1')
        ->select('db1.Calificacion','db2.NOMBRE',DB::raw('COUNT(*)AS CANTIDAD'))
        ->join('ITL_SICH.dbo.view_reticula as db2', 'db1.ClaveMateria', '=', 'db2.ClaveMateria')
        ->where([['NumeroControl', $solicitada->CONTROL],
        ['db2.Nombre',trim($solicitada->MATERIA)]])
       ->groupBy('db1.Calificacion')
       ->groupBy('db2.NOMBRE')
        ->get();

        if($materias[0]->Calificacion >= 70){
            //$resultado = array_merge($resultado, array('calificacion' => $materias[0]->Calificacion));
            $resultado = array_merge($resultado, array('year' => $materias[0]->NOMBRE));
            $resultado = array_merge($resultado, array('aprobados' => count($materias)));
            $resultado = array_merge($resultado, array('reprobadis' => 0));
            $final = array_merge($final, array($resultado));
        }else{
            $resultado = array_merge($resultado, array('year' => $materias[0]->NOMBRE));
            $resultado = array_merge($resultado, array('reprobados' => count($materias)));
            $final = array_merge($final, array($resultado));

        }
        if($index == 1){
            $resultado = array();
            $resultado = array_merge($resultado, array('year' => $materias[0]->NOMBRE));
            $resultado = array_merge($resultado, array('aprobados' => 0));
            $resultado = array_merge($resultado, array('reprobados' => count($materias)));
            $final = array_merge($final, array($resultado));

        }
        }
        return $final;
    }

    public function graficaGeneralAproRepCar(Request $request)
    {
        $resultadoapro = array();    
        $resultadorepro = array();
        $final = array();
        $final1 = array();
        $solicitadas = DB::table('CATR_ASESORIA_ACEPTADA as b')
        ->select('NUMERO_CONTROL as CONTROL','MATERIA','CLAVE_CARRERA as CARRERA')
        ->join('users as a', 'a.PK_USUARIO', '=', 'b.FK_ALUMNO')
        ->groupBy('NUMERO_CONTROL')
        ->groupBy('CLAVE_CARRERA')
        ->groupBy('MATERIA')
        ->get();
        //return $solicitadas;
        foreach($solicitadas as  $index => $solicitada){
        $resultado = array();
        //$materias = DB::table('ITL_SICH.dbo.view_seguimiento as db1')

        $materias = DB::table('ITL_SICH.dbo.view_seguimiento as db1')
        ->select('db1.Calificacion','db2.NOMBRE',DB::raw('COUNT(*)AS CANTIDAD'))
        ->join('ITL_SICH.dbo.view_reticula as db2', 'db1.ClaveMateria', '=', 'db2.ClaveMateria')
        ->where([['NumeroControl', $solicitada->CONTROL],
        ['db2.Nombre',trim($solicitada->MATERIA)]])
       ->groupBy('db1.Calificacion')
       ->groupBy('db2.NOMBRE')
        ->get();

        if($materias[0]->Calificacion >= 70){
            //$resultado = array_merge($resultado, array('calificacion' => $materias[0]->Calificacion));
            $resultado = array_merge($resultado, array('year' => $solicitada->CARRERA));
            $resultado = array_merge($resultado, array('aprobados' => count($materias)));
            $resultado = array_merge($resultado, array('reprobadis' => 0));
            $resultadoapro = array_merge($resultadoapro, array($resultado));
        }else{
            $resultado = array_merge($resultado, array('year' => $solicitada->CARRERA));
            $resultado = array_merge($resultado, array('reprobados' => count($materias)));
            $resultadorepro = array_merge($resultadorepro, array($resultado));

        }
        if($index == 1){
            $resultado = array();
            $resultado = array_merge($resultado, array('year' => $solicitada->CARRERA));
            $resultado = array_merge($resultado, array('aprobados' => 0));
            $resultado = array_merge($resultado, array('reprobados' => count($materias)));
            $resultadorepro = array_merge($resultadorepro, array($resultado));

        }
        }
        $final = array_merge($final, array('year' => 'ISC'));
        $final = array_merge($final, array('aprobados' => 5));       
        $final = array_merge($final, array('reprobados' => 1));
        $final1 = array_merge($final1, array($final));
        $final = array_merge($final, array('year' => 'LOX'));
        $final = array_merge($final, array('aprobados' => 5));       
        $final = array_merge($final, array('reprobados' => 1));
        $final1 = array_merge($final1, array($final));
        return $final1;
    }


    public function graficaGeneralAproRepCarMat(Request $request)
    {
        $final = array();
        $final1 = array();
        
        $final = array_merge($final, array('year' => 'ISC'));
        $final = array_merge($final, array('materia' => 'APROBADOS CALCULO DIFERENCIAL'));       
        $final = array_merge($final, array('materia1' => 'REPROBADOS CALCULO DIFERENCIAL'));
        $final = array_merge($final, array('APROBADOS CALCULO DIFERENCIAL' => 1));
        $final = array_merge($final, array('REPROBADOS CALCULO DIFERENCIAL' => 1));
        $final1 = array_merge($final1, array($final));
        $final = array();

        $final = array_merge($final, array('year' => 'ISC'));
        $final = array_merge($final, array('materia' => 'APROBADOS REDES DE COMPUTADORA'));       
        $final = array_merge($final, array('materia1' => 'REPROBADOS REDES DE COMPUTADORA'));
        $final = array_merge($final, array('APROBADOS REDES DE COMPUTADORA' => 1));
        $final = array_merge($final, array('REPROBADOS REDES DE COMPUTADORA' => 1));
        $final1 = array_merge($final1, array($final));
        $final = array();

        $final = array_merge($final, array('year' => 'LOX'));
        $final = array_merge($final, array('materia' => 'APROBADOS ECONOMIA'));       
        $final = array_merge($final, array('materia1' => 'REPROBADOS ECONOMIA'));
        $final = array_merge($final, array('APROBADOS ECONOMIA' => 1));
        $final = array_merge($final, array('REPROBADOS ECONOMIA' => 1));
        $final1 = array_merge($final1, array($final));
        return $final1;
        /* {
        "year": "ISC0",
        "materia": "SOLICITADAS FISICA",
        "materia1": "ACEPTADAS FISICA",
        "SOLICITADAS FISICA": "3",
        "ACEPTADAS FISICA": "0"
    }, */
    }
}
