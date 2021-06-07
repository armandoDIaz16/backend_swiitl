<?php

namespace App\Http\Controllers\capacitacion_docente;


use App\Helpers\Abreviaturas;
use App\Helpers\Constantes;
use App\Helpers\PermisosUsuario;
use App\Helpers\UsuariosHelper;
use App\Usuario_Rol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use App\PeriodoCADO;
use App\CursoCADO;
use App\ParticipanteCADO;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
// variables globales
protected $value_docente  = '';

    public  function busca_curso_por_pk( $pk_curso ){


        if( isset($pk_curso) ){
            //    DB::enableQueryLog();
            $curso = DB::table('CAT_CURSO_CADO')
                //                ->select('PK_USUARIO','NOMBRE','PRIMER_APELLIDO','SEGUNDO_APELLIDO')
                //                ->join('CAT_PARTICIPANTE_CADO','CAT_PARTICIPANTE_CADO.FK_USUARIO','=','CAT_USUARIO.PK_USUARIO')
                ->where('BORRADO',0)
                ->where('PK_CAT_CURSO_CADO',$pk_curso)
                ->get();
            //      return  $query = DB::getQueryLog();
            $curso = $this->prepararArrayCurso($curso);

            return response()->json(
                $curso,Response::HTTP_OK);
        }

    }

    public function  eliminar_curso(Request $request){
        $mytime = Carbon::now();
//        $mytime->toDateTimeString();
        // array de respuesta
        $data = array();

        $PK_CURSO_CADO = $request->pk_periodo_curso;
        $PK_PARTICIPANTE_ELIMINA = $request->participante;
        $FECHA_MODIFICACION = $mytime->toDateTimeString();

        $curso = CursoCADO::find($PK_CURSO_CADO);
        $curso->BORRADO  = 1;
        $curso->FK_PARTICIPANTE_MODIFICACION  = $PK_PARTICIPANTE_ELIMINA;
        $curso->FECHA_MODIFICACION  = $FECHA_MODIFICACION;

        if($curso->save()) {
            array_push($data, [
                'estado'=>'exito',
                'mensaje'=>'Se elimino  el curso exitosamente!'
            ]);
                return response()->json(
                    $data,
                    Response::HTTP_OK // 200
                );
        } else {
            array_push($data, [
                'estado'=>'error',
                'mensaje'=>'No se pudo eliminar el curso, intentelo más tarde'
            ]);

                return response()->json(
                    $data,
                    Response::HTTP_OK// 200
                );
        }


    }

    public function busca_curso_misma_hora ( $fecha_inicio = '' , $hora_inicio = '' ){
/*
        //    DB::enableQueryLog();
        return response()->json(
            DB::table('VIEW_CURSOS_FORMAT')
                ->where('FECHA_INICIO',$fecha_inicio)
                ->where('HORA_INICIO',$hora_inicio)
                ->where('BORRADO',0)
                ->get()
            ,
//      return  $query = DB::getQueryLog();
            Response::HTTP_OK);*/
    }

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
                $cursosCD = DB::table('VIEW_CURSOS_POR_PERIODO_INSTRUCTOR')
                    ->where('FK_PERIODO_CADO',$pkperiodo)
//                    ->where('TIPO_CURSO',1)
                    ->where('FK_PARTICIPANTE_CADO',$pk_participante)
                    ->orderBy('TIPO_CURSO','ASC')
                    ->get();

                // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                $cursosCD = $this->prepararArrayCursos($cursosCD);

                /*//actualizacion profesional
                $cursosAP = DB::table('VIEW_CURSOS_POR_PERIODO_INSTRUCTOR')
                    ->where('FK_PERIODO_CADO',$pkperiodo)
                    ->where('TIPO_CURSO',2)
                    ->where('FK_PARTICIPANTE_CADO',$pk_participante)
                    ->get();

                // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                $cursosAP = $this->prepararArrayCursos($cursosAP);*/


                // METEMOS A CADA PERIODO SUS CURSOS
                $itemArray = array();
                array_push($itemArray, [
                    'PK_PERIODO_CADO'=>$pkperiodo,
                    'NOMBRE_PERIODO'=>$nombreperiodo,
                    'FECHA_INICIO'=>$fechainicionperiodo,
                    'FECHA_FIN'=>$fechafinperiodo,
                    'CURSOSCD'=>$cursosCD,
//                    'CURSOSAP'=>$cursosAP,
                ]);
                array_push($resultadoCursosArray,$itemArray);
            }//FIN FOR
            return response()->json(
                $resultadoCursosArray,
                Response::HTTP_OK // 200
            );

        }else{
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
                    $cursosCD = DB::table('VIEW_CURSOS_POR_PERIODO')
                        ->where('FK_PERIODO_CADO',$pkperiodo)
                        ->orderBy('TIPO_CURSO','ASC')
//                        ->where('TIPO_CURSO',1)
                        ->get();

                    // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                    $cursosCD = $this->prepararArrayCursos($cursosCD);

                    /*//actualizacion profesional
                    $cursosAP = DB::table('VIEW_CURSOS_POR_PERIODO')
                        ->where('FK_PERIODO_CADO',$pkperiodo)
//                        ->where('TIPO_CURSO',2)
                        ->get();

                    // este metodo tomara el cursos y lo descomponera en otro pero incluyendo sus instructores
                    $cursosAP = $this->prepararArrayCursos($cursosAP);*/


        // METEMOS A CADA PERIODO SUS CURSOS
                    $itemArray = array();
                    array_push($itemArray, [
                        'PK_PERIODO_CADO'=>$pkperiodo,
                        'NOMBRE_PERIODO'=>$nombreperiodo,
                        'FECHA_INICIO'=>$fechainicionperiodo,
                        'FECHA_FIN'=>$fechafinperiodo,
                        'CURSOSCD'=>$cursosCD,
//                        'CURSOSAP'=>$cursosAP,
                    ]);
                    array_push($resultadoCursosArray,$itemArray);
                }//FIN FOR
                 return response()->json(
                     $resultadoCursosArray,
                     Response::HTTP_OK // 200
                 );

             }else{
                 return response()->json(
                     $resultadoCursosArray,
                     Response::HTTP_OK // 200
                 );
             }

    }// fin consulta coordinador

    //esta funcion se utiliza para compactar en un array los instructores de un solo curso
    public function prepararArrayCurso($arrayCursos){
        //variables
        $resultadoCursosArray = array();

        if (isset($arrayCursos[0]) ){
            foreach ($arrayCursos as $arrayCurso){
                // tomaremos cada clave del curso
                $pkcurso = $arrayCurso->PK_CAT_CURSO_CADO;
                $nombrecurso = $arrayCurso->NOMBRE_CURSO;
                $cupomcurso = $arrayCurso->CUPO_MAXIMO;
                $cupoacurso = $arrayCurso->CUPO_ACTUAL;
                $fkpcurso = $arrayCurso->FK_PERIODO_CADO;
                $tccurso = $arrayCurso->TIPO_CURSO;
                $fkareacurso = $arrayCurso->FK_AREA_ACADEMICA;
                $estadocurso = $arrayCurso->ESTADO;
                $ruta_imagen = $arrayCurso->RUTA_IMAGEN_CURSO;
                $fk_ficha_tecnica = $arrayCurso->FK_FICHA_TECNICA_CADO;
                $ficurso = $arrayCurso->FECHA_INICIO;
                $ffcurso = $arrayCurso->FECHA_FIN;
                $hicurso = $arrayCurso->HORA_INICIO;
                $hfcurso = $arrayCurso->HORA_FIN;
                $thorascurso = $arrayCurso->TOTAL_HORAS;
                $edificiocurso = $arrayCurso->FK_EDIFICIO;
                $espaciocurso = $arrayCurso->NOMBRE_ESPACIO;

                //instructor
                $instructores = DB::table('VIEW_INSTRUCTORES_CURSO')
                    ->where('FK_CAT_CURSO_CADO',$pkcurso)
//                    ->where('TIPO_CURSO',2)
                    ->get();

                // anexamos el objeto ficha para que la cargue automaticamente
                // y no tener que armar un array, se usa el metodo "" de ORM
                //y asi con solo usar un find traera todas las relaciones de la ficha
                $objeto_ficha = CursoCADO::find($pkcurso)->ficha_tecnica;
                $objeto_periodo = CursoCADO::find($pkcurso)->periodo;
                $objeto_edificio = CursoCADO::find($pkcurso)->edificio;
                $objeto_area_academica = CursoCADO::find($pkcurso)->area_academica;


                // METEMOS A CADA PERIODO SUS CURSOS
                $itemArray = array();
                array_push($itemArray, [
                    'PK_CAT_CURSO_CADO'=>$pkcurso,
                    'NOMBRE_CURSO'=>$nombrecurso,
                    'CUPO_MAXIMO'=>$cupomcurso,
                    'CUPO_ACTUAL'=>$cupoacurso,
                    'FK_PERIODO_CADO'=>$fkpcurso,
                    'TIPO_CURSO'=>$tccurso,
                    'FK_AREA_ACADEMICA'=>$fkareacurso,
                    'ESTADO_CURSO'=>$estadocurso,
                    'RUTA_IMAGEN_CURSO'=>$ruta_imagen,
                    'FK_FICHA_TECNICA_CADO'=>$fk_ficha_tecnica,
                    'FECHA_INICIO'=>$ficurso,
                    'FECHA_FIN'=>$ffcurso,
                    'HORA_INICIO'=>$hicurso,
                    'HORA_FIN'=>$hfcurso,
                    'TOTAL_HORAS'=>$thorascurso,
                    'FK_EDIFICIO'=>$edificiocurso,
                    'NOMBRE_ESPACIO'=>$espaciocurso,
                    'INSTRUCTORES'=>$instructores,
                    'OBJ_FICHA_TECNICA'=>$objeto_ficha,
                    'OBJ_PERIODO'=>$objeto_periodo,
                    'OBJ_EDIFICIO'=>$objeto_edificio,
                    'OBJ_AREA_ACADEMICA'=>$objeto_area_academica
                ]);
                array_push($resultadoCursosArray,$itemArray);
            }//FIN FOR
            return $resultadoCursosArray;

        }else{
            return $arrayCursos;
        }



    }

    //esta funcion se utiliza para compactar en un array los instructores de cada curso
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
                $estadocurso = $arrayCurso->ESTADO;
                $img_curso = $arrayCurso->RUTA_IMAGEN_CURSO;
                $nombre_estado = $arrayCurso->NOMBRE_ESTADO;



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
                    'ESTADO_CURSO'=>$estadocurso,
                    'RUTA_IMAGEN_CURSO'=>$img_curso,
                    'INSTRUCTORES'=>$instructores,
                    'NOMBRE_ESTADO'=>$nombre_estado,


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

        /*$periodos = PeriodoCADO::where('BORRADO',0)
            ->get();
        return response()->json(
            DB::table('CAT_PERIODO_CADO')->where('BORRADO',0)->get(),
            Response::HTTP_OK // 200
        );*/
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

    public function consulta_institutos()
    {
        return response()->json(
            DB::table('CAT_INSTITUCION')
                ->select('PK_INSTITUCION','ABREVIATURA','NOMBRE')
                ->where('BORRADO',0)->get(),
            Response::HTTP_OK // 200
        );
    }

    public function registro_curso(Request $request) {

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

                        /*//     creamos las relaciones necesarias
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
                                    ['FK_TIPO_PARTICIPANTE' =>$valor[0]->PK_TIPO_PARTICIPANTE_CADO,
                                        'FK_USUARIO' => $instructor]);
                                // Le asignamos el rol de participante
                                if (!UsuariosHelper::rol_usuario($instructor, Abreviaturas::CADO_ROL_PARTICIPANTE, TRUE)) {
                                    error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                                    error_log('PK_USUARIO: ' . $instructor);
                                    error_log('ROL: ' . Abreviaturas::CADO_ROL_PARTICIPANTE);
                                }
                            }
                                //Asignamos el instructor a la tabla para impartir el curso
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
                        );*/
                        array_push($data, ['pk_curso' => $pkCurso]);

                    }else{
                        // no se pudo insertar el curso
                        array_push($data, [
                            'estado'=>'error',
                            'mensaje'=>'no se pudo insertar el curso'
                        ] );
                    }
                } else {
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'El usuario no tiene registro de participante'
                    ] );
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

    public function modifica_curso(Request $request) {
        //ESPACIO PRUEBA
        // FIN ESPACIO PRUEBA
        // variables
        $data = array();
        $mytime = Carbon::now();
//        $mytime->toDateTimeString();
        $pk_curso = $request->pk_curso;

        if (isset($request->no_control_usuario_registro)) {
            // BUSCAMOS POR NOCONTROL EL USUARIO QUE REALIZA LA MODIFICACIÓN
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

                    $pk_participante_modifica = $result2[0]->PK_PARTICIPANTE_CADO;
                    //procedemos a realizar el insert del curso
                    //proceso de modificación
                    $curso = CursoCADO::find($pk_curso);

                    if(isset($curso) and ( !empty($curso) ) ){
//                        $flight->name = 'New Flight Name';
                        $curso->NOMBRE_CURSO = $request->nombre_curso;
                        $curso->TIPO_CURSO = $request->tipo_curso;
                        $curso->CUPO_MAXIMO = $request->cupo_maximo;
                        $curso->TOTAL_HORAS = $request->total_horas;
                        $curso->FK_AREA_ACADEMICA = ($request->pk_area_academica == 0) ? NULL : $request->pk_area_academica;
                        $curso->FECHA_INICIO = $request->fecha_inicio;
                        $curso->FECHA_FIN = $request->fecha_fin;
                        $curso->HORA_INICIO = $request->hora_inicio;
                        $curso->HORA_FIN = $request->hora_fin;
                        $curso->FK_EDIFICIO = $request->edificio;
                        $curso->NOMBRE_ESPACIO = $request->espacio;
                        $curso->ESTADO = $request->estado_curso;
                        $curso->FK_PERIODO_CADO = $request->pk_periodo;
                        $curso->FK_PARTICIPANTE_MODIFICACION = $pk_participante_modifica;
                        $curso->FECHA_MODIFICACION = $mytime->toDateTimeString();

                        if ( $curso->save() ) {
                            // si pudo crear el curso
                            //     creamos las relaciones necesarias
                            // insertamos el registro de los instructores en CATTR_PARTICIPANTE_IMPARTE_CURSO
                            //obtenemos los instructores propuestos
                            /*$instructoresArray = $request->array_instructores;
                            $pkParticipanteInstructor = 0;
                            // si el array viene con datos eliminamos los registros y los creamos con los nuevos datos
                            if(isset($instructoresArray)  ){
                                //borramos todos los instructores para solo activar los que si queden como instructores
                                if( count($instructoresArray)>0 ) {
                                    $affected = DB::table('CATTR_PARTICIPANTE_IMPARTE_CURSO')
                                        ->where('FK_CAT_CURSO_CADO','=', $pk_curso)
                                        ->update(['BORRADO' => 1]);
                                    // recorremos todos los intructores del array
                                    foreach ($instructoresArray as $instructor) {
                                        // BUSCAMOS SI EL USUARIO TIENE REGISTRO EN PARTICIPANTE, SI NO SE LO CREAMOS
                                        $participante = ParticipanteCADO::where('FK_USUARIO', $instructor)
                                            ->get();
                                        if (isset($participante[0])) {
                                            // ya tiene usuario participante
                                            $pkParticipanteInstructor = $participante[0]->PK_PARTICIPANTE_CADO;
                                        } else {
                                            // no tiene usuario participante
                                            //se lo creamos todo validar si es externo o interno y reasignar roles por BD
                                            $pkParticipanteInstructor = DB::table('CAT_PARTICIPANTE_CADO')->insertGetId(
                                                ['FK_TIPO_PARTICIPANTE' => $valor[0]->PK_TIPO_PARTICIPANTE_CADO,
                                                    'FK_USUARIO' => $instructor]);
                                            // Le asignamos el rol de participante
                                            if (!UsuariosHelper::rol_usuario($instructor, Abreviaturas::CADO_ROL_PARTICIPANTE, TRUE)) {
                                                error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                                                error_log('PK_USUARIO: ' . $instructor);
                                                error_log('ROL: ' . Abreviaturas::CADO_ROL_PARTICIPANTE);
                                            }
                                        }

                                        if ($pkParticipanteInstructor > 0) {
                                            DB::table('CATTR_PARTICIPANTE_IMPARTE_CURSO')
                                                ->updateOrInsert(
                                                    ['FK_PARTICIPANTE_CADO' => $pkParticipanteInstructor,
                                                        'FK_CAT_CURSO_CADO' => $pk_curso],
                                                    ['FK_PARTICIPANTE_CADO' =>$pkParticipanteInstructor,
                                                        'BORRADO' =>0]
                                                );

                                        } else {
                                            array_push($data, [
                                                'estado' => 'error',
                                                'mensaje' => 'No se pudo actualizar el instructor del curso'
                                            ]);
                                        }

                                    }
                                }
                            }*/
                            array_push($data, [
                                'estado' => 'exito',
                                'mensaje' => 'Se registro  el curso exitosamente!'
                            ]);

                        }else {
                            array_push($data, [
                                'estado' => 'error',
                                'mensaje' => 'No se pudo actualizar el curso'
                            ]);
                        }
                    }
                } else {
                    array_push($data, [
                        'estado' => 'error',
                        'mensaje' => 'El usuario no tiene registro de participante'
                    ]);
//            //no tiene registro de participante por lo tanto se lo creamos
                    // ESTE SERIA EL CASO DE ALGUN DOCENTE QUE ENTRO A CREAR SU CURSO POR PRIMERA VEZ

//                $participante->FK_USUARIO    = $pk_usuario;
//                $participante->FK_TIPO_PARTICIPANTE    = 1; // TIPO DOCENTE

                }
            } else {
                // AQUI ENTRO PORQUE NO ENCONTRO UN USUARIO CON EL NUMERO DE CONTROL DADO, O EL VALOR NO VENIA EN LA REQUEST
                // AQUI PUEDE SER EL CASO DE LOS INSTRUCTORES EXTERNOS
                array_push($data, [
                    'estado' => 'error',
                    'mensaje' => 'El usuario no cuenta con número de control, solicitelo al Departamento de Sistemas'
                ]);
            }// fin else
        } // fin if

        return response()->json($data, 200);
    }// fin metodo

    public function asigna_instructores_curso(Request $request) {
        //     creamos las relaciones necesarias
        $data = array();
        $pkCurso = $request->pk_curso;
        $pk_participante_registro = $request->pk_participante;

        $valor = DB::table('CAT_TIPO_PARTICIPANTE_CADO')
            ->select('PK_TIPO_PARTICIPANTE_CADO')
            ->where('NOMBRE_TIPO','Instructor')->get();
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
                    ['FK_TIPO_PARTICIPANTE' =>$valor[0]->PK_TIPO_PARTICIPANTE_CADO,
                        'FK_USUARIO' => $instructor]);
                // Le asignamos el rol de participante
                $usuario = UsuariosHelper::get_usuario_pk($instructor);
                $tipo_usuario = $usuario->TIPO_USUARIO;

                if($tipo_usuario == 2){
                    if (!UsuariosHelper::rol_usuario($instructor, Abreviaturas::CADO_ROL_INSTRUCTOR, TRUE)) {
                        error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                        error_log('PK_USUARIO: ' . $instructor);
                        error_log('ROL: ' . Abreviaturas::CADO_ROL_INSTRUCTOR);
                    }
                }elseif ($tipo_usuario == 4){
                    if (!UsuariosHelper::rol_usuario($instructor, Abreviaturas::CADO_ROL_INSTRUCTOR_EXT, TRUE)) {
                        error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                        error_log('PK_USUARIO: ' . $instructor);
                        error_log('ROL: ' . Abreviaturas::CADO_ROL_INSTRUCTOR_EXT);
                    }
                }

            }
            //Asignamos el instructor a la tabla para impartir el curso
            if($pkParticipanteInstructor>0){
                DB::table('CATTR_PARTICIPANTE_IMPARTE_CURSO')->insert(
                    ['FK_PARTICIPANTE_CADO' =>$pkParticipanteInstructor,
                        'FK_CAT_CURSO_CADO' => $pkCurso]
                );

                array_push($data, [
                    'estado'=>'exito',
                    'mensaje'=>'Se registro  el curso exitosamente!'
                ]);

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

        return response()->json($data, 200);
    }

    public function modifica_instructores_curso(Request $request) {
        //     creamos las relaciones necesarias
        $data = array();
        $pk_curso = $request->pk_curso;

        $valor = DB::table('CAT_TIPO_PARTICIPANTE_CADO')
            ->select('PK_TIPO_PARTICIPANTE_CADO')
            ->where('NOMBRE_TIPO','Instructor')->get();

        $instructoresArray = $request->array_instructores;
        $pkParticipanteInstructor = 0;
        // si el array viene con datos eliminamos los registros y los creamos con los nuevos datos
        if(isset($instructoresArray)  ){
            //borramos todos los instructores para solo activar los que si queden como instructores
            if( count($instructoresArray)>0 ) {
                $affected = DB::table('CATTR_PARTICIPANTE_IMPARTE_CURSO')
                    ->where('FK_CAT_CURSO_CADO','=', $pk_curso)
                    ->update(['BORRADO' => 1]);
                // recorremos todos los intructores del array
                foreach ($instructoresArray as $instructor) {
                    // BUSCAMOS SI EL USUARIO TIENE REGISTRO EN PARTICIPANTE, SI NO SE LO CREAMOS
                    $participante = ParticipanteCADO::where('FK_USUARIO', $instructor)
                        ->get();
                    if (isset($participante[0])) {
                        // ya tiene usuario participante
                        $pkParticipanteInstructor = $participante[0]->PK_PARTICIPANTE_CADO;
                        $this->asigna_roles_instructor($instructor);

                    } else {
                        // no tiene usuario participante
                        $pkParticipanteInstructor = DB::table('CAT_PARTICIPANTE_CADO')->insertGetId(
                            ['FK_TIPO_PARTICIPANTE' => $valor[0]->PK_TIPO_PARTICIPANTE_CADO,
                                'FK_USUARIO' => $instructor]);
                        // Le asignamos el rol de participante
                        $this->asigna_roles_instructor($instructor);

                        /*$usuario = UsuariosHelper::get_usuario_pk($instructor);
                        $tipo_usuario = $usuario->TIPO_USUARIO;

                        if($tipo_usuario == 2){
                            if (!UsuariosHelper::rol_usuario($instructor, Abreviaturas::CADO_ROL_INSTRUCTOR, TRUE)) {
                                error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                                error_log('PK_USUARIO: ' . $instructor);
                                error_log('ROL: ' . Abreviaturas::CADO_ROL_INSTRUCTOR);
                            }
                        }elseif ($tipo_usuario == 4){
                            if (!UsuariosHelper::rol_usuario($instructor, Abreviaturas::CADO_ROL_INSTRUCTOR_EXT, TRUE)) {
                                error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                                error_log('PK_USUARIO: ' . $instructor);
                                error_log('ROL: ' . Abreviaturas::CADO_ROL_INSTRUCTOR_EXT);
                            }
                        }*/
                    }

                    if ($pkParticipanteInstructor > 0) {
                        DB::table('CATTR_PARTICIPANTE_IMPARTE_CURSO')
                            ->updateOrInsert(
                                ['FK_PARTICIPANTE_CADO' => $pkParticipanteInstructor,
                                    'FK_CAT_CURSO_CADO' => $pk_curso],
                                ['FK_PARTICIPANTE_CADO' =>$pkParticipanteInstructor,
                                    'BORRADO' =>0]
                            );

                        array_push($data, [
                            'estado' => 'exito',
                            'mensaje' => 'Si se pudo actualizar el instructor del curso'
                        ]);

                    } else {
                        array_push($data, [
                            'estado' => 'error',
                            'mensaje' => 'No se pudo actualizar el instructor del curso'
                        ]);
                    }

                }
            }
        }

        return response()->json($data, 200);
    }

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
            ->whereIn('TIPO_USUARIO',[2, 4])
            ->where('BORRADO',0)
            ->limit(10)
            ->get(),
//        $query = DB::getQueryLog();
            Response::HTTP_OK);
    }

    public function carga_estados_curso()
    {
        // echo PeriodoCADO::all();
        // return DB::table('CAT_PERIODO_CADO')->where('BORRADO',0)->get();

        return response()->json(
            DB::table('CAT_ESTADOS_CURSO')->where('BORRADO',0)->get(),
            Response::HTTP_OK // 200
        );
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

    public function actualiza_estatus_curso($pk_curso,$estatus)
    {
        // array de respuesta
        $data = array();
        $mensaje = '';
        switch ($estatus){
            case 1:$mensaje = 'Se asignó el curso, exitosamente!';break;
            case 2:$mensaje = 'Se autorizó la ficha técnica, exitosamente!';break;
            case 3:$mensaje = 'Se rechazó la ficha técnica, exitosamente!';break;
            case 4:$mensaje = 'Se evaluó el curso, exitosamente!';break;
            case 5:$mensaje = 'Se envió la ficha técnica para su revisión, exitosamente!';break;
//            default: $mensaje = 'Se actualizo el estatus del curso, exitosamente!';
        }


        // datos
        $curso =  CursoCADO::find($pk_curso);
        $curso->ESTADO = $estatus;
        if($curso->save()){
            array_push($data, [
                'estado'=>'exito',
                'mensaje'=>$mensaje
            ]);
        }else{
            array_push($data, [
                'estado'=>'error',
                'mensaje'=>'No se pudo enviar la información, intentelo más tarde'
            ]);
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }

    public function consulta_participante($idUsuario)
    {
        // BUSCAMOS POR NOCONTROL EL USUARIO QUE REALIZA EL REGISTRO
        $result = DB::table('CAT_USUARIO')
            ->select('PK_USUARIO')
            ->where('PK_USUARIO', $idUsuario)
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

    public function consulta_roles($idUsuario, $abreviatura_sistema)
    {
        $result = PermisosUsuario::consulta_roles_usuario($idUsuario,$abreviatura_sistema);

        if ($result->isNotEmpty()) {
            return response()->json($result,Response::HTTP_OK); // 200
        }else{
            return response()->json(false,Response::HTTP_OK);// 200
        }
    }

    public function asigna_roles_instructor($idUsuario)  {
        // Asigna los roles al instructor conn su pk_usuario
        $usuario = UsuariosHelper::get_usuario_pk($idUsuario);
        $tipo_usuario = $usuario->TIPO_USUARIO;

        if($tipo_usuario == 2){
            if (!UsuariosHelper::rol_usuario($idUsuario, Abreviaturas::CADO_ROL_INSTRUCTOR, TRUE)) {
                error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                error_log('PK_USUARIO: ' . $idUsuario);
                error_log('ROL: ' . Abreviaturas::CADO_ROL_INSTRUCTOR);
            }
        }elseif ($tipo_usuario == 4){
            if (!UsuariosHelper::rol_usuario($idUsuario, Abreviaturas::CADO_ROL_INSTRUCTOR_EXT, TRUE)) {
                error_log('***** ERROR AL ASIGNAR ROL A USUARIO *****');
                error_log('PK_USUARIO: ' . $idUsuario);
                error_log('ROL: ' . Abreviaturas::CADO_ROL_INSTRUCTOR_EXT);
            }
        }
    }

}
