<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistration extends Notification 
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $name;
    protected $email;
    public function __construct($user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/dashboard');
        return (new MailMessage)
                    ->greeting('Hello,')
                    ->line(ucfirst($this->name).' Your registration was successful')
                    ->action('Click to View', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => ucfirst($this->name).' just registered now with email '. $this->email
        ];
    }
}
