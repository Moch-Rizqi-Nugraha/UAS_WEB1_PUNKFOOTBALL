<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventParticipantApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;
    public $user;

    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Great news!')
            ->line("Your participation for **{$this->event->name}** has been approved!")
            ->line("Event Date: " . $this->event->event_date->format('F d, Y'))
            ->line("Location: " . $this->event->location)
            ->action('View Event', url("/user/events/{$this->event->id}"))
            ->line('Thank you for joining Punk Football!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => "Event Participation Approved",
            'message' => "Your participation for {$this->event->name} has been approved!",
            'event_id' => $this->event->id,
            'type' => 'event_approved',
        ];
    }
}
