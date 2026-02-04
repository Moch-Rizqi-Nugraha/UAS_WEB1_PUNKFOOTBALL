<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    use ApiResponse;

    /**
     * Authorization check
     */
    public function checkAdminAccess()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Get all tickets with search, filter, and pagination
     */
    public function index(Request $request)
    {
        try {
            $this->checkAdminAccess();

            $search = $request->input('search');
            $filter = $request->input('filter', 'all');
            $perPage = $request->input('per_page', 15);

            $tickets = Ticket::query()
                ->with(['user', 'event'])
                ->when($search, fn($q) => 
                    $q->where('ticket_number', 'like', "%$search%")
                      ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                      ->orWhereHas('event', fn($e) => $e->where('name', 'like', "%$search%"))
                )
                ->when($filter !== 'all', fn($q) => $q->where('status', $filter))
                ->orderBy('purchase_date', 'desc')
                ->paginate($perPage);

            $stats = [
                'total_tickets' => Ticket::count(),
                'available' => Ticket::available()->count(),
                'used' => Ticket::used()->count(),
                'expired' => Ticket::expired()->count(),
                'revenue' => Ticket::sum('price'),
            ];

            return request()->expectsJson() 
                ? $this->successResponse(['tickets' => $tickets, 'stats' => $stats])
                : view('admin.tickets.index', compact('tickets', 'search', 'filter', 'stats'));
        } catch (\Exception $e) {
            Log::error('Error fetching tickets: ' . $e->getMessage());
            return request()->expectsJson() 
                ? $this->serverErrorResponse('Failed to fetch tickets')
                : back()->with('error', 'Failed to fetch tickets');
        }
    }

    /**
     * Show ticket creation form
     */
    public function create()
    {
        try {
            $this->checkAdminAccess();

            $events = Event::active()->upcoming()->get();
            $users = User::where('role', 'user')->get();

            return view('admin.tickets.create', compact('events', 'users'));
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load form');
        }
    }

    /**
     * Store new tickets
     */
    public function store(Request $request)
    {
        try {
            $this->checkAdminAccess();

            $validated = $request->validate([
                'event_id' => 'required|exists:events,id',
                'user_id' => 'nullable|exists:users,id',
                'quantity' => 'required|integer|min:1|max:100',
                'price' => 'required|numeric|min:0',
            ], [
                'event_id.required' => 'Event is required',
                'quantity.max' => 'Cannot create more than 100 tickets at once',
                'price.required' => 'Price is required',
            ]);

            $event = Event::findOrFail($validated['event_id']);

            if (!$event->isActive()) {
                return back()->with('error', 'Cannot create tickets for inactive event');
            }

            $createdCount = 0;
            for ($i = 0; $i < $validated['quantity']; $i++) {
                Ticket::create([
                    'user_id' => $validated['user_id'] ?? null,
                    'event_id' => $validated['event_id'],
                    'price' => $validated['price'],
                    'status' => 'available',
                    'purchase_date' => now(),
                    'ticket_number' => 'TKT-' . strtoupper(uniqid()),
                ]);
                $createdCount++;
            }

            Log::info("Admin " . Auth::id() . " created $createdCount tickets for event " . $event->id);

            return back()->with('success', "$createdCount ticket(s) created successfully");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating tickets: ' . $e->getMessage());
            return back()->with('error', 'Failed to create tickets');
        }
    }

    /**
     * View single ticket
     */
    public function show(Ticket $ticket)
    {
        try {
            $this->checkAdminAccess();
            
            $ticket->load(['user', 'event']);
            
            return request()->expectsJson()
                ? $this->successResponse($ticket)
                : view('admin.tickets.show', compact('ticket'));
        } catch (\Exception $e) {
            Log::error('Error fetching ticket: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->notFoundResponse()
                : back()->with('error', 'Ticket not found');
        }
    }

    /**
     * Show edit form
     */
    public function edit(Ticket $ticket)
    {
        try {
            $this->checkAdminAccess();

            $events = Event::all();
            $users = User::all();

            return view('admin.tickets.edit', compact('ticket', 'events', 'users'));
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return back()->with('error', 'Failed to load form');
        }
    }

    /**
     * Update ticket
     */
    public function update(Request $request, Ticket $ticket)
    {
        try {
            $this->checkAdminAccess();

            $validated = $request->validate([
                'status' => 'required|in:available,used,expired,cancelled',
                'price' => 'required|numeric|min:0',
            ]);

            $oldStatus = $ticket->status;
            $ticket->update($validated);

            Log::info("Admin " . Auth::id() . " updated ticket {$ticket->id} from {$oldStatus} to {$validated['status']}");

            return back()->with('success', 'Ticket updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating ticket: ' . $e->getMessage());
            return back()->with('error', 'Failed to update ticket');
        }
    }

    /**
     * Delete ticket (soft delete)
     */
    public function destroy(Ticket $ticket)
    {
        try {
            $this->checkAdminAccess();

            Log::info("Admin " . Auth::id() . " deleted ticket {$ticket->id}");
            
            $ticket->delete();

            return back()->with('success', 'Ticket deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting ticket: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete ticket');
        }
    }

    /**
     * Get tickets for specific event
     */
    public function eventTickets(Event $event)
    {
        try {
            $this->checkAdminAccess();

            $tickets = $event->tickets()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            $stats = [
                'total' => $event->tickets()->count(),
                'available' => $event->tickets()->available()->count(),
                'used' => $event->tickets()->used()->count(),
                'expired' => $event->tickets()->expired()->count(),
                'revenue' => $event->tickets()->sum('price'),
            ];

            return request()->expectsJson()
                ? $this->successResponse(compact('event', 'tickets', 'stats'))
                : view('admin.tickets.event-tickets', compact('event', 'tickets', 'stats'));
        } catch (\Exception $e) {
            Log::error('Error fetching event tickets: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->serverErrorResponse()
                : back()->with('error', 'Failed to fetch event tickets');
        }
    }

    /**
     * Get tickets for specific user
     */
    public function userTickets(User $user)
    {
        try {
            $this->checkAdminAccess();

            $tickets = $user->tickets()
                ->with('event')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            $stats = [
                'total' => $user->tickets()->count(),
                'available' => $user->tickets()->available()->count(),
                'used' => $user->tickets()->used()->count(),
                'total_spent' => $user->tickets()->sum('price'),
            ];

            return request()->expectsJson()
                ? $this->successResponse(compact('user', 'tickets', 'stats'))
                : view('admin.tickets.user-tickets', compact('user', 'tickets', 'stats'));
        } catch (\Exception $e) {
            Log::error('Error fetching user tickets: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->serverErrorResponse()
                : back()->with('error', 'Failed to fetch user tickets');
        }
    }

    /**
     * Mark ticket as used
     */
    public function markAsUsed(Ticket $ticket)
    {
        try {
            $this->checkAdminAccess();

            if (!$ticket->isAvailable()) {
                $message = "Ticket is already {$ticket->status}";
                return request()->expectsJson()
                    ? $this->errorResponse($message, null, 422)
                    : back()->with('error', $message);
            }

            $ticket->markAsUsed();

            Log::info("Admin " . Auth::id() . " marked ticket {$ticket->id} as used");

            return request()->expectsJson()
                ? $this->successResponse($ticket, 'Ticket marked as used')
                : back()->with('success', 'Ticket marked as used');
        } catch (\Exception $e) {
            Log::error('Error marking ticket as used: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->serverErrorResponse()
                : back()->with('error', 'Failed to mark ticket as used');
        }
    }

    /**
     * Mark ticket as expired
     */
    public function markAsExpired(Ticket $ticket)
    {
        try {
            $this->checkAdminAccess();

            if (!$ticket->isAvailable()) {
                $message = "Ticket is already {$ticket->status}";
                return request()->expectsJson()
                    ? $this->errorResponse($message, null, 422)
                    : back()->with('error', $message);
            }

            $ticket->markAsExpired();

            Log::info("Admin " . Auth::id() . " marked ticket {$ticket->id} as expired");

            return request()->expectsJson()
                ? $this->successResponse($ticket, 'Ticket marked as expired')
                : back()->with('success', 'Ticket marked as expired');
        } catch (\Exception $e) {
            Log::error('Error marking ticket as expired: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->serverErrorResponse()
                : back()->with('error', 'Failed to mark ticket as expired');
        }
    }

    /**
     * Generate ticket report
     */
    public function report(Request $request)
    {
        try {
            $this->checkAdminAccess();

            $validated = $request->validate([
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            $startDate = $validated['start_date'] 
                ? \Carbon\Carbon::parse($validated['start_date'])->startOfDay()
                : now()->subMonth()->startOfDay();
            
            $endDate = $validated['end_date']
                ? \Carbon\Carbon::parse($validated['end_date'])->endOfDay()
                : now()->endOfDay();

            $tickets = Ticket::whereBetween('purchase_date', [$startDate, $endDate])
                ->with(['user', 'event'])
                ->orderBy('purchase_date', 'desc')
                ->get();

            $stats = [
                'total_sold' => $tickets->count(),
                'total_revenue' => $tickets->sum('price'),
                'average_price' => $tickets->avg('price') ?? 0,
                'by_status' => [
                    'available' => $tickets->where('status', 'available')->count(),
                    'used' => $tickets->where('status', 'used')->count(),
                    'expired' => $tickets->where('status', 'expired')->count(),
                    'cancelled' => $tickets->where('status', 'cancelled')->count(),
                ],
            ];

            return request()->expectsJson()
                ? $this->successResponse(compact('tickets', 'stats', 'startDate', 'endDate'))
                : view('admin.tickets.report', compact('tickets', 'stats', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            Log::error('Error generating report: ' . $e->getMessage());
            return request()->expectsJson()
                ? $this->serverErrorResponse()
                : back()->with('error', 'Failed to generate report');
        }
    }
}

class TicketManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'all'); // all, available, used, expired

        $tickets = Ticket::query()
            ->with(['user', 'event'])
            ->when($search, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                                        ->orWhereHas('event', fn($e) => $e->where('name', 'like', "%$search%")))
            ->when($filter !== 'all', fn($q) => $q->where('status', $filter))
            ->orderBy('purchase_date', 'desc')
            ->paginate(15);

        // Stats
        $stats = [
            'total_tickets' => Ticket::count(),
            'available' => Ticket::where('status', 'available')->count(),
            'used' => Ticket::where('status', 'used')->count(),
            'revenue' => Ticket::sum('price'),
        ];

        return view('admin.tickets.index', compact('tickets', 'search', 'filter', 'stats'));
    }

    public function create()
    {
        $events = Event::all();
        $users = User::all();
        return view('admin.tickets.create', compact('events', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'nullable|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $event = Event::find($request->event_id);
        
        // Create multiple tickets
        for ($i = 0; $i < $request->quantity; $i++) {
            Ticket::create([
                'user_id' => $request->user_id,
                'event_id' => $request->event_id,
                'price' => $request->price,
                'status' => 'available',
                'purchase_date' => now(),
                'ticket_number' => 'TKT-' . uniqid(),
            ]);
        }

        return redirect()->route('admin.tickets.index')->with('success', $request->quantity . ' ticket(s) created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'event']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $events = Event::all();
        $users = User::all();
        return view('admin.tickets.edit', compact('ticket', 'events', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:available,used,expired,cancelled',
            'price' => 'required|numeric|min:0',
        ]);

        $ticket->update([
            'status' => $request->status,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    /**
     * Get event ticket sales
     */
    public function eventTickets(Event $event)
    {
        $tickets = $event->tickets()->with('user')->paginate(15);

        $stats = [
            'total_tickets' => $event->tickets()->count(),
            'available' => $event->tickets()->where('status', 'available')->count(),
            'used' => $event->tickets()->where('status', 'used')->count(),
            'revenue' => $event->tickets()->sum('price'),
        ];

        return view('admin.tickets.event-tickets', compact('event', 'tickets', 'stats'));
    }

    /**
     * Get user's tickets
     */
    public function userTickets(User $user)
    {
        $tickets = $user->tickets()->with('event')->paginate(15);

        $stats = [
            'total_tickets' => $user->tickets()->count(),
            'total_spent' => $user->tickets()->sum('price'),
        ];

        return view('admin.tickets.user-tickets', compact('user', 'tickets', 'stats'));
    }

    /**
     * Mark ticket as used
     */
    public function markAsUsed(Ticket $ticket)
    {
        $ticket->update([
            'status' => 'used',
            'used_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket marked as used.'
        ]);
    }

    /**
     * Mark ticket as expired
     */
    public function markAsExpired(Ticket $ticket)
    {
        $ticket->update(['status' => 'expired']);

        return response()->json([
            'success' => true,
            'message' => 'Ticket marked as expired.'
        ]);
    }

    /**
     * Generate tickets report
     */
    public function report(Request $request)
    {
        $start_date = $request->start_date ? \Carbon\Carbon::parse($request->start_date) : now()->subMonth();
        $end_date = $request->end_date ? \Carbon\Carbon::parse($request->end_date) : now();

        $tickets = Ticket::whereBetween('purchase_date', [$start_date, $end_date])
                        ->with(['user', 'event'])
                        ->orderBy('purchase_date', 'desc')
                        ->get();

        $stats = [
            'total_sold' => $tickets->count(),
            'total_revenue' => $tickets->sum('price'),
            'average_price' => $tickets->avg('price'),
        ];

        return view('admin.tickets.report', compact('tickets', 'stats', 'start_date', 'end_date'));
    }
}
