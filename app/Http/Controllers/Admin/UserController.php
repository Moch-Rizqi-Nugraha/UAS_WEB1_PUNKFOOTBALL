<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EventParticipant;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                        ->orWhere('email', 'like', "%$search%"))
            ->with(['eventParticipations', 'tickets', 'transactions'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.users.index', compact('users', 'search'));
    }

    public function show(User $user)
    {
        // Load all user activities
        $user->load([
            'eventParticipations' => fn($q) => $q->with('event')->latest(),
            'tickets' => fn($q) => $q->with('event')->latest(),
            'transactions' => fn($q) => $q->latest(),
        ]);

        // Get statistics
        $stats = [
            'events_joined' => $user->eventParticipations()->count(),
            'tickets_purchased' => $user->tickets()->count(),
            'transactions_total' => $user->transactions()->count(),
            'amount_spent' => $user->transactions()->where('status', 'completed')->sum('amount'),
        ];

        // Recent activities
        $recent_events = $user->eventParticipations()->with('event')->latest()->take(5)->get();
        $recent_tickets = $user->tickets()->with('event')->latest()->take(5)->get();
        $recent_transactions = $user->transactions()->latest()->take(5)->get();

        return view('admin.users.show', compact('user', 'stats', 'recent_events', 'recent_tickets', 'recent_transactions'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user,moderator',
        ]);
        
        $user->update($request->only(['name', 'email', 'role']));
        
        return redirect()->route('admin.users.show', $user->id)->with('success', 'User updated successfully.');
    }

    /**
     * View user's events
     */
    public function viewEvents(User $user)
    {
        $events = $user->eventParticipations()
                      ->with('event')
                      ->paginate(10);
        
        return view('admin.users.events', compact('user', 'events'));
    }

    /**
     * View user's tickets
     */
    public function viewTickets(User $user)
    {
        $tickets = $user->tickets()
                       ->with('event')
                       ->paginate(10);
        
        return view('admin.users.tickets', compact('user', 'tickets'));
    }

    /**
     * View user's transactions
     */
    public function viewTransactions(User $user)
    {
        $transactions = $user->transactions()
                            ->paginate(10);
        
        return view('admin.users.transactions', compact('user', 'transactions'));
    }

    /**
     * Update user's event participation status
     */
    public function updateEventStatus(User $user, EventParticipant $participation, Request $request)
    {
        $request->validate([
            'status' => 'required|in:registered,confirmed,completed,cancelled',
        ]);

        $participation->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Event participation status updated.'
        ]);
    }

    /**
     * Remove user from event
     */
    public function removeFromEvent(User $user, EventParticipant $participation)
    {
        $participation->delete();

        return redirect()->back()->with('success', 'User removed from event.');
    }

    /**
     * Get users list as JSON API
     */
    public function indexApi(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                        ->orWhere('email', 'like', "%$search%"))
            ->with(['eventParticipations', 'tickets', 'transactions'])
            ->latest()
            ->paginate(15);
        
        return response()->json($users);
    }

    /**
     * Get single user details as JSON API
     */
    public function showApi(User $user)
    {
        $user->load([
            'eventParticipations' => fn($q) => $q->with('event')->latest(),
            'tickets' => fn($q) => $q->with('event')->latest(),
            'transactions' => fn($q) => $q->latest(),
        ]);

        $stats = [
            'events_joined' => $user->eventParticipations()->count(),
            'tickets_purchased' => $user->tickets()->count(),
            'transactions_total' => $user->transactions()->count(),
            'amount_spent' => $user->transactions()->where('status', 'completed')->sum('amount'),
        ];

        return response()->json([
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    /**
     * Get user activities as JSON API
     */
    public function userActivitiesApi(User $user)
    {
        $activities = [
            'events' => $user->eventParticipations()->with('event')->latest()->take(10)->get(),
            'tickets' => $user->tickets()->with('event')->latest()->take(10)->get(),
            'transactions' => $user->transactions()->latest()->take(10)->get(),
        ];

        return response()->json($activities);
    }
}
