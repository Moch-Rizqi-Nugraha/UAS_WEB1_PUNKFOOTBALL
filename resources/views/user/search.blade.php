<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results - Punk Football</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('user.partials.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Search Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Search Results</h1>
                <p class="mt-1 text-sm text-gray-600">Search results for: <span class="font-medium text-gray-900">"{{ $query }}"</span></p>
            </div>

            <!-- Search Results -->
            <div class="space-y-8">
                <!-- Events Section -->
                @if($events->count() > 0)
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Events ({{ $events->count() }})</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($events as $event)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <img class="h-16 w-16 rounded-lg object-cover" src="{{ $event->getPosterUrl() }}" alt="{{ $event->name }}">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $event->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $event->location }} • {{ $event->getCategoryLabel() }}</p>
                                        <p class="text-sm text-gray-500">{{ $event->event_date->format('M d, Y H:i') }}</p>
                                        <div class="mt-2 flex items-center space-x-4">
                                            <span class="text-sm text-gray-600">
                                                <span class="font-medium">{{ $event->current_participants }}</span> / {{ $event->max_participants }} participants
                                            </span>
                                            @if($event->price > 0)
                                                <span class="text-sm font-medium text-green-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-sm font-medium text-green-600">Free</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end space-y-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $event->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $event->status }}
                                    </span>
                                    @if($event->hasAvailableSpots())
                                        <button class="btn-primary text-sm">Join Event</button>
                                    @else
                                        <span class="text-sm text-red-600 font-medium">Full</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- No Results -->
                @if($events->count() === 0)
                <div class="card">
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM33 33l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms or check for typos.</p>
                        <div class="mt-6">
                            <a href="{{ route('user.dashboard') }}" class="btn-primary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>