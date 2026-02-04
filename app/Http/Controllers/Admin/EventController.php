<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'all'); // all, active, inactive
        
        $events = Event::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                        ->orWhere('description', 'like', "%$search%"))
            ->when($filter !== 'all', fn($q) => $q->where('status', $filter))
            ->with(['participants'])
            ->orderBy('event_date', 'desc')
            ->paginate(15);
            
        return view('admin.events.index', compact('events', 'search', 'filter'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'category' => 'required|in:turnamen,pelatihan,friendly_match',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['current_participants'] = 0;

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load(['participants' => fn($q) => $q->with('user')]);
        
        $stats = [
            'total_participants' => $event->participants()->count(),
            'confirmed' => $event->participants()->where('status', 'confirmed')->count(),
            'registered' => $event->participants()->where('status', 'registered')->count(),
            'available_spots' => $event->getAvailableSpots(),
        ];

        $participants = $event->participants()->with('user')->paginate(20);

        return view('admin.events.show', compact('event', 'stats', 'participants'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'category' => 'required|in:turnamen,pelatihan,friendly_match',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $data['poster'] = $request->file('poster')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        // Delete all participants
        $event->participants()->delete();

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    /**
     * Toggle event status
     */
    public function toggleStatus(Event $event)
    {
        $event->status = $event->status === 'active' ? 'inactive' : 'active';
        $event->save();

        return redirect()->back()->with('success', 'Event status updated.');
    }

    /**
     * Update participant status
     */
    public function updateParticipantStatus(Event $event, EventParticipant $participant, Request $request)
    {
        $request->validate([
            'status' => 'required|in:registered,confirmed,completed,cancelled',
        ]);

        $participant->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Participant status updated.'
        ]);
    }

    /**
     * Remove participant from event
     */
    public function removeParticipant(Event $event, EventParticipant $participant)
    {
        $participant->delete();
        $event->decrement('current_participants');

        return redirect()->back()->with('success', 'Participant removed from event.');
    }

    /**
     * Approve all pending participants
     */
    public function approvePendingParticipants(Event $event)
    {
        $event->participants()
              ->where('status', 'registered')
              ->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'All pending participants approved.');
    }

    /**
     * Get events list as JSON API
     */
    public function indexApi(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'all');
        
        $events = Event::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                                        ->orWhere('description', 'like', "%$search%"))
            ->when($filter !== 'all', fn($q) => $q->where('status', $filter))
            ->with(['participants'])
            ->latest()
            ->paginate(15);
            
        return response()->json($events);
    }

    /**
     * Get single event details as JSON API
     */
    public function showApi(Event $event)
    {
        $event->load(['participants' => fn($q) => $q->with('user')]);
        
        $stats = [
            'total_participants' => $event->participants()->count(),
            'confirmed' => $event->participants()->where('status', 'confirmed')->count(),
            'registered' => $event->participants()->where('status', 'registered')->count(),
            'available_spots' => $event->getAvailableSpots(),
        ];

        return response()->json([
            'event' => $event,
            'stats' => $stats,
        ]);
    }

    /**
     * Get event participants as JSON API
     */
    public function participantsApi(Event $event)
    {
        $participants = $event->participants()
                             ->with('user')
                             ->latest()
                             ->paginate(20);

        return response()->json($participants);
    }

    /**
     * Update participant status via API
     */
    public function updateParticipantStatusApi(Event $event, EventParticipant $participant, Request $request)
    {
        $request->validate([
            'status' => 'required|in:registered,confirmed,completed,cancelled',
        ]);

        $participant->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Participant status updated.',
            'participant' => $participant,
        ]);
    }
}
