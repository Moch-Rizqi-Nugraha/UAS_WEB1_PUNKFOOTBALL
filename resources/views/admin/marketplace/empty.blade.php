@extends('admin.layout')

@section('title', 'Marketplace Management')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 text-center">
    <h1 class="text-xl font-bold mb-4">No Marketplace Transactions</h1>
    <p class="text-gray-600 mb-6">There are currently no marketplace transactions to display.</p>
    <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Dashboard</a>
</div>
@endsection
