<?php

namespace App\Http\Controllers\tutorias;

use App\Carrera;
use App\Estado_Civil;
use App\GrupoTutorias;
use App\GrupoTutoriasDetalle;
use App\Helpers\Constantes;
use App\Helpers\ReportesTutoria;
use App\Helpers\ResponseHTTP;
use App\Helpers\UsuariosHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

/**
 * Class SITPdfController
 * @package App\Http\Controllers\tutorias
 */
class SITPdfController extends Controller
{
    /*public function test_reporte() {
        return ResponseHTTP::response_ok(ReportesTutoria::test_reporte());
    }*/

    /**
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function perfil_grupal(Request $request)
    {
        if ($request->grupo) {
            $grupo = GrupoTutorias::find($request->grupo);
            if ($grupo) {

                $html_final = view('tutorias.perfil_grupal', $this->get_perfil_grupal($grupo));
                /* Fuentes */
                $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
                $fontDirs = $defaultConfig['fontDir'];

                $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
                $fontData = $defaultFontConfig['fontdata'];

                $mpdf = new Mpdf([
                    'fontDir' => array_merge($fontDirs, [
                        __DIR__ . '/custom/font/directory',
                    ]),
                    'fontdata' => $fontData + [
                            'montserrat' => [
                                'R' => 'Montserrat-Medium.ttf',
                                'B' => 'Montserrat-ExtraBold.ttf',
                            ]
                        ],
                    'default_font' => 'montserrat'
                ]);

                $mpdf->WriteHTML($html_final);
                return $mpdf->Output();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function get_perfil_grupal(GrupoTutorias $grupo)
    {
        $data = [];
        $detalle_grupo = GrupoTutoriasDetalle::where('FK_GRUPO', $grupo->PK_GRUPO_TUTORIA)->get();

        $data['tutor'] = $this->get_tutor($grupo->FK_USUARIO);
        $data['grupo'] = $grupo->CLAVE;
        $data['cantidad_alumnos'] = count($detalle_grupo);
        $data['periodo'] = Constantes::get_periodo_texto($grupo->PERIODO);

        $carrera = Carrera::find($grupo->FK_CARRERA);
        $data['carrera'] = (isset($carrera->NOMBRE)) ? $carrera->NOMBRE : 'No definido';

        $filtro = ['grupo' => $grupo->PK_GRUPO_TUTORIA];
        // datos personales de grupo
        $data['personales'] = $this->get_datos_personales($grupo->PERIODO, $filtro);

        // datos condición académica
        $data['academico'] = $this->get_condicion_acedemica_grupo($grupo->PERIODO, $filtro);

        // datos condición socioeconomica
        $data['socioeconomico'] = $this->get_socioeconomico_grupo($grupo->PERIODO, $filtro);

        // datos condicion familiar
        $data['familiar'] = $this->get_familiar_grupo($grupo->PERIODO, $filtro);

        // datos salud fisica
        $data['pasatiempos'] = $this->get_pasatiempos_grupo($grupo->PERIODO, $filtro);

        // datos salud fisica
        $data['salud'] = $this->get_salud_grupo($grupo->PERIODO, $filtro);

        // datos hábitos de estudio
        // $data['habitos_estudio'] = SITHelper::habitos_estudio_grupo($pk_grupo);

        return $data;
    }

    private function get_salud_grupo($periodo, $filtros)
    {
        $salud = ReportesTutoria::reporte_salud($periodo, $filtros);

        if ($salud) {
            $salud = $this->agrupa_preguntas($salud);

            $habilidades = [];
            $respuestas = [];
            $respuestas_pool = [0, 1, 2, 4, 5, 6, 9, 10];
            foreach ($salud as $index => $pregunta) {
                if (in_array($index, $respuestas_pool)) {
                    $respuestas[] = $pregunta;
                }

                if ($index >= 14 && $index <= 26) {
                    $habilidades[] = $pregunta;
                }
            }

            return (object)[
                'estado_salud' => $salud[14],
                'respuestas' => $respuestas,
                'habilidades' => $habilidades,
                'estado_animo' => $salud[28],
            ];
        }

        return (object)[
            'estado_salud' => 'No definido',
            'respuestas' => 'No definido',
            'habilidades' => 'No definido',
            'estado_animo' => 'No definido',
        ];
    }

    private function get_pasatiempos_grupo($periodo, $filtros)
    {
        $pasatiempos = ReportesTutoria::reporte_pasatiempos($periodo, $filtros);

        if ($pasatiempos) {
            return (object)[
                'mas_1' => $pasatiempos[0],
                'mas_2' => $pasatiempos[1],
                'mas_3' => $pasatiempos[2],
                'menos_1' => $pasatiempos[sizeof($pasatiempos) - 3],
                'menos_2' => $pasatiempos[sizeof($pasatiempos) - 2],
                'menos_3' => $pasatiempos[sizeof($pasatiempos) - 1],
            ];
        }

        return (object)[
            'mas_1' => 'No definido',
            'mas_2' => 'No definido',
            'mas_3' => 'No definido',
            'menos_1' => 'No definido',
            'menos_2' => 'No definido',
            'menos_3' => 'No definido',
        ];
    }

    private function get_familiar_grupo($periodo, $filtros)
    {
        $ficha = ReportesTutoria::reporte_ficha_familiar($periodo, $filtros);
        $tipo_familia = ReportesTutoria::reporte_tipo_familia($periodo, $filtros);

        if ($ficha && $tipo_familia) {
            $ficha = $this->agrupa_preguntas($ficha);
            $cohesion =
                $this->agrega_promedios($tipo_familia['cohesion'], 'CANTIDAD', true);
            $adaptabilidad =
                $this->agrega_promedios($tipo_familia['adaptabilidad'], 'CANTIDAD', true);

            return (object)[
                // FICHA
                'tipo_familia' => $ficha[3],
                'aspectos_excelentes' => $this->get_aspectos_grupo($ficha, 'Excelente', 4),
                'aspectos_deficientes' => $this->get_aspectos_grupo($ficha, 'Deficiente', 4),

                // FACE 20
                'nivel_cohesion' => $cohesion,
                'tipo_familia_cohesion' => $this->datos_cohesion($cohesion->NIVEL)->tipo,
                'explicacion_cohesion' => $this->datos_cohesion($cohesion->NIVEL)->explicacion,
                'nivel_adaptabilidad' => $adaptabilidad,
                'tipo_familia_adaptabilidad' => $this->datos_adaptabilidad($adaptabilidad->NIVEL)->tipo,
                'explicacion_adaptabilidad' => $this->datos_adaptabilidad($adaptabilidad->NIVEL)->explicacion,
                'funcionamiento_nivel' =>
                    $this->datos_funcionamiento_familiar($cohesion->NIVEL, $adaptabilidad->NIVEL)->nivel,
                'funcionamiento_descripcion' =>
                    $this->datos_funcionamiento_familiar($cohesion->NIVEL, $adaptabilidad->NIVEL)->descripcion,
            ];
        }

        return (object)[
            'tipo_familia' => 'No definido',
            'aspectos_excelentes' => 'No definido',
            'aspectos_deficientes' => 'No definido',
            'nivel_cohesion' => 'No definido',
            'tipo_familia_cohesion' => 'No definido',
            'explicacion_cohesion' => 'No definido',
            'nivel_adaptabilidad' => 'No definido',
            'tipo_familia_adaptabilidad' => 'No definido',
            'explicacion_adaptabilidad' => 'No definido',
            'funcionamiento_nivel' => 'No definido',
            'funcionamiento_descripcion' => 'No definido',
        ];
    }

    private function get_aspectos_grupo($ficha, $aspecto, $inicio = 0)
    {
        $aspectos = [];
        for ($ind = $inicio; $ind < sizeof($ficha) - 1; $ind++) {
            $promedio = 0;
            foreach ($ficha[$ind]['RESPUESTAS'] as $respuesta) {
                if ($respuesta['RESPUESTA'] == $aspecto) {
                    $promedio = $respuesta['CANTIDAD'] * 100 / $ficha[$ind]['SUMA_TOTAL'];
                }
            }
            $aspectos[] = [
                'PK_PREGUNTA' => $ficha[$ind]['PK_PREGUNTA'],
                'PLANTEAMIENTO' => $ficha[$ind]['PLANTEAMIENTO'],
                'PROMEDIO' => $promedio,
            ];
        }

        return $aspectos;
    }

    private function get_socioeconomico_grupo($periodo, $filtros)
    {
        $ficha = ReportesTutoria::reporte_ficha_socioeconomico($periodo, $filtros);
        $nivel = ReportesTutoria::reporte_nivel_socioeconomico($periodo, $filtros);

        if ($ficha && $nivel) {
            $ficha = $this->agrupa_preguntas($ficha);
            $nivel = $this->agrega_promedios($nivel, 'CANTIDAD');

            return (object)[
                'niveles' => $nivel,
                'quien_vive' => $ficha[0],
                'trabaja' => $ficha[2],
                'aporta_dinero' => $ficha[8],
                'escolaridad_padre' => $ficha[6],
                'escolaridad_madre' => $ficha[7],
            ];
        }

        return (object)[
            'tipo_escuela' => 'No definido',
            'modalidad' => 'No definido',
            'especialidad' => 'No definido',
            'promedio' => 'No definido',
            'materias_dificultad' => 'No definido',
            'itl_primera_opcion' => 'No definido',
            'carrera_primera_opcion' => 'No definido',
        ];
    }

    private function agrega_promedios($array, $columna, $retorna_mayor = false)
    {
        $suma = 0;
        foreach ($array as $item) {
            $suma += $item->$columna;
        }

        $mayor = 0;
        $item_mayor = null;
        foreach ($array as $item) {
            $item->PROMEDIO = number_format($item->$columna / $suma * 100, 1);
            if ($item->$columna > $mayor) {
                $mayor = $item->$columna;
                $item_mayor = $item;
            }
        }

        return ($retorna_mayor) ? $item_mayor : $array;
    }

    private function get_condicion_acedemica_grupo($periodo, $filtros)
    {
        $reporte = ReportesTutoria::reporte_academica($periodo, $filtros);
        if ($reporte) {
            $reporte = $this->agrupa_preguntas($reporte);
            return (object)[
                'tipo_escuela' => $reporte[0],
                // 'modalidad'           => $reporte[1],
                'especialidad' => $reporte[2],
                'promedio' => $reporte[5],
                'materias_dificultad' => $reporte[6],
                'itl_primera_opcion' => $reporte[7],
                'carrera_primera_opcion' => $reporte[8],
            ];
        }

        return (object)[
            'tipo_escuela' => 'No definido',
            'modalidad' => 'No definido',
            'especialidad' => 'No definido',
            'promedio' => 'No definido',
            'materias_dificultad' => 'No definido',
            'itl_primera_opcion' => 'No definido',
            'carrera_primera_opcion' => 'No definido',
        ];
    }

    private function agrupa_preguntas($reporte)
    {
        $preguntas = [];
        $anterior = $reporte[0]->PK_PREGUNTA;
        $ind = 0;
        $respuestas = [];
        $preguntas[$ind]['SUMA_TOTAL'] = 0;
        $preguntas[$ind]['ABIERTAS'] = '';
        foreach ($reporte as $item) {
            $nuevo = $item->PK_PREGUNTA;
            // SEPARAR PREGUNTAS
            if ($anterior != $nuevo) {
                $anterior = $nuevo;
                $preguntas[$ind]['RESPUESTAS'] = $respuestas;
                $ind++;
                $respuestas = [];
                $preguntas[$ind]['SUMA_TOTAL'] = 0;
                $preguntas[$ind]['ABIERTAS'] = '';
            }
            $preguntas[$ind]['PK_PREGUNTA'] = $item->PK_PREGUNTA;
            $preguntas[$ind]['PLANTEAMIENTO'] = $item->PLANTEAMIENTO;
            $preguntas[$ind]['SUMA_TOTAL'] += $item->CANTIDAD;

            if ($item->TIPO_PREGUNTA == 6) {
                $preguntas[$ind]['ABIERTAS'] .= str_replace("\n", ' ', $item->RESPUESTA_ABIERTA) . ', ';
            } else {
                $respuestas[] = [
                    'RESPUESTA' => $item->RESPUESTA,
                    'CANTIDAD' => $item->CANTIDAD,
                ];
            }
        }
        $preguntas[$ind]['RESPUESTAS'] = $respuestas;

        return $preguntas;
    }

    private function get_datos_personales($periodo, $filtro)
    {
        $datos_personales = ReportesTutoria::reporte_datos_personales($periodo, $filtro);
        if ($datos_personales) {
            $data = [];
            foreach ($datos_personales as $key => $categoria) {
                $data[$key] = $this->calcula_promedio($categoria);
            }

            return $data;
        }

        return [];
    }

    private function calcula_promedio($array)
    {
        $suma = 0;
        foreach ($array as $item) {
            $suma += $item->CANTIDAD;
        }
        foreach ($array as $item) {
            $item->PROMEDIO = number_format(($item->CANTIDAD / $suma) * 100, 1);
        }

        return $array;
    }

    /* ********************************************* *
     * ******** REPORTE DE PERFIL PERSONAL ********* *
     * ********************************************* */
    /**
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function perfil_personal(Request $request)
    {
        if ($request->pk_encriptada) {
            $alumno = UsuariosHelper::get_usuario($request->pk_encriptada);
            if ($alumno) {
                $html_final = view(
                    'tutorias.perfil_individual_ingreso',
                    $this->get_perfil_personal($alumno)
                );

                /* Fuentes */
                $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
                $fontDirs = $defaultConfig['fontDir'];

                $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
                $fontData = $defaultFontConfig['fontdata'];

                $mpdf = new Mpdf([
                    'fontDir' => array_merge($fontDirs, [
                        __DIR__ . '/custom/font/directory',
                    ]),
                    'fontdata' => $fontData + [
                            'montserrat' => [
                                'R' => 'Montserrat-Medium.ttf',
                                'B' => 'Montserrat-ExtraBold.ttf',
                            ]
                        ],
                    'default_font' => 'montserrat'
                ]);

                $mpdf->WriteHTML($html_final);
                return $mpdf->Output();
            } else {
                return ResponseHTTP::response_error('Bad request');
            }
        } else {
            return ResponseHTTP::response_error('Bad request');
        }
    }

    private function get_perfil_personal($alumno)
    {
        $data = [];
        $detalle_grupo = GrupoTutoriasDetalle::where('FK_USUARIO', $alumno->PK_USUARIO)
            ->orderBy('PK_GRUPO_TUTORIA_DETALLE', 'desc')
            ->first();
        if ($detalle_grupo) {
            $grupo = GrupoTutorias::find($detalle_grupo->FK_GRUPO);
            $data['alumno'] = $alumno;
            $data['tutor'] = $this->get_tutor($grupo->FK_USUARIO);
            $data['grupo'] = $grupo->CLAVE;
            $data['periodo'] = Constantes::get_periodo_texto($grupo->PERIODO);

            $estado_civil = Estado_Civil::find($alumno->FK_ESTADO_CIVIL);
            $data['alumno']->ESTADO_CIVIL = (isset($estado_civil->NOMBRE)) ? $estado_civil->NOMBRE : 'No definido';

            $carrera = Carrera::find($alumno->FK_CARRERA);
            $data['carrera'] = (isset($carrera->NOMBRE)) ? $carrera->NOMBRE : 'No definido';

            // filtros para reportes
            $filtros = ['usuario' => $alumno->PK_USUARIO];

            // Reporte condición académica
            $data['condicion_academica'] = $this->get_condicion_acedemica($grupo->PERIODO, $filtros);

            // Reporte condición socioeconomica
            $data['condicion_socioeconomica'] = $this->get_condicion_socioeconomica($grupo->PERIODO, $filtros);

            // Reporte condición familiar
            $data['condicion_familiar'] = $this->get_condicion_familiar($grupo->PERIODO, $filtros);

            // Reporte pasatiempos
            $data['pasatiempos'] = $this->get_pasatiempos($grupo->PERIODO, $filtros);

            // Reporte salud
            $data['salud'] = $this->get_salud($grupo->PERIODO, $filtros);

            // Reporte hábitos de estudio
            $data['habitos_estudio'] = $this->get_habitos_estudio($grupo->PERIODO, $filtros);
        }

        return $data;
    }

    private function get_habitos_estudio($periodo, $filtros)
    {
        $habitos = ReportesTutoria::reporte_habitos($periodo, $filtros);

        if ($habitos) {
            $puntos_fuertes = [];
            $puntos_debiles = [];
            foreach ($habitos as $habito) {
                if ($habito->PORCENTAJE >= 70) {
                    $puntos_fuertes[] = $habito->DESCRIPCION . '(' . $habito->ABREVIATURA . ')';
                } else {
                    $puntos_debiles[] = $habito->DESCRIPCION . '(' . $habito->ABREVIATURA . ')';
                }
            }

            return (object)[
                'puntos_fuertes' => $puntos_fuertes,
                'puntos_debiles' => $puntos_debiles,
            ];
        }
        return (object)[
            'puntos_fuertes' => [],
            'puntos_debiles' => [],
        ];
    }

    private function get_salud($periodo, $filtro)
    {
        $salud = ReportesTutoria::reporte_salud($periodo, $filtro);

        if ($salud) {
            $habilidades = [];
            $respuestas = [];
            $respuestas_pool = [0, 1, 2, 4, 5, 6, 9, 10];
            foreach ($salud as $index => $pregunta) {
                if (in_array($index, $respuestas_pool)) {
                    if ($pregunta->RESPUESTA == 'SÍ') {
                        $respuestas[] = [
                            'PLANTEAMIENTO' => $pregunta->PLANTEAMIENTO,
                            'RESPUESTA' => $pregunta->RESPUESTA
                        ];
                    }
                }

                if ($index >= 14 && $index <= 26) {
                    if ($pregunta->RESPUESTA == 'Excelente' || $pregunta->RESPUESTA == 'Mala') {
                        $habilidades[] = [
                            'PLANTEAMIENTO' => $pregunta->PLANTEAMIENTO,
                            'RESPUESTA' => $pregunta->RESPUESTA
                        ];
                    }
                }
            }

            return (object)[
                'estado_salud' => $salud[14]->RESPUESTA,
                'respuestas' => $respuestas,
                'habilidades' => $habilidades,
                'estado_animo' => $salud[28]->RESPUESTA,
            ];
        }

        return (object)[
            'estado_salud' => 'No definido',
            'respuestas' => [],
            'habilidades' => [],
            'estado_animo' => 'No definido',
        ];
    }

    private function get_pasatiempos($periodo, $filtros)
    {
        $pasatiempos = ReportesTutoria::reporte_pasatiempos($periodo, $filtros);
        if ($pasatiempos) {
            return (object)[
                'mas_realiza_1' => $pasatiempos[0]->RESPUESTA,
                'mas_realiza_2' => $pasatiempos[1]->RESPUESTA,
                'mas_realiza_3' => $pasatiempos[2]->RESPUESTA,
                'menos_realiza_1' => $pasatiempos[12]->RESPUESTA,
                'menos_realiza_2' => $pasatiempos[13]->RESPUESTA,
                'menos_realiza_3' => $pasatiempos[14]->RESPUESTA,
            ];
        }

        return (object)[
            'mas_realiza_1' => 'No definido',
            'mas_realiza_2' => 'No definido',
            'mas_realiza_3' => 'No definido',
            'menos_realiza_1' => 'No definido',
            'menos_realiza_2' => 'No definido',
            'menos_realiza_3' => 'No definido',
        ];
    }

    private function get_condicion_familiar($periodo, $filtros)
    {
        $ficha = ReportesTutoria::reporte_ficha_familiar($periodo, $filtros);
        $tipo_familia = ReportesTutoria::reporte_tipo_familia($periodo, $filtros);
        /*error_log(print_r($ficha, true));
        error_log(print_r($tipo_familia, true));*/
        if ($ficha && $tipo_familia) {
            return (object)[
                'tipo_familia' => $ficha[3]->RESPUESTA,
                'numero_hermanos' => $ficha[1]->RESPUESTA,
                'lugar_entre_hermanos' => $ficha[2]->RESPUESTA,
                'aspectos_excelentes' => $this->get_aspectos($ficha, 'Excelente', 4),
                'aspectos_deficientes' => $this->get_aspectos($ficha, 'Deficiente', 4),
                // fase 20 esr
                'nivel_cohesion' => $tipo_familia['cohesion'][0]->NIVEL,
                'familia_cohesion' => $this->datos_cohesion($tipo_familia['cohesion'][0]->NIVEL)->tipo,
                'explicacion_cohesion' => $this->datos_cohesion($tipo_familia['cohesion'][0]->NIVEL)->explicacion,

                'nivel_adaptabilidad' => $tipo_familia['adaptabilidad'][0]->NIVEL,
                'familia_adaptabilidad' => $this->datos_adaptabilidad($tipo_familia['adaptabilidad'][0]->NIVEL)->tipo,
                'explicacion_adaptabilidad' =>
                    $this->datos_adaptabilidad($tipo_familia['adaptabilidad'][0]->NIVEL)->explicacion,

                'nivel_funcionamiento' => $this->datos_funcionamiento_familiar(
                    $tipo_familia['cohesion'][0]->NIVEL,
                    $tipo_familia['adaptabilidad'][0]->NIVEL
                )->nivel,
                'explicacion_funcionamiento' => $this->datos_funcionamiento_familiar(
                    $tipo_familia['cohesion'][0]->NIVEL,
                    $tipo_familia['adaptabilidad'][0]->NIVEL
                )->descripcion
            ];
        }

        return (object)[
            'tipo_familia' => 'No definido',
            'numero_hermanos' => 'No definido',
            'lugar_entre_hermanos' => 'No definido',
            'aspectos_excelentes' => 'No definido',
            'aspectos_deficientes' => 'No definido',
            // fase 20 esr
            'nivel_cohesion' => 'No definido',
            'familia_cohesion' => 'No definido',
            'explicacion_cohesion' => 'No definido',
            'nivel_adaptabilidad' => 'No definido',
            'familia_adaptabilidad' => 'No definido',
            'explicacion_adaptabilidad' => 'No definido',
            'nivel_funcionamiento' => 'No definido',
            'explicacion_funcionamiento' => 'No definido',
        ];
    }

    private function get_aspectos($ficha, $aspecto, $inicio = 0)
    {
        $aspectos = '';
        for ($ind = $inicio; $ind < sizeof($ficha); $ind++) {
            if ($ficha[$ind]->RESPUESTA == $aspecto) {
                $aspectos .= $ficha[$ind]->PLANTEAMIENTO . ', ';
            }
        }

        return $aspectos;
    }

    private function get_condicion_socioeconomica($periodo, $filtros)
    {
        $ficha = ReportesTutoria::reporte_ficha_socioeconomico($periodo, $filtros);
        $nivel = ReportesTutoria::reporte_nivel_socioeconomico($periodo, $filtros);
        if ($ficha && $nivel) {
            return (object)[
                'nivel_socioeconomico' => $nivel[0]->NIVEL,
                'con_quien_vive' => $ficha[0]->RESPUESTA,
                'trabaja' => $ficha[2]->RESPUESTA,
                'aporte_dinero' => $ficha[8]->RESPUESTA,
                'escolaridad_padre' => $ficha[6]->RESPUESTA,
                'escolaridad_madre' => $ficha[7]->RESPUESTA,
                'colonia' => $ficha[10]->RESPUESTA_ABIERTA,
            ];
        }

        return (object)[
            'nivel_socioeconomico' => 'No definido',
            'con_quien_vive' => 'No definido',
            'trabaja' => 'No definido',
            'aporte_dinero' => 'No definido',
            'escolaridad_padre' => 'No definido',
            'escolaridad_madre' => 'No definido',
            'colonia' => 'No definido',
        ];
    }

    private function get_condicion_acedemica($periodo, $filtros)
    {
        $reporte = ReportesTutoria::reporte_academica($periodo, $filtros);
        if ($reporte) {
            return (object)[
                'tipo_escuela' => $reporte[0]->RESPUESTA,
                'modalidad' => $reporte[1]->RESPUESTA,
                'especialidad' => $reporte[2]->RESPUESTA_ABIERTA,
                'promedio' => $reporte[5]->RESPUESTA,
                'materias_dificultad' => $reporte[6]->RESPUESTA_ABIERTA,
                'itl_primera_opcion' => $reporte[7]->RESPUESTA,
                'carrera_primera_opcion' => $reporte[8]->RESPUESTA,
            ];
        }

        return (object)[
            'tipo_escuela' => 'No definido',
            'modalidad' => 'No definido',
            'especialidad' => 'No definido',
            'promedio' => 'No definido',
            'materias_dificultad' => 'No definido',
            'itl_primera_opcion' => 'No definido',
            'carrera_primera_opcion' => 'No definido',
        ];
    }

    private function get_tutor($pk_usuario)
    {
        $usuario = UsuariosHelper::get_usuario_pk($pk_usuario);

        return ($usuario)
            ? $usuario->NOMBRE . ' ' . $usuario->PRIMER_APELLIDO . ' ' . $usuario->SEGUNDO_APELLIDO
            : 'No asignado';
    }

    /**
     * @param $nivel
     * @return object | [tipo, expliccion]
     */
    private function datos_cohesion($nivel)
    {
        switch ($nivel) {
            case 'Cohesión baja':
                return (object)[
                    'tipo' => 'Desprendida o desapegada',
                    'explicacion' => 'Familias con ausencia de unión afectiva y lealtad,
                    lo primordial es el yo por lo que existe una alta independencia personal,
                    es escaso el tiempo para convivir y por tanto el involucramiento o interacción
                    entre los miembros, las decisiones son tomadas de manera independiente y los
                    intereses son desiguales y se enfocan fuera de la familia.'
                ];
            case 'Cohesión moderada-baja':
                return (object)[
                    'tipo' => 'Separada',
                    'explicacion' => 'Familias en que existe la separación emocional, aunque a veces se demuestra
                    el afecto, la lealtad familiar es ocasional, el involucramiento se acepta,
                    sin embargo se prefiere la distancia, hay una tendencia al yo, con presencia
                    del nosotros, en la interacción se da la interdependencia con cierta
                    tendencia a la independencia, el límite parento-filial es claro con cierto
                    nivel de cercanía entre padres e hijos, las decisiones se toman
                    individualmente habiendo posibilidad de realizarlas de manera conjunta, el
                    interés se focaliza fuera de la familia y se prefieren espacios separados.'
                ];
            case 'Cohesión moderada-alta':
                return (object)[
                    'tipo' => 'Unida o conectada',
                    'explicacion' => 'Familias en que lo principal es el nosotros con presencia del yo, se
                    presenta una considerable unión-afectiva y fidelidad entre sus integrantes,
                    interdependencia con tendencia a la dependencia, los límites entre
                    subsistemas son claros con cercanía parento-filial, el tiempo de convivencia
                    juntos es importante, la separación es respetada pero poco valorada, las
                    decisiones se toman preferentemente de manera conjunta y el interés se
                    focaliza dentro de la familia.'
                ];
            case 'Cohesión muy alta':
                return (object)[
                    'tipo' => 'Enredada o apegada',
                    'explicacion' => 'Familias en que la cercanía emocional es extrema, el involucramiento
                    simbiótico, los integrantes dependen unos de otros en todos los aspectos, no
                    existen límites generacionales, el interés se focaliza dentro de la familia,
                    se dan por mandato los intereses conjuntos, la lealtad se demanda hacia la
                    familia, las coaliciones parento-filiales están presentes, la mayor parte
                    del tiempo se convive juntos, hay falta de separación personal.'
                ];
            default:
                return (object)[
                    'tipo' => 'No definido',
                    'explicacion' => 'No definido',
                ];
        }
    }

    /**
     * @param $nivel
     * @return object | [tipo, expliccion]
     */
    private function datos_adaptabilidad($nivel)
    {
        switch ($nivel) {
            case 'Adaptabilidad baja':
                return (object)[
                    'tipo' => 'Rígida',
                    'explicacion' => 'En estas familias, el liderazgo es autoritario con control parental, los roles
                    son fijos y definidos, la disciplina estricta, rígida y severa, los padres
                    imponen las decisiones, las reglas se cumplen estrictamente y no existe la
                    posibilidad del cambio.'
                ];
            case 'Adaptabilidad moderada-baja':
                return (object)[
                    'tipo' => 'Estructurada',
                    'explicacion' => 'Familias en las que el liderazgo es autoritario en principio y algunas veces
                    igualitario, los roles son compartidos, en cierto grado la disciplina es
                    democrática, lo padres toman las decisiones, las reglas se cumplen firmemente y
                    pocas veces cambian, es democrática y los cambios se dan cuando se solicitan.'
                ];
            case 'Adaptabilidad moderada-alta':
                return (object)[
                    'tipo' => 'Flexible',
                    'explicacion' => 'Es característico que en la familia se comparta el liderazgo y los roles, la
                    disciplina es democrática, es común que se den los acuerdos en las decisiones,
                    las reglas se cumplen con flexibilidad y pueden cambiar algunas, y se permiten
                    los cambios cuando son necesarios.'
                ];
            case 'Adaptabilidad muy alta':
                return (object)[
                    'tipo' => 'Caótica',
                    'explicacion' => 'En este tipo de familias, el liderazgo es ineficaz o ausente, la disciplina poco
                    severa e inconsistente en sus castigos, las decisiones de los padres son
                    impulsivas, no se tiene claridad en los roles ni funciones, y los cambios son
                    muy frecuentes en el sistema.'
                ];
            default:
                return (object)[
                    'tipo' => 'No definido',
                    'explicacion' => 'No definido',
                ];
        }
    }

    /**
     * @param $nivel_cohesion
     * @param $nivel_adaptabilidad
     * @return object | [nivel, descripcion]
     */
    private function datos_funcionamiento_familiar($nivel_cohesion, $nivel_adaptabilidad)
    {
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-alta' && $nivel_cohesion == 'Cohesión moderada-baja') {
            return (object)[
                'nivel' => 'Balanceado: Flexible-separada',
                'descripcion' => 'Los niveles de funcionamiento familiar balanceados
                ubica a aquellas de óptimo funcionamiento.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-alta' && $nivel_cohesion == 'Cohesión moderada-alta') {
            return (object)[
                'nivel' => 'Balanceado: Flexible-unida',
                'descripcion' => 'Los niveles de funcionamiento familiar balanceados
                ubica a aquellas de óptimo funcionamiento.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-baja' && $nivel_cohesion == 'Cohesión moderada-baja') {
            return (object)[
                'nivel' => 'Balanceado: Estructurada-separada',
                'descripcion' => 'Los niveles de funcionamiento familiar balanceados
                ubica a aquellas de óptimo funcionamiento.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-baja' && $nivel_cohesion == 'Cohesión moderada-alta') {
            return (object)[
                'nivel' => 'Balanceado: Estructurada-unida',
                'descripcion' => 'Los niveles de funcionamiento familiar balanceados
                ubica a aquellas de óptimo funcionamiento.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad alta' && $nivel_cohesion == 'Cohesión moderada-baja') {
            return (object)[
                'nivel' => 'Rango medio: Caótica – separada',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad alta' && $nivel_cohesion == 'Cohesión moderada-alta') {
            return (object)[
                'nivel' => 'Rango medio: Caótica-unida',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-alta' && $nivel_cohesion == 'Cohesión baja') {
            return (object)[
                'nivel' => 'Rango medio: Flexible- desprendida',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-alta' && $nivel_cohesion == 'Cohesión muy alta') {
            return (object)[
                'nivel' => 'Rango medio: Flexible-enredada',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-baja' && $nivel_cohesion == 'Cohesión baja') {
            return (object)[
                'nivel' => 'Rango medio: Estructurada-desprendida',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad moderada-baja' && $nivel_cohesion == 'Cohesión muy alta') {
            return (object)[
                'nivel' => 'Rango medio: Estructurada-enredada',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad baja' && $nivel_cohesion == 'Cohesión moderada-baja') {
            return (object)[
                'nivel' => 'Rango medio: Rígida-separada',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad baja' && $nivel_cohesion == 'Cohesión moderada-alta') {
            return (object)[
                'nivel' => 'Rango medio: Rígida-unida',
                'descripcion' => 'En el nivel de rango medio se presentan familias cuya dinámica es extrema
                en una sola dimensión, sea en adaptabilidad o en cohesión,
                generalmente debido a situaciones de estrés.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad alta' && $nivel_cohesion == 'Cohesión baja') {
            return (object)[
                'nivel' => 'Extremo: Caótica-desprendida',
                'descripcion' => 'En los niveles extremos se ubican familias en situación de dificultad,
                y en la cohesión se encuentran de tipo desprendida-enredada y en la adaptabilidad caótica-rígida.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad alta' && $nivel_cohesion == 'Cohesión muy alta') {
            return (object)[
                'nivel' => 'Extremo: Caótica -enredada',
                'descripcion' => 'En los niveles extremos se ubican familias en situación de dificultad,
                y en la cohesión se encuentran de tipo desprendida-enredada y en la adaptabilidad caótica-rígida.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad baja' && $nivel_cohesion == 'Cohesión baja') {
            return (object)[
                'nivel' => 'Extremo: Rígida-desprendia',
                'descripcion' => 'En los niveles extremos se ubican familias en situación de dificultad,
                y en la cohesión se encuentran de tipo desprendida-enredada y en la adaptabilidad caótica-rígida.'];
        }
        if ($nivel_adaptabilidad == 'Adaptabilidad baja' && $nivel_cohesion == 'Cohesión muy alta') {
            return (object)[
                'nivel' => 'Extremo: Rígida-enredada',
                'descripcion' => 'En los niveles extremos se ubican familias en situación de dificultad,
                y en la cohesión se encuentran de tipo desprendida-enredada y en la adaptabilidad caótica-rígida.'];
        }

        return (object)[
            'nivel' => 'No definido',
            'descripcion' => 'No definido'
        ];
    }
}
