<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Class PermisosUsuario
 * @package App\Helpers
 */
class PermisosUsuario {

    /**
     * @param $json_permisos
     * @param $sistema
     * @return mixed|null
     */
    public static function get_permisos_sistema($json_permisos, $sistema) {
        return (isset($json_permisos[$sistema]))
            ? $json_permisos[$sistema]
            : null;
    }


    public static function consulta_roles_usuario($idUsuario, $abreviatura_sistema)
    {
        // BUSCAMOS LOS ROLES DE UN SISTEMA EN PARTICULAR POR SU ABREVIATURA
        $result = DB::table('PER_TR_ROL_USUARIO AS RU')
            ->select('CR.PK_ROL','CR.ABREVIATURA')
            ->join('PER_CAT_ROL AS CR',
                'CR.PK_ROL', '=', 'RU.FK_ROL')
            ->join('PER_CAT_SISTEMA AS CS',
                'CS.PK_SISTEMA', '=', 'CR.FK_SISTEMA')
            ->where('CS.ABREVIATURA',$abreviatura_sistema)
            ->where('RU.FK_USUARIO',$idUsuario)
            ->where('RU.BORRADO',0)
            ->where('CR.BORRADO',0)
            ->where('CS.BORRADO',0)
            ->get();
        /* SELECT CR.PK_ROL,RU.FK_USUARIO,CR.ABREVIATURA,CS.ABREVIATURA
         FROM PER_TR_ROL_USUARIO RU
         INNER JOIN PER_CAT_ROL CR ON CR.PK_ROL = RU.FK_ROL
         INNER JOIN PER_CAT_SISTEMA CS ON CS.PK_SISTEMA = CR.FK_SISTEMA
         WHERE  CS.ABREVIATURA='CADO' AND RU.BORRADO=0 AND CR.BORRADO=0 AND CS.BORRADO=0*/

        return $result;

    }

}
