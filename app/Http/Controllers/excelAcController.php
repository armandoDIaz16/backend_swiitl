<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;


use DB;


class excelAcController extends Controller
{

    public function importarCreditos(Request $req){
        $path = $req->file->getRealPath();
        $data = Excel::load($path)->get();

         foreach($data as $d){
            $pk_usuario = DB::table('users')
                ->select('PK_USUARIO')
                ->where('NUMERO_CONTROL',$d->num_control)
                ->get()->first();
           
             $pk_lineamiento = DB::table('LINEAMIENTOS')    
                ->select('PK_LINEAMIENTO')
                ->where('NOMBRE',$d->lineamiento)
                ->get()->first();

          switch($d->calificacion){
              case "0":
                $cali = "INSUFICIENTE";
                break;
              case "1":
                $cali = "SUFICIENTE";
                break;
              case "2":
                $cali = "BUENO";
                break;
              case "3":
                $cali = "NOTABLE";
                break;
              case "4";
                $cali = "SOBRESALIENTE";
                break;
          }
          if($d->calificacion != '0'){
            $arr[] = [
                'FK_ALUMNO' => $pk_usuario->PK_USUARIO,
                'FK_LINEAMIENTO' => $pk_lineamiento->PK_LINEAMIENTO,
                'CALIFICACION' => $cali,
                'PERIODO' => $d->periodo
            ]; 
          }
       }

         if(!empty($arr)){
            DB::table('ALUMNO_CREDITO')->insert($arr);
            return "correcto";
        }  



    } 

    public function generarExcel(){//traer una lista con el id de los alumnos y su cantidad de creditos registrados
        $sumacali = 0;
        $total = 0;
        $creditosCount = DB::table('ALUMNO_CREDITO')
            ->selectRaw('FK_ALUMNO, COUNT(FK_LINEAMIENTO) as creditos')
            ->where('VALIDADO',1)
            ->where('VALIDACION_2',0)
            ->groupBy('FK_ALUMNO')
            ->get();

       // $fechaEvaluacion = DB::table('CAT_CONFIGURACION_ESCOLARES')//obtener la fecha de evaluacion
           // ->select('FECHA')->get()->first();
        
            $año_actual = Carbon::today()->format('Y');//obtener el periodo en el formato pedido en el excel
            $fecha_actual = Carbon::today()->format('m-d');
            $inicio_año = Carbon::parse('01/01')->format('m-d');
            $medio_año = Carbon::parse("08/01")->format('m-d');
            
            if($fecha_actual > $inicio_año && $fecha_actual < $medio_año){
             $periodo = $año_actual."1";
              }else{
             $periodo = $año_actual."2";
              }
        
        foreach($creditosCount as $count){
            if($count->creditos >= 5){//si el alunno cunple con sus 5 creditos entonces..
                $infoAlumno = DB::table('users')//guardar la info de los alumnos en un arreglo
                    ->select('NUMERO_CONTROL', 'SEMESTRE')
                    ->where('PK_USUARIO',$count->FK_ALUMNO)
                    ->get()->first();

                //-------------obtener le promedio final de los créditos con base en la calificación 
                $calificaciones = DB::table('ALUMNO_CREDITO')//obtener todas las calificaiones
                    ->select('CALIFICACION')
                    ->where('FK_ALUMNO',$count->FK_ALUMNO)
                    ->get();
                
                    foreach($calificaciones as $cal){//convertir las calificaciones en strings a numéricas 
                        switch($cal->CALIFICACION){
                            case "INSUFICIENTE":
                                $calnumero = 0;
                                break;
                            case "SUFICIENTE":
                                $calnumero = 1;
                                break;
                            case "BUENO":
                                $calnumero = 2;
                                break;
                            case "NOTABLE":
                                $calnumero = 3;
                                break;
                            case "SOBRESALIENTE":
                                $calnumero = 4;
                                break;
                        }
                        $sumacali = $sumacali + $calnumero; //realizar sumatoria de las calificaciones 
                        $total = $total + 1; //sumar el numero de vueltas que da el ciclo para saber el número entre el que hay que dividir la sumatoria de calificaciones para obtener el promedio final (en teoría este número siempre debe ser 5, pero aquí se está estableciendo de manera dinámica)
                    }

                    $promedio = $sumacali / $total;

                $data[] = [ //arreglo con la info del excel
                    'Numero_Control' => $infoAlumno->NUMERO_CONTROL,
                    'Clave_de_Materia' => 'ACA',
                    'Clave_Periodo_Escolar' => $periodo,
                    'Semestre' => $infoAlumno->SEMESTRE,
                    'Fecha_Evaluacion' => '$fechaEvaluacion->FECHA',
                    'Calificacoin' => '-2',
                    'Nivel_de_Curso' => 'CO',
                    'Tipo_Aprobacion' => 'COPO',
                    'Folio' => 'AC',
                    'Promedio' => $promedio
                ];

                  DB::table('ALUMNO_CREDITO')->where('FK_ALUMNO',$count->FK_ALUMNO)
                ->update(array(
                    'VALIDACION_2'=>1));  
                
            }
        }

            //$response = Response::json($data);
            //return $response;
        try{
            return Excel::create("act_compl", function($excel) use ($data){
                $excel->sheet('sheet name', function($sheet) use ($data){
                    $sheet->fromArray($data);
                });
            })->download('xlsx');
        }catch(\Exception $e){
            return "No hay datos para exportar";
        };
            
        
    }
}
