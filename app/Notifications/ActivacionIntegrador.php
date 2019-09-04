<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivacionIntegrador extends Notification
{
    use Queueable;
    public $integrador;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($integrador)
    {
        $this->integrador = $integrador;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $notifiable->email = 'hvillasana@bisso.mx';
        return (new MailMessage)
                ->from('hola@wirewatt.com','Wirewatt')
                ->subject('Activación de usuario')
                ->markdown('emails.integradores.activacion', ['integrador' => $this->integrador]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
