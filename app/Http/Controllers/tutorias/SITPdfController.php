<?php

namespace App\Http\Controllers\tutorias;

use App\Aplicacion_Encuesta;
use App\Carrera;
use App\Estado_Civil;
use App\GrupoTutorias;
use App\GrupoTutoriasDetalle;
use App\Helpers\Constantes;
use App\Helpers\SITHelper;
use App\Http\Controllers\Controller;
use App\Usuario;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

/**
 * Class SITPdfController
 * @package App\Http\Controllers\tutorias
 */
class SITPdfController extends Controller
{
    /**
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function get_pdf_perfil_grupal_ingreso(Request $request)
    {
        if ($request->grupo) {
            $data_reporte['data'] = $this->get_datos_perfil_grupal($request->grupo);

            $html_final = view('tutorias.perfil_grupal_ingreso', $data_reporte);
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
    }

    private function get_datos_perfil_grupal($pk_grupo) {
        $data = [];

        $datos_grupo = $this->get_tutor_grupo($pk_grupo);
        $data['tutor']            = $datos_grupo->NOMBRE .' '. $datos_grupo->PRIMER_APELLIDO .' '. $datos_grupo->SEGUNDO_APELLIDO;
        $data['grupo']            = $datos_grupo->CLAVE;
        $data['cantidad_alumnos'] = $this->get_cantidad_alumnos_grupo($pk_grupo);
        $data['carrera'] = $this->get_carrera_grupo($pk_grupo);

        // datos personales de grupo
        $data['personales'] = $this->get_datos_personales_grupo($pk_grupo);

        // datos condición académica
        $data['academico'] = $this->get_condicion_academica_grupo($pk_grupo);

        // datos condición socioeconomica
        $data['socioeconomica'] = $this->get_socioeconomica_grupo($pk_grupo);

        // datos condicion familiar
        $data['familiar'] = $this->get_familiar_grupo($pk_grupo);

        // datos salud fisica
        $data['pasatiempos'] = SITHelper::pasatiempos_grupo($pk_grupo, 1);

        // datos salud fisica
        $data['salud'] = $this->get_salud_grupo($pk_grupo);

        // datos hábitos de estudio
        $data['habitos_estudio'] = SITHelper::habitos_estudio_grupo($pk_grupo);

        return $data;
    }

    private function get_familiar_grupo($pk_grupo) {

        $factor_cohesion      = SITHelper::factor_cohesion_grupo($pk_grupo);
        $factor_adaptabilidad = SITHelper::factor_adaptabilidad_grupo($pk_grupo);

        return [
            'tipo_familia' => SITHelper::promedio_pregunta_grupo($pk_grupo, 65),
            'aspectos'     => SITHelper::habilidades_grupo(
                $pk_grupo,
                '66, 67, 68, 69, 70, 71, 72, 73, 74, 75',
                'Excelente',
                'Deficiente'
            ),
            'cohesion'       => SITHelper::get_datos_cohesion($factor_cohesion),
            'adaptabilidad'  => SITHelper::get_datos_adaptabilidad($factor_adaptabilidad),
            'funcionamiento' => SITHelper::get_datos_funcionamiento_familiar($factor_cohesion, $factor_adaptabilidad),
        ];
    }

    private function get_socioeconomica_grupo($pk_grupo) {
        return [
            /*'salud_fisica'           => SITHelper::promedio_pregunta_grupo($pk_grupo, 16),*/
            'quien_vive'           => SITHelper::promedio_pregunta_grupo($pk_grupo, 32),
            'trabaja'              => SITHelper::promedio_pregunta_grupo($pk_grupo, 34),
            'aporta_dinero'        => SITHelper::promedio_pregunta_grupo($pk_grupo, 40),
            'escolaridad_padre'    => SITHelper::promedio_pregunta_grupo($pk_grupo, 38),
            'escolaridad_madre'    => SITHelper::promedio_pregunta_grupo($pk_grupo, 39),
            'nivel_socioeconomico' => SITHelper::condicion_socioeconomica_grupo($pk_grupo),
        ];
    }

    private function get_salud_grupo($pk_grupo) {
        return [
            'salud_fisica'           => SITHelper::promedio_pregunta_grupo($pk_grupo, 16),
            'sentimiento'            => SITHelper::promedio_pregunta_grupo($pk_grupo, 30),
            'habilidades'            => SITHelper::habilidades_grupo(
                $pk_grupo,
                '17, 18, 19, 20, 21, 22, 24, 25, 26, 27, 28, 29',
                'Mala',
                'Excelente'
            ),
        ];
    }

    private function get_condicion_academica_grupo($pk_grupo) {
        return [
            'tipo_escuela'           => SITHelper::promedio_pregunta_grupo($pk_grupo, 53),
            'areas'                  => SITHelper::respuestas_grupo($pk_grupo, 55),
            'promedios'              => SITHelper::promedio_pregunta_grupo($pk_grupo, 58),
            'materias_dificiles'     => SITHelper::respuestas_grupo($pk_grupo, 59),
            'itl_primera_opcion'     => SITHelper::promedio_pregunta_grupo($pk_grupo, 60),
            'carrera_primera_opcion' => SITHelper::promedio_pregunta_grupo($pk_grupo, 61),
        ];
    }

    private function get_datos_personales_grupo($pk_grupo) {
        return [
            'sexo'                 => SITHelper::porcentaje_sexo_grupo($pk_grupo),
            'estado_civil'         => SITHelper::porcentaje_estado_civil_grupo($pk_grupo),
            'colonias'             => SITHelper::colonias_grupo($pk_grupo),
            'situacion_residencia' => SITHelper::situacion_residencia_grupo($pk_grupo),
        ];
    }

    /**
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function get_pdf_perfil_personal_ingreso(Request $request)
    {
        $data_reporte['data'] = $this->get_datos_perfil_personal($request->pk_encriptada);

        $html_final = view('tutorias.perfil_individual_ingreso', $data_reporte);

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
    }

    private function get_datos_perfil_personal($pk_encriptada) {
        $data = [];

        $alumno = Usuario::where('PK_ENCRIPTADA', $pk_encriptada)->first();
        if ($alumno) {
            $grupo = GrupoTutoriasDetalle::where('FK_USUARIO', $alumno->PK_USUARIO)->first();
            $carrera = Carrera::where('PK_CARRERA', $alumno->FK_CARRERA)->first();
            $estado_civil = Estado_Civil::where('PK_ESTADO_CIVIL', $alumno->FK_ESTADO_CIVIL)->first();
            if ($grupo) {
                $datos_grupo = $this->get_tutor_grupo($grupo->FK_GRUPO);
                if ($datos_grupo) {
                    $data['tutor']               = $datos_grupo->NOMBRE .' '. $datos_grupo->PRIMER_APELLIDO .' '. $datos_grupo->SEGUNDO_APELLIDO;
                    $data['grupo']               = $datos_grupo->CLAVE;
                    $data['periodo']             = Constantes::get_periodo_texto($datos_grupo->PERIODO);

                    $data['alumno']              = $alumno->NOMBRE .' '. $alumno->PRIMER_APELLIDO .' '. $alumno->SEGUNDO_APELLIDO;
                    $data['numero_control']      = $alumno->NUMERO_CONTROL;
                    $data['semestre']            = $alumno->SEMESTRE;

                    $data['fecha_nacimiento']    = $alumno->FECHA_NACIMIENTO;
                    $data['edad']                = Constantes::calcula_edad($alumno->FECHA_NACIMIENTO);
                    $data['estado_civil']        = (isset($estado_civil->NOMBRE)) ? $estado_civil->NOMBRE : '';
                    $data['correo']              = $alumno->CORREO1;
                    $data['telefono_movil']      = $alumno->TELEFONO_CASA;
                    $data['telefono_fijo']       = $alumno->TELEFONO_MOVIL;

                    $data['nombre_contacto']     = $alumno->NOMBRE_CONTACTO;
                    $data['parentesco_contacto'] = $alumno->PARENTESCO_CONTACTO;
                    $data['telefono_contacto']   = $alumno->TELEFONO_CONTACTO;
                    $data['correo_contacto']     = $alumno->CORREO_CONTACTO;

                    $data['carrera']             = $carrera->NOMBRE;
                    $data['grupo']               = $datos_grupo->CLAVE;

                    // Reporte condición académica
                    $data['condicion_academica'] = $this->get_condicion_acedemica($alumno->PK_USUARIO, $datos_grupo->PERIODO);

                    // Reporte condición socioeconomica
                    $data['condicion_socioeconomica'] = $this->get_condicion_socioeconomica($alumno->PK_USUARIO, $datos_grupo->PERIODO);

                    // Reporte condición socioeconomica
                    $data['condicion_familiar'] = $this->get_condicion_familiar($alumno->PK_USUARIO, $datos_grupo->PERIODO);

                    // Reporte pasatiempos
                    $data['pasatiempos'] = $this->get_pasatiempos($alumno->PK_USUARIO, $datos_grupo->PERIODO);

                    // Reporte salud
                    $data['salud'] = $this->get_salud($alumno->PK_USUARIO, $datos_grupo->PERIODO);

                    // Reporte hábitos de estudio
                    $data['habitos_estudio'] = $this->get_habitos_estudio($alumno->PK_USUARIO, $datos_grupo->PERIODO);
                }
            }
        }

        return $data;
    }

    private function get_habitos_estudio($pk_usuario, $periodo) {
        /* Datos habitos estudio */
        $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $pk_usuario)
            ->where('PERIODO', $periodo)
            ->where('FK_ENCUESTA', Constantes::ENCUESTA_HABITOS_DE_ESTUDIO)
            ->first();

        $ficha_habitos_estudio = SITHelper::reporte_habitos_estudio(
            Constantes::ENCUESTA_HABITOS_DE_ESTUDIO,
            $aplicacion->PK_APLICACION_ENCUESTA
        );

        $porcentajes_habitos_estudio = SITHelper::get_porcentajes_habitos_estudio($ficha_habitos_estudio);

        $puntos_fuertes = [];
        $puntos_debiles = [];

        if ($porcentajes_habitos_estudio['DT'] >= 1){
            if ($porcentajes_habitos_estudio['DT'] >= 70 ) {
                $puntos_fuertes[] = 'DISTRIBUCIÓN DE TIEMPO';
            } else {
                $puntos_debiles[] = 'DISTRIBUCIÓN DE TIEMPO';
            }
        }

        if ($porcentajes_habitos_estudio['ME'] >= 1) {
            if ($porcentajes_habitos_estudio['ME'] >= 70) {
                $puntos_fuertes[] = 'MOTIVACIÓN PARA EL ESTUDIO';
            } else {
                $puntos_debiles[] = 'MOTIVACIÓN PARA EL ESTUDIO';
            }
        }

        if ($porcentajes_habitos_estudio['DE'] >= 1) {
            if ($porcentajes_habitos_estudio['DE'] >= 70) {
                $puntos_fuertes[] = 'DISTRACTORES DURANTE EL ESTUDIO';
            } else {
                $puntos_debiles[] = 'DISTRACTORES DURANTE EL ESTUDIO';
            }
        }

        if ($porcentajes_habitos_estudio['NC'] >= 1) {
            if ($porcentajes_habitos_estudio['NC'] >= 70) {
                $puntos_fuertes[] = 'CÓMO TOMAR NOTAS EN CLASE';
            } else {
                $puntos_debiles[] = 'CÓMO TOMAR NOTAS EN CLASE';
            }
        }

        if ($porcentajes_habitos_estudio['OL'] >= 1) {
            if ($porcentajes_habitos_estudio['OL'] >= 70) {
                $puntos_fuertes[] = 'OPTIMIZACIÓN DE LA LECTURA';
            } else {
                $puntos_debiles[] = 'OPTIMIZACIÓN DE LA LECTURA';
            }
        }

        if ($porcentajes_habitos_estudio['PE'] >= 1) {
            if ($porcentajes_habitos_estudio['PE'] >= 70) {
                $puntos_fuertes[] = 'CÓMO PREPARAR UN EXAMEN';
            } else {
                $puntos_debiles[] = 'CÓMO PREPARAR UN EXAMEN';
            }
        }

        if ($porcentajes_habitos_estudio['AC'] >= 1) {
            if ($porcentajes_habitos_estudio['AC'] >= 70) {
                $puntos_fuertes[] = 'ACTITUDES Y CONDUCTAS PRODUCTIVAS ANTE EL ESTUDIO';
            } else {
                $puntos_debiles[] = 'ACTITUDES Y CONDUCTAS PRODUCTIVAS ANTE EL ESTUDIO';
            }
        }

        return [
            'puntos_fuertes' => $puntos_fuertes,
            'puntos_debiles' => $puntos_debiles,
        ];
    }

    private function get_salud($pk_usuario, $periodo) {
        /* Datos pasatiempos */
        $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $pk_usuario)
            ->where('PERIODO', $periodo)
            ->where('FK_ENCUESTA', Constantes::ENCUESTA_SALUD)
            ->first();

        $ficha_salud = SITHelper::get_cuestionario_resuelto(
            Constantes::ENCUESTA_SALUD,
            $aplicacion->PK_APLICACION_ENCUESTA
        );

        $habilidades = [];
        foreach ($ficha_salud['SECCIONES'][0]['PREGUNTAS'] as $pregunta) {
            if ($pregunta['PK_PREGUNTA'] > 16 && $pregunta['PK_PREGUNTA'] < 28) {
                if (isset($pregunta['RESPUESTAS'][0]['RESPUESTA'])) {
                    if ($pregunta['RESPUESTAS'][0]['RESPUESTA'] == 'Excelente'
                        || $pregunta['RESPUESTAS'][0]['RESPUESTA'] == 'Mala') {
                        $habilidades[] = [
                            'PLANTEAMIENTO' => $pregunta['PLANTEAMIENTO'],
                            'RESPUESTA' => $pregunta['RESPUESTAS'][0]['RESPUESTA']
                        ];
                    }
                }
            }
        }

        return [
            'estado_salud' =>
                isset($ficha_salud['SECCIONES'][0]['PREGUNTAS'][14]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_salud['SECCIONES'][0]['PREGUNTAS'][14]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'habilidades' => $habilidades,
            'estado_animo' =>
                isset($ficha_salud['SECCIONES'][0]['PREGUNTAS'][28]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_salud['SECCIONES'][0]['PREGUNTAS'][28]['RESPUESTAS'][0]['RESPUESTA']
                : '',
        ];
    }

    private function get_pasatiempos($pk_usuario, $periodo) {
        /* Datos pasatiempos */
        $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $pk_usuario)
            ->where('PERIODO', $periodo)
            ->where('FK_ENCUESTA', Constantes::ENCUESTA_PASATIEMPOS)
            ->first();

        $ficha_pasatiempos = SITHelper::get_cuestionario_resuelto(
            Constantes::ENCUESTA_PASATIEMPOS,
            $aplicacion->PK_APLICACION_ENCUESTA
        );

        return [
            'mas_realiza_1' =>
                isset($ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'mas_realiza_2' =>
                isset($ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][1]['RESPUESTA'])
                ? $ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][1]['RESPUESTA']
                : '',
            'mas_realiza_3' =>
                isset($ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][2]['RESPUESTA'])
                ? $ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][2]['RESPUESTA']
                : '',
            'menos_realiza_1' =>
                isset($ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][12]['RESPUESTA'])
                ? $ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][12]['RESPUESTA']
                : '',
            'menos_realiza_2' =>
                isset($ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][13]['RESPUESTA'])
                ? $ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][13]['RESPUESTA']
                : '',
            'menos_realiza_3' =>
                isset($ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][14]['RESPUESTA'])
                ? $ficha_pasatiempos['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][14]['RESPUESTA']
                : '',
        ];
    }

    private function get_condicion_familiar($pk_usuario, $periodo) {
        /* Datos condición familiar */
        $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $pk_usuario)
            ->where('PERIODO', $periodo)
            ->where('FK_ENCUESTA', Constantes::ENCUESTA_CONDICION_FAMILIAR)
            ->first();

        $ficha_condicion_familiar = SITHelper::get_cuestionario_resuelto(
            Constantes::ENCUESTA_CONDICION_FAMILIAR,
            $aplicacion->PK_APLICACION_ENCUESTA,
            16
        );
        $reporte_condicion_famliar = SITHelper::reporte_condicion_familiar(
            Constantes::ENCUESTA_CONDICION_FAMILIAR,
            $aplicacion->PK_APLICACION_ENCUESTA
        );

        $aspectos_excelentes  = '';
        $aspectos_deficientes = '';
        foreach ($ficha_condicion_familiar['SECCIONES'][0]['PREGUNTAS'] as $pregunta) {
            if (isset($pregunta['RESPUESTAS'][0]['RESPUESTA'])) {
                if ($pregunta['RESPUESTAS'][0]['RESPUESTA'] == 'Excelente'){
                    $aspectos_excelentes .= $pregunta['PLANTEAMIENTO'] . ', ';
                }
                if ($pregunta['RESPUESTAS'][0]['RESPUESTA'] == 'Deficiente'){
                    $aspectos_deficientes .= $pregunta['PLANTEAMIENTO'] . ', ';
                }
            }
        }

        if ($aspectos_excelentes)
            $aspectos_excelentes =
                substr($aspectos_excelentes, 0, strlen($aspectos_excelentes) - 2);
        if ($aspectos_deficientes)
            $aspectos_deficientes =
                substr($aspectos_deficientes, 0, strlen($aspectos_deficientes) - 2);

        $datos_cohesion =
            SITHelper::get_datos_cohesion($reporte_condicion_famliar['COHESION']);
        $datos_adaptabilidad =
            SITHelper::get_datos_adaptabilidad($reporte_condicion_famliar['ADAPTABILIDAD']);
        $datos_funcionamiento_familiar =
            SITHelper::get_datos_funcionamiento_familiar(
                $reporte_condicion_famliar['COHESION'],
                $reporte_condicion_famliar['ADAPTABILIDAD']
            );

        return [
            'tipo_familia'         =>
                isset($ficha_condicion_familiar['SECCIONES'][0]['PREGUNTAS'][3]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_familiar['SECCIONES'][0]['PREGUNTAS'][3]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'numero_hermanos'      =>
                isset($ficha_condicion_familiar['SECCIONES'][0]['PREGUNTAS'][1]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_familiar['SECCIONES'][0]['PREGUNTAS'][1]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'lugar_entre_hermanos' =>
                isset($ficha_condicion_familiar['SECCIONES'][0]['PREGUNTAS'][2]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_familiar['SECCIONES'][0]['PREGUNTAS'][2]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'aspectos_excelentes'  => $aspectos_excelentes,
            'aspectos_deficientes' => $aspectos_deficientes,
            // fase 20 esr
            'nivel_cohesion'             => $datos_cohesion['nivel'],
            'familia_cohesion'           => $datos_cohesion['tipo_familia'],
            'explicacion_cohesion'       => $datos_cohesion['explicacion'],
            'nivel_adaptabilidad'        => $datos_adaptabilidad['nivel'],
            'familia_adaptabilidad'      => $datos_adaptabilidad['tipo_familia'],
            'explicacion_adaptabilidad'  => $datos_adaptabilidad['explicacion'],
            'nivel_funcionamiento'       => $datos_funcionamiento_familiar['nivel'],
            'explicacion_funcionamiento' => $datos_funcionamiento_familiar['explicacion'],
        ];
    }

    private function get_condicion_socioeconomica($pk_usuario, $periodo) {
        /* Datos condicion socioeconómica */
        $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $pk_usuario)
            ->where('PERIODO', $periodo)
            ->where('FK_ENCUESTA', Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA)
            ->first();

        $ficha_condicion_socioeconomica = SITHelper::get_cuestionario_resuelto(
            Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA,
            $aplicacion->PK_APLICACION_ENCUESTA,
            14
        );
        $nivel_socioeconomico = SITHelper::get_nivel_socioeconomico(
            SITHelper::reporte_condicion_socioeconomica(
                Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA,
                $aplicacion->PK_APLICACION_ENCUESTA
            )
        );

        $aporte_dinero = isset($ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][8]['RESPUESTAS'][0]['RESPUESTA'])
            ? $ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][8]['RESPUESTAS'][0]['RESPUESTA']
            : '';
        if (isset($ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][8]['RESPUESTAS'][0]['ABIERTA']))
            $aporte_dinero =
                $ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][8]['RESPUESTAS'][0]['ABIERTA'];
        return [
            'nivel_socioeconomico' => $nivel_socioeconomico,
            'con_quien_vive'   =>
                isset($ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'trabaja'          =>
                isset($ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][2]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][2]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'aporte_dinero'          => $aporte_dinero,
            'escolaridad_padre'          =>
                isset($ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][6]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][6]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'escolaridad_madre'          =>
                isset($ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][7]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][7]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'colonia' =>
                isset($ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][10]['RESPUESTAS'][0]['ABIERTA'])
                ? $ficha_condicion_socioeconomica['SECCIONES'][0]['PREGUNTAS'][10]['RESPUESTAS'][0]['ABIERTA']
                : ''
        ];
    }

    private function get_condicion_acedemica($pk_usuario, $periodo) {
        /* Datos condicion académica */
        $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $pk_usuario)
            ->where('PERIODO', $periodo)
            ->where('FK_ENCUESTA', Constantes::ENCUESTA_CONDICION_ACADEMICA)
            ->first();

        $ficha_condicion_academica = SITHelper::get_cuestionario_resuelto(
            Constantes::ENCUESTA_CONDICION_ACADEMICA,
            $aplicacion->PK_APLICACION_ENCUESTA
        );

        return [
            'tipo_escuela'           =>
                isset($ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][0]['RESPUESTAS'][0]['RESPUESTA']
            : '',
            'modalidad'              =>
                isset($ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][1]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][1]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'especialidad'           =>
                isset($ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][2]['RESPUESTAS'][0]['ABIERTA'])
                ? $ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][2]['RESPUESTAS'][0]['ABIERTA']
                : '',
            'promedio'               =>
                isset($ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][5]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][5]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'materias_dificultad'    =>
                isset($ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][6]['RESPUESTAS'][0]['ABIERTA'])
                ? $ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][6]['RESPUESTAS'][0]['ABIERTA']
                : '',
            'itl_primera_opcion'     =>
                isset($ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][7]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][7]['RESPUESTAS'][0]['RESPUESTA']
                : '',
            'carrera_primera_opcion' =>
                isset($ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][8]['RESPUESTAS'][0]['RESPUESTA'])
                ? $ficha_condicion_academica['SECCIONES'][0]['PREGUNTAS'][8]['RESPUESTAS'][0]['RESPUESTA']
                : '',
        ];
    }

    private function get_carrera_grupo($pk_grupo) {
        $sql = "
        SELECT
            CAT_CARRERA.NOMBRE AS CARRERA
        FROM
            CAT_USUARIO
            LEFT JOIN CAT_CARRERA ON CAT_USUARIO.FK_CARRERA = CAT_CARRERA.PK_CARRERA
        WHERE
            PK_USUARIO = (
                SELECT TOP 1 
                    FK_USUARIO 
                FROM 
                     TR_GRUPO_TUTORIA_DETALLE
                )
        ;";

        $result = Constantes::procesa_consulta_general($sql);
        if ($result) {
            $result = $result[0];
            return $result->CARRERA;
        } else {
            return false;
        }
    }

    private function get_cantidad_alumnos_grupo($pk_grupo) {
        $sql = "
        SELECT
            COUNT(*) AS CANTIDAD
        FROM
            TR_GRUPO_TUTORIA_DETALLE
        WHERE 
              FK_GRUPO = $pk_grupo
        ;";

        $result = Constantes::procesa_consulta_general($sql);
        if ($result) {
            $result = $result[0];
            return $result->CANTIDAD;
        } else {
            return false;
        }
    }

    private function get_tutor_grupo($pk_grupo) {
        $sql = "
        SELECT
            TR_GRUPO_TUTORIA.CLAVE,
            TR_GRUPO_TUTORIA.PERIODO,
            NOMBRE,
            PRIMER_APELLIDO,
            SEGUNDO_APELLIDO
        FROM
            TR_GRUPO_TUTORIA
            LEFT JOIN CAT_USUARIO ON TR_GRUPO_TUTORIA.FK_USUARIO = CAT_USUARIO.PK_USUARIO
        WHERE 
              PK_GRUPO_TUTORIA = $pk_grupo
              AND PERIODO = '".Constantes::get_periodo()."'
        ;";

        $result = Constantes::procesa_consulta_general($sql);
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
}
