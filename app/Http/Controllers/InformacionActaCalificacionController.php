<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use App\InformacionActaCalificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformacionActaCalificacionController extends Controller
{

    public function index()
    {
        $periodo = new CreditosSiia();
        $info = new InformacionActaCalificacion();
        $actual = $periodo->periodo();
        $letra = $info->LetraPeriodo();
        $anio = date('y');
        $residentes = DB::select('SELECT CATR_ALUMNO.NUMERO_CONTROL 
                                        FROM CATR_ALUMNO
                                        JOIN users ON CATR_ALUMNO.ID_PADRE = users.PK_USUARIO
                                        JOIN PER_TR_ROL_USUARIO ON users.PK_USUARIO = PER_TR_ROL_USUARIO.FK_USUARIO
                                        JOIN PER_CATR_ROL ON PER_TR_ROL_USUARIO.FK_ROL = PER_CATR_ROL.PK_ROL
                                        WHERE PER_CATR_ROL.NOMBRE = :rol',['rol'=>'Residente']);
        $residentes1 = json_decode(json_encode($residentes), true);

        $folio = DB::select('SELECT FOLIO FROM CAT_CONFIGURACION_ESCOLARES WHERE PERIODO = :periodo',['periodo'=>$actual]);
        $folio1 = json_decode(json_encode($folio), true);
        $folio2 = array_pop($folio1);
        $folio3 = array_pop($folio2);

        $fecha = DB::select('SELECT FECHA FROM CAT_CONFIGURACION_ESCOLARES WHERE PERIODO = :periodo',['periodo'=>$actual]);
        $fecha1 = json_decode(json_encode($fecha), true);
        $fecha2 = array_pop($fecha1);
        $fecha3 = array_pop($fecha2);

        try {
            foreach ($residentes as $r) {
                $residentes2 = array_pop($residentes1);
                $residentes3 = array_pop($residentes2);

                $folioF = $anio . '24' . $folio3 . $letra;

                DB::table('CAT_CARTA_CALIFICACION_RESIDENCIA')->insert(['FOLIO_ASIGNADO' => $folioF, 'FECHA' => $fecha3, 'NUMERO_CONTROL' => $residentes3]);

                $folio3++;
            }
        }catch (\Exception $exception){
            return response()->json('Error');
        }
        return response()->json('Asignados con exito');



    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
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
