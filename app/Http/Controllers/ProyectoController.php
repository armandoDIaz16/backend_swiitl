<?php

namespace App\Http\Controllers;

use App\AnteproyectoResidencias;
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
        $proyecto = new Proyecto();
        $proyecto->FK_ANTEPROYECTO = $request->id;
        $proyecto->save();
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
        $f = DB::select('SELECT ID_ANTEPROYECTO, NOMBRE FROM CAT_ANTEPROYECTO_RESIDENCIA WHERE AREA_ACADEMICA = :area AND ESTATUS = 2',['area'=>$d]);
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
        $maestro = $request->Maestro;
        $cantidad = DB::select('SELECT CANTIDAD FROM PER_DOCENTE_PROYECTO WHERE FK_DOCENTE = :docente',['docente'=>$maestro]);
        $cantidad1 = json_decode(json_encode($cantidad),true);
        $cantidad2 = array_pop($cantidad1);
        $cantidad3 = array_pop($cantidad2);
        if($cantidad3 == null){
            $proyecto = Proyecto::where('FK_ANTEPROYECTO',$id)->first();
            $proyecto->FK_DOCENTE = $maestro;
            $proyecto->save();
            $cantidad3 = 1;
            DB::insert('INSERT INTO PER_DOCENTE_PROYECTO (FK_DOCENTE,CANTIDAD) VALUES(:maestro,:cantidad)',['maestro'=>$maestro,'cantidad'=>$cantidad3]);
            return json_encode('correcto');
        }if($cantidad3 < 3){
            $proyecto = Proyecto::where('FK_ANTEPROYECTO',$id)->first();
            $proyecto->FK_DOCENTE = $maestro;
            $proyecto->save();
            $cantidad3 = $cantidad3+1;
            DB::statement('UPDATE PER_DOCENTE_PROYECTO SET CANTIDAD = :cantidad WHERE FK_DOCENTE = :maestro',['cantidad'=>$cantidad3 , 'maestro'=>$maestro]);
            return json_encode('correcto');
        }else{
            return json_encode('Maestro no puede tener más de 3 alumnos');
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
