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

        return self::procesa_consulta($sql, $multi_result);
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

        return self::procesa_consulta($sql, $multi_result);
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

        return self::procesa_consulta($sql, $multi_result);
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

        return self::procesa_consulta($sql, $multi_result);
    }

    public static function get_seguimiento($numero_control, $clave_carrera, $multi_result = true) {
        $sql = "
            SELECT
                view_seguimiento.ClaveMateria AS CLAVE_MATERIA,
                Nombre as NOMBRE_MATERIA,
                CASE
                    WHEN IdNivelCurso = 'CO'  THEN 'Curso ordinario'
                    WHEN IdNivelCurso = 'CR'  THEN 'Curso de repetición'
                    WHEN IdNivelCurso = 'CE'  THEN 'Curso especial'
                    WHEN IdNivelCurso = 'CE2' THEN 'Otro'
                    WHEN IdNivelCurso = '00'  THEN 'Otro'
                    WHEN IdNivelCurso = 'CN'  THEN 'Otro'
                    WHEN IdNivelCurso = 'CV'  THEN 'Otro'
                    WHEN IdNivelCurso = 'EE1' THEN 'Otro'
                    WHEN IdNivelCurso = 'EE2' THEN 'Otro'
                    WHEN IdNivelCurso = 'EQ'  THEN 'Otro'
                    WHEN IdNivelCurso = 'REP' THEN 'Otro'
                END AS TIPO_CURSO,
                CALIFICACION,
                CASE
                    WHEN FechaPrimera = '1900-01-01 00:00:00' THEN NULL
                    WHEN FechaPrimera != '1900-01-01 00:00:00' THEN FechaPrimera
                END AS FECHA_PRIMERA,
                CASE
                    WHEN FechaSegunda = '1900-01-01 00:00:00' THEN NULL
                    WHEN FechaSegunda != '1900-01-01 00:00:00' THEN FechaSegunda
                END AS FECHA_SEGUNDA,
                CASE
                    WHEN FechaTercera = '1900-01-01 00:00:00' THEN NULL
                    WHEN FechaTercera != '1900-01-01 00:00:00' THEN FechaTercera
                END AS FECHA_TERCERA
            FROM
                dbo.view_seguimiento
                LEFT JOIN dbo.view_reticula
                    ON view_reticula.ClaveMateria = view_seguimiento.ClaveMateria
            WHERE
                view_seguimiento.NumeroControl = '".$numero_control."'
                and ClaveCarrera = '".$clave_carrera."'
            ORDER BY
                view_seguimiento.FechaPrimera ASC,
                view_seguimiento.FechaSegunda ASC,
                view_seguimiento.FechaTercera ASC,
                NOMBRE_MATERIA ASC
            ;";

        $seguimiento = self::procesa_consulta($sql, $multi_result);
        if ($seguimiento) {
            foreach ($seguimiento as $materia) {
                if ($materia->FECHA_PRIMERA) {
                    $materia->FECHA_PRIMERA = trim($materia->FECHA_PRIMERA);
                    $materia->FECHA_PRIMERA = explode(' ', $materia->FECHA_PRIMERA)[0];

                    $array = explode('-', $materia->FECHA_PRIMERA);
                    $materia->PERIODO_TEXTO = Constantes::get_periodo_texto(
                        Constantes::get_periodo_anio_mes($array[0], $array[1])
                    );
                }
                if ($materia->FECHA_SEGUNDA) {
                    $materia->FECHA_SEGUNDA = trim($materia->FECHA_SEGUNDA);
                    $materia->FECHA_SEGUNDA = explode(' ', $materia->FECHA_SEGUNDA)[0];

                    $array = explode('-', $materia->FECHA_SEGUNDA);
                    $materia->PERIODO_TEXTO = Constantes::get_periodo_texto(
                        Constantes::get_periodo_anio_mes($array[0], $array[1])
                    );
                }
                if ($materia->FECHA_TERCERA) {
                    $materia->FECHA_TERCERA = trim($materia->FECHA_TERCERA);
                    $materia->FECHA_TERCERA = explode(' ', $materia->FECHA_TERCERA)[0];

                    $array = explode('-', $materia->FECHA_TERCERA);
                    $materia->PERIODO_TEXTO = Constantes::get_periodo_texto(
                        Constantes::get_periodo_anio_mes($array[0], $array[1])
                    );
                }
            }
        }

        return $seguimiento;
    }

    public static function buscar_alumno($numero_control, $nombre, $primer_apellido, $segundo_apellido) {
        // BUSCAR POR NÚMERO DE CONTROL
        $sql = "
            SELECT
                *
            FROM
                dbo.view_alumnos
            WHERE
                NumeroControl = '".trim($numero_control)."'
            ;";

        $usuario = self::procesa_consulta($sql, false);
        if (!$usuario) {
            // BUSCAR POR NOMBRE
            $sql = "
            SELECT
                *
            FROM
                dbo.view_alumnos
            WHERE
                Nombre          = '".$nombre."'
                AND ApellidoPaterno = '".$primer_apellido."'
                AND ApellidoMaterno = '".$segundo_apellido."'
            ;";

            $usuario = self::procesa_consulta($sql, false);
        }

        return $usuario;
    }

    public static function buscar_aspirante($nombre, $primer_apellido, $segundo_apellido) {
        // BUSCAR POR NOMBRE
        $sql = "
            SELECT
                *
            FROM
                dbo.view_alumnos
            WHERE
                Nombre          = '".$nombre."'
                AND ApellidoPaterno = '".$primer_apellido."'
                AND ApellidoMaterno = '".$segundo_apellido."'
            ;";

        return self::procesa_consulta($sql, false);
    }

    public static function buscar_empleado($numero_control) {
        // BUSCAR POR NÚMERO DE SIIA
        $sql = "
            SELECT
                *
            FROM
                dbo.view_docentes
            WHERE
                Idusuario = '".trim($numero_control)."'
            ;";

        return self::procesa_consulta($sql, false);
    }

    /**
     * @param $sql
     * @param $bindings
     * @param $multi_result
     * @return array|bool
     */
    private static function procesa_consulta($sql, $multi_result) {
        $result = DB::connection(self::$connnection)->select($sql);

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
