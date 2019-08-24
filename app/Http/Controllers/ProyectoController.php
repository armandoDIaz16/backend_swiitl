<?php

namespace App\Http\Controllers;

use App\AnteproyectoResidencias;
use App\CreditosSiia;
use App\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
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
        try{
           $x = DB::select('SELECT * FROM CATR_PROYECTO WHERE FK_ANTEPROYECTO = :id',['id'=>$request->id]);
            if($x != null){
                return response()->json('Proyecto ya estaba aprobado');
            }else {
                $proyecto = new Proyecto();
                $proyecto->FK_ANTEPROYECTO = $request->id;
                $proyecto->save();
                return response()->json('Aprobado con exito');
            }
        }catch(\Exception $exception){
                return response()->json('Error');
        }
    }


    public function show($id)
    {
        $a = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :numero', ['numero' => $id]);
        $b = json_decode(json_encode($a),true);
        $c = array_pop($b);
        $d = array_pop($c);
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $f = DB::select('SELECT ID_ANTEPROYECTO, NOMBRE 
                                FROM CAT_ANTEPROYECTO_RESIDENCIA 
                                JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = FK_ANTEPROYECTO
                                WHERE AREA_ACADEMICA = :area 
                                AND ESTATUS = 2
                                AND CATR_PROYECTO.PERIODO = :periodo
                                AND (CATR_PROYECTO.FK_DOCENTE IS NULL 
                                OR CATR_PROYECTO.FK_ASESOR_EXT IS NULL)',['area'=>$d,'periodo'=>$actual]);
        return $f;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
       $periodo = new CreditosSiia();
        if($request->Maestro) {
            $maestro = $request->Maestro;
            $prueba = DB::select('SELECT COUNT(CATR_PROYECTO.PK_PROYECTO)
                                        FROM CATR_PROYECTO
                                        WHERE CATR_PROYECTO.FK_DOCENTE = :cco
                                        AND PERIODO = :periodo',['cco'=>$maestro, 'periodo'=>$periodo->periodo()]);
            $prueba1 = json_decode(json_encode($prueba), true);
            $prueba2 = array_pop($prueba1);
            $prueba3 = array_pop($prueba2);
            if ($prueba3 == 0) {
                DB::table('PER_TR_ROL_USUARIO')->insert(['FK_ROL' => '10', 'FK_USUARIO' => $maestro]);
                $proyecto = Proyecto::where('FK_ANTEPROYECTO', $id)->first();
                $proyecto->FK_DOCENTE = $maestro;
                if($request->Externo){
                    $externo = $request->Externo;
                    $prueb = DB::select('SELECT COUNT(CATR_PROYECTO.PK_PROYECTO)
                                        FROM CATR_PROYECTO
                                        WHERE CATR_PROYECTO.FK_ASESOR_EXT = :cco
                                        AND PERIODO = :periodo',['cco'=>$externo, 'periodo'=>$periodo->periodo()]);
                    $prueb1 = json_decode(json_encode($prueb), true);
                    $prueb2 = array_pop($prueb1);
                    $prueb3 = array_pop($prueb2);
                    if ($prueb3 == 0){
                        DB::table('PER_TR_ROL_USUARIO')->insert(['FK_ROL' => '11', 'FK_USUARIO' => $externo]);
                    }
                    $proyecto->FK_ASESOR_EXT = $request->Externo;
                }
                try{
                    $proyecto->save();
                    return json_encode('correcto');}
                catch(\Exception $exception){
                    return response()->json('Error');
                }
            }
            else {
                $proyecto = Proyecto::where('FK_ANTEPROYECTO', $id)->first();
                $proyecto->FK_DOCENTE = $maestro;
                if($request->Externo){
                    $externo = $request->Externo;
                    $prueb = DB::select('SELECT COUNT(CATR_PROYECTO.PK_PROYECTO)
                                        FROM CATR_PROYECTO
                                        WHERE CATR_PROYECTO.FK_ASESOR_EXT = :cco
                                        AND PERIODO = :periodo',['cco'=>$externo, 'periodo'=>$periodo->periodo()]);
                    $prueb1 = json_decode(json_encode($prueb), true);
                    $prueb2 = array_pop($prueb1);
                    $prueb3 = array_pop($prueb2);
                    if ($prueb3 == 0){
                        DB::table('PER_TR_ROL_USUARIO')->insert(['FK_ROL' => '11', 'FK_USUARIO' => $externo]);
                    }
                    $proyecto->FK_ASESOR_EXT = $request->Externo;
                }
                try{
                    $proyecto->save();
                    return json_encode('correcto');}
                catch(\Exception $exception){
                    return response()->json('Error');
                }
            }
        }
        if ($request->Externo){
            $externo = $request->Externo;
            $prueb = DB::select('SELECT COUNT(CATR_PROYECTO.PK_PROYECTO)
                                        FROM CATR_PROYECTO
                                        WHERE CATR_PROYECTO.FK_ASESOR_EXT = :cco
                                        AND PERIODO = :periodo',['cco'=>$externo, 'periodo'=>$periodo->periodo()]);
            $prueb1 = json_decode(json_encode($prueb), true);
            $prueb2 = array_pop($prueb1);
            $prueb3 = array_pop($prueb2);
            if ($prueb3 == 0){
                DB::table('PER_TR_ROL_USUARIO')->insert(['FK_ROL' => '11', 'FK_USUARIO' => $externo]);
            }
            $proyecto = Proyecto::where('FK_ANTEPROYECTO', $id)->first();
            $proyecto->FK_ASESOR_EXT = $request->Externo;
            try{
            $proyecto->save();
            return json_encode('correcto');}
            catch(\Exception $exception){
                return response()->json('Error');
            }
        }

    }


    public function destroy($id)
    {
        //
    }

    public function alumnos($id){
        $proyecto1 = DB::select('SELECT * FROM CATR_PROYECTO JOIN CAT_ANTEPROYECTO_RESIDENCIA ON CATR_PROYECTO.FK_ANTEPROYECTO = CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO
                                        JOIN CATR_ALUMNO ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CATR_ALUMNO.ID_PADRE WHERE NUMERO_CONTROL = :noc',['noc'=>$id]);
        $proyecto = DB::table('CATR_PROYECTO')->join('CAT_ANTEPROYECTO_RESIDENCIA','CATR_PROYECTO.FK_ANTEPROYECTO','=','CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO')
        ->join('CATR_ALUMNO','CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO','=', 'CATR_ALUMNO.ID_PADRE')->where('NUMERO_CONTROL','=', $id)->first();
        return response()->json($proyecto1);
    }

    public function maestros($id){
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $maestros = DB::select('SELECT ID_PADRE, NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO FROM CATR_DOCENTE JOIN CAT_USUARIO ON CATR_DOCENTE.ID_PADRE = CAT_USUARIO.PK_USUARIO WHERE ID_AREA_ACADEMICA = (SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE ID_PADRE = :padre)',['padre'=>$id]);
        foreach ($maestros as $index => $value){
            $te = $value->ID_PADRE;
            $cantidad = DB::select('SELECT COUNT(PK_PROYECTO) FROM CATR_PROYECTO WHERE FK_DOCENTE = :te and PERIODO = :periodo',['te'=>$te, 'periodo'=>$actual]);
            $c1 = json_decode(json_encode($cantidad), true);
            $c2 = array_pop($c1);
            $c3 = array_pop($c2);
            $value->CANTIDAD = $c3;
        }
        return $maestros;
    }
}
