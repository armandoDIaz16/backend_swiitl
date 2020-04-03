<?php

namespace App\Http\Controllers\Referencias;

use App\Referencias\Concepto;
use App\Referencias\Referencia;
use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReferenciaController extends Controller
{
    /**
     * Muestra todas las referencias.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReferencias()
    {
        $referencias = DB::table('TR_REFERENCIA')
            ->join('CAT_USUARIO',
                'TR_REFERENCIA.FK_USUARIO', '=', 'CAT_USUARIO.PK_USUARIO')
            ->join('CAT_CONCEPTO',
                'TR_REFERENCIA.FK_CONCEPTO', '=', 'CAT_CONCEPTO.PK_CONCEPTO')
            ->select('TR_REFERENCIA.*', 'CAT_USUARIO.NOMBRE AS NOMBRE_USUARIO', 'CAT_USUARIO.PRIMER_APELLIDO',
                'CAT_USUARIO.SEGUNDO_APELLIDO', 'CAT_CONCEPTO.NOMBRE AS NOMBRE_CONCEPTO')
            ->get();

        return response()->json(
            $referencias,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Crea una referencia.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createReferencia(Request $request)
    {
        $concepto = Concepto::find($request->FK_CONCEPTO);
        $usuario = Usuario::find($request->FK_USUARIO);

        $referencia = new Referencia;

        //Para generar el número de referencia
        $ref = \App\Helpers\Referencia::RUTINA8250POSICIONES([
            'tipo_persona'=>$usuario->TIPO_USUARIO,                             //tipo usuario, cat_usuario
            'control'=>$usuario->NUMERO_CONTROL,                                //número de control, cat_usuario
            'servicio'=>'037',
            'valorvariable'=>2,
            'monto'=>$concepto->MONTO,                                          //monto, cat_concepto
            'yearC'=>date("Y", strtotime($concepto->VIGENCIA_FINAL)),   //año, vigencia final, cat_concepto
            'mesC'=>date("m", strtotime($concepto->VIGENCIA_FINAL)),    //mes, vigencia final, cat_concepto
            'diaC'=>date("d", strtotime($concepto->VIGENCIA_FINAL))     //dia, vigencia final, cat_concepto
        ]);

        $referencia->FK_USUARIO = $request->FK_USUARIO;
        $referencia->FK_CONCEPTO = $request->FK_CONCEPTO;
        $referencia->FECHA_GENERADA = date('Y-m-d H:i:s');
        $referencia->FECHA_EXPIRACION = $concepto->VIGENCIA_FINAL;
        $referencia->NUMERO_REF_BANCO = $ref;
        $referencia->MONTO_SISTEMA = $concepto->MONTO;
        $referencia->MONTO_PAGADO = $request->MONTO_PAGADO;
        $referencia->CANTIDAD_SOLICITADA = $request->CANTIDAD_SOLICITADA;
        $referencia->MONTO = $concepto->MONTO * $request->CANTIDAD_SOLICITADA;  //Monto * cantidad = monto total

        $referencia->save();

        return response()->json(
            $referencia,
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Muestra una referencia especificada por su PK.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getReferencia($id)
    {
        $referencia = DB::table('TR_REFERENCIA')
            ->join('CAT_USUARIO',
                'TR_REFERENCIA.FK_USUARIO', '=', 'CAT_USUARIO.PK_USUARIO')
            ->join('CAT_CONCEPTO',
                'TR_REFERENCIA.FK_CONCEPTO', '=', 'CAT_CONCEPTO.PK_CONCEPTO')
            ->where('PK_REFERENCIA', '=', $id)
            ->select('TR_REFERENCIA.*', 'CAT_USUARIO.NOMBRE AS NOMBRE_USUARIO', 'CAT_USUARIO.PRIMER_APELLIDO',
                'CAT_USUARIO.SEGUNDO_APELLIDO', 'CAT_CONCEPTO.NOMBRE AS NOMBRE_CONCEPTO')
            ->first();

        if (empty($referencia)) {
            return response()->json(
                'No existe ninguna referencia con el ID enviado.',
                Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                $referencia,
                Response::HTTP_ACCEPTED
            );
        }
    }
}
