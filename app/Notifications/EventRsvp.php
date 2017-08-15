<?php

namespace Alanmanderson\HeadCount\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Alanmanderson\HeadCount\Models\Occurrence;

class EventRsvp extends Notification {
    use Queueable;

    private $occurrence;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Occurrence $occurrence) {
        $this->occurrence = $occurrence;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        return [
                'mail', 'nexmo'
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $event = $this->occurrence->event;
        return (new MailMessage)->view(
                'mail.rsvp',
                [
                        "dayOfWeek" => $this->occurrence->start_time->format('l'),
                        "date" => $this->occurrence->start_time->format('F jS'),
                        "time" => $this->occurrence->start_time->format('h:i:s A'),
                        "location" => "$event->address $event->city, $event->state",
                        "userId" => $notifiable->guid,
                    "occuranceId" => $this->occurrence->id,
                    "appUrl" => env('APP_URL')
                ]);
    }

    public function toNexmo($notifiable) {
        $eventName = $this->occurrence->event->name;
        $dayOfWeek = $this->occurrence->start_time->format('l');
        $time = $this->occurrence->start_time->format('h:i:s A');
        $msg = "Are you coming to $eventName this $dayOfWeek at $time? reply y or n";
        return (new NexmoMessage)
            ->content($msg);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [            //
        ];
    }
}
