<?php

namespace App\Http\Controllers\capacitacion_docente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use App\PeriodoCADO;
use App\CursoCADO;
use App\ParticipanteCADO;
use Illuminate\Support\Facades\DB;

class ConvocatoriaController extends Controller
{
    public function carga_convocatoria_cursos()
    {
        //variables
        $resultadoCursosArray = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_ACTUAL = $mytime->toDateTimeString();
        // recupera ficha de BD
        // comenzamos a preparar el array de  cursos
                // tomaremos cada clave del periodo
                //formación docente
                $cursosCD = DB::table('VIEW_CONVOCATORIA_CADO')
//                    ->where('FK_PERIODO_CADO',$pkperiodo)
//                    ->where('TIPO_CURSO',1)
                    ->where('FECHA_FIN_PERIODO','>=',$FECHA_ACTUAL)
//                    ->where('FK_PARTICIPANTE_CADO',$pk_participante)
                        ->orderBy('TIPO_CURSO','ASC')
                    ->get();
                // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                    $obj_CursoController = new CursoController;
                $cursosCD = $obj_CursoController->prepararArrayCurso($cursosCD);
                //actualizacion profesional
               /* $cursosAP = DB::table('VIEW_CONVOCATORIA_CADO')
                    ->where('TIPO_CURSO',2)
                    ->where('TIPO_CURSO',1)
                    ->where('FECHA_FIN_PERIODO','>=',$FECHA_ACTUAL)
                    ->get();

                // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                $cursosAP = $this->prepararArrayCursos($cursosAP);*/
                    return response()->json(
                        $cursosCD,
                        Response::HTTP_OK // 200
                    );

                // METEMOS A CADA PERIODO SUS CURSOS
               /* $itemArray = array();
                array_push($itemArray, [
//                    'PK_PERIODO_CADO'=>$pkperiodo,
//                    'NOMBRE_PERIODO'=>$nombreperiodo,
//                    'FECHA_INICIO'=>$fechainicionperiodo,
//                    'FECHA_FIN'=>$fechafinperiodo,
//                    'CURSOSFD'=>$cursosFD,
                    '$cursosCD'=>$cursosCD,

                ]);
                array_push($resultadoCursosArray,$itemArray);

            return response()->json(
                $resultadoCursosArray,
                Response::HTTP_OK // 200
            );*/


    }// fin carga_convocatoria_cursos

}
