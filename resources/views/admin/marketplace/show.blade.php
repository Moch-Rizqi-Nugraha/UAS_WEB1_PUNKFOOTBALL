@extends('admin.layout')

@section('title', 'Marketplace Transaction Detail')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Transaction Detail</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <span class="font-semibold">ID:</span> {{ $transaction->id }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">User:</span> {{ $transaction->user->name ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Item:</span> {{ $transaction->item_name ?? '-' }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Amount:</span> Rp {{ number_format($transaction->amount, 0, ',', '.') }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Status:</span>
            <span class="px-2 py-1 rounded text-xs font-semibold {{
                $transaction->status === 'completed' ? 'bg-green-100 text-green-800' :
                ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                ($transaction->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
            }}">
                {{ ucfirst($transaction->status) }}
            </span>
        </div>
        <form method="POST" action="{{ route('admin.marketplace.update', $transaction->id) }}" class="mt-6">
            @csrf
            @method('PUT')
            <label for="status" class="block font-semibold mb-2">Update Status</label>
            <select name="status" id="status" class="border rounded px-3 py-2 w-full mb-4">
                <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
    <div class="mt-6">
        <a href="{{ route('admin.marketplace.index') }}" class="text-gray-600 hover:underline">&larr; Back to Marketplace</a>
    </div>
</div>
@endsection
