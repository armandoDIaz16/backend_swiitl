<?php

namespace App\Http\Controllers;

use App\responsableActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;

class ResponsableActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = DB::table('responsables_v')->get();
        $response = Response::json($res);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\responsableActividad  $responsableActividad
     * @return \Illuminate\Http\Response
     */
    public function show($id_usuario)//rerotna todas las actividades asignadas al responsable de actividad
    {
        $actividades = DB::table('actividades_v')
            ->join('ACTIVIDADES','ACTIVIDADES.PK_ACTIVIDAD','=','actividades_v.PK_ACTIVIDAD')
            ->select('actividades_v.PK_ACTIVIDAD', 'actividades_v.NOMBRE', 'actividades_v.DESCRIPCION', 'actividades_v.LUGAR', 'actividades_v.FECHA',
                    'actividades_v.HORA', 'actividades_v.CUPO', 'actividades_v.FK_LINEAMIENTO', 'actividades_v.FK_TIPO', 'actividades_v.FK_RESPONSABLE')
            ->where('ACTIVIDADES.FK_RESPONSABLE','=', $id_usuario)
            ->orderBy('actividades_v.FECHA','DESC')
            ->get();

        $response = Response::json($actividades);
        return $response;
    
    }

    public function getListaAsistentes($pk_actividad){//obtener lista de asistencia por actividad
        $alumnos = DB::table('users')
            ->join('ALUMNO_ACTIVIDAD', 'ALUMNO_ACTIVIDAD.FK_ALUMNO','=','users.PK_USUARIO')
            ->join('ACTIVIDADES','ACTIVIDADES.PK_ACTIVIDAD','=','ALUMNO_ACTIVIDAD.FK_ACTIVIDAD')
            ->join('ASISTENCIA_ALUMNO_ACTIVIDAD','ASISTENCIA_ALUMNO_ACTIVIDAD.FK_ALUMNO_ACTIVIDAD','=','ALUMNO_ACTIVIDAD.PK_ALUMNO_ACTIVIDAD')
            ->select('users.PK_USUARIO','users.PRIMER_APELLIDO','users.SEGUNDO_APELLIDO','users.name','ASISTENCIA_ALUMNO_ACTIVIDAD.ENTRADA','ASISTENCIA_ALUMNO_ACTIVIDAD.SALIDA')
            ->where('ACTIVIDADES.PK_ACTIVIDAD','=',$pk_actividad)
         /*    ->where('ASISTENCIA_ALUMNO_ACTIVIDAD.ENTRADA','=',1)
            ->where('ASISTENCIA_ALUMNO_ACTIVIDAD.SALIDA','=',1) */
            ->orderBy('users.PRIMER_APELLIDO')
            ->get();
        $response = Response::json($alumnos);
        return $response;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\responsableActividad  $responsableActividad
     * @return \Illuminate\Http\Response
     */
    public function edit(responsableActividad $responsableActividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\responsableActividad  $responsableActividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, responsableActividad $responsableActividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\responsableActividad  $responsableActividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(responsableActividad $responsableActividad)
    {
        //
    }
}
