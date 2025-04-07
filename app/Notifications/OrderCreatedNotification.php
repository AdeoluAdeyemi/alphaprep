<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    public $subject;
    public $message;
    public $fromMail;
    public $mailer;

    // You're in! Order confirmation for "Rock Paper Scissors - Python Tutorial.”
    // You're in! Here's your order confirmation.
    // Order complete! Start learning now.

    /**
     * Create a new notification instance.
     */
    public function __construct(string $orderId)
    {
        //
        $this->subject = '';
        $this->message = '';
        $this->fromMail = '';
        $this->mailer = 'smtp';

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->mailer($this->mailer)
                    ->subject()
                    ->greeting('Hi '.$notifiable->first_name)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
            //
        ];
    }
}
