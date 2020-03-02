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

    public function busca_instructor($pk_participante = 0 ){

    //    DB::enableQueryLog();
        return response()->json(
            DB::table('CAT_USUARIO')
                ->select('PK_USUARIO','NOMBRE','PRIMER_APELLIDO','SEGUNDO_APELLIDO')
                ->join('CAT_PARTICIPANTE_CADO','CAT_PARTICIPANTE_CADO.FK_USUARIO','=','CAT_USUARIO.PK_USUARIO')
                ->where('CAT_USUARIO.BORRADO',0)
                ->where('PK_PARTICIPANTE_CADO',$pk_participante)
                ->get()//;
            ,
//      return  $query = DB::getQueryLog();
           Response::HTTP_OK);
    }


    public function consulta_cursos_instructor($pk_participante)
    {
        //variables
        $resultadoCursosArray = array();
        // PREPARAMOS LA CABECERA CON LOS PERIODOS
        $periodos = DB::table('VIEW_PERIODOS_INSTRUCTOR')
            ->where('FK_PARTICIPANTE_CADO',$pk_participante)
//            ->where('TIPO_CURSO',1)
                ->groupBy('PK_PERIODO_CADO','NOMBRE_PERIODO','FECHA_INICIO','FECHA_FIN','FK_PARTICIPANTE_CADO')
            ->get();

        // comenzamos a preparar el array de periodos con cursos
        if (isset($periodos[0]) ){
            foreach ($periodos as $periodo){
                // tomaremos cada clave del periodo
                $pkperiodo = $periodo->PK_PERIODO_CADO;
                $nombreperiodo = $periodo->NOMBRE_PERIODO;
                $fechainicionperiodo = $periodo->FECHA_INICIO;
                $fechafinperiodo = $periodo->FECHA_FIN;
                //formación docente
                $cursosFD = DB::table('VIEW_CURSOS_POR_PERIODO_INSTRUCTOR')
                    ->where('FK_PERIODO_CADO',$pkperiodo)
                    ->where('TIPO_CURSO',1)
                    ->where('FK_PARTICIPANTE_CADO',$pk_participante)
                    ->get();

                // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                $cursosFD = $this->prepararArrayCursos($cursosFD);

                //actualizacion profesional
                $cursosAP = DB::table('VIEW_CURSOS_POR_PERIODO_INSTRUCTOR')
                    ->where('FK_PERIODO_CADO',$pkperiodo)
                    ->where('TIPO_CURSO',2)
                    ->where('FK_PARTICIPANTE_CADO',$pk_participante)
                    ->get();

                // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                $cursosAP = $this->prepararArrayCursos($cursosAP);


                // METEMOS A CADA PERIODO SUS CURSOS
                $itemArray = array();
                array_push($itemArray, [
                    'PK_PERIODO_CADO'=>$pkperiodo,
                    'NOMBRE_PERIODO'=>$nombreperiodo,
                    'FECHA_INICIO'=>$fechainicionperiodo,
                    'FECHA_FIN'=>$fechafinperiodo,
                    'CURSOSFD'=>$cursosFD,
                    'CURSOSAP'=>$cursosAP,

                ]);
                array_push($resultadoCursosArray,$itemArray);
            }//FIN FOR
            return response()->json(
                $resultadoCursosArray,
                Response::HTTP_OK // 200
            );

        }

    }// fin consulta instructpr



    public function consulta_cursos_coordinador()
    {
        //variables
        $resultadoCursosArray = array();
            // PREPARAMOS LA CABECERA CON LOS PERIODOS
               $periodos = PeriodoCADO::where('BORRADO',0)
                                ->orderBy('FECHA_FIN', 'desc')
                                ->get();
                    // comenzamos a preparar el array de periodos con cursos
             if (isset($periodos[0]) ){
                foreach ($periodos as $periodo){
                    // tomaremos cada clave del periodo
                    $pkperiodo = $periodo->PK_PERIODO_CADO;
                    $nombreperiodo = $periodo->NOMBRE_PERIODO;
                    $fechainicionperiodo = $periodo->FECHA_INICIO;
                    $fechafinperiodo = $periodo->FECHA_FIN;
                        //formación docente
                    $cursosFD = DB::table('VIEW_CURSOS_POR_PERIODO')
                        ->where('FK_PERIODO_CADO',$pkperiodo)
                        ->where('TIPO_CURSO',1)
                        ->get();

                    // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                    $cursosFD = $this->prepararArrayCursos($cursosFD);

                    //actualizacion profesional
                    $cursosAP = DB::table('VIEW_CURSOS_POR_PERIODO')
                        ->where('FK_PERIODO_CADO',$pkperiodo)
                        ->where('TIPO_CURSO',2)
                        ->get();

                    // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                    $cursosAP = $this->prepararArrayCursos($cursosAP);


        // METEMOS A CADA PERIODO SUS CURSOS
                    $itemArray = array();
                    array_push($itemArray, [
                        'PK_PERIODO_CADO'=>$pkperiodo,
                        'NOMBRE_PERIODO'=>$nombreperiodo,
                        'FECHA_INICIO'=>$fechainicionperiodo,
                        'FECHA_FIN'=>$fechafinperiodo,
                        'CURSOSFD'=>$cursosFD,
                        'CURSOSAP'=>$cursosAP,

                    ]);
                    array_push($resultadoCursosArray,$itemArray);
                }//FIN FOR
                 return response()->json(
                     $resultadoCursosArray,
                     Response::HTTP_OK // 200
                 );

             }

    }// fin consulta coordinador

    public function prepararArrayCursos($arrayCursos){
        //variables
        $resultadoCursosArray = array();

        if (isset($arrayCursos[0]) ){
            foreach ($arrayCursos as $arrayCurso){
                // tomaremos cada clave del curso
                $pkcurso = $arrayCurso->PK_CAT_CURSO_CADO;
                $nombrecurso = $arrayCurso->NOMBRE_CURSO;
                $areacurso = $arrayCurso->NOMBRE_AREA;
                $ficurso = $arrayCurso->FECHA_INICIO;
                $ffcurso = $arrayCurso->FECHA_FIN;
                $hicurso = $arrayCurso->HORA_INICIO;
                $hfcurso = $arrayCurso->HORA_FIN;
                $tccurso = $arrayCurso->TIPO_CURSO;
                $fkpcurso = $arrayCurso->FK_PERIODO_CADO;

                //instructor
                $instructores = DB::table('VIEW_INSTRUCTORES_CURSO')
                    ->where('FK_CAT_CURSO_CADO',$pkcurso)
//                    ->where('TIPO_CURSO',2)
                    ->get();


                // METEMOS A CADA PERIODO SUS CURSOS
                $itemArray = array();
                array_push($itemArray, [
                    'PK_CAT_CURSO_CADO'=>$pkcurso,
                    'NOMBRE_CURSO'=>$nombrecurso,
                    'NOMBRE_AREA'=>$areacurso,
                    'FECHA_INICIO'=>$ficurso,
                    'FECHA_FIN'=>$ffcurso,
                    'HORA_INICIO'=>$hicurso,
                    'HORA_FIN'=>$hfcurso,
                    'TIPO_CURSO'=>$tccurso,
                    'FK_PERIODO_CADO'=>$fkpcurso,
                    'INSTRUCTORES'=>$instructores,

                ]);
                array_push($resultadoCursosArray,$itemArray);
            }//FIN FOR
            return $resultadoCursosArray;

        }else{
            return $arrayCursos;
        }



    }
    public function consulta_cursos_participante($pk_participante,$tipo_participante)
    {

        $periodos = PeriodoCADO::where('BORRADO',0)
            ->get();
        return response()->json(
            DB::table('CAT_PERIODO_CADO')->where('BORRADO',0)->get(),
            Response::HTTP_OK // 200
        );
    }

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

        //ESPACIO PRUEBA
        // FIN ESPACIO PRUEBA
        // variables
        $data = array();

        if (isset($request->no_control_usuario_registro)) {
            // BUSCAMOS POR NOCONTROL EL USUARIO QUE REALIZA EL REGISTRO
            $no_control = $request->no_control_usuario_registro;
            $result = DB::table('CAT_USUARIO')
                ->select('PK_USUARIO')
                ->where('NUMERO_CONTROL', $no_control)
                ->get();

            if (isset($result[0]->PK_USUARIO)) {
                //si encontro el registro del usuario
                $pk_usuario = $result[0]->PK_USUARIO;
                // validamos si el usuario ya es un participante, si no se lo creamos
                $result2 = DB::table('CAT_PARTICIPANTE_CADO')
                    ->select('PK_PARTICIPANTE_CADO')
                    ->where('FK_USUARIO', $pk_usuario)
                    ->get();

                if (isset($result2[0]->PK_PARTICIPANTE_CADO)) {
                    //si tiene ya su registro como participante lo tomamos
                    // NORMALMENTE AQUI ENTRO POR QUE ES EL COORDINADOR QUIEN DA DE ALTA O ALGUN INSTRUCTOR QUE YA
                    // HA PARTICIPADO ANTES O UN DOCENTE QUE PARTICIPO EN UN CURSO ANTERIORMENTE

                    $pk_participante_registro = $result2[0]->PK_PARTICIPANTE_CADO;
                    //procedemos a realizar el insert del curso
                   $pkCurso= DB::table('CAT_CURSO_CADO')->insertGetId(
                        [
                            'NOMBRE_CURSO' => $request->nombre_curso,
                            'TIPO_CURSO' => $request->tipo_curso,
                            'CUPO_MAXIMO' =>  $request->cupo_maximo,
                            'TOTAL_HORAS' => $request->total_horas,
                            'FK_AREA_ACADEMICA' =>  ($request->pk_area_academica == 0) ? NULL : $request->pk_area_academica,
                            'FECHA_INICIO' => $request->fecha_inicio,
                            'FECHA_FIN' => $request->fecha_fin,
                            'HORA_INICIO' =>$request->hora_inicio,
                            'HORA_FIN' =>  $request->hora_fin,
                            'FK_EDIFICIO' =>  $request->edificio,
                            'NOMBRE_ESPACIO' => $request->espacio,
                            'ESTADO' => $request->estado_curso,
                            'FK_PERIODO_CADO' => $request->pk_periodo,
                            'FK_PARTICIPANTE_REGISTRO' => $pk_participante_registro
                        ]
                    );

                    if(isset($pkCurso) && $pkCurso >0 ) {
                        // si pudo crear el curso
                        //     creamos las relaciones necesarias
                        // insertamos el registro de los instructores en CATTR_PARTICIPANTE_IMPARTE_CURSO
                        //obtenemos los instructores propuestos
                        $instructoresArray = $request->array_instructores;
                        $pkParticipanteInstructor =0;
                        foreach ($instructoresArray as $instructor){
                            // BUSCAMOS SI EL USUARIO TIENE REGISTRO EN PARTICIPANTE, SI NO SE LO CREAMOS
                            $participante  = ParticipanteCADO::where('FK_USUARIO', $instructor)
                                                               ->get();
                            if(isset($participante[0])){
                                // ya tiene usuario participante
                                $pkParticipanteInstructor =$participante[0]->PK_PARTICIPANTE_CADO;
                            }else{
                                // no tiene usuario participante
                                //se lo creamos
                                $pkParticipanteInstructor= DB::table('CAT_PARTICIPANTE_CADO')->insertGetId(
                                    [
                                        'FK_TIPO_PARTICIPANTE' =>2,
                                        'FK_USUARIO' => $instructor
                                    ]
                                );
                            }

                            if($pkParticipanteInstructor>0){
                                DB::table('CATTR_PARTICIPANTE_IMPARTE_CURSO')->insert(
                                    ['FK_PARTICIPANTE_CADO' =>$pkParticipanteInstructor,
                                        'FK_CAT_CURSO_CADO' => $pkCurso]
                                );
                            }else{
                                array_push($data, [
                                    'estado'=>'error',
                                    'mensaje'=>'No se pudo crear el participante para el instructor(es)'
                                ]);
                            }

                        }
                        // insertamos el registro de quien propone el curso puede ser el coordinador o el mismo
                        // instructor en CATTR_PARTICIPANTE_PROPONE_CURSO
                        DB::table('CATTR_PARTICIPANTE_PROPONE_CURSO')->insert(
                            ['FK_PARTICIPANTE_CADO' =>$pk_participante_registro, 'FK_CAT_CURSO_CADO' => $pkCurso]
                        );
                        array_push($data, [
                            'estado'=>'exito',
                            'mensaje'=>'Se registro  el curso exitosamente!'
                        ]);

                    }else{
                        // no se pudo insertar el curso
                        array_push($data, [
                            'estado'=>'error',
                            'mensaje'=>'no se pudo insertar el curso'
                        ] );
                    }
                } else {
//            //no tiene registro de participante por lo tanto se lo creamos
                    // ESTE SERIA EL CASO DE ALGUN DOCENTE QUE ENTRO A CREAR SU CURSO POR PRIMERA VEZ

//                $participante->FK_USUARIO    = $pk_usuario;
//                $participante->FK_TIPO_PARTICIPANTE    = 1; // TIPO DOCENTE

                }
            } else {
                // AQUI ENTRO PORQUE NO ENCONTRO UN USUARIO CON EL NUMERO DE CONTROL DADO, O EL VALOR NO VENIA EN LA REQUEST
                // AQUI PUEDE SER EL CASO DE LOS INSTRUCTORES EXTERNOS
                array_push($data,[
                    'estado'=>'error',
                    'mensaje'=>'El usuario no cuenta con número de control, solicitelo al Departamento de Sistemas'
                ]);
            }// fin else
        } // fin if


        return response()->json($data, 200);

    }// fin function registro


    public function filtro_docente($value2 = ''){
        // se utiliza una variable global para poder pasar el ´parametro a la funcion del where
        $this->value_docente = $value2;
//        DB::enableQueryLog();
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

    public function consulta_participante($noControl)
    {
        // BUSCAMOS POR NOCONTROL EL USUARIO QUE REALIZA EL REGISTRO
        $result = DB::table('CAT_USUARIO')
            ->select('PK_USUARIO')
            ->where('NUMERO_CONTROL', $noControl)
            ->get();

        if (isset($result[0]->PK_USUARIO)) {
            //si encontro el registro del usuario
            $pk_usuario = $result[0]->PK_USUARIO;
            // validamos si el usuario ya es un participante
            $result2 = DB::table('CAT_PARTICIPANTE_CADO')
                ->select('PK_PARTICIPANTE_CADO','FK_TIPO_PARTICIPANTE')
                ->where('FK_USUARIO', $pk_usuario)
                ->get();

            if(isset($result2[0]->PK_PARTICIPANTE_CADO)){
                return response()->json(
                    $result2[0],
                    Response::HTTP_OK // 200
                );
            }else{
                return response()->json(
                    false,
                    Response::HTTP_NOT_FOUND// 404
                );
            }

        }else{
            return response()->json(
                false,
                Response::HTTP_NOT_FOUND// 404
            );
        }
    }


}
