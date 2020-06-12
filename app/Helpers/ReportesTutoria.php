<?php

namespace App\Helpers;

/**
 * Class ReportesTutoria
 * @package App\Helpers
 */
class ReportesTutoria
{
    /*public static function test_reporte()
    {
        // PASATIEMPOS - 1
        $sql = self::sql_pasatiempos(
            '20192',
            Constantes::ENCUESTA_PASATIEMPOS,
            [
                // 'area_academica' => 1, // 1
                // 'carrera' => 5,
                // 'grupo' => 1,
            ]
        );
    }*/

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo
     * @return array|bool
     */
    public static function reporte_datos_personales($periodo, $data)
    {
        /* DATOS PERSONALES */
        return [
            'sexo' => Constantes::procesa_consulta_general(
                $sql = self::sql_datos_personales($periodo, 'SEXO', $data),
                true
            ),
            'edad' => Constantes::procesa_consulta_general(
                $sql = self::sql_datos_personales($periodo, 'EDAD', $data),
                true
            ),
            'estado_civil' => Constantes::procesa_consulta_general(
                $sql = self::sql_datos_personales($periodo, 'ESTADO_CIVL', $data),
                true
            ),
            'colonia' => Constantes::procesa_consulta_general(
                $sql = self::sql_datos_personales($periodo, 'COLONIA', $data),
                true
            ),
            'situacion_residencia' => Constantes::procesa_consulta_general(
                $sql = self::sql_datos_personales($periodo, 'SITUACION_RESIDENCIA', $data),
                true
            )
        ];
    }

    /**
     * @param $periodo
     * @param $columna
     * @param $data
     * @return string
     */
    private static function sql_datos_personales($periodo, $columna, $data) {
        $sql = "
            SELECT $columna as ITEM, COUNT(*) AS CANTIDAD
            FROM VW_REPORTE_DATOS_PERSONALES
            WHERE PERIODO = '$periodo' ";

        $sql .=
            (isset($data['area_academica']) && $data['area_academica'])
                ? " AND PK_AREA_ACADEMICA = " . $data['area_academica']
                : "";
        $sql .=
            (isset($data['carrera']) && $data['carrera'])
                ? " AND PK_CARRERA = " . $data['carrera'] :
                "";
        $sql .=
            (isset($data['grupo']) && $data['grupo'])
                ? " AND PK_GRUPO_TUTORIA = " . $data['grupo']
                : "";
        $sql .= "
            GROUP BY $columna ORDER BY CANTIDAD DESC ";

        return $sql;
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array|bool
     */
    public static function reporte_pasatiempos($periodo, $data)
    {
        /* PASATIEMPOS - 1 */
        return Constantes::procesa_consulta_general(
            $sql = self::sql_pasatiempos($periodo, Constantes::ENCUESTA_PASATIEMPOS, $data),
            true
        );
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array|bool
     */
    public static function reporte_salud($periodo, $data)
    {
        /* SALUD - 2 */
        return Constantes::procesa_consulta_general(
            $sql = self::sql_respuestas($periodo, Constantes::ENCUESTA_SALUD, $data),
            true
        );
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array|bool
     */
    public static function reporte_ficha_socioeconomico($periodo, $data)
    {
        /* NIVEL SOCIOECONOMICO - 3 */
        return Constantes::procesa_consulta_general(
            $sql = self::sql_respuestas($periodo, Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA, $data),
            true
        );
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array|bool
     */
    public static function reporte_nivel_socioeconomico($periodo, $data)
    {
        /* NIVEL SOCIOECONOMICO - 3 */
        return Constantes::procesa_consulta_general(
            $sql = self::sql_nivel_socioeconomico(
                $periodo,
                Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA,
                $data
            ),
            true
        );
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array|bool
     */
    public static function reporte_academica($periodo, $data)
    {
        /* CONDICION ACADÉMICA - 4 */
        return Constantes::procesa_consulta_general(
            $sql = self::sql_respuestas($periodo, Constantes::ENCUESTA_CONDICION_ACADEMICA, $data),
            true
        );
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array|bool
     */
    public static function reporte_ficha_familiar($periodo, $data)
    {
        /* FICHA CONDICION FAMILIAR - 5 */
        return Constantes::procesa_consulta_general(
            $sql = self::sql_respuestas($periodo, Constantes::ENCUESTA_CONDICION_FAMILIAR, $data),
            true
        );
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array
     */
    public static function reporte_tipo_familia($periodo, $data)
    {
        /* CONDICION FAMILIAR TIPO FAMILIA - 5 */
        return [
            'cohesion' =>
                Constantes::procesa_consulta_general(
                    $sql = self::sql_tipo_familia(
                        $periodo,
                        Constantes::ENCUESTA_CONDICION_FAMILIAR,
                        1, // cohesion
                        $data
                    ),
                    true
                ),
            'adaptabilidad' => Constantes::procesa_consulta_general(
                $sql = self::sql_tipo_familia(
                    $periodo,
                    Constantes::ENCUESTA_CONDICION_FAMILIAR,
                    2, // adaptabilidad
                    $data
                ),
                true
            ),
        ];
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array
     */
    public static function reporte_habitos($periodo, $data)
    {
        /* HABITOS DE ESTUDIO - 6 */
        return self::get_habitos($periodo, Constantes::ENCUESTA_HABITOS_DE_ESTUDIO, $data);
    }

    /**
     * @param $periodo
     * @param $data | null, area_academica, carrera, grupo, usuario
     * @return array
     */
    public static function reporte_16pf($periodo, $data)
    {
        /* 16 PF - 8 */
        return self::get_16pf($periodo, Constantes::ENCUESTA_16_PF, $data);
    }

    /* FUNCIONES PRIVADAS */

    /**
     * @param $periodo
     * @param $encuesta
     * @param $data
     * @return array
     */
    private static function get_16pf($periodo, $encuesta, $data)
    {
        return [
            'A' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 1, $data), false),
            'B' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 2, $data), false),
            'C' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 3, $data), false),
            'E' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 4, $data), false),
            'F' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 5, $data), false),
            'G' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 6, $data), false),
            'H' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 7, $data), false),
            'I' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 8, $data), false),
            'L' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 9, $data), false),
            'M' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 10, $data), false),
            'N' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 11, $data), false),
            'O' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 12, $data), false),
            'Q1' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 13, $data), false),
            'Q2' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 14, $data), false),
            'Q3' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 15, $data), false),
            'Q4' => Constantes::procesa_consulta_general(
                self::sql_16pf($periodo, $encuesta, 16, $data), false),
        ];
    }

    /**
     * @param $periodo
     * @param $encuesta
     * @param $factor
     * @param $data
     * @return string
     */
    private static function sql_16pf($periodo, $encuesta, $factor, $data)
    {
        switch ($factor) {
            case 1: // A - Expresión emocional
                $preguntas = " AND PK_PREGUNTA IN (200, 223, 224, 248, 249, 273, 298, 323, 348, 373) ";
                $abreviatura = 'A'; $descripcion = 'Expresión emocional';
                break;
            case 2: // B - Inteligencia
                $preguntas = " AND PK_PREGUNTA IN (225, 250, 251, 274, 275, 299, 300, 324, 325, 349, 350, 374, 375) ";
                $abreviatura = 'B'; $descripcion = 'Inteligencia';
                break;
            case 3: // C - Fuerza del yo
                $preguntas = " AND PK_PREGUNTA IN (201, 202, 226, 227, 252, 276, 277, 301, 302, 326, 327, 351, 376) ";
                $abreviatura = 'C'; $descripcion = 'Fuerza del yo';
                break;
            case 4: // E - Dominancia
                $preguntas = " AND PK_PREGUNTA IN (203, 204, 228, 229, 253, 254, 278, 303, 328, 352, 353, 377, 378) ";
                $abreviatura = 'E'; $descripcion = 'Dominancia';
                break;
            case 5: // F - Impulsividad
                $preguntas = " AND PK_PREGUNTA IN (205, 230, 255, 279, 280, 304, 305, 329, 330, 354, 355, 379, 380) ";
                $abreviatura = 'F'; $descripcion = 'Impulsividad';
                break;
            case 6: // G - Lealtad grupal
                $preguntas = " AND PK_PREGUNTA IN (206, 231, 256, 281, 306, 331, 356, 357, 381, 382) ";
                $abreviatura = 'G'; $descripcion = 'Lealtad grupal';
                break;
            case 7: // H - Aptitud situacional
                $preguntas = " AND PK_PREGUNTA IN (207, 232, 233, 257, 258, 282, 283, 307, 308, 332, 333, 358, 383) ";
                $abreviatura = 'H'; $descripcion = 'Aptitud situacional';
                break;
            case 8: // I - Emotividad
                $preguntas = " AND PK_PREGUNTA IN (208, 209, 234, 259, 284, 309, 334, 335, 359, 360) ";
                $abreviatura = 'I'; $descripcion = 'Emotividad';
                break;
            case 9: // L - Credibilidad
                $preguntas = " AND PK_PREGUNTA IN (210, 235, 260, 261, 285, 286, 310, 311, 336, 361) ";
                $abreviatura = 'L'; $descripcion = 'Credibilidad';
                break;
            case 10: // M - Actitud cognocitiva
                $preguntas = " AND PK_PREGUNTA IN (211, 212, 236, 237, 262, 287, 288, 312, 313, 337, 338, 362, 363) ";
                $abreviatura = 'M'; $descripcion = 'Actitud cognocitiva';
                break;
            case 11: // N - Sutileza
                $preguntas = " AND PK_PREGUNTA IN (213, 214, 238, 239, 263, 264, 289, 314, 339, 364) ";
                $abreviatura = 'N'; $descripcion = 'Sutileza';
                break;
            case 12: // O - Conciencia
                $preguntas = " AND PK_PREGUNTA IN (215, 216, 240, 241, 265, 266, 290, 291, 315, 316, 340, 341, 365) ";
                $abreviatura = 'O'; $descripcion = 'Conciencia';
                break;
            case 13: // Q1 - Posición social
                $preguntas = " AND PK_PREGUNTA IN (217, 218, 242, 243, 267, 292, 317, 342, 366, 367) ";
                $abreviatura = 'Q1'; $descripcion = 'Posición social';
                break;
            case 14: // Q2 - Certeza individual
                $preguntas = " AND PK_PREGUNTA IN (219, 244, 268, 269, 293, 294, 318, 319, 343, 368) ";
                $abreviatura = 'Q2'; $descripcion = 'Certeza individual';
                break;
            case 15: // Q3 - Autoestima
                $preguntas = " AND PK_PREGUNTA IN (220, 221, 245, 270, 295, 320, 345, 344, 369, 370) ";
                $abreviatura = 'Q3'; $descripcion = 'Autoestima';
                break;
            case 16: // Q4 - Estado de ansiedad
                $preguntas = " AND PK_PREGUNTA IN (222, 246, 247, 271, 272, 296, 297, 321, 322, 346, 347, 371, 372) ";
                $abreviatura = 'Q4'; $descripcion = 'Estado de ansiedad';
                break;
        }

        $sql = "
        SELECT
            '$abreviatura' AS ABREVIATURA,
            '$descripcion' AS DESCRIPCION,
            SUM(PUNTOS) AS PUNTOS,
            COUNT(PUNTOS) AS TOTAL,
            (SUM(PUNTOS)*10.00 / COUNT(PUNTOS))/10  AS PORCENTAJE
        FROM
            (SELECT
                SUM(VALOR_NUMERICO) AS PUNTOS
                FROM
                    VW_RESPUESTA_ENCUESTA
                WHERE
                    PERIODO = '$periodo'
                    AND PK_ENCUESTA = $encuesta " . $preguntas;

        $sql .=
            (isset($data['area_academica']) && $data['area_academica'])
                ? " AND PK_AREA_ACADEMICA = " . $data['area_academica']
                : "";
        $sql .=
            (isset($data['carrera']) && $data['carrera'])
                ? " AND PK_CARRERA = " . $data['carrera'] :
                "";
        $sql .=
            (isset($data['grupo']) && $data['grupo'])
                ? " AND PK_GRUPO_TUTORIA = " . $data['grupo']
                : "";
        $sql .=
            (isset($data['usuario']) && $data['usuario'])
                ? " AND PK_USUARIO = " . $data['usuario']
                : "";

        $sql .= " GROUP BY ";

        if (isset($data['area_academica']) && $data['area_academica']) {
            $sql .= " PK_AREA_ACADEMICA, ";
        }
        if (isset($data['carrera']) && $data['carrera']) {
            $sql .= " PK_CARRERA, ";
        }
        if (isset($data['grupo']) && $data['grupo']) {
            $sql .= " PK_GRUPO_TUTORIA, ";
        }

        $sql .= "PERIODO, PK_USUARIO, PK_ENCUESTA) as QUERY; ";

        return $sql;
    }

    /**
     * @param $periodo
     * @param $encuesta
     * @param $data
     * @return array
     */
    private static function get_habitos($periodo, $encuesta, $data)
    {
        return [
            Constantes::procesa_consulta_general(
                self::sql_habitos_estudio($periodo, $encuesta, 1, $data), false
            ),
            Constantes::procesa_consulta_general(
                self::sql_habitos_estudio($periodo, $encuesta, 2, $data), false
            ),
            Constantes::procesa_consulta_general(
                self::sql_habitos_estudio($periodo, $encuesta, 3, $data), false
            ),
            Constantes::procesa_consulta_general(
                self::sql_habitos_estudio($periodo, $encuesta, 4, $data),false
            ),
            Constantes::procesa_consulta_general(
                self::sql_habitos_estudio($periodo, $encuesta, 5, $data),false
            ),
            Constantes::procesa_consulta_general(
                self::sql_habitos_estudio($periodo, $encuesta, 6, $data),false
            ),
            Constantes::procesa_consulta_general(
                self::sql_habitos_estudio($periodo, $encuesta, 7, $data),false
            ),
        ];
    }

    /**
     * @param $periodo
     * @param $encuesta
     * @param $habito
     * @param $data
     * @return string
     */
    private static function sql_habitos_estudio($periodo, $encuesta, $habito, $data)
    {
        switch ($habito) {
            case 1: // Distribución del tiempo
                $preguntas = " AND PK_PREGUNTA IN (97, 104, 111, 118, 125, 132, 139, 146, 153, 160)  ";
                $abreviatura = 'DT'; $descripcion = 'Distribución del tiempo';
                break;
            case 2: // Motivación para el estudio
                $preguntas = " AND PK_PREGUNTA IN (98, 105, 112, 119, 126, 133, 140, 147, 154, 161)  ";
                $abreviatura = 'ME'; $descripcion = 'Motivación para el estudio';
                break;
            case 3: // Distractores durante el estudio
                $preguntas = " AND PK_PREGUNTA IN (99, 106, 113, 120, 127, 134, 141, 148, 155, 162)  ";
                $abreviatura = 'DE'; $descripcion = 'Distractores durante el estudio';
                break;
            case 4: //  Cómo tomar notas en clase
                $preguntas = " AND PK_PREGUNTA IN (100, 107, 114, 121, 128, 135, 142, 149, 156, 163) ";
                $abreviatura = 'NC'; $descripcion = 'Cómo tomar notas en clase';
                break;
            case 5: //  optimización de la lectura
                $preguntas = " AND PK_PREGUNTA IN (101, 108, 115, 122, 129, 136, 143, 150, 157, 164) ";
                $abreviatura = 'OL'; $descripcion = 'Optimización de la lectura';
                break;
            case 6: //  como preparar un examen
                $preguntas = " AND PK_PREGUNTA IN (102, 109, 116, 123, 130, 137, 144, 151, 158, 165) ";
                $abreviatura = 'PE'; $descripcion = 'Cómo preparar un examen';
                break;
            case 7: //  Actitudes y conductas
                $preguntas = " AND PK_PREGUNTA IN (103, 110, 117, 124, 131, 138, 145, 152, 159, 166) ";
                $abreviatura = 'AC'; $descripcion = 'Actitudes y conductas';
                break;
        }
        $sql = "
        SELECT
            '$abreviatura' AS ABREVIATURA,
            '$descripcion' AS DESCRIPCION,
            SUM(PORCENTAJE) AS PUNTOS,
            COUNT(PORCENTAJE) AS TOTAL,
            (SUM(PORCENTAJE)*10.00 / COUNT(PORCENTAJE))/10  AS PORCENTAJE
        FROM
            (SELECT
                -- PK_USUARIO,
                    SUM(VALOR_NUMERICO) AS PUNTOS,
                    CASE
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 0 AND 3 THEN 10
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 4 AND 6 THEN 20
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 7 AND 9 THEN 30
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 10 AND 12 THEN 40
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 13 AND 15 THEN 50
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 16 AND 18 THEN 60
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 19 AND 21 THEN 70
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 22 AND 24 THEN 80
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 25 AND 27 THEN 90
                        WHEN SUM(VALOR_NUMERICO) BETWEEN 28 AND 30 THEN 100
                    END AS PORCENTAJE
                FROM
                    VW_RESPUESTA_ENCUESTA
                WHERE
                        PERIODO = '$periodo'
                        AND PK_ENCUESTA = $encuesta " . $preguntas;

        $sql .=
            (isset($data['area_academica']) && $data['area_academica'])
                ? " AND PK_AREA_ACADEMICA = " . $data['area_academica']
                : "";
        $sql .=
            (isset($data['carrera']) && $data['carrera'])
                ? " AND PK_CARRERA = " . $data['carrera'] :
                "";
        $sql .=
            (isset($data['grupo']) && $data['grupo'])
                ? " AND PK_GRUPO_TUTORIA = " . $data['grupo']
                : "";
        $sql .=
            (isset($data['usuario']) && $data['usuario'])
                ? " AND PK_USUARIO = " . $data['usuario']
                : "";

        $sql .= " GROUP BY ";

        if (isset($data['area_academica']) && $data['area_academica']) {
            $sql .= " PK_AREA_ACADEMICA, ";
        }
        if (isset($data['carrera']) && $data['carrera']) {
            $sql .= " PK_CARRERA, ";
        }
        if (isset($data['grupo']) && $data['grupo']) {
            $sql .= " PK_GRUPO_TUTORIA, ";
        }

        $sql .= "PERIODO, PK_USUARIO, PK_ENCUESTA) as QUERY; ";

        return $sql;
    }

    /**
     * @param $periodo
     * @param $encuesta
     * @param $tipo
     * @param $data
     * @return string
     */
    private static function sql_tipo_familia($periodo, $encuesta, $tipo, $data)
    {
        $texto = ($tipo == 1) ? 'Cohesión' : 'Adaptabilidad';
        $sql = "
        SELECT NIVEL, COUNT(NIVEL) AS CANTIDAD FROM (
            SELECT
                SUM(VALOR_NUMERICO) AS PUNTOS,
                CASE
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 0 AND 12 THEN '$texto baja'
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 13 AND 25 THEN '$texto moderada-baja'
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 26 AND 38 THEN '$texto moderada-alta'
                    WHEN SUM(VALOR_NUMERICO) > 38 THEN '$texto muy alta'
                END AS NIVEL
            FROM
                VW_RESPUESTA_ENCUESTA
            WHERE
                PERIODO = '$periodo'
                AND PK_ENCUESTA = $encuesta ";
        $sql .= ($tipo == 1)
            ? " AND PK_PREGUNTA IN (77, 80, 83, 85, 86, 89, 91, 93, 94, 96) "  // cohesion
            : " AND PK_PREGUNTA IN (78, 79, 81, 82, 84, 87, 88, 90, 92, 95) "; // adaptabilidad

        $sql .=
            (isset($data['area_academica']) && $data['area_academica'])
                ? " AND PK_AREA_ACADEMICA = " . $data['area_academica']
                : "";
        $sql .=
            (isset($data['carrera']) && $data['carrera'])
                ? " AND PK_CARRERA = " . $data['carrera'] :
                "";
        $sql .=
            (isset($data['grupo']) && $data['grupo'])
                ? " AND PK_GRUPO_TUTORIA = " . $data['grupo']
                : "";
        $sql .=
            (isset($data['usuario']) && $data['usuario'])
                ? " AND PK_USUARIO = " . $data['usuario']
                : "";

        $sql .= " GROUP BY ";

        if (isset($data['area_academica']) && $data['area_academica']) {
            $sql .= " PK_AREA_ACADEMICA, ";
        }
        if (isset($data['carrera']) && $data['carrera']) {
            $sql .= " PK_CARRERA, ";
        }
        if (isset($data['grupo']) && $data['grupo']) {
            $sql .= " PK_GRUPO_TUTORIA, ";
        }

        $sql .= "PERIODO, PK_USUARIO, PK_ENCUESTA ) AS REPORTE
        GROUP BY NIVEL
        ;";

        return $sql;
    }

    /**
     * @param $periodo
     * @param $encuesta
     * @param $data
     * @return string
     */
    private static function sql_nivel_socioeconomico($periodo, $encuesta, $data)
    {
        $sql = "
        SELECT NIVEL, COUNT(NIVEL) AS CANTIDAD FROM (
            SELECT
                SUM(VALOR_NUMERICO) AS PUNTOS,
                CASE
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 0 AND 32 THEN 'E'
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 33 AND 97 THEN 'D'
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 80 AND 104 THEN 'D+'
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 105 AND 127 THEN 'C-'
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 128 AND 154 THEN 'C'
                    WHEN SUM(VALOR_NUMERICO) BETWEEN 155 AND 192 THEN 'C+'
                    WHEN SUM(VALOR_NUMERICO) > 192 THEN 'AB'
                END AS NIVEL
            FROM
                VW_RESPUESTA_ENCUESTA
            WHERE
                PERIODO = '$periodo'
                AND PK_PREGUNTA BETWEEN 45 AND 52
                AND PK_ENCUESTA = $encuesta ";

        $sql .=
            (isset($data['area_academica']) && $data['area_academica'])
                ? " AND PK_AREA_ACADEMICA = " . $data['area_academica']
                : "";
        $sql .=
            (isset($data['carrera']) && $data['carrera'])
                ? " AND PK_CARRERA = " . $data['carrera'] :
                "";
        $sql .=
            (isset($data['grupo']) && $data['grupo'])
                ? " AND PK_GRUPO_TUTORIA = " . $data['grupo']
                : "";
        $sql .=
            (isset($data['usuario']) && $data['usuario'])
                ? " AND PK_USUARIO = " . $data['usuario']
                : "";

        $sql .= " GROUP BY ";

        if (isset($data['area_academica']) && $data['area_academica']) {
            $sql .= " PK_AREA_ACADEMICA, ";
        }
        if (isset($data['carrera']) && $data['carrera']) {
            $sql .= " PK_CARRERA, ";
        }
        if (isset($data['grupo']) && $data['grupo']) {
            $sql .= " PK_GRUPO_TUTORIA, ";
        }

        $sql .= "PERIODO, PK_USUARIO, PK_ENCUESTA ) AS REPORTE
        GROUP BY NIVEL
        ;";

        return $sql;
    }

    /**
     * @param $periodo
     * @param $encuesta
     * @param $data
     * @return string
     */
    private static function sql_respuestas($periodo, $encuesta, $data)
    {
        $sql = "
        SELECT
            PK_PREGUNTA,
            TIPO_PREGUNTA,
            PLANTEAMIENTO,
            RESPUESTA,
            RESPUESTA_ABIERTA,
            COUNT(RESPUESTA) AS CANTIDAD
        FROM
            VW_RESPUESTA_ENCUESTA
        WHERE
            PERIODO = '$periodo'
            AND PK_ENCUESTA = $encuesta ";

        $sql .= ($encuesta == Constantes::ENCUESTA_CONDICION_SOCIOECONOMICA)
            ? ' AND PK_PREGUNTA BETWEEN 32 AND 44 '
            : '';

        $sql .= ($encuesta == Constantes::ENCUESTA_CONDICION_FAMILIAR)
            ? ' AND PK_PREGUNTA BETWEEN 62 AND 76 '
            : '';

        $sql .=
            (isset($data['area_academica']) && $data['area_academica'])
                ? " AND PK_AREA_ACADEMICA = " . $data['area_academica']
                : "";
        $sql .=
            (isset($data['carrera']) && $data['carrera'])
                ? " AND PK_CARRERA = " . $data['carrera'] :
                "";
        $sql .=
            (isset($data['grupo']) && $data['grupo'])
                ? " AND PK_GRUPO_TUTORIA = " . $data['grupo']
                : "";
        $sql .=
            (isset($data['usuario']) && $data['usuario'])
                ? " AND PK_USUARIO = " . $data['usuario']
                : "";

        $sql .= " GROUP BY ";

        if (isset($data['area_academica']) && $data['area_academica']) {
            $sql .= " PK_AREA_ACADEMICA, ";
        }
        if (isset($data['carrera']) && $data['carrera']) {
            $sql .= " PK_CARRERA, ";
        }
        if (isset($data['grupo']) && $data['grupo']) {
            $sql .= " PK_GRUPO_TUTORIA, ";
        }

        $sql .= " PERIODO, PK_ENCUESTA, PK_PREGUNTA, TIPO_PREGUNTA, PLANTEAMIENTO,
                    PK_RESPUESTA_POSIBLE, RESPUESTA, RESPUESTA_ABIERTA
                ORDER BY PK_RESPUESTA_POSIBLE ASC
        ";

        return $sql;
    }

    /**
     * @param $periodo
     * @param $encuesta
     * @param $data
     * @return string
     */
    private static function sql_pasatiempos($periodo, $encuesta, $data)
    {
        $sql = "
        SELECT
            PK_RESPUESTA_POSIBLE,
            RESPUESTA,
            ORDEN,
            SUM(ORDEN) AS CANTIDAD
        FROM
            VW_RESPUESTA_ENCUESTA
        WHERE
            PERIODO = '$periodo'
            AND PK_ENCUESTA = $encuesta ";

        $sql .=
            (isset($data['area_academica']) && $data['area_academica'])
                ? " AND PK_AREA_ACADEMICA = " . $data['area_academica']
                : "";
        $sql .=
            (isset($data['carrera']) && $data['carrera'])
                ? " AND PK_CARRERA = " . $data['carrera']
                : "";
        $sql .=
            (isset($data['grupo']) && $data['grupo'])
                ? " AND PK_GRUPO_TUTORIA = " . $data['grupo']
                : "";
        $sql .=
            (isset($data['usuario']) && $data['usuario'])
                ? " AND PK_USUARIO = " . $data['usuario']
                : " AND ORDEN = 1 ";

        $sql .= " GROUP BY ";

        if (isset($data['area_academica']) && $data['area_academica']) {
            $sql .= " PK_AREA_ACADEMICA, ";
        }
        if (isset($data['carrera']) && $data['carrera']) {
            $sql .= " PK_CARRERA, ";
        }
        if (isset($data['grupo']) && $data['grupo']) {
            $sql .= " PK_GRUPO_TUTORIA, ";
        }
        if (isset($data['usuario']) && $data['usuario']) {
            $sql .= " PK_USUARIO, ";
        }

        $sql .= " PERIODO, PK_ENCUESTA, PK_PREGUNTA, PK_RESPUESTA_POSIBLE, RESPUESTA, ORDEN
                ORDER BY CANTIDAD ASC
        ";

        // error_log($sql);

        return $sql;
    }
}
