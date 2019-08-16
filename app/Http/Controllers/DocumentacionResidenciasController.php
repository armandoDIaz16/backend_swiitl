<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use Illuminate\Http\Request;
use App\CargaArchivo;
use App\DocumentacionResidencias;
use App\PeriodoResidencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DocumentacionResidenciasController extends Controller
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
        $documentacion = new Documentacion();
        $documentacion->ALUMNO = $request->ALUMNO;
        $documentacion->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Return DocumentacionResidencias::where('ALUMNO',$id)->get();
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
        $documentacion = DocumentacionResidencias::find($id);
        $carga = new CargaArchivo();


        if($request->id == 1):
            $ruta = $carga->savefile($request);
            $documentacion->carta_documentacion = $ruta;
        else:
            $ruta = $carga->savefile($request);
            $documentacion->carta_aceptacion = $ruta;
        endif;
            $documentacion->save();
    }


    public function updatesolicitud(Request $request){
        $id = $request->id;
        $fecha = new PeriodoResidencia();
        $dia = date('Y-m-d');
        $diai = $fecha->FIniA($id,2);
        $diaf = $fecha->FFinA($id,2);
        if($diai<=$dia && $dia<=$diaf) {
            $documentacion = DocumentacionResidencias::where('ALUMNO', $id)->first();
            //   \Log::debug('Prueba ' . $id);
            $File = $request->file('myfile'); //line 1
            $sub_path = 'files'; //line 2
            $real_name = $File->getClientOriginalName(); //line 3
            $destination_path = public_path($sub_path);  //line 4
            $File->move($destination_path, $real_name);  //line 5
            $Ruta = $sub_path . '/' . $real_name;
            $documentacion->SOLICITUD = $Ruta;
            $documentacion->save();
            return response()->json('Solicitud guardada');
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
            $documentacion = DocumentacionResidencias::where('ALUMNO', $id)->first();

            $File = $request->file('myfile'); //line 1
            $sub_path = 'files'; //line 2
            $real_name = $File->getClientOriginalName(); //line 3
            $destination_path = public_path($sub_path);  //line 4
            $File->move($destination_path, $real_name);  //line 5
            $Ruta = $sub_path . '/' . $real_name;
            $documentacion->CARTA_ACEPTACION = $Ruta;
            $documentacion->save();
            return response()->json('Carta de aceptacion guardada');
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

    public function destroy($id)
    {
        //
    }
}
