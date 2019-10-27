<?php

namespace App\Http\Controllers;

use App\asistenciaAlumnoActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use DB;


class AsistenciaAlumnoActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asistencia_alumno_actividad =  asistenciaAlumnoActividad::all();
        $response = Response::json($asistencia_alumno_actividad);
        return $response;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asistencia_alumno_actividad = new asistenciaAlumnoActividad();
        $asistencia_alumno_actividad->FK_ALUMNO_ACTIVIDAD = $request->FK_ALUMNO_ACTIVIDAD;
        $asistencia_alumno_actividad->ENTRADA = $request->ENTRADA;
        $asistencia_alumno_actividad->SALIDA = $request->SALIDA;
        $asistencia_alumno_actividad->save();

        echo json_encode($asistencia_alumno_actividad);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\asistenciaAlumnoActividad  $asistenciaAlumnoActividad
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
          
    }

    public function actividadesList($FK_LINEAMIENTO, $FK_ALUMNO){
        //obtener las actividades a las que ha asistido el alumno, clasificadas por lineamiento
        $actividades = asistenciaAlumnoActividad::join('ALUMNO_ACTIVIDAD','FK_ALUMNO_ACTIVIDAD','=','PK_ALUMNO_ACTIVIDAD')
        ->join('ACTIVIDADES','ALUMNO_ACTIVIDAD.FK_ACTIVIDAD','=','ACTIVIDADES.PK_ACTIVIDAD')
        ->join('actividades_v','ALUMNO_ACTIVIDAD.FK_ACTIVIDAD','=','actividades_v.PK_ACTIVIDAD')
        ->selectRAW("ACTIVIDADES.PK_ACTIVIDAD, ACTIVIDADES.NOMBRE, replace(convert(NVARCHAR, ACTIVIDADES.FECHA, 106), ' ', '/') as FECHA, actividades_v.FK_TIPO, ENTRADA, SALIDA")
        ->Where('ACTIVIDADES.FK_LINEAMIENTO','=',$FK_LINEAMIENTO)
        ->Where('ALUMNO_ACTIVIDAD.FK_ALUMNO','=',$FK_ALUMNO)
        ->get(); 

  $response = Response::json($actividades);
  return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\asistenciaAlumnoActividad  $asistenciaAlumnoActividad
     * @return \Illuminate\Http\Response
     */
    public function edit(asistenciaAlumnoActividad $asistenciaAlumnoActividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\asistenciaAlumnoActividad  $asistenciaAlumnoActividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pk)
    {
    
    }

    public function regSalida($fk_alumno_actividad){
        
        $aaa = asistenciaAlumnoActividad::select('PK_ASISTENCIA_ALUMNO_ACTIVIDAD as pk','SALIDA')
                ->where('FK_ALUMNO_ACTIVIDAD','=', $fk_alumno_actividad)
                ->get()->first();
 
        
        if($aaa->SALIDA == 0){//verificar si es la primera vez que se registra la salida (no se puede registrar la salida múltiples veces)

        //$asistencia_alumno_actividad = asistenciaAlumnoActividad::find($pk);
        //$aaa->SALIDA = 1;
        //$aaa->save();

        asistenciaALumnoActividad::where('PK_ASISTENCIA_ALUMNO_ACTIVIDAD','=',$aaa->pk)
            ->update(array('SALIDA' => 1)); // registrar la salida
    

        $alumno = DB::select('exec dbo.get_usuariolineamiento ?', array($aaa->pk)); //obtener el usuario del que se esta tomando asistencia y el lineamiento al que pertenece la actividad
        $sumatoria = DB::select('exec dbo.get_sumatorialineamiento ?,?', array($alumno[0]->alumno, $alumno[0]->lineamiento));//obtener sumatoria del valor de las actividades correspondientes al lineamiento obtenido

        if ($sumatoria[0]->total == 100 or $sumatoria[0]->total == 200){ //si la sumatoria vale 100 o 200 significa que hay que registrar un credito
            
            $lineamiento = DB::table('LINEAMIENTOS')->select('*')//obtener los datos completos del lineamiento obtenido
                        ->where('PK_LINEAMIENTO','=',$sumatoria[0]->pk_lineamiento)->get()->first();
                        
            $num_registros = DB::select('exec dbo.num_creditosbylineamiento ?,?', array($alumno[0]->lineamiento, $alumno[0]->alumno)); //obtener la cantidad de creditos que ya tiene registrados el alumno correspondientes al lineamiento obtenido

            if($num_registros){ //si ya hay créditos de este mismo lineamiento registrados entonces...                
                
                if($num_registros[0]->registros < $lineamiento->LIMITE){//si la cantidad de creditos registrado para este lineamiento es menor al limite de registros permitidos entonces..
                    
                    return $this->analizarCredito($alumno[0]->alumno, $alumno[0]->lineamiento, $lineamiento);//registrar nuevo crédito

                }else{//sino significa que ya se rebaso el limite
                    echo("No se pueden registrar mas creditos de este tipo. Superaste el limite de creditos permitidos para este lineamiento");
                }           
            }else{//si la variable $num_registros no contiene nada significa que no hay ningun registro de algun credito para este lineamiento, entonces...
                    return $this->analizarCredito($alumno[0]->alumno, $alumno[0]->lineamiento, $lineamiento);//registrar nuevo crédito          
              }
          }
     }else{
         echo "La asistencia ya estaba registrada anteriormente";
     }
    }

    public function analizarCredito($alalumno, $allineamiento, $lineamiento){
        $calificacion = "";
        if($lineamiento->NOMBRE == 'Eventos académicos relacionados con la carrera' || //si el lineamiento es un lineamiento opcional hay que validar que no se registren mas del limite establecido, para no generar registros de mas de los 5 creditos que requieren los alumnos
           $lineamiento->NOMBRE == 'Programas de apoyo a la formación profesional' ||
           $lineamiento->NOMBRE == 'Tutoria 2'){
            $programas_apoyo = DB::table('ALUMNO_CREDITO')//determinar la cantidad de creditos que se tienen de programas de apoyo a la formacion
                        ->join('LINEAMIENTOS', 'ALUMNO_CREDITO.FK_LINEAMIENTO','=','LINEAMIENTOS.PK_LINEAMIENTO')
                        ->selectRaw("COUNT(LINEAMIENTOS.NOMBRE) as total")
                        ->where('ALUMNO_CREDITO.FK_ALUMNO',$alalumno)
                        ->where('LINEAMIENTOS.NOMBRE','Programas de apoyo a la formación profesional')
                        ->get()->first();
            $sum_lin_opcionales = DB::select('exec sumatoriaLineamientosOpcionales ?', array($alalumno));
            if($programas_apoyo->total < 1){// si no hay ningun credito de programas de apoyo, establecer el limite en 2, ya que 1 de los 2 creditos permitidos mediante programas de apoyo es obligatorio, evitando que se registren creditos opcionales en lugar del credito obligatorio
                if($sum_lin_opcionales[0]->TOTAL < 2){
                    return $this->registrarCredito($lineamiento, $alalumno, $allineamiento);
                }else{
                    return "Ya no se pueden registrar mas lineamientos de este tipo";
                }
            }else{
                if($sum_lin_opcionales[0]->TOTAL < 3){// si ya hay creditos de programas de apoyo, establecer el limite en 3, ya que 1 de los 2 creditos permitidos mediante programas de apoyo es obligatorio y el segundo es opcional
                    return $this->registrarCredito($lineamiento, $alalumno, $allineamiento);
                }else{
                    return "Ya no se pueden registrar mas lineamientos de este tipo";
                }
            }
        }else{// si no se trata de ningun credito opcional entonces es uno obigatorio y hay que registrarlo, a este else nunca se va a llegar por ahora ya que los creidot obligatorios expecto programas de apoyo tienen limite de 1 credito pero igual se pone por precaucion o futuras modiicaciones
            return $this->registrarCredito($lineamiento, $alalumno, $allineamiento);
        }
    }

    public function registrarCredito($lineamiento, $alalumno, $allineamiento){
        if($lineamiento->NOMBRE == 'Eventos académicos relacionados con la carrera' ||//saber si hay que insertar la calificacion de NOTABLE
        $lineamiento->NOMBRE == 'Programas de apoyo a la formación profesional'){
        $calificacion = 'NOTABLE';
     }
    //ahora determinar el periodo
    $año_actual = Carbon::today()->format('Y');
    $fecha_actual = Carbon::today()->format('m-d');
    $inicio_año = Carbon::parse('01/01')->format('m-d');
    $medio_año = Carbon::parse("08/01")->format('m-d');
    
    if($fecha_actual > $inicio_año && $fecha_actual < $medio_año){
     $periodo = "Enero - Junio ".$año_actual;
      }else{
     $periodo = "Agosto - Diciembre".$año_actual;
      }
                 
     DB::table('ALUMNO_CREDITO')->insert(//insertar el credito cumplido
         array('FK_ALUMNO' => $alalumno, 'FK_LINEAMIENTO' => $allineamiento,
         'CALIFICACION' => $calificacion, 'PERIODO' => $periodo));
         /**---------------------------- */
  $registrar = true;
  $lista_act = DB::table('ACTIVIDADES')//obtener una lista de las actividades en base al lineamiento y al usuario
         ->join('LINEAMIENTOS','ACTIVIDADES.FK_LINEAMIENTO','=','LINEAMIENTOS.PK_LINEAMIENTO')
         ->join('ALUMNO_ACTIVIDAD','ACTIVIDADES.PK_ACTIVIDAD','=','ALUMNO_ACTIVIDAD.FK_ACTIVIDAD')
         ->join('ASISTENCIA_ALUMNO_ACTIVIDAD','ALUMNO_ACTIVIDAD.PK_ALUMNO_ACTIVIDAD','=','ASISTENCIA_ALUMNO_ACTIVIDAD.FK_ALUMNO_ACTIVIDAD')
         ->join('CAT_USUARIO','ALUMNO_ACTIVIDAD.FK_ALUMNO','=','CAT_USUARIO.PK_USUARIO')
         ->selectRAW("ACTIVIDADES.PK_ACTIVIDAD, ACTIVIDADES.NOMBRE, replace(convert(NVARCHAR, ACTIVIDADES.FECHA, 106), ' ', '/') as FECHA")
         ->where('CAT_USUARIO.PK_USUARIO','=', $alalumno)
         ->where('LINEAMIENTOS.PK_LINEAMIENTO','=',$allineamiento)
         ->where('ASISTENCIA_ALUMNO_ACTIVIDAD.SALIDA','=',1)
         ->get();
     
     $act_registradas = DB::table('CREDITO_ACTIVIDAD')//obtener una lista de las actividades ya registradas en la tabla credito_alumno . Esta tabla relacionar los creditos con las actividades mediante las cuales fueron cumplidos
         ->join('ALUMNO_CREDITO','FK_ALUMNO_CREDITO','=','PK_ALUMNO_CREDITO')
         ->join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
         ->select('FK_ACTIVIDAD')
         ->where('FK_ALUMNO','=',$alalumno)
         ->where('FK_LINEAMIENTO','=',$allineamiento)
         ->get();

         foreach ($lista_act as $l) { //comparar ambas listas para saber si se debe regisrar o no la actividad para evitar duplicados y garantizar el orden   
             foreach($act_registradas as $ar){
                 if($ar->FK_ACTIVIDAD == $l->PK_ACTIVIDAD){
                     $registrar = false;
                     break;
                 }
             }
             if($registrar){ // si la actividad no se encuentra registrada en la tabla de CREDITO_ACTIVIDAD entonces..
                 $alumno_credito = DB::table('ALUMNO_CREDITO')//obtener el último id insertado en esta tabla correspondiente al usuario, para posteriomente insertarlo en la tabla credito_actividad
                 ->select('PK_ALUMNO_CREDITO')
                 ->where('FK_ALUMNO','=',$alalumno)
                 ->get()->last();

                 DB::table('CREDITO_ACTIVIDAD')->insert(//insertar la actividad correspondiente al credito cumplido
                     array('FK_ALUMNO_CREDITO' => $alumno_credito->PK_ALUMNO_CREDITO, 'FK_ACTIVIDAD' => $l->PK_ACTIVIDAD));

             }
         $registrar = TRUE;
         }
     echo("nuevo credito registrado");
    }

    public function pruebaActByLineamiento($asistencia_alumno_actividad){
       /*  $registrar = true;
        $lista_act = DB::table('ACTIVIDADES')
                ->join('LINEAMIENTOS','ACTIVIDADES.FK_LINEAMIENTO','=','LINEAMIENTOS.PK_LINEAMIENTO')
                ->join('ALUMNO_ACTIVIDAD','ACTIVIDADES.PK_ACTIVIDAD','=','ALUMNO_ACTIVIDAD.FK_ACTIVIDAD')
                ->join('ASISTENCIA_ALUMNO_ACTIVIDAD','ALUMNO_ACTIVIDAD.PK_ALUMNO_ACTIVIDAD','=','ASISTENCIA_ALUMNO_ACTIVIDAD.FK_ALUMNO_ACTIVIDAD')
                ->join('users','ALUMNO_ACTIVIDAD.FK_ALUMNO','=','users.PK_USUARIO')
                ->selectRAW("ACTIVIDADES.PK_ACTIVIDAD, ACTIVIDADES.NOMBRE, replace(convert(NVARCHAR, ACTIVIDADES.FECHA, 106), ' ', '/') as FECHA")
                ->where('users.PK_USUARIO','=', $pk_usuario)
                ->where('LINEAMIENTOS.PK_LINEAMIENTO','=',$pk_lineamiento)
                ->where('ASISTENCIA_ALUMNO_ACTIVIDAD.SALIDA','=',1)
                ->get();
        
         $act_registradas = DB::table('CREDITO_ACTIVIDAD')
                ->join('ALUMNO_CREDITO','FK_ALUMNO_CREDITO','=','PK_ALUMNO_CREDITO')
                ->select('FK_ACTIVIDAD')
                ->where('FK_ALUMNO','=',$pk_usuario)
                ->get();
             /*    $response = Response::json($lista_act);
                return $response;   */              
        /* foreach ($lista_act as $l) {    
                foreach($act_registradas as $ar){
                    if($ar->FK_ACTIVIDAD == $l->PK_ACTIVIDAD){
                        $registrar = false;
                    }
                }
                if($registrar){
                   // echo "hay que registrarlo";
                }else{
                    //echo "no se debe registrar";
                }
            $registrar = TRUE;
            }
        $alumno_credito = DB::table('ALUMNO_CREDITO')
                ->select('PK_ALUMNO_CREDITO')
                ->where('FK_ALUMNO','=',$pk_usuario)
                ->get()->last();
                $response = Response::json($alumno_credito);
                return $response; */
               /*  $act_registradas = DB::table('CREDITO_ACTIVIDAD')//obtener una lista de las actividades ya registradas en la tabla credito_alumno . Esta tabla relacionar los creditos con las actividades mediante las cuales fueron cumplidos
                ->join('ALUMNO_CREDITO','FK_ALUMNO_CREDITO','=','PK_ALUMNO_CREDITO')
                ->join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                ->select('FK_ACTIVIDAD')
                ->where('FK_ALUMNO','=',$pk_usuario)
                ->where('FK_LINEAMIENTO','=',$pk_lineamiento)
                ->get();
                $response = Response::json($act_registradas);
                return $response; */
 
                $alumno = DB::select('exec dbo.get_usuariolineamiento ?', array($asistencia_alumno_actividad)); //obtener el usuario del que se esta tomando asistencia y el lineamiento al que pertenece la actividad
        $sumatoria = DB::select('exec dbo.get_sumatorialineamiento ?,?', array($alumno[0]->alumno, $alumno[0]->lineamiento));//obtener sumatoria del valor de las actividades correspondientes al lineamiento obtenido
        

        $lin = DB::table('LINEAMIENTOS')->select('NOMBRE')
            ->where('PK_LINEAMIENTO','=', $alumno[0]->lineamiento )
            ->get()->first();
        if($lin->NOMBRE == 'Eventos Academicos relacionados con la carrera' || $lin->NOMBRE == 'Programa de Apoyo a la Formacion Profesional'){
            $calificacion = 'NOTABLE';
        }
        echo $calificacion;
            
        }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\asistenciaAlumnoActividad  $asistenciaAlumnoActividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(asistenciaAlumnoActividad $asistenciaAlumnoActividad)
    {
        //
    }
}
