<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyCreatedNotification extends Notification
{
    use Queueable;

    protected $company;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($company, $password)
    {
        $this->company = $company;
        $this->password = $password;
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
        return (new MailMessage) ->subject(ucwords("Welcome ".$this->company->name))
                    ->greeting("Hello ".$this->company->name.", ")
                    ->line('Welcome to Glade Portal')
                    ->line('Here are yout login information')
                    ->line("--------------------------------: ")
                    ->line("Email: " . $this->company->user->email)
                    ->line("Password: " . $this->password);
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
