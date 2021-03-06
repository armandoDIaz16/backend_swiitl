<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use App\Helpers\Base64ToFile;
use Illuminate\Http\Request;
use App\CargaArchivo;
use App\DocumentacionResidencias;
use App\PeriodoResidencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DocumentacionResidenciasController extends Controller
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
        $documentacion = new Documentacion();
        $documentacion->ALUMNO = $request->ALUMNO;
        $documentacion->save();
    }


    public function show($id)
    {
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $documentos = DB::select('SELECT CAT_DOCUMENTACION.CARTA_ACEPTACION, CAT_DOCUMENTACION.SOLICITUD, CAT_USUARIO.NOMBRE, CAT_DOCUMENTACION.CARTA_FINALIZACION, PRIMER_APELLIDO,
                                    SEGUNDO_APELLIDO, PK_USUARIO 
                                  FROM CAT_DOCUMENTACION 
                                  JOIN CATR_ALUMNO ON CAT_DOCUMENTACION.ALUMNO = CATR_ALUMNO.ID_PADRE
                                  JOIN CAT_USUARIO ON CATR_ALUMNO.ID_PADRE = CAT_USUARIO.PK_USUARIO
                                  JOIN CATR_CARRERA ON CATR_ALUMNO.CLAVE_CARRERA = CATR_CARRERA.CLAVE
                                  WHERE CATR_CARRERA.FK_AREA_ACADEMICA = :caa
                                  AND CAT_DOCUMENTACION.PERIODO = :periodo',['caa'=>$id,'periodo'=>$actual]);

        foreach ($documentos as $index => $value) {
            $no = $value->PK_USUARIO;
            $informe = DB::select('SELECT INFORME FROM CAT_INFORME_ALUMNO WHERE FK_ALUMNO = :alumno',['alumno'=>$no]);
            $in = json_decode(json_encode($informe), true);
            if( $in != null) {
                $in2 = array_pop($in);
                $in3 = array_pop($in2);
                $value->INFORME = $in3;
            } else {
                $value->INFORME = $in;
            }
        }

            return $documentos;
    }


    public function edit($id)
    {
        Return DocumentacionResidencias::where('ALUMNO',$id)->get();
    }


    public function update(Request $request, $id)
    {
        $documentacion = DocumentacionResidencias::find($id);
        $carga = new CargaArchivo();


        if($request->id == 1):
            $ruta = $carga->savefile($request);
            $documentacion->carta_documentacion = $ruta;
        else:
            $ruta = $carga->savefile($request);
            $documentacion->carta_aceptacion = $ruta;
        endif;
        try{
            $documentacion->save();
            return response()->json('Guardado con exito');}
            catch(\Exception $exception){
            return response()->json('Error al guardar');
            }
    }


    public function updatesolicitud(Request $request){
        $id = $request->id;
        $fecha = new PeriodoResidencia();
        $dia = date('Y-m-d');
        $diai = $fecha->FIniA($id,2);
        $diaf = $fecha->FFinA($id,2);
        if($diai<=$dia && $dia<=$diaf) {
            $archivo = new Base64ToFile();
            $Ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            list($id1, $id2) = explode('files', $Ruta);
            $Ruta2 = 'files'.$id2;
            try{
                DB::table('CAT_DOCUMENTACION')->where('ALUMNO',$id)->update(['SOLICITUD' => $Ruta2]);
                return response()->json('Solicitud guardada');}
            catch(\Exception $exception){
                return response()->json('Error al guardar');
            }
        }
        return response()->json('Fuera de fecha permitida');
    }

    public function updateaceptacion(Request $request){
        $id = $request->id;
        $fecha = new PeriodoResidencia();
        $dia = date('Y-m-d');
        $diai = $fecha->FIniA($id,2);
        $diaf = $fecha->FFinA($id,2);
        if($diai<=$dia && $dia<=$diaf) {
            $archivo = new Base64ToFile();
            $Ruta = $archivo->guardarArchivo($request->Sistema, $request->Nombre, $request->Extencion, $request->Archivo);
            list($id1, $id2) = explode('files', $Ruta);
            $Ruta2 = 'files'.$id2;
            try{
                DB::table('CAT_DOCUMENTACION')->where('ALUMNO',$id)->update(['CARTA_ACEPTACION' => $Ruta2]);
                return response()->json('Carta de aceptacion guardada');}
            catch(\Exception $exception){
                return response()->json('Error al guardar');
            }
        }
        return response()->json('Fuera de fecha permitida');
    }

    public function verdoc($id){
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $documentos = DB::select('SELECT CAT_DOCUMENTACION.CARTA_ACEPTACION, CAT_DOCUMENTACION.SOLICITUD, CAT_USUARIO.NOMBRE, CAT_DOCUMENTACION.CARTA_FINALIZACION, PRIMER_APELLIDO,
                                    SEGUNDO_APELLIDO, PK_USUARIO 
                                  FROM CAT_DOCUMENTACION 
                                  JOIN CATR_ALUMNO ON CAT_DOCUMENTACION.ALUMNO = CATR_ALUMNO.ID_PADRE
                                  JOIN CAT_USUARIO ON CATR_ALUMNO.ID_PADRE = CAT_USUARIO.PK_USUARIO
                                  JOIN CATR_CARRERA ON CATR_ALUMNO.CLAVE_CARRERA = CATR_CARRERA.CLAVE
                                  WHERE CATR_CARRERA.FK_AREA_ACADEMICA = (SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :caa)
                                  AND CAT_DOCUMENTACION.PERIODO = :periodo',['caa'=>$id,'periodo'=>$actual]);

        foreach ($documentos as $index => $value) {
            $no = $value->PK_USUARIO;
            $informe = DB::select('SELECT INFORME FROM CAT_INFORME_ALUMNO WHERE FK_ALUMNO = :alumno',['alumno'=>$no]);
            $in = json_decode(json_encode($informe), true);
            if( $in != null) {
                $in2 = array_pop($in);
                $in3 = array_pop($in2);
                $value->INFORME = $in3;
            } else {
                $value->INFORME = $in;
            }
        }

        return $documentos;
    }

    public function archivos($id){
        $documentos = DB::select('SELECT CAT_DOCUMENTACION.CARTA_ACEPTACION, CAT_DOCUMENTACION.SOLICITUD
                                        FROM CAT_DOCUMENTACION
                                        WHERE CAT_DOCUMENTACION.ALUMNO = :alumno ', ['alumno'=>$id]);
        return $documentos;
    }

    public function destroy($id)
    {
        //
    }
}
