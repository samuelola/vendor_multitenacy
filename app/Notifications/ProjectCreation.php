<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectCreation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    
    public $name;
    public $email;
    public $project_name;
    public function __construct($project)
    {
        $this->name = $project->user->name;
        $this->email = $project->user->email;
        $this->project_name = $project->name;
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
                    ->line(ucfirst($this->name).' You have successfully created this project titled '.$this->project_name)
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
           'data' => $this->name.' with '.$this->email. ' created a project with title '. $this->project_name
        ];
    }
}
