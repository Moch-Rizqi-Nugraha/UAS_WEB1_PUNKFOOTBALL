@extends('layouts.admin')

@section('title', 'System Health')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">System Health Check</h1>
        <p class="mt-2 text-gray-600">Monitor the health status of your application components</p>
    </div>

    <!-- Health Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Database Health -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Database</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $health['database']['status'] === 'healthy' ? 'bg-green-100 text-green-800' :
                       ($health['database']['status'] === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                    </svg>
                    {{ ucfirst($health['database']['status']) }}
                </span>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600">{{ $health['database']['message'] }}</p>
                <div class="text-xs text-gray-500">
                    Connection: {{ $health['database']['connection'] ?? 'Unknown' }}
                </div>
            </div>
        </div>

        <!-- Cache Health -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Cache System</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $health['cache']['status'] === 'healthy' ? 'bg-green-100 text-green-800' :
                       ($health['cache']['status'] === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                    </svg>
                    {{ ucfirst($health['cache']['status']) }}
                </span>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600">{{ $health['cache']['message'] }}</p>
                <div class="text-xs text-gray-500">
                    Driver: {{ $health['cache']['driver'] ?? 'Unknown' }}
                </div>
            </div>
        </div>

        <!-- Storage Health -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">File Storage</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $health['storage']['status'] === 'healthy' ? 'bg-green-100 text-green-800' :
                       ($health['storage']['status'] === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                    </svg>
                    {{ ucfirst($health['storage']['status']) }}
                </span>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600">{{ $health['storage']['message'] }}</p>
                <div class="text-xs text-gray-500">
                    Disk: {{ $health['storage']['disk'] ?? 'Unknown' }}
                </div>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="card mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <div class="text-sm text-gray-600">PHP Version</div>
                <div class="font-medium">{{ PHP_VERSION }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-600">Laravel Version</div>
                <div class="font-medium">{{ app()->version() }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-600">Server</div>
                <div class="font-medium">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-600">Environment</div>
                <div class="font-medium">{{ app()->environment() }}</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="flex gap-4">
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Dashboard
        </a>
        <form method="POST" action="{{ route('admin.system.clear-cache') }}" class="inline">
            @csrf
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Clear Cache
            </button>
        </form>
    </div>
</div>
@endsection