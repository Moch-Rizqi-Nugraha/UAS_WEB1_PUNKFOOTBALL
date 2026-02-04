<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->name }} - Punk Football</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('admin.partials.navbar')


    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2A1 1 0 0 0 1 10h2v8a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-4a1 1 0 0 0 1-1v-2a1 1 0 0 0 1-1h6a1 1 0 0 0 1 1v2a1 1 0 0 0 1 1v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-8h2a1 1 0 0 0 .707-1.707Z"/>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                                </svg>
                                <a href="{{ route('admin.events.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Events</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $event->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Event Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Event Info -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $event->name }}</h1>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-2
                                    @if($event->category === 'turnamen') bg-blue-100 text-blue-800
                                    @elseif($event->category === 'pelatihan') bg-green-100 text-green-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $event->getCategoryLabel() }}
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn-secondary text-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.events.toggle-status', $event) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-primary text-sm">
                                        {{ $event->status === 'active' ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($event->poster)
                        <div class="mb-4">
                            <img src="{{ $event->getPosterUrl() }}" alt="{{ $event->name }}" class="w-full h-64 object-cover rounded-lg">
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Date & Time</h3>
                                <p class="text-lg text-gray-900">{{ $event->event_date->format('l, d F Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $event->event_date->format('H:i') }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Location</h3>
                                <p class="text-lg text-gray-900">{{ $event->location }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Participants</h3>
                                <p class="text-lg text-gray-900">{{ $event->current_participants }} / {{ $event->max_participants }}</p>
                                @if($event->current_participants >= $event->max_participants)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 mt-1">Full</span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mt-1">{{ $event->getAvailableSpots() }} spots left</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Price</h3>
                                <p class="text-lg text-gray-900">{{ $event->price > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Free' }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                            <p class="text-gray-900">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div>
                    <div class="card mb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Status</span>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Total Registered</span>
                                <span class="text-sm font-medium">{{ $event->participants()->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Confirmed</span>
                                <span class="text-sm font-medium">{{ $event->confirmedParticipants()->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Pending</span>
                                <span class="text-sm font-medium">{{ $event->participants()->where('status', 'registered')->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Cancelled</span>
                                <span class="text-sm font-medium">{{ $event->participants()->where('status', 'cancelled')->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Available Spots</span>
                                <span class="text-sm font-medium">{{ $event->getAvailableSpots() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn-primary w-full text-center block">Edit Event</a>
                            <a href="{{ route('admin.events.index') }}" class="btn-secondary w-full text-center block">Back to Events</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participants List -->
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Event Participants ({{ $participants->total() }})</h2>
                            <p class="mt-1 text-sm text-gray-600">Manage participant registrations and confirmations.</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.events.index') }}" class="btn-secondary text-sm">Back to Events</a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($participants as $participant)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ strtoupper(substr($participant->user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $participant->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $participant->user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $participant->registered_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($participant->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($participant->status === 'registered') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($participant->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($participant->status !== 'confirmed')
                                        <form method="POST" action="{{ route('admin.events.participants.update-status', [$event, $participant]) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                                                Confirm
                                            </button>
                                        </form>
                                        @endif
                                        @if($participant->status !== 'cancelled')
                                        <form method="POST" action="{{ route('admin.events.participants.update-status', [$event, $participant]) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                                Cancel
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No participants registered yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($participants->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $participants->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>