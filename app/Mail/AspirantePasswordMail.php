<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class AspirantePasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    public $CORREO1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token,$CORREO1)
    {
        $this->token = $token;
        $this->CORREO1 = $CORREO1;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.aspirantePassword')->from('us@example.com', 'ITL')->with([
            'token' => $this->token,
            'CORREO1' => $this->CORREO1
        ]);
    }
}