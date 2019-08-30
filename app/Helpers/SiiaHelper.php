<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Class UsuariosHelper
 * @package App\Helpers
 */
class SiiaHelper {

    /**
     * @var string
     */
    private static $connnection = 'sqlsrv2';

    /**
     * @param $data
     * @param bool $multi_result
     * @return array|bool
     */
    public static function get_horario_grupo($data, $multi_result = true) {
        $sql = "
        SELECT DISTINCT
            IdPeriodoEscolar,
            clavemateria,
            clavegrupo,
            IdMaestro,
            Aula,
            CASE
                WHEN Dia = 1 THEN 'Lunes'
                WHEN Dia = 2 THEN 'Martes'
                WHEN Dia = 3 THEN 'Miércoles'
                WHEN Dia = 4 THEN 'Jueves'
                WHEN Dia = 5 THEN 'Viernes'
            END AS DIA,
            CONCAT(HoraInicial, ':', MinutoInicial) AS HORA_INICIAL,
            CONCAT(HoraFinal, ':', MinutoFinal) AS HORA_FINAL
        FROM
             dbo.view_horarioalumno
        WHERE
            clavegrupo           = " .$data['CLAVE_GRUPO']. "
            AND IdPeriodoEscolar = " .$data['PERIODO']. "
            AND clavemateria     = '" .$data['CLAVE_MATERIA']. "' ;";

        return SiiaHelper::procesa_consulta($sql, $multi_result);
    }

    /**
     * @param $data
     * @param bool $multi_result
     * @return array|bool
     */
    public static function get_horario_alumno($data, $multi_result = true) {
        $sql = "";
        $bindings = [];

        return SiiaHelper::procesa_consulta($sql, $multi_result);
    }

    /**
     * @param $data
     * @param bool $multi_result
     * @return array|bool
     */
    public static function get_lista_grupo($data, $multi_result = true) {
        $sql = "
        SELECT
            NumeroControl,
            Nombre,
            ApellidoPaterno,
            ApellidoMaterno,
            Semestre,
            ClaveCarrera
        FROM
            dbo.view_alumnos
        WHERE
            NumeroControl IN (
                SELECT DISTINCT
                    NumeroControl
                FROM
                    dbo.view_horarioalumno
                WHERE
                    IdPeriodoEscolar = " .$data['PERIODO']. "
                    AND clavemateria = '" .$data['CLAVE_MATERIA']. "'
                    AND clavegrupo = " .$data['CLAVE_GRUPO']. "
            ); ";

        return SiiaHelper::procesa_consulta($sql, $multi_result);
    }

    /**
     * @param $sql
     * @param $bindings
     * @param $multi_result
     * @return array|bool
     */
    private static function procesa_consulta($sql, $multi_result) {
        $result = DB::connection(SiiaHelper::$connnection)->select($sql);

        if ($result) {
            if ($multi_result) {
                return $result;
            } else {
                return $result[0];
            }
        } else {
            return false;
        }
    }

}
