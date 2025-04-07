<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderConfirmationNotification extends Notification
{  use Queueable;
    public $subject;
    public $message;
    public $fromMail;
    public $mailer;
    public $order_id;
    public $exam_name;

    // You're in! Order confirmation for "Rock Paper Scissors - Python Tutorial.”
    // You're in! Here's your order confirmation.
    // Order complete! Start learning now.

    /**
     * Create a new notification instance.
     */
    public function __construct(string $orderId) //  string $examName
    {
        //
        $this->subject = '';
        $this->message = '';
        $this->fromMail = '';
        $this->mailer = 'smtp';
        $this->order_id = $orderId;
        //$this->exam_name = $examName;

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
        Log::info('I got into Notification class');

        return (new MailMessage)
                    ->mailer($this->mailer)
                    ->subject('Order confirmation for '.$this->order_id .'. Start practicing now!')
                    ->greeting('Your order’s been processed')
                    ->line('You’re all set to start practising. Ready to get started?')
                    ->action('Start Practicing', url(route('order.summary'))); // URL to exam paid for.
                    //->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            $notifiable->email
        ];
    }
}
