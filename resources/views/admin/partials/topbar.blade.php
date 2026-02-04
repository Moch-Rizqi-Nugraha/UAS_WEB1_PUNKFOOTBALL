<!-- Top Bar -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="px-6 py-4 flex justify-between items-center">
        <!-- Search Bar -->
        <div class="flex-1 max-w-lg">
            <form action="{{ route('admin.search') }}" method="GET" class="flex">
                <div class="relative w-full">
                    <input type="text" name="q" placeholder="Search..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-gray-900 bg-gray-50">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Actions -->
        <div class="flex items-center space-x-6 ml-6">
            <!-- Notifications -->
            <div class="relative" x-data="{ notifOpen: false }">
                <button @click="notifOpen = !notifOpen" class="text-gray-600 hover:text-gray-900 relative transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-0 right-0 h-3 w-3 bg-red-500 rounded-full"></span>
                </button>
                <div x-show="notifOpen" @click.away="notifOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900">Notifications</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer">
                            <p class="text-sm font-medium text-gray-900">New product added</p>
                            <p class="text-xs text-gray-600 mt-1">5 minutes ago</p>
                        </div>
                        <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer">
                            <p class="text-sm font-medium text-gray-900">Event registration</p>
                            <p class="text-xs text-gray-600 mt-1">20 minutes ago</p>
                        </div>
                        <div class="p-4 hover:bg-gray-50 cursor-pointer">
                            <p class="text-sm font-medium text-gray-900">System update</p>
                            <p class="text-xs text-gray-600 mt-1">1 hour ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative" x-data="{ userOpen: false }">
                <button @click="userOpen = !userOpen" class="flex items-center space-x-3 hover:bg-gray-100 px-3 py-2 rounded-lg transition duration-200">
                    <div class="w-9 h-9 bg-gray-900 text-white rounded-lg flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-600">Administrator</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-600" :class="userOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
                <div x-show="userOpen" @click.away="userOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">Profile Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">Admin Settings</a>
                        <div class="border-t border-gray-200"></div>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
