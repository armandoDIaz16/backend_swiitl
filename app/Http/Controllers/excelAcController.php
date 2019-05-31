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

          if($d->aprobado == '1'){
            $arr[] = [
                'FK_ALUMNO' => $pk_usuario->PK_USUARIO,
                'FK_LINEAMIENTO' => $pk_lineamiento->PK_LINEAMIENTO,
                'CALIFICACION' => $d->calificacion,
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

                $data[] = [ //arreglo con la info del excel
                    'Numero_Control' => $infoAlumno->NUMERO_CONTROL,
                    'Clave_de_Materia' => 'ACA',
                    'Clave_Periodo_Escolar' => $periodo,
                    'Semestre' => $infoAlumno->SEMESTRE,
                    'Fecha_Evaluacion' => '$fechaEvaluacion->FECHA',
                    'Calificacoin' => '-2',
                    'Nivel_de_Curso' => 'CO',
                    'Tipo_Aprobacion' => 'COPO',
                    'Folio' => 'AC'
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
