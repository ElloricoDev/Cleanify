<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportRejectedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Report $report
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
        $resolver = $this->report->resolver;
        $resolverName = $resolver ? $resolver->name : 'Admin';
        
        return (new MailMessage)
                    ->subject('Report Status Update - Cleanify')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('We wanted to inform you about the status of your community report.')
                    ->line('**Report Details:**')
                    ->line('📍 Location: ' . $this->report->location)
                    ->line('📝 Description: ' . $this->report->description)
                    ->line('**Status:** Rejected')
                    ->when($this->report->rejection_reason, function ($mail) {
                        return $mail->line('**Reason:**')
                                    ->line($this->report->rejection_reason);
                    })
                    ->line('Reviewed by: ' . $resolverName)
                    ->line('Reviewed on: ' . $this->report->resolved_at->format('F d, Y \a\t h:i A'))
                    ->action('View Report', url('/community-reports'))
                    ->line('If you have any questions, please feel free to submit a new report.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'status' => 'rejected',
            'location' => $this->report->location,
        ];
    }
}
