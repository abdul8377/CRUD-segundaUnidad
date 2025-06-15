<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    /**
     * Crear una nueva instancia del mensaje.
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        $resetUrl = url("/password/reset?token={$this->token}&email={$this->email}");

        return $this->subject('Restablecer contraseña')
                    ->view('emails.reset_password')
                    ->with([
                        'resetUrl' => $resetUrl,
                        'email' => $this->email,
                    ]);
    }
}
