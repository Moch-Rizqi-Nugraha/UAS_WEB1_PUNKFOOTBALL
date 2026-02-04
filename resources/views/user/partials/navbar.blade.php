<!-- Navigation -->
<nav class="bg-gray-900 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('user.dashboard') }}" class="text-white text-xl font-bold hover:text-gray-200 transition duration-300">
                        ⚽ Punk Football
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a>
                        <a href="{{ route('user.events') }}" class="nav-link {{ request()->routeIs('user.events') ? 'bg-gray-800' : '' }}">Events</a>
                        <a href="{{ route('user.tickets') }}" class="nav-link {{ request()->routeIs('user.tickets') ? 'bg-gray-800' : '' }}">Tickets</a>
                        <a href="{{ route('user.marketplace') }}" class="nav-link {{ request()->routeIs('user.marketplace') ? 'bg-gray-800' : '' }}">Marketplace</a>
                        <a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'bg-gray-800' : '' }}">Profile</a>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:block flex-1 max-w-xs mx-4">
                <form action="{{ route('user.search') }}" method="GET" class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search events..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-600 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    @if(request('q'))
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <a href="{{ url()->current() }}" class="text-gray-400 hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative hidden md:block">
                    <button class="text-white hover:text-gray-200 p-2 rounded-md hover:bg-gray-800 transition duration-300 relative">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h4l4 4v-4h4a2 2 0 002-2z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-yellow-400 rounded-full flex items-center justify-center">
                            <span class="text-xs text-black font-bold">2</span>
                        </span>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-gray-200 p-2 rounded-md hover:bg-gray-800 transition duration-300">
                        <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <span class="hidden md:block">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                        <div class="py-1">
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Account Settings</a>
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
                <a href="{{ route('user.dashboard') }}" class="nav-link block {{ request()->routeIs('user.dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a>
                <a href="{{ route('user.events') }}" class="nav-link block {{ request()->routeIs('user.events') ? 'bg-gray-800' : '' }}">Events</a>
                <a href="{{ route('user.tickets') }}" class="nav-link block {{ request()->routeIs('user.tickets') ? 'bg-gray-800' : '' }}">Tickets</a>
                <a href="{{ route('user.marketplace') }}" class="nav-link block {{ request()->routeIs('user.marketplace') ? 'bg-gray-800' : '' }}">Marketplace</a>
                <a href="{{ route('user.profile') }}" class="nav-link block {{ request()->routeIs('user.profile') ? 'bg-gray-800' : '' }}">Profile</a>
            </div>
        </div>
    </div>
</nav>