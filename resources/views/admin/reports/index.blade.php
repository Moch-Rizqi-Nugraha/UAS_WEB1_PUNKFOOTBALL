@extends('admin.layout')

@section('title', 'Reports & Exports')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Reports & Exports</h1>
        <p class="text-gray-600">Generate and export reports in Excel or PDF format</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Users Report -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Users Report</h3>
            <p class="text-gray-600 mb-4">Export complete list of users with their details</p>
            <div class="flex space-x-2">
                <a href="{{ route('admin.reports.users.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Export Excel
                </a>
                <a href="{{ route('admin.reports.users.pdf') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Events Report -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Events Report</h3>
            <p class="text-gray-600 mb-4">Export all events with details and status</p>
            <div class="flex space-x-2">
                <a href="{{ route('admin.reports.events.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Export Excel
                </a>
                <a href="{{ route('admin.reports.events.pdf') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Transactions Report -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Transactions Report</h3>
            <p class="text-gray-600 mb-4">Export transaction history and revenue data</p>
            <div class="flex space-x-2">
                <a href="{{ route('admin.reports.transactions.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Export Excel
                </a>
                <a href="{{ route('admin.reports.transactions.pdf') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                    Export PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="text-lg font-medium text-blue-900 mb-2">Report Features</h4>
        <ul class="text-blue-800 text-sm space-y-1">
            <li>• Excel exports include all data with proper formatting</li>
            <li>• PDF exports provide printable reports</li>
            <li>• All exports include timestamps for data integrity</li>
            <li>• Files are automatically downloaded to your device</li>
        </ul>
    </div>
</div>
@endsection