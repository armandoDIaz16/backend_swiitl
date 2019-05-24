<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class CorreoAspirantesMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mensaje;
    public $asunto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje,$asunto)
    {
        $this->mensaje = $mensaje;
        $this->asunto = $asunto;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.correoAspirantes')->subject($this->asunto)->from('us@example.com', 'ITL')->with([
            'mensaje' => $this->mensaje
        ]);
    }
}