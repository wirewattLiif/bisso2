<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CotizacionInicial extends Mailable
{
    use Queueable, SerializesModels;
    public $solicitud;
    public $primer_mensualidad;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitud,$primer_mensualidad)
    {
        $this->solicitud = $solicitud;
        $this->primer_mensualidad = $primer_mensualidad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hola@wirewatt.com','Wirewatt')
                ->subject('Este el resultado de la cotización de préstamo solar Wirewatt.')
                ->attach($this->solicitud->id.'.pdf')
                ->markdown('emails.solicitudes.cotizacion_inicial');
    }
}
