@extends('admin.layout')

@section('title', 'Create Marketplace Transaction')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Create Marketplace Transaction</h1>
    <form method="POST" action="{{ route('admin.marketplace.store') }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="user_id" class="block font-semibold mb-2">User</label>
            <select name="user_id" id="user_id" class="border rounded px-3 py-2 w-full">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="item_name" class="block font-semibold mb-2">Item Name</label>
            <input type="text" name="item_name" id="item_name" class="border rounded px-3 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="product_name" class="block font-semibold mb-2">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="border rounded px-3 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block font-semibold mb-2">Description</label>
            <textarea name="description" id="description" class="border rounded px-3 py-2 w-full" required></textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block font-semibold mb-2">Price</label>
            <input type="number" name="price" id="price" class="border rounded px-3 py-2 w-full" required min="0">
        </div>
        <div class="mb-4">
            <label for="stock" class="block font-semibold mb-2">Stock</label>
            <input type="number" name="stock" id="stock" class="border rounded px-3 py-2 w-full" required min="0">
        </div>
        <div class="mb-4">
            <label for="image" class="block font-semibold mb-2">Image</label>
            <input type="file" name="image" id="image" class="border rounded px-3 py-2 w-full">
        </div>
        <div class="mb-4">
            <label for="amount" class="block font-semibold mb-2">Amount</label>
            <input type="number" name="amount" id="amount" class="border rounded px-3 py-2 w-full" required min="0">
        </div>
        <div class="mb-4">
            <label for="status" class="block font-semibold mb-2">Status</label>
            <select name="status" id="status" class="border rounded px-3 py-2 w-full">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="shipped">Shipped</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
    </form>
    <div class="mt-6">
        <a href="{{ route('admin.marketplace.index') }}" class="text-gray-600 hover:underline">&larr; Back to Marketplace</a>
    </div>
</div>
@endsection
