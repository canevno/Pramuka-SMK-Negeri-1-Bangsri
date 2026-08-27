<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;

class NewBantaraRegistration extends Notification
{
    use Queueable;

    protected $registration;

    public function __construct($registration)
    {
        $this->registration = $registration;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'bantara_registration',
            'registration_id' => $this->registration->id,
            'nama' => $this->registration->nama,
            'message' => 'Pendaftaran baru: ' . $this->registration->nama,
            'url' => route('admin.pendaftaran'),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pendaftaran Bantara Baru')
                    ->line('Ada pendaftaran Bantara baru dari: ' . $this->registration->nama)
                    ->action('Lihat Pendaftaran', route('admin.pendaftaran'));
    }
}
