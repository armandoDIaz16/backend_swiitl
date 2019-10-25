<?php

namespace App\Helpers;

/**
 * Class Referencia
 * @package App\Helpers
 * Algoritmo para generar la referencia bancaria
 * @param  array   $datos      el array datos debe contener
 *                             refpar:        tipo_persona.control.servicio
 *                              tipo_persona:  1 = alumno, 0 = externo, 4 = egresado
 *                             control:       número de control del alumno
 *                             servicio:      es el concepto del servicio a pagar.
 *                             Si el concepto = '012' || '013' || '014', se debe tomar como concepto = '061'
 *                             Si no, si el concepto = '001' || '002' || '003', sedebe tomar como concepto = '037'
 *                             Si no, el concepto se toma del catálogo de conceptos
 *                             valorvariable: 2 (fijo)
 *                             monto:         monto a pagar
 *                             yearC:         año en que vence la referencia
 *                     e       mesC:          mes en que vence la referencia
 *                             diaC:          día en que vence la referencia
 * @return String  $referencia número de referencia bancaria
 */

class Referencia
{

    /**
     * @param $datosReferencia
     * @return string
     */

    public static function RUTINA8250POSICIONES($datos)
    {
        $Amonto = array(7, 3, 1); //arreglo para obtener el importe concensado
        $ADV = array(11, 13, 17, 19, 23); //arreglo de digito verificador
        $letra = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5, 6, 7, 8, 9);

        $referencia = strtoupper($datos['tipo_persona'] . $datos['control'] . $datos['servicio']); //tipoalumno.control.servicio
        $rev = "";
        $ValorVariable = $datos['valorvariable'];
        foreach (str_split($referencia) as $char) {
            if ((ord($char) > 64 && ord($char) < 91)) {
                $rev .= $letra[ord($char) - 65];
            } else {
                $rev .= $char;
            }
        }
        $referencia = $rev;
        $monto = $datos['monto'];
        if (strpos($monto, '.') === false) {
            $monto = number_format($monto, 2, '.', '');
        }
        $fecha = "" . ((($datos['yearC'] - 2014) * 372) + (($datos['mesC'] - 1) * 31) + ($datos['diaC'] - 1));
        $monto = strrev(str_replace('.', '', $monto));
        $i = 0;
        $suma = 0;
        foreach (str_split($monto) as $dig) {
            $suma += ($Amonto[$i] * $dig);
            $i++;
            if ($i == count($Amonto)) {
                $i = 0;
            }
        }
        $monotoConde = "" . ($suma % 10);
        $referenciatemp = strrev($referencia . $fecha . '' . $monotoConde . '' . $ValorVariable);
        $i = 0;
        $suma = 0;
        foreach (str_split($referenciatemp) as $dig) {
            $suma += ($ADV[$i] * $dig);
            $i++;
            if ($i == count($ADV)) {
                $i = 0;
            }
        }
        $digitoVerificador = "" . (($suma % 97) + 1);
        $DV = (($suma % 97) + 1);
        if ($DV < 10) {
            $digitoVerificador = "0" . (($suma % 97) + 1);
        } else {
            $digitoVerificador = "" . (($suma % 97) + 1);
        }
        return $referencia . $fecha . $monotoConde . $ValorVariable . $digitoVerificador;
    }

    public static function RUTINA8250POSICIONESSIIA($datos)
    {
        //return "fmdifj0jf0jf09j0f3900";
        $Amonto = array(7, 3, 1); //arreglo para obtener el importe concensado
        $ADV = array(11, 13, 17, 19, 23); //arreglo de digito verificador
        $letra = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5, 6, 7, 8, 9);

        $referencia = strtoupper($datos['tipo_persona'] . $datos['control'] . $datos['servicio'] . $datos['concepto']); //tipoalumno.control.servicio.concepto
        $rev = "";
        $ValorVariable = $datos['valorvariable'];
        foreach (str_split($referencia) as $char) {
            if ((ord($char) > 64 && ord($char) < 91)) {
                $rev .= $letra[ord($char) - 65];
            } else {
                $rev .= $char;
            }
        }
        $referencia = $rev;
        $monto = $datos['monto'];
        if (strpos($monto, '.') === false) {
            $monto = number_format($monto, 2, '.', '');
        }
        $fecha = "" . ((($datos['yearC'] - 2014) * 372) + (($datos['mesC'] - 1) * 31) + ($datos['diaC'] - 1));
        $monto = strrev(str_replace('.', '', $monto));
        $i = 0;
        $suma = 0;
        foreach (str_split($monto) as $dig) {
            $suma += ($Amonto[$i] * $dig);
            $i++;
            if ($i == count($Amonto)) {
                $i = 0;
            }
        }
        $monotoConde = "" . ($suma % 10);
        $referenciatemp = strrev($referencia . $fecha . '' . $monotoConde . '' . $ValorVariable);
        $i = 0;
        $suma = 0;
        foreach (str_split($referenciatemp) as $dig) {
            $suma += ($ADV[$i] * $dig);
            $i++;
            if ($i == count($ADV)) {
                $i = 0;
            }
        }
        $digitoVerificador = "" . (($suma % 97) + 1);
        $DV = (($suma % 97) + 1);
        if ($DV < 10) {
            $digitoVerificador = "0" . (($suma % 97) + 1);
        } else {
            $digitoVerificador = "" . (($suma % 97) + 1);
        }
        return $referencia . $fecha . $monotoConde . $ValorVariable . $digitoVerificador;
    }
}
