<?php

namespace App\Http\Controllers;

use App\Comentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentariosController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $comentario = new Comentarios();
        $comentario->FK_REPORTE = $request->Numero;
        $comentario->FK_USUARIO = $request->Usuario;
        $comentario->COMENTARIO = $request->Comentario;
        try{
            $comentario->save();
            return json_encode('Guardado con exito!');}
        catch(\Exception $exception){
            return json_encode('Error al subir archivo');
        }

    }

    public function show($id)
    {
        $comentario = DB::select('select CATR_COMENTARIO_REPORTE.COMENTARIO, CATR_COMENTARIO_REPORTE.FK_USUARIO, CAT_REPORTE_RESIDENCIA.NOMBRE, users.name
                                        FROM CATR_COMENTARIO_REPORTE
                                        join CAT_REPORTE_RESIDENCIA ON CATR_COMENTARIO_REPORTE.FK_REPORTE = CAT_REPORTE_RESIDENCIA.PK_REPORTE
                                        join users ON CATR_COMENTARIO_REPORTE.FK_USUARIO = users.PK_USUARIO
                                        WHERE CAT_REPORTE_RESIDENCIA.PK_REPORTE = :id',['id'=>$id]);
        /*$x = DB::select('SELECT CATR_DOCENTE.NUMERO_EMPLEADO_DOCENTE FROM CATR_DOCENTE WHERE ID_PADRE = :padre',['padre'=>$id]);
        if($x != null){
            $comentario = DB::select('select CATR_COMENTARIO_REPORTE.COMENTARIO, CATR_COMENTARIO_REPORTE.FK_USUARIO, CAT_REPORTE_RESIDENCIA.NOMBRE, users.name
                    from CATR_COMENTARIO_REPORTE
                    join CAT_REPORTE_RESIDENCIA ON CATR_COMENTARIO_REPORTE.FK_REPORTE = CAT_REPORTE_RESIDENCIA.PK_REPORTE
                    join CAT_ANTEPROYECTO_RESIDENCIA ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = CAT_REPORTE_RESIDENCIA.ALUMNO
                    JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
                    join users on users.PK_USUARIO = CATR_PROYECTO.FK_DOCENTE
                    WHERE CATR_PROYECTO.FK_DOCENTE = :id',['id'=>$id]);
        }else {
            $comentario = DB::select('select CATR_COMENTARIO_REPORTE.COMENTARIO, CATR_COMENTARIO_REPORTE.FK_USUARIO, CAT_REPORTE_RESIDENCIA.NOMBRE, users.name
                  FROM CATR_COMENTARIO_REPORTE
                  join CAT_REPORTE_RESIDENCIA ON CATR_COMENTARIO_REPORTE.FK_REPORTE = CAT_REPORTE_RESIDENCIA.PK_REPORTE
                  join users ON CATR_COMENTARIO_REPORTE.FK_USUARIO = users.PK_USUARIO
                  WHERE CAT_REPORTE_RESIDENCIA.ALUMNO = :id', ['id' => $id]);
        }*/
        return $comentario;
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
