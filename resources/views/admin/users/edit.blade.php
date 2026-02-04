@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Edit User</h1>
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="role" class="block font-semibold mb-2">Role</label>
            <select name="role" id="role" class="border rounded px-3 py-2 w-full">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="is_active" class="block font-semibold mb-2">Status</label>
            <select name="is_active" id="is_active" class="border rounded px-3 py-2 w-full">
                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('admin.users.show', $user->id) }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
