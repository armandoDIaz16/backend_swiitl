<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BajaAlumnoController extends Controller
{

    public function index()
    {
        try {
            $alumno = DB::statement('DELETE FROM PER_TR_ROL_USUARIO WHERE FK_ROL = (SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = :fu)', ['fu' => 'Residente']);
            $docente = DB::statement('DELETE FROM PER_TR_ROL_USUARIO WHERE FK_ROL = (SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = :fa)', ['fa' => 'Asesor Docente']);
            $externo = DB::statement('DELETE FROM PER_TR_ROL_USUARIO WHERE FK_ROL = (SELECT PK_ROL FROM PER_CATR_ROL WHERE NOMBRE = :fe)', ['fe' => 'Asesor Externo']);
        }
        catch(\Exception $exception){
            return response()->json('Error al finalizar semestre');
        }
        return response()->json('Semestre finalizado correctamente');
    }


    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {
       try {
            DB::table('PER_TR_ROL_USUARIO')->join('CATR_ALUMNO', 'PER_TR_ROL_USUARIO.FK_USUARIO', '=', 'CATR_ALUMNO.ID_PADRE')
                ->where('NUMERO_CONTROL', $id)->delete();
        }catch(\Exception $exception){
            return response()->json('Error: no se pudo quitar rol al Alumno');
        }
        $idproyecto = DB::select('SELECT CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO 
                                         FROM CAT_ANTEPROYECTO_RESIDENCIA
                                         JOIN CATR_ALUMNO ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CATR_ALUMNO.ID_PADRE
                                         WHERE NUMERO_CONTROL = :nocontrol',['nocontrol'=>$id]);
        $idproyecto1 = json_decode(json_encode($idproyecto), true);
        $idproyecto2 = array_pop($idproyecto1);
        $idproyecto3 = array_pop($idproyecto2);

        try{
            DB::table('CATR_PROYECTO')->where('FK_ANTEPROYECTO',$idproyecto3)->delete();
        }catch(\Exception $exception){
            return response()->json('Error: no se pudo borrar el proyecto');
        }

        try{
            DB::table('CAT_ANTEPROYECTO_RESIDENCIA')->where('ID_ANTEPROYECTO',$idproyecto3)->update(['ALUMNO'=>NULL]);
        }catch(\Exception $exception){
            return response()->json('Error no se pudo liberar proyecto');
        }

        return response()->json('Alumno dado de baja correctamente');

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }
}
