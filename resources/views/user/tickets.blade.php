@extends('user.layout')

@section('title', 'My Tickets - Punk Football')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900">🎟️ My Tickets</h1>
        <p class="mt-2 text-gray-600">View and manage your purchased event tickets</p>
    </div>

    @if($tickets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($tickets as $ticket)
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h3 class="text-xl font-semibold text-blue-700">{{ $ticket->event->name }}</h3>
                                <div class="text-xs text-gray-500">{{ $ticket->event->event_date->format('d M Y, H:i') }} • {{ $ticket->event->location }}</div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $ticket->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                   ($ticket->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ strtoupper($ticket->status) }}
                            </span>
                        </div>
                        <div class="mt-4 space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Ticket Code:</span>
                                <span class="font-mono text-gray-900">{{ $ticket->ticket_code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Price:</span>
                                <span class="text-gray-900">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Purchase Date:</span>
                                <span class="text-gray-900">{{ $ticket->purchase_date->format('d M Y') }}</span>
                            </div>
                        </div>
                        @if($ticket->status === 'confirmed')
                            <div class="mt-6">
                                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                                    <i class="fas fa-download mr-2"></i> Download Ticket
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-lg font-semibold text-gray-900">No tickets yet</h3>
                <p class="mt-1 text-sm text-gray-500">You haven't purchased any event tickets yet.</p>
                <div class="mt-6">
                    <a href="{{ route('user.events') }}" class="btn-primary">Browse Events</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection