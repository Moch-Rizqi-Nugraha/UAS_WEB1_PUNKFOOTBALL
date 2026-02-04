<!-- Navigation -->
<nav class="bg-red-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-xl font-bold hover:text-gray-200 transition duration-300">
                        ⚽ Punk Football Admin
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'bg-red-700' : '' }}">Dashboard</a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="nav-link flex items-center {{ request()->routeIs('admin.events*') ? 'bg-red-700' : '' }}">
                                Events
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                <div class="py-1">
                                    <a href="{{ route('admin.events.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Events</a>
                                    <a href="{{ route('admin.events.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Event</a>
                                </div>
                            </div>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="nav-link flex items-center {{ request()->routeIs('admin.articles*', 'admin.categories*') ? 'bg-red-700' : '' }}">
                                Content
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                <div class="py-1">
                                    <a href="{{ route('admin.articles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Articles</a>
                                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Categories</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'bg-red-700' : '' }}">Users</a>
                        <a href="#" class="nav-link">Roles & Permissions</a>
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'bg-red-700' : '' }}">Reports</a>
                        <a href="#" class="nav-link">Settings</a>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative hidden md:block">
                    <button class="text-white hover:text-gray-200 p-2 rounded-md hover:bg-red-700 transition duration-300 relative">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h4l4 4v-4h4a2 2 0 002-2z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-yellow-400 rounded-full flex items-center justify-center">
                            <span class="text-xs text-black font-bold">3</span>
                        </span>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-gray-200 p-2 rounded-md hover:bg-red-700 transition duration-300">
                        <div class="w-8 h-8 bg-red-700 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <span class="hidden md:block">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Settings</a>
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
                    <button class="mobile-menu-button text-white hover:text-gray-200 p-2 rounded-md hover:bg-red-700 transition duration-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden border-t border-red-500">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link block {{ request()->routeIs('admin.dashboard') ? 'bg-red-700' : '' }}">Dashboard</a>
                <div class="border-t border-red-500 pt-2 mt-2">
                    <div class="text-white text-sm font-medium mb-2">Events</div>
                    <a href="{{ route('admin.events.index') }}" class="nav-link block ml-4 {{ request()->routeIs('admin.events.index') ? 'bg-red-700' : '' }}">All Events</a>
                    <a href="{{ route('admin.events.create') }}" class="nav-link block ml-4 {{ request()->routeIs('admin.events.create') ? 'bg-red-700' : '' }}">Create Event</a>
                </div>
                <div class="border-t border-red-500 pt-2 mt-2">
                    <div class="text-white text-sm font-medium mb-2">Content</div>
                    <a href="{{ route('admin.articles.index') }}" class="nav-link block ml-4 {{ request()->routeIs('admin.articles*') ? 'bg-red-700' : '' }}">Articles</a>
                    <a href="{{ route('admin.categories.index') }}" class="nav-link block ml-4 {{ request()->routeIs('admin.categories*') ? 'bg-red-700' : '' }}">Categories</a>
                </div>
                <a href="{{ route('admin.users') }}" class="nav-link block {{ request()->routeIs('admin.users*') ? 'bg-red-700' : '' }}">Users</a>
                <a href="#" class="nav-link block">Roles & Permissions</a>
                <a href="{{ route('admin.reports.index') }}" class="nav-link block {{ request()->routeIs('admin.reports*') ? 'bg-red-700' : '' }}">Reports</a>
                <a href="#" class="nav-link block">Settings</a>
            </div>
        </div>
    </div>
</nav>