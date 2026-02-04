<!-- Sidebar -->
<aside x-data="{ sidebarOpen: true }" class="bg-gray-900 text-white h-screen sticky top-0 transition-all duration-300 flex flex-col" :class="sidebarOpen ? 'w-64' : 'w-20'">
    <!-- Logo Section -->
    <div class="flex items-center justify-between h-20 px-4 border-b border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 hover:text-gray-300 transition" :class="!sidebarOpen && 'justify-center w-full'">
            <span class="text-2xl">⚽</span>
            <span x-show="sidebarOpen" class="font-bold whitespace-nowrap">Punk Admin</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4V8m0 0L8 4"></path>
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
        </a>

        <!-- Events -->
        <div x-data="{ eventOpen: {{ request()->routeIs('admin.events*') ? 'true' : 'false' }} }">
            <button @click="eventOpen = !eventOpen" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.events*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium flex-1 text-left">Events</span>
                <svg x-show="sidebarOpen" class="w-4 h-4" :class="eventOpen && 'transform rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </button>
            <div x-show="eventOpen && sidebarOpen" class="mt-2 ml-4 space-y-2">
                <a href="{{ route('admin.events.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition duration-200">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span>All Events</span>
                </a>
                <a href="{{ route('admin.events.create') }}" class="flex items-center space-x-3 px-4 py-2 text-sm rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition duration-200">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span>Create Event</span>
                </a>
            </div>
        </div>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.products*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Products</span>
        </a>

        <!-- Gallery -->
        <a href="{{ route('admin.galleries.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.galleries*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Gallery</span>
        </a>

        <!-- Content -->
        <div x-data="{ contentOpen: {{ request()->routeIs('admin.articles*', 'admin.categories*') ? 'true' : 'false' }} }">
            <button @click="contentOpen = !contentOpen" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.articles*', 'admin.categories*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium flex-1 text-left">Content</span>
                <svg x-show="sidebarOpen" class="w-4 h-4" :class="contentOpen && 'transform rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </button>
            <div x-show="contentOpen && sidebarOpen" class="mt-2 ml-4 space-y-2">
                <a href="{{ route('admin.articles.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition duration-200">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span>Articles</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-2 text-sm rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition duration-200">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span>Categories</span>
                </a>
            </div>
        </div>

        <!-- Users -->
        <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.users*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Users</span>
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.reports*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Reports</span>
        </a>

        <!-- Settings -->
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition duration-200 text-gray-400 hover:text-white hover:bg-gray-800">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Settings</span>
        </a>
    </nav>

    <!-- Toggle Button -->
    <div class="border-t border-gray-700 p-4">
        <button @click="sidebarOpen = !sidebarOpen" class="w-full flex items-center justify-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition duration-200">
            <svg class="w-5 h-5" :class="!sidebarOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span x-show="sidebarOpen">Collapse</span>
        </button>
    </div>
</aside>
