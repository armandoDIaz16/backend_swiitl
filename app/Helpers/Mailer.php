<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{

    private $config      = array();
    private $puerto      = null;
    private $smtp_secure = null;

    public function __construct($config) {
        $this->config        = $config;
        // tls config
        // $this->puerto      = 587;
        // $this->smtp_secure = 'tls';

        // ssl config
        $this->puerto      = 465;
        $this->smtp_secure = 'ssl';
    }

    public function send() {
        // require 'vendor/autoload.php'; // load Composer's autoloader

        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        $obtenerCorreo = new ObtenerCorreo;
        $correoDatos = $obtenerCorreo->getCorreo();
        //error_log(print_r($correoDatos,true));

        try {
            // Server settings
            $mail->SMTPDebug  = 0; // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $correoDatos->DIRECCION;
            $mail->Password   = $correoDatos->INDICIO;
            $mail->SMTPSecure = $this->smtp_secure;
            $mail->Port       = $this->puerto;

            //Datos de emisor
            $mail->setFrom($this->config['correo_emisor'], $this->config['nombre_emisor']);

            //array de correos receptores
            if ($this->config['correos_receptores']){
                foreach ($this->config['correos_receptores'] as $correo) {
                    $mail->addAddress($correo);
                }
            }

            // Datos de receptor con copia
            if (isset($this->config['correos_copia'])){
                foreach ($this->config['correos_copia'] as $correo) {
                    $mail->addCC($correo);
                }
            }

            // Datos de receptor con copia oculta
            if (isset($this->config['correos_copia_oculta'])){
                foreach ($this->config['correos_copia_oculta'] as $correo) {
                    $mail->addBCC($correo);
                }
            }

            // Array de archivos adjuntos
            if (isset($this->config['adjuntos'])) {
                foreach ($this->config['adjuntos'] as $adjunto) {
                    $mail->addAttachment($adjunto['ruta'], $adjunto['nombre']);
                }
            }

            //Content
            $mail->isHTML(true);
            $mail->Subject = $this->config['asunto'];
            $mail->Body    = $this->config['cuerpo_html'];

            if($mail->send()){
                $obtenerCorreo->aumentarContador($correoDatos->PK_ENVIO_CORREO,$correoDatos->PK_CORREO);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log("Error en envío de correo desde clase: App/Helpers/Mailer.php");
            error_log("Detalle del error:");
            error_log($e->getMessage());

            return false;
        }
    }

}
