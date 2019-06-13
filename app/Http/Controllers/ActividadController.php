<?php

namespace App\Http\Controllers;

use App\actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Log;

use DB;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividad = DB::table('actividades_v')->get();
        $response = Response::json($actividad);
        return $response;
        /*
        $actividad = Actividad::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
        ->join('TIPOS','FK_TIPO','=','PK_TIPO')
        ->SELECT('ACTIVIDADES.PK_ACTIVIDAD','ACTIVIDADES.NOMBRE','ACTIVIDADES.DESCRIPCION',
        'ACTIVIDADES.LUGAR','ACTIVIDADES.FECHA','ACTIVIDADES.HORA',
        'ACTIVIDADES.CUPO','LINEAMIENTOS.NOMBRE AS FK_LINEAMIENTO','TIPOS.NOMBRE AS FK_TIPO','ACTIVIDADES.FK_RESPONSABLE')
        ->get();

        echo json_encode($actividad);
        */
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
        $actividad = new actividad();
        $actividad->NOMBRE = $request->input('NOMBRE');
        $actividad->DESCRIPCION = $request->input('DESCRIPCION');
        $actividad->LUGAR = $request->input('LUGAR');
        $actividad->FECHA = $request->input('FECHA');
        $actividad->HORA = $request->input('HORA');
        $actividad->CUPO = $request->input('CUPO');
        $actividad->FK_LINEAMIENTO = $request->input('FK_LINEAMIENTO');
        $actividad->FK_TIPO = $request->input('FK_TIPO');
        $actividad->FK_RESPONSABLE = $request->input('FK_RESPONSABLE');
        $actividad->IMAGEN = $request->input('IMAGEN');
        $actividad->save();

        echo json_encode($actividad);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function show($id_alumno)
    {
        $hoy = Carbon::today();
        /* Mostrar las actividades en las que se encuentra registrado el alumno */
        $inscrito = DB::table('actividades_v')->join('ALUMNO_ACTIVIDAD','FK_ACTIVIDAD', '=', 'PK_ACTIVIDAD')
                    ->select('actividades_v.PK_ACTIVIDAD', 'actividades_v.NOMBRE', 'actividades_v.DESCRIPCION', 'actividades_v.LUGAR', 'actividades_v.FECHA',
                    'actividades_v.HORA', 'actividades_v.CUPO', 'actividades_v.FK_LINEAMIENTO', 'actividades_v.FK_TIPO', 'actividades_v.FK_RESPONSABLE')
                    ->where('ALUMNO_ACTIVIDAD.FK_ALUMNO','=',$id_alumno)
                    ->whereDate('actividades_v.FECHA','>=',$hoy)
                    ->orderBY('actividades_v.FECHA')
                    ->get();
        $response = Response::json($inscrito);
        return $response;
    }

    public function getActividadById($id_actividad){
        $actividad = DB::table('actividades_v')->select('*')
                    ->where('PK_ACTIVIDAD','=',$id_actividad)
                    ->get();

        $response = Response::json($actividad);
        return $response;

    }

    public function actividadesDisponibles($id_alumno)
    {
        $data = [];
        $hoy = Carbon::today();

        $inscrito = DB::table('actividades_v')->join('ALUMNO_ACTIVIDAD','FK_ACTIVIDAD', '=', 'PK_ACTIVIDAD')
        ->select('actividades_v.PK_ACTIVIDAD')
        ->where('ALUMNO_ACTIVIDAD.FK_ALUMNO','=',$id_alumno)
        ->groupBy('actividades_v.PK_ACTIVIDAD')
        ->get();

        foreach($inscrito as $i){
            $data[] = $i->PK_ACTIVIDAD;
        }

        $noInscrito = DB::table('actividades_v')
                    ->selectRaw("actividades_v.PK_ACTIVIDAD, actividades_v.NOMBRE, replace(convert(NVARCHAR, actividades_v.FECHA, 106), ' ', '/') as FECHA, actividades_v.LUGAR , actividades_v.CUPO")
                    ->whereNotIn('actividades_v.PK_ACTIVIDAD', $data)
                    ->whereDate('actividades_v.FECHA','>=',$hoy)
                    ->get(); 
        
        $response = Response::json($noInscrito);
        return $response;
    }

    public function getActRaw()/*Obtiene las actividades directamente de la tabla Actividades, no de la vista */
    {
        $actividad =  actividad::get();
        $response = Response::json($actividad);
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $actividad_id)
    {
        $actividad = Actividad::find($actividad_id);
        $actividad->NOMBRE = $request->input('NOMBRE');
        $actividad->DESCRIPCION = $request->input('DESCRIPCION');
        $actividad->LUGAR = $request->input('LUGAR');
        $actividad->FECHA = $request->input('FECHA');
        $actividad->HORA = $request->input('HORA');
        $actividad->CUPO = $request->input('CUPO');
        $actividad->FK_LINEAMIENTO = $request->input('FK_LINEAMIENTO');
        $actividad->FK_TIPO = $request->input('FK_TIPO');
        $actividad->FK_RESPONSABLE = $request->input('FK_RESPONSABLE');
        $actividad->IMAGEN = $request->input('IMAGEN');
        $actividad->save();

        echo json_encode($actividad);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy($actividad_id)
    {
        $actividad = Actividad::find($actividad_id);
        $actividad->delete();
    
    }


    public function signupComiteAcademico(Request $request)
    {
        //todo Cambiar a generación de objeto de usaurio de forma explícita

        $usuario = DB::table('users')
        ->select('PK_USUARIO')
        ->where('CURP',$request->CURP)
        ->get()->first();

        $response = Response::json($usuario->PK_USUARIO);
        return $response;

    }
    
}
