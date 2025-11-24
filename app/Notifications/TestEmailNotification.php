<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Only send if user has email notifications enabled
        if ($notifiable->email_notifications ?? true) {
            return ['mail'];
        }
        return [];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Test Email Notification - Cleanify Admin')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('This is a test email notification from Cleanify Admin Panel.')
                    ->line('If you received this email, it means your email notifications are working correctly!')
                    ->line('You can manage your notification preferences in the Admin Settings page.')
                    ->action('Go to Settings', url('/admin/settings'))
                    ->line('Thank you for using Cleanify!');
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
