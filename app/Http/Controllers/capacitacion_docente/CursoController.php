<?php

namespace App\Http\Controllers\capacitacion_docente;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\PeriodoCADO;
use App\CursoCADO;
use App\ParticipanteCADO;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
// variables globales
protected $value_docente  = '';


    public function consulta_edificios()
    {
        return response()->json(
            DB::table('CATR_EDIFICIO')
                ->select('PK_EDIFICIO','FK_CAMPUS','PREFIJO','NOMBRE')
                ->where('BORRADO',0)->get(),
            Response::HTTP_OK // 200
        );
    }

    public function registro_curso(Request $request)
    {
        $no_control = $request->no_control_usuario_registro;
        $result = DB::table('CAT_USUARIO')
                    ->select('PK_USUARIO')
                    ->where('NUMERO_CONTROL',$no_control)
                    ->get();

        if (isset($result[0]->PK_USUARIO)) {
            //si encontro el registro del usuario
            $pk_usuario =$result[0]->PK_USUARIO;
            // validamos si el usuario ya es un participante, si no se lo creamos
            $result = DB::table('CAT_PARTICIPANTE_CADO')
                ->select('PK_PARTICIPANTE_CADO')
                ->where('FK_USUARIO',$pk_usuario)
                ->get();

            if (isset($result[0]->PK_PARTICIPANTE_CADO)) {
                //si tiene ya su registro como participante lo tomamos
                $pk_participante = $result[0]->PK_PARTICIPANTE_CADO;
                //procedemos a realizar el insert del curso
                $curso = new CursoCADO;
                $curso->NOMBRE_CURSO         = $request->nombre_curso;
                $curso->TIPO_CURSO           = $request->tipo_curso;
                $curso->CUPO_MAXIMO          = $request->cupo_maximo;
                $curso->TOTAL_HORAS          = $request->total_horas;
                $curso->FK_AREA_ACADEMICA        = $request->pk_area_academica;
                $curso->FECHA_INICIO               = $request->fecha_inicio;
                $curso->FECHA_FIN                = $request->fecha_fin;
                $curso->HORA_INICIO            = $request->hora_inicio;
                $curso->HORA_FIN               = $request->hora_fin;
                $curso->FK_EDIFICIO           = $request->edificio;
                $curso->NOMBRE_ESPACIO       = $request->espacio;
                $curso->ESTADO               = $request->estado_curso;
                $curso->FK_PERIODO_CADO      = $request->pk_periodo;
                $curso->FK_PARTICIPANTE_REGISTRO      = $pk_participante;

                if($curso->save()) {
                    return response()->json(// si pudo almacenar el curso
                        true,
                        Response::HTTP_OK // 200
                    );
                } else {
                    return response()->json(
                        ['error' => 'No se pudo guardar el curso'], // si pudo almacenar el curso
                        Response::HTTP_NOT_FOUND// 404
                    );
                }

            }else{
//            //no tiene registro de participante por lo tanto se lo creamos
//                $participante = new ParticipanteCADO;
//
//                $participante->FK_USUARIO    = $pk_usuario;
//                $participante->FK_TIPO_PARTICIPANTE    = 1; // TIPO DOCENTE

            }
        }else{
//no encontro el registro
            return response()->json(
                ['error' => 'No se pudo guardar'],
                Response::HTTP_NOT_FOUND// 404
            );
        }
//        $participante = new ParticipanteCADO;
//
//        $curso = new CursoCADO;
//    $curso->NOMBRE_CURSO         = $request->nombre_curso;
//        $curso->TIPO_CURSO           = $request->tipo_curso;
//        $curso->CUPO_MAXIMO          = $request->cupo_maximo;
//        $curso->TOTAL_HORAS          = $request->total_horas;
//        $curso->FK_AREA_ACADEMICA        = $request->pk_area_academica;
//        $curso->FECHA_INICIO               = $request->fecha_inicio;
//        $curso->FECHA_FIN                = $request->fecha_fin;
//        $curso->HORA_INICIO            = $request->hora_inicio;
//        $curso->HORA_FIN      = $request->hora_fin;
//        $curso->FK_EDIFICIO           = $request->edificio;
//        $curso->NOMBRE_ESPACIO       = $request->espacio;
//        $curso->ESTADO               = $request->estado_curso;
//        $curso->FK_PERIODO_CADO      = $request->pk_periodo;
//
////    FK_PARTICIPANTE_REGISTRO     INT NOT NULL, -- FK
//
//        if($curso->save()) {
//            return response()->json(
//                true,
//                Response::HTTP_OK // 200
//            );
//        } else {
//            return response()->json(
//                ['error' => 'No se pudo guardar'],
//                Response::HTTP_NOT_FOUND// 404
//            );
//        }
    }


    public function filtro_docente($value2 = ''){
        // se utiliza una variable global para poder pasar el ´parametro a la funcion del where
        $this->value_docente = $value2;
        DB::enableQueryLog();
        return response()->json(
        DB::table('CAT_USUARIO')
                ->select('PK_USUARIO','NOMBRE','PRIMER_APELLIDO','SEGUNDO_APELLIDO')
                 ->where(function($query) {
                     $query->where('NOMBRE', 'like', '%'. $this->value_docente.'%')
                         ->orWhere('PRIMER_APELLIDO', 'like', '%'. $this->value_docente.'%')
                         ->orWhere('SEGUNDO_APELLIDO', 'like', '%'. $this->value_docente.'%');
                 })
            ->where('TIPO_USUARIO',2)
            ->where('BORRADO',0)
            ->limit(10)
            ->get(),
//        $query = DB::getQueryLog();
            Response::HTTP_OK);
    }

    public function consulta_area_academica()
    {
        // echo PeriodoCADO::all();
        // return DB::table('CAT_PERIODO_CADO')->where('BORRADO',0)->get();

        return response()->json(
            DB::table('CAT_AREA_ACADEMICA')->where('BORRADO',0)->get(),
            Response::HTTP_OK // 200
        );
    }
}
