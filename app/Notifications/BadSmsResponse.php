<?php

namespace Alanmanderson\HeadCount\Notifications;

use Alanmanderson\HeadCount\Services\NexmoInboundSms;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class BadSmsResponse extends Notification {
    use Queueable;

    private $sms;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NexmoInboundSms $sms) {
        $this->sms = $sms;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['nexmo'];
    }

    public function toNexmo($notifiable) {
        $msg = "{$this->sms->keyword} is not a valid response.  Reply with HELP for more information.";
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
        return [];
    }
}
