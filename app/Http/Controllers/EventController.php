<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display public event listing (for landing page)
     */
    public function publicIndex()
    {
        $events = Event::where('status', 'active')->orderBy('event_date')->take(6)->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show registration page for event
     */
    public function register($id)
    {
        $event = Event::findOrFail($id);
        // Bisa tambahkan form pendaftaran di sini
        return view('events.register', compact('event'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

        // Handle poster upload
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('events', 'public');
            $data['poster'] = $posterPath;
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $participants = $event->participants()->with('user')->paginate(20);
        return view('admin.events.show', compact('event', 'participants'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
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

        // Handle poster upload
        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $posterPath = $request->file('poster')->store('events', 'public');
            $data['poster'] = $posterPath;
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete poster file if exists
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
        $event->update([
            'status' => $event->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->back()->with('success', 'Event status updated successfully.');
    }

    /**
     * Update participant status
     */
    public function updateParticipantStatus(Request $request, Event $event, EventParticipant $participant)
    {
        $request->validate([
            'status' => 'required|in:registered,confirmed,cancelled'
        ]);

        $participant->update(['status' => $request->status]);

        // Update current participants count
        $confirmedCount = $event->confirmedParticipants()->count();
        $event->update(['current_participants' => $confirmedCount]);

        return redirect()->back()->with('success', 'Participant status updated successfully.');
    }
}
