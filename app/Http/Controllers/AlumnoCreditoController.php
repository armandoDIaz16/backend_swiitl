<?php

namespace App\Http\Controllers;

use App\alumnoCredito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use DB;

class AlumnoCreditoController extends Controller
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


    public function store(Request $request)
    {
        $alumnoCredito = new alumnoCredito();
        $alumnoCredito->FK_ALUMNO = $request->FK_ALUMNO;
        $alumnoCredito->FK_LINEAMIENTO = $request->FK_LINEAMIENTO;
        $alumnoCredito->save();

        echo json_encode($alumnoCredito);

    }

    public function show($pk_usuario)
    {
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->select('PK_ALUMNO_CREDITO','LINEAMIENTOS.NOMBRE','PERIODO','VALIDADO')
                    ->where('FK_ALUMNO','=',$pk_usuario)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }

    public function getCreditosPorValidar(){
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->join('CAT_USUARIO','FK_ALUMNO','=','PK_USUARIO')
                    ->select('PK_ALUMNO_CREDITO', 'LINEAMIENTOS.NOMBRE', 'CAT_USUARIO.NUMERO_CONTROL','CAT_USUARIO.PRIMER_APELLIDO','CAT_USUARIO.SEGUNDO_APELLIDO','CAT_USUARIO.NOMBRE as name','CALIFICACION')
                    ->where('VALIDADO','=',0)
                    ->take(200)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }

    public function getCreditosPorValidarByNumC($num_control){
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->join('CAT_USUARIO','FK_ALUMNO','=','PK_USUARIO')
                    ->select('PK_ALUMNO_CREDITO', 'LINEAMIENTOS.NOMBRE', 'CAT_USUARIO.NUMERO_CONTROL','CAT_USUARIO.PRIMER_APELLIDO','CAT_USUARIO.SEGUNDO_APELLIDO','CAT_USUARIO.NOMBRE as name','CALIFICACION')
                    ->where('CAT_USUARIO.NUMERO_CONTROL','=',$num_control)
                    ->where('VALIDADO','=',0)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }
    public function getCreditosPorValidarByLin($lineamiento){
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->join('CAT_USUARIO','FK_ALUMNO','=','PK_USUARIO')
                    ->select('PK_ALUMNO_CREDITO', 'LINEAMIENTOS.NOMBRE', 'CAT_USUARIO.NUMERO_CONTROL','CAT_USUARIO.PRIMER_APELLIDO','CAT_USUARIO.SEGUNDO_APELLIDO','CAT_USUARIO.NOMBRE as name','CALIFICACION')
                    ->where('LINEAMIENTOS.PK_LINEAMIENTO','=',$lineamiento)
                    ->where('VALIDADO','=',0)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }

    /**........................................................................... */

    public function getCreditosValidados(){
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->join('CAT_USUARIO','FK_ALUMNO','=','PK_USUARIO')
                    ->select('PK_ALUMNO_CREDITO', 'LINEAMIENTOS.NOMBRE', 'CAT_USUARIO.NUMERO_CONTROL','CAT_USUARIO.PRIMER_APELLIDO','CAT_USUARIO.SEGUNDO_APELLIDO','CAT_USUARIO.NOMBRE as name ','CALIFICACION')
                    ->where('VALIDADO','=',1)
                    ->orderBy('PK_ALUMNO_CREDITO','desc')
                    ->take(200)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }

    public function getCreditosValidadosByNumC($num_control){
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->join('CAT_USUARIO','FK_ALUMNO','=','PK_USUARIO')
                    ->select('PK_ALUMNO_CREDITO', 'LINEAMIENTOS.NOMBRE', 'CAT_USUARIO.NUMERO_CONTROL','CAT_USUARIO.PRIMER_APELLIDO','CAT_USUARIO.SEGUNDO_APELLIDO','CAT_USUARIO.NOMBRE as name','CALIFICACION')
                    ->where('CAT_USUARIO.NUMERO_CONTROL','=',$num_control)
                    ->where('VALIDADO','=',1)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }

    public function getCreditosValidadosByLin($lineamiento){
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->join('CAT_USUARIO','FK_ALUMNO','=','PK_USUARIO')
                    ->select('PK_ALUMNO_CREDITO', 'LINEAMIENTOS.NOMBRE', 'CAT_USUARIO.NUMERO_CONTROL','CAT_USUARIO.PRIMER_APELLIDO','CAT_USUARIO.SEGUNDO_APELLIDO','CAT_USUARIO.NOMBRE as name','CALIFICACION')
                    ->where('LINEAMIENTOS.PK_LINEAMIENTO','=',$lineamiento)
                    ->where('VALIDADO','=',1)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }

    /**------------------------------------------------------------------------ */
    public function getCreditosByCarrera($carrera){
        $creditos = alumnoCredito::join('LINEAMIENTOS','FK_LINEAMIENTO','=','PK_LINEAMIENTO')
                    ->join('CAT_USUARIO','FK_ALUMNO','=','PK_USUARIO')
                    ->select('PK_ALUMNO_CREDITO', 'LINEAMIENTOS.NOMBRE', 'CAT_USUARIO.NUMERO_CONTROL','CAT_USUARIO.PRIMER_APELLIDO','CAT_USUARIO.SEGUNDO_APELLIDO','CAT_USUARIO.NOMBRE as name','CALIFICACION')
                    ->where('CAT_USUARIO.FK_CARRERA','=',$carrera)
                    ->where('CONSTANCIA_GENERADA', '=', 0)
                    ->get();
        $response = Response::json($creditos);
        return $response;
    }
    //obtener el id carrera del usuario 
    public function getClaveCarrera($idUsuario){
        $clave_carrera = DB::table('CAT_USUARIO')
                         ->select('FK_CARRERA')
                         ->where('PK_USUARIO','=',$idUsuario)
                         ->get();
        $response = Response::json($clave_carrera);
        return $response;                         
    }
    
    
    public function update($pk_alumnoCredito)//validar credito
    {
        $alumnoCredito = alumnoCredito::find($pk_alumnoCredito);
        $alumnoCredito->VALIDADO = 1;
        $alumnoCredito->save();
    }

    public function validarCreditos($pk_alumnoCredito){
        $alumnoCredito = alumnoCredito::find($pk_alumnoCredito);
        $alumnoCredito->VALIDADO = 1;
        $alumnoCredito->save();
    }

    public function destroy($id)
    {
        $alumnoCredito = alumnoCredito::find($id);
        $alumnoCredito->delete();
    }
}
