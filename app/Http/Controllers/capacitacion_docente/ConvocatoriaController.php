<?php

namespace App\Http\Controllers\capacitacion_docente;

use App\InscripcionCursoCADO;
use Illuminate\Http\JsonResponse;
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
                    ->where('FECHA_FIN_PERIODO','>=',$FECHA_ACTUAL)
                        ->orderBy('TIPO_CURSO','ASC')
                    ->get();
                // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                    $obj_CursoController = new CursoController;
                $cursosCD = $obj_CursoController->prepararArrayCurso($cursosCD);

                    return response()->json(
                        $cursosCD,
                        Response::HTTP_OK // 200
                    );


    }// fin

    /**
     * @author : Armando Díaz
     * @since  : 6/7/2020
     * @requerimiento : RF - 32 Registro de participantes a cursos
     * @version : 1.0.0
     * @description: Realiza una consulta de base de datos para validar si el cupo del curso
     * @param $pk_curso Integer Es la clave primaria del curso al cual se desea inscribir el participante
     * @return JsonResponse con valor true si hay cupo o false si esta lleno el curso
     */
    public function  validar_cupo_curso($pk_curso){
        //Buscamos el curso de la base de datos por su pk
        $obj_curso = DB::table('CAT_CURSO_CADO')
            ->where('PK_CAT_CURSO_CADO',$pk_curso)
            ->where('BORRADO',0)
            ->get();
       // obtenemos el cupo actual del curso
        $cupo_actual = $obj_curso[0]->CUPO_ACTUAL;
        $cupo_maximo = $obj_curso[0]->CUPO_MAXIMO;
        // Validamos que el cupo actual sea menor al cupo mámixo para poder inscribir
        if($cupo_actual < $cupo_maximo ) {
            // Si aún hay cupo devolvemos true
            return response()->json(true,Response::HTTP_OK ); // 200
        } else {
            // Si no hay cupo devolvemos false
            return response()->json(false,Response::HTTP_OK ); // 200
        }
    } // fin metodo validar_cupo_curso

    /**
     * @author : Armando Díaz
     * @since  : 6/7/2020
     * @requerimiento : RF - 32 Registro de participantes a cursos
     * @version : 1.0.0
     * @description: Realiza una consulta de base de datos para validar si el participante ya esta inscrito
     * a este curso
     * @param $pk_curso Integer Es la clave primaria del curso al cual se desea inscribir el participante
     * @return JsonResponse con valor true si hay cupo o false si esta lleno el curso
     */
    public function  valida_inscripcion_curso($pk_curso, $pk_participante){
        //Buscamos el curso de la base de datos por su pk
        $obj_curso = DB::table('CATTR_INSCRIPCION_CURSO')
            ->where('FK_CAT_CURSO_CADO',$pk_curso)
            ->where('FK_PARTICIPANTE_CADO',$pk_participante)
            ->where('BORRADO',0)
            ->get();
        //  validamos si encontramos un registro
        if($obj_curso->isNotEmpty() ) {
            // Si no esta vacio es que ya esta inscrito
            return response()->json(true,Response::HTTP_OK ); // 200
        } else {
            // Si esta vacio es que no se ha inscrito
            return response()->json(false,Response::HTTP_OK ); // 200
        }
    } // fin metodo validar_cupo_curso

    /**
     * @author : Armando Díaz
     * @since  : 6/7/2020
     * @requerimiento : RF - 32 Registro de participantes a cursos
     * @version : 1.0.0
     * @description: Realiza una consulta de base de datos para validar si el participante
     * no se ha inscrito a otro curtso en el mismo horario
     * @param $request Request  pk_curso, fecha y hora de inicio del curso
     * @return JsonResponse con valor true si se puede inscribir y false si no puede
     */
    public function  validar_horario_disponible($pk_curso, $pk_participante, $pk_periodo){
        // obtenemos todos los cursos a los que se ha inscrito el participante
        // si no se ha inscrito a ninguno no recuperamos el curso actual y devolvemos un true
        $tiene_cursos = false;
        $misma_fecha = false;
        $misma_hora = false;
        $obj_participante_curso = DB::table('VIEW_INSCRIPCIONES_CURSOS')
            ->where('FK_PARTICIPANTE_CADO',$pk_participante)
            ->where('PK_PERIODO_CADO',$pk_periodo)
            ->get();

        if(  $obj_participante_curso->isNotEmpty() ) {
            $tiene_cursos= true;
        }

        if ($tiene_cursos) {
            //Buscamos el curso al cual se desea inscribir el participante
            $obj_curso = DB::table('CAT_CURSO_CADO')
                ->where('PK_CAT_CURSO_CADO',$pk_curso)
                ->where('BORRADO',0)
                ->get();
            // obtenemos la fecha y hora del curso
            $fechai_curso = $obj_curso[0]->FECHA_INICIO;
            $horai_curso  = $obj_curso[0]->HORA_INICIO;

            // recorremos todos los cursos a los que ya se inscribio el participante
            //para comparar la fecha y la hora de inicio del curso
            foreach ($obj_participante_curso as $curso_participante) {
                // obtenemos la fecha y hora del curso
                $fecha_curso_participante = $curso_participante->FECHA_INICIO;
                $hora_curso_participante  = $curso_participante->HORA_INICIO;
                //comparamos fechas
                $date1 = date_create($fechai_curso);
                $date2 = date_create($fecha_curso_participante);
                $interval_date = date_diff($date1, $date2);
                //comparamos horas
                $time1 = date_create(substr($horai_curso,10));
                $time2 = date_create(substr($hora_curso_participante,10));
                $interval_time = date_diff($time1, $time2);
                if($interval_date->days == 0){
                     if($interval_time->h == 0 ) {
                         $misma_fecha = true;
                         $misma_hora = true;
                     }
                }
            }

            //validamos si se imparten el mismo día sde lo contrario continue
            if($misma_fecha && $misma_hora) {
                // No puede inscribirse a un curso el mismo dia y la hora
                return response()->json(false,Response::HTTP_OK ); // 200
            }else{
                // Si no tiene cursos devolvemos true
                return response()->json(true,Response::HTTP_OK ); // 200
            }

        } else {
            // Si no tiene cursos devolvemos true
            return response()->json(true,Response::HTTP_OK ); // 200
        }
    } // fin metodo validar_cupo_curso


    /**
     * @author : Armando Díaz
     * @since  : 6/7/2020
     * @requerimiento : RF - 32 Registro de participantes a cursos
     * @version : 1.0.0
     * @description: Realiza un INSERT en la tabla de inscripcion_cursos para el participante
     * @param $request Request  pk_curso, pk_participante
     * @return JsonResponse con valor true si se pudo inscribir y false si no puede
     */
    public function inscribir_participante(Request $request) {
        try {
            // Creamos una nueva instancia de la clase InscripcionCursoCADO
            $inscripcion = new InscripcionCursoCADO;
            $inscripcion->FK_PARTICIPANTE_CADO = $request->pk_participante;
            $inscripcion->FK_CAT_CURSO_CADO = $request->pk_curso;
             // Con la función save() de Model  se persiste el objeto en la base de datos
            if($inscripcion->save()) {
                $curso = CursoCADO::find($request->pk_curso);
                $curso->CUPO_ACTUAL =  $curso->CUPO_ACTUAL + 1;
                if($curso->save()) {
                    // Si la operación es exitosa, regresamos un valor true con status 200
                    return response()->json(true,Response::HTTP_OK);// 200
                }else{
                    //De lo contrario regresamos un valor false con un mensaje de error
                    return response()->json(false,Response::HTTP_OK);// 200
                }

            } else {
                //De lo contrario regresamos un valor false con un mensaje de error
                return response()->json(false,Response::HTTP_OK);// 200
            } // fin else

        } catch (Exception $e) {
            error_log($e->getMessage());
            return response()->json(false,Response::HTTP_OK);// 200
        }
    } // fin método inscribir_participante


    /**
     * @author : Armando Díaz
     * @since  : 6/7/2020
     * @requerimiento : RF - 33 Baja de participantes de cursos
     * @version : 1.0.0
     * @description: Realiza un UPDATE de borrado 1 en la tabla de inscripcion_cursos para el participante
     * @param $request Request  pk_curso, pk_participante
     * @return JsonResponse con valor true si se pudo dar de baja y false si no pudo dar de baja
     */
    public function baja_participante(Request $request) {
        try {
            // Con la función update damos de baja la inscripcion del curso
            $affected = DB::table('CATTR_INSCRIPCION_CURSO')
                        ->where('FK_CAT_CURSO_CADO',$request->pk_curso)
                        ->where('FK_PARTICIPANTE_CADO',$request->pk_participante)
                        ->update(['BORRADO' => 1]);

            if($affected>0) {
                $curso = CursoCADO::find($request->pk_curso);
                $curso->CUPO_ACTUAL =  $curso->CUPO_ACTUAL -1;
                if($curso->save()) {
                    // Si la operación es exitosa, regresamos un valor true con status 200
                    return response()->json(true,Response::HTTP_OK);// 200
                }else{
                    //De lo contrario regresamos un valor false con un mensaje de error
                    return response()->json(false,Response::HTTP_OK);// 200
                }

            } else {
                //De lo contrario regresamos un valor false con un mensaje de error
                return response()->json(false,Response::HTTP_OK);// 200
            } // fin else

        } catch (Exception $e) {
            error_log($e->getMessage());
            return response()->json(false,Response::HTTP_OK);// 200
        }
    } // fin método baja_participante


    public function carga_mis_cursos($pk_participante) {
        // recupera ficha de BD
        // comenzamos a preparar el array de  cursos
        $cursos = DB::table('VIEW_MIS_CURSOS_CADO')
            ->where('FK_PARTICIPANTE_CADO',$pk_participante)
            ->orderBy('FECHA_FIN','DESC')
            ->get();
        // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
        $obj_CursoController = new CursoController;
        $cursos = $obj_CursoController->prepararArrayCurso($cursos);

        return response()->json(
            $cursos,
            Response::HTTP_OK // 200
        );


    }// fin



}
