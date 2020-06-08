<?php

namespace App\Http\Controllers\capacitacion_docente;

use App\CurriculumCADO;
use App\ExperienciaDocenteCVCADO;
use App\ExperienciaLaboralCVCADO;
use App\FormacionCVCADO;
use App\ParticipacionInstructorCVCADO;
use App\ProductoAcademicoCVCADO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;

class CurriculumController extends Controller
{
/*CARGA DE CATALAGOS*/
    /**
     * @descripcion : CARGA EL CATALAGO DE TIPOS DE FORMACION DE LA TABLA CAT_TIPO_FORMACION_ACADEMICA_CADO
     * @version : 1.0.0
     * @return JsonResponse CON CAT_TIPO_FORMACION_ACADEMICA_CADO
     * @author : Armando Díaz
     * @fecha  : 7/5/2020
     */
    public function carga_tipos_formacion()
    {
        return response()->json(
            DB::table('CAT_TIPO_FORMACION_ACADEMICA_CADO')->where('BORRADO',0)->get(),
            Response::HTTP_OK // 200
        );
    }

/*GUARDA SECCIONES*/
    /**
     * @requerimiento : RF - 25	Modificación de información de CV
     * @descripcion : Guarda la seccion de formación académica
     * @version : 1.0.0
     * @param Request $request Contiene los valores de TIPO, FORMACIÓN, INSTITUTO,  FECHA TITULACION
     * CEDULA PROFESIONAL OPCIONAL Y FK CV QUE VIENEN DENTRO DE UN ARRAY CON N ELEMENTOS
     * @return JsonResponse
     * @author : Armando Díaz
     * @fecha  : 09/05/2020
     */
    public function guardar_formacion_academica(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos lOS REGISTROS DE formacion  de  CV
        $pk_cv = $request->pk_cv;
        $pk_usuario = $request->fk_usuario_modifica;
        $formaciones_array = $request->array_formacion_academica;
        // primero borraremos todos los registros de la tabla
        $formaciones_actuales = CurriculumCADO::find($request->pk_cv)->formaciones;
        if (isset($formaciones_actuales) ) {
            foreach ($formaciones_actuales as $formacion_actual) {
                $obj_formacion_actual = FormacionCVCADO::find($formacion_actual->PK_FORMACION_ACADEMICA_CV);
                $obj_formacion_actual->BORRADO = 1;
                $obj_formacion_actual->FECHA_MODIFICACION = $FECHA_MODIFICACION;
                $obj_formacion_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($formaciones_array) ){
            foreach ($formaciones_array as $formacion) {
                //creamos el objeto nuevo
                $obj_formacion = new FormacionCVCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($formacion['PK_FORMACION_ACADEMICA_CV'] != -1)
                    $obj_formacion = FormacionCVCADO::find($formacion['PK_FORMACION_ACADEMICA_CV']);
                //seteamos los valores
                $obj_formacion->FK_CV = $pk_cv;
                $obj_formacion->TIPO_FORMACION = $formacion['TIPO_FORMACION'];
                if( $formacion['TIPO_FORMACION'] ==5)
                $obj_formacion->OTRO_TIPO = $formacion['OTRO_TIPO'];

                $obj_formacion->NOMBRE_CARRERA = $formacion['NOMBRE_CARRERA'];
                $obj_formacion->INSTITUCION = $formacion['INSTITUCION'];
                $obj_formacion->FECHA_TITULACION = $formacion['FECHA_TITULACION'];
                if( $formacion['CEDULA_PROFESIONAL'] >0)
                $obj_formacion->CEDULA_PROFESIONAL = $formacion['CEDULA_PROFESIONAL'];

                $obj_formacion->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_formacion->BORRADO = 0;

                if ($obj_formacion->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Formación académica exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Formación académica, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }
    /**
     * @requerimiento : RF - 25	Modificación de información de CV
     * @descripcion : Guarda la seccion de EXPERIENCIA LABORAL
     * @version : 1.0.0
     * @param Request $request Contiene los valores de NOMBRE_MATERIA,FK_INSTITUCION,NOMBRE_OTRA_INSTITUCION
     * FECHA_INICIO_PERIODO,FECHA_FIN_PERIODO Y FK CV QUE VIENEN DENTRO DE UN ARRAY CON N ELEMENTOS
     * @return JsonResponse
     * @author : Armando Díaz
     * @fecha  : 14/05/2020
     */
    public function guardar_seccion_experiencia_docente(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos lOS REGISTROS DE formacion  de  CV
        $pk_cv = $request->pk_cv;
        $pk_usuario = $request->fk_usuario_modifica;
        $experiencia_docente_array = $request->array_experiencia_docente;
        // primero borraremos todos los registros de la tabla
        $exp_docentes_actuales = CurriculumCADO::find($request->pk_cv)->experiencia_docente;
        if (isset($exp_docentes_actuales) ) {
            foreach ($exp_docentes_actuales as $exp_docente_actual) {
                $obj_exp_docente_actual = ExperienciaDocenteCVCADO::find($exp_docente_actual->PK_EXPERIENCIA_DOCENTE_CV);
                $obj_exp_docente_actual->BORRADO = 1;
                $obj_exp_docente_actual->FECHA_MODIFICACION = $FECHA_MODIFICACION;
                $obj_exp_docente_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($experiencia_docente_array) ){
            foreach ($experiencia_docente_array as $exp_docente) {
                //creamos el objeto nuevo
                $obj_exp_docente = new ExperienciaDocenteCVCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($exp_docente['PK_EXPERIENCIA_DOCENTE_CV'] != -1)
                    $obj_exp_docente = ExperienciaDocenteCVCADO::find($exp_docente['PK_EXPERIENCIA_DOCENTE_CV']);
                //seteamos los valores

                $obj_exp_docente->FK_CV = $pk_cv;
                $obj_exp_docente->NOMBRE_MATERIA = $exp_docente['NOMBRE_MATERIA'];
                $obj_exp_docente->FK_INSTITUCION = $exp_docente['FK_INSTITUCION'];
                if( $exp_docente['FK_INSTITUCION'] == 0)
                    $obj_exp_docente->NOMBRE_OTRA_INSTITUCION = $exp_docente['NOMBRE_OTRA_INSTITUCION'];

                $obj_exp_docente->FECHA_INICIO_PERIODO = $exp_docente['FECHA_INICIO_PERIODO'];
                $obj_exp_docente->FECHA_FIN_PERIODO = $exp_docente['FECHA_FIN_PERIODO'];
                $obj_exp_docente->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_exp_docente->BORRADO = 0;

                if ($obj_exp_docente->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Experiencia docente exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Experiencia docente, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }

    /**
     * @requerimiento : RF - 25	Modificación de información de CV
     * @descripcion : Guarda la seccion de experiencia laboral
     * @version : 1.0.0
     * @param Request $request Contiene los valores de NOMBRE PUESTO, EMPRESA, PERMANENCIA1, PERMANENCIA 2
     * ACTIVIDADES A CARGO Y FK CV QUE VIENEN DENTRO DE UN ARRAY CON N ELEMENTOS
     * @return JsonResponse
     * @author : Armando Díaz
     * @fecha  : 12/05/2020
     */
    public function guardar_experiencia_laboral(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos lOS REGISTROS DE experiencia laboral  de  CV
        $pk_cv = $request->pk_cv;
        $pk_usuario = $request->fk_usuario_modifica;
        $experiencia_laboral_array = $request->array_experiencia_laboral;
        // primero borraremos todos los registros de la tabla
        $experiencias_actuales = CurriculumCADO::find($request->pk_cv)->experiencias_laborales;
        if (isset($experiencias_actuales) ) {
            foreach ($experiencias_actuales as $experiencia_actual) {
                $obj_experiencia_actual = ExperienciaLaboralCVCADO::find($experiencia_actual->PK_EXPERIENCIA_LABORAL_CV);
                $obj_experiencia_actual->BORRADO = 1;
                $obj_experiencia_actual->FECHA_MODIFICACION = $FECHA_MODIFICACION;
                $obj_experiencia_actual->FK_USUARIO_MODIFICACION = $pk_usuario;
                $obj_experiencia_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($experiencia_laboral_array) ){
            foreach ($experiencia_laboral_array as $experiencia) {
                //creamos el objeto nuevo
                $obj_experiencia = new ExperienciaLaboralCVCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($experiencia['PK_EXPERIENCIA_LABORAL_CV'] != -1)
                    $obj_experiencia = ExperienciaLaboralCVCADO::find($experiencia['PK_EXPERIENCIA_LABORAL_CV']);
                //seteamos los valores
                $obj_experiencia->FK_CV = $pk_cv;
                $obj_experiencia->NOMBRE_PUESTO = $experiencia['NOMBRE_PUESTO'];
                $obj_experiencia->NOMBRE_EMPRESA = $experiencia['NOMBRE_EMPRESA'];
                $obj_experiencia->FECHA_INICIO_PERMANENCIA = $experiencia['FECHA_INICIO_PERMANENCIA'];
                $obj_experiencia->FECHA_FIN_PERMANENCIA = $experiencia['FECHA_FIN_PERMANENCIA'];
                $obj_experiencia->ACTIVIDADES_A_CARGO = $experiencia['ACTIVIDADES_A_CARGO'];
                $obj_experiencia->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_experiencia->BORRADO = 0;

                if ($obj_experiencia->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Experiencia laboral exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Experiencia laboral, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }
    /**
     * @requerimiento : RF - 25	Modificación de información de CV
     * @descripcion : Guarda la seccion de productos académicos
     * @version : 1.0.0
     * @param Request $request Contiene los valores de NOMBRE PRODUCTO, DESCRIPCIÓN, FECHA
     * Y FK CV QUE VIENEN DENTRO DE UN ARRAY CON N ELEMENTOS
     * @return JsonResponse
     * @author : Armando Díaz
     * @fecha  : 12/05/2020
     */
    public function guardar_productos_academicos(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos lOS REGISTROS DE experiencia laboral  de  CV
        $pk_cv = $request->pk_cv;
        $pk_usuario = $request->fk_usuario_modifica;
        $productos_academicos_array = $request->array_prductos_academicos;
        // primero borraremos todos los registros de la tabla
        $productos_academicos_actuales = CurriculumCADO::find($request->pk_cv)->productos_academicos;
        if (isset($productos_academicos_actuales) ) {
            foreach ($productos_academicos_actuales as $producto_academico_actual) {
                $obj_producto_actual = ProductoAcademicoCVCADO::find($producto_academico_actual->PK_PRODUCTOS_ACADEMICOS_CV);
                $obj_producto_actual->BORRADO = 1;
                $obj_producto_actual->FECHA_MODIFICACION = $FECHA_MODIFICACION;
                $obj_producto_actual->FK_USUARIO_MODIFICACION = $pk_usuario;
                $obj_producto_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($productos_academicos_array) ){
            foreach ($productos_academicos_array as $producto) {
                //creamos el objeto nuevo
                $obj_producto = new ProductoAcademicoCVCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($producto['PK_EXPERIENCIA_LABORAL_CV'] != -1)
                    $obj_producto = ProductoAcademicoCVCADO::find($producto['PK_PRODUCTOS_ACADEMICOS_CV']);
                //seteamos los valores
                $obj_producto->FK_CV = $pk_cv;
                $obj_producto->NOMBRE_PRODUCTO = $producto['NOMBRE_PRODUCTO'];
                $obj_producto->DESCRIPCION = $producto['DESCRIPCION'];
                $obj_producto->FECHA_PRODUCTO = $producto['FECHA_PRODUCTO'];
                $obj_producto->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_producto->BORRADO = 0;

                if ($obj_producto->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Productos académicos exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Productos académicos, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }
    /**
     * @requerimiento : RF - 25	Modificación de información de CV
     * @descripcion : Guarda la seccion de participacion como instructor, recibe un array de objetos
     * ya que puede ser de 1 a 3 participaciones
     * @version : 1.0.0
     * @param Request $request Contiene los valores de TITULO_CURSO, NOMBRE_INSTITUCION, HRS_DURACION_CURSO y  FECHA_IMPARTICION
     * Y FK CV QUE VIENEN DENTRO DE UN ARRAY CON N ELEMENTOS
     * @return JsonResponse
     * @author : Armando Díaz
     * @fecha  : 14/05/2020
     */
    public function guardar_seccion_participacion_instructor(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos lOS REGISTROS DE participacion como instructor  de  CV
        $pk_cv = $request->pk_cv;
        $pk_usuario = $request->fk_usuario_modifica;
        $participacion_instructor_array = $request->array_participacion_instructor;
        // primero borraremos todos los registros de la tabla
        $participaciones_actuales = CurriculumCADO::find($request->pk_cv)->participacion_instructor;
        if (isset($participaciones_actuales) ) {
            foreach ($participaciones_actuales as $participacion_actual) {
                $obj_participacion_actual = ParticipacionInstructorCVCADO::find($participacion_actual->PK_PARTICIPACION_INSTRUCTOR_CV);
                $obj_participacion_actual->BORRADO = 1;
                $obj_participacion_actual->FECHA_MODIFICACION = $FECHA_MODIFICACION;
                $obj_participacion_actual->FK_USUARIO_MODIFICACION = $pk_usuario;
                $obj_participacion_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($participacion_instructor_array) ){
            foreach ($participacion_instructor_array as $participacion) {
                //creamos el objeto nuevo
                $obj_participacion = new ParticipacionInstructorCVCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($participacion['PK_PARTICIPACION_INSTRUCTOR_CV'] != -1)
                    $obj_participacion = ParticipacionInstructorCVCADO::find($participacion['PK_PARTICIPACION_INSTRUCTOR_CV']);
                //seteamos los valores
                $obj_participacion->FK_CV = $pk_cv;
                $obj_participacion->TITULO_CURSO = $participacion['TITULO_CURSO'];
                $obj_participacion->NOMBRE_INSTITUCION = $participacion['NOMBRE_INSTITUCION'];
                $obj_participacion->HRS_DURACION_CURSO = $participacion['HRS_DURACION_CURSO'];
                $obj_participacion->FECHA_IMPARTICION = $participacion['FECHA_IMPARTICION'];
                $obj_participacion->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_participacion->BORRADO = 0;

                if ($obj_participacion->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Participación como instructor exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Participación como instructor, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }

    /**
     * @requerimiento : RF - 25	Modificación de información de CV
     * @descripcion : Guarda la seccion de datos personales
     * @version : 1.0.0
     * @param Request $request Contiene los valores de RFC, pk del CV y Biografia
     * @return JsonResponse
     * @author : Armando Díaz
     * @fecha  : 7/5/2020
     */
    public function guardar_datos_personales(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recupera cv de BD
        $cv = CurriculumCADO::find($request->pk_cv);
        // actualiza datos
        $cv->RFC   = $request->rfc;
        $cv->BIOGRAFIA   = $request->biografia;
        $cv->FK_USUARIO_REGISTRO = $request->fk_usuario_registra;
        $cv->FK_USUARIO_MODIFICACION = $request->fk_usuario_registra;
        $cv->FECHA_MODIFICACION  = $FECHA_MODIFICACION;
        //realiza update
        if($cv){
            if ($cv->save()) {
                array_push($data, [
                    'estado'=>'exito',
                    'mensaje'=>'Se guardo  la sección, datos personales exitosamente!'
                ]);
            }else{
                array_push($data, [
                    'estado'=>'error',
                    'mensaje'=>'No se pudo guardar la sección datos personales, intentelo más tarde'
                ]);
            }
            return response()->json(
                $data,
                Response::HTTP_OK // 200
            );
        }else {
            array_push($data, ['estado'=>'error',
                                     'mensaje'=>'No se encontro el CV, intentelo más tarde!']);
            return response()->json($data,Response::HTTP_OK // 200
            );
        }
    }


    /*METODOS GENERALES */
    /**
     * @requerimiento : RF - 23	Registro de CV
     * @version : 1.0.0
     * @description: Crear el registro de CV en la base de datos, con los datos vacios
     * solo para permitir ser modificados en un futuro por el instructor ya que no se sabe
     * cual seccion decidirá completar primero
     * @return \Illuminate\Http\Response
     * @return CurriculumCADO
     * @author : Armando Díaz
     * @fecha  : 7/5/2020
     */
    public function crear_actualizar_cv(Request $request){
        $cv = new CurriculumCADO;
// creamos la ficha tecnica vacia, la cual iremos actualizando por partes
        $cv->FK_PARTICIPANTE_CADO = $request->pk_participante;
        $cv->RFC   = '';
        $cv->BIOGRAFIA   = '';
        //realizamos el insert
        $cv->save();
        if($cv->PK_CV_PARTICIPANTE > 0 ) {
            return response()->json(
                ['pk_cv' =>  $cv->PK_CV_PARTICIPANTE],
                Response::HTTP_OK // 200
            );
        } else {
            return response()->json(
                ['error' => 'No se pudo guardar'],
                Response::HTTP_OK // 200
            );
        }

    }


}
