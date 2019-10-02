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
    public static function get_materias_alumno($data, $multi_result = true) {
        $sql = "
            SELECT DISTINCT
                view_reticula.ClaveMateria,
                view_reticula.Nombre,
                CONCAT(
                    view_docentes.Nombre, ' ',
                    view_docentes.ApellidoPaterno, ' ',
                    view_docentes.ApellidoMaterno, ' '
                ) AS Docente,
                -- view_horarioalumno.NumeroControl,
                ClaveCarrera,
                view_horarioalumno.Aula
            FROM
                dbo.view_horarioalumno
                LEFT JOIN dbo.view_reticula
                    ON view_reticula.ClaveMateria = view_horarioalumno.ClaveMateria
                LEFT JOIN dbo.view_docentes
                    ON view_docentes.Idusuario = view_horarioalumno.IdMaestro
            WHERE
                view_horarioalumno.NumeroControl = '" .$data['NUMERO_CONTROL'] ."'
                and ClaveCarrera = '" .$data['CLAVE_CARRERA'] ."'
            and IdPeriodoEscolar = '" .$data['PERIODO'] ."' ;";

        return SiiaHelper::procesa_consulta($sql, $multi_result);
    }

    /**
     * @param $data
     * @param bool $multi_result
     * @return array|bool
     */
    public static function get_horario_materia($data, $multi_result = true) {
        $sql = "
        SELECT
            view_reticula.ClaveMateria,
            view_horarioalumno.NumeroControl,
            ClaveCarrera,
            CASE
                WHEN Dia = 1 THEN 
                    CONCAT('Lunes ' , HoraInicial, ':', MinutoInicial, ' - ', HoraFinal, ':', MinutoFinal)
            END AS Lunes,
               CASE
                WHEN Dia = 2 THEN 
                    CONCAT('Martes ' , HoraInicial, ':', MinutoInicial, ' - ', HoraFinal, ':', MinutoFinal)
            END AS Martes,
            CASE
                WHEN Dia = 3 THEN 
                    CONCAT('Miércoles ' , HoraInicial, ':', MinutoInicial, ' - ', HoraFinal, ':', MinutoFinal)
            END AS Miercoles,
            CASE
                WHEN Dia = 4 THEN 
                    CONCAT('Jueves ' , HoraInicial, ':', MinutoInicial, ' - ', HoraFinal, ':', MinutoFinal)
            END AS Jueves,
            CASE
                WHEN Dia = 5 THEN 
                    CONCAT('Viernes ' , HoraInicial, ':', MinutoInicial, ' - ', HoraFinal, ':', MinutoFinal)
            END AS Viernes
        FROM
            dbo.view_horarioalumno
            LEFT JOIN dbo.view_reticula 
                ON view_reticula.ClaveMateria = view_horarioalumno.ClaveMateria
        WHERE
            view_horarioalumno.NumeroControl = '" .$data['NUMERO_CONTROL']. "'
            AND ClaveCarrera                 = '" .$data['CLAVE_CARRERA']. "'
            AND IdPeriodoEscolar             = '" .$data['PERIODO']. "'
            AND view_reticula.ClaveMateria   = '" .$data['CLAVE_MATERIA']. "'
        order by
            view_horarioalumno.Dia asc ; ";

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
