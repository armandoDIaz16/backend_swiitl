<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Class ObtenerCorreo
 * @package App\Helpers
 */
class ObtenerCorreo
{
    function getCorreo()
    {
        $correo = DB::table('CAT_CORREO as CC')
            ->select('TEC.PK_ENVIO_CORREO', 'CC.PK_CORREO', 'CC.DIRECCION', 'CC.INDICIO')
            ->leftjoin('TR_ENVIO_CORREO as TEC', 'CC.PK_CORREO', '=', 'TEC.FK_CORREO')
            ->whereRaw('CC.CANTIDAD > TEC.CANTIDAD and DIA=CONVERT (date, GETDATE())')
            ->orWhereNull('TEC.CANTIDAD')
            ->take(1)
            ->first();
        if (empty($correo)) {
            $correos = DB::table('CAT_CORREO')->select('PK_CORREO')->get();
            foreach ($correos as $tr) {
                DB::table('TR_ENVIO_CORREO')->insert(['FK_CORREO' => $tr->PK_CORREO, 'CANTIDAD' => 0]);
            }
            $correo = DB::table('CAT_CORREO as CC')
            ->select('TEC.PK_ENVIO_CORREO', 'CC.PK_CORREO', 'CC.DIRECCION', 'CC.INDICIO')
            ->leftjoin('TR_ENVIO_CORREO as TEC', 'CC.PK_CORREO', '=', 'TEC.FK_CORREO')
            ->whereRaw('CC.CANTIDAD > TEC.CANTIDAD and DIA=CONVERT (date, GETDATE())')
            ->orWhereNull('TEC.CANTIDAD')
            ->take(1)
            ->first();
        }
        return $correo;
    }
    function aumentarContador($PK_ENVIO_CORREO, $PK_CORREO)
    {
        if ($PK_ENVIO_CORREO) {
            DB::table('TR_ENVIO_CORREO')->where('PK_ENVIO_CORREO', $PK_ENVIO_CORREO)->increment('CANTIDAD', 1);
        } else {
            DB::table('TR_ENVIO_CORREO')->insert(['FK_CORREO' => $PK_CORREO, 'CANTIDAD' => 1]);
        }
    }
}
