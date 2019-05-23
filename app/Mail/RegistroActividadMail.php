<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistroActividadMail extends Mailable
{
    use Queueable, SerializesModels;

    //private $qr;
    public $pk_alumno_act;
    public $name;
    public $name_act;
    public $fecha;
    public $lugar;
    public $hora;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pk_alumno_act, $name, $name_act, $fecha, $lugar, $hora)
    {
        //$this->qr = $qr;
        $this->pk_alumno_act = $pk_alumno_act;
        $this->name = $name;
        $this->name_act = $name_act;
        $this->fecha = $fecha;
        $this->lugar = $lugar;
        $this->hora = $hora;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.registroActividadMail')
                ->attach(public_path().'/creditos-complementarios/codigos-qr-a-c/qrcode-f-'.$this->pk_alumno_act.'.png', [
                    'as' => 'tucodigo.png'
                ])
                ->from('l.gerad95@gmail.com', 'Actividades complementarias - ITL')
                ->subject('Correo de prueba');

    }
}
