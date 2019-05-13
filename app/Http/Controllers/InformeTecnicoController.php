<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InformeTecnico;
use App\CreditosSiia;
use App\PeriodoResidencia;
use App\CargaArchivo;
use Illuminate\Support\Facades\DB;

class InformeTecnicoController extends Controller
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
        $fecha = new PeriodoResidencia();
        $dia = ('Y-m-d');
        $diai = $fecha->FIniA($request->FK_ALUMNO,5);
        $diaf = $fecha->FFinD($request->FK_ALUMNO,5);
        if ($diai<=$dia && $dia<=$diaf){
            $informe = new InformeTecnico();
            $carga = new CargaArchivo();
            $periodo = new CreditosSiia();
            $ruta = $carga->saveFile($request);
            $informe->INFORME = $ruta;
            $informe->FK_ALUMNO = $request->FK_ALUMNO;
            $informe->PERIODO = $periodo->periodo();
            $informe->save();
            return response()->json('Guardado ocn exito');
        }
        return response()->json('Fuera de fecha permitida');
    }

    public function show($id)
    {
        $area = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :padre',['padre'=>$id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();

        $proyectos = DB::select('SELECT CAT_INFORME_ALUMNO.INFORME, users.name FROM CAT_INFORME_ALUMNO
                                        JOIN CATR_ALUMNO ON CAT_INFORME_ALUMNO.FK_ALUMNO = CATR_ALUMNO.ID_PADRE
                                        JOIN users ON CATR_ALUMNO.ID_PADRE = users.PK_USUARIO
                                        JOIN CATR_CARRERA ON CATR_ALUMNO.CLAVE_CARRERA = CATR_CARRERA.PK_CARRERA
                                        WHERE CATR_CARRERA.FK_AREA_ACADEMICA = :area
                                        AND CAT_INFORME_ALUMNO.PERIODO = :periodo',['area'=>$area3, 'periodo'=>$actual]);
        return $proyectos;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
