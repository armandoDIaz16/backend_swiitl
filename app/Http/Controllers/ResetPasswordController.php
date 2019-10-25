<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers
 */
class ResetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        $aspirante = DB::table('CAT_USUARIO')
            ->select(
                'PK_USUARIO',
                'CORREO1',
                'CURP'
            )
            ->where(['CURP', '=', $request->CURP])
            ->first();
        $token = $this->get_datos_token($aspirante);
        if (!$this->notifica_usuario(
            $aspirante->CORREO1,
            $token->TOKEN,
            $token->CLAVE_ACCESO
        )) {
            error_log("Error al enviar correo al receptor en activación de cuenta: " . $aspirante->CORREO1);
            error_log("AuthController.php");
        }
    }

    private function get_datos_token($usuario)
    {
        // buscar token activo
        $datos_token = ObtenerContrasenia::where('FK_USUARIO', $usuario->PK_USUARIO)
            ->where('FECHA_GENERACION', '>=', date('Y-m-d 00:00:00'))
            ->where('FECHA_GENERACION', '<=', date('Y-m-d 23:59:59'))
            ->where('ESTADO', 1)
            ->first();

        if (!isset($datos_token->FK_USUARIO)) { // sí no tiene token activo
            // generar token y clave
            $fecha = date('Y-m-d H:i:s');
            $token = UsuariosHelper::get_token_contrasenia($usuario->CURP, $fecha);
            $clave = UsuariosHelper::get_clave_verificacion();

            // registro en tabla de contraseñas
            $datos_token = new ObtenerContrasenia;
            $datos_token->FK_USUARIO = $usuario->PK_USUARIO;
            $datos_token->TOKEN = $token;
            $datos_token->CLAVE_ACCESO = $clave;
            $datos_token->FECHA_GENERACION = $fecha;
            $datos_token->save();
        }

        return $datos_token;
    }
    private function notifica_usuario($correo_receptor, $token, $clave)
    {
        //obtener correo del sistema
        $datos_sistema = Sistema::where('ABREVIATURA', 'SIT')->first();

        //enviar correo de notificación
        $mailer = new Mailer(
            array(
                // correo de origen
                'correo_origen' => $datos_sistema->CORREO1,
                'password_origen' => $datos_sistema->INDICIO1,

                // datos que se mostrarán del emisor
                // 'correo_emisor' => $datos_sistema->CORREO1,
                'correo_emisor' => 'tecvirtual@itleon.edu.mx',
                'nombre_emisor' => utf8_decode('Tecnológico Nacional de México en León'),

                // array correos receptores
                'correos_receptores' => array($correo_receptor),

                // asunto del correo
                'asunto' => utf8_decode('TecVirtual - Activación de cuenta'),

                // cuerpo en HTML del correo
                'cuerpo_html' => view(
                    'mails.activacion_cuenta',
                    ['token' => $token, 'clave' => $clave]
                )->render()
            )
        );

        return $mailer->send();
    }
}
