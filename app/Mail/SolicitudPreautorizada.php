<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudPreautorizada extends Mailable
{
    use Queueable, SerializesModels;
    public $solicitud;
    public $periodos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitud,$periodos)
    {
        $this->solicitud = $solicitud;
        $this->periodos = $periodos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hola@wirewatt.com','Wirewatt')
                    ->subject('Tu solicitud ha sido pre-autorizada!')
                    ->markdown('emails.solicitudes.solicitud_preautorizada');
    }
}
