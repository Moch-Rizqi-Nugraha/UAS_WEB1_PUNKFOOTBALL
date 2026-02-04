<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Punk Football</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('user.partials.navbar')
                            </svg>
                            <span class="absolute -top-1 -right-1 h-4 w-4 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-xs text-white font-bold">2</span>
                            </span>
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-gray-200 p-2 rounded-md hover:bg-gray-800 transition duration-300">
                            <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <span class="hidden md:block">{{ $user->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                            <div class="py-1">
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                                <a href="{{ route('user.events') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Events</a>
                                <a href="{{ route('user.marketplace') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button class="mobile-menu-button text-white hover:text-gray-200 p-2 rounded-md hover:bg-gray-800 transition duration-300">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="mobile-menu hidden md:hidden border-t border-gray-700">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('user.dashboard') }}" class="nav-link block">Dashboard</a>
                    <a href="{{ route('user.events') }}" class="nav-link block">Events</a>
                    <a href="{{ route('user.tickets') }}" class="nav-link block">Tickets</a>
                    <a href="{{ route('user.marketplace') }}" class="nav-link block">Marketplace</a>
                    <a href="{{ route('user.profile') }}" class="nav-link block">Profile</a>
                    <div class="border-t border-gray-700 pt-2 mt-2">
                        <div class="px-3 py-2 text-white text-sm">
                            Welcome, {{ $user->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">My Dashboard</h1>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card football-element">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Events Joined</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['events_joined'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card football-element">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Tickets Purchased</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['tickets_purchased'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('user.events') }}" class="card football-element text-center hover:shadow-lg transition-shadow">
                    <svg class="w-12 h-12 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">My Events</h3>
                    <p class="text-gray-600">View and manage your event registrations</p>
                </a>

                <a href="{{ route('user.tickets') }}" class="card football-element text-center hover:shadow-lg transition-shadow">
                    <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v-3a2 2 0 00-2-2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">My Tickets</h3>
                    <p class="text-gray-600">Manage your event tickets</p>
                </a>

                <a href="{{ route('user.marketplace') }}" class="card football-element text-center hover:shadow-lg transition-shadow">
                    <svg class="w-12 h-12 text-purple-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">My Purchases</h3>
                    <p class="text-gray-600">Track your marketplace orders</p>
                </a>

                <a href="{{ route('user.profile') }}" class="card football-element text-center hover:shadow-lg transition-shadow">
                    <svg class="w-12 h-12 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">My Profile</h3>
                    <p class="text-gray-600">Update your account information</p>
                </a>
            </div>

            <!-- Gallery Widget -->
            <div class="mt-12">
                @php
                    $galleries = \App\Models\Gallery::active()
                        ->orderBy('order')
                        ->orderBy('created_at', 'desc')
                        ->limit(8)
                        ->get();
                @endphp

                <div class="card football-element">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 transition-all duration-500 hover:text-blue-600 inline-block">Galeri Acara</h2>
                    
                    @if($galleries->count())
                        <style>
                            @keyframes zoomIn {
                                from {
                                    opacity: 0;
                                    transform: scale(0.9);
                                }
                                to {
                                    opacity: 1;
                                    transform: scale(1);
                                }
                            }
                            
                            .dashboard-gallery-item {
                                animation: zoomIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                                opacity: 0;
                            }
                            
                            .dashboard-gallery-item:nth-child(1) { animation-delay: 0.1s; }
                            .dashboard-gallery-item:nth-child(2) { animation-delay: 0.2s; }
                            .dashboard-gallery-item:nth-child(3) { animation-delay: 0.3s; }
                            .dashboard-gallery-item:nth-child(4) { animation-delay: 0.4s; }
                            .dashboard-gallery-item:nth-child(5) { animation-delay: 0.5s; }
                            .dashboard-gallery-item:nth-child(6) { animation-delay: 0.6s; }
                            .dashboard-gallery-item:nth-child(7) { animation-delay: 0.7s; }
                            .dashboard-gallery-item:nth-child(8) { animation-delay: 0.8s; }
                        </style>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                            @foreach($galleries as $gallery)
                                <a href="{{ route('galleries.show', $gallery) }}" 
                                   class="dashboard-gallery-item group relative overflow-hidden rounded-lg bg-gray-200 aspect-square hover:shadow-2xl transition-all duration-500 transform hover:scale-105 hover:-translate-y-2">
                                    
                                    <img src="{{ asset('storage/' . $gallery->image) }}" 
                                         alt="{{ $gallery->image_alt ?? $gallery->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-700 ease-out">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent group-hover:via-black/40 transition-all duration-500"></div>
                                    
                                    <div class="absolute bottom-0 left-0 right-0 p-3 transform group-hover:translate-y-0 transition-transform duration-300">
                                        <h3 class="text-white font-semibold text-sm truncate group-hover:text-base transition-all duration-300">{{ $gallery->title }}</h3>
                                        @if($gallery->category)
                                            <p class="text-gray-200 text-xs opacity-90 group-hover:opacity-100 transition-opacity duration-300">{{ $gallery->category }}</p>
                                        @endif
                                    </div>

                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform group-hover:scale-110">
                                        <div class="bg-blue-600 rounded-full p-3 shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="text-center">
                            <a href="{{ route('galleries.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Lihat Semua Galeri
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada galeri</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>