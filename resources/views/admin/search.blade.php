<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results - Punk Football Admin</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('admin.partials.navbar')

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
                                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ $event->getPosterUrl() }}" alt="{{ $event->name }}">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('admin.events.show', $event) }}" class="hover:text-blue-600">{{ $event->name }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $event->location }} • {{ $event->getCategoryLabel() }}</p>
                                        <p class="text-sm text-gray-500">{{ $event->event_date->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $event->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $event->status }}
                                    </span>
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn-secondary text-sm">View</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Users Section -->
                @if($users->count() > 0)
                <div class="card">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Users ({{ $users->count() }})</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($users as $user)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-lg font-medium text-gray-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('admin.users.show', $user) }}" class="hover:text-blue-600">{{ $user->name }}</a>
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        <p class="text-sm text-gray-500">Joined {{ $user->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn-secondary text-sm">View</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- No Results -->
                @if($events->count() === 0 && $users->count() === 0)
                <div class="card">
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM33 33l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search terms or check for typos.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>