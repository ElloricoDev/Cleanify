<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportResolvedNotification extends Notification
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
                    ->subject('Your Report Has Been Resolved - Cleanify')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('Great news! Your community report has been resolved.')
                    ->line('**Report Details:**')
                    ->line('📍 Location: ' . $this->report->location)
                    ->line('📝 Description: ' . $this->report->description)
                    ->when($this->report->admin_notes, function ($mail) {
                        return $mail->line('**Admin Notes:**')
                                    ->line($this->report->admin_notes);
                    })
                    ->line('Resolved by: ' . $resolverName)
                    ->line('Resolved on: ' . $this->report->resolved_at->format('F d, Y \a\t h:i A'))
                    ->action('View Report', url('/community-reports'))
                    ->line('Thank you for helping keep our community clean!');
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
            'status' => 'resolved',
            'location' => $this->report->location,
        ];
    }
}
