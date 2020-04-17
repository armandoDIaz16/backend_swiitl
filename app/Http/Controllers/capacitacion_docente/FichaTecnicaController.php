<?php

namespace App\Http\Controllers\capacitacion_docente;

use App\ArchivoContenidoTematicoCADO;
use App\CompetenciaCADO;
use App\ContenidoTematicoCADO;
use App\CriterioEvaluacionCADO;
use App\FuenteInformacionCADO;
use App\Helpers\Base64ToFile;
use App\MaterialDidacticoCADO;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Helpers\CursosCADOHelper;
use App\FichaTecnicaCADO;
use App\CursoCADO;

class FichaTecnicaController extends Controller
{
    public function registra_foto_curso(Request $request) {
        $curso = CursoCADO::find($request->PK_CURSO);
        $url = CursosCADOHelper::get_url_carpeta_curso($request->PK_CURSO, $request->PERIODO, 'imagen_curso');
//        $nombre_archivo = $request->NOMBRE_ARCHIVO.date('Y-m-d H:i:s');
        $nombre_archivo =  md5($request->NOMBRE_ARCHIVO).date('Y-m-d-H-i-s');

        $ruta = Base64ToFile::guarda_archivo($url, $nombre_archivo, $request->EXTENSION, $request->CONTENIDO);

        if ($ruta) {
            $curso->RUTA_IMAGEN_CURSO = $ruta;
            if ($curso->save()) {
                return response()->json($ruta, Response::HTTP_OK);
            } else {
                return response()->json(false, Response::HTTP_NOT_FOUND);
            }
        } else {
            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }
    public function registra_archivo_adjunto(Request $request) {
//        $curso = CursoCADO::find($request->PK_CURSO);
        $adjunto_tema = new ArchivoContenidoTematicoCADO;
        $url = CursosCADOHelper::get_url_carpeta_curso($request->PK_CURSO, $request->PERIODO, 'temas/' . $request->FK_CONTENIDO_TEMATICO );
//        $nombre_archivo = $request->NOMBRE_ARCHIVO.date('Y-m-d H:i:s');
        $nombre_archivo =  md5($request->NOMBRE_ARCHIVO).date('Y-m-d-H-i-s');

        $ruta = Base64ToFile::guarda_archivo($url, $nombre_archivo, $request->EXTENSION, $request->CONTENIDO);

        if ($ruta) {
            $adjunto_tema->RUTA_ARCHIVO = $ruta;
            $adjunto_tema->FK_CONTENIDO_TEMATICO = $request->FK_CONTENIDO_TEMATICO;
            $adjunto_tema->NOMBRE_ARCHIVO = $request->NOMBRE_ARCHIVO;
            if ($adjunto_tema->save()) {
                $temas_actuales = FichaTecnicaCADO::find($request->pk_ficha)->contenido_tematico;
                return response()->json($temas_actuales, Response::HTTP_OK);
            } else {
                return response()->json(false, Response::HTTP_NOT_FOUND);
            }
        } else {
            return response()->json(false, Response::HTTP_NOT_FOUND);
        }
    }


    public function crear_actualizar_ficha(Request $request){
        $ficha = new FichaTecnicaCADO;
// creamos la ficha tecnica vacia, la cual iremos actualizando por partes
        $ficha->FK_LUGAR = 1;
        $ficha->INTRODUCCION   = '';
        $ficha->JUSTIFICACION   = '';
        $ficha->OBJETIVO_GENERAL   = '';
        $ficha->TIPO_SERVICIO = -1;

        //realizamos el insert
        $ficha->save();


        if($ficha->PK_CAT_FICHA_TECNICA > 0 ) {
//            recuperamos el curso
            $curso =  CursoCADO::find($request->pk_curso);
            $curso->FK_FICHA_TECNICA_CADO = $ficha->PK_CAT_FICHA_TECNICA;
            //realizamos el update al curso
            $curso->save();

            return response()->json(
                ['pk_ficha' =>  $ficha->PK_CAT_FICHA_TECNICA],
                Response::HTTP_OK // 200
            );
        } else {
            return response()->json(
                ['error' => 'No se pudo guardar'],
                Response::HTTP_OK // 200
            );
        }

    }


    public function guardar_descripcion_servicio(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recupera ficha de BD
        $ficha = FichaTecnicaCADO::find($request->pk_ficha);
        // actualiza datos
        $ficha->INTRODUCCION = $request->introduccion;
        $ficha->JUSTIFICACION = $request->justificacion;
        $ficha->OBJETIVO_GENERAL = $request->objetivo_general;
        $ficha->FK_USUARIO_MODIFICACION = $request->fk_usuario_modifica;
        $ficha->FECHA_MODIFICACION  = $FECHA_MODIFICACION;
        //realiza update
        if($ficha){
            if ($ficha->save()) {
                array_push($data, [
                    'estado'=>'exito',
                    'mensaje'=>'Se guardo  la sección, Descripción del Servicio exitosamente!'
                ]);
                return response()->json(
                    $data,
                    Response::HTTP_OK // 200
                );
            }else{
                array_push($data, [
                    'estado'=>'error',
                    'mensaje'=>'No se pudo guardar la sección Descripción del servicio, intentelo más tarde'
                ]);
                return response()->json(
                    $data,
                    Response::HTTP_OK// 200
                );
            }
        }
    }

    public function guardar_informacion_servicio(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recupera ficha de BD
        $ficha = FichaTecnicaCADO::find($request->pk_ficha);
        // actualiza datos
        $ficha->TIPO_SERVICIO = $request->tipo_servicio;
        // si es otro servicio optiene el parametro de lo contrario no lo actualiza
        if ( $request->tipo_servicio == 7)
            $ficha->OTRO_SERVICIO = $request->otro_servicio;

        $ficha->FK_USUARIO_MODIFICACION = $request->fk_usuario_modifica;
        $ficha->FK_LUGAR = $request->lugar_institucion;
        $ficha->FECHA_MODIFICACION  = $FECHA_MODIFICACION;
        //realiza update
        if($ficha){
            if ($ficha->save()) {
                array_push($data, [
                    'estado'=>'exito',
                    'mensaje'=>'Se guardo  la sección, Información del Servicio exitosamente!'
                ]);
                return response()->json(
                    $data,
                    Response::HTTP_OK // 200
                );
            }else{
                array_push($data, [
                    'estado'=>'error',
                    'mensaje'=>'No se pudo guardar la sección Información del servicio, intentelo más tarde'
                ]);

                return response()->json(
                    $data,
                    Response::HTTP_OK// 200
                );
            }
        }
    }
    public function guardar_elementos_didacticos(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos los elementos didacticos de la ficha
        $pkficha = $request->pk_ficha;
        $pk_usuario = $request->fk_usuario_modifica;
        $elementos_array = $request->array_elementos_didacticos;
        // primero borraremos todos los elementos de la tabla
        $elementos_didacticos_actuales = FichaTecnicaCADO::find($request->pk_ficha)->material_didactico;
        if (isset($elementos_didacticos_actuales) ) {
            foreach ($elementos_didacticos_actuales as $elemento_actual) {
                $obj_elemento_actual = MaterialDidacticoCADO::find($elemento_actual->PK_MATERIAL_DIDACTICO);
                $obj_elemento_actual->BORRADO = 1;
                $obj_elemento_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($elementos_array) ){
            foreach ($elementos_array as $elemento) {
                //creamos el objeto nuevo
                $obj_elemento = new MaterialDidacticoCADO;
                //seteamos los valores
                if ($elemento['PK_MATERIAL_DIDACTICO'] != -1)
                    $obj_elemento = MaterialDidacticoCADO::find($elemento['PK_MATERIAL_DIDACTICO']);

                $obj_elemento->FK_FICHA_TECNICA = $pkficha;
                $obj_elemento->NOMBRE_MATERIAL = $elemento['NOMBRE_MATERIAL'];
                $obj_elemento->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_elemento->BORRADO = 0;

                if ($obj_elemento->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Elementos Didácticos exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Elementos Didácticos, intentelo más tarde'
                    ]);
                }
            }

        }

        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }
    public function guardar_criterios_evaluacion(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos los criterios de evaluacion de la ficha
        $pkficha = $request->pk_ficha;
        $pk_usuario = $request->fk_usuario_modifica;
        $criterios_array = $request->array_criterios_evaluacion;
        // primero borraremos todos los criterios de la tabla
        $criterios_evaluacion_actuales = FichaTecnicaCADO::find($request->pk_ficha)->criterios_evaluacion;
        if (isset($criterios_evaluacion_actuales) ) {
            foreach ($criterios_evaluacion_actuales as $criterio_actual) {
                $obj_criterio_actual = CriterioEvaluacionCADO::find($criterio_actual->PK_CRITERIO_EVALUACION);
                $obj_criterio_actual->BORRADO = 1;
                $obj_criterio_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($criterios_array) ){
            foreach ($criterios_array as $criterio) {
                //creamos el objeto nuevo
                $obj_criterio = new CriterioEvaluacionCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($criterio['PK_CRITERIO_EVALUACION'] != -1)
                    $obj_criterio = CriterioEvaluacionCADO::find($criterio['PK_CRITERIO_EVALUACION']);
                //seteamos los valores
                $obj_criterio->FK_FICHA_TECNICA = $pkficha;
                $obj_criterio->NOMBRE_CRITERIO = $criterio['NOMBRE_CRITERIO'];
                $obj_criterio->VALOR_CRITERIO = $criterio['VALOR_CRITERIO'];
                $obj_criterio->INSTRUMENTO_DE_EVALUACION = $criterio['INSTRUMENTO_DE_EVALUACION'];
                $obj_criterio->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_criterio->BORRADO = 0;

                if ($obj_criterio->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Criterios de evaluación exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Criterios de evaluación, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }
    public function guardar_competencias(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos las competencias  de la ficha
        $pkficha = $request->pk_ficha;
        $pk_usuario = $request->fk_usuario_modifica;
        $competencias_array = $request->array_competencias;
        // primero borraremos todos las competencias de la tabla
        $competencias_actuales = FichaTecnicaCADO::find($request->pk_ficha)->competencias;
        if (isset($competencias_actuales) ) {
            foreach ($competencias_actuales as $competencia_actual) {
                $obj_competencia_actual = CompetenciaCADO::find($competencia_actual->PK_COMPETENCIA_CURSO);
                $obj_competencia_actual->BORRADO = 1;
                $obj_competencia_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($competencias_array) ){
            foreach ($competencias_array as $competencia) {
                //creamos el objeto nuevo
                $obj_competencia = new CompetenciaCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($competencia['PK_COMPETENCIA_CURSO'] != -1)
                    $obj_competencia = CompetenciaCADO::find($competencia['PK_COMPETENCIA_CURSO']);
                //seteamos los valores
                $obj_competencia->FK_FICHA_TECNICA = $pkficha;
                $obj_competencia->TEXTO_COMPETENCIA = $competencia['TEXTO_COMPETENCIA'];
                $obj_competencia->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_competencia->BORRADO = 0;

                if ($obj_competencia->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Competencias a Desarrollar exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Competencias a Desarrollar, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }
    public function guardar_fuentes_informacion(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos las fuente  de la ficha
        $pkficha = $request->pk_ficha;
        $pk_usuario = $request->fk_usuario_modifica;
        $fuentes_array = $request->array_fuentes;
        // primero borraremos todos las fuente de la tabla
        $fuentes_actuales = FichaTecnicaCADO::find($request->pk_ficha)->fuentes_informacion;
        if (isset($fuentes_actuales) ) {
            foreach ($fuentes_actuales as $fuente_actual) {
                $obj_fuente_actual = FuenteInformacionCADO::find($fuente_actual->PK_FUENTE_INFORMACION);
                $obj_fuente_actual->BORRADO = 1;
                $obj_fuente_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($fuentes_array) ){
            foreach ($fuentes_array as $fuente) {
                //creamos el objeto nuevo
                $obj_fuente = new FuenteInformacionCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($fuente['PK_FUENTE_INFORMACION'] != -1)
                    $obj_fuente = FuenteInformacionCADO::find($fuente['PK_FUENTE_INFORMACION']);
                //seteamos los valores
                $obj_fuente->FK_FICHA_TECNICA = $pkficha;
                $obj_fuente->TEXTO_FUENTE = $fuente['TEXTO_FUENTE'];
                $obj_fuente->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_fuente->BORRADO = 0;

                if ($obj_fuente->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Fuentes de información exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Fuentes de información, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }

    public function guardar_contenidos_tematicos(Request $request){
        // array de respuesta
        $data = array();
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        // recuperamos las temas  de la ficha
        $pkficha = $request->pk_ficha;
        $pk_usuario = $request->fk_usuario_modifica;
        $temas_array = $request->array_temas;
        // primero borraremos todos las temas de la tabla
        $temas_actuales = FichaTecnicaCADO::find($request->pk_ficha)->contenido_tematico;
        if (isset($temas_actuales) ) {
            foreach ($temas_actuales as $tema_actual) {
                $obj_tema_actual = ContenidoTematicoCADO::find($tema_actual->PK_CONTENIDO_TEMATICO);
                $obj_tema_actual->BORRADO = 1;
                $obj_tema_actual->save();
            }
        }
        //agregaremos todos de nuevo y si uno ya no esta ya fue borrado
        if (isset($temas_array) ){
            $indice = -1;
            foreach ($temas_array as $tema) {
                $indice ++;
                //creamos el objeto nuevo
                $obj_tema = new ContenidoTematicoCADO;
                // hacemos un if para que si ya existe solo lo actuallize
                if ($tema['PK_CONTENIDO_TEMATICO'] != -1)
                    $obj_tema = ContenidoTematicoCADO::find($tema['PK_CONTENIDO_TEMATICO']);
                //seteamos los valores
                $obj_tema->FK_CAT_FICHA_TECNICA = $pkficha;
                $obj_tema->NOMBRE_TEMA = $tema['NOMBRE_TEMA'];
                $obj_tema->TIEMPO_TEMA = $tema['TIEMPO_TEMA'];
                $obj_tema->ACTIVIDAD_APRENDIZAJE = $tema['ACTIVIDAD_APRENDIZAJE'];
                $obj_tema->INDICE_TEMA = $indice;
                $obj_tema->FK_USUARIO_REGISTRO = $pk_usuario;
                $obj_tema->BORRADO = 0;

                if ($obj_tema->save()) {
                    array_push($data, [
                        'estado'=>'exito',
                        'mensaje'=>'Se guardo  la sección, Contenido temático exitosamente!'
                    ]);
                }else{
                    array_push($data, [
                        'estado'=>'error',
                        'mensaje'=>'No se pudo guardar la sección Contenido temático, intentelo más tarde'
                    ]);
                }
            }
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );
    }
    public function  elimina_archivo_por_pk($pk_adjunto,$pk_ficha){
        // array de respuesta
        $data = array();
        $temas = [];
        //datos
        $mytime = Carbon::now();
        $FECHA_MODIFICACION = $mytime->toDateTimeString();
        $obj_adjunto_tema = ArchivoContenidoTematicoCADO::find($pk_adjunto);
        $obj_adjunto_tema->BORRADO  = 1; // es eliminado
        $obj_adjunto_tema->FECHA_MODIFICACION  = $FECHA_MODIFICACION;
        if($obj_adjunto_tema->save()) {
            $temas = FichaTecnicaCADO::find($pk_ficha)->contenido_tematico;
            array_push($data, [
                'estado'=>'exito',
                'mensaje'=>'Se elimino el material adjunto exitosamente!',
                'temas'=> $temas
            ]);
        } else {
            array_push($data, [
                'estado'=>'error',
                'mensaje'=>'No se pudo eliminar el material adjunto, intentelo más tarde',
                'temas'=> $temas
            ]);
        }
        return response()->json(
            $data,
            Response::HTTP_OK // 200
        );

    }


    /*METODO CREADO PARA PROBAR X RESPUESTA
     * public function pruebarelacionorm()
    {
        return $curso = CursoCADO::find(6);
//            $ficha = new Fic[haTecnicaCADO;
//        return $ficha->();
    }*/

    }
