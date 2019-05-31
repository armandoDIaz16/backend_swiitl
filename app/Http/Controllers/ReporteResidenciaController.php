<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use App\ReporteResidencia;
use App\PeriodoResidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteResidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $reporte = new ReporteResidencia();
        $Fecha = new PeriodoResidencia();
        $periodo = new CreditosSiia();
        $x = $request->ID;
        $y = 0;
        switch($x){
            case 1:
                $y = 3;
                break;
            case 2:
                $y = 4;
                break;
            case 3:
                $y = 5;
                break;
        }
        try{
        $diai = $Fecha->FIniA($request->id, $y);
        $diaf = $Fecha->FFinA($request->id, $y);}
        catch(\Exception $exception){
            return response()->json('Fecha aun no activa');
        }
        $dia = date('Y-m-d');
        if ($diai<=$dia && $dia<=$diaf) {
            $File = $request->file('myfile');
            $sub_path = 'files';
            $real_name =  /* 'Reporte'.$id.$request->ID; */
                $File->getClientOriginalName();
            $destination_path = public_path($sub_path);
            $File->move($destination_path, $real_name);
            $Ruta = $sub_path . '/' . $real_name;
            $reporte->NOMBRE = $real_name;
            $reporte->ALUMNO = $request->id;
            $reporte->PDF = $Ruta;
            $reporte->NUMERO = $request->ID;
            $reporte->PERIODO = $periodo->periodo();
            $reporte->save();
            return response()->json('Reporte guardado');
        }
        return response()->json('No se puede entregar fuera de fecha');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $x = DB::select('SELECT CATR_DOCENTE.NUMERO_EMPLEADO_DOCENTE FROM CATR_DOCENTE WHERE ID_PADRE = :padre',['padre'=>$id]);
        $y = DB::select('SELECT CATR_EXTERNO.ID_PADRE FROM CATR_EXTERNO WHERE ID_PADRE = :padre',['padre'=>$id]);
       // \Log::debug($x);
        if($x != null){
        $variable = DB::select('select CAT_REPORTE_RESIDENCIA.PK_REPORTE, CAT_REPORTE_RESIDENCIA.PDF, CAT_REPORTE_RESIDENCIA.ALUMNO, CAT_REPORTE_RESIDENCIA.NUMERO, CAT_REPORTE_RESIDENCIA.NOMBRE, users.name 
                                              from CAT_REPORTE_RESIDENCIA
                                              join CAT_ANTEPROYECTO_RESIDENCIA ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                              JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
                                              JOIN users ON users.PK_USUARIO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                              WHERE CATR_PROYECTO.FK_DOCENTE = :id',['id'=>$id]);
        }elseif($y != null){
            $variable = DB::select('SELECT CAT_REPORTE_RESIDENCIA.PK_REPORTE, CAT_REPORTE_RESIDENCIA.PDF, CAT_REPORTE_RESIDENCIA.ALUMNO, CAT_REPORTE_RESIDENCIA.NUMERO, CAT_REPORTE_RESIDENCIA.NOMBRE, users.name 
                                           FROM CAT_REPORTE_RESIDENCIA
                                           JOIN CAT_ANTEPROYECTO_RESIDENCIA ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                           JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
                                           JOIN users ON users.PK_USUARIO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                           WHERE CATR_PROYECTO.FK_ASESOR_EXT = :id',['id'=>$id]);
        }
        else{
            $variable = DB::select('SELECT CAT_REPORTE_RESIDENCIA.PK_REPORTE, CAT_REPORTE_RESIDENCIA.PDF, CAT_REPORTE_RESIDENCIA.ALUMNO, CAT_REPORTE_RESIDENCIA.NUMERO, CAT_REPORTE_RESIDENCIA.NOMBRE, users.name
                                          FROM CAT_REPORTE_RESIDENCIA
                                          JOIN users ON users.PK_USUARIO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                          WHERE CAT_REPORTE_RESIDENCIA.ALUMNO = :id',['id'=>$id]);
        }
        return $variable;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
