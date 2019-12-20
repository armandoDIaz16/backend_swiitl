<?php

namespace App\Http\Controllers;

use App\Helpers\Referencia;
use Illuminate\Http\Request;

class ReferenciasEspeciales extends Controller
{
    public function generar_referencia_siia()
    {
        $fechaLimitePago = '2020-01-15';
        $monto = '3900';
        $numeros_control = [
            '1000',
            '1001',
            '1002',
            '1003',
            '1004',
            '1005',
            '1006',
            '1007',
            '1008',
            '1009',
            '1010',
            '1011',
            '1012',
            '1013',
            '1014',
            '1015',
            '1016',
            '1017',
            '1018',
            '1019',
            '1020',
            '1021',
            '1022',
            '1023',
            '1024',
            '1025',
            '1026',
            '1027',
            '1028',
            '1029',
            '1030',
            '1031',
            '1032',
            '1033',
            '1034',
            '1035',
            '1036',
            '1037',
            '1038',
            '1039',
            '1040',
            '1041',
            '1042',
            '1043',
            '1044',
            '1045',
            '1046',
            '1047',
            '1048',
            '1049',
            '1050',
            '1051',
            '1052',
            '1053',
            '1054',
            '1055',
            '1056',
            '1057',
            '1058',
            '1059',
            '1060',
            '1061',
            '1062',
            '1063',
            '1064',
            '1065',
            '1066',
            '1067',
            '1068',
            '1069',
            '1070',
            '1071',
            '1072',
            '1073',
            '1074',
            '1075',
            '1076',
            '1077',
            '1078',
            '1079',
            '1080',
            '1081',
            '1082',
            '1083',
            '1084',
            '1085',
            '1086',
            '1087',
            '1088',
            '1089',
            '1090',
            '1091',
            '1092',
            '1093',
            '1094',
            '1095',
            '1096',
            '1097',
            '1098',
            '1099',
            '1100',
            '1101',
            '1102',
            '1103',
            '1104',
            '1105',
            '1106',
            '1107',
            '1108',
            '1109',
            '1110',
            '1111',
            '1112',
            '1113',
            '1114',
            '1115'
        ];

        // 30 19240660 015 037 22545291

        $referencias = [];

        foreach ($numeros_control as $numero_control) {
            $datosReferencia = [
                'tipo_persona' => '30', // 30
                'control'  => $numero_control,
                'servicio' => '015', // 015
                'concepto' => '037', // 037
                'valorvariable' => '2',
                'monto' => $monto,
                'yearC' => date('Y', strtotime($fechaLimitePago)),
                'mesC' => date('m', strtotime($fechaLimitePago)),
                'diaC' => date('j', strtotime($fechaLimitePago)),
            ];

            $referencias[] = [
                'numero_control' => $numero_control,
                'referencia' => Referencia::RUTINA8250POSICIONESSIIA($datosReferencia)
            ];
        }

        return $referencias;
    }

    public static function generar_referencia()
    {
        $fechaLimitePago = '2020-01-23';
        $monto = '250';
        // NUMEROS DE CONTROL DE HORIZONTES
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
