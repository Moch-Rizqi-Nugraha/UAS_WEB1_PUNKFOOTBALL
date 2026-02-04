<?php

namespace App\Utilities;

/**
 * User-Admin Integration Helper
 * 
 * Provides convenient methods untuk mengakses user-admin integrated data
 */
class IntegrationHelper
{
    /**
     * Get complete user activity summary
     */
    public static function getUserActivitySummary($userId)
    {
        $user = \App\Models\User::findOrFail($userId);

        return [
            'user' => $user,
            'events' => [
                'total' => $user->eventParticipations()->count(),
                'upcoming' => $user->eventParticipations()
                    ->whereHas('event', fn($q) => $q->where('event_date', '>=', now()))
                    ->count(),
                'completed' => $user->eventParticipations()
                    ->where('status', 'completed')
                    ->count(),
            ],
            'tickets' => [
                'total' => $user->tickets()->count(),
                'available' => $user->tickets()->where('status', 'available')->count(),
                'used' => $user->tickets()->where('status', 'used')->count(),
                'total_spent' => $user->tickets()->sum('price'),
            ],
            'transactions' => [
                'total' => $user->transactions()->count(),
                'completed' => $user->transactions()->where('status', 'completed')->count(),
                'pending' => $user->transactions()->where('status', 'pending')->count(),
                'total_amount' => $user->transactions()->where('status', 'completed')->sum('amount'),
            ],
        ];
    }

    /**
     * Get event management summary
     */
    public static function getEventManagementSummary($eventId)
    {
        $event = \App\Models\Event::findOrFail($eventId);

        return [
            'event' => $event,
            'participants' => [
                'total' => $event->participants()->count(),
                'registered' => $event->participants()->where('status', 'registered')->count(),
                'confirmed' => $event->participants()->where('status', 'confirmed')->count(),
                'completed' => $event->participants()->where('status', 'completed')->count(),
                'available_spots' => $event->getAvailableSpots(),
            ],
            'tickets' => [
                'total_sold' => $event->tickets()->count(),
                'revenue' => $event->tickets()->sum('price'),
                'available' => $event->tickets()->where('status', 'available')->count(),
                'used' => $event->tickets()->where('status', 'used')->count(),
            ],
        ];
    }

    /**
     * Get marketplace summary
     */
    public static function getMarketplaceSummary()
    {
        return [
            'products' => [
                'total' => \App\Models\Product::count(),
                'total_stock' => \App\Models\Product::sum('stock'),
            ],
            'transactions' => [
                'total' => \App\Models\Transaction::count(),
                'completed' => \App\Models\Transaction::where('status', 'completed')->count(),
                'pending' => \App\Models\Transaction::where('status', 'pending')->count(),
                'revenue' => \App\Models\Transaction::where('status', 'completed')->sum('amount'),
            ],
        ];
    }

    /**
     * Check if user can join event
     */
    public static function canUserJoinEvent($user, $event)
    {
        $errors = [];

        // Check if user already registered
        if ($event->participants()->where('user_id', $user->id)->exists()) {
            $errors[] = 'User sudah terdaftar untuk event ini';
        }

        // Check event availability
        if (!$event->hasAvailableSpots()) {
            $errors[] = 'Event sudah penuh, tidak ada spot tersedia';
        }

        // Check event status
        if ($event->status !== 'active') {
            $errors[] = 'Event tidak aktif';
        }

        return [
            'can_join' => count($errors) === 0,
            'errors' => $errors,
        ];
    }

    /**
     * Process event participant approval
     */
    public static function approveEventParticipant($participantId)
    {
        $participant = \App\Models\EventParticipant::findOrFail($participantId);
        $participant->status = 'confirmed';
        $participant->save();

        return $participant;
    }

    /**
     * Process event completion
     */
    public static function completeEventParticipant($participantId)
    {
        $participant = \App\Models\EventParticipant::findOrFail($participantId);
        $participant->status = 'completed';
        $participant->save();

        return $participant;
    }

    /**
     * Generate event report
     */
    public static function generateEventReport($eventId)
    {
        $summary = self::getEventManagementSummary($eventId);

        return [
            'event_name' => $summary['event']->name,
            'event_date' => $summary['event']->event_date,
            'location' => $summary['event']->location,
            'participant_summary' => $summary['participants'],
            'ticket_summary' => $summary['tickets'],
            'total_revenue' => $summary['tickets']['revenue'],
            'generated_at' => now(),
        ];
    }

    /**
     * Generate user activity report
     */
    public static function generateUserActivityReport($userId)
    {
        $summary = self::getUserActivitySummary($userId);

        return [
            'user_name' => $summary['user']->name,
            'user_email' => $summary['user']->email,
            'event_summary' => $summary['events'],
            'ticket_summary' => $summary['tickets'],
            'transaction_summary' => $summary['transactions'],
            'total_spent' => $summary['transactions']['total_amount'] + $summary['tickets']['total_spent'],
            'generated_at' => now(),
        ];
    }

    /**
     * Get dashboard statistics
     */
    public static function getDashboardStatistics()
    {
        return [
            'users' => [
                'total' => \App\Models\User::count(),
                'admins' => \App\Models\User::where('role', 'admin')->count(),
                'regular' => \App\Models\User::where('role', 'user')->count(),
                'new_this_month' => \App\Models\User::whereMonth('created_at', now()->month)->count(),
            ],
            'events' => [
                'total' => \App\Models\Event::count(),
                'active' => \App\Models\Event::where('status', 'active')->count(),
                'inactive' => \App\Models\Event::where('status', 'inactive')->count(),
                'total_participants' => \App\Models\EventParticipant::count(),
            ],
            'tickets' => [
                'total_sold' => \App\Models\Ticket::count(),
                'available' => \App\Models\Ticket::where('status', 'available')->count(),
                'used' => \App\Models\Ticket::where('status', 'used')->count(),
                'revenue' => \App\Models\Ticket::sum('price'),
            ],
            'marketplace' => [
                'total_products' => \App\Models\Product::count(),
                'total_transactions' => \App\Models\Transaction::count(),
                'completed_sales' => \App\Models\Transaction::where('status', 'completed')->sum('amount'),
                'pending_sales' => \App\Models\Transaction::where('status', 'pending')->sum('amount'),
            ],
        ];
    }
}
