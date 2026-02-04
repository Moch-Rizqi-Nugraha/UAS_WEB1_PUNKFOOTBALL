<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketPurchaseConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $event = $this->ticket->event;
        
        return (new MailMessage)
            ->greeting('Ticket Purchase Confirmed!')
            ->line("Your ticket for **{$event->name}** has been purchased successfully!")
            ->line("Ticket #: " . $this->ticket->ticket_number)
            ->line("Price: Rp " . number_format($this->ticket->price, 0, ',', '.'))
            ->line("Event Date: " . $event->event_date->format('F d, Y'))
            ->action('View Ticket', url("/user/tickets/{$this->ticket->id}"))
            ->line('Thank you for your purchase!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => "Ticket Purchase Confirmed",
            'message' => "Your ticket #{$this->ticket->ticket_number} for {$this->ticket->event->name} has been confirmed.",
            'ticket_id' => $this->ticket->id,
            'event_id' => $this->ticket->event->id,
            'type' => 'ticket_purchased',
        ];
    }
}
