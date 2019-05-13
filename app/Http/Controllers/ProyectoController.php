<?php

namespace App\Http\Controllers;

use App\AnteproyectoResidencias;
use App\CreditosSiia;
use App\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
       $periodo = new CreditosSiia();
        if($request->Maestro) {
            $maestro = $request->Maestro;
            $cantidad = DB::select('SELECT CANTIDAD FROM PER_DOCENTE_PROYECTO 
                                          WHERE FK_DOCENTE = :docente AND PERIODO = :periodo', ['docente' => $maestro, 'periodo' =>$periodo->periodo()]);
            $cantidad1 = json_decode(json_encode($cantidad), true);
            $cantidad2 = array_pop($cantidad1);
            if ($cantidad2 != null) {
                $cantidad3 = array_pop($cantidad2);
            }
            if ($cantidad2 == null) {
                $proyecto = Proyecto::where('FK_ANTEPROYECTO', $id)->first();
                $proyecto->FK_DOCENTE = $maestro;
                if($request->Externo){
                    $proyecto->FK_ASESOR_EXT = $request->Externo;
                }
                $proyecto->save();
                $cantidad3 = 1;
                DB::insert('INSERT INTO PER_DOCENTE_PROYECTO (FK_DOCENTE,CANTIDAD,PERIODO) 
                                  VALUES(:maestro,:cantidad,:periodo)', ['maestro' => $maestro, 'cantidad' => $cantidad3, 'periodo'=>$periodo->periodo()]);
                return json_encode('correcto');
            }
            if ($cantidad3 < 3) {
                $proyecto = Proyecto::where('FK_ANTEPROYECTO', $id)->first();
                $proyecto->FK_DOCENTE = $maestro;
                if($request->Externo){
                    $proyecto->FK_ASESOR_EXT = $request->Externo;
                }
                $proyecto->save();
                $cantidad3 = $cantidad3 + 1;
                DB::statement('UPDATE PER_DOCENTE_PROYECTO SET CANTIDAD = :cantidad WHERE FK_DOCENTE = :maestro', ['cantidad' => $cantidad3, 'maestro' => $maestro]);
                return json_encode('correcto');
            } else {
                return json_encode('Maestro no puede tener más de 3 alumnos');
            }
        }
        if ($request->Externo){
            $proyecto = Proyecto::where('FK_ANTEPROYECTO', $id)->first();
            $proyecto->FK_ASESOR_EXT = $request->Externo;
            $proyecto->save();
        }

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
