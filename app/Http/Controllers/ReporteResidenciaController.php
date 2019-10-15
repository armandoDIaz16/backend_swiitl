<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use App\ReporteResidencia;
use App\PeriodoResidencia;
use App\Helpers\Base64ToFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteResidenciaController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


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
            /*$File = $request->file('myfile');
            $sub_path = 'files';
            $real_name =  /* 'Reporte'.$id.$request->ID; */
              /*  $File->getClientOriginalName();
            $destination_path = public_path($sub_path);
            $File->move($destination_path, $real_name);
            $Ruta = $sub_path . '/' . $real_name;*/
            $archivo = new Base64ToFile();
            $Ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            $reporte->NOMBRE = $request->Nombre;
            $reporte->ALUMNO = $request->id;
            $reporte->PDF = $Ruta;
            $reporte->NUMERO = $request->ID;
            $reporte->PERIODO = $periodo->periodo();
            $reporte->save();
            return response()->json('Reporte guardado');
        }
        return response()->json('No se puede entregar fuera de fecha');
    }


    public function show($id)
    {
        $x = DB::select('SELECT CATR_DOCENTE.NUMERO_EMPLEADO_DOCENTE FROM CATR_DOCENTE WHERE ID_PADRE = :padre',['padre'=>$id]);
        $y = DB::select('SELECT CATR_EXTERNO.ID_PADRE FROM CATR_EXTERNO WHERE ID_PADRE = :padre',['padre'=>$id]);
       // \Log::debug($x);
        if($x != null){
        $variable = DB::select('select CAT_REPORTE_RESIDENCIA.PK_REPORTE, CAT_REPORTE_RESIDENCIA.PDF, CAT_REPORTE_RESIDENCIA.ALUMNO, CAT_REPORTE_RESIDENCIA.NUMERO, CAT_REPORTE_RESIDENCIA.NOMBRE, CAT_USUARIO.NOMBRE as NOMBREALUMNO 
                                              from CAT_REPORTE_RESIDENCIA
                                              join CAT_ANTEPROYECTO_RESIDENCIA ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                              JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
                                              JOIN CAT_USUARIO ON CAT_USUARIO.PK_USUARIO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                              WHERE CATR_PROYECTO.FK_DOCENTE = :id',['id'=>$id]);
        }elseif($y != null){
            $variable = DB::select('SELECT CAT_REPORTE_RESIDENCIA.PK_REPORTE, CAT_REPORTE_RESIDENCIA.PDF, CAT_REPORTE_RESIDENCIA.ALUMNO, CAT_REPORTE_RESIDENCIA.NUMERO, CAT_REPORTE_RESIDENCIA.NOMBRE, CAT_USUARIO.NOMBRE as NOMBREALUMNO 
                                           FROM CAT_REPORTE_RESIDENCIA
                                           JOIN CAT_ANTEPROYECTO_RESIDENCIA ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                           JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
                                           JOIN CAT_USUARIO ON CAT_USUARIO.PK_USUARIO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                           WHERE CATR_PROYECTO.FK_ASESOR_EXT = :id',['id'=>$id]);
        }
        else{
            $variable = DB::select('SELECT CAT_REPORTE_RESIDENCIA.PK_REPORTE, CAT_REPORTE_RESIDENCIA.PDF, CAT_REPORTE_RESIDENCIA.ALUMNO, CAT_REPORTE_RESIDENCIA.NUMERO, CAT_REPORTE_RESIDENCIA.NOMBRE, CAT_USUARIO.NOMBRE as NOMBREALUMNO
                                          FROM CAT_REPORTE_RESIDENCIA
                                          JOIN CAT_USUARIO ON CAT_USUARIO.PK_USUARIO = CAT_REPORTE_RESIDENCIA.ALUMNO
                                          WHERE CAT_REPORTE_RESIDENCIA.ALUMNO = :id',['id'=>$id]);
        }
        return $variable;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
        //
    }
}
