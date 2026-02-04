@extends('admin.layout')

@section('title', 'Marketplace Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Marketplace Transactions</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.marketplace.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Produk</a>
            <a href="{{ route('admin.marketplace.create') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Create Transaction</a>
        </div>
    </div>
    <table class="min-w-full bg-white shadow rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Item</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $transaction->id }}</td>
                <td class="px-4 py-2">{{ $transaction->user->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $transaction->item_name ?? '-' }}</td>
                <td class="px-4 py-2">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded text-xs font-semibold {{
                        $transaction->status === 'completed' ? 'bg-green-100 text-green-800' :
                        ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                        ($transaction->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                    }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.marketplace.show', $transaction->id) }}" class="text-blue-600 hover:underline">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">{{ $transactions->links() }}</div>
</div>
@endsection
