<?php

namespace App\Http\Controllers;

use App\asistenciaAlumnoActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        //$asistencia_alumno_actividad->SALIDA = $request->SALIDA;
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
       /*  $pk = asistenciaAlumnoActividad::select('PK_ASISTENCIA_ALUMNO_ACTIVIDAD as pk')
                ->where('FK_ALUMNO_ACTIVIDAD','=', $fk_alumno_actividad)
                ->get()->first();
 */
        $asistencia_alumno_actividad = asistenciaAlumnoActividad::find($pk);
        $asistencia_alumno_actividad->SALIDA = $request->SALIDA;
        $asistencia_alumno_actividad->save();

        $alumno = DB::select('exec dbo.get_usuariolineamiento ?', array($pk)); //obtener el usuario del que se esta tomando asistencia y el lineamiento al que pertenece la actividad
        $sumatoria = DB::select('exec dbo.get_sumatorialineamiento ?,?', array($alumno[0]->alumno, $alumno[0]->lineamiento));//obtener sumatoria del valor de las actividades correspondientes al lineamiento obtenido

        if ($sumatoria[0]->total == 100 or $sumatoria[0]->total == 200){ //si la sumatoria vale 100 o 200 significa que hay que registrar un credito

            $num_registros = DB::select('exec dbo.num_creditosbylineamiento ?,?', array($alumno[0]->lineamiento, $alumno[0]->alumno)); //obtener la cantidad de creditos que ya tiene registrados el alumno correspondientes al lineamiento obtenido

            if($num_registros){ //si ya  creditos de este mismo lineamiento registrados entonces...
                $lineamiento = DB::table('LINEAMIENTOS')->select('*')//obtener los datos completos del lineamiento obtenido
                        ->where('PK_LINEAMIENTO','=',$sumatoria[0]->pk_lineamiento)->get()->first();
                
                if($num_registros[0]->registros < $lineamiento->LIMITE){//si la cantidad de creditos registrado para este lineamiento es menor al limite de registros permitidos entonces..
                    //DB::select('exec dbo.insert_alumnocreditos ?,?',array($alumno[0]->alumno, $alumno[0]->lineamiento));//insertar el credito cumplido                    
                    DB::table('ALUMNO_CREDITO')->insert(//insertar el credito cumplido
                        array('FK_ALUMNO' => $alumno[0]->alumno, 'FK_LINEAMIENTO' => $alumno[0]->lineamiento));
                    echo("nuevo credito registrado");
                }else{//sino significa que ya se rebaso el limite
                    echo("No se pueden registrar mas creditos de este tipo. Superaste el limite de creditos permitidos para este lineamiento");
                }           
            }else{//si la variable $num_registros no contiene nada significa que no hay ningun registro de algun credito para este lineamiento, entonces...
                DB::table('ALUMNO_CREDITO')->insert(//insertar el credito cumplido
                    array('FK_ALUMNO' => $alumno[0]->alumno, 'FK_LINEAMIENTO' => $alumno[0]->lineamiento));
                echo("nuevo credito registrado");
            }            
        }


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
