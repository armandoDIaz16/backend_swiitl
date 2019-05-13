<?php

namespace App\Http\Controllers;

use App\asistenteActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

use DB;

class AsistenteActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asistente_actividad = asistenteActividad::get();
        $response = Response::json($asistente_actividad);
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
        $registro_rol = DB::select('exec getNumRegistrosRolAsistente ?,?', array(2002,$request->FK_USUARIO));

        if($registro_rol){
            $sistente_actividad = new asistenteActividad();
            $sistente_actividad->FK_USUARIO = $request->FK_USUARIO;
            $sistente_actividad->FK_ACTIVIDAD = $request->FK_ACTIVIDAD;
            $sistente_actividad->save();
        }else{
        DB::table('PER_TR_ROL_USUARIO')
            ->insert(array('FK_ROL' => 2002, 'FK_USUARIO' => $request->FK_USUARIO));
            $sistente_actividad = new asistenteActividad();
            $sistente_actividad->FK_USUARIO = $request->FK_USUARIO;
            $sistente_actividad->FK_ACTIVIDAD = $request->FK_ACTIVIDAD;
            $sistente_actividad->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function show($pk_actividad)//muestra la lista de alumnos designados para tomar asistencia en alguna actividad en especifico
    {
        $asitentes = asistenteActividad::join('users','PK_USUARIO','=','FK_USUARIO')
                        ->select('PRIMER_APELLIDO','SEGUNDO_APELLIDO','name')
                        ->where('FK_ACTIVIDAD','=',$pk_actividad)
                        ->get();
    
        $response = Response::json($asitentes);
        return $response;
    }
    
    public function getAlumnoByNc($num_control)//obtener el nombre completo del alumno mediante el numero de control
    {
        $usuario = DB::connection('sqlsrv2')
                    ->table('view_alumnos')
                    ->select('ApellidoPaterno','ApellidoMaterno','Nombre')
                    ->where('NumeroControl','=',$num_control)
                    ->get();

        $response = Response::json($usuario);
        return $response;
    }

    public function getPkuserByName($apellidoPaterno, $apellidoMaterno,$nombre){//Obtener el id del usuario mediante el mnombre completo
        $pk_usuario = DB::table('users')
                    ->select('PK_USUARIO as FK_USUARIO')
                    ->where('PRIMER_APELLIDO','=',$apellidoPaterno)
                    ->where('SEGUNDO_APELLIDO','=',$apellidoMaterno)
                    ->where('name','=',$nombre)
                    ->get();

        $response = Response::json($pk_usuario);
        return $response;                
    }


    //estos son servicios para los alumnos con el rol de asistentes
    public function habilitarTomaAsistencia(){
        $fechaActual = Carbon::now();
        $fechaActual = $fechaActual->format('Y-m-d');
        
        $fechaActividad = DB::table('ACTIVIDADES')
                          ->select('PK_ACTIVIDAD','FECHA')
                          ->where('PK_ACTIVIDAD','=',1005)
                          ->get()->first();
        
        $fechaActCarbon = Carbon::parse($fechaActividad->FECHA)->format('Y-m-d');
/* 
       echo $fechaActual;
       echo $fechaActCarbon; */

       if($fechaActual == $fechaActCarbon){
            $horaActual = Carbon::now();
            $horaActual = $horaActual->format('G:i');

            $horaActividad = DB::table('actividades_v')
                         ->select('PK_ACTIVIDAD','HORA')
                         ->where('PK_ACTIVIDAD','=',1005)
                         ->get()->first();
            //$fecha_hora = $fechaActividad->FECHA +
            
            $horaActividadCarbon = Carbon::parse($horaActividad->HORA)->format('h:i A');
            $horaInicio = Carbon::parse($horaActividad->HORA)->subHours(1)->format('G:i');
            $horaFinal = Carbon::parse($horaActividad->HORA)->addHours(2)->format('G:i');
            /* echo $horaActual;
            echo $horaInicio;
            echo $horaFinal; */
            if(strtotime($horaActual) > strtotime($horaInicio) && strtotime($horaActual) < strtotime($horaFinal)){
                return "Registro de asistencia habilitado";
            }else{
                return "Registro de asistencia deshabilitado";
            }
        }else if($fechaActual > $fechaActCarbon){
            return "La fecha de la actividad ya paso";
        }else{
            return "La fecha de la actividad aun no llega";
           }
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function edit(asistenteActividad $asistenteActividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, asistenteActividad $asistenteActividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\asistenteActividad  $asistenteActividad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sistente_actividad = asistenteActividad::find($id);
        $sistente_actividad->delete();
    }
}
