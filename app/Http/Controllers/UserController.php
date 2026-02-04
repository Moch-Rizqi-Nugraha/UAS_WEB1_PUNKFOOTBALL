<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display user welcome page
     */
    public function welcome()
    {
        $user = auth()->user();

        // Get statistics for the user
        $stats = [
            'events_joined' => $user->eventParticipations()->count(),
            'tickets' => $user->tickets()->count(),
            'purchases' => $user->transactions()->where('status', 'completed')->count(),
            'total_spent' => $user->transactions()->where('status', 'completed')->sum('amount'),
        ];

        return view('user.welcome', compact('user', 'stats'));
    }

    /**
     * Display user dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Real data for user dashboard with recent items
        $stats = [
            'events_joined' => $user->eventParticipations()->count(),
            'tickets_purchased' => $user->tickets()->count(),
            'marketplace_purchases' => $user->transactions()->where('status', 'completed')->count(),
        ];

        // Get recent events, tickets, and transactions
        $recent_events = $user->eventParticipations()
                              ->with('event')
                              ->latest()
                              ->take(5)
                              ->get();

        $recent_tickets = $user->tickets()
                              ->with('event')
                              ->latest()
                              ->take(5)
                              ->get();

        $recent_purchases = $user->transactions()
                                 ->where('status', 'completed')
                                 ->latest()
                                 ->take(5)
                                 ->get();

        return view('user.dashboard', compact('user', 'stats', 'recent_events', 'recent_tickets', 'recent_purchases'));
    }

    /**
     * Display user profile
     */
    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($request->only(['name', 'email']));

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Display user's events with proper relationships
     */
    public function events()
    {
        $user = auth()->user();
        
        // Get all participations with event details
        $participations = $user->eventParticipations()
                              ->with('event')
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

        // Separate by status
        $upcoming = $user->eventParticipations()
                         ->with('event')
                         ->where('status', 'registered')
                         ->whereHas('event', function($q) {
                             $q->where('event_date', '>=', now());
                         })
                         ->get();

        $confirmed = $user->eventParticipations()
                          ->with('event')
                          ->where('status', 'confirmed')
                          ->get();

        $completed = $user->eventParticipations()
                          ->with('event')
                          ->where('status', 'completed')
                          ->get();

        // Format events for view
        $events = $participations->map(function($participation) {
            return [
                'name' => $participation->event?->name ?? 'Unknown Event',
                'status' => $participation->status,
                'date' => $participation->event?->event_date,
                'location' => $participation->event?->location,
                'id' => $participation->id,
            ];
        });

        return view('user.events', compact('participations', 'upcoming', 'confirmed', 'completed', 'events'));
    }

    /**
     * Display user's tickets with proper relationships
     */
    public function tickets()
    {
        $user = auth()->user();
        
        $tickets = $user->tickets()
                       ->with('event')
                       ->orderBy('purchase_date', 'desc')
                       ->paginate(10);

        // Summary stats
        $stats = [
            'total_tickets' => $user->tickets()->count(),
            'used_tickets' => $user->tickets()->where('status', 'used')->count(),
            'available_tickets' => $user->tickets()->where('status', 'available')->count(),
            'total_spent' => $user->tickets()->sum('price'),
        ];

        return view('user.tickets', compact('tickets', 'stats'));
    }

    /**
     * Display user's marketplace purchases
     */
    public function marketplace()
    {
        $user = auth()->user();
        
        $transactions = $user->transactions()
                            ->with('product')
                            ->where('transaction_type', 'purchase')
                            ->orderBy('transaction_date', 'desc')
                            ->paginate(10);

        // Summary stats
        $stats = [
            'total_purchases' => $user->transactions()->where('transaction_type', 'purchase')->count(),
            'completed' => $user->transactions()->where('transaction_type', 'purchase')->where('status', 'completed')->count(),
            'pending' => $user->transactions()->where('transaction_type', 'purchase')->where('status', 'pending')->count(),
            'total_spent' => $user->transactions()->where('transaction_type', 'purchase')->where('status', 'completed')->sum('amount'),
        ];

        return view('user.marketplace', compact('transactions', 'stats'));
    }

    /**
     * Buy a product from marketplace
     */
    public function buyProduct(Request $request, $productId)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $user = auth()->user();
        $quantity = 1; // default quantity

        // Check stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Decrease stock
        $product->decrement('stock', $quantity);

        // Create transaction
        \App\Models\Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'item_name' => $product->name,
            'amount' => $product->price * $quantity,
            'total_price' => $product->price * $quantity,
            'quantity' => $quantity,
            'status' => 'completed',
            'transaction_type' => 'purchase',
            'transaction_date' => now(),
            'transaction_data' => [
                'quantity' => $quantity,
                'price' => $product->price,
                'product_name' => $product->name,
            ],
        ]);

        return redirect()->route('user.marketplace')->with('success', 'Produk berhasil dibeli! Silakan cek riwayat pembelian Anda.');
    }

    /**
     * Join an event
     */
    public function joinEvent(Request $request, Event $event)
    {
        $user = auth()->user();

        // Check if already registered
        if ($event->participants()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event.'
            ], 422);
        }

        // Check event availability
        if (!$event->hasAvailableSpots()) {
            return response()->json([
                'success' => false,
                'message' => 'This event is full. No more spots available.'
            ], 422);
        }

        // Create participation record
        $participation = $event->participants()->create([
            'user_id' => $user->id,
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        // Update event participant count
        $event->increment('current_participants');

        return response()->json([
            'success' => true,
            'message' => 'Successfully joined the event.',
            'redirect' => route('user.events')
        ]);
    }

    /**
     * Leave an event
     */
    public function leaveEvent(Request $request, Event $event)
    {
        $user = auth()->user();

        $participation = $event->participants()->where('user_id', $user->id)->first();

        if (!$participation) {
            return response()->json([
                'success' => false,
                'message' => 'You are not registered for this event.'
            ], 422);
        }

        // Check if event has started
        if ($event->event_date < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot leave an event that has already started.'
            ], 422);
        }

        $participation->delete();

        // Update event participant count
        $event->decrement('current_participants');

        return response()->json([
            'success' => true,
            'message' => 'Successfully left the event.',
            'redirect' => route('user.events')
        ]);
    }

    /**
     * Buy ticket for event
     */
    public function buyTicket(Request $request, Event $event)
    {
        $user = auth()->user();

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->quantity;
        $totalAmount = $event->price * $quantity;

        // Create transaction
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => 'ticket',
            'item_name' => $event->name,
            'amount' => $totalAmount,
            'status' => 'completed',
            'transaction_date' => now(),
        ]);

        // Create tickets
        for ($i = 0; $i < $quantity; $i++) {
            Ticket::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'price' => $event->price,
                'status' => 'available',
                'purchase_date' => now(),
                'ticket_number' => 'TKT-' . uniqid(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tickets purchased successfully.',
            'redirect' => route('user.tickets')
        ]);
    }

    // ============ API METHODS FOR MOBILE/EXTERNAL APPS ============

    /**
     * Get dashboard data as JSON API
     */
    public function dashboardApi()
    {
        $user = auth()->user();

        $stats = [
            'events_joined' => $user->eventParticipations()->count(),
            'tickets_purchased' => $user->tickets()->count(),
            'marketplace_purchases' => $user->transactions()->where('status', 'completed')->count(),
        ];

        $recent_events = $user->eventParticipations()
                              ->with('event')
                              ->latest()
                              ->take(5)
                              ->get();

        $recent_tickets = $user->tickets()
                              ->with('event')
                              ->latest()
                              ->take(5)
                              ->get();

        $recent_purchases = $user->transactions()
                                 ->where('status', 'completed')
                                 ->latest()
                                 ->take(5)
                                 ->get();

        return response()->json([
            'user' => $user,
            'stats' => $stats,
            'recent_events' => $recent_events,
            'recent_tickets' => $recent_tickets,
            'recent_purchases' => $recent_purchases,
        ]);
    }

    /**
     * Get user events as JSON API
     */
    public function eventsApi()
    {
        $user = auth()->user();
        
        $participations = $user->eventParticipations()
                              ->with('event')
                              ->latest()
                              ->get();

        $upcoming = $user->eventParticipations()
                         ->with('event')
                         ->where('status', 'registered')
                         ->whereHas('event', function($q) {
                             $q->where('event_date', '>=', now());
                         })
                         ->get();

        $confirmed = $user->eventParticipations()
                          ->with('event')
                          ->where('status', 'confirmed')
                          ->get();

        return response()->json([
            'all' => $participations,
            'upcoming' => $upcoming,
            'confirmed' => $confirmed,
        ]);
    }

    /**
     * Get user tickets as JSON API
     */
    public function ticketsApi()
    {
        $user = auth()->user();
        
        $tickets = $user->tickets()
                       ->with('event')
                       ->latest()
                       ->get();

        $stats = [
            'total_tickets' => $user->tickets()->count(),
            'used_tickets' => $user->tickets()->where('status', 'used')->count(),
            'available_tickets' => $user->tickets()->where('status', 'available')->count(),
            'total_spent' => $user->tickets()->sum('price'),
        ];

        return response()->json([
            'tickets' => $tickets,
            'stats' => $stats,
        ]);
    }

    /**
     * Get user marketplace purchases as JSON API
     */
    public function marketplaceApi()
    {
        $user = auth()->user();
        
        $transactions = $user->transactions()
                            ->with(['product'])
                            ->latest()
                            ->get();

        $stats = [
            'total_purchases' => $user->transactions()->count(),
            'completed' => $user->transactions()->where('status', 'completed')->count(),
            'pending' => $user->transactions()->where('status', 'pending')->count(),
            'total_spent' => $user->transactions()->where('status', 'completed')->sum('amount'),
        ];

        return response()->json([
            'transactions' => $transactions,
            'stats' => $stats,
        ]);
    }
}
