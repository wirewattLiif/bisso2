<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudMasInformacion extends Mailable
{
    use Queueable, SerializesModels;
    public $cliente;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hola@wirewatt.com','Wirewatt')
            ->subject('No podemos pre-autorizar, necesitamos más información.')
            ->markdown('emails.solicitudes.solicitud_mas_informacion');
    }
}
