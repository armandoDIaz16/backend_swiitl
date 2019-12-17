<?php

namespace App\Http\Controllers;

use App\Helpers\Referencia;
use Illuminate\Http\Request;

class ReferenciasEspeciales extends Controller
{
    public function generar_referencia_siia()
    {
        $fechaLimitePago = '2020-01-23';

        // 30 19240660 015 037 22545291

        // 1  18240295 037     20773285
        // 1  18240295 037     20776227

        // 1  18240295 037     22546281

        $datosReferencia = [
            'tipo_persona' => '30', // 30
            'control' => '19240660',
            'servicio' => '015', // 015
            'concepto' => '037', // 037
            'valorvariable' => '2',
            'monto' => '5',
            'yearC' => date('Y', strtotime($fechaLimitePago)),
            'mesC' => date('m', strtotime($fechaLimitePago)),
            'diaC' => date('j', strtotime($fechaLimitePago)),
        ];

        return Referencia::RUTINA8250POSICIONESSIIA($datosReferencia);
    }

    public static function generar_referencia()
    {
        $fechaLimitePago = '2020-01-23';
        $monto = '250';
        $numeros_control = [
            '19240660',
            '19240263',
            '19240062',
            '19240022',
            '19240497',
            '19240369',
            '19240362',
            '19240066',
            '19240245',
            '19240133',
            '19240659',
            '19240167',
            '19240436',
            '19240528',
            '19240058',
            '19240096',
            '19240279',
            '19240636',
            '19240439',
            '19240441',
            '19241023',
            '19240283',
            '19240897',
            '19240197',
            '19240175',
            '19241013',
            '19240440',
            '19240052',
            '19240100',
            '19240522',
            '19240308',
            '19240327',
            '19240530',
            '19240091',
            '19240524',
            '19240981',
            '19240037',
            '19240364',
            '19240043',
            '19240709',
            '19240510',
            '19241026',
            '19240442',
            '19241030',
            '19240548',
            '19240368',
            '19240332',
            '19240298',
            '19240352',
            '19240899',
            '19240402',
            '19240712',
            '19240508',
            '19240958',
            '19241033',
            '19240634',
            '19240217',
            '19241045',
            '19240452',
            '19240360',
            '19240946',
            '19240029',
            '19240389',
            '19240997',
            '19240057',
            '19240764',
            '19240257',
            '19240177',
            '19240132',
            '19240920',
        ];

        $referencias = [];

        foreach ($numeros_control as $numero_control) {
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

            $referencias[] = [
                'numero_control' => $numero_control,
                'referencia' => Referencia::RUTINA8250POSICIONES($datosReferencia)
            ];
        }

        return $referencias;
    }

}
