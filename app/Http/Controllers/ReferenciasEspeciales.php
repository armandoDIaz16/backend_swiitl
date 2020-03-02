<?php

namespace App\Http\Controllers;

use App\Helpers\Referencia;
use Illuminate\Http\Request;

class ReferenciasEspeciales extends Controller
{
    public function generar_referencia_siia()
    {
        // De semestre 0 a 1
        $fechaLimitePago = '2020-01-31';
        $monto = '3900';

        $numero_control = '1121';

        $datosReferencia = [
            'tipo_persona' => '30', // 30
            'control' => $numero_control,
            'servicio' => '015', // 015
            'concepto' => '037', // 037
            'valorvariable' => '2',
            'monto' => $monto,
            'yearC' => date('Y', strtotime($fechaLimitePago)),
            'mesC' => date('m', strtotime($fechaLimitePago)),
            'diaC' => date('j', strtotime($fechaLimitePago)),
        ];

        $referencia = [
            'numero_control' => $numero_control,
            'referencia' => Referencia::RUTINA8250POSICIONESSIIA($datosReferencia)
        ];

        return $referencia;
    }

    public static function generar_referencia()
    {
        $fechaLimitePago = '2020-02-08';
        $monto = '3000';
        $numero_control = '19240153';

        $datosReferencia = [
            'tipo_persona' => '1',
            'control' => $numero_control,
            'servicio' => '037',
            'valorvariable' => '2',
            'monto' => $monto,
            'yearC' => date('Y', strtotime($fechaLimitePago)),
            'mesC' => date('m', strtotime($fechaLimitePago)),
            'diaC' => date('j', strtotime($fechaLimitePago)),
        ];

        $referencia = [
            'numero_control' => $numero_control,
            'referencia' => Referencia::RUTINA8250POSICIONES($datosReferencia)
        ];

        return $referencia;
    }

    public static function generar_referencia_hijos()
    {
        $fechaLimitePago = '2020-01-19';
        $monto = '450';
        // NUMEROS DE CONTROL DE HIJOS DE HOMOLOOGADOS
        $numero_control = '16240311';

        $datosReferencia = [
            'tipo_persona' => '1',
            'control' => $numero_control,
            'servicio' => '037',
            'valorvariable' => '2',
            'monto' => $monto,
            'yearC' => date('Y', strtotime($fechaLimitePago)),
            'mesC' => date('m', strtotime($fechaLimitePago)),
            'diaC' => date('j', strtotime($fechaLimitePago)),
        ];

        $referencia = [
            'numero_control' => $numero_control,
            'referencia' => Referencia::RUTINA8250POSICIONES($datosReferencia)
        ];

        return $referencia;
    }

    public static function referencia_propedeutico()
    {
        $fechaLimitePago = '2020-02-29'; // FECHA LIMITE DE PAGO
        $monto = '2500';

        $numero_control = '2279';

        $datosReferencia = [
            'tipo_persona' => '30', // 30
            'control' => $numero_control,
            'servicio' => '015', // 015
            'concepto' => '037', // 037
            'valorvariable' => '2',
            'monto' => $monto,
            'yearC' => date('Y', strtotime($fechaLimitePago)),
            'mesC' => date('m', strtotime($fechaLimitePago)),
            'diaC' => date('j', strtotime($fechaLimitePago)),
            ];

        $referencia = [
            'numero_control' => $numero_control,
            'referencia' => Referencia::RUTINA8250POSICIONESSIIA($datosReferencia)
        ];

        return $referencia;
    }

}
