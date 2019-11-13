<?php

namespace App\Helpers;

use App\Aplicacion_Encuesta;
use App\Encuesta;
use App\GrupoTutorias;
use App\GrupoTutoriasDetalle;
use App\Pregunta;
use App\Seccion_Encuesta;
use Illuminate\Support\Facades\DB;

/**
 * Class SITHelper
 * @package App\Helpers
 */
class SITHelper
{

    public static function habitos_estudio_grupo($pk_grupo) {
        $total = 0;
        $porcentajes_habitos_estudio = ['DT' => 0, 'ME' => 0, 'DE' => 0, 'NC' => 0, 'OL' => 0, 'PE' => 0, 'AC' => 0];
        $array_porcentajes = [];

        $detalle_grupo = GrupoTutoriasDetalle::where('FK_GRUPO', $pk_grupo)->get();
        $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $pk_grupo)->first();

        foreach ($detalle_grupo as $alumno) {
            $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $alumno->FK_USUARIO)
                ->where('PERIODO', $grupo->PERIODO)
                ->where('FK_ENCUESTA', Constantes::ENCUESTA_HABITOS_DE_ESTUDIO)
                ->first();


            $temp_porcentajes = self::get_porcentajes_habitos_estudio(
                self::reporte_habitos_estudio(
                    Constantes::ENCUESTA_HABITOS_DE_ESTUDIO,
                    $aplicacion->PK_APLICACION_ENCUESTA
                )
            );

            if ($temp_porcentajes['DT']) {
                $array_porcentajes[] = $temp_porcentajes;
                $total++;
            }
        }

        foreach ($array_porcentajes as $habitos_alumno) {
            $porcentajes_habitos_estudio['DT'] += $habitos_alumno['DT'];
            $porcentajes_habitos_estudio['ME'] += $habitos_alumno['ME'];
            $porcentajes_habitos_estudio['DE'] += $habitos_alumno['DE'];
            $porcentajes_habitos_estudio['NC'] += $habitos_alumno['NC'];
            $porcentajes_habitos_estudio['OL'] += $habitos_alumno['OL'];
            $porcentajes_habitos_estudio['PE'] += $habitos_alumno['PE'];
            $porcentajes_habitos_estudio['AC'] += $habitos_alumno['AC'];
        }

        $porcentajes_habitos_estudio['DT'] = $porcentajes_habitos_estudio['DT'] / $total;
        $porcentajes_habitos_estudio['ME'] = $porcentajes_habitos_estudio['ME'] / $total;
        $porcentajes_habitos_estudio['DE'] = $porcentajes_habitos_estudio['DE'] / $total;
        $porcentajes_habitos_estudio['NC'] = $porcentajes_habitos_estudio['NC'] / $total;
        $porcentajes_habitos_estudio['OL'] = $porcentajes_habitos_estudio['OL'] / $total;
        $porcentajes_habitos_estudio['PE'] = $porcentajes_habitos_estudio['PE'] / $total;
        $porcentajes_habitos_estudio['AC'] = $porcentajes_habitos_estudio['AC'] / $total;



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

    public static function factor_adaptabilidad_grupo($pk_grupo) {
        $sumatoria = 0;
        $total = 0;

        $detalle_grupo = GrupoTutoriasDetalle::where('FK_GRUPO', $pk_grupo)->get();
        $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $pk_grupo)->first();

        foreach ($detalle_grupo as $alumno) {
            $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $alumno->FK_USUARIO)
                ->where('PERIODO', $grupo->PERIODO)
                ->where('FK_ENCUESTA', Constantes::ENCUESTA_CONDICION_FAMILIAR)
                ->first();

            $reporte_condicion_familiar = self::reporte_condicion_familiar(
                Constantes::ENCUESTA_CONDICION_FAMILIAR,
                $aplicacion->PK_APLICACION_ENCUESTA
            );

            $sumatoria += $reporte_condicion_familiar['ADAPTABILIDAD'];

            $total++;
        }

        return ceil(($sumatoria / $total));
    }

    public static function factor_cohesion_grupo($pk_grupo) {
        $sumatoria = 0;
        $total = 0;

        $detalle_grupo = GrupoTutoriasDetalle::where('FK_GRUPO', $pk_grupo)->get();
        $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $pk_grupo)->first();

        foreach ($detalle_grupo as $alumno) {
            $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $alumno->FK_USUARIO)
                ->where('PERIODO', $grupo->PERIODO)
                ->where('FK_ENCUESTA', Constantes::ENCUESTA_CONDICION_FAMILIAR)
                ->first();

            $reporte_condicion_familiar = self::reporte_condicion_familiar(
                Constantes::ENCUESTA_CONDICION_FAMILIAR,
                $aplicacion->PK_APLICACION_ENCUESTA
            );

            $sumatoria += $reporte_condicion_familiar['COHESION'];

            $total++;
        }

        return ceil(($sumatoria / $total));
    }

    public static function condicion_socioeconomica_grupo($pk_grupo) {
        $sumatoria = 0;
        $total = 0;

        $detalle_grupo = GrupoTutoriasDetalle::where('FK_GRUPO', $pk_grupo)->get();
        $grupo = GrupoTutorias::where('PK_GRUPO_TUTORIA', $pk_grupo)->first();

        foreach ($detalle_grupo as $alumno) {
            $aplicacion = Aplicacion_Encuesta::where('FK_USUARIO', $alumno->FK_USUARIO)
                ->where('PERIODO', $grupo->PERIODO)
                ->where('FK_ENCUESTA', Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA)
                ->first();

            $sumatoria += self::reporte_condicion_socioeconomica(
                Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA,
                $aplicacion->PK_APLICACION_ENCUESTA
            );

            $total++;
        }

        return self::get_nivel_socioeconomico(ceil(($sumatoria / $total)));
    }

    public static function habilidades_grupo($pk_grupo, $range, $criterio_1 = "", $criterio_2 = "") {
        $response = [];

        $preguntas = Pregunta::whereRaw("PK_PREGUNTA IN ($range)")->get();
        foreach ($preguntas as $pregunta) {
            $sql = "
                SELECT
                    RESPUESTA                       AS RESPUESTA,
                    COUNT(FK_RESPUESTA_POSIBLE) / 4 AS CANTIDAD
                FROM
                    VW_RESPUESTA_ENCUESTA
                WHERE
                    PK_GRUPO_TUTORIA = $pk_grupo
                    AND PK_PREGUNTA  = $pregunta->PK_PREGUNTA
                GROUP BY
                    RESPUESTA
                ORDER BY
                    CANTIDAD
            ;";
            $respuestas = Constantes::procesa_consulta_general($sql);

            $respuestas_array = [];
            foreach ($respuestas as $respuesta){
                if ($respuesta->RESPUESTA == $criterio_1 || $respuesta->RESPUESTA == $criterio_2) {
                    $respuestas_array[] = (object)[
                        'RESPUESTA' => $respuesta->RESPUESTA,
                        'CANTIDAD'  => $respuesta->CANTIDAD
                    ];
                }
            }

            $response[] = (object)[
                'PLANTEAMIENTO' => $pregunta->PLANTEAMIENTO,
                'RESPUESTAS'    => $respuestas_array
            ];
        }

        return $response;
    }

    public static function pasatiempos_grupo($pk_grupo, $pk_pregunta) {
        $sql = "
            SELECT
                RESPUESTA            AS ETIQUETA,
                SUM(RESPUESTA_ORDEN) AS CANTIDAD
            FROM
                VW_RESPUESTA_ENCUESTA
            WHERE
                PK_GRUPO_TUTORIA = $pk_grupo
                AND PK_PREGUNTA = $pk_pregunta
            GROUP BY
                RESPUESTA,
                PK_RESPUESTA_POSIBLE
            ORDER BY
                CANTIDAD
        ;";

        return self::get_result($sql);
    }

    public static function respuestas_grupo($pk_grupo, $pk_pregunta) {
        $sql = "
            SELECT
                RESPUESTA_ABIERTA AS ETIQUETA
            FROM
                VW_RESPUESTA_ENCUESTA
            WHERE
                PK_GRUPO_TUTORIA = $pk_grupo
                AND PK_PREGUNTA = $pk_pregunta
                AND RESPUESTA_ABIERTA != '-'
            GROUP BY
                RESPUESTA_ABIERTA
        ;";

        return self::get_result($sql);
    }

    public static function promedio_pregunta_grupo($pk_grupo, $pk_pregunta) {
        $sql = "
            SELECT
                RESPUESTA AS ETIQUETA,
                COUNT(RESPUESTA) AS CANTIDAD
            FROM
                VW_RESPUESTA_ENCUESTA
            WHERE
                PK_GRUPO_TUTORIA = $pk_grupo
                AND PK_PREGUNTA  = $pk_pregunta 
            GROUP BY
                RESPUESTA
            ;";

        return self::get_promedios($sql);
    }

    public static function situacion_residencia_grupo($pk_grupo) {
        $sql = "
        SELECT
            CAT_SITUACION_RESIDENCIA.NOMBRE AS ETIQUETA,
            COUNT(FK_COLONIA) AS CANTIDAD
        FROM
            CAT_USUARIO
            RIGHT JOIN CAT_SITUACION_RESIDENCIA
                ON CAT_USUARIO.FK_SITUACION_RESIDENCIA = CAT_SITUACION_RESIDENCIA.PK_SITUACION_RESIDENCIA
        WHERE
            PK_USUARIO IN (
                SELECT
                    FK_USUARIO
                FROM
                    TR_GRUPO_TUTORIA_DETALLE
                WHERE
                    FK_GRUPO = $pk_grupo
            )
        GROUP BY
            CAT_SITUACION_RESIDENCIA.NOMBRE
        ;";

        return self::get_promedios($sql);
    }

    public static function colonias_grupo($pk_grupo) {
        $sql = "
        SELECT
            CAT_COLONIA.NOMBRE AS ETIQUETA,
            COUNT(FK_COLONIA) AS CANTIDAD
        FROM
            CAT_USUARIO
            RIGHT JOIN CAT_COLONIA
                ON CAT_USUARIO.FK_COLONIA = CAT_COLONIA.PK_COLONIA
        WHERE
            PK_USUARIO IN (
                SELECT
                    FK_USUARIO
                FROM
                    TR_GRUPO_TUTORIA_DETALLE
                WHERE
                    FK_GRUPO = $pk_grupo
            )
        GROUP BY
            CAT_COLONIA.NOMBRE
        ;";

        return self::get_result($sql);
    }

    public static function porcentaje_estado_civil_grupo($pk_grupo) {
        $sql = "
        SELECT
            CAT_ESTADO_CIVIL.NOMBRE AS ETIQUETA,
            COUNT(FK_ESTADO_CIVIL) AS CANTIDAD
        FROM
            CAT_USUARIO
            RIGHT JOIN CAT_ESTADO_CIVIL
                ON CAT_USUARIO.FK_ESTADO_CIVIL = CAT_ESTADO_CIVIL.PK_ESTADO_CIVIL
        WHERE
            PK_USUARIO IN (
                SELECT
                    FK_USUARIO
                FROM
                    TR_GRUPO_TUTORIA_DETALLE
                WHERE
                    FK_GRUPO = $pk_grupo
            )
        GROUP BY
            CAT_ESTADO_CIVIL.NOMBRE
        ;";

        return self::get_promedios($sql);
    }

    public static function porcentaje_sexo_grupo($pk_grupo) {
        $sql = "
        SELECT
            CASE
                WHEN SEXO = 1 THEN 'Masculino'
                WHEN SEXO = 2 THEN 'Femenino'
            END as ETIQUETA,
            COUNT(SEXO) AS CANTIDAD
        FROM
            CAT_USUARIO
        WHERE
            PK_USUARIO IN (
                SELECT
                    FK_USUARIO
                FROM
                    TR_GRUPO_TUTORIA_DETALLE
                WHERE
                    FK_GRUPO = $pk_grupo
            )
            AND SEXO IS NOT NULL
        GROUP BY
            SEXO;";

        return self::get_promedios($sql);
    }

    private static function get_promedios($sql, $array = null) {
        $result = Constantes::procesa_consulta_general($sql);
        $array_result = [];
        if ($result) {
            $total = 0;
            foreach ($result as $item) {
                $total += $item->CANTIDAD;
            }

            foreach ($result as $item){
                $item->PROMEDIO = number_format(
                    ($item->CANTIDAD / $total) * 100,
                    0
                );
                $array_result[] = $item;
            }
        }

        return $array_result;
    }

    private static function get_result($sql) {
        $result = Constantes::procesa_consulta_general($sql);
        return ($result) ? $result :  null;
    }

    /**
     * @param $habitos_estudio
     * @return array
     */
    public static function get_porcentajes_habitos_estudio($habitos_estudio) {
        return [
            'DT' => self::evalua_puntos($habitos_estudio['sumatoria_DT']),
            'ME' => self::evalua_puntos($habitos_estudio['sumatoria_ME']),
            'DE' => self::evalua_puntos($habitos_estudio['sumatoria_DE']),
            'NC' => self::evalua_puntos($habitos_estudio['sumatoria_NC']),
            'OL' => self::evalua_puntos($habitos_estudio['sumatoria_OL']),
            'PE' => self::evalua_puntos($habitos_estudio['sumatoria_PE']),
            'AC' => self::evalua_puntos($habitos_estudio['sumatoria_AC']),
        ];
    }

    private static function evalua_puntos($puntos_actividad) {
        if ($puntos_actividad > 0) {
            if ($puntos_actividad >= 0 && $puntos_actividad <= 3) {
                return 10;
            } else if ($puntos_actividad >= 4 && $puntos_actividad <= 6) {
                return 20;
            } else if ($puntos_actividad >= 7 && $puntos_actividad <= 9) {
                return 30;
            } else if ($puntos_actividad >= 10 && $puntos_actividad <= 12) {
                return 40;
            } else if ($puntos_actividad >= 13 && $puntos_actividad <= 15) {
                return 50;
            } else if ($puntos_actividad >= 16 && $puntos_actividad <= 18) {
                return 60;
            } else if ($puntos_actividad >= 19 && $puntos_actividad <= 21) {
                return 70;
            } else if ($puntos_actividad >= 22 && $puntos_actividad <= 24) {
                return 80;
            } else if ($puntos_actividad >= 25 && $puntos_actividad <= 27) {
                return 90;
            } else if ($puntos_actividad >= 28 && $puntos_actividad <= 30) {
                return 100;
            }
        }

        return null;
    }

    /**
     * @param $factor_cohesion
     * @return array
     */
    public static function get_datos_cohesion($factor_cohesion) {
        $nivel = '';
        $tipo = '';
        $explicacion = '';

        if ($factor_cohesion > 0) {
            if ($factor_cohesion > 0 && $factor_cohesion <= 12) {
                $nivel .= 'Cohesión baja';
                $tipo  = 'Desprendida o desapegada';
                $explicacion = '
                Familias con ausencia de unión afectiva y lealtad,
                lo primordial es el yo por lo que existe una alta independencia personal,
                es escaso el tiempo para convivir y por tanto el involucramiento o interacción
                entre los miembros, las decisiones son tomadas de manera independiente y los
                intereses son desiguales y se enfocan fuera de la familia.';
            }
            if ($factor_cohesion >= 13 && $factor_cohesion <= 25) {
                $nivel .= 'Cohesión moderada-baja';
                $tipo  = 'Separada';
                $explicacion = '
                Familias en que existe la separación emocional, aunque a veces se demuestra
                el afecto, la lealtad familiar es ocasional, el involucramiento se acepta,
                sin embargo se prefiere la distancia, hay una tendencia al yo, con presencia
                del nosotros, en la interacción se da la interdependencia con cierta
                tendencia a la independencia, el límite parento-filial es claro con cierto
                nivel de cercanía entre padres e hijos, las decisiones se toman
                individualmente habiendo posibilidad de realizarlas de manera conjunta, el
                interés se focaliza fuera de la familia y se prefieren espacios separados.';
            }
            if ($factor_cohesion >= 26 && $factor_cohesion <= 38){
                $nivel .= 'Cohesión moderada-alta';
                $tipo  = 'Unida o conectada';
                $explicacion = '
               Familias en que lo principal es el nosotros con presencia del yo, se
                presenta una considerable unión-afectiva y fidelidad entre sus integrantes,
                interdependencia con tendencia a la dependencia, los límites entre
                subsistemas son claros con cercanía parento-filial, el tiempo de convivencia
                juntos es importante, la separación es respetada pero poco valorada, las
                decisiones se toman preferentemente de manera conjunta y el interés se
                focaliza dentro de la familia.';
            }
            if ($factor_cohesion >= 39 && $factor_cohesion <= 50){
                $nivel .= 'Cohesión muy alta';
                $tipo  = 'Enredada o apegada';
                $explicacion = '
                Familias en que la cercanía emocional es extrema, el involucramiento
                simbiótico, los integrantes dependen unos de otros en todos los aspectos, no
                existen límites generacionales, el interés se focaliza dentro de la familia,
                se dan por mandato los intereses conjuntos, la lealtad se demanda hacia la
                familia, las coaliciones parento-filiales están presentes, la mayor parte
                del tiempo se convive juntos, hay falta de separación personal.';
            }
        }

        return [
            'nivel'        => $nivel,
            'tipo_familia' => $tipo,
            'explicacion'  => $explicacion,
        ];
    }

    public static function get_datos_adaptabilidad($factor_adaptabilidad) {
        $nivel = '';
        $tipo = '';
        $explicacion = '';

        if ($factor_adaptabilidad > 0) {
            if ($factor_adaptabilidad > 0 && $factor_adaptabilidad <= 12) {
                $nivel .= 'Adaptabilidad baja';
                $tipo  = 'Rígida';
                $explicacion = '
                En estas familias, el liderazgo es autoritario con control parental, los roles
                son fijos y definidos, la disciplina estricta, rígida y severa, los padres
                imponen las decisiones, las reglas se cumplen estrictamente y no existe la
                posibilidad del cambio.';
            }
            if ($factor_adaptabilidad >= 13 && $factor_adaptabilidad <= 25) {
                $nivel .= 'Adaptabilidad moderada-baja';
                $tipo  = 'Estructurada';
                $explicacion = '
                Familias en las que el liderazgo es autoritario en principio y algunas veces
                igualitario, los roles son compartidos, en cierto grado la disciplina es
                democrática, lo padres toman las decisiones, las reglas se cumplen firmemente y
                pocas veces cambian, es democrática y los cambios se dan cuando se solicitan.';
            }
            if ($factor_adaptabilidad >= 26 && $factor_adaptabilidad <= 38){
                $nivel .= 'Adaptabilidad moderada-alta';
                $tipo  = 'Flexible';
                $explicacion = '
                Es característico que en la familia se comparta el liderazgo y los roles, la
                disciplina es democrática, es común que se den los acuerdos en las decisiones,
                las reglas se cumplen con flexibilidad y pueden cambiar algunas, y se permiten
                los cambios cuando son necesarios.';
            }
            if ($factor_adaptabilidad >= 39 && $factor_adaptabilidad <= 50){
                $nivel .= 'Adaptabilidad muy alta';
                $tipo  = 'Caótica';
                $explicacion = '
                En este tipo de familias, el liderazgo es ineficaz o ausente, la disciplina poco
                severa e inconsistente en sus castigos, las decisiones de los padres son
                impulsivas, no se tiene claridad en los roles ni funciones, y los cambios son
                muy frecuentes en el sistema.';
            }
        }

        return [
            'nivel'        => $nivel,
            'tipo_familia' => $tipo,
            'explicacion'  => $explicacion,
        ];
    }

    public static function get_datos_funcionamiento_familiar($factor_cohesion, $factor_adaptabilidad) {
        $nivel = '';
        $explicacion = '';

        if ($factor_cohesion > 0 && $factor_adaptabilidad > 0) {
            if (
                (($factor_adaptabilidad    >= 26 && $factor_adaptabilidad <= 38)
                    && ($factor_cohesion   >= 13 && $factor_cohesion      <= 25))
                || (($factor_adaptabilidad >= 26 && $factor_adaptabilidad <= 38)
                    && ($factor_cohesion   >= 26 && $factor_cohesion      <= 38))
                || (($factor_adaptabilidad >= 13 && $factor_adaptabilidad <= 25)
                    && ($factor_cohesion   >= 13 && $factor_cohesion      <= 25))
                || (($factor_adaptabilidad >= 13 && $factor_adaptabilidad <= 25)
                    && ($factor_cohesion   >= 26 && $factor_cohesion      <= 38))
            ) {
                $nivel = 'Balanceado';
                $explicacion = '
                Los niveles de funcionamiento familiar balanceados ubica a aquellas de óptimo funcionamiento';
            }

            if (
                (($factor_adaptabilidad    >= 39 && $factor_adaptabilidad <= 50)
                    && ($factor_cohesion   >= 13 && $factor_cohesion      <= 25))
                || (($factor_adaptabilidad >= 39 && $factor_adaptabilidad <= 50)
                    && ($factor_cohesion   >= 26 && $factor_cohesion      <= 38))
                || (($factor_adaptabilidad >= 26 && $factor_adaptabilidad <= 38)
                    && ($factor_cohesion   >= 0 && $factor_cohesion       <= 12))
                || (($factor_adaptabilidad >= 26 && $factor_adaptabilidad <= 38)
                    && ($factor_cohesion   >= 39 && $factor_cohesion      <= 50))

                || (($factor_adaptabilidad >= 13 && $factor_adaptabilidad <= 25)
                    && ($factor_cohesion   >= 0 && $factor_cohesion       <= 12))
                || (($factor_adaptabilidad >= 13 && $factor_adaptabilidad <= 25)
                    && ($factor_cohesion   >= 39 && $factor_cohesion      <= 50))
                || (($factor_adaptabilidad >= 0 && $factor_adaptabilidad  <= 12)
                    && ($factor_cohesion   >= 13 && $factor_cohesion      <= 25))
                || (($factor_adaptabilidad >= 0 && $factor_adaptabilidad  <= 12)
                    && ($factor_cohesion   >= 26 && $factor_cohesion      <= 38))
            ) {
                $nivel = 'Rango medio';
                $explicacion = '
                En el nivel de rango medio se presentan familias cuya dinámica es extrema 
                en una sola dimensión, sea en adaptabilidad o en cohesión, 
                generalmente debido a situaciones de estrés.';
            }

            if (
                (($factor_adaptabilidad    >= 39 && $factor_adaptabilidad <= 50)
                    && ($factor_cohesion   >= 0 && $factor_cohesion       <= 12))
                || (($factor_adaptabilidad >= 39 && $factor_adaptabilidad <= 50)
                    && ($factor_cohesion   >= 39 && $factor_cohesion      <= 50))
                || (($factor_adaptabilidad >= 0 && $factor_adaptabilidad  <= 12)
                    && ($factor_cohesion   >= 0 && $factor_cohesion       <= 12))
                || (($factor_adaptabilidad >= 0 && $factor_adaptabilidad  <= 12)
                    && ($factor_cohesion   >= 39 && $factor_cohesion      <= 50))
            ) {
                $nivel = 'Extremo';
                $explicacion = '
                En los niveles extremos se ubican familias en situación de dificultad, 
                y en la cohesión se encuentran de tipo desprendida-enredada 
                y en la adaptabilidad caótica-rígida.';
            }
        }

        return [
            'nivel'        => $nivel,
            'explicacion'  => $explicacion,
        ];
    }

    /**
     * @param $nivel_numerico
     * @return string
     */
    public static function get_nivel_socioeconomico($nivel_numerico) {
        if ($nivel_numerico > 0 && $nivel_numerico <= 32)
            return 'E';
        if ($nivel_numerico > 33 && $nivel_numerico <= 79)
            return 'D';
        if ($nivel_numerico > 80 && $nivel_numerico <= 104)
            return 'D+';
        if ($nivel_numerico > 105 && $nivel_numerico <= 127)
            return 'C-';
        if ($nivel_numerico > 128 && $nivel_numerico <= 154)
            return 'C';
        if ($nivel_numerico > 155 && $nivel_numerico <= 192)
            return 'C+';
        if ($nivel_numerico > 193)
            return 'AB';
    }
    /**
     * @param $pk_encuesta
     * @param $pk_aplicacion
     * @return array
     */
    public static function reporte_factores_personalidad($pk_encuesta, $pk_aplicacion)
    {
        $array_A  = [200, 223, 224, 248, 249, 273, 298, 323, 348, 373];
        $array_C  = [201, 202, 226, 227, 252, 276, 277, 301, 302, 326, 327, 351, 376];
        $array_F  = [205, 230, 255, 279, 280, 304, 305, 329, 330, 354, 355, 379, 380];
        $array_H  = [207, 232, 233, 257, 258, 282, 283, 307, 308, 332, 333, 358, 383];
        $array_L  = [210, 235, 260, 261, 285, 286, 310, 311, 336, 361];
        $array_N  = [213, 214, 238, 239, 263, 264, 289, 314, 339, 364];
        $array_Q1 = [217, 218, 242, 243, 267, 292, 317, 342, 366, 367];
        $array_Q3 = [220, 221, 245, 270, 295, 320, 345, 344, 369, 370];
        $array_B  = [225, 250, 251, 274, 275, 299, 300, 324, 325, 349, 350, 374, 375];
        $array_E  = [203, 204, 228, 229, 253, 254, 278, 303, 328, 352, 353, 377, 378];
        $array_G  = [206, 231, 256, 281, 306, 331, 356, 357, 381, 382];
        $array_I  = [208, 209, 234, 259, 284, 309, 334, 335, 359, 360];
        $array_M  = [211, 212, 236, 237, 262, 287, 288, 312, 313, 337, 338, 362, 363];
        $array_O = [215, 216, 240, 241, 265, 266, 290, 291, 315, 316, 340, 341, 365];
        $array_Q2 = [219, 244, 268, 269, 293, 294, 318, 319, 343, 368];
        $array_Q4 = [222, 246, 247, 271, 272, 296, 297, 321, 322, 346, 347, 371, 372];

        $sumatoria_A  = 0;
        $sumatoria_C  = 0;
        $sumatoria_F  = 0;
        $sumatoria_H  = 0;
        $sumatoria_L  = 0;
        $sumatoria_N  = 0;
        $sumatoria_Q1 = 0;
        $sumatoria_Q3 = 0;
        $sumatoria_B  = 0;
        $sumatoria_E  = 0;
        $sumatoria_G  = 0;
        $sumatoria_I  = 0;
        $sumatoria_M  = 0;
        $sumatoria_O = 0;
        $sumatoria_Q2 = 0;
        $sumatoria_Q4 = 0;

        $cuestionario = Encuesta::where('PK_ENCUESTA', $pk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);

                    if (in_array($pregunta->PK_PREGUNTA, $array_A)) {
                        $sumatoria_A += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_C)) {
                        $sumatoria_C += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_F)) {
                        $sumatoria_F += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_H)) {
                        $sumatoria_H += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_L)) {
                        $sumatoria_L += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_N)) {
                        $sumatoria_N += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q1)) {
                        $sumatoria_Q1 += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q3)) {
                        $sumatoria_Q3 += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_B)) {
                        $sumatoria_B += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_E)) {
                        $sumatoria_E += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_G)) {
                        $sumatoria_G += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_I)) {
                        $sumatoria_I += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_M)) {
                        $sumatoria_M += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_O)) {
                        $sumatoria_O += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q2)) {
                        $sumatoria_Q2 += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_Q4)) {
                        $sumatoria_Q4 += $respuestas->SUMATORIA;
                    }
                }
            }
        }

        return [
            'sumatoria_A' =>  $sumatoria_A,
            'sumatoria_C' =>  $sumatoria_C,
            'sumatoria_F' =>  $sumatoria_F,
            'sumatoria_H' =>  $sumatoria_H,
            'sumatoria_L' =>  $sumatoria_L,
            'sumatoria_N' =>  $sumatoria_N,
            'sumatoria_Q1' => $sumatoria_Q1,
            'sumatoria_Q3' => $sumatoria_Q3,
            'sumatoria_B' =>  $sumatoria_B,
            'sumatoria_E' =>  $sumatoria_E,
            'sumatoria_G' =>  $sumatoria_G,
            'sumatoria_I' =>  $sumatoria_I,
            'sumatoria_M' =>  $sumatoria_M,
            'sumatoria_O' =>  $sumatoria_O,
            'sumatoria_Q2' => $sumatoria_Q2,
            'sumatoria_Q4' => $sumatoria_Q4

            /*'sumatoria_A' =>  $this->evalua_factor($sumatoria_A, 'A'),
            'sumatoria_C' =>  $this->evalua_factor($sumatoria_C, 'C'),
            'sumatoria_F' =>  $this->evalua_factor($sumatoria_F, 'F'),
            'sumatoria_H' =>  $this->evalua_factor($sumatoria_H, 'H'),
            'sumatoria_L' =>  $this->evalua_factor($sumatoria_L, 'L'),
            'sumatoria_N' =>  $this->evalua_factor($sumatoria_N, 'N'),
            'sumatoria_Q1' => $this->evalua_factor($sumatoria_Q1, 'Q1'),
            'sumatoria_Q3' => $this->evalua_factor($sumatoria_Q3, 'Q3'),
            'sumatoria_B' =>  $this->evalua_factor($sumatoria_B, 'B'),
            'sumatoria_E' =>  $this->evalua_factor($sumatoria_E, 'E'),
            'sumatoria_G' =>  $this->evalua_factor($sumatoria_G, 'G'),
            'sumatoria_I' =>  $this->evalua_factor($sumatoria_I, 'I'),
            'sumatoria_M' =>  $this->evalua_factor($sumatoria_M, 'M'),
            'sumatoria_O' =>  $this->evalua_factor($sumatoria_O, 'O'),
            'sumatoria_Q2' => $this->evalua_factor($sumatoria_Q2, 'Q2'),
            'sumatoria_Q4' => $this->evalua_factor($sumatoria_Q4, 'Q4')*/
        ];
    }

    /**
     * @param $sumatoria
     * @param $factor
     * @return int
     */
    private function evalua_factor($sumatoria, $factor) {
        switch ($factor) {
            case 'A':
                if ($sumatoria >= 0 && $sumatoria <= 3) return 1;
                if ($sumatoria >= 4 && $sumatoria <= 5) return 2;
                if ($sumatoria >= 6 && $sumatoria <= 7) return 3;
                if ($sumatoria == 8) return 4;
                if ($sumatoria >= 9 && $sumatoria <= 10) return 5;
                if ($sumatoria >= 11 && $sumatoria <= 12) return 6;
                if ($sumatoria == 13) return 7;
                if ($sumatoria >= 14 && $sumatoria <= 15) return 8;
                if ($sumatoria == 16) return 9;
                if ($sumatoria >= 18 && $sumatoria <= 20) return 10;
            case 'C':
                if ($sumatoria >= 0 && $sumatoria <= 1) return 1;
                if ($sumatoria == 2) return 2;
                if ($sumatoria >= 3 && $sumatoria <= 4) return 3;
                if ($sumatoria == 5) return 4;
                if ($sumatoria == 6) return 5;
                if ($sumatoria == 7) return 6;
                if ($sumatoria == 8) return 7;
                // if ($sumatoria == 9) return 8;
                if ($sumatoria == 9) return 9;
                if ($sumatoria >= 10 && $sumatoria <= 13) return 10;
            case 'F':
                if ($sumatoria >= 0 && $sumatoria <= 3) return 1;
                if ($sumatoria >= 4 && $sumatoria <= 5) return 2;
                if ($sumatoria >= 6 && $sumatoria <= 7) return 3;
                if ($sumatoria == 8) return 4;
                if ($sumatoria >= 9 && $sumatoria <= 10) return 5;
                if ($sumatoria >= 11 && $sumatoria <= 12) return 6;
                if ($sumatoria == 13) return 7;
                if ($sumatoria >= 14 && $sumatoria <= 15) return 8;
                if ($sumatoria == 16) return 9;
                if ($sumatoria >= 18 && $sumatoria <= 20) return 10;
            case 'H': break;
            case 'L': break;
            case 'N': break;
            case 'Q1': break;
            case 'Q2': break;
            case 'B': break;
            case 'E': break;
            case 'G': break;
            case 'I': break;
            case 'M': break;
            case 'O': break;
            case 'Q2': break;
            case 'Q4': break;
        }
    }

    /**
     * @param $pk_encuesta
     * @param $pk_aplicacion
     * @return array
     */
    public static function reporte_habitos_estudio($pk_encuesta, $pk_aplicacion)
    {
        $array_DT = [97, 104, 111, 118, 125, 132, 139, 146, 153, 160];
        $sumatoria_DT = false;

        $array_ME = [98, 105, 112, 119, 126, 133, 140, 147, 154, 161];
        $sumatoria_ME = false;

        $array_DE = [99, 106, 113, 120, 127, 134, 141, 148, 155, 162];
        $sumatoria_DE = false;

        $array_NC = [100, 107, 114, 121, 128, 135, 142, 149, 156, 163];
        $sumatoria_NC = false;

        $array_OL = [101, 108, 115, 122, 129, 136, 143, 150, 157, 164];
        $sumatoria_OL = false;

        $array_PE = [102, 109, 116, 123, 130, 137, 144, 151, 158, 165];
        $sumatoria_PE = false;

        $array_AC = [103, 110, 117, 124, 131, 138, 145, 152, 159, 166];
        $sumatoria_AC = false;

        $cuestionario = Encuesta::where('PK_ENCUESTA', $pk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);

                    if (in_array($pregunta->PK_PREGUNTA, $array_DT)) {
                        $sumatoria_DT += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_ME)) {
                        $sumatoria_ME += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_DE)) {
                        $sumatoria_DE += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_NC)) {
                        $sumatoria_NC += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_OL)) {
                        $sumatoria_OL += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_PE)) {
                        $sumatoria_PE += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_AC)) {
                        $sumatoria_AC += $respuestas->SUMATORIA;
                    }
                }
            }
        }

        return [
            'sumatoria_DT' => $sumatoria_DT,
            'sumatoria_ME' => $sumatoria_ME,
            'sumatoria_DE' => $sumatoria_DE,
            'sumatoria_NC' => $sumatoria_NC,
            'sumatoria_OL' => $sumatoria_OL,
            'sumatoria_PE' => $sumatoria_PE,
            'sumatoria_AC' => $sumatoria_AC
        ];
    }

    /**
     * @param $pk_encuesta
     * @param $pk_aplicacion
     * @return array
     */
    public static function reporte_condicion_familiar($pk_encuesta, $pk_aplicacion)
    {
        $array_cohesion = [77, 80, 83, 85, 86, 89, 91, 93, 94, 96];
        $sumatoria_cohesion = 0;

        $array_adaptabilidad = [78, 79, 81, 82, 84, 87, 88, 90, 92, 95];
        $sumatoria_adaptabilidad = 0;
        $cuestionario = Encuesta::where('PK_ENCUESTA', $pk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);
                    if (in_array($pregunta->PK_PREGUNTA, $array_cohesion)) {
                        $sumatoria_cohesion += $respuestas->SUMATORIA;
                    }

                    if (in_array($pregunta->PK_PREGUNTA, $array_adaptabilidad)) {
                        $sumatoria_adaptabilidad += $respuestas->SUMATORIA;
                    }
                }
            }
        }

        return [
            'COHESION' => $sumatoria_cohesion,
            'ADAPTABILIDAD' => $sumatoria_adaptabilidad
        ];
    }

    /**
     * @param $pk_encuesta
     * @param $pk_aplicacion
     * @return int
     */
    public static function reporte_condicion_socioeconomica($pk_encuesta, $pk_aplicacion)
    {
        $sumatoria = 0;
        $cuestionario = Encuesta::where('PK_ENCUESTA', $pk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                foreach ($preguntas as $pregunta) {
                    //consultar respuesta de usuario
                    $sql = "SELECT
                                SUM(CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO) AS SUMATORIA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                                AND CAT_RESPUESTA_POSIBLE.VALOR_NUMERICO IS NOT NULL
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql, false);
                    $sumatoria += $respuestas->SUMATORIA;
                }
            }
        }

        return $sumatoria;
    }

    /**
     * @param $pk_encuesta
     * @param $pk_aplicacion
     * @param null $cantidad_preguntas
     * @return array
     */
    public static function get_cuestionario_resuelto($pk_encuesta, $pk_aplicacion, $cantidad_preguntas = null)
    {
        $array_secciones = array();
        $cuestionario = Encuesta::where('PK_ENCUESTA', $pk_encuesta)->first();
        if ($cuestionario) {
            $secciones = Seccion_Encuesta::where('FK_ENCUESTA', $cuestionario->PK_ENCUESTA)->get();
            foreach ($secciones as $seccion) {
                $array_preguntas = array();
                $preguntas = DB::table('CAT_PREGUNTA')
                    ->leftJoin('CAT_TIPO_PREGUNTA', 'CAT_TIPO_PREGUNTA.PK_TIPO_PREGUNTA', '=', 'CAT_PREGUNTA.FK_TIPO_PREGUNTA')
                    ->where('FK_SECCION', $seccion->PK_SECCION)
                    ->get();
                $contador = 0;
                foreach ($preguntas as $pregunta) {
                    $contador++;

                    //consultar respuesta de usuario
                    $sql = "SELECT
                                PK_RESPUESTA_POSIBLE,
                                FK_PREGUNTA,
                                RESPUESTA,
                                TR_RESPUESTA_USUARIO_ENCUESTA.RESPUESTA_ABIERTA AS ABIERTA,
                                VALOR_NUMERICO,
                                MINIMO,
                                MAXIMO,
                                TR_RESPUESTA_USUARIO_ENCUESTA.ORDEN,
                                ES_MIXTA
                            FROM
                                TR_RESPUESTA_USUARIO_ENCUESTA
                                LEFT JOIN CAT_RESPUESTA_POSIBLE
                                    ON TR_RESPUESTA_USUARIO_ENCUESTA.FK_RESPUESTA_POSIBLE = CAT_RESPUESTA_POSIBLE.PK_RESPUESTA_POSIBLE
                            WHERE
                                FK_APLICACION_ENCUESTA = $pk_aplicacion
                                AND FK_PREGUNTA = $pregunta->PK_PREGUNTA
                            ORDER BY
                                TR_RESPUESTA_USUARIO_ENCUESTA.ORDEN ASC
                            ;";
                    $respuestas = Constantes::procesa_consulta_general($sql);
                    $array_respuestas = array();
                    if ($respuestas) {
                        if ($cantidad_preguntas)
                            if ($cantidad_preguntas == $contador)
                                break;
                        foreach ($respuestas as $respuesta) {
                            $array_respuestas[] = array(
                                'PK_RESPUESTA_POSIBLE' => $respuesta->PK_RESPUESTA_POSIBLE,
                                'FK_PREGUNTA' => $respuesta->FK_PREGUNTA,
                                'RESPUESTA' => $respuesta->RESPUESTA,
                                'ABIERTA' => $respuesta->ABIERTA,
                                'VALOR_NUMERICO' => $respuesta->VALOR_NUMERICO,
                                'MINIMO' => $respuesta->MINIMO,
                                'MAXIMO' => $respuesta->MAXIMO,
                                'ORDEN' => $respuesta->ORDEN,
                                'ES_MIXTA' => $respuesta->ES_MIXTA
                            );
                        }
                    }
                    $array_preguntas[] = array(
                        'PK_PREGUNTA' => $pregunta->PK_PREGUNTA,
                        'FK_SECCION' => $pregunta->FK_SECCION,
                        'ORDEN' => $pregunta->ORDEN,
                        'PLANTEAMIENTO' => $pregunta->PLANTEAMIENTO,
                        'TEXTO_GUIA' => $pregunta->TEXTO_GUIA,
                        'FK_TIPO_PREGUNTA' => $pregunta->FK_TIPO_PREGUNTA,
                        'NOMBRE_TIPO_PREGUNTA' => $pregunta->NOMBRE_TIPO_PREGUNTA,
                        'RESPUESTAS' => $array_respuestas
                    );
                }
                $array_secciones[] = array(
                    'PK_SECCION' => $seccion->PK_SECCION,
                    'FK_ENCUESTA' => $seccion->FK_ENCUESTA,
                    'NOMBRE' => $seccion->NOMBRE,
                    'NUMERO' => $seccion->NUMERO,
                    'ORDEN' => $seccion->ORDEN,
                    'OBJETIVO' => $seccion->OBJETIVO,
                    'INSTRUCCIONES' => $seccion->INSTRUCCIONES,
                    'PREGUNTAS' => $array_preguntas
                );
            }
            $cuestionario_completo = array(
                'PK_ENCUESTA' => $cuestionario->PK_ENCUESTA,
                'NOMBRE' => $cuestionario->NOMBRE,
                'OBJETIVO' => $cuestionario->OBJETIVO,
                'INSTRUCCIONES' => $cuestionario->INSTRUCCIONES,
                'FUENTE_CITA' => $cuestionario->FUENTE_CITA,
                'ES_ADMINISTRABLE' => $cuestionario->ES_ADMINISTRABLE,
                'SECCIONES' => $array_secciones
            );
        }

        return $cuestionario_completo;
    }
}
