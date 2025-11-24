<?php

namespace App\Notifications;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ScheduleCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Schedule $schedule
    ) {
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
                    ->subject('New Garbage Collection Schedule - Cleanify')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('A new garbage collection schedule has been created for your area.')
                    ->line('**Schedule Details:**')
                    ->line('📍 Area: ' . $this->schedule->area)
                    ->line('📅 Days: ' . $this->schedule->days)
                    ->line('⏰ Time: ' . $this->schedule->formatted_time_range)
                    ->line('🚛 Truck: ' . $this->schedule->truck)
                    ->line('✅ Status: ' . ucfirst($this->schedule->status))
                    ->action('View Schedule', url('/garbage-schedule'))
                    ->line('Please prepare your garbage for collection on the scheduled days.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'schedule_id' => $this->schedule->id,
            'area' => $this->schedule->area,
            'status' => $this->schedule->status,
        ];
    }
}
