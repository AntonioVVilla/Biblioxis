<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = url('/verify-email/' . $notifiable->getKey() . '/' . sha1($notifiable->getEmailForVerification()));

        return (new MailMessage)
            ->subject('Verifica tu correo electrónico - ' . config('app.name'))
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Gracias por registrarte en ' . config('app.name') . '.')
            ->line('Por favor, haz clic en el siguiente botón para verificar tu dirección de correo electrónico:')
            ->action('Verificar Correo Electrónico', $verificationUrl)
            ->line('Si no creaste una cuenta, no es necesario realizar ninguna acción.')
            ->salutation('Saludos,<br>' . config('app.name'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
} 