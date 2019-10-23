<?php

namespace App\Helpers;

/**
 * Class FechaEspañol
 * @package App\Helpers
 */
class FechaEspanol
{

    /**
     * Función para regresar un dia o mes en español
     * @param  String $fecha      Fehca de sql
     */

    public static function getDia($fecha)
    {
        $dia = date('w', strtotime($fecha));
        switch ($dia) {
            case 0:
                $dia = "Domingo";
                break;
            case 1:
                $dia = "Lunes";
                break;
            case 2:
                $dia = "Martes";
                break;
            case 3:
                $dia = "Miercoles";
                break;
            case 4:
                $dia = "Jueves";
                break;
            case 5:
                $dia = "Viernes";
                break;
            case 6:
                $dia = "Sabado";
                break;
        }
        return $dia;
    }

    public static function getMes($fecha)
    {
        $mes = date('m', strtotime($fecha));
        error_log(print_r($mes,true));
        switch ($mes) {
            case 1:
                $mes = "Enero";
                break;
            case 2:
                $mes = "Febrero";
                break;
            case 3:
                $mes = "Marzo";
                break;
            case 4:
                $mes = "Abril";
                break;
            case 5:
                $mes = "Mayo";
                break;
            case 6:
                $mes = "Junio";
                break;
            case 7:
                $mes = "Julio";
                break;
            case 8:
                $mes = "Agosto";
                break;
            case 9:
                $mes = "Septiembre";
                break;
            case 10:
                $mes = "Octubre";
                break;
            case 11:
                $mes = "Noviembre";
                break;
            case 12:
                $mes = "Diciembre";
                break;
        }
        return $mes;
    }
}
