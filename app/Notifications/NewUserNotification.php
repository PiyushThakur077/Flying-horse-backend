<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    private $user;
    private $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Welcome to Our Application')
        ->line('Hello ' . $this->user->name . ',')
        ->line('Welcome to our application! Your account has been successfully created.')
        ->line('Here are your login details:')
        ->line('Email: ' . $this->user->email)
        ->line('Password: ' . $this->password)
        ->line('Thank you for using our application.');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}